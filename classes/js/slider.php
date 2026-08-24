/**
 * ydCarousel 2.6.2 - V2.6.2 RUNTIME LIFECYCLE RELEASE (FINAL HARDENED REVISION)
 * Includes: Automatic Visibility Management (Smart Freezing), freeze(), unfreeze(), 
 * pause(), resume(), Complete Runtime Interaction & Observer Freezing, SSR Guards,
 * Deep Cleanup, Diagnostic Consistency, and Manual/Auto Freeze Isolation.
 * 
 * DEVELOPER RULES:
 * 1. CSS REQUIREMENT: The scrollbar plugin requires external CSS for disabled states:
 *    .yd_scrollbar.disabled { pointer-events: none; opacity: 0.5; }
 * 2. CSS REQUIREMENT: If using auto-height, you must add a transition to the viewport:
 *    .yd_viewport { transition: height 0.3s ease; }
 * 3. CSS REQUIREMENT: To prevent browser squashing during loop cloning, slides need:
 *    .yd_slide { flex-shrink: 0; }
 * 4. EVENT MUTATION: Never directly modify `api.currentIndex` or `api.currentGroup`.
 *    Always use `api.goToGroup()`, `api.goToSlide()`, or `api.snapToClosest()`.
 * 5. BATCH API: The callback passed to `api.batch(() => {...})` MUST be synchronous.
 * 6. RTL SEMANTICS: RTL modifies visual layout and translation direction. Logical 
 *    slide index (0 to n) remains strictly LTR. Autoplay "forward" means next logical slide.
 * 7. VIRTUALIZATION: Logical = data model, Rendered = DOM model. `virtual.logicalSlides` 
 *    is the real dataset. `slides` is the rendered dataset.
 */

class ydCarousel {
  static VERSION = '2.6.2'; 
  static ENGINE = 'ydCarousel-Enterprise';
  static DEBUG = true; // Enabled for Milestone 10 diagnostics
  static SNAP_EPSILON = 0.5; 
  static _autoInitObserver = null;
  static _pluginRegistry = new Map();
  static activeCarousel = null; 
  static _keyboardInitialized = false; 
  static _keyboardUsers = 0; 
  static _instances = new Set(); 

  static EVENTS = Object.freeze([
    'init', 'resize', 'destroy',
    'pause', 'resume', 'freeze', 'unfreeze',
    'dragStart', 'dragMove', 'dragEnd',
    'scroll', 'settle',
    'beforeSelect', 'select', 'afterSelect',
    'activeSlideChange', 'activeGroupChange',
    'previewUpdate', 
    'slideEnter', 'slideExit',
    'loopEnter', 'loopExit', 'loopReposition',
    'autoplayStart', 'autoplayPause', 'autoplayResume', 'autoplayStop',
    'syncStart', 'syncUpdate', 'syncStop',
    'debugOpen', 'debugClose',
    'pluginEnabled', 'pluginDisabled'
  ]);

  static _now() {
    return typeof performance !== 'undefined' ? performance.now() : Date.now();
  }

  static hasDOM() {
    return typeof window !== 'undefined' && typeof document !== 'undefined';
  }

  static registerPlugin(pluginDef) {
    if (!pluginDef.name) throw new Error('[ydCarousel] Plugin must have a name');
    this._pluginRegistry.set(pluginDef.name, pluginDef);
  }

  static _globalKeyDownHandler(e) {
    if (ydCarousel.activeCarousel && ydCarousel.activeCarousel.options.keyboard) {
      ydCarousel.activeCarousel.onKeyDown(e);
    }
  }

  static startAutoInit() {
    if (!ydCarousel.hasDOM()) return;
    if (typeof MutationObserver === 'undefined') return;

    const initAll = () => {
      document.querySelectorAll('.yd_carousel:not(.yd_carousel-ready)').forEach(el => {
        if (!el.__ydCarousel) {
          try {
            new ydCarousel(el);
          } catch (err) {
            console.error('[ydCarousel] Auto-init failed:', err);
          }
        }
      });
    };
    initAll();
    if (!this._autoInitObserver) {
      let timeout;
      this._autoInitObserver = new MutationObserver(() => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
          ydCarousel._instances.forEach(api => {
            if (!document.contains(api.root)) api.destroy();
          });
          initAll();
        }, 100); 
      });
      this._autoInitObserver.observe(document.body, { childList: true, subtree: true }); 
    }
  }

  static stopAutoInit() {
    if (this._autoInitObserver) {
      this._autoInitObserver.disconnect();
      this._autoInitObserver = null;
    }
  }

  constructor(element) {
    this.root = element;
    
    this.track = this.root ? this.root.querySelector('.yd_container') : null;
    if (!this.track) {
      throw new Error('[ydCarousel] Missing .yd_container element');
    }
    
    this.root.__ydCarousel = this;

    const reducedSetting = this.root.dataset.reducedMotion || 'auto';
    let respectReducedMotion = false;
    
    if (reducedSetting === 'true') {
      respectReducedMotion = true;
    } else if (reducedSetting === 'false') {
      respectReducedMotion = false;
    } else if (ydCarousel.hasDOM() && window.matchMedia) {
      respectReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }
    
    this.reducedMotion = respectReducedMotion;
    
    this.options = {
      loop: this.root.classList.contains('loop'),
      dragFree: this.root.classList.contains('drag-free'),
      alignCenter: this.root.classList.contains('align-center'),
      alignEnd: this.root.classList.contains('align-end'),
      keyboard: this.root.classList.contains('keyboard'),
      autoplay: !this.reducedMotion && this.root.classList.contains('autoplay'),
      direction: this.root.classList.contains('rtl') ? 'rtl' : 'ltr',
      vertical: this.root.classList.contains('vertical'),
      autoHeight: this.root.classList.contains('auto-height'),
      autoVisibility: this.root.dataset.autoVisibility !== 'false', 
      focusOnChange: this.root.classList.contains('focus-on-change') || this.root.dataset.focusOnChange === 'true',
      duration: this.reducedMotion ? 1 : (parseFloat(this.root.dataset.duration) || 0.1),
      friction: this.reducedMotion ? 1 : (parseFloat(this.root.dataset.friction) || 0.92),
      delay: parseInt(this.root.dataset.delay) || 4000,
      dragThreshold: parseInt(this.root.dataset.dragThreshold) || 5,
      velocityThreshold: parseFloat(this.root.dataset.velocityThreshold) || 0.5,
      dragInertia: this.reducedMotion ? 0 : (parseFloat(this.root.dataset.dragInertia) || 40),
      slideSnap: this.root.classList.contains('slide-snap'),
      groupSnap: this.root.classList.contains('group-snap')
    };

    this.isRTL = this.options.direction === 'rtl';
    this.dir = this.isRTL ? -1 : 1;

    if (this.options.groupSnap) {
      this.options.slideSnap = false;
    }
    if (!this.options.slideSnap && !this.options.groupSnap) {
      this.options.slideSnap = true;
    }

    this.currentPos = 0;
    this.targetPos = 0;
    
    this.currentIndex = 0;
    this.prevIndex = 0; 
    this.currentGroup = 0;
    this.prevGroup = 0;

    this.previewIndex = 0;
    this.previewGroup = 0;

    this._velocity = 0; 
    this.inertia = 0;
    this._isPaused = false;
    this._isFrozen = false;
    this._isAutoFrozen = false;
    this._manualFrozen = false;
    this._lastIntersectionState = true;
    
    this.isDraggingActive = false;
    this.activePointerId = undefined;
    this.isSettled = true;
    this.destroyed = false;        
    this.rafId = null;
    this.mutationRaf = null;
    this.maxScroll = 0;

    this.dragStartPos = 0;
    this.dragStartCurrentPos = 0;
    this.lastPointerPos = 0;
    this.lastPointerTime = 0;
    this.isClickSuppressed = false;
    this._keyboardRegistered = false; 

    this.dragState = {
      active: false,
      startLogicalIndex: 0,
      currentLogicalIndex: 0,
      startPointer: 0,
      startTargetPos: 0
    };
    
    this.ignoreNextMutation = false; 
    this.batchDepth = 0;
    this._trackedActiveNode = null;
    this._isDynamicRefreshing = false;

    this.slides = []; 
    this.visibleSlides = new Set(); 

    this._stats = {
      renderTicks: 0,
      layoutCalcs: 0,
      lastLayoutTime: 0,
      initTime: ydCarousel._now()
    };
    this._eventStats = {};
    this._pluginErrorTracker = new Map();

    this.metrics = {
      viewportSize: 0,
      trackSize: 0,
      realTrackSize: 0, 
      prependOffset: 0,  
      gap: 0,
      averageSlideSize: 0,
      slideSizes: [],
      slideOffsets: [], 
      slideSnaps: [], 
      groupSnaps: [], // legacy
      snapPoints: []  
    };

    this.virtual = {
      enabled: this.root.dataset.virtual === 'true',
      logicalSlides: [],
      renderedSlides: [],
      windowSlides: [],
      lastWindow: [],
      logicalGroups: [],
      groupSnaps: [],
      windowStart: 0,
      windowEnd: 0,
      slidesPerView: 0,
      buffer: 0,
      windowSize: 0,
      renderIndex: 0,
      pendingRebalance: null,
      lastRebalanceIndex: -1
    };

    this.listeners = {};
    this.plugins = []; 
    this.activePlugins = new Map(); 

    this.onPointerDown = this.onPointerDown.bind(this);
    this.onPointerMove = this.onPointerMove.bind(this);
    this.onPointerUp = this.onPointerUp.bind(this);
    this.onClick = this.onClick.bind(this);
    this.onKeyDown = this.onKeyDown.bind(this);
    this.onResize = this.onResize.bind(this);
    this.onMutation = this.onMutation.bind(this);
    this.tick = this.tick.bind(this);
    this._docVisHandler = this._onDocVisibilityChange.bind(this);
    this.onActivate = () => { ydCarousel.activeCarousel = this; }; 
    
    this.onDeactivate = (e) => {
      if (e && e.type === 'focusout' && this.root.contains(e.relatedTarget)) return;
      if (ydCarousel.activeCarousel === this) {
        const fallback = [...ydCarousel._instances].find(api => api !== this && !api.destroyed && api.options.keyboard);
        ydCarousel.activeCarousel = fallback || null; 
      }
    };

    this.init();
  }

  get rtl() {
    return this.isRTL;
  }

  getTransformValue() {
    if (this.options.vertical) {
      return -this.currentPos;
    }
    return -this.currentPos * this.dir;
  }

  init() {
    if (this.destroyed) this.destroyed = false;
    this._isPaused = false;
    this._isFrozen = false;
    this._isAutoFrozen = false;
    this._manualFrozen = false;
    
    this.root.dataset.direction = this.options.direction;

    ydCarousel._instances.add(this); 
    
    if (
      !ydCarousel.activeCarousel ||
      ydCarousel.activeCarousel.destroyed ||
      (this.options.keyboard && !ydCarousel.activeCarousel.options.keyboard)
    ) {
      ydCarousel.activeCarousel = this;
    }
    
    this.setupAccessibility();
    this.setupObservers();
    this.updateMeasurements();
    this.bindEvents();
    
    this.initPlugins();
    this.initEnterprisePlugins(); 

    this.startPhysicsLoop();
    this.root.classList.add('yd_carousel-ready');
    this.emit('init');
  }

  pause() {
    if (this.destroyed || this._isPaused) return;
    this._isPaused = true;
    
    if (this.rafId) {
      if (typeof cancelAnimationFrame === 'function') cancelAnimationFrame(this.rafId);
      this.rafId = null;
    }

    if (this.isDraggingActive) {
      this.isDraggingActive = false;
      this.dragState.active = false;
      this.isClickSuppressed = false;
      this.track.style.cursor = '';
      if (ydCarousel.hasDOM()) {
        window.removeEventListener('pointermove', this.onPointerMove);
        window.removeEventListener('pointerup', this.onPointerUp);
        window.removeEventListener('pointercancel', this.onPointerUp);
      }
      if (this.activePointerId !== undefined) {
        try { this.track.releasePointerCapture(this.activePointerId); } catch (err) {}
        this.activePointerId = undefined;
      }
      this.emit('dragEnd');
      this.snapToClosest(true, true);
    }
    
    this.emit('pause');
  }

  resume() {
    if (this.destroyed || !this._isPaused) return;
    this._isPaused = false;
    if (!this._isFrozen) this._wake(); 
    this.emit('resume');
  }

  isPaused() { return this._isPaused; }

  freeze(isManual = true) {
    if (this.destroyed) return;
    
    if (isManual) {
      this._manualFrozen = true;
    }
    
    if (this._isFrozen) return;
    this._isFrozen = true;

    if (this.rafId) {
      if (typeof cancelAnimationFrame === 'function') cancelAnimationFrame(this.rafId);
      this.rafId = null;
    }

    if (this.mutationRaf) {
      if (typeof cancelAnimationFrame === 'function') cancelAnimationFrame(this.mutationRaf);
      this.mutationRaf = null;
    }

    if (this.isDraggingActive) {
      this.isDraggingActive = false;
      this.dragState.active = false;
      this.isClickSuppressed = false;
      this.track.style.cursor = '';
      if (ydCarousel.hasDOM()) {
        window.removeEventListener('pointermove', this.onPointerMove);
        window.removeEventListener('pointerup', this.onPointerUp);
        window.removeEventListener('pointercancel', this.onPointerUp);
      }
      if (this.activePointerId !== undefined) {
        try { this.track.releasePointerCapture(this.activePointerId); } catch (err) {}
        this.activePointerId = undefined;
      }
      this.emit('dragEnd');
      this.snapToClosest(true, true);
    }

    if (this.resizeObserver) this.resizeObserver.disconnect();
    if (this.mutationObserver) this.mutationObserver.disconnect();
    if (this.visibilityObserver) this.visibilityObserver.disconnect();

    this.emit('freeze', { reason: isManual ? 'manual' : 'visibility' });
  }

  unfreeze(isManual = true) {
    if (this.destroyed) return;
    
    if (isManual) {
      this._manualFrozen = false;
    } else if (this._manualFrozen) {
      return;
    }

    if (!this._isFrozen) return;
    this._isFrozen = false;

    if (this.resizeObserver && this.root) {
      this.resizeObserver.observe(this.root);
    }
    if (this.mutationObserver && this.track) {
      this.mutationObserver.observe(this.track, { childList: true, subtree: true, attributes: true, attributeFilter: ['src'] });
    }
    if (this.visibilityObserver && this.track) {
      Array.from(this.track.children).forEach(node => this.visibilityObserver.observe(node));
    }

    this.updateMeasurements();
    this.emit('unfreeze', { reason: isManual ? 'manual' : 'visibility' });
  }

  isFrozen() { return this._isFrozen; }

  _onDocVisibilityChange() {
    this._handleAutoVisibility(this._lastIntersectionState, !document.hidden);
  }

  _handleAutoVisibility(intersecting, docVisible) {
    this._lastIntersectionState = intersecting;
    const shouldBeActive = intersecting && docVisible;
    
    if (!shouldBeActive && !this._isFrozen) {
      this._isAutoFrozen = true;
      this.freeze(false);
    } else if (shouldBeActive && this._isAutoFrozen) {
      this._isAutoFrozen = false;
      this.unfreeze(false);
    }
  }

  setupAccessibility() {
    if (!ydCarousel.hasDOM()) return;
    
    this.root.setAttribute('role', 'region');
    this.root.setAttribute('aria-roledescription', 'carousel');
    
    if (!this.root.id) {
      this.root.id = `yd_carousel_${Math.random().toString(36).slice(2, 11)}`;
    }
    const trackId = this.track.id || `${this.root.id}_track`;
    this.track.id = trackId;
    this.track.setAttribute('aria-live', 'polite');
    
    let announcer = this.root.querySelector('.yd_carousel-announcer');
    if (!announcer) {
      announcer = document.createElement('div');
      announcer.className = 'yd_carousel-announcer';
      announcer.setAttribute('aria-live', 'polite');
      announcer.setAttribute('aria-atomic', 'true');
      announcer.style.cssText = 'position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;';
      this.root.appendChild(announcer);
    }
    
    this.announceHandler = (api, payload) => {
      if (api.options.slideSnap) {
        announcer.textContent = `Slide ${payload.currentIndex + 1} of ${api.logicalSlideCount()}`;
      } else {
        announcer.textContent = `Group ${payload.currentGroup + 1} of ${api.groupCount()}`;
      }
    };
    this.on('select', this.announceHandler);
  }

  focusActiveSlide() {
    const active = this.activeSlide();
    if (!active) return;

    if (!active.hasAttribute('tabindex')) {
      active.setAttribute('tabindex', '0');
    }

    if (typeof active.focus === 'function') {
      try {
        active.focus({ preventScroll: true });
      } catch (err) {
        active.focus();
      }
    }
  }

  circularDetection() {
    const registry = ydCarousel._pluginRegistry;
    const cycles = [];
    const visited = new Map(); 
    const path = [];

    const dfs = (node) => {
      visited.set(node, 1);
      path.push(node);

      const def = registry.get(node);
      const deps = def ? (def.dependencies || def.requires || []) : [];

      for (const dep of deps) {
        if (!registry.has(dep)) continue;
        const state = visited.get(dep) || 0;
        if (state === 1) {
          const cycleStart = path.indexOf(dep);
          cycles.push([...path.slice(cycleStart), dep]);
        } else if (state === 0) {
          dfs(dep);
        }
      }

      path.pop();
      visited.set(node, 2);
    };

    registry.forEach((_, name) => {
      if ((visited.get(name) || 0) === 0) {
        dfs(name);
      }
    });

    return Object.freeze(cycles.map(c => Object.freeze([...c])));
  }

  detectCircularDependencies() {
    return this.circularDetection();
  }

  validateDependencies(pluginName = null) {
    const registry = ydCarousel._pluginRegistry;
    const activeNames = new Set([
      ...this.plugins.map(p => p.name).filter(Boolean),
      ...Array.from(this.activePlugins.keys())
    ]);

    const missing = [];
    const targetPlugins = pluginName ? [pluginName] : Array.from(registry.keys());

    targetPlugins.forEach(name => {
      const def = registry.get(name);
      if (def) {
        const deps = def.dependencies || def.requires || [];
        deps.forEach(dep => {
          if (!activeNames.has(dep)) {
            missing.push(
              Object.freeze({
                plugin: name,
                missingDependency: dep
              })
            );
          }
        });
      } else if (!activeNames.has(name)) {
        missing.push(
          Object.freeze({
            plugin: name,
            missingDependency: 'unregistered'
          })
        );
      }
    });

    const circular = this.circularDetection();

    return Object.freeze({
      valid: missing.length === 0 && circular.length === 0,
      missing: Object.freeze(missing),
      circular
    });
  }

  dependencyReport() {
    const registry = ydCarousel._pluginRegistry;
    const activeNames = new Set([
      ...this.plugins.map(p => p.name).filter(Boolean),
      ...Array.from(this.activePlugins.keys())
    ]);

    const report = {};
    const missingDependencies = [];

    const dependentsMap = new Map();
    registry.forEach((_, name) => dependentsMap.set(name, []));

    registry.forEach((def, name) => {
      const deps = def.dependencies || def.requires || [];
      deps.forEach(dep => {
        if (dependentsMap.has(dep)) {
          dependentsMap.get(dep).push(name);
        }
      });
    });

    registry.forEach((def, name) => {
      const deps = def.dependencies || def.requires || [];
      const missing = deps.filter(dep => !activeNames.has(dep));

      if (missing.length > 0) {
        missingDependencies.push(
          Object.freeze({
            plugin: name,
            missing: Object.freeze([...missing])
          })
        );
      }

      report[name] = Object.freeze({
        active: activeNames.has(name),
        dependencies: Object.freeze([...deps]),
        satisfied: missing.length === 0,
        missing: Object.freeze([...missing]),
        dependents: Object.freeze(dependentsMap.get(name) || [])
      });
    });

    const circular = this.circularDetection();

    return Object.freeze({
      valid: missingDependencies.length === 0 && circular.length === 0,
      plugins: Object.freeze(report),
      missingDependencies: Object.freeze(missingDependencies),
      circularDependencies: circular
    });
  }

  _recordPluginError(pluginName, err) {
    const current = this._pluginErrorTracker.get(pluginName) || { count: 0, lastError: null };
    this._pluginErrorTracker.set(pluginName, {
      count: current.count + 1,
      lastError: err ? (err.message || String(err)) : 'Unknown error'
    });
  }

  pluginInfo() {
    const registered = Array.from(ydCarousel._pluginRegistry.keys());
    const enterpriseActive = Array.from(this.activePlugins.keys());
    const coreActive = this.plugins.map(p => p.name || 'anonymous');
    
    return Object.freeze({
      totalRegistered: registered.length,
      totalActive: enterpriseActive.length + coreActive.length,
      registeredPlugins: Object.freeze([...registered]),
      activeEnterprise: Object.freeze([...enterpriseActive]),
      activeCore: Object.freeze([...coreActive])
    });
  }

  warnings() {
    const list = [];
    if (this.destroyed) {
      list.push('Instance is destroyed.');
      return Object.freeze(list);
    }
    
    // LOGICAL COUNT
    if (this.options.loop && this.logicalSlideCount() <= 1) {
      list.push('Loop mode is enabled but requires at least 2 slides.');
    }
    if (this.options.vertical && this.options.loop && this.root.classList.contains('wheel')) {
      list.push('Wheel navigation in vertical loop mode may trap page scrolling.');
    }
    
    // LOGICAL COUNT
    if (this.logicalSlideCount() === 0) {
      list.push('Carousel track contains no slides.');
    }
    
    const uptimeSecs = Math.max(1, (ydCarousel._now() - this._stats.initTime) / 1000);
    if (this._stats.layoutCalcs > 50 && (this._stats.layoutCalcs / uptimeSecs) > 10) {
      list.push(`High layout recalculation rate (${(this._stats.layoutCalcs / uptimeSecs).toFixed(1)}/sec). Check for frequent DOM mutations.`);
    }

    const depCheck = this.validateDependencies();
    if (!depCheck.valid) {
      depCheck.missing.forEach(m => list.push(`Missing plugin dependency: "${m.missingDependency}" required by "${m.plugin}".`));
      depCheck.circular.forEach(c => list.push(`Circular plugin dependency cycle: ${c.join(' -> ')}.`));
    }

    return Object.freeze(list);
  }

  compatibilityReport() {
    const hasDOM = ydCarousel.hasDOM();
    const requiredFeatures = {
      ResizeObserver: hasDOM && typeof window.ResizeObserver !== 'undefined',
      IntersectionObserver: hasDOM && typeof window.IntersectionObserver !== 'undefined',
      MutationObserver: hasDOM && typeof window.MutationObserver !== 'undefined',
      PointerEvents: hasDOM && typeof window.PointerEvent !== 'undefined',
      requestAnimationFrame: hasDOM && typeof window.requestAnimationFrame !== 'undefined',
      performanceNow: typeof performance !== 'undefined' && typeof performance.now === 'function'
    };
    
    const optionalFeatures = {
      matchMedia: hasDOM && typeof window.matchMedia !== 'undefined',
      inert: hasDOM && ('inert' in document.createElement('div'))
    };

    const degradedFeatures = [];
    if (!requiredFeatures.ResizeObserver) degradedFeatures.push('ResizeObserver missing; auto-resizing via observer disabled.');
    if (!requiredFeatures.IntersectionObserver) degradedFeatures.push('IntersectionObserver missing; auto-visibility and lazy loading may fall back.');
    if (!requiredFeatures.MutationObserver) degradedFeatures.push('MutationObserver missing; dynamic DOM mutations will not auto-refresh.');
    if (!requiredFeatures.requestAnimationFrame) degradedFeatures.push('requestAnimationFrame missing; physics loop will be disabled.');

    const fullyCompatible = Object.values(requiredFeatures).every(Boolean);

    return Object.freeze({
      engine: ydCarousel.ENGINE,
      version: ydCarousel.VERSION,
      environment: hasDOM ? 'browser' : 'non-browser/ssr',
      fullyCompatible,
      requiredFeatures: Object.freeze(requiredFeatures),
      optionalFeatures: Object.freeze(optionalFeatures),
      degradedFeatures: Object.freeze(degradedFeatures)
    });
  }

  pluginHealth() {
    const registry = ydCarousel._pluginRegistry;
    const activeNames = new Set(Array.from(this.activePlugins.keys()));
    const health = {};

    registry.forEach((def, name) => {
      const errInfo = this._pluginErrorTracker.get(name) || { count: 0, lastError: null };
      health[name] = Object.freeze({
        type: 'enterprise',
        active: activeNames.has(name),
        errors: errInfo.count,
        lastError: errInfo.lastError
      });
    });

    this.plugins.forEach(p => {
      if (p.name && !health[p.name]) {
        const errInfo = this._pluginErrorTracker.get(p.name) || { count: 0, lastError: null };
        health[p.name] = Object.freeze({
          type: 'core',
          active: true,
          errors: errInfo.count,
          lastError: errInfo.lastError
        });
      }
    });

    this._pluginErrorTracker.forEach((errInfo, name) => {
      if (!health[name]) {
        health[name] = Object.freeze({
          type: 'core',
          active: false,
          errors: errInfo.count,
          lastError: errInfo.lastError
        });
      }
    });

    return Object.freeze(health);
  }

  health() {
    const issues = [];
    let status = 'healthy';

    if (this.destroyed) {
      return Object.freeze({ status: 'destroyed', issues: ['Instance is destroyed'], timestamp: Date.now() });
    }

    if (!this.root) {
      issues.push('Root element missing');
    } else if (typeof document !== 'undefined' && !document.contains(this.root)) {
      issues.push('Root element detached from DOM');
    }

    if (!this.track) issues.push('Track container missing');
    
    if (isNaN(this.currentPos)) issues.push('currentPos computation resulted in NaN');
    if (isNaN(this.targetPos)) issues.push('targetPos computation resulted in NaN');
    if (this.batchDepth > 0) issues.push(`Unresolved dynamic batch operations (depth: ${this.batchDepth})`);

    if (ydCarousel.hasDOM() && this.options.autoVisibility && typeof IntersectionObserver === 'undefined') {
      issues.push('autoVisibility is enabled but IntersectionObserver is not supported in this environment.');
    }

    if (this.logicalSlideCount() > 0 && this.currentIndex >= this.logicalSlideCount()) {
      issues.push('Current index exceeds slide count');
    }
    if (this.currentIndex < 0) issues.push('Current index below zero');

    if (this.groupCount() > 0 && this.currentGroup >= this.groupCount()) {
      issues.push('Current group exceeds group count');
    }
    if (this.currentGroup < 0) issues.push('Current group below zero');

    const warns = this.warnings();
    warns.forEach(w => {
      if (!issues.includes(w)) issues.push(w);
    });

    if (issues.length > 0) status = 'degraded';

    return Object.freeze({ status, issues, reducedMotion: this.reducedMotion, timestamp: Date.now() });
  }

  performanceStats() {
    if (this.destroyed) {
      return Object.freeze({ destroyed: true });
    }
    
    const totalNodes = this.track ? this.track.children.length : 0;
    const clones = this.track ? this.track.querySelectorAll('.yd_slide-clone').length : 0;
    
    return Object.freeze({
      layoutRecalculations: this._stats.layoutCalcs,
      lastLayoutDurationMs: parseFloat(this._stats.lastLayoutTime.toFixed(2)),
      renderTicks: this._stats.renderTicks,
      domNodeCount: totalNodes,
      clonedNodes: clones,
      // LOGICAL COUNT
      originalSlides: this.logicalSlideCount(),
      activeObservers: this._isFrozen ? 0 : ((this.resizeObserver ? 1 : 0) + (this.mutationObserver ? 1 : 0) + (this.visibilityObserver ? 1 : 0))
    });
  }

  xray() {
    return Object.freeze({
      core: this.info(),
      inspection: this.inspect(),
      virtual: Object.freeze({
        enabled: this.virtual.enabled,
        logicalSlides: this.getLogicalCount(),
        renderedSlides: this.getRenderedCount(),
        windowSlides: this.virtual.windowSlides.length,
        lastWindow: [...this.virtual.lastWindow],
        logicalGroups: [...this.virtual.logicalGroups],
        groupCount: this.virtual.logicalGroups.length,
        currentGroupStart: this.virtual.logicalGroups[this.currentGroup] !== undefined ? this.virtual.logicalGroups[this.currentGroup] : 0,
        currentLogicalIndex: this.currentIndex,
        currentRenderIndex: this.virtual.renderIndex,
        slidesPerView: this.virtual.slidesPerView,
        buffer: this.virtual.buffer,
        windowSize: this.virtual.windowSize,
        windowStart: this.virtual.windowStart,
        windowEnd: this.virtual.windowEnd,
        renderIndex: this.virtual.renderIndex,
        pendingRebalance: this.virtual.pendingRebalance,
        lastRebalanceIndex: this.virtual.lastRebalanceIndex,
        safetyMargin: this.windowSafetyMargin(),
        renderedIndices: this.buildVirtualWindow(this.currentIndex)
      }),
      drag: {
        active: this.dragState.active,
        startLogicalIndex: this.dragState.startLogicalIndex,
        currentLogicalIndex: this.dragState.currentLogicalIndex
      },
      health: this.health(),
      performance: this.performanceStats(),
      warnings: this.warnings(),
      compatibility: this.compatibilityReport(),
      plugins: this.pluginInfo(),
      pluginHealth: this.pluginHealth(),
      dependencies: this.dependencyReport(),
      events: Object.freeze({
        stats: this.eventStats(),
        totalListeners: this.listenerCount()
      }),
      metrics: Object.freeze({
        viewportSize: this.metrics.viewportSize,
        trackSize: this.metrics.trackSize,
        realTrackSize: this.metrics.realTrackSize,
        prependOffset: this.metrics.prependOffset,
        gap: this.metrics.gap,
        averageSlideSize: this.metrics.averageSlideSize,
        slideSizes: Object.freeze([...this.metrics.slideSizes]),
        slideOffsets: Object.freeze([...this.metrics.slideOffsets]),
        slideSnaps: Object.freeze([...this.metrics.slideSnaps]),
        groupSnaps: Object.freeze([...this.metrics.groupSnaps]), // legacy
        snapPoints: Object.freeze([...this.metrics.snapPoints])
      }),
      config: Object.freeze({
        loop: this.options.loop,
        dragFree: this.options.dragFree,
        alignCenter: this.options.alignCenter,
        alignEnd: this.options.alignEnd,
        keyboard: this.options.keyboard,
        autoplay: this.options.autoplay,
        direction: this.options.direction,
        vertical: this.options.vertical,
        autoHeight: this.options.autoHeight,
        autoVisibility: this.options.autoVisibility,
        focusOnChange: this.options.focusOnChange,
        reducedMotion: this.reducedMotion,
        duration: this.options.duration,
        friction: this.options.friction,
        delay: this.options.delay,
        dragThreshold: this.options.dragThreshold,
        velocityThreshold: this.options.velocityThreshold,
        dragInertia: this.options.dragInertia,
        slideSnap: this.options.slideSnap,
        groupSnap: this.options.groupSnap
      })
    });
  }

  once(event, callback) {
    const wrapper = (...args) => {
      this.off(event, wrapper);
      callback(...args);
    };
    return this.on(event, wrapper);
  }

  eventStats(clear = false) {
    const stats = Object.freeze({ ...this._eventStats });
    if (clear) this._eventStats = {};
    return stats;
  }

  listenerCount(eventName) {
    if (eventName) {
      return this.listeners[eventName] ? this.listeners[eventName].length : 0;
    }
    return Object.keys(this.listeners).reduce((acc, key) => acc + this.listeners[key].length, 0);
  }

  exportState() {
    return Object.freeze({
      index: this.currentIndex,
      group: this.currentGroup
    });
  }

  importState(state) {
    if (!state) return;
    if (typeof state.index === 'number') {
      const maxIdx = Math.max(0, this.logicalSlideCount() - 1);
      const targetIdx = Math.max(0, Math.min(state.index, maxIdx));
      this.goToSlide(targetIdx, true);
    } else if (typeof state.group === 'number') {
      const maxGrp = Math.max(0, this.groupCount() - 1); 
      const targetGrp = Math.max(0, Math.min(state.group, maxGrp));
      this.goToGroup(targetGrp, true);
    }
  }

  isReducedMotion() { return this.reducedMotion; }
  version() { return ydCarousel.VERSION; }
  isReady() { return this.root.classList.contains('yd_carousel-ready'); }
  isDestroyed() { return this.destroyed; }
  events() { return [...ydCarousel.EVENTS, '*']; }
  
  hashGroup() { return this.root.dataset.hashGroup; }
  syncGroup() { return this.root.dataset.syncGroup; }
  velocity() { return this._velocity; }
  currentPosition() { return this.currentPos; }
  targetPosition() { return this.targetPos; }

  logicalSlides() { return this.virtual.logicalSlides; }
  renderedSlides() { return this.virtual.renderedSlides; }

  logicalSlideCount() {
    if (this.virtual.logicalSlides.length > 0) {
      return this.virtual.logicalSlides.length;
    }
    return this.slides.length;
  }

  renderedSlideCount() { return this.virtual.renderedSlides.length; }

  getLogicalCount() { return this.logicalSlideCount(); }
  getRenderedCount() { return this.virtual.renderedSlides.length; }

  getLogicalSlide(index) { return this.virtual.logicalSlides[index] || null; }
  getRenderedSlide(index) { return this.virtual.renderedSlides[index] || null; }

  getRenderedSlideByLogicalIndex(index) {
    return this.slides.find(
      slide => Number(slide.getAttribute('data-slide-index')) === index
    ) || null;
  }

  getSlidesPerView() {
    const avg = this.metrics.averageSlideSize;
    if (avg <= 0) {
      return 1;
    }
    return Math.max(1, Math.ceil(this.metrics.viewportSize / avg));
  }

  getVirtualBuffer() {
    return Math.max(this.getSlidesPerView() * 3, 6);
  }

  getWindowSize() {
    const visible = this.getSlidesPerView();
    const buffer = this.getVirtualBuffer();
    return buffer + visible + buffer;
  }

  normalizeLogicalIndex(index) {
    const total = this.logicalSlideCount();
    if (!total) return 0;
    let normalized = index;
    while (normalized < 0) normalized += total;
    while (normalized >= total) normalized -= total;
    return normalized;
  }

  buildLogicalGroups() {
    const groups = [];
    const visible = this.virtual.slidesPerView || 1;
    const total = this.logicalSlideCount();
    for (let i = 0; i < total; i += visible) {
      groups.push(i);
    }
    return groups;
  }

  buildLogicalGroupSnaps() {
    return this.virtual.logicalGroups.map(groupStart => ({
      logicalIndex: groupStart
    }));
  }

  getGroupForLogicalIndex(index) {
    const normIndex = this.options.loop ? this.normalizeLogicalIndex(index) : index;
    const groups = this.virtual.logicalGroups;
    if (!groups || groups.length === 0) return 0;
    let result = 0;
    for (let i = 0; i < groups.length; i++) {
      if (groups[i] <= normIndex) {
        result = i;
      } else {
        break;
      }
    }
    return result;
  }

  buildVirtualWindow(activeIndex) {
    if (!this.virtual.enabled) {
      return [];
    }

    const total = this.logicalSlideCount();
    if (!total) {
      return [];
    }

    const buffer = this.virtual.buffer;
    const start = activeIndex - buffer;
    const end = activeIndex + buffer + this.virtual.slidesPerView;
    const window = [];

    for (let i = start; i < end; i++) {
      window.push(this.normalizeLogicalIndex(i));
    }

    console.assert(
      window.length === this.virtual.windowSize,
      'Invalid virtual window size'
    );

    return window;
  }

  buildRenderedSlides(activeIndex) {
    const indices = this.buildVirtualWindow(activeIndex);
    return indices.map(index => this.virtual.logicalSlides[index]);
  }

  resolveRenderIndex(logicalIndex, windowArray = null) {
    const window = windowArray || this.buildVirtualWindow(this.currentIndex);
    const index = window.indexOf(logicalIndex);
    return index >= 0 ? index : 0;
  }

  syncRenderIndex() {
    this.virtual.renderIndex = this.resolveRenderIndex(this.currentIndex);
  }

  calculateWindowDelta(oldWindow, newWindow) {
    return {
      removed: oldWindow.filter(x => !newWindow.includes(x)),
      added: newWindow.filter(x => !oldWindow.includes(x))
    };
  }

  measureOutgoingWidth(indices) {
    let width = 0;
    indices.forEach(index => {
      const slide = this.getRenderedSlideByLogicalIndex(index);
      if (!slide) {
        return;
      }
      const rect = slide.getBoundingClientRect();
      width += (this.options.vertical ? rect.height : rect.width) + this.metrics.gap;
    });
    return width;
  }

  applyTranslationCompensation(delta, direction) {
    if (direction === 'forward') {
      this.currentPos -= delta;
      this.targetPos -= delta;
    } else {
      this.currentPos += delta;
      this.targetPos += delta;
    }
  }

  rebalanceWindow(activeIndex) {
    const oldWindow = [...this.virtual.lastWindow];
    const newWindow = this.buildVirtualWindow(activeIndex);
    const diff = this.calculateWindowDelta(oldWindow, newWindow);
    const deltaWidth = this.measureOutgoingWidth(diff.removed);

    this.virtual.windowSlides = this.buildRenderedSlides(activeIndex);

    let direction = this.currentIndex > this.prevIndex ? 'forward' : 'backward';
    if (this.options.loop && this.logicalSlideCount() > 0) {
      const half = this.logicalSlideCount() / 2;
      if (this.prevIndex - this.currentIndex > half) direction = 'forward';
      else if (this.currentIndex - this.prevIndex > half) direction = 'backward';
    }

    this.virtual.pendingRebalance = {
      direction,
      deltaWidth
    };

    this.virtual.lastWindow = [...newWindow];
  }

  updateVirtualRenderer(activeIndex) {
    if (!this.virtual.enabled) {
      return;
    }

    if (this.virtual.lastWindow.length === 0) {
      this.virtual.windowSlides = this.buildRenderedSlides(activeIndex);
      this.virtual.lastWindow = this.buildVirtualWindow(activeIndex);
    } else {
      this.rebalanceWindow(activeIndex);
    }

    this.syncRenderIndex();
  }

  distanceToWindowStart(logicalIndex) {
    const window = this.virtual.lastWindow.length > 0 ? this.virtual.lastWindow : this.buildVirtualWindow(this.currentIndex);
    return this.resolveRenderIndex(logicalIndex, window);
  }

  distanceToWindowEnd(logicalIndex) {
    const window = this.virtual.lastWindow.length > 0 ? this.virtual.lastWindow : this.buildVirtualWindow(this.currentIndex);
    return this.virtual.windowSize - 1 - this.resolveRenderIndex(logicalIndex, window);
  }

  approachingWindowEdge() {
    const futureIndex = this.predictFutureIndex();
    const window = this.virtual.lastWindow.length > 0 ? this.virtual.lastWindow : this.buildVirtualWindow(this.currentIndex);
    
    if (window.indexOf(futureIndex) === -1) {
      return true;
    }

    const threshold = Math.max(2 * this.virtual.slidesPerView, 6);

    if (this._velocity > 0) {
      return this.distanceToWindowEnd(futureIndex) <= threshold;
    }

    if (this._velocity < 0) {
      return this.distanceToWindowStart(futureIndex) <= threshold;
    }

    return false;
  }

  predictFutureIndex() {
    const projectedPosition = this.targetPos + this.inertia;
    return this.findNearestSlide(projectedPosition);
  }

  midFlightRebalance() {
    const futureIndex = this.predictFutureIndex();

    if (futureIndex === this.virtual.lastRebalanceIndex) {
      return;
    }

    this.virtual.lastRebalanceIndex = futureIndex;
    this.rebalanceWindow(futureIndex);
    this.onMidDragRebalance();
  }

  windowSafetyMargin() {
    if (!this.virtual.enabled) return 0;
    const futureIndex = this.predictFutureIndex();
    const window = this.virtual.lastWindow.length > 0 ? this.virtual.lastWindow : this.buildVirtualWindow(this.currentIndex);
    
    if (window.indexOf(futureIndex) === -1) {
      return 0;
    }

    return Math.min(
      this.distanceToWindowStart(futureIndex),
      this.distanceToWindowEnd(futureIndex)
    );
  }

  updateDragLogicalIndex() {
    if (!this.dragState.active) {
      return;
    }
    this.dragState.currentLogicalIndex = this.findNearestSlide(this.targetPos);
    this.previewGroup = this.getGroupForLogicalIndex(this.dragState.currentLogicalIndex);
  }

  onMidDragRebalance() {
    if (!this.dragState.active) {
      return;
    }
    const logical = this.dragState.currentLogicalIndex;
    this.virtual.renderIndex = this.resolveRenderIndex(logical);
  }

  isDragRebalanceSafe() {
    return (this.dragState.active && this.activePointerId !== undefined);
  }

  validateDragPosition() {
    if (!this.dragState.active) {
      return;
    }
    const expected = this.resolveRenderIndex(this.dragState.currentLogicalIndex);
    if (expected !== this.virtual.renderIndex) {
      this.virtual.renderIndex = expected;
    }
  }

  slideCount() {
    // LOGICAL COUNT
    return this.logicalSlideCount();
  }
  
  groupCount() { return this.virtual.logicalGroups.length; }
  selectedGroup() { return this.currentGroup; }
  
  state() {
    return Object.freeze({
      version: this.version(),
      index: this.currentIndex,
      group: this.currentGroup,
      previousIndex: this.prevIndex,
      position: this.currentPos,
      target: this.targetPos,
      velocity: this._velocity,
      progress: this.scrollProgress(),
      visualProgress: this.getVisualProgress(),
      dragging: this.isDraggingActive,
      settled: this.isSettled,
      looping: this.options.loop,
      rtl: this.isRTL,
      direction: this.options.direction,
      vertical: this.options.vertical,
      autoHeight: this.options.autoHeight,
      autoVisibility: this.options.autoVisibility,
      focusOnChange: this.options.focusOnChange,
      reducedMotion: this.reducedMotion,
      paused: this._isPaused,
      frozen: this._isFrozen,
      autoFrozen: this._isAutoFrozen,
      manualFrozen: this._manualFrozen,
      slideSnap: this.options.slideSnap,
      groupSnap: this.options.groupSnap
    });
  }

  get stateData() { return this.state(); }
  snapshot() { return this.state(); }
  pluginsList() { return this.plugins.map(p => p.name || 'anonymous').concat(Array.from(this.activePlugins.keys())); }

  buildInfo() {
    return Object.freeze({
      engine: ydCarousel.ENGINE,
      version: this.version(),
      build: 'enterprise-production',
      released: '2026-08'
    });
  }

  capabilities() {
    return Object.freeze({
      loop: true, dragFree: true, rtl: true, direction: true, vertical: true, autoHeight: true, autoVisibility: true, dynamicApi: true,
      autoplay: true, autoplayApi: true, keyboard: true, wheel: true, hash: true,
      sync: true, creative: true, lazyLoad: true, accessibility: true, focusManagement: true,
      once: true, stateExportImport: true, reducedMotion: true, eventWildcards: true, eventStats: true, listenerCount: true,
      pauseResume: true, freezeUnfreeze: true,
      warnings: true, compatibilityReport: true, pluginHealth: true,
      debug: true, plugins: true, events: true, diagnostics: true, dependencies: true,
      snapshots: true, observers: true, registry: true 
    });
  }

  runtimeCapabilities() {
    return Object.freeze({
      loop: this.options.loop, dragFree: this.options.dragFree,
      rtl: this.isRTL, direction: this.options.direction, vertical: this.options.vertical,
      autoplay: this.options.autoplay, keyboard: this.options.keyboard,
      autoHeight: this.options.autoHeight, autoVisibility: this.options.autoVisibility, focusOnChange: this.options.focusOnChange,
      reducedMotion: this.reducedMotion,
      alignCenter: this.options.alignCenter, alignEnd: this.options.alignEnd, 
      slideSnap: this.options.slideSnap, groupSnap: this.options.groupSnap
    });
  }

  info() {
    return Object.freeze({
      version: this.version(), build: this.buildInfo(),
      plugins: Object.freeze(this.pluginsList()),
      events: Object.freeze(this.events()),
      capabilities: this.capabilities(),
      runtimeCapabilities: this.runtimeCapabilities(),
      state: this.state()
    });
  }

  inspect() {
    return Object.freeze({
      info: this.info(), state: this.state(),
      capabilities: this.capabilities(), runtimeCapabilities: this.runtimeCapabilities(),
      slidesInView: Object.freeze(this.slidesInView()),
      slidesNotInView: Object.freeze(this.slidesNotInView()),
      activeSlide: this.selectedIndex()
    });
  }

  virtualInfo() {
    return Object.freeze({
      enabled: this.virtual.enabled,
      logicalSlides: this.getLogicalCount(),
      renderedSlides: this.getRenderedCount(),
      windowSlides: this.virtual.windowSlides.length,
      lastWindow: [...this.virtual.lastWindow],
      logicalGroups: [...this.virtual.logicalGroups],
      groupCount: this.virtual.logicalGroups.length,
      currentGroupStart: this.virtual.logicalGroups[this.currentGroup] !== undefined ? this.virtual.logicalGroups[this.currentGroup] : 0,
      currentLogicalIndex: this.currentIndex,
      currentRenderIndex: this.virtual.renderIndex,
      slidesPerView: this.virtual.slidesPerView,
      buffer: this.virtual.buffer,
      windowSize: this.virtual.windowSize,
      windowStart: this.virtual.windowStart,
      windowEnd: this.virtual.windowEnd,
      renderIndex: this.virtual.renderIndex,
      pendingRebalance: this.virtual.pendingRebalance,
      lastRebalanceIndex: this.virtual.lastRebalanceIndex,
      safetyMargin: this.windowSafetyMargin(),
      renderedIndices: this.buildVirtualWindow(this.currentIndex),
      dragState: {
        active: this.dragState.active,
        startLogicalIndex: this.dragState.startLogicalIndex,
        currentLogicalIndex: this.dragState.currentLogicalIndex
      }
    });
  }

  virtualWindowInfo() {
    return {
      activeIndex: this.currentIndex,
      slidesPerView: this.virtual.slidesPerView,
      buffer: this.virtual.buffer,
      windowSize: this.virtual.windowSize,
      renderedSlides: this.virtual.renderedSlides.length,
      indices: this.buildVirtualWindow(this.currentIndex)
    };
  }

  virtualMathReport() {
    return {
      viewport: this.metrics.viewportSize,
      averageSlide: this.metrics.averageSlideSize,
      slidesPerView: this.getSlidesPerView(),
      buffer: this.getVirtualBuffer(),
      windowSize: this.getWindowSize()
    };
  }

  getEventPayload() {
    return {
      currentIndex: this.currentIndex,
      previousIndex: this.prevIndex,
      currentGroup: this.currentGroup, 
      previousGroup: this.prevGroup,
      previewIndex: this.previewIndex !== undefined ? this.previewIndex : this.currentIndex, 
      previewGroup: this.previewGroup !== undefined ? this.previewGroup : this.currentGroup,    
      // LOGICAL COUNT
      slideCount: this.logicalSlideCount(),
      progress: this.scrollProgress(),
      visualProgress: this.getVisualProgress(),
      isDragging: this.isDraggingActive,
      isSettled: this.isSettled,
      looping: this.options.loop,
      direction: this._velocity > 0 ? 1 : (this._velocity < 0 ? -1 : 0),
      paused: this._isPaused,
      frozen: this._isFrozen
    };
  }

  emit(event, customData = {}) {
    if (this.destroyed && event !== 'destroy') return;

    this._eventStats[event] = (this._eventStats[event] || 0) + 1;

    const payload = { ...this.getEventPayload(), ...customData };
    
    if (this.listeners[event]) {
      const listeners = [...this.listeners[event]];
      listeners.forEach(cb => {
        try {
          cb(this, payload);
        } catch (err) {
          console.error(`[ydCarousel] Error executing listener for event "${event}":`, err);
        }
      });
    }

    if (this.listeners['*']) {
      const wildcards = [...this.listeners['*']];
      wildcards.forEach(cb => {
        try {
          cb(event, this, payload);
        } catch (err) {
          console.error(`[ydCarousel] Error executing wildcard listener for event "${event}":`, err);
        }
      });
    }
  }

  on(event, callback) {
    if (!this.listeners[event]) this.listeners[event] = [];
    if (!this.listeners[event].includes(callback)) {
      this.listeners[event].push(callback);
    }
    return this;
  }

  off(event, callback) {
    if (!this.listeners[event]) return this;
    this.listeners[event] = this.listeners[event].filter(cb => cb !== callback);
    if (this.listeners[event].length === 0) {
      delete this.listeners[event];
    }
    return this;
  }

  scrollTo(index, immediate = false) { this.goToSlide(index, immediate); }
  selectedIndex() { return this.currentIndex; }
  previousIndex() { return this.prevIndex; }
  
  activeSlide() { 
    // RENDERED LOOKUP
    const activeIdx = this.virtual.enabled ? this.virtual.renderIndex : this.currentIndex;
    return this.getRenderedSlide(activeIdx); 
  }
  
  slideNodes() { 
    // RENDERED DOM COUNT
    return this.renderedSlides(); 
  }
  
  isDragging() { return this.isDraggingActive; } 
  isLoop() { return this.options.loop; }        

  refresh(full = false) {
    if (this.destroyed) return;
    this.updateMeasurements();
    if (full) this.initPlugins();
  }

  reInit(config = {}) {
    const root = this.root;
    let savedState = null;
    if (config && config.preserveState) {
      savedState = this.exportState();
    }
    this.destroy();
    const newApi = new ydCarousel(root);
    if (savedState) {
      newApi.importState(savedState);
    }
    return newApi;
  }

  rebuildPlugins() {
    if (this.destroyed) return;
    this.initPlugins();
  }

  _purgeClones() {
    this.track.querySelectorAll('.yd_slide-clone').forEach(c => c.remove());
  }

  batch(callback) {
    if (this.destroyed) return;
    if (this.batchDepth === 0) {
      // RENDERED LOOKUP
      const activeIdx = this.virtual.enabled ? this.virtual.renderIndex : this.currentIndex;
      this._trackedActiveNode = this.getRenderedSlide(activeIdx);
      this._purgeClones(); 
    }
    this.batchDepth++;
    this.ignoreNextMutation = true;
    let batchValid = true;
    try {
      const result = callback();
      if (result instanceof Promise) {
        batchValid = false;
        this.ignoreNextMutation = false;
        this._trackedActiveNode = null;
        throw new Error('[ydCarousel] batch() callback must be synchronous.');
      }
    } finally {
      this.batchDepth--;
      if (batchValid && this.batchDepth === 0) {
        this._refreshAfterDynamic();
      }
    }
  }

  _refreshAfterDynamic() {
    if (this.batchDepth > 0) return;
    this._isDynamicRefreshing = true;
    this.updateMeasurements();
    this._isDynamicRefreshing = false;
    this._trackedActiveNode = null;
    this.initPlugins();
  }

  clampState() {
    if (!this.metrics.slideSnaps.length) {
      this.currentIndex = 0;
      this.currentGroup = 0;
      return;
    }
    this.currentIndex = Math.max(0, Math.min(this.currentIndex, this.logicalSlideCount() - 1));
    this.currentGroup = Math.max(0, Math.min(this.currentGroup, this.groupCount() - 1));
    
    if (this.options.slideSnap) {
      this.currentGroup = this.getGroupForLogicalIndex(this.currentIndex);
    } else {
      const targetLogical = this.virtual.logicalGroups[this.currentGroup];
      this.currentIndex = targetLogical || 0;
    }
  }

  addSlide(html) {
    this.batch(() => {
      this.track.insertAdjacentHTML('beforeend', html);
    });
  }

  removeSlide(index) {
    this.batch(() => {
      // RENDERED LOOKUP
      const slide = this.getRenderedSlide(index);
      if (slide) slide.remove();
    });
  }

  removeAllSlides() {
    this.batch(() => {
      this.track.innerHTML = '';
      this._trackedActiveNode = null;
    });
  }

  insertSlide(index, html) {
    this.batch(() => {
      // RENDERED LOOKUP
      const target = this.getRenderedSlide(index);
      if (!target) {
        this.track.insertAdjacentHTML('beforeend', html);
      } else {
        target.insertAdjacentHTML('beforebegin', html);
      }
    });
  }

  replaceSlide(index, html) {
    this.batch(() => {
      // RENDERED LOOKUP
      const target = this.getRenderedSlide(index);
      if (!target) return;
      target.insertAdjacentHTML('beforebegin', html);
      
      if (this._trackedActiveNode === target) {
        this._trackedActiveNode = null; 
      }
      target.remove();
    });
  }

  canScrollNext() {
    if (this.root.classList.contains('stop-last')) {
      if (this.options.slideSnap) return this.currentIndex < this.logicalSlideCount() - 1;
      return this.currentGroup < this.groupCount() - 1;
    }
    if (this.options.slideSnap) return this.options.loop || this.currentIndex < this.logicalSlideCount() - 1;
    return this.options.loop || this.currentGroup < this.groupCount() - 1;
  }

  canScrollPrev() {
    if (this.options.slideSnap) return this.options.loop || this.currentIndex > 0;
    return this.options.loop || this.currentGroup > 0;
  }

  scrollProgress() {
    if (this.options.loop) {
      if (this.metrics.realTrackSize <= 0) return 0;
      
      let relativePos = (this.currentPos - this.metrics.prependOffset) % this.metrics.realTrackSize;
      if (relativePos < 0) relativePos += this.metrics.realTrackSize;
      
      return Math.max(0, Math.min(1, relativePos / this.metrics.realTrackSize));
    }
    if (!this.maxScroll) return 0;
    return Math.max(0, Math.min(1, this.currentPos / this.maxScroll));
  }
  
  getVisualProgress() {
    const p = this.scrollProgress();
    return (this.isRTL && !this.options.vertical) ? 1 - p : p;
  }

  slideProgress(index) {
    const offset = this.metrics.slideOffsets[index] || 0;
    let distance = this.currentPos - offset;
    
    if (this.options.loop && this.metrics.realTrackSize > 0) {
      const distFwd = distance - this.metrics.realTrackSize;
      const distBwd = distance + this.metrics.realTrackSize;
      if (Math.abs(distFwd) < Math.abs(distance)) distance = distFwd;
      if (Math.abs(distBwd) < Math.abs(distance)) distance = distBwd;
    }
    
    let progress = distance / (this.metrics.viewportSize || 1);
    return Math.max(-1, Math.min(1, progress));
  }

  slidesInView() {
    return [...this.visibleSlides].sort((a, b) => a - b);
  }

  slidesNotInView() {
    return this.slides.map((_, idx) => idx).filter(idx => !this.visibleSlides.has(idx));
  }

  _wake() {
    if (this._isPaused || this._isFrozen) return;
    if (this.isSettled) {
      this.isSettled = false;
      this.startPhysicsLoop();
    }
  }
  
  findNearestSlide(position) {
    let minDistance = Infinity;
    let nearest = 0;
    
    let searchPos = position;
    if (this.options.loop && this.metrics.realTrackSize > 0) {
      let rel = position - this.metrics.prependOffset;
      rel = ((rel % this.metrics.realTrackSize) + this.metrics.realTrackSize) % this.metrics.realTrackSize;
      searchPos = rel + this.metrics.prependOffset;
    }

    this.metrics.slideSnaps.forEach((snap, idx) => {
      let dist = Math.abs(snap - searchPos);
      if (dist < minDistance) {
        minDistance = dist;
        nearest = idx;
      }
    });
    
    if (this.virtual.enabled) {
      const slide = this.getRenderedSlide(nearest);
      if (slide) {
        return parseInt(slide.getAttribute('data-slide-index'), 10);
      }
    }
    
    return nearest;
  }

  updateMeasurements() {
    const perfStart = ydCarousel._now();
    this.visibleSlides.clear();

    if (this.mutationObserver) this.mutationObserver.disconnect();
    this._purgeClones();
    
    // NEW OWNERSHIP MODEL
    this.virtual.renderedSlides = Array.from(this.track.children);
    this.slides = this.virtual.renderedSlides;
    
    if (!this.virtual.enabled || this.virtual.logicalSlides.length === 0) {
      this.virtual.logicalSlides = [...this.virtual.renderedSlides];
    }

    if (this._isDynamicRefreshing) {
      if (this._trackedActiveNode && this.slides.includes(this._trackedActiveNode)) {
        // RENDERED LOOKUP
        this.currentIndex = this.slides.indexOf(this._trackedActiveNode);
      }
    }
    
    // RENDERED DOM COUNT
    if (!this.renderedSlideCount()) {
      this.metrics.slideSnaps = [];
      this.metrics.groupSnaps = [];
      this.metrics.snapPoints = [];
      this.metrics.slideOffsets = [];
      this.metrics.slideSizes = [];
      this.metrics.averageSlideSize = 0;

      this.virtual.windowSlides = [];
      this.virtual.lastWindow = [];
      this.virtual.logicalGroups = [];
      this.virtual.groupSnaps = [];
      this.virtual.slidesPerView = 0;
      this.virtual.buffer = 0;
      this.virtual.windowSize = 0;
      this.virtual.pendingRebalance = null;
      this.virtual.lastRebalanceIndex = -1;

      this.maxScroll = 0;
      this.currentIndex = 0;
      this.currentGroup = 0;

      this.currentPos = 0;
      this.targetPos = 0;
      this._velocity = 0;
      this.inertia = 0;
      this.previewIndex = 0;
      this.previewGroup = 0;

      this.track.style.transform = '';
      const viewportEl = this.root.querySelector('.yd_viewport') || this.root;
      if (this.options.autoHeight && viewportEl) {
        viewportEl.style.height = '';
      }

      if (this.mutationObserver && !this._isFrozen) {
        this.mutationObserver.observe(this.track, { childList: true, subtree: true, attributes: true, attributeFilter: ['src'] });
      }
      
      this._stats.layoutCalcs++;
      this._stats.lastLayoutTime = ydCarousel._now() - perfStart;
      return;
    }

    this.slides.forEach((slide, idx) => {
      // In non-virtual mode, assign DOM index. In virtual mode, the actual DOM manipulation step will handle setting this correctly
      if (!this.virtual.enabled) slide.setAttribute('data-slide-index', idx);
    });

    const viewportEl = this.root.querySelector('.yd_viewport') || this.root;
    const viewportRect = viewportEl.getBoundingClientRect();
    
    this.metrics.viewportSize = this.options.vertical ? viewportRect.height : viewportRect.width;
    
    // RENDERED DOM COUNT
    this.metrics.slideSizes = this.slides.map(slide => {
      const sRect = slide.getBoundingClientRect();
      return this.options.vertical ? sRect.height : sRect.width;
    });

    if (this.metrics.slideSizes.length) {
      this.metrics.averageSlideSize = this.metrics.slideSizes.reduce((total, size) => total + size, 0) / this.metrics.slideSizes.length;
    } else {
      this.metrics.averageSlideSize = 0;
    }

    this.virtual.slidesPerView = this.getSlidesPerView();
    this.virtual.buffer = this.getVirtualBuffer();
    this.virtual.windowSize = this.getWindowSize();

    this.virtual.logicalGroups = this.buildLogicalGroups();
    this.virtual.groupSnaps = this.buildLogicalGroupSnaps();

    if (this.virtual.enabled) {
      this.updateVirtualRenderer(this.currentIndex);
    }

    // RENDERED LOOKUP
    const firstRect = this.getRenderedSlide(0).getBoundingClientRect();
    
    // RENDERED DOM COUNT
    const relativeOffsets = this.slides.map(slide => {
      const sRect = slide.getBoundingClientRect();
      if (this.options.vertical) {
        return sRect.top - firstRect.top;
      }
      return this.isRTL ? firstRect.right - sRect.right : sRect.left - firstRect.left;
    });

    let physicalSize = 0;
    let loopGap = 0;

    // RENDERED DOM COUNT
    if (this.renderedSlideCount() > 0) {
      // RENDERED DOM COUNT
      const lastIdx = this.renderedSlideCount() - 1;
      physicalSize = relativeOffsets[lastIdx] + this.metrics.slideSizes[lastIdx];
    }

    // RENDERED DOM COUNT (Gap Calculation Fix)
    if (this.getRenderedCount() > 1) {
      loopGap = relativeOffsets[1] - (relativeOffsets[0] + this.metrics.slideSizes[0]);
      loopGap = Math.max(0, loopGap);
    }

    this.metrics.gap = loopGap;
    this.metrics.realTrackSize = this.options.loop ? physicalSize + loopGap : physicalSize;

    this.metrics.prependOffset = 0;

    // LOGICAL COUNT
    if (this.options.loop && this.logicalSlideCount() > 1 && this.metrics.realTrackSize > 0) {
      this.metrics.prependOffset = this.metrics.realTrackSize;
      
      let clonedSize = 0;
      let setsNeeded = 0;
      const MAX_CLONES = 120; // Clone count cap to prevent node explosion
      
      // RENDERED DOM COUNT
      while (clonedSize < (this.metrics.viewportSize * 3) && setsNeeded < 4 && (this.renderedSlideCount() * setsNeeded * 2) < MAX_CLONES) {
        clonedSize += this.metrics.realTrackSize;
        setsNeeded++;
      }
      setsNeeded = Math.max(1, setsNeeded);
      
      for (let i = 0; i < setsNeeded; i++) {
        // RENDERED DOM COUNT
        const clonesBefore = this.slides.map(s => this.createClone(s));
        const clonesAfter = this.slides.map(s => this.createClone(s));
        
        // RENDERED LOOKUP
        const firstOriginal = this.getRenderedSlide(0);
        clonesBefore.forEach(c => this.track.insertBefore(c, firstOriginal));
        clonesAfter.forEach(c => this.track.appendChild(c));
      }
    }

    this.metrics.trackSize = this.options.vertical ? this.track.scrollHeight : this.track.scrollWidth;
    
    this.metrics.slideOffsets = [];
    this.metrics.slideSnaps = [];
    this.metrics.groupSnaps = [];
    
    let currentGroupStartOffset = 0;
    let currentGroupStartSnap = 0;
    
    this.metrics.slideSizes.forEach((size, idx) => {
      const relOffset = relativeOffsets[idx];
      const baseOffset = this.metrics.prependOffset + relOffset;
      
      let snap = baseOffset;
      if (this.options.alignCenter) snap -= (this.metrics.viewportSize / 2) - (size / 2);
      if (this.options.alignEnd) snap -= this.metrics.viewportSize - size;
      
      this.metrics.slideOffsets.push(Math.max(0, snap));
      this.metrics.slideSnaps.push(Math.max(0, snap));

      if (idx === 0) {
        this.metrics.groupSnaps.push(Math.max(0, snap));
        currentGroupStartOffset = relOffset;
        currentGroupStartSnap = Math.max(0, snap);
      } else {
        const span = (relOffset - currentGroupStartOffset) + size;
        if (span > this.metrics.viewportSize) {
          currentGroupStartOffset = relOffset;
          currentGroupStartSnap = Math.max(0, snap);
          this.metrics.groupSnaps.push(currentGroupStartSnap);
        }
      }
    });

    this.maxScroll = Math.max(0, this.metrics.realTrackSize - this.metrics.viewportSize);

    if (!this.options.loop) {
      let rawSlides = this.metrics.slideSnaps.map(snap => Math.max(0, Math.min(snap, this.maxScroll)));
      let uniqueSlideSnaps = [];
      rawSlides.forEach(snap => {
        if (uniqueSlideSnaps.length === 0 || Math.abs(uniqueSlideSnaps[uniqueSlideSnaps.length - 1] - snap) > ydCarousel.SNAP_EPSILON) {
          uniqueSlideSnaps.push(snap);
        }
      });
      this.metrics.slideSnaps = uniqueSlideSnaps;
      
      let rawGroups = this.metrics.groupSnaps.map(snap => Math.max(0, Math.min(snap, this.maxScroll)));
      let uniqueGroupSnaps = [];
      rawGroups.forEach(snap => {
        if (uniqueGroupSnaps.length === 0 || Math.abs(uniqueGroupSnaps[uniqueGroupSnaps.length - 1] - snap) > ydCarousel.SNAP_EPSILON) {
          uniqueGroupSnaps.push(snap);
        }
      });
      this.metrics.groupSnaps = uniqueGroupSnaps; 
    }

    this.metrics.snapPoints = this.options.slideSnap ? this.metrics.slideSnaps : this.metrics.groupSnaps;

    if (this.options.loop && this.metrics.slideSnaps.length === 0) {
       this.options.loop = false; 
    }

    this.clampState();

    if (this.visibilityObserver) {
      this.visibilityObserver.disconnect();
      if (!this._isFrozen) {
        Array.from(this.track.children).forEach(node => this.visibilityObserver.observe(node));
      }
    }

    if (this.mutationObserver && !this._isFrozen) {
      this.mutationObserver.observe(this.track, { childList: true, subtree: true, attributes: true, attributeFilter: ['src'] });
    }

    this.emit('resize');
    
    if (this.options.slideSnap) {
      this.goToSlide(this.currentIndex, true);
    } else {
      this.goToGroup(this.currentGroup, true);
    }

    this.updateAutoHeight();

    this._stats.layoutCalcs++;
    this._stats.lastLayoutTime = ydCarousel._now() - perfStart;
  }

  createClone(slide) {
    const clone = slide.cloneNode(true);
    clone.setAttribute('data-slide-index', slide.getAttribute('data-slide-index'));
    clone.classList.add('yd_slide-clone');
    clone.setAttribute('aria-hidden', 'true');
    if ('inert' in clone) {
      clone.inert = true;
    }
    clone.removeAttribute('aria-current');
    clone.classList.remove('active', 'prev', 'next', 'in-view', 'out-view');
    
    const nodes = [clone, ...clone.querySelectorAll('*')];
    nodes.forEach(node => {
      node.removeAttribute('id');
      node.removeAttribute('for');
      node.removeAttribute('aria-labelledby');
      node.removeAttribute('aria-describedby');
      node.removeAttribute('aria-controls');
      
      if (node.matches && node.matches('a, button, input, select, textarea, [tabindex]')) {
        node.setAttribute('tabindex', '-1');
      }
    });
    return clone;
  }

  setupObservers() {
    if (typeof ResizeObserver !== 'undefined') {
      this.resizeObserver = new ResizeObserver(this.onResize);
      this.resizeObserver.observe(this.root);
    }

    if (typeof MutationObserver !== 'undefined') {
      this.mutationObserver = new MutationObserver(this.onMutation);
    }

    if (typeof IntersectionObserver !== 'undefined') {
      const viewport = this.root.querySelector('.yd_viewport') || this.root;
      this.visibilityObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          const node = entry.target;
          const idx = parseInt(node.getAttribute('data-slide-index'), 10);
          const isClone = node.classList.contains('yd_slide-clone');
          
          if (entry.isIntersecting) {
            node.classList.add('in-view');
            node.classList.remove('out-view');
            if (!isClone) {
              node.removeAttribute('aria-hidden');
              if (!isNaN(idx) && !this.visibleSlides.has(idx)) {
                this.visibleSlides.add(idx);
                this.emit('slideEnter', { index: idx });
              }
            }
          } else {
            node.classList.add('out-view');
            node.classList.remove('in-view');
            if (!isClone) {
              node.setAttribute('aria-hidden', 'true');
              if (!isNaN(idx) && this.visibleSlides.has(idx)) {
                this.visibleSlides.delete(idx);
                this.emit('slideExit', { index: idx });
              }
            }
          }
        });
      }, { root: viewport, threshold: 0.01 });

      if (this.options.autoVisibility) {
        this.rootVisibilityObserver = new IntersectionObserver((entries) => {
          this._handleAutoVisibility(entries[0].isIntersecting, !document.hidden);
        }, { rootMargin: '150px' });
        this.rootVisibilityObserver.observe(this.root);
        
        if (ydCarousel.hasDOM()) {
          document.addEventListener('visibilitychange', this._docVisHandler);
        }
      }
    }
  }

  onResize() { this.updateMeasurements(); }

  onMutation(mutations) {
    if (this.batchDepth > 0) return;
    if (this.isDraggingActive) return;

    if (this.ignoreNextMutation) {
      this.ignoreNextMutation = false;
      return;
    }

    const isCloneMutation = mutations.some(m => {
      const nodes = [...Array.from(m.addedNodes), ...Array.from(m.removedNodes)];
      return nodes.some(n => n.nodeType === 1 && n.classList.contains('yd_slide-clone'));
    });
    if (isCloneMutation) return;

    if (this.mutationRaf && typeof cancelAnimationFrame === 'function') {
      cancelAnimationFrame(this.mutationRaf);
    }
    
    if (typeof requestAnimationFrame === 'function') {
      this.mutationRaf = requestAnimationFrame(() => {
        if (this.destroyed) return;
        const structureChanged = mutations.some(m => m.type === 'childList');
        this.updateMeasurements();
        if (structureChanged) {
          this.initPlugins(); 
        }
      });
    } else {
      if (this.destroyed) return;
      const structureChanged = mutations.some(m => m.type === 'childList');
      this.updateMeasurements();
      if (structureChanged) {
        this.initPlugins();
      }
    }
  }

  getPointerPos(e) { return this.options.vertical ? e.clientY : e.clientX; }

  _registerKeyboard() {
    if (!this._keyboardRegistered) {
      ydCarousel._keyboardUsers++;
      this._keyboardRegistered = true;
      if (!ydCarousel._keyboardInitialized) {
        if (ydCarousel.hasDOM()) {
          document.addEventListener('keydown', ydCarousel._globalKeyDownHandler);
        }
        ydCarousel._keyboardInitialized = true;
      }
    }
  }

  _unregisterKeyboard() {
    if (this._keyboardRegistered) {
      ydCarousel._keyboardUsers--;
      this._keyboardRegistered = false;
      if (ydCarousel._keyboardUsers <= 0) {
        if (ydCarousel.hasDOM()) {
          document.removeEventListener('keydown', ydCarousel._globalKeyDownHandler);
        }
        ydCarousel._keyboardInitialized = false;
        ydCarousel._keyboardUsers = 0;
      }
    }
  }

  bindEvents() {
    this.track.addEventListener('pointerdown', this.onPointerDown);
    this.track.addEventListener('click', this.onClick, { capture: true });
    
    this.root.addEventListener('mouseenter', this.onActivate);
    this.root.addEventListener('focusin', this.onActivate);
    this.root.addEventListener('mouseleave', this.onDeactivate);
    this.root.addEventListener('focusout', this.onDeactivate);
    this.track.addEventListener('pointerdown', this.onActivate);

    if (this.options.keyboard) {
      this.root.setAttribute('tabindex', '0');
      this._registerKeyboard();
    }
  }

  unbindEvents() {
    this.track.removeEventListener('pointerdown', this.onPointerDown);
    this.track.removeEventListener('click', this.onClick, { capture: true });
    if (ydCarousel.hasDOM()) {
      window.removeEventListener('pointermove', this.onPointerMove);
      window.removeEventListener('pointerup', this.onPointerUp);
      window.removeEventListener('pointercancel', this.onPointerUp);
    }
    
    this.root.removeEventListener('mouseenter', this.onActivate);
    this.root.removeEventListener('focusin', this.onActivate);
    this.root.removeEventListener('mouseleave', this.onDeactivate);
    this.root.removeEventListener('focusout', this.onDeactivate);
    this.track.removeEventListener('pointerdown', this.onActivate);

    if (this.options.keyboard) {
      this._unregisterKeyboard();
    }
  }

  onPointerDown(e) {
    if (e.button !== 0 || this._isPaused || this._isFrozen) return; 
    this.isDraggingActive = true;
    this.dragState.active = true;
    this.dragState.startLogicalIndex = this.currentIndex;
    this.dragState.currentLogicalIndex = this.currentIndex;
    this.dragState.startPointer = this.getPointerPos(e);
    this.dragState.startTargetPos = this.targetPos;

    this.activePointerId = e.pointerId;
    this.isClickSuppressed = false;

    this.targetPos = this.currentPos;
    this.dragStartPos = this.getPointerPos(e);
    this.dragStartCurrentPos = this.currentPos;
    
    this.lastPointerPos = this.getPointerPos(e);
    this.lastPointerTime = ydCarousel._now();
    this._velocity = 0;
    this.inertia = 0; 

    this.previewIndex = this.currentIndex;
    this.previewGroup = this.currentGroup;

    try {
      this.track.setPointerCapture(e.pointerId);
    } catch (err) {}
    this.track.style.cursor = 'grabbing';
    
    if (ydCarousel.hasDOM()) {
      window.addEventListener('pointermove', this.onPointerMove);
      window.addEventListener('pointerup', this.onPointerUp);
      window.addEventListener('pointercancel', this.onPointerUp);
    }
    
    this._wake();
    this.emit('dragStart');
    e.preventDefault(); 
  }

  onPointerMove(e) {
    if (!this.isDraggingActive) return;
    const currentPointer = this.getPointerPos(e);
    
    let dragDistance = this.dragStartPos - currentPointer;
    if (!this.options.vertical) dragDistance *= this.dir;
    if (Math.abs(dragDistance) > this.options.dragThreshold) this.isClickSuppressed = true;

    const now = ydCarousel._now();
    const dt = now - this.lastPointerTime;
    if (dt > 0) {
      let rawVel = (this.lastPointerPos - currentPointer) / dt;
      if (!this.options.vertical) rawVel *= this.dir;
      this._velocity = rawVel;
    }
    this.lastPointerPos = currentPointer;
    this.lastPointerTime = now;

    let newTarget = this.dragStartCurrentPos + dragDistance;

    if (!this.options.loop) {
      if (newTarget < 0) newTarget *= 0.3;
      else if (newTarget > this.maxScroll) newTarget = this.maxScroll + ((newTarget - this.maxScroll) * 0.3);
    }

    this.targetPos = newTarget;
    this.updateDragLogicalIndex();
    this._wake();
    this.emit('dragMove');

    const nearest = this.findNearestSlide(this.targetPos);
    if (nearest !== this.previewIndex) {
      this.previewIndex = nearest;
      this.emit('previewUpdate');
    }
  }

  onPointerUp(e) {
    if (!this.isDraggingActive) return;
    this.isDraggingActive = false;
    this.dragState.active = false;
    
    setTimeout(() => { this.isClickSuppressed = false; }, 50);

    const pid = e && e.pointerId !== undefined ? e.pointerId : this.activePointerId;
    if (pid !== undefined) {
      try { this.track.releasePointerCapture(pid); } catch(err) {}
    }
    this.activePointerId = undefined;
    this.track.style.cursor = '';

    if (ydCarousel.hasDOM()) {
      window.removeEventListener('pointermove', this.onPointerMove);
      window.removeEventListener('pointerup', this.onPointerUp);
      window.removeEventListener('pointercancel', this.onPointerUp);
    }
    this.emit('dragEnd');

    if (this.reducedMotion) {
      this.inertia = 0;
      this.snapToClosest();
      return;
    }

    if (this.options.dragFree) {
      this.inertia = this._velocity * this.options.dragInertia; 
    } else {
      if (Math.abs(this._velocity) > this.options.velocityThreshold) {
        this._velocity > 0 ? this.scrollNext() : this.scrollPrev();
      } else {
        this.snapToClosest();
      }
    }
  }

  onClick(e) {
    if (this.isClickSuppressed) {
      e.preventDefault();
      e.stopPropagation();
    }
  }

  onKeyDown(e) {
    if ((ydCarousel.activeCarousel && ydCarousel.activeCarousel !== this) || this._isPaused || this._isFrozen) return;

    const activeElement = ydCarousel.hasDOM() ? document.activeElement : null;
    const ignoreTags = ['INPUT', 'TEXTAREA', 'SELECT', 'OPTION'];
    if (activeElement) {
      const isInputTag = ignoreTags.includes(activeElement.tagName);
      const isEditable = activeElement.isContentEditable;
      
      if (isInputTag || isEditable) {
        return; 
      }
    }

    const keys = ['Home', 'End', 'PageDown', 'PageUp', 'ArrowRight', 'ArrowLeft', 'ArrowDown', 'ArrowUp'];
    if (keys.includes(e.key)) {
      e.preventDefault();
    }

    const isRtl = this.isRTL;
    const isVert = this.options.vertical;
    
    if (e.key === 'Home') this.options.slideSnap ? this.goToSlide(0) : this.goToGroup(0);
    if (e.key === 'End') this.options.slideSnap ? this.goToSlide(this.logicalSlideCount() - 1) : this.goToGroup(this.groupCount() - 1);
    
    if (e.key === 'PageDown') this.scrollNext();
    if (e.key === 'PageUp') this.scrollPrev();

    if (e.key === 'ArrowRight' && !isVert) isRtl ? this.scrollPrev() : this.scrollNext();
    if (e.key === 'ArrowLeft' && !isVert) isRtl ? this.scrollNext() : this.scrollPrev();
    if (e.key === 'ArrowDown' && isVert) this.scrollNext();
    if (e.key === 'ArrowUp' && isVert) this.scrollPrev();
  }

  startPhysicsLoop() {
    if (typeof requestAnimationFrame !== 'function') return;
    if (this.rafId) cancelAnimationFrame(this.rafId);
    this.rafId = requestAnimationFrame(this.tick);
  }

  tick() {
    if (this.destroyed || this._isPaused || this._isFrozen) {
      this.rafId = null;
      return;
    }
    
    this._stats.renderTicks++;

    const isLoopActive = this.options.loop && this.metrics.slideSnaps.length > 0;

    if (isLoopActive) {
      const firstSnap = this.metrics.prependOffset;
      const lastSnap = this.metrics.prependOffset + this.metrics.realTrackSize;
      const buffer = this.metrics.realTrackSize * 0.02;
      
      if (this.targetPos < firstSnap - buffer) {
        this.emit('loopEnter', { position: 'start' });
        const from = this.currentPos;
        this.currentPos += this.metrics.realTrackSize;
        this.targetPos += this.metrics.realTrackSize;
        if (!this.isDraggingActive) {
          this.inertia *= 0.5;
        }
        this.emit('loopReposition', { from, to: this.currentPos }); 
        this.emit('loopExit', { position: 'end' });
      } else if (this.targetPos > lastSnap + buffer) {
        this.emit('loopEnter', { position: 'end' });
        const from = this.currentPos;
        this.currentPos -= this.metrics.realTrackSize;
        this.targetPos -= this.metrics.realTrackSize;
        if (!this.isDraggingActive) {
          this.inertia *= 0.5;
        }
        this.emit('loopReposition', { from, to: this.currentPos }); 
        this.emit('loopExit', { position: 'start' });
      }
    }

    if (this.virtual.enabled && this.approachingWindowEdge()) {
      this.midFlightRebalance();
    }

    if (this.options.dragFree && Math.abs(this.inertia) > 0.1 && !this.isDraggingActive) {
      this.inertia *= this.options.friction;
      this.targetPos += this.inertia;
      
      if (!this.options.loop) {
        if (this.targetPos < 0) {
          this.targetPos *= 0.8;
          this.inertia *= 0.5;
        } else if (this.targetPos > this.maxScroll) {
          this.targetPos = this.maxScroll + ((this.targetPos - this.maxScroll) * 0.8);
          this.inertia *= 0.5;
        }
      }
    } else if (this.options.dragFree && !this.options.loop && !this.isDraggingActive) {
      if (this.targetPos < 0) this.targetPos = 0;
      if (this.targetPos > this.maxScroll) this.targetPos = this.maxScroll;
    }

    const diff = this.targetPos - this.currentPos;
    
    if (Math.abs(diff) < 0.1 && Math.abs(this.inertia) < 0.1) {
      this.currentPos = this.targetPos;
      if (!this.isSettled) {
        this.isSettled = true;
        this.emit('settle');
      }
    } else {
      this.isSettled = false;
      this.currentPos += diff * this.options.duration;
    }

    if (this.dragState.active) {
      this.validateDragPosition();
    }

    const transformVal = this.getTransformValue();
    
    if (this.options.vertical) {
      this.track.style.transform = `translate3d(0, ${transformVal}px, 0)`;
    } else {
      this.track.style.transform = `translate3d(${transformVal}px, 0, 0)`;
    }

    this.emit('scroll');
    
    if (!this.isSettled && typeof requestAnimationFrame === 'function') {
      this.rafId = requestAnimationFrame(this.tick);
    }
  }

  destroy() {
    if (this.destroyed) return;

    // Emit 'destroy' event FIRST while valid instance state and plugin references are intact
    this.emit('destroy');

    this.destroyed = true; 
    if (this.rafId && typeof cancelAnimationFrame === 'function') cancelAnimationFrame(this.rafId);
    if (this.mutationRaf && typeof cancelAnimationFrame === 'function') cancelAnimationFrame(this.mutationRaf);
    this.rafId = null;
    this.mutationRaf = null;
    
    this.root.removeAttribute('data-direction');

    this.unbindEvents();
    if (this.resizeObserver) { this.resizeObserver.disconnect(); this.resizeObserver = null; }
    if (this.mutationObserver) { this.mutationObserver.disconnect(); this.mutationObserver = null; }
    if (this.visibilityObserver) { this.visibilityObserver.disconnect(); this.visibilityObserver = null; }
    
    if (this.rootVisibilityObserver) { 
      this.rootVisibilityObserver.disconnect(); 
      this.rootVisibilityObserver = null; 
    }
    if (ydCarousel.hasDOM()) {
      document.removeEventListener('visibilitychange', this._docVisHandler);
    }

    if (this.announceHandler) this.off('select', this.announceHandler);

    this.plugins.forEach(p => p.destroy && p.destroy(this));
    this.plugins = []; 
    
    [...this.activePlugins.keys()].forEach(name => this.disablePlugin(name));

    this.root.classList.remove('yd_carousel-ready');
    this.track.style.transform = '';
    this._purgeClones();

    if (this.root.__ydCarousel === this) {
      delete this.root.__ydCarousel;
    }
    
    if (ydCarousel.activeCarousel === this) {
      ydCarousel.activeCarousel = null;
      if (ydCarousel.hasDOM()) {
        const readyCarousels = Array.from(document.querySelectorAll('.yd_carousel-ready'))
          .map(el => el.__ydCarousel)
          .filter(api => api && api !== this && !api.destroyed);
        
        if (readyCarousels.length > 0) {
          const withKeyboard = readyCarousels.find(api => api.options.keyboard);
          ydCarousel.activeCarousel = withKeyboard || readyCarousels[0];
        }
      }
    }

    ydCarousel._instances.delete(this); 
    this.listeners = {}; 
    this._eventStats = {};
    this._pluginErrorTracker.clear();
    
    this.slides = [];
    this.visibleSlides.clear();
    this.activePlugins.clear();
    
    this.currentPos = 0;
    this.targetPos = 0;
    this._velocity = 0;
    this.inertia = 0;
    this.previewIndex = 0;
    this.previewGroup = 0;
    this.maxScroll = 0;
    this._manualFrozen = false;

    this.dragState = {
      active: false,
      startLogicalIndex: 0,
      currentLogicalIndex: 0,
      startPointer: 0,
      startTargetPos: 0
    };
    
    this.metrics.viewportSize = 0;
    this.metrics.trackSize = 0;
    this.metrics.realTrackSize = 0;
    this.metrics.prependOffset = 0;
    this.metrics.gap = 0;
    this.metrics.averageSlideSize = 0;
    this.metrics.slideSizes = [];
    this.metrics.slideOffsets = [];
    this.metrics.slideSnaps = [];
    this.metrics.groupSnaps = [];
    this.metrics.snapPoints = [];

    this.virtual.logicalSlides = [];
    this.virtual.renderedSlides = [];
    this.virtual.windowSlides = [];
    this.virtual.lastWindow = [];
    this.virtual.logicalGroups = [];
    this.virtual.groupSnaps = [];
    this.virtual.windowStart = 0;
    this.virtual.windowEnd = 0;
    this.virtual.slidesPerView = 0;
    this.virtual.buffer = 0;
    this.virtual.windowSize = 0;
    this.virtual.renderIndex = 0;
    this.virtual.pendingRebalance = null;
    this.virtual.lastRebalanceIndex = -1;
  }

  goToGroup(groupIndex, immediate = false, force = false) {
    if (!this.groupCount() || ((this._isPaused || this._isFrozen) && !force)) return;
    const maxGroup = this.groupCount() - 1;
    const targetGroup = Math.max(0, Math.min(groupIndex, maxGroup));
    
    const logicalIndex = this.virtual.logicalGroups[targetGroup];
    this.goToSlide(logicalIndex, immediate, force);
  }

  goToSlide(slideIndex, immediate = false, force = false) {
    if (!this.metrics.slideSnaps.length || ((this._isPaused || this._isFrozen) && !force)) return;
    const maxSlide = this.logicalSlideCount() - 1;
    const targetSlide = Math.max(0, Math.min(slideIndex, maxSlide));

    const changed = (this.currentIndex !== targetSlide);

    if (changed) {
      this.emit('beforeSelect', { currentIndex: this.currentIndex, targetIndex: targetSlide });
      this.prevIndex = this.currentIndex;
      this.currentIndex = targetSlide;
      this.virtual.lastRebalanceIndex = -1;

      if (this.virtual.enabled) {
        this.updateVirtualRenderer(this.currentIndex);
      }

      this.previewIndex = this.currentIndex;
      this.emit('activeSlideChange', { currentIndex: this.currentIndex, previousIndex: this.prevIndex });
    }
    
    const safeSnapIndex = Math.min(this.currentIndex, this.metrics.slideSnaps.length - 1);
    const rawTarget = this.metrics.slideSnaps[safeSnapIndex];
    
    let nextTarget = rawTarget;
    this.inertia = 0; 

    if (this.options.loop && !immediate) {
      const distNormal = nextTarget - this.targetPos;
      const distForward = (nextTarget + this.metrics.realTrackSize) - this.targetPos;
      const distBackward = (nextTarget - this.metrics.realTrackSize) - this.targetPos;
      const minDist = Math.min(Math.abs(distNormal), Math.abs(distForward), Math.abs(distBackward));
      
      if (minDist === Math.abs(distForward)) nextTarget += this.metrics.realTrackSize;
      else if (minDist === Math.abs(distBackward)) nextTarget -= this.metrics.realTrackSize;
    }

    this.targetPos = nextTarget;

    if (immediate) {
      this.inertia = 0;
      this._velocity = 0;
      this.currentPos = this.targetPos;
      const transformVal = this.getTransformValue();
      this.track.style.transform = this.options.vertical 
        ? `translate3d(0, ${transformVal}px, 0)` 
        : `translate3d(${transformVal}px, 0, 0)`;
        
      if (!this.isSettled) {
        this.isSettled = true;
        this.emit('settle');
      }
    } else {
      this._wake();
    }

    const targetGroup = this.getGroupForLogicalIndex(this.currentIndex);
    
    if (this.currentGroup !== targetGroup) {
       this.prevGroup = this.currentGroup;
       this.currentGroup = targetGroup;
       this.previewGroup = this.currentGroup;
       this.emit('activeGroupChange', { currentGroup: this.currentGroup, previousGroup: this.prevGroup });
    }
    
    this.updateSlideStates();
    this.updateAutoHeight();

    if (changed) {
      this.emit('select');
      this.emit('afterSelect'); 
    }
  }

  snapToClosest(immediate = false, force = false) {
    let closestIndex = 0;
    let minDistance = Infinity;
    
    this.metrics.slideSnaps.forEach((point, index) => {
      const d1 = Math.abs(point - this.targetPos);
      const d2 = this.options.loop ? Math.abs((point + this.metrics.realTrackSize) - this.targetPos) : Infinity;
      const d3 = this.options.loop ? Math.abs((point - this.metrics.realTrackSize) - this.targetPos) : Infinity;
      const distance = Math.min(d1, d2, d3);
      if (distance < minDistance) {
        minDistance = distance;
        closestIndex = index;
      }
    });

    if (this.options.dragFree) {
       this.targetPos = this.metrics.slideSnaps[closestIndex];
       if (immediate) {
         this.currentPos = this.targetPos;
         const transformVal = this.getTransformValue();
         this.track.style.transform = this.options.vertical 
           ? `translate3d(0, ${transformVal}px, 0)` 
           : `translate3d(${transformVal}px, 0, 0)`;
         if (!this.isSettled) {
           this.isSettled = true;
           this.emit('settle');
         }
       } else {
         this._wake();
       }
    } else {
       if (this.virtual.enabled) {
         const slide = this.getRenderedSlide(closestIndex);
         if (slide) {
           closestIndex = parseInt(slide.getAttribute('data-slide-index'), 10);
         }
       }

       if (this.options.slideSnap) {
         this.goToSlide(closestIndex, immediate, force);
       } else {
         const group = this.getGroupForLogicalIndex(closestIndex);
         this.goToGroup(group, immediate, force);
       }
    }
  }

  scrollNext(force = false) {
    if (!this.logicalSlideCount()) return;
    if ((this._isPaused || this._isFrozen) && !force) return;
    
    if (this.options.slideSnap) {
      if (this.options.loop) {
        this.goToSlide((this.currentIndex + 1) % this.logicalSlideCount(), false, force);
      } else {
        this.goToSlide(Math.min(this.currentIndex + 1, this.logicalSlideCount() - 1), false, force);
      }
      return;
    }
    
    if (this.currentGroup < this.groupCount() - 1) {
      this.goToGroup(this.currentGroup + 1, false, force);
    } else if (this.options.loop && this.canScrollNext()) {
      this.goToGroup(0, false, force);
    }
  }

  scrollPrev(force = false) {
    if (!this.logicalSlideCount()) return;
    if ((this._isPaused || this._isFrozen) && !force) return;
    
    if (this.options.slideSnap) {
      if (this.options.loop) {
        this.goToSlide((this.currentIndex - 1 + this.logicalSlideCount()) % this.logicalSlideCount(), false, force);
      } else {
        this.goToSlide(Math.max(this.currentIndex - 1, 0), false, force);
      }
      return;
    }
    
    if (this.currentGroup > 0) {
      this.goToGroup(this.currentGroup - 1, false, force);
    } else if (this.options.loop && this.canScrollPrev()) {
      this.goToGroup(this.groupCount() - 1, false, force);
    }
  }

  updateSlideStates() {
    // RENDERED DOM COUNT
    if (!this.renderedSlideCount()) return;

    // LOGICAL COUNT
    const total = this.logicalSlideCount();
    const prevIdx = this.options.loop ? (total + this.currentIndex - 1) % total : this.currentIndex - 1;
    const nextIdx = this.options.loop ? (this.currentIndex + 1) % total : this.currentIndex + 1;

    let visualPrev = prevIdx;
    let visualNext = nextIdx;
    if (this.isRTL && !this.options.vertical) {
      visualPrev = nextIdx;
      visualNext = prevIdx;
    }

    const activeRenderIndex = this.virtual.enabled ? this.virtual.renderIndex : this.currentIndex;
    const prevRenderIndex = this.virtual.enabled ? this.resolveRenderIndex(visualPrev) : visualPrev;
    const nextRenderIndex = this.virtual.enabled ? this.resolveRenderIndex(visualNext) : visualNext;

    // RENDERED DOM COUNT
    this.slides.forEach((slide, idx) => {
      slide.classList.remove('active', 'prev', 'next');
      slide.removeAttribute('aria-current');
      
      slide.setAttribute('role', 'group');
      slide.setAttribute('aria-roledescription', 'slide');
      // LOGICAL COUNT usage
      slide.setAttribute('aria-label', `${idx + 1} of ${total}`);

      if (idx === activeRenderIndex) {
        slide.classList.add('active');
        slide.setAttribute('aria-current', 'true');
        slide.setAttribute('tabindex', '0');
      } else {
        if (idx === prevRenderIndex) slide.classList.add('prev');
        else if (idx === nextRenderIndex) slide.classList.add('next');
        slide.setAttribute('tabindex', '-1');
      }
    });

    if (this.options.loop) {
      const clones = this.track.querySelectorAll('.yd_slide-clone');
      clones.forEach(clone => {
        const idx = parseInt(clone.getAttribute('data-slide-index'), 10);
        clone.classList.remove('active', 'prev', 'next');
        clone.removeAttribute('aria-current');
        clone.setAttribute('aria-hidden', 'true');
        if ('inert' in clone) clone.inert = true;
        
        if (idx === this.currentIndex) {
          clone.classList.add('active');
        } else if (idx === prevIdx) {
          clone.classList.add('prev');
        } else if (idx === nextIdx) {
          clone.classList.add('next');
        }
      });
    }

    if (this.options.focusOnChange && ydCarousel.hasDOM() && this.root.contains(document.activeElement)) {
      this.focusActiveSlide();
    }
  }
  
  updateAutoHeight() {
    if (!this.options.autoHeight) return;
    // RENDERED LOOKUP
    const activeIdx = this.virtual.enabled ? this.virtual.renderIndex : this.currentIndex;
    const slide = this.getRenderedSlide(activeIdx);
    if (!slide) return;
    
    const height = slide.offsetHeight;
    if (height <= 0) return;
    
    const viewport = this.root.querySelector('.yd_viewport') || this.root;
    viewport.style.height = height + 'px';
  }

  _initCorePlugin(plugin) {
    if (!plugin || !plugin.name) return;
    try {
      plugin.init(this);
      this.plugins.push(plugin);
      this._pluginErrorTracker.delete(plugin.name);
    } catch (err) {
      this._recordPluginError(plugin.name, err);
      console.error(`[ydCarousel] Error initializing core plugin "${plugin.name}":`, err);
    }
  }

  enablePlugin(name) {
    if (this.activePlugins.has(name)) return;
    const pluginDef = ydCarousel._pluginRegistry.get(name);
    if (!pluginDef) return;

    const deps = pluginDef.dependencies || pluginDef.requires || [];
    const activeNames = new Set([
      ...this.plugins.map(p => p.name).filter(Boolean),
      ...Array.from(this.activePlugins.keys())
    ]);

    const missing = deps.filter(d => !activeNames.has(d));
    if (missing.length > 0) {
      console.warn(`[ydCarousel] Cannot enable plugin "${name}": missing dependencies [${missing.join(', ')}]`);
      return; 
    }

    try {
      const instance = pluginDef.init(this);
      this.activePlugins.set(name, { def: pluginDef, instance });
      this._pluginErrorTracker.delete(name);
      this.emit('pluginEnabled', { name });
    } catch (err) {
      this._recordPluginError(name, err);
      console.error(`[ydCarousel] Error enabling plugin "${name}":`, err);
    }
  }

  disablePlugin(name) {
    const active = this.activePlugins.get(name);
    if (active) {
      if (active.def.destroy) {
        try {
          active.def.destroy(this, active.instance);
        } catch (err) {
          this._recordPluginError(name, err);
          console.error(`[ydCarousel] Error disabling plugin "${name}":`, err);
        }
      }
      this.activePlugins.delete(name);
      this.emit('pluginDisabled', { name });
    }
  }

  initEnterprisePlugins() {
    const circular = this.circularDetection();
    if (circular.length > 0) {
      console.error('[ydCarousel] Circular plugin dependencies detected:', circular);
      return;
    }

    const registry = ydCarousel._pluginRegistry;
    const order = [];
    const visited = new Set();
    const visiting = new Set();

    const visit = (name) => {
      if (visiting.has(name)) return; 
      if (visited.has(name)) return;
      
      visiting.add(name);
      const def = registry.get(name);
      if (def) {
        const deps = def.dependencies || def.requires || [];
        deps.forEach(dep => visit(dep));
      }
      
      visiting.delete(name);
      visited.add(name);
      order.push(name);
    };

    registry.forEach((_, name) => visit(name));
    order.forEach(name => this.enablePlugin(name));
  }

  initPlugins() {
    this.plugins.forEach(p => p.destroy && p.destroy(this));
    this.plugins = [];

    // CONTROLS (Prev/Next)
    const prevBtn = this.root.querySelector('.yd_prev');
    const nextBtn = this.root.querySelector('.yd_next');
    if (prevBtn || nextBtn) {
      const controls = (() => {
        let hPrev, hNext;
        return {
          name: 'controls',
          init: (api) => {
            hPrev = () => { if (!api.isPaused() && !api.isFrozen()) api.scrollPrev(); };
            hNext = () => { if (!api.isPaused() && !api.isFrozen()) api.scrollNext(); };
            if (prevBtn) {
              prevBtn.addEventListener('click', hPrev);
              prevBtn.setAttribute('aria-controls', api.track.id);
            }
            if (nextBtn) {
              nextBtn.addEventListener('click', hNext);
              nextBtn.setAttribute('aria-controls', api.track.id);
            }
          },
          destroy: () => {
            if (prevBtn) prevBtn.removeEventListener('click', hPrev);
            if (nextBtn) nextBtn.removeEventListener('click', hNext);
          }
        };
      })();
      this._initCorePlugin(controls);
    }

    // CUSTOM HTML DOTS
    const dotsContainer = this.root.querySelector('.yd_dots');
    if (dotsContainer) {
      const dots = (() => {
        let updateDots;
        return {
          name: 'dots',
          init: (api) => {
            const template = dotsContainer.querySelector('.yd_dot');
            dotsContainer.innerHTML = '';
            dotsContainer.setAttribute('role', 'tablist');
            dotsContainer.setAttribute('aria-orientation', api.options.vertical ? 'vertical' : 'horizontal');
            
            const totalDots = api.options.slideSnap ? api.logicalSlideCount() : api.groupCount();
            const dotsArray = new Array(totalDots).fill(0);

            dotsArray.forEach((_, idx) => {
              let dot = template ? template.cloneNode(true) : document.createElement('button');
              if (!template) dot.className = 'yd_dot';
              dot.setAttribute('role', 'tab');
              dot.setAttribute('aria-controls', api.track.id);
              dot.setAttribute('aria-label', `Go to ${api.options.slideSnap ? 'slide' : 'group'} ${idx + 1}`);
              
              dot.addEventListener('click', () => {
                if (api.isPaused() || api.isFrozen()) return;
                if (api.options.slideSnap) api.goToSlide(idx);
                else api.goToGroup(idx);
              });
              
              dot.addEventListener('keydown', (e) => {
                if (api.isPaused() || api.isFrozen()) return;
                const nextKey = api.isRTL ? 'ArrowLeft' : 'ArrowRight';
                const prevKey = api.isRTL ? 'ArrowRight' : 'ArrowLeft';

                if (e.key === nextKey || e.key === prevKey) {
                  e.preventDefault();
                  let targetIdx = idx;
                  if (e.key === nextKey) {
                    targetIdx = (idx + 1) % totalDots;
                  } else if (e.key === prevKey) {
                    targetIdx = (idx - 1 + totalDots) % totalDots;
                  }
                  const targetDot = dotsContainer.children[targetIdx];
                  if (targetDot) targetDot.focus();
                  if (api.options.slideSnap) api.goToSlide(targetIdx);
                  else api.goToGroup(targetIdx);
                }

                if (e.key === 'Home') {
                  e.preventDefault();
                  const targetDot = dotsContainer.children[0];
                  if (targetDot) targetDot.focus();
                  if (api.options.slideSnap) api.goToSlide(0);
                  else api.goToGroup(0);
                }

                if (e.key === 'End') {
                  e.preventDefault();
                  const lastIdx = totalDots - 1;
                  const targetDot = dotsContainer.children[lastIdx];
                  if (targetDot) targetDot.focus();
                  if (api.options.slideSnap) api.goToSlide(lastIdx);
                  else api.goToGroup(lastIdx);
                }
              });
              
              dotsContainer.appendChild(dot);
            });
            
            updateDots = (api, payload) => {
              const activeIdx = api.options.slideSnap 
                ? (payload.previewIndex !== undefined ? payload.previewIndex : payload.currentIndex)
                : (payload.previewGroup !== undefined ? payload.previewGroup : payload.currentGroup);

              Array.from(dotsContainer.children).forEach((dot, idx) => {
                const isActive = idx === activeIdx;
                dot.classList.toggle('active', isActive);
                dot.setAttribute('aria-selected', isActive ? 'true' : 'false');
                dot.setAttribute('tabindex', isActive ? '0' : '-1');
                dot.removeAttribute('aria-current');
              });
            };
            api.on('select', updateDots);
            api.on('activeGroupChange', updateDots);
            api.on('activeSlideChange', updateDots);
            api.on('previewUpdate', updateDots); 
            updateDots(api, api.getEventPayload());
          },
          destroy: (api) => {
            api.off('select', updateDots);
            api.off('activeGroupChange', updateDots);
            api.off('activeSlideChange', updateDots);
            api.off('previewUpdate', updateDots);
          }
        };
      })();
      this._initCorePlugin(dots);
    }

    // CUSTOM HTML COUNTER
    const counterEl = this.root.querySelector('.yd_counter');
    if (counterEl) {
      const counter = (() => {
        let updateCounter;
        return {
          name: 'counter',
          init: (api) => {
            const currentEl = counterEl.querySelector('.yd_current');
            const totalEl = counterEl.querySelector('.yd_total');
            
            updateCounter = (api, payload) => {
              const current = api.options.slideSnap 
                ? (payload.previewIndex !== undefined ? payload.previewIndex : payload.currentIndex) + 1 
                : (payload.previewGroup !== undefined ? payload.previewGroup : payload.currentGroup) + 1;
              const total = api.options.slideSnap ? api.logicalSlideCount() : api.groupCount();

              if (currentEl && totalEl) {
                currentEl.textContent = current;
                totalEl.textContent = total;
              } else {
                counterEl.textContent = `${current} / ${total}`;
              }
            };
            api.on('select', updateCounter);
            api.on('activeGroupChange', updateCounter);
            api.on('activeSlideChange', updateCounter);
            api.on('previewUpdate', updateCounter); 
            updateCounter(api, api.getEventPayload());
          },
          destroy: (api) => {
            api.off('select', updateCounter);
            api.off('activeGroupChange', updateCounter);
            api.off('activeSlideChange', updateCounter);
            api.off('previewUpdate', updateCounter);
          }
        };
      })();
      this._initCorePlugin(counter);
    }

    // SCROLLBAR CONTROL 
    const scrollbar = this.root.querySelector('.yd_scrollbar');
    if (scrollbar) {
      const sbPlugin = (() => {
        let updateThumbSize, updateProgress, onClickTrack;
        let onThumbDown, onThumbMove, onThumbUp, onApiPause;
        let isDraggingThumb = false;
        let isDisabled = false;
        let startPointerPos = 0;
        let startProgress = 0;
        let thumbRef = null;

        const logicalToVisual = (api, progress) => {
          return (api.isRTL && !api.options.vertical) ? 1 - progress : progress;
        };

        const visualToLogical = (api, progress) => {
          return (api.isRTL && !api.options.vertical) ? 1 - progress : progress;
        };

        return {
          name: 'scrollbar',
          init: (api) => {
            if (api.options.loop) {
              console.warn('[ydCarousel] Scrollbar disabled: Absolute scrollbars cannot be mapped to infinite loops.');
              scrollbar.style.display = 'none';
              return;
            }

            let thumb = scrollbar.querySelector('.yd_scrollbar-thumb');
            
            if (!thumb) {
              thumb = document.createElement('div');
              thumb.className = 'yd_scrollbar-thumb';
              scrollbar.appendChild(thumb);
            }
            thumbRef = thumb;

            scrollbar.setAttribute('role', 'scrollbar');
            scrollbar.setAttribute('aria-controls', api.track.id);

            updateThumbSize = () => {
              if (api.metrics.realTrackSize <= api.metrics.viewportSize) {
                isDisabled = true;
                scrollbar.classList.add('disabled');
                scrollbar.setAttribute('aria-disabled', 'true');
                thumb.setAttribute('tabindex', '-1');
                if (api.options.vertical) {
                  thumb.style.height = '100%';
                  thumb.style.width = '';
                } else {
                  thumb.style.width = '100%';
                  thumb.style.height = '';
                }
                thumb.style.transform = 'translate3d(0,0,0)'; 
              } else {
                isDisabled = false;
                scrollbar.classList.remove('disabled');
                scrollbar.removeAttribute('aria-disabled');
                thumb.removeAttribute('tabindex');
                const ratio = api.metrics.viewportSize / (api.metrics.realTrackSize || 1);
                const sizePct = `${Math.max(10, Math.min(100, ratio * 100))}%`;
                if (api.options.vertical) {
                  thumb.style.height = sizePct;
                  thumb.style.width = '';
                } else {
                  thumb.style.width = sizePct;
                  thumb.style.height = '';
                }
              }
            };

            updateProgress = (api, payload) => {
              const valNum = Math.round(payload.progress * 100);
              scrollbar.setAttribute('aria-valuenow', valNum);
              scrollbar.setAttribute('aria-valuemin', '0');
              scrollbar.setAttribute('aria-valuemax', '100');

              if (isDisabled || isDraggingThumb) return; 
              
              const movableSpace = api.options.vertical
                ? scrollbar.offsetHeight - thumb.offsetHeight
                : scrollbar.offsetWidth - thumb.offsetWidth;
              
              const visualProgress = payload.visualProgress !== undefined ? payload.visualProgress : api.getVisualProgress();
              
              if (api.options.vertical) {
                thumb.style.transform = `translate3d(0, ${visualProgress * movableSpace}px, 0)`;
              } else {
                thumb.style.transform = `translate3d(${visualProgress * movableSpace}px, 0, 0)`;
              }
            };

            onClickTrack = (e) => {
              if (isDisabled || e.target === thumb || api.isPaused() || api.isFrozen()) return; 
              const rect = scrollbar.getBoundingClientRect();
              
              const raw = api.options.vertical
                ? (e.clientY - rect.top) / rect.height
                : (e.clientX - rect.left) / rect.width;
              
              const pct = visualToLogical(api, raw);
              
              api.targetPos = pct * api.maxScroll;
              api.snapToClosest();
            };

            onThumbDown = (e) => {
              if (isDisabled || e.button !== 0 || api.isPaused() || api.isFrozen()) return;
              e.preventDefault();
              e.stopPropagation();
              isDraggingThumb = true;
              startPointerPos = api.options.vertical ? e.clientY : e.clientX;
              startProgress = api.scrollProgress();

              api.previewIndex = api.currentIndex;
              api.previewGroup = api.currentGroup;

              try {
                thumb.setPointerCapture(e.pointerId);
              } catch (err) {}
              thumb.style.cursor = 'grabbing';
              
              if (ydCarousel.hasDOM()) {
                document.addEventListener('pointermove', onThumbMove);
                document.addEventListener('pointerup', onThumbUp);
                document.addEventListener('pointercancel', onThumbUp);
              }
              
              api.emit('dragStart');
            };

            onThumbMove = (e) => {
              if (!isDraggingThumb) return;
              const movableSpace = api.options.vertical
                ? scrollbar.offsetHeight - thumb.offsetHeight
                : scrollbar.offsetWidth - thumb.offsetWidth;
              if (movableSpace <= 0) return;
              
              const currentPointer = api.options.vertical ? e.clientY : e.clientX;
              const delta = currentPointer - startPointerPos;
              
              const thumbVisualStart = logicalToVisual(api, startProgress);
              const visualProgress = Math.max(0, Math.min(1, thumbVisualStart + (delta / movableSpace)));
              const rawProgress = visualToLogical(api, visualProgress);
              
              if (api.options.vertical) {
                thumb.style.transform = `translate3d(0, ${visualProgress * movableSpace}px, 0)`;
              } else {
                thumb.style.transform = `translate3d(${visualProgress * movableSpace}px, 0, 0)`;
              }
              
              const dragDistance = api.maxScroll;
              let newTarget = rawProgress * dragDistance;
              newTarget = Math.max(0, Math.min(newTarget, api.maxScroll));
              
              api.targetPos = newTarget;
              api.currentPos = newTarget; 
              
              api._wake(); 

              let previewUpdated = false;
              let normalizedTarget = newTarget;
              
              if (api.options.loop && api.metrics.realTrackSize > 0) {
                 normalizedTarget = (((newTarget - api.metrics.prependOffset) % api.metrics.realTrackSize) + api.metrics.realTrackSize) % api.metrics.realTrackSize + api.metrics.prependOffset;
              }

              if (!api.options.slideSnap) {
                let minGroupDist = Infinity, closestGroup = api.previewGroup;
                let distToCurrent = Infinity;
                
                const currentEvalGroup = api.previewGroup !== undefined ? api.previewGroup : api.currentGroup;
                
                if (api.metrics.groupSnaps[currentEvalGroup] !== undefined) {
                   distToCurrent = Math.abs(api.metrics.groupSnaps[currentEvalGroup] - normalizedTarget);
                }

                api.metrics.groupSnaps.forEach((p, i) => {
                   let dist = Math.abs(p - normalizedTarget);
                   if (dist < minGroupDist) { minGroupDist = dist; closestGroup = i; }
                });
                
                const hysteresis = Math.min(12, Math.max(5, api.metrics.viewportSize * 0.01));
                if (currentEvalGroup !== closestGroup && minGroupDist < distToCurrent - hysteresis) {
                   api.previewGroup = closestGroup;
                   previewUpdated = true;
                }
              }

              let nearestSlide = api.findNearestSlide(normalizedTarget);
              const currentEvalSlide = api.previewIndex !== undefined ? api.previewIndex : api.currentIndex;
              
              if (currentEvalSlide !== nearestSlide) {
                 api.previewIndex = nearestSlide;
                 if (api.options.slideSnap) {
                    previewUpdated = true;
                 }
              }

              if (previewUpdated) {
                 api.emit('previewUpdate');
              }
            };

            onThumbUp = (e) => {
              if (!isDraggingThumb) return;
              isDraggingThumb = false;
              
              if (e && e.pointerId !== undefined) {
                try { thumb.releasePointerCapture(e.pointerId); } catch(err) {}
              }
              thumb.style.cursor = '';
              
              if (ydCarousel.hasDOM()) {
                document.removeEventListener('pointermove', onThumbMove);
                document.removeEventListener('pointerup', onThumbUp);
                document.removeEventListener('pointercancel', onThumbUp);
              }
              
              api.previewIndex = api.currentIndex;
              api.previewGroup = api.currentGroup;

              api.emit('dragEnd');
              api.snapToClosest();
            };

            onApiPause = () => {
              if (isDraggingThumb) {
                isDraggingThumb = false;
                thumb.style.cursor = '';
                if (ydCarousel.hasDOM()) {
                  document.removeEventListener('pointermove', onThumbMove);
                  document.removeEventListener('pointerup', onThumbUp);
                  document.removeEventListener('pointercancel', onThumbUp);
                }
                api.emit('dragEnd');
                api.snapToClosest(true, true);
              }
            };

            api.on('resize', updateThumbSize);
            api.on('scroll', updateProgress);
            api.on('pause', onApiPause);
            api.on('freeze', onApiPause); 
            scrollbar.addEventListener('click', onClickTrack);
            thumb.addEventListener('pointerdown', onThumbDown);
            
            updateThumbSize();
            updateProgress(api, api.getEventPayload());
          },
          destroy: (api) => {
            api.off('resize', updateThumbSize);
            api.off('scroll', updateProgress);
            api.off('pause', onApiPause);
            api.off('freeze', onApiPause);
            scrollbar.removeEventListener('click', onClickTrack);
            if (thumbRef) {
              thumbRef.removeEventListener('pointerdown', onThumbDown);
            }
            if (ydCarousel.hasDOM()) {
              document.removeEventListener('pointermove', onThumbMove);
              document.removeEventListener('pointerup', onThumbUp);
              document.removeEventListener('pointercancel', onThumbUp);
            }
          }
        };
      })();
      this._initCorePlugin(sbPlugin);
    }

    // CAROUSEL PROGRESS
    const progressEl = this.root.querySelector('.yd_progress');
    if (progressEl) {
      const progress = (() => {
        let updateProgress;
        return {
          name: 'progress',
          init: (api) => {
            let fill = progressEl.querySelector('.yd_progress-fill');
            if (!fill) {
              fill = document.createElement('div');
              fill.className = 'yd_progress-fill';
              progressEl.appendChild(fill);
            }

            updateProgress = (api, payload) => {
              const pct = api.scrollProgress() * 100;
              progressEl.style.setProperty('--progress', `${pct}%`);
            };
            api.on('scroll', updateProgress);
            updateProgress(api, api.getEventPayload());
          },
          destroy: (api) => api.off('scroll', updateProgress)
        };
      })();
      this._initCorePlugin(progress);
    }

    // AUTOPLAY PROGRESS & SYSTEM
    if (this.options.autoplay) {
      const autoplay = (() => {
        let playTimer, play, stop, stopPermanent, loopProgress, onVisChange, onFocusIn, onFocusOut, pauseTimer, onSettle, resetVisual;
        let onBeforeSelect, onDragStart, onDragEnd, onApiPause, onApiResume; 
        let isPaused = false;
        let hasStarted = false;
        let permanentlyStopped = false; 
        let startTime = 0;
        let animRaf = null;
        let direction = 1; 
        
        return {
          name: 'autoplay',
          init: (api) => {
            direction = api.root.dataset.autoplayDirection === 'backward' ? -1 : 1;

            const apProgressEl = api.root.querySelector('.yd_autoplay-progress');
            if (apProgressEl) {
              let fill = apProgressEl.querySelector('.yd_autoplay-progress-fill');
              if (!fill) {
                fill = document.createElement('div');
                fill.className = 'yd_autoplay-progress-fill';
                apProgressEl.appendChild(fill);
              }
              apProgressEl.style.setProperty('--ap-progress', `0%`);
            }

            resetVisual = () => {
              if (apProgressEl) apProgressEl.style.setProperty('--ap-progress', `0%`); 
            };
            
            loopProgress = () => {
              if (isPaused || api.isPaused() || api.isFrozen()) return;
              const elapsed = ydCarousel._now() - startTime;
              const pct = Math.min(100, (elapsed / api.options.delay) * 100);
              if (apProgressEl) apProgressEl.style.setProperty('--ap-progress', `${pct}%`);
              if (pct < 100 && typeof requestAnimationFrame === 'function') {
                animRaf = requestAnimationFrame(loopProgress);
              }
            };

            stopPermanent = () => {
              if (permanentlyStopped) return;
              permanentlyStopped = true;
              clearTimeout(playTimer);
              if (animRaf && typeof cancelAnimationFrame === 'function') cancelAnimationFrame(animRaf);
              hasStarted = false;
              isPaused = false;
              api.emit('autoplayStop');
            };

            pauseTimer = () => {
              clearTimeout(playTimer);
              if (animRaf && typeof cancelAnimationFrame === 'function') cancelAnimationFrame(animRaf);
            };

            api.autoplayApi = {
              play: () => {
                permanentlyStopped = false;
                isPaused = false;
                play();
              },
              pause: () => {
                if (hasStarted && !isPaused && !permanentlyStopped) {
                  isPaused = true;
                  pauseTimer();
                  api.emit('autoplayPause');
                }
              },
              stop: () => stopPermanent(),
              reset: () => {
                 permanentlyStopped = false;
                 const ready = api.options.slideSnap ? api.logicalSlideCount() > 0 : api.groupCount() > 0;
                 if (!hasStarted && ready) {
                  isPaused = false;
                  play();
                 }
              },
              setDirection: (dir) => {
                direction = (dir === 'backward' || dir === -1) ? -1 : 1;
                resetVisual();
                if (permanentlyStopped) {
                  permanentlyStopped = false;
                  const ready = api.options.slideSnap ? api.logicalSlideCount() > 0 : api.groupCount() > 0;
                  if (ready) {
                     isPaused = false;
                     play();
                  }
                } else if (hasStarted && !isPaused) {
                  play(); 
                }
              },
              getDirection: () => direction === 1 ? 'forward' : 'backward',
              getState: () => Object.freeze({
                started: hasStarted,
                paused: isPaused,
                stopped: permanentlyStopped,
                direction: direction === 1 ? 'forward' : 'backward'
              })
            };

            api.resetAutoplay = api.autoplayApi.reset;

            play = () => {
              if (permanentlyStopped || api.isPaused() || api.isFrozen()) return; 
              pauseTimer();
              
              if (!hasStarted) {
                hasStarted = true;
                api.emit('autoplayStart');
              } else if (isPaused) {
                isPaused = false;
                api.emit('autoplayResume'); 
              }
              
              const canContinue = direction === 1 ? api.canScrollNext() : api.canScrollPrev();
              if (!canContinue) {
                if (apProgressEl) apProgressEl.style.setProperty('--ap-progress', `100%`);
                stopPermanent();
                return;
              }

              startTime = ydCarousel._now();
              loopProgress();
              
              playTimer = setTimeout(() => {
                direction === 1 ? api.scrollNext() : api.scrollPrev(); 
              }, api.options.delay);
            };
            
            stop = () => {
              pauseTimer(); 
              if (hasStarted && !isPaused && !permanentlyStopped) {
                isPaused = true;
                api.emit('autoplayPause');
              }
            };

            onSettle = () => {
               if (hasStarted && !isPaused && !permanentlyStopped) play(); 
            };

            onVisChange = () => document.hidden ? stop() : play();
            onFocusIn = () => stop();
            onFocusOut = () => play();

            onBeforeSelect = () => { pauseTimer(); resetVisual(); };
            onDragStart = () => { stop(); resetVisual(); };
            onDragEnd = () => {
               if (hasStarted && isPaused && !permanentlyStopped) {
                 isPaused = false;
                 api.emit('autoplayResume');
                 if (api.isSettled) play();
               }
            };

            onApiPause = () => { stop(); };
            onApiResume = () => { 
              if (!permanentlyStopped && hasStarted) {
                isPaused = false; 
                if (api.isSettled) play(); 
              }
            };
            
            api.on('beforeSelect', onBeforeSelect);
            api.on('dragStart', onDragStart);
            api.on('dragEnd', onDragEnd);
            api.on('settle', onSettle);
            api.on('pause', onApiPause);
            api.on('resume', onApiResume);
            api.on('freeze', onApiPause); 
            api.on('unfreeze', onApiResume);
            
            if (api.root.classList.contains('pause-hover')) {
              api.root.addEventListener('mouseenter', stop);
              api.root.addEventListener('mouseleave', play);
            }
            if (ydCarousel.hasDOM()) {
              document.addEventListener('visibilitychange', onVisChange);
            }
            api.root.addEventListener('focusin', onFocusIn);
            api.root.addEventListener('focusout', onFocusOut);
            
            if (typeof requestAnimationFrame === 'function') {
              requestAnimationFrame(() => {
                const ready = api.options.slideSnap ? api.logicalSlideCount() > 0 : api.groupCount() > 0;
                if (ready) {
                  play();
                }
              });
            }
          },
          destroy: (api) => {
            stop();
            if (!permanentlyStopped) {
               api.emit('autoplayStop');
            }
            
            delete api.autoplayApi;
            delete api.resetAutoplay; 
            
            api.off('beforeSelect', onBeforeSelect);
            api.off('dragStart', onDragStart);
            api.off('dragEnd', onDragEnd); 
            api.off('settle', onSettle);
            api.off('pause', onApiPause);
            api.off('resume', onApiResume);
            api.off('freeze', onApiPause);
            api.off('unfreeze', onApiResume);
            
            api.root.removeEventListener('mouseenter', stop);
            api.root.removeEventListener('mouseleave', play);
            if (ydCarousel.hasDOM()) {
              document.removeEventListener('visibilitychange', onVisChange);
            }
            api.root.removeEventListener('focusin', onFocusIn);
            api.root.removeEventListener('focusout', onFocusOut);
          }
        };
      })();
      this._initCorePlugin(autoplay);
    }

    // MOUSEWHEEL NAVIGATION
    if (this.root.classList.contains('wheel')) {
      const wheel = (() => {
        let onWheel, resetTimer;
        let accumulator = 0;
        return {
          name: 'wheel',
          init: (api) => {
            if (api.options.vertical && api.options.loop) {
              console.warn('[ydCarousel] Wheel plugin disabled: Vertical loops trap page scrolling.');
              return;
            }
            
            const threshold = parseInt(api.root.dataset.wheelThreshold) || 60;
            onWheel = (e) => {
              if (api.isPaused() || api.isFrozen()) return;
              if (!api.options.vertical && Math.abs(e.deltaY) > Math.abs(e.deltaX)) return;
              
              const delta = api.options.vertical ? e.deltaY : (e.deltaX || e.deltaY);
              const isAtStart = (api.options.slideSnap ? api.currentIndex === 0 : api.currentGroup === 0) && delta < 0;
              const maxEnd = api.options.slideSnap ? api.logicalSlideCount() - 1 : api.groupCount() - 1;
              const isAtEnd = (api.options.slideSnap ? api.currentIndex >= maxEnd : api.currentGroup >= maxEnd) && delta > 0;
              
              if (!api.options.loop && (isAtStart || isAtEnd)) {
                return; 
              }
              
              e.preventDefault();
              
              accumulator += delta;
              
              if (Math.abs(accumulator) >= threshold) {
                 let wheelDirection = accumulator > 0;
                 if (api.isRTL && !api.options.vertical) {
                   wheelDirection = !wheelDirection;
                 }

                 wheelDirection ? api.scrollNext() : api.scrollPrev();
                 accumulator = 0;
              }
              clearTimeout(resetTimer);
              resetTimer = setTimeout(() => { accumulator = 0; }, 100);
            };
            api.root.addEventListener('wheel', onWheel, { passive: false });
          },
          destroy: (api) => {
            clearTimeout(resetTimer); 
            api.root.removeEventListener('wheel', onWheel);
          }
        };
      })();
      this._initCorePlugin(wheel);
    }

    // HASH NAVIGATION
    if (this.root.classList.contains('hash')) {
      const hashPlugin = (() => {
        let onHash, onSelect;
        let isSyncingHash = false; 
        return {
          name: 'hash',
          init: (api) => {
            const updateUrl = api.root.dataset.hashUpdate !== 'false';
            const hashGroup = api.hashGroup(); 
            
            onHash = () => {
              if (isSyncingHash) return;
              const rawHash = ydCarousel.hasDOM() ? window.location.hash.replace('#', '') : '';
              let slideHash = rawHash;
              if (hashGroup) {
                if (rawHash.startsWith(`${hashGroup}:`)) {
                  slideHash = rawHash.split(':')[1];
                } else {
                  return; 
                }
              }
              // LOGICAL LOOKUP
              const targetIdx = api.logicalSlides().findIndex(s => s.dataset.hash === slideHash);
              if (targetIdx > -1 && targetIdx !== api.currentIndex) {
                try {
                  isSyncingHash = true;
                  api.goToSlide(targetIdx);
                } finally {
                  isSyncingHash = false;
                }
              }
            };
            
            onSelect = (api, payload) => {
              if (!updateUrl || isSyncingHash) return;
              // LOGICAL LOOKUP
              const slideHash = api.getLogicalSlide(payload.currentIndex)?.dataset.hash;
              if (slideHash && typeof history !== 'undefined') {
                const newHash = hashGroup ? `#${hashGroup}:${slideHash}` : `#${slideHash}`;
                try {
                  isSyncingHash = true;
                  history.replaceState(null, null, newHash);
                } finally {
                  isSyncingHash = false;
                }
              }
            };
            
            if (ydCarousel.hasDOM()) {
              window.addEventListener('hashchange', onHash);
            }
            api.on('select', onSelect);
            setTimeout(onHash, 0);
          },
          destroy: (api) => {
            if (ydCarousel.hasDOM()) {
              window.removeEventListener('hashchange', onHash);
            }
            api.off('select', onSelect);
          }
        };
      })();
      this._initCorePlugin(hashPlugin);
    }

    // THUMBNAIL SYNCING & SYNC GROUPS
    const syncTarget = this.root.dataset.sync;
    const syncGroup = this.syncGroup();
    if (syncTarget || syncGroup) {
      const syncPlugin = (() => {
        let onSelect;
        let hasSynced = false;
        let isSyncing = false; 
        return {
          name: 'sync',
          init: (api) => {
            onSelect = (api, payload) => {
              if (isSyncing) return;
              if (!ydCarousel.hasDOM()) return;

              let targets = [];
              if (syncTarget) {
                 const el = document.querySelector(syncTarget);
                 if (el && el.__ydCarousel) targets.push(el.__ydCarousel);
              }
              if (syncGroup) { 
                 document.querySelectorAll(`.yd_carousel[data-sync-group="${syncGroup}"]`).forEach(el => {
                    if (el !== api.root && el.__ydCarousel) targets.push(el.__ydCarousel);
                 });
              }
              
              if (targets.length) {
                try {
                  isSyncing = true;
                  if (!hasSynced) {
                    hasSynced = true;
                    api.emit('syncStart');
                  } else {
                    api.emit('syncUpdate');
                  }
                  
                  targets.forEach(targetApi => {
                    if (targetApi.selectedIndex() !== payload.currentIndex) {
                       targetApi.goToSlide(payload.currentIndex);
                    }
                  });
                } finally {
                  isSyncing = false;
                }
              }
            };
            api.on('select', onSelect);
          },
          destroy: (api) => {
            api.emit('syncStop');
            api.off('select', onSelect);
          }
        };
      })();
      this._initCorePlugin(syncPlugin);
    }

    // CREATIVE EFFECTS
    if (this.root.classList.contains('creative')) {
      const creative = (() => {
        let onScroll;
        return {
          name: 'creative',
          init: (api) => {
            onScroll = () => {
              const updateNode = (slide, idx) => {
                const progress = api.slideProgress(idx); 
                slide.style.setProperty('--slide-progress', progress.toFixed(4));
                slide.style.setProperty('--slide-abs-progress', Math.abs(progress).toFixed(4));
              };
              // RENDERED DOM COUNT
              api.slides.forEach((slide, idx) => updateNode(slide, idx));
              
              if (api.options.loop) {
                api.track.querySelectorAll('.yd_slide-clone').forEach(clone => {
                  const idx = parseInt(clone.getAttribute('data-slide-index'), 10);
                  updateNode(clone, idx);
                });
              }
            };
            api.on('scroll', onScroll);
            onScroll();
          },
          destroy: (api) => {
            api.off('scroll', onScroll);
            api.slides.forEach(s => {
              s.style.removeProperty('--slide-progress');
              s.style.removeProperty('--slide-abs-progress');
            });
          }
        };
      })();
      this._initCorePlugin(creative);
    }

    // LAZY LOAD
    if (this.root.classList.contains('lazy-load')) {
      const lazyLoad = (() => {
        let onSlideEnter;
        return {
          name: 'lazy-load',
          init: (api) => {
            onSlideEnter = (api, payload) => {
              // RENDERED LOOKUP
              const slide = api.getRenderedSlide(payload.index);
              if (slide && !slide.dataset.loaded) {
                const img = slide.querySelector('img[data-src]');
                if (img && img.dataset.src) {
                  img.onload = () => {
                    if (api.options.autoHeight) api.updateAutoHeight();
                  };
                  img.src = img.dataset.src;
                  img.removeAttribute('data-src');
                }
                slide.dataset.loaded = "true";
              }
            };
            api.on('slideEnter', onSlideEnter);
            api.slidesInView().forEach(idx => onSlideEnter(api, {index: idx}));
          },
          destroy: (api) => {
            api.off('slideEnter', onSlideEnter);
          }
        };
      })();
      this._initCorePlugin(lazyLoad);
    }

    // DEBUG PLUGIN 
    if (this.root.classList.contains('debug')) {
      const debugPlugin = (() => {
         let debugEl, onUpdate, lastUpdate = 0;
         let opened = false;
         return {
            name: 'debug',
            init: (api) => {
               if (!ydCarousel.hasDOM()) return;

               const delay = parseInt(api.root.dataset.debugDelay) || 150; 
               opened = true;
               api.emit('debugOpen'); 
               debugEl = document.createElement('div');
               debugEl.className = 'yd_carousel-debug-panel';
               debugEl.style.cssText = 'position:absolute;top:0;left:0;background:rgba(0,0,0,0.8);color:#0f0;font-family:monospace;font-size:12px;padding:10px;z-index:9999;pointer-events:none;white-space:pre;line-height:1.4;';
               api.root.appendChild(debugEl);
               
               onUpdate = (api, payload) => {
                 const now = ydCarousel._now();
                 if (now - lastUpdate < delay) return; 
                 lastUpdate = now;
                 
                 const state = api.state();
                 debugEl.textContent = `
[ydCarousel v${state.version}]
Group: ${state.group} | Idx: ${state.index}
Prog:  ${state.progress.toFixed(2)}
VPrg:  ${state.visualProgress.toFixed(2)}
Drag:  ${state.dragging}
Setl:  ${state.settled}
Loop:  ${state.looping}
Vel:   ${state.velocity.toFixed(2)}
InVw:  ${api.slidesInView().join(',')}
Mode:  ${state.slideSnap ? 'slide-snap' : 'group-snap'}
                 `.trim();
               };
               api.on('scroll', onUpdate);
               api.on('select', onUpdate);
               api.on('activeGroupChange', onUpdate);
               api.on('activeSlideChange', onUpdate); 
               onUpdate(api, api.getEventPayload());
            },
            destroy: (api) => {
               if (debugEl) debugEl.remove();
               api.off('scroll', onUpdate);
               api.off('select', onUpdate);
               api.off('activeGroupChange', onUpdate);
               api.off('activeSlideChange', onUpdate);
               if (opened) {
                 api.emit('debugClose');
               }
            }
         };
      })();
      this._initCorePlugin(debugPlugin);
    }
  }
}

// AUTO-INIT SYSTEM
if (ydCarousel.hasDOM()) {
  document.addEventListener('DOMContentLoaded', () => ydCarousel.startAutoInit());
}

if (typeof window !== 'undefined') {
  window.debugRTL = api => {
    console.table({
      currentPos: api.currentPos,
      targetPos: api.targetPos,
      progress: api.scrollProgress(),
      visualProgress: api.getVisualProgress(),
      maxScroll: api.maxScroll,
      rtl: api.isRTL
    });
  };
}
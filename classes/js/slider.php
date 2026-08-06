/**
 * ydCarousel 2.2 - V1.0 ENTERPRISE EDITION
 * FINAL PRODUCTION RELEASE: S+ Architecture, Safe Observers, Strict Init Ordering & Mutation Recovery
 */

class ydCarousel {
  static VERSION = '2.2.0';
  static ENGINE = 'ydCarousel';
  static DEBUG = false; 
  static _autoInitObserver = null;
  
  // Enterprise Plugin Factory Storage
  static globalPlugins = [];

  // Global Defaults
  static defaults = {
    duration: 0.1,
    friction: 0.92,
    delay: 4000
  };

  static EVENTS = [
    'beforeInit', 'init', 'afterInit',
    'beforeResize', 'resize', 'afterResize',
    'beforeRefresh', 'afterRefresh',
    'beforePluginInit', 'afterPluginInit',
    'beforeDestroy', 'destroy', 'afterDestroy',
    'dragStart', 'dragMove', 'dragEnd',
    'scroll', 'scrollHeavy', 'settle',
    'beforeSelect', 'select', 'afterSelect',
    'activeSlideChange',
    'slideEnter', 'slideExit',
    'loopEnter', 'loopExit', 'loopReposition',
    'visibilityPause', 'visibilityResume',
    'autoplayStart', 'autoplayPause', 'autoplayResume', 'autoplayStop', 'autoplayToggleRequest',
    'syncStart', 'syncUpdate', 'syncStop',
    'debugOpen', 'debugClose',
    'error'
  ];

  static startAutoInit() {
    if (typeof document === 'undefined') return;
    const initAll = () => {
      document.querySelectorAll('.yd_carousel:not(.yd_carousel-ready):not(.yd_carousel-initializing)').forEach(el => {
        el.classList.add('yd_carousel-initializing');
        try {
          if (!el.__ydCarousel) el.__ydCarousel = new ydCarousel(el);
        } catch (err) {
          el.classList.remove('yd_carousel-initializing');
          console.error(err);
        }
      });
    };
    initAll();
    if (!this._autoInitObserver) {
      if (typeof MutationObserver === 'function') {
        this._autoInitObserver = new MutationObserver(initAll);
        this._autoInitObserver.observe(document.body, { childList: true, subtree: true });
      }
    }
  }

  static stopAutoInit() {
    if (this._autoInitObserver) {
      this._autoInitObserver.disconnect();
      this._autoInitObserver = null;
    }
  }

  static use(pluginFactory) {
    if (!this.globalPlugins.includes(pluginFactory)) {
      this.globalPlugins.push(pluginFactory);
    }
  }

  constructor(element, options = {}) {
    this.root = element;
    this.track = this.root.querySelector('.yd_container');
    if (!this.track) {
      this.root.classList.remove('yd_carousel-initializing');
      return;
    }
    
    // Constructor Options Mapping
    if (options instanceof Set) options = { disabledPlugins: [...options] };
    this.instanceOptions = options;
    this.disabledPlugins = new Set(options.disabledPlugins || []);

    // Internal State
    this._mounted = false;
    this._isVisible = true;
    this._syncLock = false;
    this._eventsPaused = false;
    this._eventQueue = [];
    this._refreshPaused = false;
    this._refreshPending = false;
    this._forceRefresh = false;
    this._lastDiffHash = '';
    
    this.currentPos = 0;
    this.targetPos = 0;
    this.currentIndex = 0;
    this.prevIndex = 0; 
    this._velocity = 0; 
    this.inertia = 0;
    
    this.isDraggingActive = false;
    this.isSettled = true;
    this.destroyed = false;        
    
    this.rafId = null;
    this.mutationRaf = null;
    this.refreshRaf = null; 
    this.resizeRaf = null; 
    
    this.lastHeavyScrollTime = 0;
    this._currentFps = 60;
    this._frames = 0;
    this._lastFpsTime = typeof performance !== 'undefined' ? performance.now() : 0;

    this.dragStartPos = 0;
    this.dragStartCurrentPos = 0;
    this.lastPointerPos = 0;
    this.lastPointerTime = 0;
    this.isClickSuppressed = false;
    this.passiveOpts = { passive: true };

    this.slides = []; 
    this.visibleSlides = new Set(); 

    this.metrics = {
      viewportSize: 0,
      trackSize: 0,
      realTrackSize: 0, 
      prependOffset: 0,  
      slideSizes: [],
      slideSnaps: [],
      scrollSnaps: [] 
    };

    this.listeners = {};
    
    // Enterprise Plugin Registry Maps
    this.plugins = [];
    this.pluginsMap = new Map();
    this.pluginRegistry = new Map();
    this.failedPlugins = [];

    this.onPointerDown = this.onPointerDown.bind(this);
    this.onPointerMove = this.onPointerMove.bind(this);
    this.onPointerUp = this.onPointerUp.bind(this);
    this.onClick = this.onClick.bind(this);
    this.onKeyDown = this.onKeyDown.bind(this);
    this.onResize = this.onResize.bind(this);
    this.onMutation = this.onMutation.bind(this);
    this.tick = this.tick.bind(this);

    this.init();
  }

  init() {
    if (this.destroyed) return;
    
    this.updateOptions();
    this.emit('beforeInit');

    this.setupAccessibility();
    this.setupObservers();
    this.bindEvents();
    this.initPlugins();
    this.updateMeasurements();
    this.startPhysicsLoop();
    
    this.root.classList.remove('yd_carousel-initializing');
    this.root.classList.add('yd_carousel-ready');
    this.emit('init');
    this._mounted = true;
    this.emit('afterInit');
  }

  // ==========================================
  // RESPONSIVE UTILITY ENGINE
  // ==========================================

  updateOptions() {
    if (this.destroyed) return;
    const w = typeof window !== 'undefined' ? window.innerWidth : 1200;
    const has = (cls) => {
      if (w <= 768 && this.root.classList.contains(`mb:${cls}`)) return true;
      if (w <= 1024 && this.root.classList.contains(`th:${cls}`)) return true;
      return this.root.classList.contains(cls);
    };

    const scrollAttr = this.root.dataset.scroll;
    const parsedScroll = parseInt(scrollAttr, 10);

    this.options = {
      ...ydCarousel.defaults,
      ...this.instanceOptions,
      loop: has('loop'),
      dragFree: has('drag-free'),
      contain: has('contain'),
      containKeep: has('contain-keep'),
      alignCenter: has('align-center'),
      alignEnd: has('align-end'),
      keyboard: has('keyboard'),
      autoplay: has('autoplay'),
      rtl: has('rtl'),
      vertical: has('vertical'),
      culling: has('culling') || has('virtual'),
      scroll: scrollAttr === 'auto' 
        ? 'auto' 
        : Number.isInteger(parsedScroll) && parsedScroll > 0 ? parsedScroll : 1,
      duration: parseFloat(this.root.dataset.duration) || ydCarousel.defaults.duration,
      friction: parseFloat(this.root.dataset.friction) || ydCarousel.defaults.friction,
      delay: parseInt(this.root.dataset.delay, 10) || ydCarousel.defaults.delay
    };

    if (typeof window !== 'undefined' && window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      this.options.duration = 1;
    }
  }

  // ==========================================
  // S-TIER ENTERPRISE API & DIAGNOSTICS
  // ==========================================

  version() { return ydCarousel.VERSION; }
  isReady() { return this.root.classList.contains('yd_carousel-ready'); }
  isDestroyed() { return this.destroyed; }
  events() { return [...ydCarousel.EVENTS]; }
  
  hashGroup() { return this.root.dataset.hashGroup; }
  syncGroup() { return this.root.dataset.syncGroup; }
  velocity() { return this._velocity; }
  currentPosition() { return this.currentPos; }
  targetPosition() { return this.targetPos; }

  visible() { return this._isVisible; }
  mounted() { return this._mounted; }
  currentSlide() { return this.activeSlide(); }
  activeSlideIndex() { return this.currentIndex; }
  slideCount() { return this.slides?.length ?? 0; }
  groupCount() { return this.metrics?.scrollSnaps?.length ?? 0; }

  getMetrics() {
    if (!this.metrics) return null;
    return Object.freeze({
      viewportSize: this.metrics.viewportSize,
      trackSize: this.metrics.trackSize,
      realTrackSize: this.metrics.realTrackSize,
      prependOffset: this.metrics.prependOffset,
      slideSizes: [...this.metrics.slideSizes],
      slideSnaps: [...this.metrics.slideSnaps],
      scrollSnaps: [...this.metrics.scrollSnaps]
    });
  }

  isAutoplayRunning() { return this.autoplayController?.isPlaying() || false; }
  play() { this.autoplayController?.play(); }
  pause() { this.autoplayController?.pause(); }
  toggleAutoplay() { this.autoplayController?.toggle(); }

  goToNext() { this.scrollNext(); }
  goToPrev() { this.scrollPrev(); }
  currentPage() { return this.currentIndex + 1; }
  pageCount() { return this.groupCount(); }

  // TRANSACTION EVENT BUS
  pauseEvents() { this._eventsPaused = true; }
  resumeEvents() {
    this._eventsPaused = false;
    this._eventQueue.forEach(args => this.emit(args.event, args.customData, args.skipPayload, args.prebuiltPayload));
    this._eventQueue = [];
  }

  transaction(callback) {
    if (this.destroyed) return;
    this.pauseEvents();
    this._refreshPaused = true;
    try {
      callback();
    } catch(err) {
      if (ydCarousel.DEBUG) console.error('[ydCarousel] Transaction Error:', err);
      this.emit('error', { context: 'transaction', error: err }, true);
    } finally {
      this._refreshPaused = false;
      if (this._refreshPending) {
        this._refreshPending = false;
        this.scheduleRefresh(true);
      }
      this.resumeEvents();
    }
  }

  addSlide(node) {
    this.track.appendChild(node);
    this.scheduleRefresh(true);
  }
  removeSlide(index) {
    if (this.slides[index]) {
      this.slides[index].remove();
      this.scheduleRefresh(true);
    }
  }
  replaceSlide(index, node) {
    if (this.slides[index]) {
      this.track.replaceChild(node, this.slides[index]);
      this.scheduleRefresh(true);
    }
  }

  // S-TIER HOT RELOADING
  disablePlugin(name) {
    if (this.destroyed) return;
    this.disabledPlugins.add(name);
    this.instanceOptions.disabledPlugins = [...this.disabledPlugins];
    const meta = this.pluginsMap.get(name);
    if (meta) {
      if (meta.instance && meta.instance.destroy) {
        try { meta.instance.destroy(this); } 
        catch (err) { 
          if (ydCarousel.DEBUG) console.error(`[ydCarousel] Plugin "${name}" disable error:`, err);
          this.emit('error', { plugin: name, action: 'disable', error: err }, true); 
        }
      }
      this.plugins = this.plugins.filter(p => p.name !== name);
      this.pluginsMap.delete(name);
    }
  }

  enablePlugin(name) {
    if (this.destroyed || this.pluginsMap.has(name)) return;
    this.disabledPlugins.delete(name);
    this.instanceOptions.disabledPlugins = [...this.disabledPlugins];
    
    const defFactory = this.pluginRegistry.get(name);
    if (defFactory) {
      this._initSinglePlugin(typeof defFactory === 'function' ? defFactory() : { ...defFactory });
    }
  }

  state() {
    return Object.freeze({
      version: this.version(),
      index: this.currentIndex,
      previousIndex: this.prevIndex,
      position: this.currentPos,
      target: this.targetPos,
      velocity: this._velocity,
      progress: this.scrollProgress(),
      dragging: this.isDraggingActive,
      settled: this.isSettled,
      looping: this.options?.loop ?? false,
      rtl: this.options?.rtl ?? false,
      vertical: this.options?.vertical ?? false
    });
  }

  get stateData() { return this.state(); }
  snapshot() { return this.state(); }

  toJSON() {
    return {
      engine: ydCarousel.ENGINE,
      version: this.version(),
      state: this.state(),
      slideCount: this.slideCount(),
      groupCount: this.groupCount()
    };
  }

  performance() {
    return Object.freeze({
      fps: this._currentFps,
      mounted: this._mounted,
      visible: this._isVisible,
      running: !!this.rafId,
      slideCount: this.slideCount(),
      groupCount: this.groupCount(),
      visibleSlides: this.slidesInView(),
      plugins: {
        total: this.plugins.length + this.failedPlugins.length,
        healthy: this.plugins.length,
        failed: this.failedPlugins.length
      }
    });
  }

  observerStatus() {
    return Object.freeze({
      resize: !!this.resizeObserver,
      mutation: !!this.mutationObserver,
      visibility: !!this.visibilityObserver,
      visibilityPauser: !!this.visibilityPauser
    });
  }

  memoryInfo() {
    return Object.freeze({
      slides: this.slides?.length || 0,
      listeners: Object.keys(this.listeners).reduce((acc, key) => acc + this.listeners[key].length, 0),
      plugins: this.plugins.length,
      observers: Number(!!this.resizeObserver) + Number(!!this.mutationObserver) + Number(!!this.visibilityObserver) + Number(!!this.visibilityPauser)
    });
  }

  registeredPlugins() { return this.plugins.map(p => p.name); }
  pluginInfo() {
    return Array.from(this.pluginsMap.values()).map(p => ({
      name: p.name, version: p.version, author: p.author
    }));
  }

  buildInfo() {
    return Object.freeze({
      engine: ydCarousel.ENGINE,
      version: this.version(),
      build: 'enterprise',
      released: '2026-08'
    });
  }

  capabilities() {
    return Object.freeze({
      loop: true, dragFree: true, rtl: true, vertical: true, autoplay: true, keyboard: true,
      wheel: true, hash: true, sync: true, creative: true, lazyLoad: true, accessibility: true,
      debug: true, plugins: true, events: true, diagnostics: true, snapshots: true,
      observers: true, scrollbar: true, autoplayProgress: true, dynamicApi: true, responsiveUtilities: true,
      culling: true, transaction: true, hotReload: true
    });
  }

  runtimeCapabilities() {
    return Object.freeze({
      loop: this.options?.loop ?? false, dragFree: this.options?.dragFree ?? false,
      rtl: this.options?.rtl ?? false, vertical: this.options?.vertical ?? false,
      autoplay: this.options?.autoplay ?? false, keyboard: this.options?.keyboard ?? false,
      contain: this.options?.contain ?? false, containKeep: this.options?.containKeep ?? false,
      alignCenter: this.options?.alignCenter ?? false, alignEnd: this.options?.alignEnd ?? false,
      culling: this.options?.culling ?? false, scroll: this.options?.scroll ?? 1
    });
  }

  info() {
    return Object.freeze({
      version: this.version(),
      build: this.buildInfo(),
      plugins: Object.freeze(this.pluginInfo()),
      events: Object.freeze(this.events()),
      capabilities: this.capabilities(),
      runtimeCapabilities: this.runtimeCapabilities(),
      state: this.state()
    });
  }

  inspect() {
    return Object.freeze({
      info: this.info(),
      state: this.state(),
      capabilities: this.capabilities(),
      runtimeCapabilities: this.runtimeCapabilities(),
      slidesInView: Object.freeze(this.slidesInView()),
      slidesNotInView: Object.freeze(this.slidesNotInView()),
      activeIndex: this.activeSlideIndex(),
      activeSlide: this.activeSlide()
    });
  }

  getEventPayload() {
    return {
      version: this.version(),
      currentIndex: this.currentIndex ?? 0,
      previousIndex: this.prevIndex ?? 0,
      slideCount: this.slides?.length ?? 0,
      groupCount: this.metrics?.scrollSnaps?.length ?? 0,
      progress: this.scrollProgress() ?? 0,
      isDragging: this.isDraggingActive ?? false,
      isSettled: this.isSettled ?? true,
      looping: this.options?.loop ?? false,
      direction: (this._velocity || 0) > 0 ? 1 : ((this._velocity || 0) < 0 ? -1 : 0)
    };
  }

  emit(event, customData = {}, skipPayload = false, prebuiltPayload = null) {
    if (this._eventsPaused && event !== 'error') {
      const queuedPayload = prebuiltPayload || (skipPayload ? { ...customData } : { ...this.getEventPayload(), ...customData });
      this._eventQueue.push({ event, customData, skipPayload: true, prebuiltPayload: queuedPayload });
      return;
    }
    
    const payload = prebuiltPayload || (skipPayload ? { ...customData } : { ...this.getEventPayload(), ...customData });
    
    if (this.listeners[event]) {
      this.listeners[event].forEach(cb => {
        try { cb(this, payload); } 
        catch(err) { 
          if (ydCarousel.DEBUG) console.error(`[ydCarousel] Event Error (${event}):`, err); 
          if (event !== 'error') this.emit('error', { context: 'event', event, error: err }, true);
        }
      });
    }
    
    if (typeof CustomEvent !== 'undefined') {
      this.root.dispatchEvent(new CustomEvent(`yd:${event}`, { detail: payload, bubbles: true }));
    }
  }

  on(event, callback) {
    if (ydCarousel.DEBUG && !ydCarousel.EVENTS.includes(event)) {
      console.warn(`[ydCarousel] Unknown event: ${event}`);
    }
    if (!this.listeners[event]) this.listeners[event] = [];
    this.listeners[event].push(callback);
    return this;
  }

  off(event, callback) {
    if (!this.listeners[event]) return;
    this.listeners[event] = this.listeners[event].filter(cb => cb !== callback);
  }

  // ==========================================
  // NAVIGATION
  // ==========================================

  goTo(index, immediate = false) {
    if (this.destroyed) return;
    if (!this.metrics || !this.metrics.scrollSnaps || !this.metrics.scrollSnaps.length) return;
    
    const maxIndex = this.metrics.scrollSnaps.length - 1;
    const targetIndex = Math.max(0, Math.min(index, maxIndex));
    
    const changed = (this.currentIndex !== targetIndex);

    if (changed) {
      this.emit('beforeSelect', { currentIndex: this.currentIndex, targetIndex });
      
      this.prevIndex = this.currentIndex;
      this.currentIndex = targetIndex;
      this.emit('activeSlideChange', { currentIndex: this.currentIndex, previousIndex: this.prevIndex });
    }
    
    let nextTarget = this.metrics.scrollSnaps[this.currentIndex];
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
    if (immediate) this.currentPos = this.targetPos;
    
    this.updateSlideStates();

    if (changed || immediate) {
      this.emit('select');
      this.emit('afterSelect'); 
    }
  }

  scrollTo(index, immediate = false) { this.goTo(index, immediate); }
  selectedIndex() { return this.currentIndex; }
  previousIndex() { return this.prevIndex; }
  
  activeSlide() { 
    if (!this.slides?.length || !this.metrics?.scrollSnaps?.length) return null;
    if (this.currentIndex < 0 || this.currentIndex >= this.metrics.scrollSnaps.length) return null;
    
    const targetSnap = this.metrics.scrollSnaps[this.currentIndex];
    let closestIdx = 0;
    let minDistance = Infinity;

    this.metrics.slideSnaps.forEach((snap, idx) => {
      let dist = Math.abs(snap - targetSnap);
      if (this.options.loop) {
        const d2 = Math.abs((snap + this.metrics.realTrackSize) - targetSnap);
        const d3 = Math.abs((snap - this.metrics.realTrackSize) - targetSnap);
        dist = Math.min(dist, d2, d3);
      }
      if (dist < minDistance) {
        minDistance = dist;
        closestIdx = idx;
      }
    });
    
    return this.slides[closestIdx] || null; 
  }

  slideNodes() { return this.slides; }
  isDragging() { return this.isDraggingActive; } 
  isLoop() { return this.options?.loop ?? false; }         

  scrollNext() {
    if (!this.metrics || !this.metrics.scrollSnaps) return;
    if (this.currentIndex < this.metrics.scrollSnaps.length - 1) this.goTo(this.currentIndex + 1);
    else if (this.options.loop && this.canScrollNext()) this.goTo(0); 
  }

  scrollPrev() {
    if (!this.metrics || !this.metrics.scrollSnaps) return;
    if (this.currentIndex > 0) this.goTo(this.currentIndex - 1);
    else if (this.options.loop && this.canScrollPrev()) this.goTo(this.metrics.scrollSnaps.length - 1);
  }

  snapToClosest() {
    if (!this.metrics || !this.metrics.scrollSnaps) return;
    let closestIndex = 0;
    let minDistance = Infinity;
    this.metrics.scrollSnaps.forEach((point, index) => {
      const d1 = Math.abs(point - this.targetPos);
      const d2 = this.options.loop ? Math.abs((point + this.metrics.realTrackSize) - this.targetPos) : Infinity;
      const d3 = this.options.loop ? Math.abs((point - this.metrics.realTrackSize) - this.targetPos) : Infinity;
      const distance = Math.min(d1, d2, d3);
      if (distance < minDistance) {
        minDistance = distance;
        closestIndex = index;
      }
    });
    this.goTo(closestIndex);
  }

  // ==========================================
  // HELPERS & LIFECYCLE
  // ==========================================

  scheduleRefresh(force = false) {
    if (this.destroyed) return;
    if (force) this._forceRefresh = true;
    if (this._refreshPaused) {
      this._refreshPending = true;
      return;
    }
    if (this.refreshRaf) return;
    this.refreshRaf = requestAnimationFrame(() => {
      this.refreshRaf = null;
      this.emit('beforeRefresh');
      this.updateMeasurements();
      this.emit('afterRefresh');
    });
  }

  scheduleResize() {
    if (this.resizeRaf || this.destroyed) return;
    this.resizeRaf = requestAnimationFrame(() => {
      this.resizeRaf = null;
      this.scheduleRefresh();
    });
  }

  refresh() {
    this.scheduleRefresh(true);
  }

  refreshPlugins() {
    if (this.destroyed || !this._mounted) return;
    this.plugins.forEach(p => {
      const instance = p.instance || p;
      if (instance && typeof instance.refresh === 'function') {
        try { instance.refresh(this); } 
        catch (err) { this.emit('error', { plugin: p.name, action: 'refresh', error: err }, true); }
      }
    });
  }

  reInit() {
    const savedState = {
      currentIndex: this.currentIndex,
      velocity: this._velocity,
      dragging: this.isDraggingActive,
      autoplayActive: this.isAutoplayRunning()
    };

    const root = this.root;
    const instanceOpts = this.instanceOptions;
    
    this.destroy(false);
    
    root.__ydCarousel = new ydCarousel(root, instanceOpts);
    const newApi = root.__ydCarousel;

    const safeIndex = Math.max(0, Math.min(savedState.currentIndex, newApi.groupCount() - 1));

    newApi._velocity = savedState.velocity;
    newApi.isDraggingActive = savedState.dragging;
    
    newApi.goTo(safeIndex, true);
    
    if (savedState.autoplayActive && newApi.play) {
      newApi.play();
    }

    return newApi;
  }

  canScrollNext() {
    if (!this.metrics || !this.metrics.scrollSnaps) return false;
    if (this.root.classList.contains('stop-last') && this.currentIndex >= this.metrics.scrollSnaps.length - 1) return false;
    return this.options.loop || this.currentIndex < this.metrics.scrollSnaps.length - 1;
  }

  canScrollPrev() {
    return this.options.loop || this.currentIndex > 0;
  }

  scrollProgress() {
    if (!this.options || !this.metrics || typeof this.maxScroll === 'undefined') return 0;
    if (this.options.loop) {
      const relativePos = this.currentPos - (this.metrics.prependOffset || 0);
      return Math.max(0, Math.min(1, relativePos / (this.metrics.realTrackSize || 1)));
    }
    if (!this.maxScroll) return 0;
    return Math.max(0, Math.min(1, this.currentPos / this.maxScroll));
  }

  slideProgress(index) {
    if (!this.metrics || !this.metrics.slideSnaps) return 0;
    const snap = this.metrics.slideSnaps[index] || 0;
    const distance = this.currentPos - snap;
    const progress = distance / (this.metrics.viewportSize || 1);
    return Math.max(-1, Math.min(1, progress));
  }

  slidesInView() {
    return [...this.visibleSlides].sort((a, b) => a - b);
  }

  slidesNotInView() {
    return this.slides.map((_, idx) => idx).filter(idx => !this.visibleSlides.has(idx));
  }

  updateSlideStates() {
    if (!this.metrics || !this.metrics.slideSnaps) return;
    
    let calculatedGeometryIndex = 0;
    let minDistance = Infinity;
    this.metrics.slideSnaps.forEach((snap, idx) => {
      let dist = Math.abs(snap - this.targetPos);
      if (this.options.loop) {
        const d2 = Math.abs((snap + this.metrics.realTrackSize) - this.targetPos);
        const d3 = Math.abs((snap - this.metrics.realTrackSize) - this.targetPos);
        dist = Math.min(dist, d2, d3);
      }
      if (dist < minDistance) {
        minDistance = dist;
        calculatedGeometryIndex = idx;
      }
    });

    const closestSlideIdx = this.options.loop ? calculatedGeometryIndex : this.currentIndex;
    const total = this.slides.length;
    const prevIdx = this.options.loop ? (total + closestSlideIdx - 1) % total : closestSlideIdx - 1;
    const nextIdx = this.options.loop ? (closestSlideIdx + 1) % total : closestSlideIdx + 1;

    this.slides.forEach((slide, idx) => {
      slide.classList.remove('active', 'prev', 'next');
      slide.removeAttribute('aria-current');
      if (idx === closestSlideIdx) {
        slide.classList.add('active');
        slide.setAttribute('aria-current', 'true');
      } else if (idx === prevIdx) {
        slide.classList.add('prev');
      } else if (idx === nextIdx) {
        slide.classList.add('next');
      }
      
      if (this.options.culling && !slide.classList.contains('yd_slide-clone')) {
        const distToActive = Math.abs(this.slideProgress(idx));
        if (distToActive > 3) {
          slide.classList.add('yd_cull-hidden');
        } else {
          slide.classList.remove('yd_cull-hidden');
        }
      }
    });
  }

  // ==========================================
  // MEASUREMENT, GROUPING, & DIFFING
  // ==========================================
  
  updateMeasurements() {
    if (this.destroyed) return;
    this.emit('beforeResize');
    this.updateOptions(); 

    const newRect = this.root.getBoundingClientRect();
    const newViewportSize = this.options.vertical ? newRect.height : newRect.width;
    const rawSlides = Array.from(this.track.children).filter(el => !el.classList.contains('yd_slide-clone'));
    const newSlideCount = rawSlides.length;

    const newSlideSizes = rawSlides.map(slide => this.options.vertical ? slide.getBoundingClientRect().height : slide.getBoundingClientRect().width);
    const sizesHash = newSlideSizes.join('|');

    const diffHash = [
      newViewportSize,
      newSlideCount,
      sizesHash,
      this.options.loop,
      this.options.scroll,
      this.options.alignCenter,
      this.options.alignEnd,
      this.options.contain,
      this.options.containKeep,
      this.options.rtl,
      this.options.vertical
    ].join('|');

    if (!this._forceRefresh && this._lastDiffHash === diffHash && this._mounted) {
      this.refreshPlugins();
      this.emit('afterResize');
      return;
    }
    this._lastDiffHash = diffHash;
    this._forceRefresh = false;

    this.visibleSlides.clear();

    if (this.mutationObserver) this.mutationObserver.disconnect();
    this.track.querySelectorAll('.yd_slide-clone').forEach(clone => clone.remove());
    
    this.slides = Array.from(this.track.children);
    if (!this.slides.length) return;

    this.slides.forEach((slide, idx) => {
      slide.setAttribute('data-slide-index', idx);
      const imgs = slide.querySelectorAll('img');
      imgs.forEach(img => {
        if (ydCarousel.DEBUG && !img.getAttribute('width') && !img.getAttribute('height') && !img.style.aspectRatio) {
           console.warn('[ydCarousel] Image missing dimensions (CLS risk):', img);
        }
        if (!img.dataset.ydLoaded) {
           img.dataset.ydLoaded = 'true';
           img.addEventListener('load', () => this.scheduleRefresh(true), { once: true });
        }
      });
    });

    this.metrics.viewportSize = newViewportSize;
    this.metrics.slideSizes = newSlideSizes;
    
    this.metrics.realTrackSize = this.metrics.slideSizes.reduce((a, b) => a + b, 0);
    this.metrics.prependOffset = 0;

    if (this.options.loop && this.slides.length > 1) {
      this.metrics.prependOffset = this.metrics.realTrackSize;
      const clonesBefore = this.slides.map(s => this.createClone(s));
      const clonesAfter = this.slides.map(s => this.createClone(s));
      clonesBefore.forEach(c => this.track.insertBefore(c, this.track.firstChild));
      clonesAfter.forEach(c => this.track.appendChild(c));
    }

    this.metrics.trackSize = this.options.vertical ? this.track.scrollHeight : this.track.scrollWidth;
    
    let currentOffset = this.metrics.prependOffset;
    this.metrics.slideSnaps = this.metrics.slideSizes.map((size) => {
      let snap = currentOffset;
      if (this.options.alignCenter) snap -= (this.metrics.viewportSize / 2) - (size / 2);
      if (this.options.alignEnd) snap -= this.metrics.viewportSize - size;
      currentOffset += size;
      return Math.max(0, snap); 
    });

    this.maxScroll = Math.max(0, this.metrics.trackSize - this.metrics.viewportSize);

    let clampedSnaps = this.metrics.slideSnaps;
    if (!this.options.loop && (this.options.contain || this.options.containKeep)) {
      clampedSnaps = this.metrics.slideSnaps.map(snap => Math.max(0, Math.min(snap, this.maxScroll)));
    }

    let rawScrollSnaps = [];
    if (this.options.scroll === 'auto') {
      let lastSnap = clampedSnaps[0];
      rawScrollSnaps.push(lastSnap);
      for (let i = 1; i < clampedSnaps.length; i++) {
        if (clampedSnaps[i] - lastSnap >= this.metrics.viewportSize * 0.9) {
          rawScrollSnaps.push(clampedSnaps[i]);
          lastSnap = clampedSnaps[i];
        }
      }
      if (rawScrollSnaps[rawScrollSnaps.length - 1] !== clampedSnaps[clampedSnaps.length - 1]) {
         rawScrollSnaps.push(clampedSnaps[clampedSnaps.length - 1]);
      }
    } else {
      const step = this.options.scroll;
      for (let i = 0; i < clampedSnaps.length; i += step) {
        rawScrollSnaps.push(clampedSnaps[i]);
      }
      if ((this.options.contain || this.options.containKeep) && rawScrollSnaps[rawScrollSnaps.length - 1] !== clampedSnaps[clampedSnaps.length - 1]) {
        rawScrollSnaps.push(clampedSnaps[clampedSnaps.length - 1]);
      }
    }

    if (!this.options.loop && this.options.contain) {
      this.metrics.scrollSnaps = [...new Set(rawScrollSnaps)];
    } else {
      this.metrics.scrollSnaps = rawScrollSnaps;
    }

    if (this.currentIndex >= this.metrics.scrollSnaps.length) {
      this.currentIndex = Math.max(0, this.metrics.scrollSnaps.length - 1);
    }

    if (this.visibilityObserver) {
      this.visibilityObserver.disconnect();
      Array.from(this.track.children).forEach(node => this.visibilityObserver.observe(node));
    }

    if (this.mutationObserver) {
      this.mutationObserver.observe(this.track, { childList: true, subtree: true, attributes: true, attributeFilter: ['src', 'style', 'class'] });
    }

    this.emit('resize');
    this.goTo(this.currentIndex, true);
    this.updateSlideStates();
    this.refreshPlugins();
    this.emit('afterResize');
  }

  createClone(slide) {
    const clone = slide.cloneNode(true);
    clone.classList.add('yd_slide-clone');
    clone.setAttribute('aria-hidden', 'true');
    clone.removeAttribute('aria-current');
    clone.classList.remove('active', 'prev', 'next', 'in-view', 'out-view');
    clone.style.contentVisibility = ''; 
    
    const nodes = [clone, ...clone.querySelectorAll('*')];
    nodes.forEach(node => {
      node.removeAttribute('id');
      node.removeAttribute('for');
      node.removeAttribute('aria-labelledby');
      node.removeAttribute('aria-describedby');
      node.removeAttribute('aria-controls');
    });

    return clone;
  }

  // ==========================================
  // OBSERVERS (VISIBILITY PAUSE & CPU HALT)
  // ==========================================
  
  setupObservers() {
    if (typeof ResizeObserver === 'function') {
      this.resizeObserver = new ResizeObserver(this.onResize);
      this.resizeObserver.observe(this.root);
    }
    
    if (typeof MutationObserver === 'function') {
      this.mutationObserver = new MutationObserver(this.onMutation);
    }

    if (typeof IntersectionObserver === 'function') {
      this.visibilityPauser = new IntersectionObserver((entries) => {
        const isIntersecting = entries[0].isIntersecting;
        if (isIntersecting !== this._isVisible) {
          this._isVisible = isIntersecting;
          if (this._isVisible) {
            this.emit('visibilityResume');
            if (!this.isSettled && !this.rafId && this._mounted) {
              this.lastPointerTime = performance.now();
              this.startPhysicsLoop();
            }
          } else {
            this.emit('visibilityPause');
          }
        }
      });
      this.visibilityPauser.observe(this.root);

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
      }, { root: this.root, threshold: 0.01 });
    }
  }

  setupAccessibility() {
    this.root.setAttribute('role', 'region');
    this.root.setAttribute('aria-roledescription', 'carousel');
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
      let text = `Page ${payload.currentIndex + 1} of ${payload.groupCount}`;
      const inView = api.slidesInView();
      if (inView.length > 1) {
        text += `. Showing slides ${inView[0] + 1} through ${inView[inView.length - 1] + 1}`;
      }
      announcer.textContent = text;
    };
    this.on('select', this.announceHandler);
  }

  onResize() { this.scheduleResize(); }

  onMutation(mutations) {
    if (this.destroyed) return;
    if (mutations.some(m => m.target.classList && m.target.classList.contains('yd_slide-clone'))) return;
    if (this.mutationRaf) cancelAnimationFrame(this.mutationRaf);
    
    this.mutationRaf = requestAnimationFrame(() => {
      this.mutationRaf = null;
      const oldLength = this.slides.length;
      const realNodes = Array.from(this.track.children).filter(el => !el.classList.contains('yd_slide-clone'));
      const newLength = realNodes.length;

      this.scheduleRefresh(true);
      if (newLength !== oldLength) {
        this.initPlugins();
      }
    });
  }

  // ==========================================
  // POINTER & EVENTS
  // ==========================================

  getPointerPos(e) {
    return this.options.vertical ? e.clientY : e.clientX;
  }

  bindEvents() {
    this.track.addEventListener('pointerdown', this.onPointerDown);
    this.track.addEventListener('click', this.onClick, { capture: true });
    if (this.options.keyboard) {
      this.root.setAttribute('tabindex', '0');
      this.root.addEventListener('keydown', this.onKeyDown);
    }
  }

  unbindEvents() {
    this.track.removeEventListener('pointerdown', this.onPointerDown);
    this.track.removeEventListener('click', this.onClick, { capture: true });
    window.removeEventListener('pointermove', this.onPointerMove, this.passiveOpts);
    window.removeEventListener('pointerup', this.onPointerUp, this.passiveOpts);
    this.root.removeEventListener('keydown', this.onKeyDown);
  }

  onPointerDown(e) {
    if (this.destroyed || e.button !== 0) return; 
    
    this.isDraggingActive = true;
    this.isClickSuppressed = false;
    this.dragStartPos = this.getPointerPos(e);
    this.dragStartCurrentPos = this.targetPos;
    
    this.lastPointerPos = this.getPointerPos(e);
    this.lastPointerTime = performance.now();
    this._velocity = 0;
    this.inertia = 0; 

    this.track.setPointerCapture(e.pointerId);
    this.track.style.cursor = 'grabbing';
    
    window.addEventListener('pointermove', this.onPointerMove, this.passiveOpts);
    window.addEventListener('pointerup', this.onPointerUp, this.passiveOpts);
    
    this.emit('dragStart');
    e.preventDefault(); 
  }

  onPointerMove(e) {
    if (this.destroyed || !this.isDraggingActive) return;
    const currentPointer = this.getPointerPos(e);
    
    let dragDistance = this.dragStartPos - currentPointer;
    if (this.options.rtl && !this.options.vertical) dragDistance *= -1;

    if (Math.abs(dragDistance) > 5) this.isClickSuppressed = true;

    const now = performance.now();
    const dt = now - this.lastPointerTime;
    if (dt > 0) {
      let rawVel = (this.lastPointerPos - currentPointer) / dt;
      if (this.options.rtl && !this.options.vertical) rawVel *= -1;
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
    this.emit('dragMove');
  }

  onPointerUp(e) {
    if (this.destroyed || !this.isDraggingActive) return;
    this.isDraggingActive = false;
    this.track.releasePointerCapture(e.pointerId);
    this.track.style.cursor = '';

    window.removeEventListener('pointermove', this.onPointerMove, this.passiveOpts);
    window.removeEventListener('pointerup', this.onPointerUp, this.passiveOpts);
    this.emit('dragEnd');

    if (this.options.dragFree) {
      this.inertia = -this._velocity * 40; 
    } else {
      if (Math.abs(this._velocity) > 0.5) {
        let momentumTarget = this.targetPos - (this._velocity * 200); 
        let closestIndex = 0;
        let minDistance = Infinity;
        if (this.metrics && this.metrics.scrollSnaps) {
          this.metrics.scrollSnaps.forEach((point, index) => {
              const d1 = Math.abs(point - momentumTarget);
              const d2 = this.options.loop ? Math.abs((point + this.metrics.realTrackSize) - momentumTarget) : Infinity;
              const d3 = this.options.loop ? Math.abs((point - this.metrics.realTrackSize) - momentumTarget) : Infinity;
              const distance = Math.min(d1, d2, d3);
              if (distance < minDistance) {
                  minDistance = distance;
                  closestIndex = index;
              }
          });
        }
        this.goTo(closestIndex);
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
    if (this.destroyed) return;
    const isRtl = this.options.rtl;
    const isVert = this.options.vertical;
    
    if (e.key === 'Home') this.goTo(0);
    if (e.key === 'End' && this.metrics && this.metrics.scrollSnaps) this.goTo(this.metrics.scrollSnaps.length - 1);
    
    if (e.key === 'PageDown') this.scrollNext();
    if (e.key === 'PageUp') this.scrollPrev();

    if (e.key === 'ArrowRight') {
      if (isVert) return;
      isRtl ? this.scrollPrev() : this.scrollNext();
    }
    if (e.key === 'ArrowLeft') {
      if (isVert) return;
      isRtl ? this.scrollNext() : this.scrollPrev();
    }
    if (e.key === 'ArrowDown' && isVert) this.scrollNext();
    if (e.key === 'ArrowUp' && isVert) this.scrollPrev();
  }

  // ==========================================
  // PHYSICS, LOOPING, & LIFECYCLE 
  // ==========================================

  startPhysicsLoop() {
    if (this.rafId || this.destroyed) return;
    this.lastHeavyScrollTime = performance.now();
    this.rafId = requestAnimationFrame(this.tick);
  }

  tick() {
    if (this.destroyed) return;
    
    if (!this._isVisible) {
      this.rafId = null;
      return;
    }

    this._frames++;
    const now = performance.now();
    if (now - this._lastFpsTime >= 1000) {
       this._currentFps = Math.round((this._frames * 1000) / (now - this._lastFpsTime));
       this._frames = 0;
       this._lastFpsTime = now;
    }

    if (this.options.loop && this.slides.length && this.metrics.slideSnaps.length) {
      const firstSnap = this.metrics.slideSnaps[0];
      const lastSnap = this.metrics.slideSnaps[this.slides.length - 1];
      
      if (this.currentPos < firstSnap - (this.metrics.realTrackSize / 2)) {
        this.emit('loopEnter', { position: 'start' });
        const from = this.currentPos;
        this.currentPos += this.metrics.realTrackSize;
        this.targetPos += this.metrics.realTrackSize;
        this.emit('loopReposition', { from, to: this.currentPos }); 
        this.emit('loopExit', { position: 'end' });
      } else if (this.currentPos > lastSnap + (this.metrics.realTrackSize / 2)) {
        this.emit('loopEnter', { position: 'end' });
        const from = this.currentPos;
        this.currentPos -= this.metrics.realTrackSize;
        this.targetPos -= this.metrics.realTrackSize;
        this.emit('loopReposition', { from, to: this.currentPos }); 
        this.emit('loopExit', { position: 'start' });
      }
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

    let transformVal = -this.currentPos;
    if (this.options.rtl && !this.options.vertical) transformVal = Math.abs(this.currentPos);
    
    if (this.options.vertical) {
      this.track.style.transform = `translate3d(0, ${transformVal}px, 0)`;
    } else {
      this.track.style.transform = `translate3d(${transformVal}px, 0, 0)`;
    }

    this.emit('scroll');
    
    if (now - this.lastHeavyScrollTime > 50) {
      this.emit('scrollHeavy');
      this.lastHeavyScrollTime = now;
    }

    this.rafId = requestAnimationFrame(this.tick);
  }

  // ==========================================
  // ENTERPRISE PLUGIN ARCHITECTURE
  // ==========================================

  _getAvailablePluginDefs() {
    const defs = [];
    
    if (this.root.querySelector('.yd_prev') || this.root.querySelector('.yd_next')) {
      defs.push(() => {
        let prevBtn, nextBtn, hPrev, hNext;
        return {
          name: 'controls', version: '1.0.0', author: 'yd', priority: 10,
          init: (api) => {
            prevBtn = api.root.querySelector('.yd_prev');
            nextBtn = api.root.querySelector('.yd_next');
            if (!prevBtn && !nextBtn) return false;
            hPrev = () => api.scrollPrev();
            hNext = () => api.scrollNext();
            if (prevBtn) prevBtn.addEventListener('click', hPrev);
            if (nextBtn) nextBtn.addEventListener('click', hNext);
            return true;
          },
          destroy: () => {
            if (prevBtn) prevBtn.removeEventListener('click', hPrev);
            if (nextBtn) nextBtn.removeEventListener('click', hNext);
          }
        };
      });
    }

    if (this.root.querySelector('.yd_dots')) {
      defs.push(() => {
        let dotsContainer, baseTemplate, onDotsClick, updateDots;
        const plugin = {
          name: 'dots', version: '1.0.0', author: 'yd', priority: 20,
          init: (api) => {
            dotsContainer = api.root.querySelector('.yd_dots');
            if (!dotsContainer) return false;
            
            const templateNode = dotsContainer.querySelector('.yd_dot');
            if (templateNode) {
              baseTemplate = templateNode.cloneNode(true);
              baseTemplate.classList.remove('active');
              baseTemplate.removeAttribute('aria-current');
              baseTemplate.removeAttribute('data-index');
            } else { 
              baseTemplate = document.createElement('button'); 
              baseTemplate.className = 'yd_dot'; 
            }
            
            onDotsClick = (e) => {
              const dot = e.target.closest('.yd_dot');
              if (dot) {
                const idx = parseInt(dot.getAttribute('data-index'), 10);
                if (!isNaN(idx)) api.scrollTo(idx);
              }
            };
            dotsContainer.addEventListener('click', onDotsClick);

            updateDots = (api, payload) => {
              Array.from(dotsContainer.children).forEach((dot, idx) => {
                const isActive = idx === payload.currentIndex;
                dot.classList.toggle('active', isActive);
                if (isActive) dot.setAttribute('aria-current', 'true');
                else dot.removeAttribute('aria-current');
              });
            };
            api.on('select', updateDots);
            return true;
          },
          refresh: (api) => {
            if (!dotsContainer || !baseTemplate) return;
            dotsContainer.innerHTML = '';
            if (api.metrics && api.metrics.scrollSnaps) {
              api.metrics.scrollSnaps.forEach((_, idx) => {
                const dot = baseTemplate.cloneNode(true);
                if (dot.tagName !== 'BUTTON') { dot.setAttribute('role', 'button'); dot.setAttribute('tabindex', '0'); }
                dot.setAttribute('aria-label', `Go to page ${idx + 1}`);
                dot.setAttribute('data-index', idx);
                dotsContainer.appendChild(dot);
              });
            }
            if (updateDots) updateDots(api, api.getEventPayload());
          },
          destroy: (api) => {
            if (dotsContainer) dotsContainer.removeEventListener('click', onDotsClick);
            if (updateDots) api.off('select', updateDots);
          }
        };
        return plugin;
      });
    }

    if (this.root.querySelector('.yd_counter')) {
      defs.push(() => {
        let counterEl, currentEl, totalEl, updateCounter;
        const plugin = {
          name: 'counter', version: '1.0.0', author: 'yd', priority: 30,
          init: (api) => {
            counterEl = api.root.querySelector('.yd_counter');
            if (!counterEl) return false;
            currentEl = counterEl.querySelector('.yd_current');
            totalEl = counterEl.querySelector('.yd_total');
            updateCounter = (api, payload) => {
              const currentText = payload.currentIndex + 1;
              const totalText = payload.groupCount;
              if (currentEl && totalEl) { currentEl.textContent = currentText; totalEl.textContent = totalText; }
              else counterEl.textContent = `${currentText} / ${totalText}`;
            };
            api.on('select', updateCounter);
            return true;
          },
          refresh: (api) => {
            if (counterEl && updateCounter) updateCounter(api, api.getEventPayload());
          },
          destroy: (api) => {
            if (updateCounter) api.off('select', updateCounter);
          }
        };
        return plugin;
      });
    }

    if (this.root.querySelector('.yd_progress')) {
      defs.push(() => {
        let progressEl, updateProgress;
        return {
          name: 'progress', version: '1.0.0', author: 'yd', priority: 40,
          init: (api) => {
            progressEl = api.root.querySelector('.yd_progress');
            if (!progressEl) return false;
            updateProgress = (api, payload) => {
              const pct = payload.progress * 100;
              progressEl.style.setProperty('--progress', `${pct}%`);
            };
            api.on('scrollHeavy', updateProgress);
            updateProgress(api, api.getEventPayload());
            return true;
          },
          destroy: (api) => {
            if (updateProgress) api.off('scrollHeavy', updateProgress);
          }
        };
      });
    }

    if (this.options.autoplay) {
      defs.push(() => {
        let playTimer, isPaused = false, hasStarted = false;
        let onVisPause, onVisResume, onToggleRequest, onHoverStop, onHoverPlay;
        return {
          name: 'autoplay', version: '1.0.0', author: 'yd', priority: 100,
          init: (api) => {
            if (!api.options.autoplay) return false;
            
            const start = () => {
              clearTimeout(playTimer);
              if (!hasStarted) { hasStarted = true; api.emit('autoplayStart'); } 
              else if (isPaused) { isPaused = false; api.emit('autoplayResume'); }
              if (!api.canScrollNext()) return;
              playTimer = setTimeout(() => { api.scrollNext(); start(); }, api.options.delay);
            };
            const stop = () => {
              clearTimeout(playTimer);
              if (hasStarted && !isPaused) { isPaused = true; api.emit('autoplayPause'); }
            };

            api.autoplayController = {
              play: () => start(),
              pause: () => stop(),
              toggle: () => { if (hasStarted && !isPaused) stop(); else start(); },
              isPlaying: () => hasStarted && !isPaused
            };

            onVisPause = () => stop();
            onVisResume = () => start();
            onToggleRequest = () => api.autoplayController.toggle();
            onHoverStop = () => stop();
            onHoverPlay = () => start();

            api.on('visibilityPause', onVisPause);
            api.on('visibilityResume', onVisResume);
            api.on('autoplayToggleRequest', onToggleRequest);
            api.on('dragStart', onHoverStop);
            api.on('dragEnd', onHoverPlay);
            
            if (api.root.classList.contains('pause-hover')) {
              api.root.addEventListener('mouseenter', onHoverStop);
              api.root.addEventListener('mouseleave', onHoverPlay);
            }
            api.root.addEventListener('focusin', onHoverStop);
            api.root.addEventListener('focusout', onHoverPlay);
            
            start();
            return true;
          },
          destroy: (api) => {
            if(api.autoplayController) {
               api.autoplayController.pause();
               delete api.autoplayController;
            }
            api.emit('autoplayStop');
            api.off('visibilityPause', onVisPause);
            api.off('visibilityResume', onVisResume);
            api.off('autoplayToggleRequest', onToggleRequest);
            api.off('dragStart', onHoverStop);
            api.off('dragEnd', onHoverPlay);
            api.root.removeEventListener('mouseenter', onHoverStop);
            api.root.removeEventListener('mouseleave', onHoverPlay);
            api.root.removeEventListener('focusin', onHoverStop);
            api.root.removeEventListener('focusout', onHoverPlay);
          }
        };
      });
    }

    if (this.root.querySelector('.yd_autoplay-toggle')) {
      defs.push(() => {
        let autoplayToggle, onClick, onPause, onResume, onStart;
        return {
          name: 'autoplay-toggle', version: '1.0.0', author: 'yd', priority: 110,
          init: (api) => {
            autoplayToggle = api.root.querySelector('.yd_autoplay-toggle');
            if (!autoplayToggle) return false;
            
            onClick = () => api.emit('autoplayToggleRequest');
            autoplayToggle.addEventListener('click', onClick);
            onPause = () => autoplayToggle.classList.add('paused');
            onResume = () => autoplayToggle.classList.remove('paused');
            onStart = () => autoplayToggle.classList.remove('paused');
            
            api.on('autoplayPause', onPause);
            api.on('autoplayResume', onResume);
            api.on('autoplayStart', onStart);
            return true;
          },
          destroy: (api) => {
            if (autoplayToggle) autoplayToggle.removeEventListener('click', onClick);
            if (onPause) api.off('autoplayPause', onPause);
            if (onResume) api.off('autoplayResume', onResume);
            if (onStart) api.off('autoplayStart', onStart);
          }
        };
      });
    }

    if (this.root.querySelector('.yd_autoplay-progress')) {
      defs.push(() => {
        let autoplayProgressEl, rafId, startTime, elapsed = 0, isPlaying = false;
        let delayMs, onSlideChange, onStartEvt, onResumeEvt, onPauseEvt, onStopEvt, onDragStartEvt;
        return {
          name: 'autoplay-progress', version: '1.0.0', author: 'yd', priority: 120,
          init: (api) => {
            autoplayProgressEl = api.root.querySelector('.yd_autoplay-progress');
            if (!autoplayProgressEl) return false;

            delayMs = api.options.delay;
            const tick = () => {
              if (!isPlaying) return;
              const now = performance.now();
              const currentElapsed = elapsed + (now - startTime);
              let pct = Math.min(100, (currentElapsed / delayMs) * 100);
              autoplayProgressEl.style.setProperty('--autoplay-progress', `${pct}%`);
              if (pct < 100) rafId = requestAnimationFrame(tick);
            };
            const start = () => { isPlaying = true; startTime = performance.now(); cancelAnimationFrame(rafId); rafId = requestAnimationFrame(tick); };
            const pause = () => { 
              if (!isPlaying || !startTime) return; 
              isPlaying = false; 
              elapsed += (performance.now() - startTime); 
              cancelAnimationFrame(rafId); 
            };
            const reset = () => { elapsed = 0; autoplayProgressEl.style.setProperty('--autoplay-progress', `0%`); };
            
            onSlideChange = () => { reset(); if (api.isAutoplayRunning()) start(); };
            onStartEvt = () => { reset(); start(); };
            onResumeEvt = start;
            onPauseEvt = pause;
            onStopEvt = () => { pause(); reset(); };
            onDragStartEvt = pause;
            
            api.on('activeSlideChange', onSlideChange);
            api.on('autoplayStart', onStartEvt);
            api.on('autoplayResume', onResumeEvt);
            api.on('autoplayPause', onPauseEvt);
            api.on('autoplayStop', onStopEvt);
            api.on('dragStart', onDragStartEvt);
            return true;
          },
          destroy: (api) => {
            cancelAnimationFrame(rafId);
            if (onSlideChange) api.off('activeSlideChange', onSlideChange);
            if (onStartEvt) api.off('autoplayStart', onStartEvt);
            if (onResumeEvt) api.off('autoplayResume', onResumeEvt);
            if (onPauseEvt) api.off('autoplayPause', onPauseEvt);
            if (onStopEvt) api.off('autoplayStop', onStopEvt);
            if (onDragStartEvt) api.off('dragStart', onDragStartEvt); 
          }
        };
      });
    }

    if (this.root.querySelector('.yd_scrollbar')) {
      defs.push(() => {
        let scrollbarEl, thumb, track, isDragging = false, startPos, startProgress;
        let updateThumb, onTrackClick, onPointerDown, onPointerMove, onPointerUp;
        return {
          name: 'scrollbar', version: '1.0.0', author: 'yd', priority: 50,
          init: (api) => {
            scrollbarEl = api.root.querySelector('.yd_scrollbar');
            if (!scrollbarEl) return false;
            
            thumb = scrollbarEl.querySelector('.yd_scrollbar-thumb');
            track = scrollbarEl.querySelector('.yd_scrollbar-track') || scrollbarEl;
            
            updateThumb = () => {
              if (isDragging) return;
              const pct = api.scrollProgress() * 100;
              if (thumb) thumb.style.setProperty('--scroll-progress', `${pct}%`);
            };
            api.on('scroll', updateThumb);
            updateThumb(api);
            
            onTrackClick = (e) => {
              if (e.target === thumb || isDragging) return;
              const rect = track.getBoundingClientRect();
              const clickPct = api.options.vertical ? (e.clientY - rect.top) / rect.height : (e.clientX - rect.left) / rect.width;
              const targetScroll = clickPct * api.maxScroll;
              let closestIdx = 0, minDiff = Infinity;
              api.metrics.scrollSnaps.forEach((snap, idx) => {
                if (Math.abs(snap - targetScroll) < minDiff) { minDiff = Math.abs(snap - targetScroll); closestIdx = idx; }
              });
              api.scrollTo(closestIdx);
            };
            track.addEventListener('click', onTrackClick);

            if (thumb) {
              onPointerDown = (e) => {
                isDragging = true;
                startPos = api.options.vertical ? e.clientY : e.clientX;
                startProgress = api.scrollProgress();
                thumb.setPointerCapture(e.pointerId);
                api.isDraggingActive = true;
              };
              onPointerMove = (e) => {
                if (!isDragging) return;
                const rect = track.getBoundingClientRect();
                const delta = api.options.vertical ? e.clientY - startPos : e.clientX - startPos;
                const trackSize = api.options.vertical ? rect.height : rect.width;
                let newProgress = startProgress + (delta / trackSize);
                newProgress = Math.max(0, Math.min(1, newProgress));
                thumb.style.setProperty('--scroll-progress', `${newProgress * 100}%`);
                api.targetPos = newProgress * api.maxScroll; 
              };
              onPointerUp = (e) => {
                if (!isDragging) return;
                isDragging = false;
                thumb.releasePointerCapture(e.pointerId);
                api.isDraggingActive = false;
                api.snapToClosest();
              };
              thumb.addEventListener('pointerdown', onPointerDown);
              thumb.addEventListener('pointermove', onPointerMove, api.passiveOpts);
              thumb.addEventListener('pointerup', onPointerUp, api.passiveOpts);
            }
            return true;
          },
          destroy: (api) => {
            if (updateThumb) api.off('scroll', updateThumb);
            if (track) track.removeEventListener('click', onTrackClick);
            if (thumb) {
              thumb.removeEventListener('pointerdown', onPointerDown);
              thumb.removeEventListener('pointermove', onPointerMove, api.passiveOpts);
              thumb.removeEventListener('pointerup', onPointerUp, api.passiveOpts); 
            }
          }
        };
      });
    }

    if (this.root.classList.contains('wheel')) {
      defs.push(() => {
        let onWheel, resetTimer, accumulator = 0;
        return {
          name: 'wheel', version: '1.0.0', author: 'yd', priority: 60,
          init: (api) => {
            if (!api.root.classList.contains('wheel')) return false;
            const threshold = parseInt(api.root.dataset.wheelThreshold) || 60;
            onWheel = (e) => {
              if (!api.options.vertical && Math.abs(e.deltaY) > Math.abs(e.deltaX)) return;
              e.preventDefault();
              const delta = api.options.vertical ? e.deltaY : (e.deltaX || e.deltaY);
              accumulator += delta;
              if (Math.abs(accumulator) >= threshold) {
                 accumulator > 0 ? api.scrollNext() : api.scrollPrev();
                 accumulator = 0;
              }
              clearTimeout(resetTimer);
              resetTimer = setTimeout(() => { accumulator = 0; }, 100);
            };
            api.root.addEventListener('wheel', onWheel, { passive: false });
            return true;
          },
          destroy: (api) => {
            clearTimeout(resetTimer); 
            if (onWheel) api.root.removeEventListener('wheel', onWheel);
          }
        };
      });
    }

    if (this.root.classList.contains('hash')) {
      defs.push(() => {
        let onHash, onSelect;
        return {
          name: 'hash', version: '1.0.0', author: 'yd', priority: 70,
          init: (api) => {
            if (!api.root.classList.contains('hash')) return false;
            const updateUrl = api.root.dataset.hashUpdate !== 'false';
            const hashGroup = api.hashGroup(); 
            onHash = () => {
              const rawHash = window.location.hash.replace('#', '');
              let slideHash = rawHash;
              if (hashGroup) {
                if (rawHash.startsWith(`${hashGroup}:`)) slideHash = rawHash.split(':')[1];
                else return; 
              }
              const targetSlideIdx = api.slides.findIndex(s => s.dataset.hash === slideHash);
              if (targetSlideIdx > -1) {
                 const snapTarget = api.metrics.scrollSnaps[targetSlideIdx];
                 if (snapTarget !== undefined) {
                   let closestIndex = 0, minDistance = Infinity;
                   api.metrics.scrollSnaps.forEach((p, i) => {
                     if (Math.abs(p - snapTarget) < minDistance) { minDistance = Math.abs(p - snapTarget); closestIndex = i; }
                   });
                   if (closestIndex !== api.selectedIndex()) api.scrollTo(closestIndex);
                 }
              }
            };
            onSelect = (api, payload) => {
              if (!updateUrl) return;
              const activeNode = api.activeSlide();
              const slideHash = activeNode ? activeNode.dataset.hash : null;
              if (slideHash) {
                const newHash = hashGroup ? `#${hashGroup}:${slideHash}` : `#${slideHash}`;
                history.replaceState(null, null, newHash);
              }
            };
            window.addEventListener('hashchange', onHash);
            api.on('select', onSelect);
            setTimeout(onHash, 0);
            return true;
          },
          destroy: (api) => {
            window.removeEventListener('hashchange', onHash);
            if (onSelect) api.off('select', onSelect);
          }
        };
      });
    }

    if (this.root.dataset.sync || this.syncGroup()) {
      defs.push(() => {
        let onSelect, hasSynced = false;
        return {
          name: 'sync', version: '1.0.0', author: 'yd', priority: 80,
          init: (api) => {
            const syncTarget = api.root.dataset.sync;
            const syncGroup = api.syncGroup();
            if (!syncTarget && !syncGroup) return false;

            onSelect = (api, payload) => {
              if (api._syncLock) return;

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
                if (!hasSynced) { hasSynced = true; api.emit('syncStart'); } 
                else { api.emit('syncUpdate'); }
                
                targets.forEach(targetApi => {
                  if (targetApi.selectedIndex() !== payload.currentIndex) {
                     try {
                       targetApi._syncLock = true;
                       targetApi.scrollTo(payload.currentIndex);
                     } finally {
                       queueMicrotask(() => {
                         targetApi._syncLock = false;
                       });
                     }
                  }
                });
              }
            };
            api.on('select', onSelect);
            return true;
          },
          destroy: (api) => {
            api.emit('syncStop');
            if (onSelect) api.off('select', onSelect);
          }
        };
      });
    }

    if (this.root.classList.contains('creative')) {
      defs.push(() => {
        let onScroll;
        return {
          name: 'creative', version: '1.0.0', author: 'yd', priority: 90,
          init: (api) => {
            if (!api.root.classList.contains('creative')) return false;
            onScroll = () => {
              api.slides.forEach((slide, idx) => {
                const progress = api.slideProgress(idx); 
                slide.style.setProperty('--slide-progress', progress.toFixed(4));
                slide.style.setProperty('--slide-abs-progress', Math.abs(progress).toFixed(4));
              });
            };
            api.on('scrollHeavy', onScroll);
            onScroll();
            return true;
          },
          destroy: (api) => {
            if (onScroll) api.off('scrollHeavy', onScroll);
            api.slides.forEach(s => {
              s.style.removeProperty('--slide-progress');
              s.style.removeProperty('--slide-abs-progress');
            });
          }
        };
      });
    }

    if (this.root.classList.contains('lazy-load')) {
      defs.push(() => {
        let onSelect;
        const plugin = {
          name: 'lazy-load', version: '1.0.0', author: 'yd', priority: 150,
          init: (api) => {
            if (!api.root.classList.contains('lazy-load')) return false;
            onSelect = (api, payload) => {
              const activeNode = api.activeSlide();
              if(!activeNode) return;
              const activeSlideIndex = parseInt(activeNode.getAttribute('data-slide-index'), 10);
              const toLoad = [activeSlideIndex - 1, activeSlideIndex, activeSlideIndex + 1];
              toLoad.forEach(idx => {
                let targetIdx = idx;
                if (api.isLoop()) targetIdx = (idx + (api.slides.length || 1)) % (api.slides.length || 1);
                const slide = api.slides[targetIdx];
                if (slide && !slide.dataset.loaded) {
                  const img = slide.querySelector('img[data-src]');
                  if (img && img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                  }
                  slide.dataset.loaded = "true";
                }
              });
            };
            api.on('select', onSelect);
            onSelect(api, api.getEventPayload());
            return true;
          },
          refresh: (api) => {
            if (onSelect) onSelect(api, api.getEventPayload());
          },
          destroy: (api) => {
            if (onSelect) api.off('select', onSelect);
          }
        };
        return plugin;
      });
    }

    if (this.root.classList.contains('debug')) {
      defs.push(() => {
        let debugEl, onUpdate, lastUpdate = 0;
        return {
          name: 'debug', version: '1.0.0', author: 'yd', priority: 999,
          init: (api) => {
            if (!api.root.classList.contains('debug')) return false;
            api.emit('debugOpen'); 
            debugEl = document.createElement('div');
            debugEl.className = 'yd_carousel-debug-panel';
            debugEl.style.cssText = 'position:absolute;top:0;left:0;background:rgba(0,0,0,0.8);color:#0f0;font-family:monospace;font-size:12px;padding:10px;z-index:9999;pointer-events:none;white-space:pre;line-height:1.4;';
            api.root.appendChild(debugEl);
            
            onUpdate = (api, payload) => {
              const now = performance.now();
              if (now - lastUpdate < (parseInt(api.root.dataset.debugDelay) || 150)) return; 
              lastUpdate = now;
              const state = api.state();
              const pInfo = api.performance();
              debugEl.textContent = `
[ydCarousel v${state.version}]
Idx:  ${state.index}
Prog: ${state.progress.toFixed(2)}
Drag: ${state.dragging}
Setl: ${state.settled}
Loop: ${state.looping}
Vel:  ${state.velocity.toFixed(2)}
InVw: ${pInfo.visibleSlides.join(',')}
FPS:  ${pInfo.fps}
              `.trim();
            };
            api.on('scrollHeavy', onUpdate);
            api.on('select', onUpdate);
            onUpdate(api, api.getEventPayload());
            return true;
          },
          destroy: (api) => {
            if (debugEl) debugEl.remove();
            if (onUpdate) {
              api.off('scrollHeavy', onUpdate);
              api.off('select', onUpdate);
            }
            api.emit('debugClose'); 
          }
        };
      });
    }

    return [...defs, ...ydCarousel.globalPlugins];
  }

  _initSinglePlugin(def) {
    if (this.disabledPlugins.has(def.name) || this.pluginsMap.has(def.name)) return;
    
    this.emit('beforePluginInit', { pluginName: def.name });
    try {
      const instance = typeof def === 'function' ? def() : { ...def };
      if (instance && typeof instance.init === 'function') {
        const context = { api: this, root: this.root, options: this.options, plugins: this.pluginsMap, events: this.listeners };
        const active = instance.init(this, context);
        if (active !== false) {
          const meta = {
            name: def.name,
            version: def.version || '1.0.0',
            author: def.author || 'unknown',
            instance: instance
          };
          this.plugins.push(meta);
          this.pluginsMap.set(def.name, meta);
        }
      }
    } catch (err) {
      if (ydCarousel.DEBUG) console.error(`[ydCarousel] Plugin "${def.name}" failed to initialize:`, err);
      this.failedPlugins.push({ name: def.name, reason: 'init_error', error: err, timestamp: Date.now() });
      this.emit('error', { plugin: def.name, error: err }, true);
    }
    this.emit('afterPluginInit', { pluginName: def.name });
  }

  initPlugins() {
    this.plugins.forEach(p => {
      try {
        if (p.instance && p.instance.destroy) p.instance.destroy(this);
      } catch (err) {
        if (ydCarousel.DEBUG) console.error(`[ydCarousel] Plugin "${p.name}" failed to destroy:`, err);
        this.emit('error', { plugin: p.name, action: 'destroy', error: err }, true);
      }
    });
    
    this.plugins = [];
    this.pluginsMap.clear();
    this.pluginRegistry.clear();
    this.failedPlugins = [];

    let allPluginDefs = [...this._getAvailablePluginDefs().map(f => typeof f === 'function' ? f() : { ...f })];
    
    allPluginDefs.forEach(def => {
      this.pluginRegistry.set(def.name, def);
    });

    allPluginDefs = allPluginDefs.filter(def => !this.disabledPlugins.has(def.name));
    
    const sortedDefs = [];
    const visited = new Set();
    const visiting = new Set();
    
    const resolveGraph = (def) => {
      if (def._failed) return;
      if (visited.has(def.name)) return;
      if (visiting.has(def.name)) {
        if (ydCarousel.DEBUG) console.error(`[ydCarousel] Circular dependency: ${def.name}`);
        this.emit('error', { plugin: def.name, error: new Error('Circular dependency') }, true);
        this.failedPlugins.push({ name: def.name, reason: 'circular_deps', timestamp: Date.now() });
        def._failed = true;
        return;
      }
      
      visiting.add(def.name);
      
      let dependenciesHealthy = true;
      if (def.depends) {
        def.depends.forEach(depName => {
          const depDef = allPluginDefs.find(d => d.name === depName);
          if (!depDef) {
            dependenciesHealthy = false;
            if (ydCarousel.DEBUG) console.warn(`[ydCarousel] Missing dependency: ${depName} for ${def.name}`);
            this.failedPlugins.push({
              name: def.name,
              reason: 'missing_dependency',
              dependency: depName,
              timestamp: Date.now()
            });
            this.emit('error', {
              plugin: def.name,
              action: 'resolve',
              error: new Error(`Missing dependency: ${depName}`)
            }, true);
          } else {
            resolveGraph(depDef);
            if (depDef._failed) {
              dependenciesHealthy = false;
            }
          }
        });
      }
      
      visiting.delete(def.name);
      
      if (!dependenciesHealthy) {
        def._failed = true;
      }

      if (!def._failed) {
        visited.add(def.name);
        sortedDefs.push(def);
      }
    };

    allPluginDefs.sort((a, b) => (a.priority || 1000) - (b.priority || 1000));
    allPluginDefs.forEach(def => resolveGraph(def));

    sortedDefs.forEach(def => this._initSinglePlugin(def));
  }
}

// ==========================================
// AUTO-INIT SYSTEM
// ==========================================
if (typeof document !== 'undefined') {
  document.addEventListener('DOMContentLoaded', () => ydCarousel.startAutoInit());
}
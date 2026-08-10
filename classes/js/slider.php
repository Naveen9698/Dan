/**
 * ydCarousel 2.3.10 - V2.3.10 ENTERPRISE FINAL
 * ROADMAP COMPLETION: Passes 1-10 + STABILIZATION FINALE
 * Includes: Clone Sequence Fix, 100% Progress Mapping Fix, Real-time Scrollbar Drag Responsiveness
 * 
 * DEVELOPER RULES:
 * 1. CSS REQUIREMENT: The scrollbar plugin requires external CSS for disabled states:
 *    .yd_scrollbar.disabled { pointer-events: none; opacity: 0.5; }
 * 2. EVENT MUTATION: Never directly modify `api.currentIndex` or `api.currentGroup`.
 *    Always use `api.goToGroup()`, `api.goToSlide()`, or `api.snapToClosest()`.
 */

class ydCarousel {
  static VERSION = '2.3.10'; 
  static ENGINE = 'ydCarousel-Enterprise';
  static DEBUG = false; 
  static _autoInitObserver = null;
  static _pluginRegistry = new Map();
  static activeCarousel = null; 
  static _keyboardInitialized = false; 
  static _keyboardUsers = 0; 

  static EVENTS = [
    'init', 'resize', 'destroy',
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
    'pluginRegistered', 'pluginEnabled', 'pluginDisabled'
  ];

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
    if (typeof document === 'undefined') return;
    const initAll = () => {
      document.querySelectorAll('.yd_carousel:not(.yd_carousel-ready)').forEach(el => {
        if (!el.__ydCarousel) el.__ydCarousel = new ydCarousel(el);
      });
    };
    initAll();
    if (!this._autoInitObserver) {
      this._autoInitObserver = new MutationObserver(initAll);
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
    this.track = this.root.querySelector('.yd_container');
    if (!this.track) return;
    
    this.options = {
      loop: this.root.classList.contains('loop'),
      dragFree: this.root.classList.contains('drag-free'),
      contain: this.root.classList.contains('contain'), 
      containKeep: this.root.classList.contains('contain-keep'),
      alignCenter: this.root.classList.contains('align-center'),
      alignEnd: this.root.classList.contains('align-end'),
      keyboard: this.root.classList.contains('keyboard'),
      autoplay: this.root.classList.contains('autoplay'),
      rtl: this.root.classList.contains('rtl'),
      vertical: this.root.classList.contains('vertical'),
      duration: parseFloat(this.root.dataset.duration) || 0.1,
      friction: parseFloat(this.root.dataset.friction) || 0.92,
      delay: parseInt(this.root.dataset.delay) || 4000,
      
      slideSnap: this.root.classList.contains('slide-snap'),
      groupSnap: this.root.classList.contains('group-snap')
    };

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
    
    this.isDraggingActive = false;
    this.isSettled = true;
    this.destroyed = false;        
    this.rafId = null;
    this.mutationRaf = null;

    this.dragStartPos = 0;
    this.dragStartCurrentPos = 0;
    this.lastPointerPos = 0;
    this.lastPointerTime = 0;
    this.isClickSuppressed = false;
    this._keyboardRegistered = false; 

    this.slides = []; 
    this.visibleSlides = new Set(); 

    this.metrics = {
      viewportSize: 0,
      trackSize: 0,
      realTrackSize: 0, 
      prependOffset: 0,  
      slideSizes: [],
      slideSnaps: [], 
      groupSnaps: [], 
      snapPoints: []  
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
    this.onActivate = () => { ydCarousel.activeCarousel = this; }; 

    this.init();
  }

  init() {
    if (this.destroyed) this.destroyed = false;
    
    if (!ydCarousel.activeCarousel) ydCarousel.activeCarousel = this; 
    
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

  // ==========================================
  // PUBLIC API
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
      dragging: this.isDraggingActive,
      settled: this.isSettled,
      looping: this.options.loop,
      rtl: this.options.rtl,
      vertical: this.options.vertical,
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
      build: 'enterprise-final',
      released: '2026-08'
    });
  }

  capabilities() {
    return Object.freeze({
      loop: true, dragFree: true, rtl: true, vertical: true,
      autoplay: true, keyboard: true, wheel: true, hash: true,
      sync: true, creative: true, lazyLoad: true, accessibility: true,
      debug: true, plugins: true, events: true, diagnostics: true,
      snapshots: true, observers: true, registry: true 
    });
  }

  runtimeCapabilities() {
    return Object.freeze({
      loop: this.options.loop, dragFree: this.options.dragFree,
      rtl: this.options.rtl, vertical: this.options.vertical,
      autoplay: this.options.autoplay, keyboard: this.options.keyboard,
      contain: this.options.contain, containKeep: this.options.containKeep,
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

  getEventPayload() {
    return {
      currentIndex: this.currentIndex,
      previousIndex: this.prevIndex,
      currentGroup: this.currentGroup, 
      previousGroup: this.prevGroup,
      previewIndex: this.previewIndex !== undefined ? this.previewIndex : this.currentIndex, 
      previewGroup: this.previewGroup !== undefined ? this.previewGroup : this.currentGroup,   
      slideCount: this.slides.length,
      progress: this.scrollProgress(),
      isDragging: this.isDraggingActive,
      isSettled: this.isSettled,
      looping: this.options.loop,
      direction: this._velocity > 0 ? 1 : (this._velocity < 0 ? -1 : 0)
    };
  }

  emit(event, customData = {}) {
    if (!this.listeners[event]) return;
    const payload = { ...this.getEventPayload(), ...customData };
    this.listeners[event].forEach(cb => cb(this, payload));
  }

  on(event, callback) {
    if (!this.listeners[event]) this.listeners[event] = [];
    this.listeners[event].push(callback);
    return this;
  }

  off(event, callback) {
    if (!this.listeners[event]) return;
    this.listeners[event] = this.listeners[event].filter(cb => cb !== callback);
  }

  scrollTo(index, immediate = false) { this.goToSlide(index, immediate); }
  selectedIndex() { return this.currentIndex; }
  previousIndex() { return this.prevIndex; }
  activeSlide() { return this.slides[this.currentIndex] || null; }
  slideNodes() { return this.slides; }
  isDragging() { return this.isDraggingActive; } 
  isLoop() { return this.options.loop; }        

  refresh() {
    if (this.destroyed) return;
    this.updateMeasurements();
  }

  reInit() {
    const root = this.root;
    this.destroy();
    root.__ydCarousel = new ydCarousel(root);
    return root.__ydCarousel;
  }

  canScrollNext() {
    if (this.root.classList.contains('stop-last')) {
      if (this.options.slideSnap) return this.currentIndex < this.slides.length - 1;
      return this.currentGroup < this.metrics.groupSnaps.length - 1;
    }
    if (this.options.slideSnap) return this.options.loop || this.currentIndex < this.slides.length - 1;
    return this.options.loop || this.currentGroup < this.metrics.groupSnaps.length - 1;
  }

  canScrollPrev() {
    if (this.options.slideSnap) return this.options.loop || this.currentIndex > 0;
    return this.options.loop || this.currentGroup > 0;
  }

  // FIX: 100% Mapping for both Scrollbars and Progress Bars exactly mapping to the final valid visual slide
  scrollProgress() {
    if (this.options.loop) {
      const snaps = this.options.slideSnap ? this.metrics.slideSnaps : this.metrics.groupSnaps;
      const relativeMaxSnap = Math.max(1, (snaps[snaps.length - 1] || 0) - this.metrics.prependOffset);
      
      let relativePos = this.currentPos - this.metrics.prependOffset;
      if (this.metrics.realTrackSize > 0) {
        relativePos = ((relativePos % this.metrics.realTrackSize) + this.metrics.realTrackSize) % this.metrics.realTrackSize;
      }
      return Math.max(0, Math.min(1, relativePos / relativeMaxSnap));
    }
    if (!this.maxScroll) return 0;
    return Math.max(0, Math.min(1, this.currentPos / this.maxScroll));
  }

  slideProgress(index) {
    const snap = this.metrics.slideSnaps[index] || 0;
    let distance = this.currentPos - snap;
    
    if (this.options.loop && this.metrics.realTrackSize > 0) {
      const distFwd = distance - this.metrics.realTrackSize;
      const distBwd = distance + this.metrics.realTrackSize;
      if (Math.abs(distFwd) < Math.abs(distance)) distance = distFwd;
      if (Math.abs(distBwd) < Math.abs(distance)) distance = distBwd;
    }
    
    const progress = distance / (this.metrics.viewportSize || 1);
    return Math.max(-1, Math.min(1, progress));
  }

  slidesInView() {
    return [...this.visibleSlides].sort((a, b) => a - b);
  }

  slidesNotInView() {
    return this.slides.map((_, idx) => idx).filter(idx => !this.visibleSlides.has(idx));
  }

  // ==========================================
  // HELPERS 
  // ==========================================
  
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
      if (this.options.loop) {
        const distFwd = Math.abs((snap + this.metrics.realTrackSize) - searchPos);
        const distBwd = Math.abs((snap - this.metrics.realTrackSize) - searchPos);
        dist = Math.min(dist, distFwd, distBwd);
      }
      if (dist < minDistance) {
        minDistance = dist;
        nearest = idx;
      }
    });
    return nearest;
  }

  // ==========================================
  // MEASUREMENTS
  // ==========================================
  
  updateMeasurements() {
    this.visibleSlides.clear();

    if (this.mutationObserver) this.mutationObserver.disconnect();
    this.track.querySelectorAll('.yd_slide-clone').forEach(clone => clone.remove());
    
    this.slides = Array.from(this.track.children);
    if (!this.slides.length) return;

    this.slides.forEach((slide, idx) => {
      slide.setAttribute('data-slide-index', idx);
    });

    const viewportEl = this.root.querySelector('.yd_viewport') || this.root;
    const rect = viewportEl.getBoundingClientRect();
    this.metrics.viewportSize = this.options.vertical ? rect.height : rect.width;
    
    this.metrics.slideSizes = this.slides.map(slide => {
      const sRect = slide.getBoundingClientRect();
      return this.options.vertical ? sRect.height : sRect.width;
    });
    
    this.metrics.realTrackSize = this.metrics.slideSizes.reduce((a, b) => a + b, 0);
    this.metrics.prependOffset = 0;

    if (this.options.loop && this.slides.length > 1) {
      this.metrics.prependOffset = this.metrics.realTrackSize;
      const clonesBefore = this.slides.map(s => this.createClone(s));
      const clonesAfter = this.slides.map(s => this.createClone(s));
      
      // FIX: Proper Sequential Clone Insertion avoids 3, 2, 1 reversed startup jump
      const firstOriginal = this.slides[0];
      clonesBefore.forEach(c => this.track.insertBefore(c, firstOriginal));
      clonesAfter.forEach(c => this.track.appendChild(c));
    }

    this.metrics.trackSize = this.options.vertical ? this.track.scrollHeight : this.track.scrollWidth;
    
    let currentOffset = this.metrics.prependOffset;
    let currentGroupStart = currentOffset;
    
    this.metrics.slideSnaps = [];
    this.metrics.groupSnaps = [];
    
    this.metrics.slideSizes.forEach((size, idx) => {
      let snap = currentOffset;
      if (this.options.alignCenter) snap -= (this.metrics.viewportSize / 2) - (size / 2);
      if (this.options.alignEnd) snap -= this.metrics.viewportSize - size;
      this.metrics.slideSnaps.push(Math.max(0, snap));

      if (idx === 0) {
        this.metrics.groupSnaps.push(Math.max(0, snap));
      } else {
        if (currentOffset - currentGroupStart + size > this.metrics.viewportSize) {
          currentGroupStart = snap;
          this.metrics.groupSnaps.push(Math.max(0, currentGroupStart));
        }
      }
      currentOffset += size;
    });

    const lastSnap = this.metrics.slideSnaps[this.metrics.slideSnaps.length - 1] || 0;
    this.maxScroll = (this.options.contain || this.options.containKeep) 
      ? Math.max(0, this.metrics.trackSize - this.metrics.viewportSize) 
      : lastSnap;

    if (!this.options.loop && (this.options.contain || this.options.containKeep)) {
      this.metrics.slideSnaps = this.metrics.slideSnaps.map(snap => Math.max(0, Math.min(snap, this.maxScroll)));
      let rawGroups = this.metrics.groupSnaps.map(snap => Math.max(0, Math.min(snap, this.maxScroll)));
      this.metrics.groupSnaps = [...new Set(rawGroups)]; 
    }

    this.metrics.snapPoints = this.options.slideSnap ? this.metrics.slideSnaps : this.metrics.groupSnaps;

    if (this.visibilityObserver) {
      this.visibilityObserver.disconnect();
      Array.from(this.track.children).forEach(node => this.visibilityObserver.observe(node));
    }

    if (this.mutationObserver) {
      this.mutationObserver.observe(this.track, { childList: true, subtree: true, attributes: true, attributeFilter: ['src', 'style', 'class'] });
    }

    this.emit('resize');
    
    if (this.options.slideSnap) {
      this.goToSlide(this.currentIndex, true);
    } else {
      this.goToGroup(this.currentGroup, true);
    }
  }

  createClone(slide) {
    const clone = slide.cloneNode(true);
    clone.classList.add('yd_slide-clone');
    clone.setAttribute('aria-hidden', 'true');
    clone.removeAttribute('aria-current');
    clone.classList.remove('active', 'prev', 'next', 'in-view', 'out-view');
    
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
  // OBSERVERS
  // ==========================================
  
  setupObservers() {
    this.resizeObserver = new ResizeObserver(this.onResize);
    this.resizeObserver.observe(this.root);
    this.mutationObserver = new MutationObserver(this.onMutation);

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

  onResize() { this.updateMeasurements(); }

  onMutation(mutations) {
    if (mutations.some(m => m.target.classList && m.target.classList.contains('yd_slide-clone'))) return;
    if (this.mutationRaf) cancelAnimationFrame(this.mutationRaf);
    
    this.mutationRaf = requestAnimationFrame(() => {
      const oldLength = this.slides.length;
      const realNodes = Array.from(this.track.children).filter(el => !el.classList.contains('yd_slide-clone'));
      const newLength = realNodes.length;

      this.updateMeasurements();
      if (newLength !== oldLength) this.initPlugins(); 
    });
  }

  // ==========================================
  // POINTER & EVENTS
  // ==========================================

  getPointerPos(e) { return this.options.vertical ? e.clientY : e.clientX; }

  _registerKeyboard() {
    if (!this._keyboardRegistered) {
      ydCarousel._keyboardUsers++;
      this._keyboardRegistered = true;
      if (!ydCarousel._keyboardInitialized) {
        document.addEventListener('keydown', ydCarousel._globalKeyDownHandler);
        ydCarousel._keyboardInitialized = true;
      }
    }
  }

  _unregisterKeyboard() {
    if (this._keyboardRegistered) {
      ydCarousel._keyboardUsers--;
      this._keyboardRegistered = false;
      if (ydCarousel._keyboardUsers <= 0) {
        document.removeEventListener('keydown', ydCarousel._globalKeyDownHandler);
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
    this.track.addEventListener('pointerdown', this.onActivate);

    if (this.options.keyboard) {
      this.root.setAttribute('tabindex', '0');
      this._registerKeyboard();
    }
  }

  unbindEvents() {
    this.track.removeEventListener('pointerdown', this.onPointerDown);
    this.track.removeEventListener('click', this.onClick, { capture: true });
    window.removeEventListener('pointermove', this.onPointerMove);
    window.removeEventListener('pointerup', this.onPointerUp);
    
    this.root.removeEventListener('mouseenter', this.onActivate);
    this.root.removeEventListener('focusin', this.onActivate);
    this.track.removeEventListener('pointerdown', this.onActivate);

    if (this.options.keyboard) {
      this._unregisterKeyboard();
    }
  }

  onPointerDown(e) {
    if (e.button !== 0) return; 
    this.isDraggingActive = true;
    this.isClickSuppressed = false;
    this.dragStartPos = this.getPointerPos(e);
    this.dragStartCurrentPos = this.targetPos;
    
    this.lastPointerPos = this.getPointerPos(e);
    this.lastPointerTime = performance.now();
    this._velocity = 0;
    this.inertia = 0; 

    this.previewIndex = this.currentIndex;
    this.previewGroup = this.currentGroup;

    this.track.setPointerCapture(e.pointerId);
    this.track.style.cursor = 'grabbing';
    
    window.addEventListener('pointermove', this.onPointerMove);
    window.addEventListener('pointerup', this.onPointerUp);
    
    this.emit('dragStart');
    e.preventDefault(); 
  }

  onPointerMove(e) {
    if (!this.isDraggingActive) return;
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
    if (!this.isDraggingActive) return;
    this.isDraggingActive = false;
    
    try { this.track.releasePointerCapture(e.pointerId); } catch(err) {}
    this.track.style.cursor = '';

    window.removeEventListener('pointermove', this.onPointerMove);
    window.removeEventListener('pointerup', this.onPointerUp);
    this.emit('dragEnd');

    if (this.options.dragFree) {
      this.inertia = -this._velocity * 40; 
    } else {
      if (Math.abs(this._velocity) > 0.5) {
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
    if (ydCarousel.activeCarousel && ydCarousel.activeCarousel !== this) return;

    const isRtl = this.options.rtl;
    const isVert = this.options.vertical;
    
    if (e.key === 'Home') this.options.slideSnap ? this.goToSlide(0) : this.goToGroup(0);
    if (e.key === 'End') this.options.slideSnap ? this.goToSlide(this.slides.length - 1) : this.goToGroup(this.metrics.groupSnaps.length - 1);
    
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
  // PHYSICS & LIFECYCLE 
  // ==========================================

  startPhysicsLoop() {
    this.rafId = requestAnimationFrame(this.tick);
  }

  tick() {
    if (this.destroyed) return;

    if (this.options.loop) {
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
    this.rafId = requestAnimationFrame(this.tick);
  }

  destroy() {
    this.destroyed = true; 
    cancelAnimationFrame(this.rafId);
    if (this.mutationRaf) cancelAnimationFrame(this.mutationRaf);
    
    this.unbindEvents();
    if (this.resizeObserver) { this.resizeObserver.disconnect(); this.resizeObserver = null; }
    if (this.mutationObserver) { this.mutationObserver.disconnect(); this.mutationObserver = null; }
    if (this.visibilityObserver) { this.visibilityObserver.disconnect(); this.visibilityObserver = null; }
    
    if (this.announceHandler) this.off('select', this.announceHandler);

    this.plugins.forEach(p => p.destroy && p.destroy(this));
    this.plugins = []; 
    
    this.activePlugins.forEach((active, name) => this.disablePlugin(name));

    this.root.classList.remove('yd_carousel-ready');
    this.track.style.transform = '';
    this.track.querySelectorAll('.yd_slide-clone').forEach(clone => clone.remove());
    this.visibleSlides.clear();

    if (this.root.__ydCarousel === this) {
      delete this.root.__ydCarousel;
    }
    
    if (ydCarousel.activeCarousel === this) {
      ydCarousel.activeCarousel = null;
      const readyCarousels = Array.from(document.querySelectorAll('.yd_carousel-ready'))
        .map(el => el.__ydCarousel)
        .filter(api => api && api !== this && !api.destroyed);
      
      if (readyCarousels.length > 0) {
        const withKeyboard = readyCarousels.find(api => api.options.keyboard);
        ydCarousel.activeCarousel = withKeyboard || readyCarousels[0];
      }
    }

    this.emit('destroy');
    this.listeners = {}; 
  }

  // ==========================================
  // SNAP BASED NAVIGATION
  // ==========================================

  goToGroup(groupIndex, immediate = false) {
    const maxGroup = this.metrics.groupSnaps.length - 1;
    const targetGroup = Math.max(0, Math.min(groupIndex, maxGroup));
    
    const changed = (this.currentGroup !== targetGroup);

    if (changed) {
      this.emit('beforeSelect', { currentGroup: this.currentGroup, targetGroup });
      this.prevGroup = this.currentGroup;
      this.currentGroup = targetGroup;
      this.previewGroup = this.currentGroup;
      this.emit('activeGroupChange', { currentGroup: this.currentGroup, previousGroup: this.prevGroup });
    }
    
    let nextTarget = this.metrics.groupSnaps[this.currentGroup];
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

    this.prevIndex = this.currentIndex;
    this.currentIndex = this.findNearestSlide(nextTarget);
    this.previewIndex = this.currentIndex;
    
    if (this.currentIndex !== this.prevIndex) {
      this.emit('activeSlideChange', { currentIndex: this.currentIndex, previousIndex: this.prevIndex });
    }
    
    this.updateSlideStates();

    if (changed || immediate) {
      this.emit('select');
      this.emit('afterSelect'); 
    }
  }

  goToSlide(slideIndex, immediate = false) {
    const maxSlide = this.metrics.slideSnaps.length - 1;
    const targetSlide = Math.max(0, Math.min(slideIndex, maxSlide));

    if (this.options.slideSnap) {
      const changed = (this.currentIndex !== targetSlide);

      if (changed) {
        this.emit('beforeSelect', { currentIndex: this.currentIndex, targetIndex: targetSlide });
        this.prevIndex = this.currentIndex;
        this.currentIndex = targetSlide;
        this.previewIndex = this.currentIndex;
        this.emit('activeSlideChange', { currentIndex: this.currentIndex, previousIndex: this.prevIndex });
      }
      
      let nextTarget = this.metrics.slideSnaps[this.currentIndex];
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

      let targetGroup = 0;
      for (let i = 0; i < this.metrics.groupSnaps.length; i++) {
        if (this.metrics.groupSnaps[i] <= nextTarget) targetGroup = i;
        else break;
      }
      if (this.currentGroup !== targetGroup) {
         this.prevGroup = this.currentGroup;
         this.currentGroup = targetGroup;
         this.previewGroup = this.currentGroup;
         this.emit('activeGroupChange', { currentGroup: this.currentGroup, previousGroup: this.prevGroup });
      }
      
      this.updateSlideStates();

      if (changed || immediate) {
        this.emit('select');
        this.emit('afterSelect'); 
      }
      return;
    }

    const targetSnap = this.metrics.slideSnaps[targetSlide];
    let targetGroup = 0;
    for (let i = 0; i < this.metrics.groupSnaps.length; i++) {
      if (this.metrics.groupSnaps[i] <= targetSnap) targetGroup = i;
      else break;
    }
    this.goToGroup(targetGroup, immediate);
  }

  snapToClosest() {
    let closestIndex = 0;
    let minDistance = Infinity;
    const snaps = this.options.slideSnap ? this.metrics.slideSnaps : this.metrics.groupSnaps;
    
    snaps.forEach((point, index) => {
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
       this.targetPos = snaps[closestIndex];
    } else {
       if (this.options.slideSnap) {
         this.goToSlide(closestIndex);
       } else {
         this.goToGroup(closestIndex);
       }
    }
  }

  scrollNext() {
    if (this.options.slideSnap) {
      if (this.options.loop) {
        this.goToSlide((this.currentIndex + 1) % this.slides.length);
      } else {
        this.goToSlide(Math.min(this.currentIndex + 1, this.slides.length - 1));
      }
      return;
    }
    
    if (this.currentGroup < this.metrics.groupSnaps.length - 1) {
      this.goToGroup(this.currentGroup + 1);
    } else if (this.options.loop && this.canScrollNext()) {
      this.goToGroup(0);
    }
  }

  scrollPrev() {
    if (this.options.slideSnap) {
      if (this.options.loop) {
        this.goToSlide((this.currentIndex - 1 + this.slides.length) % this.slides.length);
      } else {
        this.goToSlide(Math.max(this.currentIndex - 1, 0));
      }
      return;
    }
    
    if (this.currentGroup > 0) {
      this.goToGroup(this.currentGroup - 1);
    } else if (this.options.loop && this.canScrollPrev()) {
      this.goToGroup(this.metrics.groupSnaps.length - 1);
    }
  }

  // FIX: Clone Active State Sync securely maps classes eliminating any boundary visual glitch
  updateSlideStates() {
    const total = this.slides.length;
    const prevIdx = this.options.loop ? (total + this.currentIndex - 1) % total : this.currentIndex - 1;
    const nextIdx = this.options.loop ? (this.currentIndex + 1) % total : this.currentIndex + 1;

    this.slides.forEach((slide, idx) => {
      slide.classList.remove('active', 'prev', 'next');
      slide.removeAttribute('aria-current');
      if (idx === this.currentIndex) {
        slide.classList.add('active');
        slide.setAttribute('aria-current', 'true');
      } else if (idx === prevIdx) {
        slide.classList.add('prev');
      } else if (idx === nextIdx) {
        slide.classList.add('next');
      }
    });

    if (this.options.loop) {
      const clones = this.track.querySelectorAll('.yd_slide-clone');
      clones.forEach(clone => {
        const idx = parseInt(clone.getAttribute('data-slide-index'), 10);
        clone.classList.remove('active', 'prev', 'next');
        clone.removeAttribute('aria-current');
        if (idx === this.currentIndex) {
          clone.classList.add('active');
          clone.setAttribute('aria-current', 'true');
        } else if (idx === prevIdx) {
          clone.classList.add('prev');
        } else if (idx === nextIdx) {
          clone.classList.add('next');
        }
      });
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
      announcer.textContent = `Slide ${payload.currentIndex + 1} of ${api.slides.length}`;
    };
    this.on('select', this.announceHandler);
  }

  // ==========================================
  // ENTERPRISE PLUGIN MANAGEMENT
  // ==========================================

  enablePlugin(name) {
    if (this.activePlugins.has(name)) return;
    const pluginDef = ydCarousel._pluginRegistry.get(name);
    if (!pluginDef) return;
    const instance = pluginDef.init(this);
    this.activePlugins.set(name, { def: pluginDef, instance });
    this.emit('pluginEnabled', { name });
  }

  disablePlugin(name) {
    const active = this.activePlugins.get(name);
    if (active) {
      if (active.def.destroy) active.def.destroy(this, active.instance);
      this.activePlugins.delete(name);
      this.emit('pluginDisabled', { name });
    }
  }

  initEnterprisePlugins() {
    ydCarousel._pluginRegistry.forEach((_, name) => this.enablePlugin(name));
  }

  // ==========================================
  // CORE & ROADMAP PLUGINS 
  // ==========================================

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
            hPrev = () => api.scrollPrev();
            hNext = () => api.scrollNext();
            if (prevBtn) prevBtn.addEventListener('click', hPrev);
            if (nextBtn) nextBtn.addEventListener('click', hNext);
          },
          destroy: () => {
            if (prevBtn) prevBtn.removeEventListener('click', hPrev);
            if (nextBtn) nextBtn.removeEventListener('click', hNext);
          }
        };
      })();
      controls.init(this);
      this.plugins.push(controls);
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
            
            const snaps = api.options.slideSnap ? api.metrics.slideSnaps : api.metrics.groupSnaps;
            snaps.forEach((_, idx) => {
              let dot = template ? template.cloneNode(true) : document.createElement('button');
              if (!template) dot.className = 'yd_dot';
              dot.setAttribute('aria-label', `Go to ${api.options.slideSnap ? 'slide' : 'group'} ${idx + 1}`);
              dot.addEventListener('click', () => {
                if (api.options.slideSnap) api.goToSlide(idx);
                else api.goToGroup(idx);
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
                if (isActive) dot.setAttribute('aria-current', 'true');
                else dot.removeAttribute('aria-current');
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
      dots.init(this);
      this.plugins.push(dots);
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
              const total = api.options.slideSnap ? api.slides.length : api.metrics.groupSnaps.length;

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
      counter.init(this);
      this.plugins.push(counter);
    }

    // SCROLLBAR CONTROL 
    const scrollbar = this.root.querySelector('.yd_scrollbar');
    if (scrollbar) {
      const sbPlugin = (() => {
        let updateThumbSize, updateProgress, onClickTrack;
        let onThumbDown, onThumbMove, onThumbUp;
        let isDraggingThumb = false;
        let isDisabled = false;
        let startX = 0;
        let startProgress = 0;

        return {
          name: 'scrollbar',
          init: (api) => {
            let thumb = scrollbar.querySelector('.yd_scrollbar-thumb');
            
            if (!thumb) {
              thumb = document.createElement('div');
              thumb.className = 'yd_scrollbar-thumb';
              scrollbar.appendChild(thumb);
            }

            updateThumbSize = () => {
              if (api.metrics.realTrackSize <= api.metrics.viewportSize && !api.options.loop) {
                isDisabled = true;
                scrollbar.classList.add('disabled');
                scrollbar.setAttribute('aria-disabled', 'true');
                thumb.setAttribute('tabindex', '-1');
                thumb.style.width = '100%';
                thumb.style.transform = 'translate3d(0,0,0)'; 
              } else {
                isDisabled = false;
                scrollbar.classList.remove('disabled');
                scrollbar.removeAttribute('aria-disabled');
                thumb.removeAttribute('tabindex');
                const ratio = api.metrics.viewportSize / (api.metrics.realTrackSize || 1);
                thumb.style.width = `${Math.max(10, Math.min(100, ratio * 100))}%`;
              }
            };

            // FIX: Fast Thumb Drag Responsiveness Sync
            updateProgress = (api, payload) => {
              if (isDisabled || isDraggingThumb) return; 
              const movableSpace = scrollbar.offsetWidth - thumb.offsetWidth;
              thumb.style.transform = `translate3d(${payload.progress * movableSpace}px, 0, 0)`;
            };

            onClickTrack = (e) => {
              if (isDisabled || e.target === thumb) return; 
              const rect = scrollbar.getBoundingClientRect();
              const pct = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width));
              
              if (api.options.loop) {
                 const snaps = api.options.slideSnap ? api.metrics.slideSnaps : api.metrics.groupSnaps;
                 const relativeMaxSnap = Math.max(1, (snaps[snaps.length - 1] || 0) - api.metrics.prependOffset);
                 const targetPos = pct * relativeMaxSnap;
                 const targetSlide = api.findNearestSlide(targetPos + api.metrics.prependOffset);
                 
                 if (api.options.slideSnap) {
                   api.goToSlide(targetSlide);
                 } else {
                   let minGroupDist = Infinity, closestGroup = 0;
                   api.metrics.groupSnaps.forEach((p, i) => {
                     let dist = Math.abs(p - (targetPos + api.metrics.prependOffset));
                     if (dist < minGroupDist) { minGroupDist = dist; closestGroup = i; }
                   });
                   api.goToGroup(closestGroup);
                 }
              } else {
                 api.targetPos = pct * api.maxScroll;
                 api.snapToClosest();
              }
            };

            onThumbDown = (e) => {
              if (isDisabled || e.button !== 0) return;
              e.preventDefault();
              e.stopPropagation();
              isDraggingThumb = true;
              startX = e.clientX;
              startProgress = api.scrollProgress();

              api.previewIndex = api.currentIndex;
              api.previewGroup = api.currentGroup;

              thumb.setPointerCapture(e.pointerId);
              thumb.style.cursor = 'grabbing';
              
              document.addEventListener('pointermove', onThumbMove);
              document.addEventListener('pointerup', onThumbUp);
              document.addEventListener('pointercancel', onThumbUp);
            };

            onThumbMove = (e) => {
              if (!isDraggingThumb) return;
              const movableSpace = scrollbar.offsetWidth - thumb.offsetWidth;
              if (movableSpace <= 0) return;
              
              const deltaX = e.clientX - startX;
              const progressDelta = deltaX / movableSpace;
              
              // Direct 1:1 Thumb visual mapping for snappy feel
              const rawProgress = Math.max(0, Math.min(1, startProgress + progressDelta));
              thumb.style.transform = `translate3d(${rawProgress * movableSpace}px, 0, 0)`;
              
              let dragFactor = parseFloat(api.root.dataset.dragFactor);
              if (!Number.isFinite(dragFactor) || dragFactor <= 0) {
                 dragFactor = 1.0; 
              }
              
              const snaps = api.options.slideSnap ? api.metrics.slideSnaps : api.metrics.groupSnaps;
              const relativeMaxSnap = Math.max(1, (snaps[snaps.length - 1] || 0) - api.metrics.prependOffset);
              const dragDistance = api.options.loop ? (relativeMaxSnap * dragFactor) : api.maxScroll;
              
              let newTarget = (startProgress * dragDistance) + (progressDelta * dragDistance);
              if (api.options.loop) {
                 newTarget += api.metrics.prependOffset;
              } else {
                 newTarget = Math.max(0, Math.min(newTarget, api.maxScroll));
              }
              
              // FIX: Instantly lock the carousel track to visual thumb pointer for snappiness
              api.targetPos = newTarget;
              api.currentPos = newTarget; 

              let searchTarget = newTarget;
              if (api.options.loop && api.metrics.realTrackSize > 0) {
                 let rel = newTarget - api.metrics.prependOffset;
                 rel = ((rel % api.metrics.realTrackSize) + api.metrics.realTrackSize) % api.metrics.realTrackSize;
                 searchTarget = rel + api.metrics.prependOffset;
              }

              let previewUpdated = false;

              if (!api.options.slideSnap) {
                let minGroupDist = Infinity, closestGroup = api.previewGroup;
                let distToCurrent = Infinity;
                
                const currentEvalGroup = api.previewGroup !== undefined ? api.previewGroup : api.currentGroup;
                
                if (api.metrics.groupSnaps[currentEvalGroup] !== undefined) {
                   distToCurrent = Math.abs(api.metrics.groupSnaps[currentEvalGroup] - searchTarget);
                   if (api.options.loop && api.metrics.realTrackSize > 0) {
                      const dFwd = Math.abs((api.metrics.groupSnaps[currentEvalGroup] + api.metrics.realTrackSize) - searchTarget);
                      const dBwd = Math.abs((api.metrics.groupSnaps[currentEvalGroup] - api.metrics.realTrackSize) - searchTarget);
                      distToCurrent = Math.min(distToCurrent, dFwd, dBwd);
                   }
                }

                api.metrics.groupSnaps.forEach((p, i) => {
                   let dist = Math.abs(p - searchTarget);
                   if (api.options.loop && api.metrics.realTrackSize > 0) {
                      const distFwd = Math.abs((p + api.metrics.realTrackSize) - searchTarget);
                      const distBwd = Math.abs((p - api.metrics.realTrackSize) - searchTarget);
                      dist = Math.min(dist, distFwd, distBwd);
                   }
                   if (dist < minGroupDist) { minGroupDist = dist; closestGroup = i; }
                });
                
                const hysteresis = Math.min(12, Math.max(5, api.metrics.viewportSize * 0.01));
                if (currentEvalGroup !== closestGroup && minGroupDist < distToCurrent - hysteresis) {
                   api.previewGroup = closestGroup;
                   previewUpdated = true;
                }
              }

              let nearestSlide = api.findNearestSlide(newTarget);
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
              
              try { thumb.releasePointerCapture(e.pointerId); } catch(err) {}
              thumb.style.cursor = '';
              
              document.removeEventListener('pointermove', onThumbMove);
              document.removeEventListener('pointerup', onThumbUp);
              document.removeEventListener('pointercancel', onThumbUp);
              
              api.previewIndex = api.currentIndex;
              api.previewGroup = api.currentGroup;

              api.snapToClosest();
            };

            api.on('resize', updateThumbSize);
            api.on('scroll', updateProgress);
            scrollbar.addEventListener('click', onClickTrack);
            thumb.addEventListener('pointerdown', onThumbDown);
            
            updateThumbSize();
            updateProgress(api, api.getEventPayload());
          },
          destroy: (api) => {
            api.off('resize', updateThumbSize);
            api.off('scroll', updateProgress);
            scrollbar.removeEventListener('click', onClickTrack);
            let thumb = scrollbar.querySelector('.yd_scrollbar-thumb');
            if (thumb) {
              thumb.removeEventListener('pointerdown', onThumbDown);
            }
            document.removeEventListener('pointermove', onThumbMove);
            document.removeEventListener('pointerup', onThumbUp);
            document.removeEventListener('pointercancel', onThumbUp);
          }
        };
      })();
      sbPlugin.init(this);
      this.plugins.push(sbPlugin);
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
              const pct = payload.progress * 100;
              progressEl.style.setProperty('--progress', `${pct}%`);
            };
            api.on('scroll', updateProgress);
            updateProgress(api, api.getEventPayload());
          },
          destroy: (api) => api.off('scroll', updateProgress)
        };
      })();
      progress.init(this);
      this.plugins.push(progress);
    }

    // AUTOPLAY PROGRESS & SYSTEM
    if (this.options.autoplay) {
      const autoplay = (() => {
        let playTimer, play, stop, stopPermanent, loopProgress, onVisChange, onFocusIn, onFocusOut, onSelect;
        let isPaused = false;
        let hasStarted = false;
        let permanentlyStopped = false; 
        let isAutoScrolling = false; // FIX: Guard to prevent double timer resets on auto advance
        let startTime = 0;
        let animRaf = null;
        
        return {
          name: 'autoplay',
          init: (api) => {
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
            
            loopProgress = () => {
              if (isPaused) return;
              const elapsed = performance.now() - startTime;
              const pct = Math.min(100, (elapsed / api.options.delay) * 100);
              if (apProgressEl) apProgressEl.style.setProperty('--ap-progress', `${pct}%`);
              if (pct < 100) animRaf = requestAnimationFrame(loopProgress);
            };

            stopPermanent = () => {
              if (permanentlyStopped) return;
              permanentlyStopped = true;
              clearTimeout(playTimer);
              cancelAnimationFrame(animRaf);
              hasStarted = false;
              isPaused = false;
              api.emit('autoplayStop');
            };

            api.resetAutoplay = () => {
               permanentlyStopped = false;
               const ready = api.options.slideSnap ? api.metrics.slideSnaps.length > 0 : api.metrics.groupSnaps.length > 0;
               if (!hasStarted && ready) play();
            };

            play = () => {
              if (permanentlyStopped) return; 
              clearTimeout(playTimer);
              cancelAnimationFrame(animRaf);
              
              if (!hasStarted) {
                hasStarted = true;
                api.emit('autoplayStart');
              } else if (isPaused) {
                isPaused = false;
                api.emit('autoplayResume'); 
              }
              
              if (!api.canScrollNext()) {
                if (apProgressEl) apProgressEl.style.setProperty('--ap-progress', `100%`);
                stopPermanent();
                return;
              }

              startTime = performance.now();
              loopProgress();
              
              // FIX: isAutoScrolling prevents user interaction resets triggered falsely by engine advancing
              playTimer = setTimeout(() => {
                isAutoScrolling = true;
                api.scrollNext(); 
                isAutoScrolling = false;
                play(); 
              }, api.options.delay);
            };
            
            stop = () => {
              clearTimeout(playTimer);
              cancelAnimationFrame(animRaf);
              if (hasStarted && !isPaused && !permanentlyStopped) {
                isPaused = true;
                api.emit('autoplayPause');
              }
            };

            onSelect = () => {
               if (hasStarted && !isPaused && !isAutoScrolling) play(); 
            };

            onVisChange = () => document.hidden ? stop() : play();
            onFocusIn = () => stop();
            onFocusOut = () => play();

            api.on('dragStart', stop);
            api.on('dragEnd', play);
            api.on('select', onSelect); 
            if (api.root.classList.contains('pause-hover')) {
              api.root.addEventListener('mouseenter', stop);
              api.root.addEventListener('mouseleave', play);
            }
            document.addEventListener('visibilitychange', onVisChange);
            api.root.addEventListener('focusin', onFocusIn);
            api.root.addEventListener('focusout', onFocusOut);
            
            requestAnimationFrame(() => {
              const ready = api.options.slideSnap ? api.metrics.slideSnaps.length > 0 : api.metrics.groupSnaps.length > 0;
              if (ready) {
                play();
              }
            });
          },
          destroy: (api) => {
            stop();
            if (!permanentlyStopped) {
               api.emit('autoplayStop');
            }
            delete api.resetAutoplay; 
            
            api.off('dragStart', stop);
            api.off('dragEnd', play);
            api.off('select', onSelect);
            api.root.removeEventListener('mouseenter', stop);
            api.root.removeEventListener('mouseleave', play);
            document.removeEventListener('visibilitychange', onVisChange);
            api.root.removeEventListener('focusin', onFocusIn);
            api.root.removeEventListener('focusout', onFocusOut);
          }
        };
      })();
      autoplay.init(this);
      this.plugins.push(autoplay);
    }

    // MOUSEWHEEL NAVIGATION
    if (this.root.classList.contains('wheel')) {
      const wheel = (() => {
        let onWheel, resetTimer;
        let accumulator = 0;
        return {
          name: 'wheel',
          init: (api) => {
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
          },
          destroy: (api) => {
            clearTimeout(resetTimer); 
            api.root.removeEventListener('wheel', onWheel);
          }
        };
      })();
      wheel.init(this);
      this.plugins.push(wheel);
    }

    // HASH NAVIGATION
    if (this.root.classList.contains('hash')) {
      const hashPlugin = (() => {
        let onHash, onSelect;
        return {
          name: 'hash',
          init: (api) => {
            const updateUrl = api.root.dataset.hashUpdate !== 'false';
            const hashGroup = api.hashGroup(); 
            
            onHash = () => {
              const rawHash = window.location.hash.replace('#', '');
              let slideHash = rawHash;
              if (hashGroup) {
                if (rawHash.startsWith(`${hashGroup}:`)) {
                  slideHash = rawHash.split(':')[1];
                } else {
                  return; 
                }
              }
              const targetIdx = api.slides.findIndex(s => s.dataset.hash === slideHash);
              if (targetIdx > -1 && targetIdx !== api.currentIndex) api.goToSlide(targetIdx);
            };
            
            onSelect = (api, payload) => {
              if (!updateUrl) return;
              const slideHash = api.slides[payload.currentIndex]?.dataset.hash;
              if (slideHash) {
                const newHash = hashGroup ? `#${hashGroup}:${slideHash}` : `#${slideHash}`;
                history.replaceState(null, null, newHash);
              }
            };
            
            window.addEventListener('hashchange', onHash);
            api.on('select', onSelect);
            setTimeout(onHash, 0);
          },
          destroy: (api) => {
            window.removeEventListener('hashchange', onHash);
            api.off('select', onSelect);
          }
        };
      })();
      hashPlugin.init(this);
      this.plugins.push(hashPlugin);
    }

    // THUMBNAIL SYNCING & SYNC GROUPS
    const syncTarget = this.root.dataset.sync;
    const syncGroup = this.syncGroup();
    if (syncTarget || syncGroup) {
      const syncPlugin = (() => {
        let onSelect;
        let hasSynced = false;
        return {
          name: 'sync',
          init: (api) => {
            onSelect = (api, payload) => {
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
      syncPlugin.init(this);
      this.plugins.push(syncPlugin);
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
      creative.init(this);
      this.plugins.push(creative);
    }

    // LAZY LOAD
    if (this.root.classList.contains('lazy-load')) {
      const lazyLoad = (() => {
        let onSelect;
        return {
          name: 'lazy-load',
          init: (api) => {
            onSelect = (api, payload) => {
              const toLoad = [
                payload.currentIndex - 1, 
                payload.currentIndex, 
                payload.currentIndex + 1
              ];
              toLoad.forEach(idx => {
                let targetIdx = idx;
                if (api.isLoop()) {
                  targetIdx = (idx + api.slides.length) % api.slides.length;
                }
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
          },
          destroy: (api) => api.off('select', onSelect)
        };
      })();
      lazyLoad.init(this);
      this.plugins.push(lazyLoad);
    }

    // DEBUG PLUGIN 
    if (this.root.classList.contains('debug')) {
      const debugPlugin = (() => {
         let debugEl, onUpdate, lastUpdate = 0;
         return {
            name: 'debug',
            init: (api) => {
               const delay = parseInt(api.root.dataset.debugDelay) || 150; 
               api.emit('debugOpen'); 
               debugEl = document.createElement('div');
               debugEl.className = 'yd_carousel-debug-panel';
               debugEl.style.cssText = 'position:absolute;top:0;left:0;background:rgba(0,0,0,0.8);color:#0f0;font-family:monospace;font-size:12px;padding:10px;z-index:9999;pointer-events:none;white-space:pre;line-height:1.4;';
               api.root.appendChild(debugEl);
               
               onUpdate = (api, payload) => {
                  const now = performance.now();
                  if (now - lastUpdate < delay) return; 
                  lastUpdate = now;
                  
                  const state = api.state();
                  debugEl.textContent = `
[ydCarousel v${state.version}]
Group: ${state.group} | Idx: ${state.index}
Prog:  ${state.progress.toFixed(2)}
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
               api.emit('debugClose'); 
            }
         };
      })();
      debugPlugin.init(this);
      this.plugins.push(debugPlugin);
    }
  }
}

// ==========================================
// AUTO-INIT SYSTEM
// ==========================================
if (typeof document !== 'undefined') {
  document.addEventListener('DOMContentLoaded', () => ydCarousel.startAutoInit());
}
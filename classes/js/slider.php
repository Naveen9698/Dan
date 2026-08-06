/**
 * ydCarousel 2.2 - V1.0 ENTERPRISE EDITION
 * 100% COMPLETION: Extreme Scalability, CPU Halting, Event Delegation, Hooks & Dynamic APIs
 */

class ydCarousel {
  static VERSION = '2.2.0';
  static ENGINE = 'ydCarousel';
  static DEBUG = false; 
  static _autoInitObserver = null;
  static globalPlugins = [];

  static EVENTS = [
    'beforeInit', 'init', 'afterInit',
    'beforeResize', 'resize', 'afterResize',
    'destroy',
    'dragStart', 'dragMove', 'dragEnd',
    'scroll', 'scrollHeavy', 'settle',
    'beforeSelect', 'select', 'afterSelect',
    // Note: 'activeSlideChange' represents a "Scroll group / page change" in the grouped scrolling model
    'activeSlideChange',
    'slideEnter', 'slideExit',
    'loopEnter', 'loopExit', 'loopReposition',
    'autoplayStart', 'autoplayPause', 'autoplayResume', 'autoplayStop', 'autoplayToggleRequest',
    'syncStart', 'syncUpdate', 'syncStop',
    'debugOpen', 'debugClose'
  ];

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

  static use(plugin) {
    if (!this.globalPlugins.includes(plugin)) {
      this.globalPlugins.push(plugin);
    }
  }

  constructor(element) {
    this.root = element;
    this.track = this.root.querySelector('.yd_container');
    if (!this.track) return;
    
    // CONFIGURATION
    const scrollAttr = this.root.dataset.scroll;
    const parsedScroll = parseInt(scrollAttr, 10);
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
      scroll: scrollAttr === 'auto' 
        ? 'auto' 
        : Number.isInteger(parsedScroll) && parsedScroll > 0 ? parsedScroll : 1,
      duration: parseFloat(this.root.dataset.duration) || 0.1,
      friction: parseFloat(this.root.dataset.friction) || 0.92,
      delay: parseInt(this.root.dataset.delay) || 4000
    };

    // REDUCED MOTION SUPPORT
    const prefersReducedMotion = typeof window !== 'undefined' && window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion) this.options.duration = 1;

    // PHYSICS & STATE
    this.currentPos = 0;
    this.targetPos = 0;
    this.currentIndex = 0;
    this.prevIndex = 0; 
    this._velocity = 0; 
    this.inertia = 0;
    
    this.isDraggingActive = false;
    this.isSettled = true;
    this.destroyed = false;        
    this.mounted = false;
    this.isVisible = true;
    
    this.rafId = null;
    this.mutationRaf = null;
    this.lastHeavyScrollTime = 0;
    this._currentFps = 60;
    this._frames = 0;
    this._lastFpsTime = typeof performance !== 'undefined' ? performance.now() : 0;

    // POINTER TRACKING
    this.dragStartPos = 0;
    this.dragStartCurrentPos = 0;
    this.lastPointerPos = 0;
    this.lastPointerTime = 0;
    this.isClickSuppressed = false;

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
    this.plugins = [];

    // Bound methods for safe addition/removal
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
    if (this.destroyed) this.destroyed = false;
    this.emit('beforeInit');
    
    this.setupAccessibility();
    this.setupObservers();
    this.updateMeasurements();
    this.bindEvents();
    this.initPlugins();
    this.startPhysicsLoop();
    
    this.root.classList.add('yd_carousel-ready');
    this.emit('init');
    this.mounted = true;
    this.emit('afterInit');
  }

  // ==========================================
  // PUBLIC API, DIAGNOSTICS & ALIASES
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
  
  // ALIASES & CONVENIENCE
  play() { this.emit('autoplayResume'); }
  pause() { this.emit('autoplayPause'); }
  goToNext() { this.scrollNext(); }
  goToPrev() { this.scrollPrev(); }
  currentPage() { return this.currentIndex + 1; }
  pageCount() { return this.metrics.scrollSnaps.length; }

  // DYNAMIC SLIDE API
  addSlide(node) {
    this.track.appendChild(node);
    this.refresh();
  }
  removeSlide(index) {
    if (this.slides[index]) {
      this.slides[index].remove();
      this.refresh();
    }
  }
  replaceSlide(index, node) {
    if (this.slides[index]) {
      this.track.replaceChild(node, this.slides[index]);
      this.refresh();
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
      looping: this.options.loop,
      rtl: this.options.rtl,
      vertical: this.options.vertical
    });
  }

  get stateData() { return this.state(); }
  
  snapshot() { return this.state(); }

  toJSON() {
    return {
      engine: ydCarousel.ENGINE,
      version: this.version(),
      state: this.state(),
      slideCount: this.slides.length,
      groupCount: this.metrics.scrollSnaps.length
    };
  }

  performance() {
    return Object.freeze({
      fps: this._currentFps,
      slideCount: this.slides.length,
      groupCount: this.metrics.scrollSnaps.length,
      plugins: this.pluginsList(),
      visibleSlides: this.slidesInView()
    });
  }

  pluginsList() { return this.plugins.map(p => p.name || 'anonymous'); }

  buildInfo() {
    return Object.freeze({
      engine: ydCarousel.ENGINE,
      version: this.version(),
      build: 'stable',
      released: '2026-08'
    });
  }

  capabilities() {
    return Object.freeze({
      loop: true, dragFree: true, rtl: true, vertical: true, autoplay: true, keyboard: true,
      wheel: true, hash: true, sync: true, creative: true, lazyLoad: true, accessibility: true,
      debug: true, plugins: true, events: true, diagnostics: true, snapshots: true,
      observers: true, scrollbar: true, autoplayProgress: true, dynamicApi: true
    });
  }

  runtimeCapabilities() {
    return Object.freeze({
      loop: this.options.loop, dragFree: this.options.dragFree, rtl: this.options.rtl,
      vertical: this.options.vertical, autoplay: this.options.autoplay, keyboard: this.options.keyboard,
      contain: this.options.contain, containKeep: this.options.containKeep,
      alignCenter: this.options.alignCenter, alignEnd: this.options.alignEnd, scroll: this.options.scroll
    });
  }

  info() {
    return Object.freeze({
      version: this.version(),
      build: this.buildInfo(),
      plugins: Object.freeze(this.pluginsList()),
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
      activeIndex: this.selectedIndex(),
      activeSlide: this.activeSlide()
    });
  }

  getEventPayload() {
    return {
      currentIndex: this.currentIndex,
      previousIndex: this.prevIndex,
      slideCount: this.slides.length,
      groupCount: this.metrics.scrollSnaps.length,
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
    
    // NATIVE DOM EVENT DISPATCHER
    if (typeof CustomEvent !== 'undefined') {
      this.root.dispatchEvent(new CustomEvent(`yd-${event}`, { detail: payload, bubbles: true }));
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

  scrollTo(index, immediate = false) { this.goTo(index, immediate); }
  selectedIndex() { return this.currentIndex; }
  previousIndex() { return this.prevIndex; }
  
  activeSlide() { 
    if (!this.slides.length || !this.metrics.scrollSnaps.length) return null;
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
    if (this.root.classList.contains('stop-last') && this.currentIndex >= this.metrics.scrollSnaps.length - 1) return false;
    return this.options.loop || this.currentIndex < this.metrics.scrollSnaps.length - 1;
  }

  canScrollPrev() {
    return this.options.loop || this.currentIndex > 0;
  }

  scrollProgress() {
    if (this.options.loop) {
      const relativePos = this.currentPos - this.metrics.prependOffset;
      return Math.max(0, Math.min(1, relativePos / (this.metrics.realTrackSize || 1)));
    }
    if (!this.maxScroll) return 0;
    return Math.max(0, Math.min(1, this.currentPos / this.maxScroll));
  }

  slideProgress(index) {
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

  // ==========================================
  // MEASUREMENT, GROUPING, & CLONING
  // ==========================================
  
  updateMeasurements() {
    this.emit('beforeResize');
    this.visibleSlides.clear();

    if (this.mutationObserver) this.mutationObserver.disconnect();
    this.track.querySelectorAll('.yd_slide-clone').forEach(clone => clone.remove());
    
    this.slides = Array.from(this.track.children);
    if (!this.slides.length) return;

    // IMAGE CLS DETECTION & REFRESH BINDING
    this.slides.forEach((slide, idx) => {
      slide.setAttribute('data-slide-index', idx);
      
      const imgs = slide.querySelectorAll('img');
      imgs.forEach(img => {
        if (ydCarousel.DEBUG && !img.getAttribute('width') && !img.getAttribute('height') && !img.style.aspectRatio) {
           console.warn('[ydCarousel] Image missing dimensions (CLS risk):', img);
        }
        if (!img.dataset.ydLoaded) {
           img.dataset.ydLoaded = 'true';
           img.addEventListener('load', () => this.refresh(), { once: true });
        }
      });
    });

    const rect = this.root.getBoundingClientRect();
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
    this.emit('afterResize');
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
  // OBSERVERS (VISIBILITY PAUSE & CPU HALT)
  // ==========================================
  
  setupObservers() {
    this.resizeObserver = new ResizeObserver(this.onResize);
    this.resizeObserver.observe(this.root);
    this.mutationObserver = new MutationObserver(this.onMutation);

    // CPU Halting Visibility Observer
    this.visibilityPauser = new IntersectionObserver((entries) => {
      this.isVisible = entries[0].isIntersecting;
      if (this.isVisible && !this.isSettled && !this.rafId && this.mounted) {
        this.lastPointerTime = performance.now();
        this.startPhysicsLoop();
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
    window.removeEventListener('pointermove', this.onPointerMove);
    window.removeEventListener('pointerup', this.onPointerUp);
    this.root.removeEventListener('keydown', this.onKeyDown);
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

    this.track.setPointerCapture(e.pointerId);
    this.track.style.cursor = 'grabbing';
    
    // PASSIVE LISTENER DELEGATION
    window.addEventListener('pointermove', this.onPointerMove, { passive: true });
    window.addEventListener('pointerup', this.onPointerUp, { passive: true });
    
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
    this.track.releasePointerCapture(e.pointerId);
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
    const isRtl = this.options.rtl;
    const isVert = this.options.vertical;
    
    if (e.key === 'Home') this.goTo(0);
    if (e.key === 'End') this.goTo(this.metrics.scrollSnaps.length - 1);
    
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
    if (this.rafId) return;
    this.lastHeavyScrollTime = performance.now();
    this.rafId = requestAnimationFrame(this.tick);
  }

  tick() {
    if (this.destroyed) return;
    
    // VISIBILITY-BASED PAUSING (CPU SAVE)
    if (!this.isVisible) {
      this.rafId = null;
      return;
    }

    // DIAGNOSTIC FPS TRACKING
    this._frames++;
    const now = performance.now();
    if (now - this._lastFpsTime >= 1000) {
       this._currentFps = Math.round((this._frames * 1000) / (now - this._lastFpsTime));
       this._frames = 0;
       this._lastFpsTime = now;
    }

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
    
    // RAF-THROTTLED HEAVY SCROLL (Performance Saver)
    if (now - this.lastHeavyScrollTime > 50) {
      this.emit('scrollHeavy');
      this.lastHeavyScrollTime = now;
    }

    this.rafId = requestAnimationFrame(this.tick);
  }

  destroy() {
    if (this.destroyed) return;
    this.destroyed = true; 
    cancelAnimationFrame(this.rafId);
    if (this.mutationRaf) cancelAnimationFrame(this.mutationRaf);
    
    this.unbindEvents();
    if (this.resizeObserver) { this.resizeObserver.disconnect(); this.resizeObserver = null; }
    if (this.mutationObserver) { this.mutationObserver.disconnect(); this.mutationObserver = null; }
    if (this.visibilityObserver) { this.visibilityObserver.disconnect(); this.visibilityObserver = null; }
    if (this.visibilityPauser) { this.visibilityPauser.disconnect(); this.visibilityPauser = null; }
    
    if (this.announceHandler) this.off('select', this.announceHandler);

    this.plugins.forEach(p => p.destroy && p.destroy(this));
    this.plugins = []; 
    
    this.root.classList.remove('yd_carousel-ready');
    this.track.style.transform = '';
    this.track.querySelectorAll('.yd_slide-clone').forEach(clone => clone.remove());
    this.visibleSlides.clear();

    if (this.root.__ydCarousel === this) {
      delete this.root.__ydCarousel;
    }

    this.emit('destroy', { state: this.state() });
    this.listeners = {}; 
  }

  // ==========================================
  // NAVIGATION & STATE
  // ==========================================

  goTo(index, immediate = false) {
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

  snapToClosest() {
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

  scrollNext() {
    if (this.currentIndex < this.metrics.scrollSnaps.length - 1) this.goTo(this.currentIndex + 1);
    else if (this.options.loop && this.canScrollNext()) this.goTo(0); 
  }

  scrollPrev() {
    if (this.currentIndex > 0) this.goTo(this.currentIndex - 1);
    else if (this.options.loop && this.canScrollPrev()) this.goTo(this.metrics.scrollSnaps.length - 1);
  }

  updateSlideStates() {
    let closestSlideIdx = 0;
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
        closestSlideIdx = idx;
      }
    });

    const total = this.slides.length;
    const prevIdx = this.options.loop ? (total + closestSlideIdx - 1) % total : closestSlideIdx - 1;
    const nextIdx = this.options.loop ? (closestSlideIdx + 1) % total : closestSlideIdx + 1;

    this.slides.forEach((slide, idx) => {
      slide.classList.remove('active', 'prev', 'next');
      slide.removeAttribute('aria-current');
      if (idx === closestSlideIdx) {
        slide.classList.add('active');
        slide.setAttribute('aria-current', 'true');
      } else if (idx === prevIdx) slide.classList.add('prev');
      else if (idx === nextIdx) slide.classList.add('next');
    });
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

  // ==========================================
  // PLUGIN ARCHITECTURE
  // ==========================================

  initPlugins() {
    this.plugins.forEach(p => p.destroy && p.destroy(this));
    this.plugins = [];

    // Combine local plugins with global public plugins
    const activePlugins = [
      ...ydCarousel.globalPlugins
    ];

    // ==========================================
    // CORE MODULES
    // ==========================================

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
      activePlugins.push(controls);
    }

    const dotsContainer = this.root.querySelector('.yd_dots');
    if (dotsContainer) {
      const dots = (() => {
        let updateDots, onDotsClick;
        return {
          name: 'dots',
          init: (api) => {
            let template = dotsContainer.querySelector('.yd_dot');
            if (template) {
              template = template.cloneNode(true);
            } else {
              template = document.createElement('button');
              template.className = 'yd_dot';
            }
            dotsContainer.innerHTML = '';
            
            // Centralized Event Delegation
            onDotsClick = (e) => {
              const dot = e.target.closest('.yd_dot');
              if (dot) {
                const idx = parseInt(dot.getAttribute('data-index'), 10);
                if (!isNaN(idx)) api.scrollTo(idx);
              }
            };
            dotsContainer.addEventListener('click', onDotsClick);

            api.metrics.scrollSnaps.forEach((_, idx) => {
              const dot = template.cloneNode(true);
              if (dot.tagName !== 'BUTTON') {
                dot.setAttribute('role', 'button');
                dot.setAttribute('tabindex', '0');
              }
              dot.setAttribute('aria-label', `Go to page ${idx + 1}`);
              dot.setAttribute('data-index', idx);
              dotsContainer.appendChild(dot);
            });
            updateDots = (api, payload) => {
              Array.from(dotsContainer.children).forEach((dot, idx) => {
                const isActive = idx === payload.currentIndex;
                dot.classList.toggle('active', isActive);
                if (isActive) dot.setAttribute('aria-current', 'true');
                else dot.removeAttribute('aria-current');
              });
            };
            api.on('select', updateDots);
            updateDots(api, api.getEventPayload());
          },
          destroy: (api) => {
            dotsContainer.removeEventListener('click', onDotsClick);
            api.off('select', updateDots);
          }
        };
      })();
      activePlugins.push(dots);
    }

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
              const currentText = payload.currentIndex + 1;
              const totalText = payload.groupCount;
              
              if (currentEl && totalEl) {
                currentEl.textContent = currentText;
                totalEl.textContent = totalText;
              } else {
                counterEl.textContent = `${currentText} / ${totalText}`;
              }
            };
            api.on('select', updateCounter);
            updateCounter(api, api.getEventPayload());
          },
          destroy: (api) => api.off('select', updateCounter)
        };
      })();
      activePlugins.push(counter);
    }

    const progressEl = this.root.querySelector('.yd_progress');
    if (progressEl) {
      const progress = (() => {
        let updateProgress;
        return {
          name: 'progress',
          init: (api) => {
            updateProgress = (api, payload) => {
              const pct = payload.progress * 100;
              progressEl.style.setProperty('--progress', `${pct}%`);
            };
            // Use heavily throttled scroll to save CPU on progress bar
            api.on('scrollHeavy', updateProgress);
            updateProgress(api, api.getEventPayload());
          },
          destroy: (api) => api.off('scrollHeavy', updateProgress)
        };
      })();
      activePlugins.push(progress);
    }

    if (this.options.autoplay) {
      const autoplay = (() => {
        let playTimer, play, stop, onVisChange, onFocusIn, onFocusOut, onToggleRequest;
        let isPaused = false;
        let hasStarted = false;
        return {
          name: 'autoplay',
          init: (api) => {
            play = () => {
              clearTimeout(playTimer);
              if (!hasStarted) {
                hasStarted = true;
                api.emit('autoplayStart');
              } else if (isPaused) {
                isPaused = false;
                api.emit('autoplayResume'); 
              }
              if (!api.canScrollNext()) return;
              playTimer = setTimeout(() => { api.scrollNext(); play(); }, api.options.delay);
            };
            stop = () => {
              clearTimeout(playTimer);
              if (hasStarted && !isPaused) {
                isPaused = true;
                api.emit('autoplayPause');
              }
            };

            onVisChange = () => document.hidden ? stop() : play();
            onFocusIn = () => stop();
            onFocusOut = () => play();

            onToggleRequest = () => {
              if (hasStarted && !isPaused) stop();
              else play();
            };
            api.on('autoplayToggleRequest', onToggleRequest);

            api.on('dragStart', stop);
            api.on('dragEnd', play);
            if (api.root.classList.contains('pause-hover')) {
              api.root.addEventListener('mouseenter', stop);
              api.root.addEventListener('mouseleave', play);
            }
            document.addEventListener('visibilitychange', onVisChange);
            api.root.addEventListener('focusin', onFocusIn);
            api.root.addEventListener('focusout', onFocusOut);
            play();
          },
          destroy: (api) => {
            stop();
            api.emit('autoplayStop');
            api.off('dragStart', stop);
            api.off('dragEnd', play);
            api.off('autoplayToggleRequest', onToggleRequest); 
            api.root.removeEventListener('mouseenter', stop);
            api.root.removeEventListener('mouseleave', play);
            document.removeEventListener('visibilitychange', onVisChange);
            api.root.removeEventListener('focusin', onFocusIn);
            api.root.removeEventListener('focusout', onFocusOut);
          }
        };
      })();
      activePlugins.push(autoplay);

      // AUTOPLAY TOGGLE BUTTON
      const autoplayToggle = this.root.querySelector('.yd_autoplay-toggle');
      if (autoplayToggle) {
        const togglePlugin = (() => {
          let onClick, onPause, onResume, onStart;
          return {
            name: 'autoplay-toggle',
            init: (api) => {
              onClick = () => api.emit('autoplayToggleRequest');
              autoplayToggle.addEventListener('click', onClick);
              
              onPause = () => autoplayToggle.classList.add('paused');
              onResume = () => autoplayToggle.classList.remove('paused');
              onStart = () => autoplayToggle.classList.remove('paused');
              
              api.on('autoplayPause', onPause);
              api.on('autoplayResume', onResume);
              api.on('autoplayStart', onStart);
            },
            destroy: (api) => {
              autoplayToggle.removeEventListener('click', onClick);
              api.off('autoplayPause', onPause);
              api.off('autoplayResume', onResume);
              api.off('autoplayStart', onStart); 
            }
          };
        })();
        activePlugins.push(togglePlugin);
      }

      // AUTOPLAY PROGRESS INDICATOR
      const autoplayProgressEl = this.root.querySelector('.yd_autoplay-progress');
      if (autoplayProgressEl) {
        const autoplayProgress = (() => {
          let rafId, startTime, elapsed = 0, isPlaying = false;
          let delayMs = 4000;
          let onSlideChange, onStartEvt, onResumeEvt, onPauseEvt, onStopEvt, onDragStartEvt;
          
          const tick = () => {
            if (!isPlaying) return;
            const now = performance.now();
            const currentElapsed = elapsed + (now - startTime);
            let pct = Math.min(100, (currentElapsed / delayMs) * 100);
            autoplayProgressEl.style.setProperty('--autoplay-progress', `${pct}%`);
            
            if (pct < 100) rafId = requestAnimationFrame(tick);
          };

          const start = () => {
            isPlaying = true;
            startTime = performance.now();
            cancelAnimationFrame(rafId);
            rafId = requestAnimationFrame(tick);
          };

          const pause = () => {
            isPlaying = false;
            elapsed += (performance.now() - startTime);
            cancelAnimationFrame(rafId);
          };

          const reset = () => {
            elapsed = 0;
            autoplayProgressEl.style.setProperty('--autoplay-progress', `0%`);
          };

          return {
            name: 'autoplay-progress',
            init: (api) => {
              delayMs = api.options.delay;
              
              onSlideChange = () => { reset(); if (api.options.autoplay) start(); };
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
            },
            destroy: (api) => {
              cancelAnimationFrame(rafId);
              api.off('activeSlideChange', onSlideChange);
              api.off('autoplayStart', onStartEvt);
              api.off('autoplayResume', onResumeEvt);
              api.off('autoplayPause', onPauseEvt);
              api.off('autoplayStop', onStopEvt);
              api.off('dragStart', onDragStartEvt); 
            }
          };
        })();
        activePlugins.push(autoplayProgress);
      }
    }

    // ==========================================
    // ADVANCED MODULES
    // ==========================================

    // SCROLLBAR INTERACTION PLUGIN
    const scrollbarEl = this.root.querySelector('.yd_scrollbar');
    if (scrollbarEl) {
      const scrollbar = (() => {
        let thumb, track, isDragging = false, startPos, startProgress;
        let updateThumb;
        let onTrackClick, onPointerDown, onPointerMove, onPointerUp;

        return {
          name: 'scrollbar',
          init: (api) => {
            thumb = scrollbarEl.querySelector('.yd_scrollbar-thumb');
            track = scrollbarEl.querySelector('.yd_scrollbar-track') || scrollbarEl;
            
            updateThumb = (api) => {
              if (isDragging) return;
              const pct = api.scrollProgress() * 100;
              if (thumb) thumb.style.setProperty('--scroll-progress', `${pct}%`);
            };
            
            api.on('scroll', updateThumb);
            updateThumb(api);
            
            onTrackClick = (e) => {
              if (e.target === thumb || isDragging) return;
              const rect = track.getBoundingClientRect();
              const clickPct = api.options.vertical 
                ? (e.clientY - rect.top) / rect.height 
                : (e.clientX - rect.left) / rect.width;
              
              const targetScroll = clickPct * api.maxScroll;
              let closestIdx = 0, minDiff = Infinity;
              api.metrics.scrollSnaps.forEach((snap, idx) => {
                if (Math.abs(snap - targetScroll) < minDiff) {
                  minDiff = Math.abs(snap - targetScroll);
                  closestIdx = idx;
                }
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
              // Safe passive listeners attached to thumb directly
              thumb.addEventListener('pointermove', onPointerMove, { passive: true });
              thumb.addEventListener('pointerup', onPointerUp, { passive: true });
            }
          },
          destroy: (api) => {
            api.off('scroll', updateThumb);
            if (track) track.removeEventListener('click', onTrackClick);
            if (thumb) {
              thumb.removeEventListener('pointerdown', onPointerDown);
              thumb.removeEventListener('pointermove', onPointerMove);
              thumb.removeEventListener('pointerup', onPointerUp); 
            }
          }
        };
      })();
      activePlugins.push(scrollbar);
    }

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
      activePlugins.push(wheel);
    }

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
              const targetSlideIdx = api.slides.findIndex(s => s.dataset.hash === slideHash);
              if (targetSlideIdx > -1) {
                 const snapTarget = api.metrics.slideSnaps[targetSlideIdx];
                 let closestIndex = 0, minDistance = Infinity;
                 api.metrics.scrollSnaps.forEach((p, i) => {
                   if (Math.abs(p - snapTarget) < minDistance) { minDistance = Math.abs(p - snapTarget); closestIndex = i; }
                 });
                 if (closestIndex !== api.selectedIndex()) api.scrollTo(closestIndex);
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
          },
          destroy: (api) => {
            window.removeEventListener('hashchange', onHash);
            api.off('select', onSelect);
          }
        };
      })();
      activePlugins.push(hashPlugin);
    }

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
                     targetApi.scrollTo(payload.currentIndex);
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
      activePlugins.push(syncPlugin);
    }

    if (this.root.classList.contains('creative')) {
      const creative = (() => {
        let onScroll;
        return {
          name: 'creative',
          init: (api) => {
            onScroll = () => {
              api.slides.forEach((slide, idx) => {
                const progress = api.slideProgress(idx); 
                slide.style.setProperty('--slide-progress', progress.toFixed(4));
                slide.style.setProperty('--slide-abs-progress', Math.abs(progress).toFixed(4));
              });
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
      activePlugins.push(creative);
    }

    if (this.root.classList.contains('lazy-load')) {
      const lazyLoad = (() => {
        let onSelect;
        return {
          name: 'lazy-load',
          init: (api) => {
            onSelect = (api, payload) => {
              const activeNode = api.activeSlide();
              if(!activeNode) return;
              const activeSlideIndex = parseInt(activeNode.getAttribute('data-slide-index'), 10);
              
              const toLoad = [
                activeSlideIndex - 1, 
                activeSlideIndex, 
                activeSlideIndex + 1
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
      activePlugins.push(lazyLoad);
    }

    if (this.root.classList.contains('debug')) {
      const debugPlugin = (() => {
         let debugEl, onUpdate;
         return {
            name: 'debug',
            init: (api) => {
               api.emit('debugOpen'); 
               debugEl = document.createElement('div');
               debugEl.className = 'yd_carousel-debug-panel';
               debugEl.style.cssText = 'position:absolute;top:0;left:0;background:rgba(0,0,0,0.8);color:#0f0;font-family:monospace;font-size:12px;padding:10px;z-index:9999;pointer-events:none;white-space:pre;line-height:1.4;';
               api.root.appendChild(debugEl);
               
               onUpdate = (api, payload) => {
                  const pInfo = api.performance();
                  debugEl.textContent = `
[ydCarousel v${api.version()}]
Idx:  ${payload.currentIndex}
Prog: ${payload.progress.toFixed(2)}
Drag: ${payload.isDragging}
Setl: ${payload.isSettled}
Loop: ${payload.looping}
Vel:  ${api.velocity().toFixed(2)}
InVw: ${pInfo.visibleSlides.join(',')}
FPS:  ${pInfo.fps}
                  `.trim();
               };
               // Using heavily throttled scroll to save CPU on debug panel
               api.on('scrollHeavy', onUpdate);
               api.on('select', onUpdate);
               onUpdate(api, api.getEventPayload());
            },
            destroy: (api) => {
               if (debugEl) debugEl.remove();
               api.off('scrollHeavy', onUpdate);
               api.off('select', onUpdate);
               api.emit('debugClose'); 
            }
         };
      })();
      activePlugins.push(debugPlugin);
    }

    // Initialize all active plugins
    activePlugins.forEach(pluginDef => {
      const instance = typeof pluginDef === 'function' ? new pluginDef() : Object.create(pluginDef);
      if (instance.init) {
        instance.init(this);
        this.plugins.push(instance);
      }
    });
  }
}

// ==========================================
// AUTO-INIT SYSTEM
// ==========================================
if (typeof document !== 'undefined') {
  document.addEventListener('DOMContentLoaded', () => ydCarousel.startAutoInit());
}
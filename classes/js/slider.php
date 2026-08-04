/**
 * DANCAROUSEL 2.2 - FINAL ARCHITECTURAL CLEANUP
 * INCLUDES: Advanced Event Semantics, Extended Developer APIs, Hardened Plugins
 */

class DanCarousel {
  constructor(element) {
    this.root = element;
    this.track = this.root.querySelector('.slides');
    if (!this.track) return;
    
    // CONFIGURATION
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
      delay: parseInt(this.root.dataset.delay) || 4000
    };

    // PHYSICS & STATE
    this.currentPos = 0;
    this.targetPos = 0;
    this.currentIndex = 0;
    this.prevIndex = 0; 
    this._velocity = 0; // Prefixed internal state (Exposed via API)
    this.inertia = 0;
    
    this.isDraggingActive = false;
    this.isSettled = true;
    this.destroyed = false;        
    this.rafId = null;
    this.mutationRaf = null;

    // POINTER TRACKING
    this.dragStartPos = 0;
    this.dragStartCurrentPos = 0;
    this.lastPointerPos = 0;
    this.lastPointerTime = 0;
    this.isClickSuppressed = false;

    this.slides = []; 
    this.visibleSlides = new Set(); // OPTIONAL #1: Visibility State Tracking

    this.metrics = {
      viewportSize: 0,
      trackSize: 0,
      realTrackSize: 0, 
      prependOffset: 0,  
      slideSizes: [],
      snapPoints: []
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
    this.setupAccessibility();
    this.setupObservers();
    this.updateMeasurements();
    this.bindEvents();
    this.initPlugins();
    this.startPhysicsLoop();
    
    this.root.classList.add('slider-ready');
    this.emit('init');
  }

  // ==========================================
  // PUBLIC API & EVENT SYSTEM
  // ==========================================

  version() { return '2.2.0'; }
  isReady() { return this.root.classList.contains('slider-ready'); }
  isDestroyed() { return this.destroyed; }
  
  // FINAL ADDITIONS: Extended APIs
  hashGroup() { return this.root.dataset.hashGroup; }
  syncGroup() { return this.root.dataset.syncGroup; }
  velocity() { return this._velocity; }
  currentPosition() { return this.currentPos; }
  targetPosition() { return this.targetPos; }
  
  state() {
    return {
      index: this.currentIndex,
      previousIndex: this.prevIndex,
      position: this.currentPos,
      target: this.targetPos,
      velocity: this._velocity,
      progress: this.scrollProgress(),
      dragging: this.isDraggingActive,
      settled: this.isSettled
    };
  }

  events() {
    return [
      'init', 'resize', 'destroy',
      'dragStart', 'dragMove', 'dragEnd',
      'scroll', 'settle',
      'beforeSelect', 'select', 'afterSelect',
      'activeSlideChange',
      'slideEnter', 'slideExit',
      'loopEnter', 'loopExit', 'loopReposition',
      'autoplayStart', 'autoplayPause', 'autoplayResume', 'autoplayStop',
      'syncStart', 'syncUpdate', 'syncStop',
      'debugOpen', 'debugClose'
    ];
  }

  getEventPayload() {
    return {
      currentIndex: this.currentIndex,
      previousIndex: this.prevIndex,
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

  scrollTo(index, immediate = false) { this.goTo(index, immediate); }
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
    this.destroy();
    this.init();
  }

  canScrollNext() {
    if (this.root.classList.contains('stop-last') && this.currentIndex >= this.metrics.snapPoints.length - 1) return false;
    return this.options.loop || this.currentIndex < this.metrics.snapPoints.length - 1;
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
    const snap = this.metrics.snapPoints[index] || 0;
    const distance = this.currentPos - snap;
    const progress = distance / (this.metrics.viewportSize || 1);
    return Math.max(-1, Math.min(1, progress));
  }

  slidesInView() {
    return Array.from(this.visibleSlides).sort((a, b) => a - b);
  }

  slidesNotInView() {
    const visible = this.slidesInView();
    return this.slides.map((_, idx) => idx).filter(idx => !visible.includes(idx));
  }

  // ==========================================
  // MEASUREMENT, ALIGNMENT, & CLONING
  // ==========================================
  
  updateMeasurements() {
    if (this.mutationObserver) this.mutationObserver.disconnect();
    this.track.querySelectorAll('.slide-clone').forEach(clone => clone.remove());
    
    this.slides = Array.from(this.track.children);
    if (!this.slides.length) return;

    this.slides.forEach((slide, idx) => {
      slide.setAttribute('data-slide-index', idx);
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
    this.metrics.snapPoints = this.metrics.slideSizes.map((size) => {
      let snap = currentOffset;
      if (this.options.alignCenter) snap -= (this.metrics.viewportSize / 2) - (size / 2);
      if (this.options.alignEnd) snap -= this.metrics.viewportSize - size;
      currentOffset += size;
      return Math.max(0, snap); 
    });

    this.maxScroll = Math.max(0, this.metrics.trackSize - this.metrics.viewportSize);

    if (!this.options.loop && (this.options.contain || this.options.containKeep)) {
      this.metrics.snapPoints = this.metrics.snapPoints.map(snap => Math.max(0, Math.min(snap, this.maxScroll)));
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
  }

  createClone(slide) {
    const clone = slide.cloneNode(true);
    clone.classList.add('slide-clone');
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
        const isClone = node.classList.contains('slide-clone');
        
        if (entry.isIntersecting) {
          node.classList.add('in-view');
          node.classList.remove('out-view');
          
          if (!isClone) {
            node.removeAttribute('aria-hidden');
            // OPTIONAL #1: Visibility State Tracking (No duplicate spam)
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
    if (mutations.some(m => m.target.classList && m.target.classList.contains('slide-clone'))) return;
    if (this.mutationRaf) cancelAnimationFrame(this.mutationRaf);
    
    this.mutationRaf = requestAnimationFrame(() => {
      const oldLength = this.slides.length;
      const realNodes = Array.from(this.track.children).filter(el => !el.classList.contains('slide-clone'));
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
    if (e.key === 'End') this.goTo(this.metrics.snapPoints.length - 1);
    
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
    this.rafId = requestAnimationFrame(this.tick);
  }

  tick() {
    if (this.destroyed) return;

    if (this.options.loop) {
      const firstSnap = this.metrics.snapPoints[0];
      const lastSnap = this.metrics.snapPoints[this.slides.length - 1];
      
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
    if (this.resizeObserver) this.resizeObserver.disconnect();
    if (this.mutationObserver) this.mutationObserver.disconnect();
    if (this.visibilityObserver) this.visibilityObserver.disconnect();
    
    if (this.announceHandler) this.off('select', this.announceHandler);

    this.plugins.forEach(p => p.destroy && p.destroy(this));
    this.plugins = []; 
    
    this.root.classList.remove('slider-ready');
    this.track.style.transform = '';
    this.track.querySelectorAll('.slide-clone').forEach(clone => clone.remove());
    this.visibleSlides.clear();

    this.emit('destroy');
    this.listeners = {}; 
  }

  // ==========================================
  // NAVIGATION & STATE
  // ==========================================

  goTo(index, immediate = false) {
    const maxIndex = this.metrics.snapPoints.length - 1;
    const targetIndex = Math.max(0, Math.min(index, maxIndex));
    
    const changed = (this.currentIndex !== targetIndex);

    // ISSUE #1 FIX: Only emit beforeSelect if state will change
    if (changed) {
      this.emit('beforeSelect', { currentIndex: this.currentIndex, targetIndex });
      
      this.prevIndex = this.currentIndex;
      this.currentIndex = targetIndex;
      this.emit('activeSlideChange', { currentIndex: this.currentIndex, previousIndex: this.prevIndex });
    }
    
    let nextTarget = this.metrics.snapPoints[this.currentIndex];
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

    // ISSUE #2 FIX: Only fire select/afterSelect on actual change (or initial boot)
    if (changed || immediate) {
      this.emit('select');
      this.emit('afterSelect'); 
    }
  }

  snapToClosest() {
    let closestIndex = 0;
    let minDistance = Infinity;
    this.metrics.snapPoints.forEach((point, index) => {
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
    if (this.currentIndex < this.metrics.snapPoints.length - 1) this.goTo(this.currentIndex + 1);
    else if (this.options.loop && this.canScrollNext()) this.goTo(0); 
  }

  scrollPrev() {
    if (this.currentIndex > 0) this.goTo(this.currentIndex - 1);
    else if (this.options.loop && this.canScrollPrev()) this.goTo(this.metrics.snapPoints.length - 1);
  }

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
      } else if (idx === prevIdx) slide.classList.add('prev');
      else if (idx === nextIdx) slide.classList.add('next');
    });
  }

  setupAccessibility() {
    this.root.setAttribute('role', 'region');
    this.root.setAttribute('aria-roledescription', 'carousel');
    this.track.setAttribute('aria-live', 'polite');
    
    let announcer = this.root.querySelector('.slider-announcer');
    if (!announcer) {
      announcer = document.createElement('div');
      announcer.className = 'slider-announcer';
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
  // PLUGIN ARCHITECTURE
  // ==========================================

  initPlugins() {
    this.plugins.forEach(p => p.destroy && p.destroy(this));
    this.plugins = [];

    // ==========================================
    // CORE MODULES
    // ==========================================

    const prevBtn = this.root.querySelector('.slider-prev');
    const nextBtn = this.root.querySelector('.slider-next');
    if (prevBtn || nextBtn) {
      const controls = (() => {
        let hPrev, hNext;
        return {
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

    const dotsContainer = this.root.querySelector('.slider-dots');
    if (dotsContainer) {
      const dots = (() => {
        let updateDots;
        return {
          init: (api) => {
            dotsContainer.innerHTML = '';
            api.metrics.snapPoints.forEach((_, idx) => {
              const dot = document.createElement('button');
              dot.className = 'slider-dot';
              dot.setAttribute('aria-label', `Go to slide ${idx + 1}`);
              dot.addEventListener('click', () => api.scrollTo(idx));
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
          destroy: (api) => api.off('select', updateDots)
        };
      })();
      dots.init(this);
      this.plugins.push(dots);
    }

    const counterEl = this.root.querySelector('.slider-counter');
    if (counterEl) {
      const counter = (() => {
        let updateCounter;
        return {
          init: (api) => {
            updateCounter = (api, payload) => {
              counterEl.textContent = `${payload.currentIndex + 1} / ${api.metrics.snapPoints.length}`;
            };
            api.on('select', updateCounter);
            updateCounter(api, api.getEventPayload());
          },
          destroy: (api) => api.off('select', updateCounter)
        };
      })();
      counter.init(this);
      this.plugins.push(counter);
    }

    const progressEl = this.root.querySelector('.slider-progress');
    if (progressEl) {
      const progress = (() => {
        let updateProgress;
        return {
          init: (api) => {
            updateProgress = (api, payload) => {
              const pct = payload.progress * 100;
              progressEl.style.setProperty('--progress', `${pct}%`);
            };
            api.on('scroll', updateProgress);
          },
          destroy: (api) => api.off('scroll', updateProgress)
        };
      })();
      progress.init(this);
      this.plugins.push(progress);
    }

    if (this.options.autoplay) {
      const autoplay = (() => {
        let playTimer, play, stop, onVisChange, onFocusIn, onFocusOut;
        let isPaused = false;
        let hasStarted = false;
        return {
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

    // ==========================================
    // ADVANCED MODULES
    // ==========================================

    // MOUSEWHEEL NAVIGATION
    if (this.root.classList.contains('wheel')) {
      const wheel = (() => {
        let onWheel, resetTimer;
        let accumulator = 0;
        return {
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
              if (targetIdx > -1 && targetIdx !== api.selectedIndex()) api.scrollTo(targetIdx);
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
          init: (api) => {
            onSelect = (api, payload) => {
              let targets = [];
              if (syncTarget) {
                 const el = document.querySelector(syncTarget);
                 if (el && el.__danCarousel) targets.push(el.__danCarousel);
              }
              if (syncGroup) { 
                 document.querySelectorAll(`.slider[data-sync-group="${syncGroup}"]`).forEach(el => {
                    if (el !== api.root && el.__danCarousel) targets.push(el.__danCarousel);
                 });
              }
              
              if (targets.length) {
                // ISSUE #3 FIX: Strict syncStart semantics based on targets existing
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
      syncPlugin.init(this);
      this.plugins.push(syncPlugin);
    }

    // CREATIVE EFFECTS
    if (this.root.classList.contains('creative')) {
      const creative = (() => {
        let onScroll;
        return {
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
      creative.init(this);
      this.plugins.push(creative);
    }

    // LAZY LOAD
    if (this.root.classList.contains('lazy-load')) {
      const lazyLoad = (() => {
        let onSelect;
        return {
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
            init: (api) => {
               const delay = parseInt(api.root.dataset.debugDelay) || 150; // OPTIONAL #2
               api.emit('debugOpen'); 
               debugEl = document.createElement('div');
               debugEl.className = 'slider-debug-panel';
               debugEl.style.cssText = 'position:absolute;top:0;left:0;background:rgba(0,0,0,0.8);color:#0f0;font-family:monospace;font-size:12px;padding:10px;z-index:9999;pointer-events:none;white-space:pre;line-height:1.4;';
               api.root.appendChild(debugEl);
               
               onUpdate = (api, payload) => {
                  const now = performance.now();
                  if (now - lastUpdate < delay) return; 
                  lastUpdate = now;
                  
                  // ISSUE #4 FIX: Access state strictly via public APIs
                  const state = api.state();
                  debugEl.textContent = `
Idx:  ${state.index}
Prog: ${state.progress.toFixed(2)}
Drag: ${state.dragging}
Setl: ${state.settled}
Loop: ${api.isLoop()}
Vel:  ${state.velocity.toFixed(2)}
                  `.trim();
               };
               api.on('scroll', onUpdate);
               api.on('select', onUpdate);
               onUpdate(api, api.getEventPayload());
            },
            destroy: (api) => {
               if (debugEl) debugEl.remove();
               api.off('scroll', onUpdate);
               api.off('select', onUpdate);
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
function initDanCarousels() {
  document.querySelectorAll('.slider:not(.slider-ready)').forEach(el => {
    if (!el.__danCarousel) {
      el.__danCarousel = new DanCarousel(el);
    }
  });
}

if (typeof document !== 'undefined') {
  document.addEventListener('DOMContentLoaded', initDanCarousels);
  const observer = new MutationObserver(initDanCarousels);
  observer.observe(document.body, { childList: true, subtree: true });
}
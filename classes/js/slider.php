/**
 * DANCAROUSEL 2.0 - V1.0 RELEASE CANDIDATE
 * INCLUDES: True Infinite Loop, RTL, Vertical Mode, API Enhancements
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
      rtl: this.root.classList.contains('rtl'),           // PHASE 6
      vertical: this.root.classList.contains('vertical'), // PHASE 7
      duration: parseFloat(this.root.dataset.duration) || 0.1,
      friction: parseFloat(this.root.dataset.friction) || 0.92,
      delay: parseInt(this.root.dataset.delay) || 4000
    };

    // PHYSICS STATE
    this.currentPos = 0;
    this.targetPos = 0;
    this.currentIndex = 0;
    this.prevIndex = 0; 
    this.velocity = 0;
    this.inertia = 0;
    
    this.isDragging = false;
    this.isSettled = true;
    this.rafId = null;
    this.mutationRaf = null;

    // POINTER TRACKING
    this.dragStartPos = 0;
    this.dragStartCurrentPos = 0;
    this.lastPointerPos = 0;
    this.lastPointerTime = 0;
    this.isClickSuppressed = false;

    this.slides = []; 

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

    // Bound methods
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
    this.setupAccessibility();
    this.setupObservers();
    this.updateMeasurements();
    this.bindEvents();
    this.initPlugins();
    this.startPhysicsLoop();
    
    this.root.classList.add('slider-ready');
    this.emit('init', this.getEventPayload());
  }

  // ==========================================
  // PUBLIC API & PHASE 8 ENHANCEMENTS
  // ==========================================

  getEventPayload() {
    return {
      currentIndex: this.currentIndex,
      previousIndex: this.prevIndex
    };
  }

  emit(event) {
    if (!this.listeners[event]) return;
    const payload = this.getEventPayload();
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
  activeSlide() { return this.slides[this.currentIndex]; }
  slideNodes() { return this.slides; }

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

  slidesInView() {
    return this.slides.reduce((acc, slide, index) => {
      if (slide.classList.contains('in-view')) acc.push(index);
      return acc;
    }, []);
  }

  slidesNotInView() {
    return this.slides.reduce((acc, slide, index) => {
      if (slide.classList.contains('out-view')) acc.push(index);
      return acc;
    }, []);
  }

  // ==========================================
  // MEASUREMENT, ALIGNMENT, & CLONING
  // ==========================================
  
  updateMeasurements() {
    if (this.mutationObserver) this.mutationObserver.disconnect();
    this.track.querySelectorAll('.slide-clone').forEach(clone => clone.remove());
    
    this.slides = Array.from(this.track.children);
    if (!this.slides.length) return;

    const rect = this.root.getBoundingClientRect();
    this.metrics.viewportSize = this.options.vertical ? rect.height : rect.width;
    
    this.metrics.slideSizes = this.slides.map(slide => {
      const sRect = slide.getBoundingClientRect();
      return this.options.vertical ? sRect.height : sRect.width;
    });
    
    this.metrics.realTrackSize = this.metrics.slideSizes.reduce((a, b) => a + b, 0);
    this.metrics.prependOffset = 0;

    // PHASE 5: TRUE INFINITE LOOP CLONING
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
      this.slides.forEach(slide => this.visibilityObserver.observe(slide));
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
        const slide = entry.target;
        if (entry.isIntersecting) {
          slide.classList.add('in-view');
          slide.classList.remove('out-view');
          slide.removeAttribute('aria-hidden');
        } else {
          slide.classList.add('out-view');
          slide.classList.remove('in-view');
          slide.setAttribute('aria-hidden', 'true');
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
      this.updateMeasurements();
      if (realNodes.length !== oldLength) this.initPlugins(); 
    });
  }

  // ==========================================
  // POINTER & EVENTS (RTL & Vertical Support)
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
    
    this.isDragging = true;
    this.isClickSuppressed = false;
    this.dragStartPos = this.getPointerPos(e);
    this.dragStartCurrentPos = this.targetPos;
    
    this.lastPointerPos = this.getPointerPos(e);
    this.lastPointerTime = performance.now();
    this.velocity = 0;
    this.inertia = 0; 

    this.track.setPointerCapture(e.pointerId);
    this.track.style.cursor = 'grabbing';
    
    window.addEventListener('pointermove', this.onPointerMove);
    window.addEventListener('pointerup', this.onPointerUp);
    
    this.emit('dragStart');
    e.preventDefault(); 
  }

  onPointerMove(e) {
    if (!this.isDragging) return;
    const currentPointer = this.getPointerPos(e);
    
    // PHASE 6 & 7: RTL / Vertical Math Reverse
    let dragDistance = this.dragStartPos - currentPointer;
    if (this.options.rtl && !this.options.vertical) dragDistance *= -1;

    if (Math.abs(dragDistance) > 5) this.isClickSuppressed = true;

    const now = performance.now();
    const dt = now - this.lastPointerTime;
    if (dt > 0) {
      let rawVel = (this.lastPointerPos - currentPointer) / dt;
      if (this.options.rtl && !this.options.vertical) rawVel *= -1;
      this.velocity = rawVel;
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
    if (!this.isDragging) return;
    this.isDragging = false;
    this.track.releasePointerCapture(e.pointerId);
    this.track.style.cursor = '';

    window.removeEventListener('pointermove', this.onPointerMove);
    window.removeEventListener('pointerup', this.onPointerUp);
    this.emit('dragEnd');

    if (this.options.dragFree) {
      this.inertia = -this.velocity * 40; 
    } else {
      if (Math.abs(this.velocity) > 0.5) {
        this.velocity > 0 ? this.scrollNext() : this.scrollPrev();
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
    if (this.options.loop) {
      const firstSnap = this.metrics.snapPoints[0];
      const lastSnap = this.metrics.snapPoints[this.slides.length - 1];
      
      if (this.currentPos < firstSnap - (this.metrics.realTrackSize / 2)) {
        this.currentPos += this.metrics.realTrackSize;
        this.targetPos += this.metrics.realTrackSize;
      } else if (this.currentPos > lastSnap + (this.metrics.realTrackSize / 2)) {
        this.currentPos -= this.metrics.realTrackSize;
        this.targetPos -= this.metrics.realTrackSize;
      }
    }

    if (this.options.dragFree && Math.abs(this.inertia) > 0.1 && !this.isDragging) {
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
    } else if (this.options.dragFree && !this.options.loop && !this.isDragging) {
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

    // PHASE 6 & 7: Apply Transform based on Orientation and Direction
    let transformVal = -this.currentPos;
    if (this.options.rtl && !this.options.vertical) transformVal = Math.abs(this.currentPos); // CSS handles the layout, we translate positive
    
    if (this.options.vertical) {
      this.track.style.transform = `translate3d(0, ${transformVal}px, 0)`;
    } else {
      this.track.style.transform = `translate3d(${transformVal}px, 0, 0)`;
    }

    this.emit('scroll');
    this.rafId = requestAnimationFrame(this.tick);
  }

  destroy() {
    cancelAnimationFrame(this.rafId);
    if (this.mutationRaf) cancelAnimationFrame(this.mutationRaf);
    this.unbindEvents();
    this.resizeObserver.disconnect();
    this.mutationObserver.disconnect();
    this.visibilityObserver.disconnect();
    this.plugins.forEach(p => p.destroy && p.destroy(this));
    this.root.classList.remove('slider-ready');
    this.track.style.transform = '';
    this.track.querySelectorAll('.slide-clone').forEach(clone => clone.remove());
    this.emit('destroy');
    this.listeners = {};
  }

  // ==========================================
  // NAVIGATION & STATE
  // ==========================================

  goTo(index, immediate = false) {
    const maxIndex = this.metrics.snapPoints.length - 1;
    const targetIndex = Math.max(0, Math.min(index, maxIndex));
    
    if (this.currentIndex !== targetIndex) this.prevIndex = this.currentIndex;
    this.currentIndex = targetIndex;
    
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
    this.emit('select');
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
    
    // PHASE 8: Dedicated Live Announcer Region
    let announcer = this.root.querySelector('.slider-announcer');
    if (!announcer) {
      announcer = document.createElement('div');
      announcer.className = 'slider-announcer';
      announcer.setAttribute('aria-live', 'polite');
      announcer.setAttribute('aria-atomic', 'true');
      announcer.style.cssText = 'position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;';
      this.root.appendChild(announcer);
    }
    this.on('select', (api, payload) => {
      announcer.textContent = `Slide ${payload.currentIndex + 1} of ${api.slides.length}`;
    });
  }

  // ==========================================
  // PLUGIN ARCHITECTURE
  // ==========================================

  initPlugins() {
    this.plugins.forEach(p => p.destroy && p.destroy(this));
    this.plugins = [];

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
              dot.addEventListener('click', () => api.goTo(idx));
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
            updateProgress = () => {
              const pct = api.scrollProgress() * 100;
              // Handle RTL CSS custom property adjustments implicitly 
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
        return {
          init: (api) => {
            play = () => {
              clearTimeout(playTimer);
              if (!api.canScrollNext()) return;
              playTimer = setTimeout(() => { api.scrollNext(); play(); }, api.options.delay);
            };
            stop = () => clearTimeout(playTimer);

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
  }
}

function initDanCarousels() {
  document.querySelectorAll('.slider:not(.slider-ready)').forEach(el => new DanCarousel(el));
}
if (typeof document !== 'undefined') {
  document.addEventListener('DOMContentLoaded', initDanCarousels);
  const observer = new MutationObserver(initDanCarousels);
  observer.observe(document.body, { childList: true, subtree: true });
}
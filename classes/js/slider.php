/**
 * DANCAROUSEL 2.0 - Autonomous HTML-First Carousel Engine
 * POST-REVIEW PATCH (Phase 1 & 2)
 */

class DanCarousel {
  constructor(element) {
    this.root = element;
    this.track = this.root.querySelector('.slides');
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
      duration: parseFloat(this.root.dataset.duration) || 0.1,
      delay: parseInt(this.root.dataset.delay) || 4000
    };

    this.currentX = 0;
    this.targetX = 0;
    this.currentIndex = 0;
    this.velocity = 0;
    this.isDragging = false;
    this.isSettled = true;
    this.rafId = null;
    this.mutationRaf = null;

    this.dragStartX = 0;
    this.dragStartCurrentX = 0;
    this.lastPointerX = 0;
    this.lastPointerTime = 0;
    this.isClickSuppressed = false;

    this.metrics = {
      viewportWidth: 0,
      trackWidth: 0,
      slideWidths: [],
      snapPoints: []
    };

    this.listeners = {};
    this.plugins = [];

    // Bind methods for safe removal
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
    this.emit('init');
  }

  // ==========================================
  // MEASUREMENT & ALIGNMENT
  // ==========================================
  
  updateMeasurements() {
    this.slides = Array.from(this.track.children);
    if (!this.slides.length) return;

    this.metrics.viewportWidth = this.root.getBoundingClientRect().width;
    this.metrics.trackWidth = this.track.scrollWidth;
    
    let currentOffset = 0;
    this.metrics.slideWidths = this.slides.map(slide => slide.getBoundingClientRect().width);

    this.metrics.snapPoints = this.metrics.slideWidths.map((width) => {
      let snap = currentOffset;
      if (this.options.alignCenter) snap -= (this.metrics.viewportWidth / 2) - (width / 2);
      if (this.options.alignEnd) snap -= this.metrics.viewportWidth - width;
      
      currentOffset += width;
      return Math.max(0, snap); 
    });

    this.maxScroll = Math.max(0, this.metrics.trackWidth - this.metrics.viewportWidth);

    // FIX #8 & #9: Clamp snaps strictly without removing duplicates (preserves 1:1 index mapping)
    if (this.options.contain || this.options.containKeep) {
      this.metrics.snapPoints = this.metrics.snapPoints.map(snap => 
        Math.max(0, Math.min(snap, this.maxScroll))
      );
    }

    this.emit('resize');
    this.goTo(this.currentIndex, true);
    this.updateSlideStates();
  }

  // ==========================================
  // OBSERVERS (FIX #6: Mutation Spam)
  // ==========================================
  
  setupObservers() {
    this.resizeObserver = new ResizeObserver(this.onResize);
    this.resizeObserver.observe(this.root);

    this.mutationObserver = new MutationObserver(this.onMutation);
    this.mutationObserver.observe(this.track, { childList: true, subtree: true });
  }

  onResize() {
    this.updateMeasurements();
  }

  onMutation() {
    if (this.mutationRaf) cancelAnimationFrame(this.mutationRaf);
    this.mutationRaf = requestAnimationFrame(() => {
      const newLength = this.track.children.length;
      // Only rebuild if slide count changes
      if (newLength !== this.slides.length) {
        this.updateMeasurements();
        this.initPlugins(); 
      }
    });
  }

  // ==========================================
  // POINTER & EVENTS
  // ==========================================

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
    this.dragStartX = e.clientX;
    this.dragStartCurrentX = this.targetX;
    
    this.lastPointerX = e.clientX;
    this.lastPointerTime = performance.now();
    this.velocity = 0;

    this.track.setPointerCapture(e.pointerId);
    this.track.style.cursor = 'grabbing';
    
    window.addEventListener('pointermove', this.onPointerMove);
    window.addEventListener('pointerup', this.onPointerUp);
    
    this.emit('dragStart');
    e.preventDefault(); 
  }

  onPointerMove(e) {
    if (!this.isDragging) return;

    const dragDistance = this.dragStartX - e.clientX;
    if (Math.abs(dragDistance) > 5) this.isClickSuppressed = true;

    const now = performance.now();
    const dt = now - this.lastPointerTime;
    if (dt > 0) this.velocity = (this.lastPointerX - e.clientX) / dt;
    this.lastPointerX = e.clientX;
    this.lastPointerTime = now;

    let newTarget = this.dragStartCurrentX + dragDistance;

    if (newTarget < 0) {
      newTarget = newTarget * 0.3;
    } else if (newTarget > this.maxScroll) {
      const overflow = newTarget - this.maxScroll;
      newTarget = this.maxScroll + (overflow * 0.3);
    }

    this.targetX = newTarget;
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
      this.targetX += this.velocity * 150; 
      this.targetX = Math.max(0, Math.min(this.targetX, this.maxScroll));
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

  // Phase 2: Key Additions
  onKeyDown(e) {
    if (e.key === 'ArrowRight' || e.key === 'PageDown') this.scrollNext();
    if (e.key === 'ArrowLeft' || e.key === 'PageUp') this.scrollPrev();
    if (e.key === 'Home') this.goTo(0);
    if (e.key === 'End') this.goTo(this.metrics.snapPoints.length - 1);
  }

  // ==========================================
  // PHYSICS & LIFECYCLE
  // ==========================================

  startPhysicsLoop() {
    this.rafId = requestAnimationFrame(this.tick);
  }

  tick() {
    const diff = this.targetX - this.currentX;
    
    if (Math.abs(diff) < 0.1) {
      this.currentX = this.targetX;
      if (!this.isSettled) {
        this.isSettled = true;
        this.emit('settle');
      }
    } else {
      this.isSettled = false;
      this.currentX += diff * this.options.duration;
    }

    this.track.style.transform = `translate3d(-${this.currentX}px, 0, 0)`;
    this.emit('scroll');
    this.rafId = requestAnimationFrame(this.tick);
  }

  destroy() {
    cancelAnimationFrame(this.rafId);
    if (this.mutationRaf) cancelAnimationFrame(this.mutationRaf);
    
    this.unbindEvents();
    this.resizeObserver.disconnect();
    this.mutationObserver.disconnect();
    
    // FIX #1: Pass API correctly to destroy
    this.plugins.forEach(p => p.destroy && p.destroy(this));
    
    this.root.classList.remove('slider-ready');
    this.track.style.transform = '';
    this.emit('destroy');
    this.listeners = {};
  }

  // ==========================================
  // NAVIGATION & STATE
  // ==========================================

  goTo(index, immediate = false) {
    const maxIndex = this.metrics.snapPoints.length - 1;
    this.currentIndex = Math.max(0, Math.min(index, maxIndex));
    this.targetX = this.metrics.snapPoints[this.currentIndex];

    if (immediate) this.currentX = this.targetX;
    
    this.updateSlideStates();
    this.emit('select');
  }

  snapToClosest() {
    let closestIndex = 0;
    let minDistance = Infinity;

    this.metrics.snapPoints.forEach((point, index) => {
      const distance = Math.abs(point - this.targetX);
      if (distance < minDistance) {
        minDistance = distance;
        closestIndex = index;
      }
    });
    this.goTo(closestIndex);
  }

  scrollNext() {
    if (this.currentIndex < this.metrics.snapPoints.length - 1) {
      this.goTo(this.currentIndex + 1);
    } else if (this.options.loop) {
      this.goTo(0); 
    }
  }

  scrollPrev() {
    if (this.currentIndex > 0) {
      this.goTo(this.currentIndex - 1);
    } else if (this.options.loop) {
      this.goTo(this.metrics.snapPoints.length - 1);
    }
  }

  // FIX #7: Loop-safe Math for States
  updateSlideStates() {
    const total = this.slides.length;
    const prevIdx = this.options.loop ? (total + this.currentIndex - 1) % total : this.currentIndex - 1;
    const nextIdx = this.options.loop ? (this.currentIndex + 1) % total : this.currentIndex + 1;

    this.slides.forEach((slide, idx) => {
      slide.classList.remove('active', 'prev', 'next');
      if (idx === this.currentIndex) slide.classList.add('active');
      else if (idx === prevIdx) slide.classList.add('prev');
      else if (idx === nextIdx) slide.classList.add('next');
    });
  }

  setupAccessibility() {
    this.root.setAttribute('role', 'region');
    this.root.setAttribute('aria-roledescription', 'carousel');
    this.track.setAttribute('aria-live', 'polite');
  }

  // ==========================================
  // EVENT SYSTEM
  // ==========================================

  on(event, callback) {
    if (!this.listeners[event]) this.listeners[event] = [];
    this.listeners[event].push(callback);
    return this;
  }

  off(event, callback) {
    if (!this.listeners[event]) return;
    this.listeners[event] = this.listeners[event].filter(cb => cb !== callback);
  }

  emit(event) {
    if (!this.listeners[event]) return;
    this.listeners[event].forEach(cb => cb(this));
  }

  // ==========================================
  // REFACTORED PLUGIN ARCHITECTURE (Fix #2-5)
  // ==========================================

  initPlugins() {
    // FIX #1: Clean up old plugins with instance context
    this.plugins.forEach(p => p.destroy && p.destroy(this));
    this.plugins = [];

    const prevBtn = this.root.querySelector('.slider-prev');
    const nextBtn = this.root.querySelector('.slider-next');
    
    // CONTROLS PLUGIN
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

    // DOTS PLUGIN (Fix #2 & Phase 2 Aria)
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
            updateDots = () => {
              Array.from(dotsContainer.children).forEach((dot, idx) => {
                const isActive = idx === api.currentIndex;
                dot.classList.toggle('active', isActive);
                if (isActive) dot.setAttribute('aria-current', 'true');
                else dot.removeAttribute('aria-current');
              });
            };
            api.on('select', updateDots);
            updateDots();
          },
          destroy: (api) => api.off('select', updateDots)
        };
      })();
      dots.init(this);
      this.plugins.push(dots);
    }

    // COUNTER PLUGIN (Fix #3)
    const counterEl = this.root.querySelector('.slider-counter');
    if (counterEl) {
      const counter = (() => {
        let updateCounter;
        return {
          init: (api) => {
            updateCounter = () => {
              counterEl.textContent = `${api.currentIndex + 1} / ${api.metrics.snapPoints.length}`;
            };
            api.on('select', updateCounter);
            updateCounter();
          },
          destroy: (api) => api.off('select', updateCounter)
        };
      })();
      counter.init(this);
      this.plugins.push(counter);
    }

    // PROGRESS PLUGIN (Fix #4)
    const progressEl = this.root.querySelector('.slider-progress');
    if (progressEl) {
      const progress = (() => {
        let updateProgress;
        return {
          init: (api) => {
            updateProgress = () => {
              const pct = Math.min(100, Math.max(0, (api.currentX / (api.maxScroll || 1)) * 100));
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

    // AUTOPLAY PLUGIN (Fix #5 & Phase 2 Features)
    if (this.options.autoplay) {
      const autoplay = (() => {
        let playTimer, play, stop;
        let onVisChange, onFocusIn, onFocusOut;

        return {
          init: (api) => {
            const isStopLast = api.root.classList.contains('stop-last');
            
            play = () => {
              clearTimeout(playTimer);
              if (isStopLast && api.currentIndex === api.metrics.snapPoints.length - 1) return;
              
              playTimer = setTimeout(() => {
                api.scrollNext();
                play();
              }, api.options.delay);
            };
            
            stop = () => clearTimeout(playTimer);

            // Phase 2 A11y & UX Additions
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

// ==========================================
// AUTO-INIT SYSTEM
// ==========================================
function initDanCarousels() {
  document.querySelectorAll('.slider:not(.slider-ready)').forEach(el => {
    new DanCarousel(el);
  });
}

if (typeof document !== 'undefined') {
  document.addEventListener('DOMContentLoaded', initDanCarousels);
  const observer = new MutationObserver(initDanCarousels);
  observer.observe(document.body, { childList: true, subtree: true });
}
/**
 * DANCAROUSEL 2.0 - Autonomous HTML-First Carousel Engine
 * 
 * Features implemented:
 * - Physics & Momentum (Lerp, Velocity, Flick detection)
 * - Pointer System (Pointer capture, click suppression)
 * - Measurement System (Align start/center/end, Contain modes)
 * - Observers (ResizeObserver, MutationObserver)
 * - Accessibility (Keyboard navigation, ARIA roles)
 * - Plugin Architecture (Controls, Dots, Counter, Progress, Autoplay)
 */

class DanCarousel {
  constructor(element) {
    this.root = element;
    this.track = this.root.querySelector('.slides');
    if (!this.track) return;
    
    // 1. HTML-First Options System (Milestone 4)
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

    // 2. Physics & State
    this.currentX = 0;
    this.targetX = 0;
    this.currentIndex = 0;
    this.velocity = 0;
    this.isDragging = false;
    this.isSettled = true;
    this.rafId = null;

    // Pointer Tracking
    this.dragStartX = 0;
    this.dragStartCurrentX = 0;
    this.lastPointerX = 0;
    this.lastPointerTime = 0;
    this.isClickSuppressed = false;

    // Measurements
    this.metrics = {
      viewportWidth: 0,
      trackWidth: 0,
      slideWidths: [],
      snapPoints: []
    };

    // Event & Plugin Registry
    this.listeners = {};
    this.plugins = [];

    // Bind methods for safe removal (BUG #2 & #4 FIX)
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
  // MEASUREMENT & ALIGNMENT (Milestones 8, 9, 24)
  // ==========================================
  
  updateMeasurements() {
    this.slides = Array.from(this.track.children);
    if (!this.slides.length) return;

    this.metrics.viewportWidth = this.root.getBoundingClientRect().width;
    this.metrics.trackWidth = this.track.scrollWidth;
    
    let currentOffset = 0;
    this.metrics.slideWidths = this.slides.map(slide => slide.getBoundingClientRect().width);

    // Calculate snap points based on alignment
    this.metrics.snapPoints = this.metrics.slideWidths.map((width) => {
      let snap = currentOffset;
      if (this.options.alignCenter) snap -= (this.metrics.viewportWidth / 2) - (width / 2);
      if (this.options.alignEnd) snap -= this.metrics.viewportWidth - width;
      
      currentOffset += width;
      return Math.max(0, snap); // Prevent negative snaps
    });

    // Calculate max scroll bounds
    this.maxScroll = Math.max(0, this.metrics.trackWidth - this.metrics.viewportWidth);

    // Contain logic (Trim edge snaps)
    if (this.options.contain || this.options.containKeep) {
      this.metrics.snapPoints = this.metrics.snapPoints.map(snap => 
        Math.max(0, Math.min(snap, this.maxScroll))
      );
      
      // 'contain' trims duplicate snaps at the end. 'contain-keep' preserves them.
      if (this.options.contain) {
        this.metrics.snapPoints = [...new Set(this.metrics.snapPoints)];
      }
    }

    this.emit('resize');
    this.goTo(this.currentIndex, true);
    this.updateSlideStates();
  }

  // ==========================================
  // OBSERVERS (Milestones 14 & 15)
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
    this.updateMeasurements();
    this.initPlugins(); // Rebind dots/counters if slides changed
  }

  // ==========================================
  // POINTER & FLICK SYSTEM (Milestones 5 & 6)
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
    if (e.button !== 0) return; // Only left click
    
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
    e.preventDefault(); // Prevent image drag
  }

  onPointerMove(e) {
    if (!this.isDragging) return;

    const dragDistance = this.dragStartX - e.clientX;
    if (Math.abs(dragDistance) > 5) this.isClickSuppressed = true;

    // Velocity Tracking
    const now = performance.now();
    const dt = now - this.lastPointerTime;
    if (dt > 0) {
      this.velocity = (this.lastPointerX - e.clientX) / dt;
    }
    this.lastPointerX = e.clientX;
    this.lastPointerTime = now;

    let newTarget = this.dragStartCurrentX + dragDistance;

    // BUG #1 FIX - Correct Rubber Banding Math
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

    // Flick Detection & Drag Free Momentum
    if (this.options.dragFree) {
      this.targetX += this.velocity * 150; // Add momentum
      this.targetX = Math.max(0, Math.min(this.targetX, this.maxScroll));
    } else {
      if (Math.abs(this.velocity) > 0.5) {
        // High velocity flick
        this.velocity > 0 ? this.scrollNext() : this.scrollPrev();
      } else {
        // Slow drag, snap to closest
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
    if (e.key === 'ArrowRight') this.scrollNext();
    if (e.key === 'ArrowLeft') this.scrollPrev();
    if (e.key === 'Home') this.goTo(0);
    if (e.key === 'End') this.goTo(this.metrics.snapPoints.length - 1);
  }

  // ==========================================
  // PHYSICS & LIFECYCLE (Bugs #3 & Engine)
  // ==========================================

  startPhysicsLoop() {
    this.rafId = requestAnimationFrame(this.tick);
  }

  tick() {
    const diff = this.targetX - this.currentX;
    
    // Settle Detection
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
    cancelAnimationFrame(this.rafId); // BUG #3 FIX
    this.unbindEvents();
    this.resizeObserver.disconnect();
    this.mutationObserver.disconnect();
    this.plugins.forEach(p => p.destroy && p.destroy());
    
    this.root.classList.remove('slider-ready');
    this.track.style.transform = '';
    this.emit('destroy');
    this.listeners = {};
  }

  // ==========================================
  // NAVIGATION & STATE (Milestone 16)
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
      this.goTo(0); // Wrap-around logic
    }
  }

  scrollPrev() {
    if (this.currentIndex > 0) {
      this.goTo(this.currentIndex - 1);
    } else if (this.options.loop) {
      this.goTo(this.metrics.snapPoints.length - 1);
    }
  }

  updateSlideStates() {
    const total = this.slides.length;
    this.slides.forEach((slide, idx) => {
      slide.classList.remove('active', 'prev', 'next');
      if (idx === this.currentIndex) slide.classList.add('active');
      else if (idx === this.currentIndex - 1) slide.classList.add('prev');
      else if (idx === this.currentIndex + 1) slide.classList.add('next');
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
  // PLUGIN ARCHITECTURE (Milestone 25 & 17-21)
  // ==========================================

  initPlugins() {
    this.plugins.forEach(p => p.destroy && p.destroy());
    this.plugins = [];

    // Controls Plugin
    const prevBtn = this.root.querySelector('.slider-prev');
    const nextBtn = this.root.querySelector('.slider-next');
    if (prevBtn || nextBtn) {
      const controls = {
        init: (api) => {
          this.hPrev = () => api.scrollPrev();
          this.hNext = () => api.scrollNext();
          if (prevBtn) prevBtn.addEventListener('click', this.hPrev);
          if (nextBtn) nextBtn.addEventListener('click', this.hNext);
        },
        destroy: () => {
          if (prevBtn) prevBtn.removeEventListener('click', this.hPrev);
          if (nextBtn) nextBtn.removeEventListener('click', this.hNext);
        }
      };
      controls.init(this);
      this.plugins.push(controls);
    }

    // Dots Plugin
    const dotsContainer = this.root.querySelector('.slider-dots');
    if (dotsContainer) {
      const dots = {
        init: (api) => {
          dotsContainer.innerHTML = '';
          api.metrics.snapPoints.forEach((_, idx) => {
            const dot = document.createElement('button');
            dot.className = 'slider-dot';
            dot.setAttribute('aria-label', `Go to slide ${idx + 1}`);
            dot.addEventListener('click', () => api.goTo(idx));
            dotsContainer.appendChild(dot);
          });
          this.updateDots = () => {
            Array.from(dotsContainer.children).forEach((dot, idx) => {
              dot.classList.toggle('active', idx === api.currentIndex);
            });
          };
          api.on('select', this.updateDots);
          this.updateDots();
        },
        destroy: (api) => api.off('select', this.updateDots)
      };
      dots.init(this);
      this.plugins.push(dots);
    }

    // Counter Plugin
    const counterEl = this.root.querySelector('.slider-counter');
    if (counterEl) {
      const counter = {
        init: (api) => {
          this.updateCounter = () => {
            counterEl.textContent = `${api.currentIndex + 1} / ${api.metrics.snapPoints.length}`;
          };
          api.on('select', this.updateCounter);
          this.updateCounter();
        },
        destroy: (api) => api.off('select', this.updateCounter)
      };
      counter.init(this);
      this.plugins.push(counter);
    }

    // Progress Plugin
    const progressEl = this.root.querySelector('.slider-progress');
    if (progressEl) {
      const progress = {
        init: (api) => {
          this.updateProgress = () => {
            const pct = Math.min(100, Math.max(0, (api.currentX / (api.maxScroll || 1)) * 100));
            progressEl.style.setProperty('--progress', `${pct}%`);
          };
          api.on('scroll', this.updateProgress);
        },
        destroy: (api) => api.off('scroll', this.updateProgress)
      };
      progress.init(this);
      this.plugins.push(progress);
    }

    // Autoplay Plugin (Milestone 21)
    if (this.options.autoplay) {
      const autoplay = {
        init: (api) => {
          this.playTimer = null;
          this.play = () => {
            clearTimeout(this.playTimer);
            this.playTimer = setTimeout(() => {
              api.scrollNext();
              this.play();
            }, api.options.delay);
          };
          this.stop = () => clearTimeout(this.playTimer);
          
          api.on('dragStart', this.stop);
          api.on('dragEnd', this.play);
          
          if (api.root.classList.contains('pause-hover')) {
            api.root.addEventListener('mouseenter', this.stop);
            api.root.addEventListener('mouseleave', this.play);
          }
          this.play();
        },
        destroy: (api) => {
          this.stop();
          api.off('dragStart', this.stop);
          api.off('dragEnd', this.play);
          api.root.removeEventListener('mouseenter', this.stop);
          api.root.removeEventListener('mouseleave', this.play);
        }
      };
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
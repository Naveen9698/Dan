/**
 * ydCarousel 3.0 - MODULAR FRAMEWORK ARCHITECTURE
 * Core: Strict Sandbox, Full Renderer Encapsulation, Immutable Architecture.
 * Production Ready: 100% Loop Agnostic, Isolated Plugins, Lifecycle Hardened.
 */

const EVENTS = Object.freeze({
  INIT: 'init', RESIZE: 'resize', DESTROY: 'destroy',
  PAUSE: 'pause', RESUME: 'resume', FREEZE: 'freeze', UNFREEZE: 'unfreeze',
  DRAG_START: 'drag:start', DRAG_MOVE: 'drag:move', DRAG_END: 'drag:end',
  SCROLL: 'scroll', SETTLE: 'settle', DOM_CHANGED: 'dom:changed',
  NAV_BEFORE: 'nav:before', NAV: 'nav', NAV_AFTER: 'nav:after',
  SELECT_BEFORE: 'select:before', SELECT: 'select', SELECT_AFTER: 'select:after',
  SLIDE_ACTIVE_CHANGE: 'slide:active', GROUP_ACTIVE_CHANGE: 'group:active',
  PREVIEW_UPDATE: 'preview:update', SLIDE_ENTER: 'slide:enter', SLIDE_EXIT: 'slide:exit',
  LOOP_ENTER: 'loop:enter', LOOP_EXIT: 'loop:exit', LOOP_REPOSITION: 'loop:reposition',
  AUTOPLAY_START: 'autoplay:start', AUTOPLAY_PAUSE: 'autoplay:pause', AUTOPLAY_RESUME: 'autoplay:resume', AUTOPLAY_STOP: 'autoplay:stop',
  SYNC_START: 'sync:start', SYNC_UPDATE: 'sync:update', SYNC_STOP: 'sync:stop',
  DEBUG_OPEN: 'debug:open', DEBUG_CLOSE: 'debug:close',
  PLUGIN_ENABLED: 'plugin:enabled', PLUGIN_DISABLED: 'plugin:disabled'
});

function deepFreeze(obj, visited = new WeakSet()) {
  if (!obj || typeof obj !== 'object' || visited.has(obj) || Object.isFrozen(obj)) return obj;
  visited.add(obj);
  Object.getOwnPropertyNames(obj).forEach(name => {
    const value = obj[name];
    if (value && typeof value === 'object') deepFreeze(value, visited);
  });
  return Object.freeze(obj);
}

// ==========================================
// LAYER 1: Core Environment & Global Registry
// ==========================================
class Environment {
  static hasDOM() { return typeof window !== 'undefined' && typeof document !== 'undefined'; }
  static now() { return typeof performance !== 'undefined' ? performance.now() : Date.now(); }
}

class CarouselRegistry {
  static MAX_LOOP_CLONES = 120;
  static _pluginRegistry = new Map();
  static activeCarousel = null; 
  static _keyboardInitialized = false; 
  static _keyboardUsers = 0; 
  static _instances = new Set(); 

  static _globalKeyDownHandler(e) {
    if (CarouselRegistry.activeCarousel && CarouselRegistry.activeCarousel.options.keyboard) {
      CarouselRegistry.activeCarousel.internal.keyboard.onKeyDown(e);
    }
  }
  static register(api) {
    this._instances.add(api);
    if (!this.activeCarousel || this.activeCarousel.internal.state.flags.destroyed || (api.options.keyboard && !this.activeCarousel.options.keyboard)) {
      this.activeCarousel = api;
    }
  }
  static unregister(api) {
    this._instances.delete(api);
    if (this.activeCarousel === api) {
      this.activeCarousel = null;
      if (Environment.hasDOM()) {
        const readyCarousels = Array.from(document.querySelectorAll('.yd_carousel-ready'))
          .map(el => el.__ydCarousel).filter(a => a && !a.internal.state.flags.destroyed);
        if (readyCarousels.length > 0) {
          this.activeCarousel = readyCarousels.find(a => a.options.keyboard) || readyCarousels[0];
        }
      }
    }
  }
  static validateRenderer(renderer) {
    const REQUIRED_RENDERER_METHODS = [
      'nextIndex', 'prevIndex', 'nextGroup', 'prevGroup', 'resolveTarget',
      'handleReposition', 'normalizePosition', 'distanceToSnap',
      'getScrollProgress', 'getVisualProgress', 'getSlideProgress',
      'cloneCount', 'cloneDiagnostics'
    ];
    REQUIRED_RENDERER_METHODS.forEach(method => {
      if (typeof renderer[method] !== 'function') throw new Error(`Renderer missing: ${method}`);
    });
  }
}

class EventBus {
  constructor(api) {
    this.api = api;
    this.listeners = {};
    this._eventStats = {};
  }
  emit(event, customData = {}) {
    if (!this.api.internal) return;
    const state = this.api.internal.state;
    if (state.flags.destroyed && event !== EVENTS.DESTROY) return;
    this._eventStats[event] = (this._eventStats[event] || 0) + 1;
    const payload = { ...this.getEventPayload(), ...customData };
    if (this.listeners[event]) [...this.listeners[event]].forEach(cb => { try { cb(this.api, payload); } catch (err) { console.error(err); } });
    if (this.listeners['*']) [...this.listeners['*']].forEach(cb => { try { cb(event, this.api, payload); } catch (err) { console.error(err); } });
  }
  on(event, callback) {
    if (!this.listeners[event]) this.listeners[event] = [];
    if (!this.listeners[event].includes(callback)) this.listeners[event].push(callback);
    return this.api;
  }
  off(event, callback) {
    if (!this.listeners[event]) return this.api;
    this.listeners[event] = this.listeners[event].filter(cb => cb !== callback);
    if (this.listeners[event].length === 0) delete this.listeners[event];
    return this.api;
  }
  once(event, callback) {
    const wrapper = (...args) => { this.off(event, wrapper); callback(...args); };
    return this.on(event, wrapper);
  }
  listenerCount(eventName) {
    if (eventName) return this.listeners[eventName] ? this.listeners[eventName].length : 0;
    return Object.keys(this.listeners).reduce((acc, key) => acc + this.listeners[key].length, 0);
  }
  eventStats(clear = false) {
    const stats = Object.freeze({ ...this._eventStats });
    if (clear) this._eventStats = {};
    return stats;
  }
  getEventPayload() {
    if (!this.api.internal) return {};
    const state = this.api.internal.state;
    return {
      currentIndex: state.index.current, previousIndex: state.index.previous,
      currentGroup: state.group.current, previousGroup: state.group.previous,
      previewIndex: state.preview.index !== undefined ? state.preview.index : state.index.current,
      previewGroup: state.preview.group !== undefined ? state.preview.group : state.group.current,
      slideCount: state.dom.originalSlides.length,
      progress: this.api.internal.renderer.getScrollProgress(),
      visualProgress: this.api.internal.renderer.getVisualProgress(),
      isDragging: state.flags.isDraggingActive, isSettled: state.flags.isSettled,
      looping: this.api.options.loop,
      direction: state.physics.velocity > 0 ? 1 : (state.physics.velocity < 0 ? -1 : 0),
      paused: state.flags.isPaused, frozen: state.flags.isFrozen
    };
  }
}

// ==========================================
// LAYER 2: State Store
// ==========================================
class CarouselState {
  constructor() {
    this.position = { current: 0, target: 0 };
    this.index = { current: 0, previous: 0 };
    this.group = { current: 0, previous: 0 };
    this.preview = { index: 0, group: 0 };
    this.physics = { velocity: 0, inertia: 0 };
    this.flags = {
      isPaused: false, isFrozen: false, isAutoFrozen: false, manualFrozen: false,
      isDraggingActive: false, isSettled: true, destroyed: false,
      _lastIntersectionState: true,
      isClickSuppressed: false, ignoreNextMutation: false, isDynamicRefreshing: false,
      _generatedRootId: false, _generatedTrackId: false, _keyboardRegistered: false, batchDepth: 0,
      layoutPending: false, mutationUsingRAF: false, pluginRefreshUsingRAF: false
    };
    this.drag = {
      active: false, startIndex: 0, currentIndex: 0, startPointer: 0, startTargetPos: 0,
      startPos: 0, startCurrentPos: 0, lastPointerPos: 0, lastPointerTime: 0,
      activePointerId: undefined
    };
    this.metrics = {
      viewportSize: 0, trackSize: 0, realTrackSize: 0, prependOffset: 0, gap: 0,
      slidesPerView: 0, averageSlideSize: 0, maxScroll: 0,
      slideSizes: [], slideOffsets: [], slideSnaps: [], groupSnaps: [], snapPoints: []
    };
    this.dom = { originalSlides: [], logicalGroups: [], visibleSlides: new Set(), _trackedActiveNode: null };
    this.timers = { rafId: null, mutationRaf: null, pluginRefreshRaf: null };
    this.stats = { renderTicks: 0, layoutCalcs: 0, lastLayoutTime: 0, initTime: Environment.now() };
  }
}

// ==========================================
// LAYER 3: Orchestration & Lifecycle
// ==========================================
class ModuleManager {
  constructor(api) { this.api = api; }
  initAll() {
    this.api.internal.accessibility.setupAccessibility();
    this.api.internal.observers.setupObservers();
    this.api.internal.measurements.updateMeasurements();
    this.api.internal.keyboard.initialize();
    this.api.internal.drag.initialize();
    this.api.internal.drag.bindEvents();
    this.api.internal.plugins.initialize();
    this.api.internal.plugins.initPlugins();
    this.api.internal.plugins.initEnterprisePlugins();
    
    if (!this.api.internal.state.flags.isSettled) {
      this.api.internal.physics.startPhysicsLoop();
    }
  }
  destroyAll() {
    this.api.internal.accessibility.destroy();
    this.api.internal.keyboard.destroy();
    this.api.internal.drag.unbindEvents();
    this.api.internal.observers.destroy();
    this.api.internal.plugins.destroyAll();
    this.api.internal.renderer._purgeClones();
  }
}

class Lifecycle {
  constructor(api) { this.api = api; }
  init() {
    const state = this.api.internal.state;
    state.flags.destroyed = false;
    state.flags.isPaused = state.flags.isFrozen = state.flags.isAutoFrozen = state.flags.manualFrozen = false;
    this.api.root.dataset.direction = this.api.options.direction;
    CarouselRegistry.register(this.api);
    this.api.internal.modules.initAll();
    this.api.root.classList.add('yd_carousel-ready');
    this.api.internal.events.emit(EVENTS.INIT);
  }
  pause() {
    const state = this.api.internal.state;
    if (state.flags.destroyed || state.flags.isPaused) return;
    state.flags.isPaused = true;
    if (state.timers.rafId) { cancelAnimationFrame(state.timers.rafId); state.timers.rafId = null; }
    if (state.flags.isDraggingActive) this.api.internal.drag.abortDrag();
    this.api.internal.events.emit(EVENTS.PAUSE);
  }
  resume() {
    const state = this.api.internal.state;
    if (state.flags.destroyed || !state.flags.isPaused) return;
    state.flags.isPaused = false;
    if (!state.flags.isFrozen) this._wake();
    this.api.internal.events.emit(EVENTS.RESUME);
  }
  freeze(isManual = true) {
    const state = this.api.internal.state;
    if (state.flags.destroyed) return;
    if (isManual) state.flags.manualFrozen = true;
    if (state.flags.isFrozen) return;
    state.flags.isFrozen = true;
    state.flags.layoutPending = false;

    if (state.timers.rafId) { cancelAnimationFrame(state.timers.rafId); state.timers.rafId = null; }
    
    if (state.timers.mutationRaf) { 
      if (state.flags.mutationUsingRAF) cancelAnimationFrame(state.timers.mutationRaf);
      else clearTimeout(state.timers.mutationRaf); 
      state.timers.mutationRaf = null; 
    }
    
    if (state.timers.pluginRefreshRaf) { 
      if (state.flags.pluginRefreshUsingRAF) cancelAnimationFrame(state.timers.pluginRefreshRaf);
      else clearTimeout(state.timers.pluginRefreshRaf); 
      state.timers.pluginRefreshRaf = null; 
    }

    if (state.flags.isDraggingActive) this.api.internal.drag.abortDrag();
    this.api.internal.observers.disconnectAll();
    this.api.internal.events.emit(EVENTS.FREEZE, { reason: isManual ? 'manual' : 'visibility' });
  }
  unfreeze(isManual = true) {
    const state = this.api.internal.state;
    if (state.flags.destroyed) return;
    if (isManual) state.flags.manualFrozen = false;
    else if (state.flags.manualFrozen) return;
    if (!state.flags.isFrozen) return;
    state.flags.isFrozen = false;

    this.api.internal.observers.reconnectAll();
    this.api.internal.measurements.updateMeasurements();
    
    if (Math.abs(state.position.target - state.position.current) > 0.1 || Math.abs(state.physics.inertia) > 0.1) {
      this._wake();
    }
    this.api.internal.events.emit(EVENTS.UNFREEZE, { reason: isManual ? 'manual' : 'visibility' });
  }
  destroy() {
    const state = this.api.internal.state;
    if (state.flags.destroyed) return;
    this.api.internal.events.emit(EVENTS.DESTROY);
    state.flags.destroyed = true;
    state.flags.layoutPending = false;

    if (state.timers.rafId) cancelAnimationFrame(state.timers.rafId);
    
    if (state.timers.mutationRaf) { 
      if (state.flags.mutationUsingRAF) cancelAnimationFrame(state.timers.mutationRaf);
      else clearTimeout(state.timers.mutationRaf); 
    }
    if (state.timers.pluginRefreshRaf) { 
      if (state.flags.pluginRefreshUsingRAF) cancelAnimationFrame(state.timers.pluginRefreshRaf);
      else clearTimeout(state.timers.pluginRefreshRaf); 
    }
    state.timers.rafId = state.timers.mutationRaf = state.timers.pluginRefreshRaf = null;

    this.api.root.removeAttribute('data-direction');
    if (this.api.options.keyboard) this.api.root.removeAttribute('tabindex');
    if (state.flags._generatedRootId) this.api.root.removeAttribute('id');
    if (state.flags._generatedTrackId) this.api.track.removeAttribute('id');

    this.api.internal.modules.destroyAll();

    this.api.root.classList.remove('yd_carousel-ready');
    this.api.track.style.transform = '';

    if (this.api.track) {
      this.api.track.querySelectorAll('[data-slide-index]').forEach(slide => {
        slide.classList.remove('active', 'prev', 'next', 'in-view', 'out-view');
        slide.removeAttribute('aria-current');
        slide.removeAttribute('tabindex');
        slide.removeAttribute('aria-hidden');
        slide.removeAttribute('role');
        slide.removeAttribute('aria-roledescription');
        slide.removeAttribute('aria-label');
      });
    }

    if (this.api.root.__ydCarousel === this.api) delete this.api.root.__ydCarousel;
    CarouselRegistry.unregister(this.api);

    this.api.internal.events.listeners = {};
    this.api.internal.events._eventStats = {};
    this.api.internal.diagnostics._pluginErrorTracker.clear();

    state.dom.originalSlides = [];
    state.dom.visibleSlides.clear();
  }
  _wake() {
    const state = this.api.internal.state;
    if (state.flags.isPaused || state.flags.isFrozen) return;
    if (state.flags.isSettled) {
      state.flags.isSettled = false;
      this.api.internal.physics.startPhysicsLoop();
    }
  }
}

// ==========================================
// LAYER 4: Renderers (Encapsulation Boundary)
// ==========================================
class BaseRenderer {
  constructor(api) { this.api = api; }
  isLoopActive() { return false; }
  normalizePosition(position) { return position; }
  distanceToSnap(point, position) { return Math.abs(point - position); }
  normalizeIndex(index) { return index; }
  nextIndex(currentIndex) { return currentIndex; }
  prevIndex(currentIndex) { return currentIndex; }
  nextGroup(currentGroup) { return currentGroup; }
  prevGroup(currentGroup) { return currentGroup; }
  getVisualPrev(index) { return index; }
  getVisualNext(index) { return index; }
  getScrollProgress() { return 0; }
  getVisualProgress() { return 0; }
  getSlideProgress(index) { return 0; }
  maxReachableSlideIndex() { return 0; }
  canScrollNext() { return false; }
  canScrollPrev() { return false; }
  createClone(slide) {}
  _purgeClones() {}
  cloneCount() { return 0; }
  cloneDiagnostics() { return { cloneNodes: 0 }; }
  setupTrack(physicalSize, loopGap, relativeOffsets) {
    const state = this.api.internal.state;
    state.metrics.gap = loopGap;
    state.metrics.realTrackSize = physicalSize;
    state.metrics.prependOffset = 0;
  }
  finalizeLayout() {
    const state = this.api.internal.state;
    let rawSlides = state.metrics.slideSnaps.map(snap => Math.max(0, Math.min(snap, state.metrics.maxScroll)));
    let uniqueSlideSnaps = [];
    rawSlides.forEach(snap => { if (uniqueSlideSnaps.length === 0 || Math.abs(uniqueSlideSnaps[uniqueSlideSnaps.length - 1] - snap) > ydCarousel.SNAP_EPSILON) uniqueSlideSnaps.push(snap); });
    state.metrics.slideSnaps = uniqueSlideSnaps;
    
    let rawGroups = state.metrics.groupSnaps.map(snap => Math.max(0, Math.min(snap, state.metrics.maxScroll)));
    let uniqueGroupSnaps = [];
    rawGroups.forEach(snap => { if (uniqueGroupSnaps.length === 0 || Math.abs(uniqueGroupSnaps[uniqueGroupSnaps.length - 1] - snap) > ydCarousel.SNAP_EPSILON) uniqueGroupSnaps.push(snap); });
    state.metrics.groupSnaps = uniqueGroupSnaps;
  }
  resolveTarget(rawTarget, currentTarget) { return rawTarget; }
  handleReposition() {}
}

class StandardRenderer extends BaseRenderer {
  nextIndex(currentIndex) { return Math.min(currentIndex + 1, this.maxReachableSlideIndex()); }
  prevIndex(currentIndex) { return Math.max(currentIndex - 1, 0); }
  nextGroup(currentGroup) { return Math.min(currentGroup + 1, this.api.internal.state.dom.logicalGroups.length - 1); }
  prevGroup(currentGroup) { return Math.max(currentGroup - 1, 0); }
  getVisualPrev(index) { return Math.max(index - 1, 0); }
  getVisualNext(index) { const total = this.api.internal.state.dom.originalSlides.length; return total ? Math.min(index + 1, total - 1) : 0; }
  maxReachableSlideIndex() { return Math.max(0, this.api.internal.state.metrics.slideSnaps.length - 1); }
  canScrollNext() {
    const state = this.api.internal.state;
    if (this.api.options.slideSnap) return state.index.current < this.maxReachableSlideIndex();
    return state.group.current < state.dom.logicalGroups.length - 1;
  }
  canScrollPrev() {
    const state = this.api.internal.state;
    if (this.api.options.slideSnap) return state.index.current > 0;
    return state.group.current > 0;
  }
  getScrollProgress() {
    const state = this.api.internal.state;
    if (!state.metrics.maxScroll) return 0;
    return Math.max(0, Math.min(1, state.position.current / state.metrics.maxScroll));
  }
  getVisualProgress() {
    const p = this.getScrollProgress();
    return (this.api.isRTL && !this.api.options.vertical) ? 1 - p : p;
  }
  getSlideProgress(index) {
    const state = this.api.internal.state;
    const offset = state.metrics.slideOffsets[index] || 0;
    let distance = state.position.current - offset;
    return Math.max(-1, Math.min(1, distance / (state.metrics.viewportSize || 1)));
  }
}

class CloneLoopRenderer extends StandardRenderer {
  isLoopActive() {
    const state = this.api.internal.state;
    return this.api.options.loop && state.metrics.slideSnaps.length > 0 && state.metrics.realTrackSize > 0;
  }
  normalizePosition(position) {
    const state = this.api.internal.state;
    if (!state.metrics.realTrackSize || !this.isLoopActive()) return position;
    let rel = position - state.metrics.prependOffset;
    rel = ((rel % state.metrics.realTrackSize) + state.metrics.realTrackSize) % state.metrics.realTrackSize;
    return rel + state.metrics.prependOffset;
  }
  distanceToSnap(point, position) {
    const state = this.api.internal.state;
    const d1 = Math.abs(point - position);
    if (!this.isLoopActive()) return d1;
    const d2 = Math.abs((point + state.metrics.realTrackSize) - position);
    const d3 = Math.abs((point - state.metrics.realTrackSize) - position);
    return Math.min(d1, d2, d3);
  }
  normalizeIndex(index) {
    const total = this.api.internal.state.dom.originalSlides.length;
    if (!total) return 0;
    let normalized = index;
    while (normalized < 0) normalized += total;
    while (normalized >= total) normalized -= total;
    return normalized;
  }
  nextIndex(currentIndex) {
    if (!this.isLoopActive()) return super.nextIndex(currentIndex);
    return (currentIndex + 1) % this.api.internal.state.dom.originalSlides.length;
  }
  prevIndex(currentIndex) {
    if (!this.isLoopActive()) return super.prevIndex(currentIndex);
    const total = this.api.internal.state.dom.originalSlides.length;
    return (currentIndex - 1 + total) % total;
  }
  nextGroup(currentGroup) {
    if (!this.isLoopActive()) return super.nextGroup(currentGroup);
    return (currentGroup + 1) % this.api.internal.state.dom.logicalGroups.length;
  }
  prevGroup(currentGroup) {
    if (!this.isLoopActive()) return super.prevGroup(currentGroup);
    const total = this.api.internal.state.dom.logicalGroups.length;
    return (currentGroup - 1 + total) % total;
  }
  getVisualPrev(index) {
    if (!this.isLoopActive()) return super.getVisualPrev(index);
    const total = this.api.internal.state.dom.originalSlides.length;
    return total ? (total + index - 1) % total : 0;
  }
  getVisualNext(index) {
    if (!this.isLoopActive()) return super.getVisualNext(index);
    const total = this.api.internal.state.dom.originalSlides.length;
    return total ? (index + 1) % total : 0;
  }
  maxReachableSlideIndex() {
    if (!this.isLoopActive()) return super.maxReachableSlideIndex();
    return Math.max(0, this.api.internal.state.dom.originalSlides.length - 1);
  }
  canScrollNext() { return this.isLoopActive() || super.canScrollNext(); }
  canScrollPrev() { return this.isLoopActive() || super.canScrollPrev(); }
  
  getScrollProgress() {
    if (!this.isLoopActive()) return super.getScrollProgress();
    const state = this.api.internal.state;
    if (state.metrics.realTrackSize > 0) {
      let relativePos = (state.position.current - state.metrics.prependOffset) % state.metrics.realTrackSize;
      if (relativePos < 0) relativePos += state.metrics.realTrackSize;
      return Math.max(0, Math.min(1, relativePos / state.metrics.realTrackSize));
    }
    return 0;
  }
  getSlideProgress(index) {
    if (!this.isLoopActive()) return super.getSlideProgress(index);
    const state = this.api.internal.state;
    const offset = state.metrics.slideOffsets[index] || 0;
    let distance = state.position.current - offset;
    if (state.metrics.realTrackSize > 0) {
      const distFwd = distance - state.metrics.realTrackSize;
      const distBwd = distance + state.metrics.realTrackSize;
      if (Math.abs(distFwd) < Math.abs(distance)) distance = distFwd;
      if (Math.abs(distBwd) < Math.abs(distance)) distance = distBwd;
    }
    return Math.max(-1, Math.min(1, distance / (state.metrics.viewportSize || 1)));
  }

  setupTrack(physicalSize, loopGap, relativeOffsets) {
    const state = this.api.internal.state;
    state.metrics.gap = loopGap;
    state.metrics.realTrackSize = physicalSize + loopGap;
    state.metrics.prependOffset = state.metrics.realTrackSize;
    
    if (state.dom.originalSlides.length > 1 && state.metrics.realTrackSize > 0) {
      let clonedSize = 0;
      let setsNeeded = 0;
      while (clonedSize < (state.metrics.viewportSize * 3) && setsNeeded < 4 && (state.dom.originalSlides.length * (setsNeeded + 1) * 2) <= CarouselRegistry.MAX_LOOP_CLONES) {
        clonedSize += state.metrics.realTrackSize;
        setsNeeded++;
      }
      setsNeeded = Math.max(0, setsNeeded);
      if (setsNeeded > 0) {
        for (let i = 0; i < setsNeeded; i++) {
          const clonesBefore = state.dom.originalSlides.map(s => this.createClone(s));
          const clonesAfter = state.dom.originalSlides.map(s => this.createClone(s));
          const firstOriginal = state.dom.originalSlides[0];
          clonesBefore.forEach(c => this.api.track.insertBefore(c, firstOriginal));
          clonesAfter.forEach(c => this.api.track.appendChild(c));
        }
      }
    }
  }
  finalizeLayout() {
    if (!this.isLoopActive()) {
      super.finalizeLayout();
      return;
    }
    const state = this.api.internal.state;
    
    const uniqueSlides = [];
    state.metrics.slideSnaps.forEach(snap => {
      if (uniqueSlides.length === 0 || Math.abs(uniqueSlides[uniqueSlides.length - 1] - snap) > ydCarousel.SNAP_EPSILON) {
        uniqueSlides.push(snap);
      }
    });
    state.metrics.slideSnaps = uniqueSlides;

    const uniqueGroups = [];
    state.metrics.groupSnaps.forEach(snap => {
      if (uniqueGroups.length === 0 || Math.abs(uniqueGroups[uniqueGroups.length - 1] - snap) > ydCarousel.SNAP_EPSILON) {
        uniqueGroups.push(snap);
      }
    });
    state.metrics.groupSnaps = uniqueGroups;
  }
  resolveTarget(rawTarget, currentTarget) {
    if (!this.isLoopActive()) return rawTarget;
    const state = this.api.internal.state;
    const distNormal = rawTarget - currentTarget;
    const distForward = (rawTarget + state.metrics.realTrackSize) - currentTarget;
    const distBackward = (rawTarget - state.metrics.realTrackSize) - currentTarget;
    const minDist = Math.min(Math.abs(distNormal), Math.abs(distForward), Math.abs(distBackward));
    if (minDist === Math.abs(distForward)) return rawTarget + state.metrics.realTrackSize;
    if (minDist === Math.abs(distBackward)) return rawTarget - state.metrics.realTrackSize;
    return rawTarget;
  }
  handleReposition() {
    if (!this.isLoopActive()) return;
    const state = this.api.internal.state;
    const firstSnap = state.metrics.prependOffset;
    const lastSnap = state.metrics.prependOffset + state.metrics.realTrackSize;
    const buffer = state.metrics.realTrackSize * 0.02;

    if (state.position.target < firstSnap - buffer) {
      this.api.internal.events.emit(EVENTS.LOOP_ENTER, { position: 'start' });
      const originalFrom = state.position.current;
      state.position.current += state.metrics.realTrackSize;
      state.position.target += state.metrics.realTrackSize;
      
      state.position.current = this.normalizePosition(state.position.current);
      state.position.target = this.normalizePosition(state.position.target);

      const normalizedTo = state.position.current;
      const delta = normalizedTo - originalFrom;

      if (!state.flags.isDraggingActive) state.physics.inertia *= 0.5;
      this.api.internal.events.emit(EVENTS.LOOP_REPOSITION, { from: originalFrom, to: normalizedTo, delta });
      this.api.internal.events.emit(EVENTS.LOOP_EXIT, { position: 'end' });
    } else if (state.position.target > lastSnap + buffer) {
      this.api.internal.events.emit(EVENTS.LOOP_ENTER, { position: 'end' });
      const originalFrom = state.position.current;
      state.position.current -= state.metrics.realTrackSize;
      state.position.target -= state.metrics.realTrackSize;

      state.position.current = this.normalizePosition(state.position.current);
      state.position.target = this.normalizePosition(state.position.target);

      const normalizedTo = state.position.current;
      const delta = normalizedTo - originalFrom;

      if (!state.flags.isDraggingActive) state.physics.inertia *= 0.5;
      this.api.internal.events.emit(EVENTS.LOOP_REPOSITION, { from: originalFrom, to: normalizedTo, delta });
      this.api.internal.events.emit(EVENTS.LOOP_EXIT, { position: 'start' });
    }
  }
  createClone(slide) {
    const clone = slide.cloneNode(true);
    clone.setAttribute('data-slide-index', slide.getAttribute('data-slide-index'));
    clone.classList.add('yd_slide-clone');
    clone.setAttribute('role', 'presentation');
    clone.setAttribute('aria-hidden', 'true');
    clone.setAttribute('tabindex', '-1');
    if ('inert' in clone) clone.inert = true;
    clone.removeAttribute('aria-current');
    clone.classList.remove('active', 'prev', 'next', 'in-view', 'out-view');
    const nodes = [clone, ...clone.querySelectorAll('*')];
    nodes.forEach(node => {
      node.removeAttribute('id'); node.removeAttribute('for');
      node.removeAttribute('aria-labelledby'); node.removeAttribute('aria-describedby'); node.removeAttribute('aria-controls');
      node.setAttribute('aria-hidden', 'true');
      if (node.matches && node.matches('a, button, input, select, textarea, [tabindex]')) node.setAttribute('tabindex', '-1');
    });
    return clone;
  }
  _purgeClones() { if (this.api.track) this.api.track.querySelectorAll('.yd_slide-clone').forEach(c => c.remove()); }
  cloneCount() { return this.api.track ? this.api.track.querySelectorAll('.yd_slide-clone').length : 0; }
  cloneDiagnostics() { return { cloneNodes: this.cloneCount() }; }
}

// ==========================================
// LAYER 5: Measurement Engine
// ==========================================
class MeasurementEngine {
  constructor(api) { this.api = api; }
  getConfiguredSlidesPerView() {
    const classTarget = this.api.root.className + ' ' + (this.api.track ? this.api.track.className : '');
    const match = classTarget.match(/\bslides-(\d+)\b/);
    return match ? parseInt(match[1], 10) : null;
  }
  getSlidesPerView() {
    const avg = this.api.internal.state.metrics.averageSlideSize;
    if (avg <= 0) return 1;
    return Math.max(1, Math.round(this.api.internal.state.metrics.viewportSize / (avg + this.api.internal.state.metrics.gap)));
  }
  buildLogicalGroups() {
    const groups = [];
    const visible = this.api.internal.state.metrics.slidesPerView || 1;
    const total = this.api.internal.state.dom.originalSlides.length;
    for (let i = 0; i < total; i += visible) groups.push(i);
    return groups;
  }
  getGroupForIndex(index) {
    const normIndex = this.api.internal.renderer.normalizeIndex(index);
    const groups = this.api.internal.state.dom.logicalGroups;
    if (!groups || groups.length === 0) return 0;
    let result = 0;
    for (let i = 0; i < groups.length; i++) {
      if (groups[i] <= normIndex) result = i;
      else break;
    }
    return result;
  }
  clampState() {
    const state = this.api.internal.state;
    if (!state.metrics.slideSnaps.length) {
      state.index.current = 0; state.group.current = 0; return;
    }
    state.index.current = Math.max(0, Math.min(state.index.current, this.api.internal.renderer.maxReachableSlideIndex()));
    state.group.current = Math.max(0, Math.min(state.group.current, state.dom.logicalGroups.length - 1));
    if (this.api.options.slideSnap) {
      state.group.current = this.getGroupForIndex(state.index.current);
    } else {
      state.index.current = state.dom.logicalGroups[state.group.current] || 0;
    }
  }
  findNearestSlide(position) {
    let minDistance = Infinity;
    let nearest = 0;
    const searchPos = this.api.internal.renderer.normalizePosition(position);

    this.api.internal.state.metrics.slideSnaps.forEach((snap, idx) => {
      const dist = this.api.internal.renderer.distanceToSnap(snap, searchPos);
      if (dist < minDistance) { minDistance = dist; nearest = idx; }
    });
    return nearest;
  }
  updateMeasurements() {
    const state = this.api.internal.state;
    const perfStart = Environment.now();
    try {
      state.dom.visibleSlides.clear();

      if (this.api.internal.observers.mutationObserver) this.api.internal.observers.mutationObserver.disconnect();
      this.api.internal.renderer._purgeClones(); 
      
      state.dom.originalSlides = Array.from(this.api.track.children);
      
      if (state.flags.isDynamicRefreshing && state.dom._trackedActiveNode && state.dom.originalSlides.includes(state.dom._trackedActiveNode)) {
        state.index.current = state.dom.originalSlides.indexOf(state.dom._trackedActiveNode);
      }
      
      if (!state.dom.originalSlides.length) {
        state.metrics.slideSnaps = state.metrics.groupSnaps = state.metrics.snapPoints = state.metrics.slideOffsets = state.metrics.slideSizes = [];
        state.metrics.averageSlideSize = state.metrics.slidesPerView = state.metrics.maxScroll = state.index.current = state.group.current = state.position.current = state.position.target = state.physics.velocity = state.physics.inertia = state.preview.index = state.preview.group = 0;
        state.dom.logicalGroups = [];
        this.api.track.style.transform = '';
        const viewportEl = this.api.root.querySelector('.yd_viewport') || this.api.root;
        if (this.api.options.autoHeight && viewportEl) viewportEl.style.height = '';
        if (this.api.internal.observers.mutationObserver && !state.flags.isFrozen) this.api.internal.observers.mutationObserver.observe(this.api.track, { childList: true, subtree: true, attributes: true, attributeFilter: ['src'] });
        state.stats.layoutCalcs++;
        state.stats.lastLayoutTime = Environment.now() - perfStart;
        return;
      }

      state.dom.originalSlides.forEach((slide, idx) => slide.setAttribute('data-slide-index', idx));

      const viewportEl = this.api.root.querySelector('.yd_viewport') || this.api.root;
      const viewportRect = viewportEl.getBoundingClientRect();
      state.metrics.viewportSize = this.api.options.vertical ? viewportRect.height : viewportRect.width;
      
      state.metrics.slideSizes = state.dom.originalSlides.map(slide => {
        const sRect = slide.getBoundingClientRect();
        return this.api.options.vertical ? sRect.height : sRect.width;
      });

      state.metrics.averageSlideSize = state.metrics.slideSizes.length ? state.metrics.slideSizes.reduce((total, size) => total + size, 0) / state.metrics.slideSizes.length : 0;
      state.metrics.slidesPerView = this.getConfiguredSlidesPerView() ?? this.getSlidesPerView();
      if (state.metrics.slidesPerView < 1) state.metrics.slidesPerView = 1;
      
      state.dom.logicalGroups = this.buildLogicalGroups();

      const firstRect = state.dom.originalSlides[0].getBoundingClientRect();
      const relativeOffsets = state.dom.originalSlides.map(slide => {
        const sRect = slide.getBoundingClientRect();
        if (this.api.options.vertical) return sRect.top - firstRect.top;
        return this.api.isRTL ? firstRect.right - sRect.right : sRect.left - firstRect.left;
      });

      let physicalSize = 0; let loopGap = 0;
      if (state.dom.originalSlides.length > 0) {
        const lastIdx = state.dom.originalSlides.length - 1;
        physicalSize = relativeOffsets[lastIdx] + state.metrics.slideSizes[lastIdx];
      }
      if (state.dom.originalSlides.length > 1) {
        loopGap = Math.max(0, relativeOffsets[1] - (relativeOffsets[0] + state.metrics.slideSizes[0]));
      }

      this.api.internal.renderer.setupTrack(physicalSize, loopGap, relativeOffsets);

      state.metrics.trackSize = this.api.options.vertical ? this.api.track.scrollHeight : this.api.track.scrollWidth;
      state.metrics.slideOffsets = [];
      state.metrics.slideSnaps = [];
      state.metrics.groupSnaps = [];
      
      let currentGroupStartOffset = 0;
      let currentGroupStartSnap = 0;
      
      state.metrics.slideSizes.forEach((size, idx) => {
        const relOffset = relativeOffsets[idx];
        const baseOffset = state.metrics.prependOffset + relOffset;
        let snap = baseOffset;
        if (this.api.options.alignCenter) snap -= (state.metrics.viewportSize / 2) - (size / 2);
        if (this.api.options.alignEnd) snap -= state.metrics.viewportSize - size;
        
        state.metrics.slideOffsets.push(Math.max(0, snap));
        state.metrics.slideSnaps.push(Math.max(0, snap));

        if (idx === 0) {
          state.metrics.groupSnaps.push(Math.max(0, snap));
          currentGroupStartOffset = relOffset;
          currentGroupStartSnap = Math.max(0, snap);
        } else {
          const span = (relOffset - currentGroupStartOffset) + size;
          if (span > state.metrics.viewportSize) {
            currentGroupStartOffset = relOffset;
            currentGroupStartSnap = Math.max(0, snap);
            state.metrics.groupSnaps.push(currentGroupStartSnap);
          }
        }
      });

      state.metrics.maxScroll = Math.max(0, state.metrics.realTrackSize - state.metrics.viewportSize);

      this.api.internal.renderer.finalizeLayout();

      state.metrics.snapPoints = this.api.options.slideSnap ? state.metrics.slideSnaps : state.metrics.groupSnaps;
      
      if (this.api.internal.renderer.isLoopActive() && state.position.current === 0 && state.metrics.slideSnaps.length > 0) {
        state.position.current = state.metrics.slideSnaps[0];
        state.position.target = state.metrics.slideSnaps[0];
      }

      this.clampState();

      if (this.api.internal.observers.visibilityObserver) {
        this.api.internal.observers.visibilityObserver.disconnect();
        if (!state.flags.isFrozen) Array.from(this.api.track.children).forEach(node => this.api.internal.observers.visibilityObserver.observe(node));
      }
      if (this.api.internal.observers.mutationObserver && !state.flags.isFrozen) {
        this.api.internal.observers.mutationObserver.observe(this.api.track, { childList: true, subtree: true, attributes: true, attributeFilter: ['src'] });
      }

      this.api.internal.events.emit(EVENTS.RESIZE);
      
      if (this.api.options.slideSnap) this.api.internal.navigation.goToSlide(state.index.current, true);
      else this.api.internal.navigation.goToGroup(state.group.current, true);

      this.api.internal.accessibility.updateAutoHeight();

      state.stats.layoutCalcs++;
      state.stats.lastLayoutTime = Environment.now() - perfStart;

    } finally {
      state.flags.layoutPending = false;
    }
  }
}

// ==========================================
// LAYER 6: Physics Engine
// ==========================================
class PhysicsEngine {
  constructor(api) { this.api = api; this.tick = this.tick.bind(this); }
  startPhysicsLoop() {
    if (typeof requestAnimationFrame !== 'function') return;
    const state = this.api.internal.state;
    if (state.timers.rafId && typeof cancelAnimationFrame === 'function') cancelAnimationFrame(state.timers.rafId);
    state.timers.rafId = requestAnimationFrame(this.tick);
  }
  tick() {
    const state = this.api.internal.state;
    if (state.flags.destroyed || state.flags.isPaused || state.flags.isFrozen) { state.timers.rafId = null; return; }
    state.stats.renderTicks++;

    this.api.internal.renderer.handleReposition();

    if (this.api.options.dragFree && Math.abs(state.physics.inertia) > 0.1 && !state.flags.isDraggingActive) {
      state.physics.inertia *= this.api.options.friction;
      state.position.target += state.physics.inertia;
      if (!this.api.internal.renderer.isLoopActive()) {
        if (state.position.target < 0) { state.position.target *= 0.8; state.physics.inertia *= 0.5; }
        else if (state.position.target > state.metrics.maxScroll) { state.position.target = state.metrics.maxScroll + ((state.position.target - state.metrics.maxScroll) * 0.8); state.physics.inertia *= 0.5; }
      }
    } else if (this.api.options.dragFree && !this.api.internal.renderer.isLoopActive() && !state.flags.isDraggingActive) {
      if (state.position.target < 0) state.position.target = 0;
      if (state.position.target > state.metrics.maxScroll) state.position.target = state.metrics.maxScroll;
    }

    const diff = state.position.target - state.position.current;
    if (Math.abs(diff) < 0.1 && Math.abs(state.physics.inertia) < 0.1) {
      state.position.current = state.position.target;
      if (!state.flags.isSettled) { 
        state.flags.isSettled = true; 
        this.api.internal.events.emit(EVENTS.SETTLE); 
      }
      state.timers.rafId = null;
    } else {
      state.flags.isSettled = false;
      state.position.current += diff * this.api.options.duration;
    }

    const transformVal = this.api.options.vertical ? -state.position.current : -state.position.current * this.api.dir;
    if (this.api.options.vertical) this.api.track.style.transform = `translate3d(0, ${transformVal}px, 0)`;
    else this.api.track.style.transform = `translate3d(${transformVal}px, 0, 0)`;

    this.api.internal.events.emit(EVENTS.SCROLL);
    if (!state.flags.isSettled && typeof requestAnimationFrame === 'function') state.timers.rafId = requestAnimationFrame(this.tick);
  }
  scrollProgress() { return this.api.internal.renderer.getScrollProgress(); }
  getVisualProgress() { return this.api.internal.renderer.getVisualProgress(); }
  slideProgress(index) { return this.api.internal.renderer.getSlideProgress(index); }
}

// ==========================================
// LAYER 7: Navigation Engine
// ==========================================
class NavigationEngine {
  constructor(api) { this.api = api; }
  maxReachableSlideIndex() { return this.api.internal.renderer.maxReachableSlideIndex(); }
  canScrollNext() {
    const state = this.api.internal.state;
    if (this.api.root.classList.contains('stop-last')) {
      return this.api.options.slideSnap ? state.index.current < this.maxReachableSlideIndex() : state.group.current < state.dom.logicalGroups.length - 1;
    }
    return this.api.internal.renderer.canScrollNext();
  }
  canScrollPrev() { return this.api.internal.renderer.canScrollPrev(); }
  goToGroup(groupIndex, immediate = false, force = false) {
    const state = this.api.internal.state;
    if (!state.dom.logicalGroups.length || ((state.flags.isPaused || state.flags.isFrozen) && !force)) return;
    const targetGroup = Math.max(0, Math.min(groupIndex, state.dom.logicalGroups.length - 1));
    const changed = (state.group.current !== targetGroup);

    if (changed) {
      this.api.internal.events.emit(EVENTS.SELECT_BEFORE, { currentGroup: state.group.current, targetGroup });
      state.group.previous = state.group.current;
      state.group.current = targetGroup;
      state.preview.group = state.group.current;
      this.api.internal.events.emit(EVENTS.GROUP_ACTIVE_CHANGE, { currentGroup: state.group.current, previousGroup: state.group.previous });
    }
    this.goToSlide(state.dom.logicalGroups[targetGroup], immediate, force);
  }
  goToSlide(slideIndex, immediate = false, force = false) {
    const state = this.api.internal.state;
    if (!state.metrics.slideSnaps.length || ((state.flags.isPaused || state.flags.isFrozen) && !force)) return;
    const targetSlide = Math.max(0, Math.min(slideIndex, this.maxReachableSlideIndex()));
    const changed = (state.index.current !== targetSlide);

    if (changed) {
      this.api.internal.events.emit(EVENTS.NAV_BEFORE, { currentIndex: state.index.current, targetIndex: targetSlide });
      this.api.internal.events.emit(EVENTS.SELECT_BEFORE, { currentIndex: state.index.current, targetIndex: targetSlide });
      state.index.previous = state.index.current;
      state.index.current = targetSlide;
      state.preview.index = state.index.current;
      this.api.internal.events.emit(EVENTS.NAV, { currentIndex: state.index.current, previousIndex: state.index.previous });
      this.api.internal.events.emit(EVENTS.SLIDE_ACTIVE_CHANGE, { currentIndex: state.index.current, previousIndex: state.index.previous });
    }
    
    const safeSnapIndex = Math.max(0, Math.min(state.index.current, state.metrics.slideSnaps.length - 1));
    const rawTarget = state.metrics.slideSnaps[safeSnapIndex];
    state.physics.inertia = 0; 

    state.position.target = immediate ? rawTarget : this.api.internal.renderer.resolveTarget(rawTarget, state.position.target);

    if (immediate) {
      state.physics.inertia = state.physics.velocity = 0;
      state.position.current = state.position.target;
      const transformVal = this.api.getTransformValue();
      this.api.track.style.transform = this.api.options.vertical ? `translate3d(0, ${transformVal}px, 0)` : `translate3d(${transformVal}px, 0, 0)`;
      if (!state.flags.isSettled) { state.flags.isSettled = true; this.api.internal.events.emit(EVENTS.SETTLE); }
    } else {
      this.api.internal.lifecycle._wake();
    }

    const targetGroup = this.api.internal.measurements.getGroupForIndex(state.index.current);
    if (state.group.current !== targetGroup) {
       state.group.previous = state.group.current;
       state.group.current = targetGroup;
       state.preview.group = state.group.current;
       this.api.internal.events.emit(EVENTS.GROUP_ACTIVE_CHANGE, { currentGroup: state.group.current, previousGroup: state.group.previous });
    }
    
    this.api.internal.accessibility.updateSlideStates();
    this.api.internal.accessibility.updateAutoHeight();

    if (changed) { 
      this.api.internal.events.emit(EVENTS.SELECT); 
      this.api.internal.events.emit(EVENTS.SELECT_AFTER); 
      this.api.internal.events.emit(EVENTS.NAV_AFTER, { currentIndex: state.index.current });
    }
  }
  scrollNext(force = false) {
    const state = this.api.internal.state;
    if (!state.dom.originalSlides.length || ((state.flags.isPaused || state.flags.isFrozen) && !force)) return;
    if (this.api.options.slideSnap) {
      this.goToSlide(this.api.internal.renderer.nextIndex(state.index.current), false, force);
      return;
    }
    if (state.group.current < state.dom.logicalGroups.length - 1) this.goToGroup(this.api.internal.renderer.nextGroup(state.group.current), false, force);
    else if (this.canScrollNext()) this.goToGroup(this.api.internal.renderer.nextGroup(state.group.current), false, force);
  }
  scrollPrev(force = false) {
    const state = this.api.internal.state;
    if (!state.dom.originalSlides.length || ((state.flags.isPaused || state.flags.isFrozen) && !force)) return;
    if (this.api.options.slideSnap) {
      this.goToSlide(this.api.internal.renderer.prevIndex(state.index.current), false, force);
      return;
    }
    if (state.group.current > 0) this.goToGroup(this.api.internal.renderer.prevGroup(state.group.current), false, force);
    else if (this.canScrollPrev()) this.goToGroup(this.api.internal.renderer.prevGroup(state.group.current), false, force);
  }
}

// ==========================================
// LAYER 8: Interaction Modules
// ==========================================
class DragModule {
  constructor(api) {
    this.api = api;
    this.onPointerDown = this.onPointerDown.bind(this);
    this.onPointerMove = this.onPointerMove.bind(this);
    this.onPointerUp = this.onPointerUp.bind(this);
    this.onClick = this.onClick.bind(this);
  }
  initialize() {
    this._onLoopReposition = (api, payload) => {
      const state = this.api.internal.state;
      if (state.flags.isDraggingActive) {
        state.drag.startCurrentPos += payload.delta;
      }
    };
    this.api.internal.events.on(EVENTS.LOOP_REPOSITION, this._onLoopReposition);
  }
  bindEvents() {
    this.api.track.addEventListener('pointerdown', this.onPointerDown);
    this.api.track.addEventListener('click', this.onClick, { capture: true });
    this.api.root.addEventListener('mouseenter', this.api.onActivate);
    this.api.root.addEventListener('focusin', this.api.onActivate);
    this.api.root.addEventListener('mouseleave', this.api.onDeactivate);
    this.api.root.addEventListener('focusout', this.api.onDeactivate);
    this.api.track.addEventListener('pointerdown', this.api.onActivate);
  }
  unbindEvents() {
    this.api.internal.events.off(EVENTS.LOOP_REPOSITION, this._onLoopReposition);
    this.api.track.removeEventListener('pointerdown', this.onPointerDown);
    this.api.track.removeEventListener('click', this.onClick, { capture: true });
    if (Environment.hasDOM()) {
      window.removeEventListener('pointermove', this.onPointerMove);
      window.removeEventListener('pointerup', this.onPointerUp);
      window.removeEventListener('pointercancel', this.onPointerUp);
    }
    this.api.root.removeEventListener('mouseenter', this.api.onActivate);
    this.api.root.removeEventListener('focusin', this.api.onActivate);
    this.api.root.removeEventListener('mouseleave', this.api.onDeactivate);
    this.api.root.removeEventListener('focusout', this.api.onDeactivate);
    this.api.track.removeEventListener('pointerdown', this.api.onActivate);
  }
  getPointerPos(e) { return this.api.options.vertical ? e.clientY : e.clientX; }
  onPointerDown(e) {
    const state = this.api.internal.state;
    if (e.button !== 0 || state.flags.isPaused || state.flags.isFrozen) return; 
    state.flags.isDraggingActive = true;
    state.drag.active = true;
    state.drag.startIndex = state.index.current;
    state.drag.currentIndex = state.index.current;
    state.drag.startPointer = this.getPointerPos(e);
    state.drag.startTargetPos = state.position.target;
    state.drag.activePointerId = e.pointerId;
    state.flags.isClickSuppressed = false;

    state.position.target = state.position.current;
    state.drag.startPos = this.getPointerPos(e);
    state.drag.startCurrentPos = state.position.current;
    state.drag.lastPointerPos = this.getPointerPos(e);
    state.drag.lastPointerTime = Environment.now();
    state.physics.velocity = 0;
    state.physics.inertia = 0; 
    state.preview.index = state.index.current;
    state.preview.group = state.group.current;

    try { this.api.track.setPointerCapture(e.pointerId); } catch (err) {}
    this.api.track.style.cursor = 'grabbing';
    if (Environment.hasDOM()) {
      window.addEventListener('pointermove', this.onPointerMove);
      window.addEventListener('pointerup', this.onPointerUp);
      window.addEventListener('pointercancel', this.onPointerUp);
    }
    this.api.internal.lifecycle._wake();
    this.api.internal.events.emit(EVENTS.DRAG_START);
    e.preventDefault(); 
  }
  onPointerMove(e) {
    const state = this.api.internal.state;
    if (!state.flags.isDraggingActive) return;
    const currentPointer = this.getPointerPos(e);
    let dragDistance = state.drag.startPos - currentPointer;
    if (!this.api.options.vertical) dragDistance *= this.api.dir;
    if (Math.abs(dragDistance) > this.api.options.dragThreshold) state.flags.isClickSuppressed = true;

    const now = Environment.now();
    const dt = now - state.drag.lastPointerTime;
    if (dt > 0) {
      let rawVel = (state.drag.lastPointerPos - currentPointer) / dt;
      if (!this.api.options.vertical) rawVel *= this.api.dir;
      state.physics.velocity = rawVel;
    }
    state.drag.lastPointerPos = currentPointer;
    state.drag.lastPointerTime = now;

    let newTarget = state.drag.startCurrentPos + dragDistance;
    if (!this.api.internal.renderer.isLoopActive()) {
      if (newTarget < 0) newTarget *= 0.3;
      else if (newTarget > state.metrics.maxScroll) newTarget = state.metrics.maxScroll + ((newTarget - state.metrics.maxScroll) * 0.3);
    }
    state.position.target = newTarget;
    if (state.drag.active) {
      state.drag.currentIndex = this.api.internal.measurements.findNearestSlide(state.position.target);
      state.preview.group = this.api.internal.measurements.getGroupForIndex(state.drag.currentIndex);
    }
    this.api.internal.lifecycle._wake();
    this.api.internal.events.emit(EVENTS.DRAG_MOVE);

    const nearest = this.api.internal.measurements.findNearestSlide(state.position.target);
    if (nearest !== state.preview.index) {
      state.preview.index = nearest;
      this.api.internal.events.emit(EVENTS.PREVIEW_UPDATE);
    }
  }
  onPointerUp(e) {
    const state = this.api.internal.state;
    if (!state.flags.isDraggingActive) return;
    state.flags.isDraggingActive = false;
    state.drag.active = false;
    setTimeout(() => { state.flags.isClickSuppressed = false; }, 50);

    const pid = e && e.pointerId !== undefined ? e.pointerId : state.drag.activePointerId;
    if (pid !== undefined) { try { this.api.track.releasePointerCapture(pid); } catch(err) {} }
    state.drag.activePointerId = undefined;
    this.api.track.style.cursor = '';

    if (Environment.hasDOM()) {
      window.removeEventListener('pointermove', this.onPointerMove);
      window.removeEventListener('pointerup', this.onPointerUp);
      window.removeEventListener('pointercancel', this.onPointerUp);
    }
    this.api.internal.events.emit(EVENTS.DRAG_END);

    if (this.api.reducedMotion) {
      state.physics.inertia = 0;
      this.snapToClosest();
      return;
    }
    if (this.api.options.dragFree) {
      state.physics.inertia = state.physics.velocity * this.api.options.dragInertia; 
    } else {
      if (Math.abs(state.physics.velocity) > this.api.options.velocityThreshold) {
        state.physics.velocity > 0 ? this.api.internal.navigation.scrollNext() : this.api.internal.navigation.scrollPrev();
      } else {
        this.snapToClosest();
      }
    }
  }
  onClick(e) { if (this.api.internal.state.flags.isClickSuppressed) { e.preventDefault(); e.stopPropagation(); } }
  abortDrag() {
    const state = this.api.internal.state;
    state.flags.isDraggingActive = false;
    state.drag.active = false;
    state.flags.isClickSuppressed = false;
    this.api.track.style.cursor = '';
    if (Environment.hasDOM()) {
      window.removeEventListener('pointermove', this.onPointerMove);
      window.removeEventListener('pointerup', this.onPointerUp);
      window.removeEventListener('pointercancel', this.onPointerUp);
    }
    if (state.drag.activePointerId !== undefined) {
      try { this.api.track.releasePointerCapture(state.drag.activePointerId); } catch (err) {}
      state.drag.activePointerId = undefined;
    }
    this.api.internal.events.emit(EVENTS.DRAG_END);
    this.snapToClosest(true, true);
  }
  snapToClosest(immediate = false, force = false) {
    let closestIndex = 0;
    let minDistance = Infinity;
    const state = this.api.internal.state;

    state.metrics.slideSnaps.forEach((point, index) => {
      const distance = this.api.internal.renderer.distanceToSnap(point, state.position.target);
      if (distance < minDistance) { minDistance = distance; closestIndex = index; }
    });

    if (this.api.options.dragFree) {
       state.position.target = state.metrics.slideSnaps[closestIndex];
       if (immediate) {
         state.position.current = state.position.target;
         const transformVal = this.api.getTransformValue();
         this.api.track.style.transform = this.api.options.vertical ? `translate3d(0, ${transformVal}px, 0)` : `translate3d(${transformVal}px, 0, 0)`;
         if (!state.flags.isSettled) { state.flags.isSettled = true; this.api.internal.events.emit(EVENTS.SETTLE); }
       } else { this.api.internal.lifecycle._wake(); }
    } else {
       if (this.api.options.slideSnap) this.api.internal.navigation.goToSlide(closestIndex, immediate, force);
       else { const group = this.api.internal.measurements.getGroupForIndex(closestIndex); this.api.internal.navigation.goToGroup(group, immediate, force); }
    }
  }
}

class KeyboardModule {
  constructor(api) { this.api = api; }
  initialize() {
    const state = this.api.internal.state;
    if (!this.api.options.keyboard) return;
    if (!state.flags._keyboardRegistered) {
      CarouselRegistry._keyboardUsers++;
      state.flags._keyboardRegistered = true;
    }
    if (!CarouselRegistry._keyboardInitialized) {
      if (Environment.hasDOM()) document.addEventListener('keydown', CarouselRegistry._globalKeyDownHandler);
      CarouselRegistry._keyboardInitialized = true;
    }
    this.api.root.setAttribute('tabindex', '0');
  }
  destroy() {
    const state = this.api.internal.state;
    if (!state.flags._keyboardRegistered) return;
    CarouselRegistry._keyboardUsers--;
    state.flags._keyboardRegistered = false;
    if (CarouselRegistry._keyboardUsers <= 0) {
      if (Environment.hasDOM()) document.removeEventListener('keydown', CarouselRegistry._globalKeyDownHandler);
      CarouselRegistry._keyboardInitialized = false;
      CarouselRegistry._keyboardUsers = 0;
    }
  }
  onKeyDown(e) {
    const state = this.api.internal.state;
    if ((CarouselRegistry.activeCarousel && CarouselRegistry.activeCarousel !== this.api) || state.flags.isPaused || state.flags.isFrozen) return;
    const activeElement = Environment.hasDOM() ? document.activeElement : null;
    if (activeElement) {
      const isInputTag = ['INPUT', 'TEXTAREA', 'SELECT', 'OPTION'].includes(activeElement.tagName);
      if (isInputTag || activeElement.isContentEditable) return; 
    }
    const keys = ['Home', 'End', 'PageDown', 'PageUp', 'ArrowRight', 'ArrowLeft', 'ArrowDown', 'ArrowUp'];
    if (keys.includes(e.key)) e.preventDefault();

    const isVert = this.api.options.vertical;
    if (e.key === 'Home') this.api.options.slideSnap ? this.api.internal.navigation.goToSlide(0) : this.api.internal.navigation.goToGroup(0);
    if (e.key === 'End') this.api.options.slideSnap ? this.api.internal.navigation.goToSlide(this.api.internal.navigation.maxReachableSlideIndex()) : this.api.internal.navigation.goToGroup(state.dom.logicalGroups.length - 1);
    if (e.key === 'PageDown') this.api.internal.navigation.scrollNext();
    if (e.key === 'PageUp') this.api.internal.navigation.scrollPrev();
    if (e.key === 'ArrowRight' && !isVert) this.api.isRTL ? this.api.internal.navigation.scrollPrev() : this.api.internal.navigation.scrollNext();
    if (e.key === 'ArrowLeft' && !isVert) this.api.isRTL ? this.api.internal.navigation.scrollNext() : this.api.internal.navigation.scrollPrev();
    if (e.key === 'ArrowDown' && isVert) this.api.internal.navigation.scrollNext();
    if (e.key === 'ArrowUp' && isVert) this.api.internal.navigation.scrollPrev();
  }
}

// ==========================================
// LAYER 9: Observer Manager
// ==========================================
class ObserverManager {
  constructor(api) {
    this.api = api;
    this.resizeObserver = null;
    this.mutationObserver = null;
    this.visibilityObserver = null;
    this.rootVisibilityObserver = null;
    this._docVisHandler = () => {
      const state = this.api.internal.state;
      const shouldBeActive = state.flags._lastIntersectionState && !document.hidden;
      if (!shouldBeActive && !state.flags.isFrozen) { state.flags.isAutoFrozen = true; this.api.internal.lifecycle.freeze(false); }
      else if (shouldBeActive && state.flags.isAutoFrozen) { state.flags.isAutoFrozen = false; this.api.internal.lifecycle.unfreeze(false); }
    };
  }
  setupObservers() {
    if (typeof ResizeObserver !== 'undefined') {
      this.resizeObserver = new ResizeObserver(() => this.api.internal.measurements.updateMeasurements());
      this.resizeObserver.observe(this.api.root);
    }
    if (typeof MutationObserver !== 'undefined') {
      this.mutationObserver = new MutationObserver((mutations) => {
        const state = this.api.internal.state;
        if (state.flags.batchDepth > 0 || state.flags.isDraggingActive || state.flags.ignoreNextMutation || state.flags.layoutPending) {
          state.flags.ignoreNextMutation = false; 
          return; 
        }
        if (mutations.some(m => [...Array.from(m.addedNodes), ...Array.from(m.removedNodes)].some(n => n.nodeType === 1 && n.classList.contains('yd_slide-clone')))) return;
        
        if (state.timers.mutationRaf) {
          if (state.flags.mutationUsingRAF) cancelAnimationFrame(state.timers.mutationRaf);
          else clearTimeout(state.timers.mutationRaf);
          state.timers.mutationRaf = null;
        }

        const runMutationRefresh = () => {
          try {
            state.timers.mutationRaf = null;
            if (state.flags.destroyed) return;
            const structureChanged = mutations.some(m => m.type === 'childList');
            this.api.internal.measurements.updateMeasurements();
            this.api.internal.events.emit(EVENTS.DOM_CHANGED, { structureChanged });
          } finally {
            state.flags.layoutPending = false;
          }
        };
        
        state.flags.layoutPending = true;
        if (typeof requestAnimationFrame === 'function') {
          state.flags.mutationUsingRAF = true;
          state.timers.mutationRaf = requestAnimationFrame(runMutationRefresh);
        } else {
          state.flags.mutationUsingRAF = false;
          state.timers.mutationRaf = setTimeout(runMutationRefresh, 16);
        }
      });
    }
    if (typeof IntersectionObserver !== 'undefined') {
      const viewport = this.api.root.querySelector('.yd_viewport') || this.api.root;
      this.visibilityObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          const node = entry.target;
          const idx = parseInt(node.getAttribute('data-slide-index'), 10);
          const isClone = node.classList.contains('yd_slide-clone');
          if (entry.isIntersecting) {
            node.classList.add('in-view'); node.classList.remove('out-view');
            if (!isClone) { node.removeAttribute('aria-hidden'); if (!isNaN(idx)) { this.api.internal.state.dom.visibleSlides.add(idx); this.api.internal.events.emit(EVENTS.SLIDE_ENTER, { index: idx }); } }
          } else {
            node.classList.add('out-view'); node.classList.remove('in-view');
            if (!isClone) { node.setAttribute('aria-hidden', 'true'); if (!isNaN(idx)) { this.api.internal.state.dom.visibleSlides.delete(idx); this.api.internal.events.emit(EVENTS.SLIDE_EXIT, { index: idx }); } }
          }
        });
      }, { root: viewport, threshold: 0.01 });

      if (this.api.options.autoVisibility) {
        this.rootVisibilityObserver = new IntersectionObserver((entries) => {
          this.api.internal.state.flags._lastIntersectionState = entries[0].isIntersecting;
          this._docVisHandler();
        }, { rootMargin: '150px' });
        this.rootVisibilityObserver.observe(this.api.root);
        if (Environment.hasDOM()) document.addEventListener('visibilitychange', this._docVisHandler);
      }
    }
  }
  disconnectAll() {
    if (this.resizeObserver) this.resizeObserver.disconnect();
    if (this.mutationObserver) this.mutationObserver.disconnect();
    if (this.visibilityObserver) this.visibilityObserver.disconnect();
  }
  reconnectAll() {
    if (this.resizeObserver && this.api.root) this.resizeObserver.observe(this.api.root);
    if (this.mutationObserver && this.api.track) this.mutationObserver.observe(this.api.track, { childList: true, subtree: true, attributes: true, attributeFilter: ['src'] });
    if (this.visibilityObserver && this.api.track) {
      this.api.internal.state.dom.visibleSlides.clear();
      Array.from(this.api.track.children).forEach(node => this.visibilityObserver.observe(node));
    }
  }
  destroy() {
    this.disconnectAll();
    if (this.rootVisibilityObserver) this.rootVisibilityObserver.disconnect();
    if (Environment.hasDOM()) document.removeEventListener('visibilitychange', this._docVisHandler);
    this.resizeObserver = this.mutationObserver = this.visibilityObserver = this.rootVisibilityObserver = null;
  }
}

// ==========================================
// LAYER 10: Dynamic Content Manager
// ==========================================
class DynamicContentManager {
  constructor(api) { this.api = api; }
  batch(callback) {
    const state = this.api.internal.state;
    if (state.flags.destroyed) return;
    if (state.flags.batchDepth === 0) {
      state.dom._trackedActiveNode = state.dom.originalSlides[state.index.current];
      this.api.internal.renderer._purgeClones(); 
    }
    state.flags.batchDepth++;
    state.flags.ignoreNextMutation = true;
    let batchValid = true;
    try {
      const result = callback();
      if (result instanceof Promise) {
        batchValid = false; state.flags.ignoreNextMutation = false; state.dom._trackedActiveNode = null;
        throw new Error('[ydCarousel] batch() callback must be synchronous.');
      }
    } finally {
      state.flags.batchDepth--;
      if (batchValid && state.flags.batchDepth === 0) this._refreshAfterDynamic();
    }
  }
  _refreshAfterDynamic() {
    const state = this.api.internal.state;
    if (state.flags.batchDepth > 0) return;
    state.flags.isDynamicRefreshing = true;
    this.api.internal.measurements.updateMeasurements();
    state.flags.isDynamicRefreshing = false;
    state.dom._trackedActiveNode = null;
    this.api.internal.plugins.schedulePluginRefresh();
  }
  addSlide(html) { this.batch(() => { this.api.track.insertAdjacentHTML('beforeend', html); }); }
  removeSlide(index) { this.batch(() => { const slide = this.api.internal.state.dom.originalSlides[index]; if (slide) slide.remove(); }); }
  removeAllSlides() { this.batch(() => { this.api.track.innerHTML = ''; this.api.internal.state.dom._trackedActiveNode = null; }); }
  insertSlide(index, html) {
    this.batch(() => {
      const target = this.api.internal.state.dom.originalSlides[index];
      if (!target) this.api.track.insertAdjacentHTML('beforeend', html);
      else target.insertAdjacentHTML('beforebegin', html);
    });
  }
  replaceSlide(index, html) {
    this.batch(() => {
      const target = this.api.internal.state.dom.originalSlides[index];
      if (!target) return;
      target.insertAdjacentHTML('beforebegin', html);
      if (this.api.internal.state.dom._trackedActiveNode === target) this.api.internal.state.dom._trackedActiveNode = null; 
      target.remove();
    });
  }
}

// ==========================================
// LAYER 11: Accessibility Manager
// ==========================================
class AccessibilityManager {
  constructor(api) { this.api = api; this._announcer = null; this.announceHandler = null; }
  setupAccessibility() {
    if (!Environment.hasDOM()) return;
    const state = this.api.internal.state;
    this.api.root.setAttribute('role', 'region');
    this.api.root.setAttribute('aria-roledescription', 'carousel');
    
    if (!this.api.root.id) { this.api.root.id = `yd_carousel_${Math.random().toString(36).slice(2, 11)}`; state.flags._generatedRootId = true; }
    if (!this.api.track.id) { this.api.track.id = `${this.api.root.id}_track`; state.flags._generatedTrackId = true; }
    this.api.track.setAttribute('aria-live', 'polite');
    
    let announcer = this.api.root.querySelector('.yd_carousel-announcer');
    if (!announcer) {
      announcer = document.createElement('div');
      announcer.className = 'yd_carousel-announcer';
      announcer.setAttribute('aria-live', 'polite');
      announcer.setAttribute('aria-atomic', 'true');
      announcer.style.cssText = 'position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;';
      this.api.root.appendChild(announcer);
    }
    this._announcer = announcer;
    
    this.announceHandler = (api, payload) => {
      if (api.options.slideSnap) announcer.textContent = `Slide ${payload.currentIndex + 1} of ${api.internal.state.dom.originalSlides.length}`;
      else announcer.textContent = `Group ${payload.currentGroup + 1} of ${api.internal.state.dom.logicalGroups.length}`;
    };
    this.api.internal.events.on(EVENTS.SELECT, this.announceHandler);
  }
  updateSlideStates() {
    const state = this.api.internal.state;
    if (!state.dom.originalSlides.length) return;
    const total = state.dom.originalSlides.length;
    const prevIdx = this.api.internal.renderer.getVisualPrev(state.index.current);
    const nextIdx = this.api.internal.renderer.getVisualNext(state.index.current);

    state.dom.originalSlides.forEach((slide, idx) => {
      slide.classList.remove('active', 'prev', 'next');
      slide.removeAttribute('aria-current');
      slide.setAttribute('role', 'group');
      slide.setAttribute('aria-roledescription', 'slide');
      slide.setAttribute('aria-label', `${idx + 1} of ${total}`);
      if (idx === state.index.current) { slide.classList.add('active'); slide.setAttribute('aria-current', 'true'); slide.setAttribute('tabindex', '0'); }
      else { if (idx === prevIdx) slide.classList.add('prev'); else if (idx === nextIdx) slide.classList.add('next'); slide.setAttribute('tabindex', '-1'); }
    });

    if (this.api.options.loop) {
      this.api.track.querySelectorAll('.yd_slide-clone').forEach(clone => {
        clone.classList.remove('active', 'prev', 'next');
        clone.removeAttribute('aria-current');
      });
    }

    if (this.api.options.focusOnChange && Environment.hasDOM() && this.api.root.contains(document.activeElement)) {
      const active = state.dom.originalSlides[state.index.current];
      if (active) {
        if (!active.hasAttribute('tabindex')) active.setAttribute('tabindex', '0');
        try { active.focus({ preventScroll: true }); } catch (err) { active.focus(); }
      }
    }
  }
  updateAutoHeight() {
    if (!this.api.options.autoHeight) return;
    const slide = this.api.internal.state.dom.originalSlides[this.api.internal.state.index.current];
    if (!slide) return;
    const height = slide.offsetHeight;
    if (height <= 0) return;
    const viewport = this.api.root.querySelector('.yd_viewport') || this.api.root;
    viewport.style.height = height + 'px';
  }
  destroy() {
    if (this.announceHandler) this.api.internal.events.off(EVENTS.SELECT, this.announceHandler);
  }
}

// ==========================================
// LAYER 12: Dependency Manager
// ==========================================
class DependencyManager {
  constructor(api) { this.api = api; }
  circularDetection() {
    const registry = CarouselRegistry._pluginRegistry;
    const cycles = []; const visited = new Map(); const path = [];
    const dfs = (node) => {
      visited.set(node, 1); path.push(node);
      const def = registry.get(node); const deps = def ? (def.dependencies || def.requires || []) : [];
      for (const dep of deps) {
        if (!registry.has(dep)) continue;
        const state = visited.get(dep) || 0;
        if (state === 1) { const cycleStart = path.indexOf(dep); cycles.push([...path.slice(cycleStart), dep]); } 
        else if (state === 0) dfs(dep);
      }
      path.pop(); visited.set(node, 2);
    };
    registry.forEach((_, name) => { if ((visited.get(name) || 0) === 0) dfs(name); });
    return Object.freeze(cycles.map(c => Object.freeze([...c])));
  }
  validateDependencies(pluginName = null) {
    const registry = CarouselRegistry._pluginRegistry;
    const missing = []; const targetPlugins = pluginName ? [pluginName] : Array.from(registry.keys());
    targetPlugins.forEach(name => {
      const def = registry.get(name);
      if (def) {
        const deps = def.dependencies || def.requires || [];
        deps.forEach(dep => { if (!registry.has(dep)) missing.push(Object.freeze({ plugin: name, missingDependency: dep })); });
      } else if (!registry.has(name)) {
        missing.push(Object.freeze({ plugin: name, missingDependency: 'unregistered' }));
      }
    });
    const circular = this.circularDetection();
    return Object.freeze({ valid: missing.length === 0 && circular.length === 0, missing: Object.freeze(missing), circular });
  }
  dependencyReport() {
    const registry = CarouselRegistry._pluginRegistry;
    const activeNames = new Set([...this.api.internal.plugins.plugins.map(p => p.name).filter(Boolean), ...Array.from(this.api.internal.plugins.activePlugins.keys())]);
    const report = {}; const missingDependencies = []; const dependentsMap = new Map();
    registry.forEach((_, name) => dependentsMap.set(name, []));
    registry.forEach((def, name) => {
      const deps = def.dependencies || def.requires || [];
      deps.forEach(dep => { if (dependentsMap.has(dep)) dependentsMap.get(dep).push(name); });
    });
    registry.forEach((def, name) => {
      const deps = def.dependencies || def.requires || [];
      const missing = deps.filter(dep => !activeNames.has(dep));
      if (missing.length > 0) missingDependencies.push(Object.freeze({ plugin: name, missing: Object.freeze([...missing]) }));
      report[name] = Object.freeze({ active: activeNames.has(name), dependencies: Object.freeze([...deps]), satisfied: missing.length === 0, missing: Object.freeze([...missing]), dependents: Object.freeze(dependentsMap.get(name) || []) });
    });
    const circular = this.circularDetection();
    return Object.freeze({ valid: missingDependencies.length === 0 && circular.length === 0, plugins: Object.freeze(report), missingDependencies: Object.freeze(missingDependencies), circularDependencies: circular });
  }
}

// ==========================================
// LAYER 13: Plugins & Diagnostics
// ==========================================
class PluginManager {
  constructor(api) {
    this.api = api; this.plugins = []; this.activePlugins = new Map();
  }
  initialize() {
    this.api.internal.events.on(EVENTS.DOM_CHANGED, (api, payload) => {
      if (payload.structureChanged) this.schedulePluginRefresh();
    });
  }
  schedulePluginRefresh() {
    const state = this.api.internal.state;
    if (state.timers.pluginRefreshRaf) return;
    
    const refreshFn = () => {
      try {
        state.timers.pluginRefreshRaf = null;
        if (!state.flags.destroyed) this.refreshPlugins();
      } finally {
        state.flags.pluginRefreshUsingRAF = false;
      }
    };

    if (typeof requestAnimationFrame === 'function') {
      state.flags.pluginRefreshUsingRAF = true;
      state.timers.pluginRefreshRaf = requestAnimationFrame(refreshFn);
    } else {
      state.flags.pluginRefreshUsingRAF = false;
      state.timers.pluginRefreshRaf = setTimeout(refreshFn, 16);
    }
  }
  refreshPlugins() {
    this.plugins.forEach(p => { 
      try {
        if (p.instance && typeof p.instance.refresh === 'function') {
          p.instance.refresh(this.api); 
        } else {
          if (p.instance?.destroy) p.instance.destroy(this.api);
          const def = Object.values(BuiltInPlugins).find(d => d.name === p.name);
          if (def) p.instance = def.init(this.api);
        }
      } catch (err) {
        this.api.internal.diagnostics._recordPluginError(p.name, err);
      }
    });
    this.activePlugins.forEach((p, name) => { 
      try {
        if (p.instance && typeof p.instance.refresh === 'function') {
          p.instance.refresh(this.api); 
        } else {
          if (p.instance?.destroy) p.instance.destroy(this.api);
          const def = CarouselRegistry._pluginRegistry.get(name);
          if (def) p.instance = def.init(this.api);
        }
      } catch (err) {
        this.api.internal.diagnostics._recordPluginError(name, err);
      }
    });
  }
  initPlugins() {
    this.plugins.forEach(p => p.instance && p.instance.destroy && p.instance.destroy(this.api));
    this.plugins = [];
    Object.values(BuiltInPlugins).forEach(def => {
      try { const instance = def.init(this.api); this.plugins.push({ name: def.name, instance }); this.api.internal.diagnostics._pluginErrorTracker.delete(def.name); } 
      catch (err) { this.api.internal.diagnostics._recordPluginError(def.name, err); }
    });
  }
  initEnterprisePlugins() {
    Array.from(CarouselRegistry._pluginRegistry.keys()).forEach(name => this.enablePlugin(name));
  }
  enablePlugin(name) {
    if (this.activePlugins.has(name)) return;
    const pluginDef = CarouselRegistry._pluginRegistry.get(name);
    if (!pluginDef) return;

    const deps = pluginDef.dependencies || pluginDef.requires || [];
    deps.forEach(dep => this.enablePlugin(dep)); 

    const depCheck = this.api.internal.dependencies.validateDependencies(name);
    if (!depCheck.valid) {
      this.api.internal.diagnostics._recordPluginError(name, new Error('Dependency validation failed'));
      return;
    }

    try { const instance = pluginDef.init(this.api); this.activePlugins.set(name, { def: pluginDef, instance }); this.api.internal.events.emit(EVENTS.PLUGIN_ENABLED, { name }); } catch (err) { this.api.internal.diagnostics._recordPluginError(name, err); }
  }
  disablePlugin(name) {
    const active = this.activePlugins.get(name);
    if (active) { if (active.def.destroy) active.def.destroy(this.api, active.instance); this.activePlugins.delete(name); this.api.internal.events.emit(EVENTS.PLUGIN_DISABLED, { name }); }
  }
  destroyAll() {
    this.plugins.forEach(p => p.instance && p.instance.destroy && p.instance.destroy(this.api));
    this.plugins = [];
    [...this.activePlugins.keys()].forEach(name => this.disablePlugin(name));
  }
}

class Diagnostics {
  constructor(api) { this.api = api; this._pluginErrorTracker = new Map(); }
  _recordPluginError(name, err) {
    const c = this._pluginErrorTracker.get(name) || { count: 0, lastError: null };
    this._pluginErrorTracker.set(name, { count: c.count + 1, lastError: err ? (err.message || String(err)) : 'Unknown error' });
  }
  health() {
    const state = this.api.internal.state;
    if (state.flags.destroyed) return deepFreeze({ status: 'destroyed', issues: ['Instance is destroyed'], timestamp: Date.now() });
    const issues = [];
    if (!this.api.root) issues.push('Root element missing');
    if (!this.api.track) issues.push('Track container missing');
    if (isNaN(state.position.current)) issues.push('currentPos is NaN');
    if (state.flags.batchDepth > 0) issues.push(`Unresolved dynamic batch operations`);
    if (state.index.current < 0) issues.push('Current index below zero');
    if (state.group.current < 0) issues.push('Current group below zero');
    return deepFreeze({ status: issues.length ? 'degraded' : 'healthy', issues, reducedMotion: this.api.reducedMotion, timestamp: Date.now() });
  }
  performanceStats() {
    const state = this.api.internal.state;
    return deepFreeze({
      layoutRecalculations: state.stats.layoutCalcs, lastLayoutDurationMs: parseFloat(state.stats.lastLayoutTime.toFixed(2)), renderTicks: state.stats.renderTicks,
      domNodeCount: this.api.track ? this.api.track.children.length : 0, clonedNodes: this.api.internal.renderer.cloneCount(),
      originalSlides: state.dom.originalSlides.length, cloneDiagnostics: this.api.internal.renderer.cloneDiagnostics(),
      activeObservers: state.flags.isFrozen ? 0 : ((this.api.internal.observers.resizeObserver ? 1 : 0) + (this.api.internal.observers.mutationObserver ? 1 : 0) + (this.api.internal.observers.visibilityObserver ? 1 : 0))
    });
  }
  warnings() {
    const list = []; const state = this.api.internal.state;
    if (state.flags.destroyed) { list.push('Instance is destroyed.'); return deepFreeze(list); }
    if (this.api.options.loop && state.dom.originalSlides.length <= 1) list.push('Loop mode is enabled but requires at least 2 slides.');
    if (this.api.options.vertical && this.api.options.loop && this.api.root.classList.contains('wheel')) list.push('Wheel navigation in vertical loop mode may trap page scrolling.');
    if (state.dom.originalSlides.length === 0) list.push('Carousel track contains no original slides.');
    const uptimeSecs = Math.max(1, (Environment.now() - state.stats.initTime) / 1000);
    if (state.stats.layoutCalcs > 50 && (state.stats.layoutCalcs / uptimeSecs) > 10) list.push(`High layout recalculation rate (${(state.stats.layoutCalcs / uptimeSecs).toFixed(1)}/sec). Check for frequent DOM mutations.`);
    const depCheck = this.api.internal.dependencies.validateDependencies();
    if (!depCheck.valid) { depCheck.missing.forEach(m => list.push(`Missing plugin dependency: "${m.missingDependency}" required by "${m.plugin}".`)); depCheck.circular.forEach(c => list.push(`Circular plugin dependency cycle: ${c.join(' -> ')}.`)); }
    return deepFreeze(list);
  }
  compatibilityReport() {
    const hasDOM = Environment.hasDOM();
    const requiredFeatures = { ResizeObserver: hasDOM && typeof window.ResizeObserver !== 'undefined', IntersectionObserver: hasDOM && typeof window.IntersectionObserver !== 'undefined', MutationObserver: hasDOM && typeof window.MutationObserver !== 'undefined', PointerEvents: hasDOM && typeof window.PointerEvent !== 'undefined', requestAnimationFrame: hasDOM && typeof window.requestAnimationFrame !== 'undefined', performanceNow: typeof performance !== 'undefined' && typeof performance.now === 'function' };
    const degradedFeatures = [];
    if (!requiredFeatures.ResizeObserver) degradedFeatures.push('ResizeObserver missing'); if (!requiredFeatures.IntersectionObserver) degradedFeatures.push('IntersectionObserver missing'); if (!requiredFeatures.MutationObserver) degradedFeatures.push('MutationObserver missing'); if (!requiredFeatures.requestAnimationFrame) degradedFeatures.push('requestAnimationFrame missing');
    return deepFreeze({ engine: ydCarousel.ENGINE, version: ydCarousel.VERSION, environment: hasDOM ? 'browser' : 'non-browser/ssr', fullyCompatible: Object.values(requiredFeatures).every(Boolean), requiredFeatures: Object.freeze(requiredFeatures), optionalFeatures: Object.freeze({ matchMedia: hasDOM && typeof window.matchMedia !== 'undefined', inert: hasDOM && ('inert' in document.createElement('div')) }), degradedFeatures: Object.freeze(degradedFeatures) });
  }
  pluginHealth() {
    const registry = CarouselRegistry._pluginRegistry; const activeNames = new Set(Array.from(this.api.internal.plugins.activePlugins.keys())); const health = {};
    registry.forEach((def, name) => { const errInfo = this._pluginErrorTracker.get(name) || { count: 0, lastError: null }; health[name] = Object.freeze({ type: 'enterprise', active: activeNames.has(name), errors: errInfo.count, lastError: errInfo.lastError }); });
    this.api.internal.plugins.plugins.forEach(p => { if (p.name && !health[p.name]) { const errInfo = this._pluginErrorTracker.get(p.name) || { count: 0, lastError: null }; health[p.name] = Object.freeze({ type: 'core', active: true, errors: errInfo.count, lastError: errInfo.lastError }); } });
    this._pluginErrorTracker.forEach((errInfo, name) => { if (!health[name]) health[name] = Object.freeze({ type: 'core', active: false, errors: errInfo.count, lastError: errInfo.lastError }); });
    return deepFreeze(health);
  }
  xray() {
    const state = this.api.internal.state;
    return deepFreeze({
      core: { version: this.api.version(), build: { engine: ydCarousel.ENGINE, version: this.api.version(), build: 'enterprise-production', released: '2026-08' }, plugins: Object.freeze([...this.api.internal.plugins.plugins.map(p=>p.name||'anonymous'), ...Array.from(this.api.internal.plugins.activePlugins.keys())]), events: Object.freeze(this.api.internal.events), capabilities: this.api.capabilities(), runtimeCapabilities: this.api.runtimeCapabilities(), state: this.api.state() },
      inspection: { slidesInView: Object.freeze([...state.dom.visibleSlides].sort((a,b)=>a-b)), slidesNotInView: Object.freeze(Array.from({length: state.dom.originalSlides.length}, (_, i) => i).filter(i => !state.dom.visibleSlides.has(i))), activeSlide: state.index.current },
      drag: { active: state.drag.active, startIndex: state.drag.startIndex, currentIndex: state.drag.currentIndex },
      health: this.health(), performance: this.performanceStats(), warnings: this.warnings(), compatibility: this.compatibilityReport(),
      plugins: { totalRegistered: CarouselRegistry._pluginRegistry.size, totalActive: this.api.internal.plugins.activePlugins.size + this.api.internal.plugins.plugins.length, registeredPlugins: Object.freeze(Array.from(CarouselRegistry._pluginRegistry.keys())), activeEnterprise: Object.freeze(Array.from(this.api.internal.plugins.activePlugins.keys())), activeCore: Object.freeze(this.api.internal.plugins.plugins.map(p=>p.name||'anonymous')) },
      pluginHealth: this.pluginHealth(), dependencies: this.api.internal.dependencies.dependencyReport(),
      events: Object.freeze({ stats: this.api.internal.events.eventStats(), totalListeners: this.api.internal.events.listenerCount() }),
      metrics: Object.freeze({ viewportSize: state.metrics.viewportSize, trackSize: state.metrics.trackSize, realTrackSize: state.metrics.realTrackSize, prependOffset: state.metrics.prependOffset, gap: state.metrics.gap, averageSlideSize: state.metrics.averageSlideSize, slideSizes: Object.freeze([...state.metrics.slideSizes]), slideOffsets: Object.freeze([...state.metrics.slideOffsets]), slideSnaps: Object.freeze([...state.metrics.slideSnaps]), groupSnaps: Object.freeze([...state.metrics.groupSnaps]), snapPoints: Object.freeze([...state.metrics.snapPoints]) }),
      config: Object.freeze({ loop: this.api.options.loop, dragFree: this.api.options.dragFree, alignCenter: this.api.options.alignCenter, alignEnd: this.api.options.alignEnd, keyboard: this.api.options.keyboard, autoplay: this.api.options.autoplay, direction: this.api.options.direction, vertical: this.api.options.vertical, autoHeight: this.api.options.autoHeight, autoVisibility: this.api.options.autoVisibility, focusOnChange: this.api.options.focusOnChange, reducedMotion: this.api.reducedMotion, duration: this.api.options.duration, friction: this.api.options.friction, delay: this.api.options.delay, dragThreshold: this.api.options.dragThreshold, velocityThreshold: this.api.options.velocityThreshold, dragInertia: this.api.options.dragInertia, slideSnap: this.api.options.slideSnap, groupSnap: this.api.options.groupSnap })
    });
  }
}

// ==========================================
// BUILT-IN PLUGINS (Factory Pattern)
// ==========================================
const BuiltInPlugins = {
  Controls: {
    name: 'controls',
    init: (api) => {
      const p = api.root.querySelector('.yd_prev'); const n = api.root.querySelector('.yd_next');
      const hP = () => { if(!api.internal.state.flags.isPaused && !api.internal.state.flags.isFrozen) api.internal.navigation.scrollPrev(); };
      const hN = () => { if(!api.internal.state.flags.isPaused && !api.internal.state.flags.isFrozen) api.internal.navigation.scrollNext(); };
      if (p) { p.addEventListener('click', hP); p.setAttribute('aria-controls', api.track.id); }
      if (n) { n.addEventListener('click', hN); n.setAttribute('aria-controls', api.track.id); }
      return { destroy: () => { if(p) p.removeEventListener('click', hP); if(n) n.removeEventListener('click', hN); } };
    }
  },
  Dots: {
    name: 'dots',
    init: (api) => {
      const c = api.root.querySelector('.yd_dots'); if (!c) return { destroy: ()=>{} };
      let t = c.querySelector('.yd_dot'); 
      const originalTemplate = t ? t.cloneNode(true) : null;
      c.setAttribute('role', 'tablist'); c.setAttribute('aria-orientation', api.options.vertical ? 'vertical' : 'horizontal');
      let lastTotal = 0;
      const build = () => {
        c.innerHTML = '';
        const total = api.options.slideSnap ? api.internal.state.metrics.slideSnaps.length : api.internal.state.dom.logicalGroups.length;
        new Array(total).fill(0).forEach((_, i) => {
          let d = originalTemplate ? originalTemplate.cloneNode(true) : document.createElement('button'); if(!originalTemplate) d.className='yd_dot';
          d.setAttribute('role','tab'); d.setAttribute('aria-controls', api.track.id); d.setAttribute('aria-label', `Go ${i+1}`);
          d.addEventListener('click', () => { if(api.internal.state.flags.isPaused||api.internal.state.flags.isFrozen) return; api.options.slideSnap ? api.internal.navigation.goToSlide(i) : api.internal.navigation.goToGroup(i); });
          c.appendChild(d);
        });
      };
      const uD = () => {
        const aI = api.options.slideSnap ? api.internal.state.index.current : api.internal.state.group.current;
        Array.from(c.children).forEach((d, i) => { const a = i === aI; d.classList.toggle('active', a); d.setAttribute('aria-selected', a); d.setAttribute('tabindex', a?'0':'-1'); });
      };
      api.internal.events.on(EVENTS.NAV_AFTER, uD); api.internal.events.on(EVENTS.GROUP_ACTIVE_CHANGE, uD); api.internal.events.on(EVENTS.PREVIEW_UPDATE, uD); 
      lastTotal = api.options.slideSnap ? api.internal.state.metrics.slideSnaps.length : api.internal.state.dom.logicalGroups.length;
      build(); uD();
      return { 
        destroy: () => { api.internal.events.off(EVENTS.NAV_AFTER, uD); api.internal.events.off(EVENTS.GROUP_ACTIVE_CHANGE, uD); api.internal.events.off(EVENTS.PREVIEW_UPDATE, uD); },
        refresh: () => { 
          const total = api.options.slideSnap ? api.internal.state.metrics.slideSnaps.length : api.internal.state.dom.logicalGroups.length;
          if (total !== lastTotal) {
            build();
            lastTotal = total;
          }
          uD(); 
        }
      };
    }
  },
  Counter: {
    name: 'counter',
    init: (api) => {
      const c = api.root.querySelector('.yd_counter'); if (!c) return { destroy: ()=>{} };
      const cu = c.querySelector('.yd_current'), t = c.querySelector('.yd_total');
      const uC = (a, p) => {
        const cur = a.options.slideSnap ? Math.min((p.previewIndex!==undefined?p.previewIndex:p.currentIndex)+1, a.internal.state.dom.originalSlides.length) : (p.previewGroup!==undefined?p.previewGroup:p.currentGroup)+1;
        const tot = a.options.slideSnap ? a.internal.state.dom.originalSlides.length : a.internal.state.dom.logicalGroups.length;
        if(cu&&t) { cu.textContent=cur; t.textContent=tot; } else c.textContent=`${cur} / ${tot}`;
      };
      api.internal.events.on(EVENTS.NAV_AFTER, uC); api.internal.events.on(EVENTS.PREVIEW_UPDATE, uC); uC(api, api.internal.events.getEventPayload());
      return { 
        destroy: () => { api.internal.events.off(EVENTS.NAV_AFTER, uC); api.internal.events.off(EVENTS.PREVIEW_UPDATE, uC); },
        refresh: () => { uC(api, api.internal.events.getEventPayload()); }
      };
    }
  },
  Scrollbar: {
    name: 'scrollbar',
    init: (api) => {
      const s = api.root.querySelector('.yd_scrollbar'); if (!s) return { destroy: ()=>{} };
      const pD = s.style.display;
      if (api.options.loop) { s.style.display = 'none'; return { destroy: () => { s.style.display = pD; } }; }
      let th = s.querySelector('.yd_scrollbar-thumb'); if(!th){ th = document.createElement('div'); th.className = 'yd_scrollbar-thumb'; s.appendChild(th); }
      const uS = () => {
        if(api.internal.state.metrics.realTrackSize <= api.internal.state.metrics.viewportSize){ s.classList.add('disabled'); th.style.transform='translate3d(0,0,0)'; }
        else { s.classList.remove('disabled'); const r=api.internal.state.metrics.viewportSize/(api.internal.state.metrics.realTrackSize||1); const p=`${Math.max(10, Math.min(100, r*100))}%`; if(api.options.vertical) th.style.height=p; else th.style.width=p; }
      };
      const uP = (a) => { if(s.classList.contains('disabled')) return; const m = a.options.vertical ? s.offsetHeight-th.offsetHeight : s.offsetWidth-th.offsetWidth; let v = a.internal.renderer.getScrollProgress(); if(a.isRTL && !a.options.vertical) v=1-v; if(a.options.vertical) th.style.transform=`translate3d(0,${v*m}px,0)`; else th.style.transform=`translate3d(${v*m}px,0,0)`; };
      api.internal.events.on(EVENTS.RESIZE, uS); api.internal.events.on(EVENTS.SCROLL, uP); uS(); uP(api);
      return { 
        destroy: () => { s.style.display = pD; api.internal.events.off(EVENTS.RESIZE, uS); api.internal.events.off(EVENTS.SCROLL, uP); },
        refresh: () => { uS(); uP(api); }
      };
    }
  },
  Progress: {
    name: 'progress',
    init: (api) => {
      const p = api.root.querySelector('.yd_progress'); if (!p) return { destroy: ()=>{} };
      const uPr = () => { p.style.setProperty('--progress', `${api.internal.renderer.getVisualProgress() * 100}%`); };
      api.internal.events.on(EVENTS.SCROLL, uPr); uPr();
      return { 
        destroy: () => api.internal.events.off(EVENTS.SCROLL, uPr),
        refresh: () => { uPr(); }
      };
    }
  },
  Wheel: {
    name: 'wheel',
    init: (api) => {
      if(!api.root.classList.contains('wheel')) return { destroy: ()=>{} };
      let acc=0, tmr; const t = parseInt(api.root.dataset.wheelThreshold)||60;
      const oW = (e) => {
        if(api.internal.state.flags.isPaused || api.internal.state.flags.isFrozen) return;
        if(!api.options.vertical && Math.abs(e.deltaY)>Math.abs(e.deltaX)) return;
        const d = api.options.vertical ? e.deltaY : (e.deltaX||e.deltaY);
        e.preventDefault(); acc+=d;
        if(Math.abs(acc)>=t){ let w=acc>0; if(api.isRTL && !api.options.vertical) w=!w; w?api.internal.navigation.scrollNext():api.internal.navigation.scrollPrev(); acc=0; }
        clearTimeout(tmr); tmr = setTimeout(()=>acc=0, 100);
      };
      api.root.addEventListener('wheel', oW, {passive:false});
      return { destroy: () => { clearTimeout(tmr); api.root.removeEventListener('wheel', oW); } };
    }
  },
  Hash: {
    name: 'hash',
    init: (api) => {
      if(!api.root.classList.contains('hash')) return { destroy: ()=>{} };
      let isSync = false;
      const oH = () => { if(isSync) return; const h = window.location.hash.replace('#',''); const idx = api.internal.state.dom.originalSlides.findIndex(s=>s.dataset.hash===h); if(idx>-1 && idx!==api.internal.state.index.current){ isSync=true; api.internal.navigation.goToSlide(idx); isSync=false; } };
      const oS = (a,p) => { if(isSync) return; const h=a.internal.state.dom.originalSlides[p.currentIndex]?.dataset.hash; if(h){ isSync=true; history.replaceState(null,null,`#${h}`); isSync=false; } };
      window.addEventListener('hashchange', oH); api.internal.events.on(EVENTS.NAV_AFTER, oS); setTimeout(oH, 0);
      return { destroy: () => { window.removeEventListener('hashchange', oH); api.internal.events.off(EVENTS.NAV_AFTER, oS); } };
    }
  },
  Autoplay: {
    name: 'autoplay',
    init: (api) => {
      if (!api.options.autoplay) return { destroy: ()=>{} };
      let playTimer, animRaf, isPaused = false, hasStarted = false, permanentlyStopped = false, startTime = 0;
      let direction = api.root.dataset.autoplayDirection === 'backward' ? -1 : 1;
      const apProgressEl = api.root.querySelector('.yd_autoplay-progress');
      if (apProgressEl && !apProgressEl.querySelector('.yd_autoplay-progress-fill')) { const f = document.createElement('div'); f.className = 'yd_autoplay-progress-fill'; apProgressEl.appendChild(f); apProgressEl.style.setProperty('--ap-progress', `0%`); }
      const resetVisual = () => { if (apProgressEl) apProgressEl.style.setProperty('--ap-progress', `0%`); };
      const loopProgress = () => {
        if (isPaused || api.internal.state.flags.isPaused || api.internal.state.flags.isFrozen) return;
        const pct = Math.min(100, ((Environment.now() - startTime) / api.options.delay) * 100);
        if (apProgressEl) apProgressEl.style.setProperty('--ap-progress', `${pct}%`);
        if (pct < 100 && typeof requestAnimationFrame === 'function') animRaf = requestAnimationFrame(loopProgress);
      };
      const stopPermanent = () => { if (permanentlyStopped) return; permanentlyStopped = true; clearTimeout(playTimer); if (animRaf) cancelAnimationFrame(animRaf); hasStarted = isPaused = false; api.internal.events.emit(EVENTS.AUTOPLAY_STOP); };
      const pauseTimer = () => { clearTimeout(playTimer); if (animRaf) cancelAnimationFrame(animRaf); };
      const play = () => {
        if (permanentlyStopped || api.internal.state.flags.isPaused || api.internal.state.flags.isFrozen) return;
        pauseTimer(); if (!hasStarted) { hasStarted = true; api.internal.events.emit(EVENTS.AUTOPLAY_START); } else if (isPaused) { isPaused = false; api.internal.events.emit(EVENTS.AUTOPLAY_RESUME); }
        
        if (!api.internal.state.metrics.slideSnaps.length) {
          playTimer = setTimeout(() => play(), 100);
          return;
        }

        if (!(direction === 1 ? api.internal.navigation.canScrollNext() : api.internal.navigation.canScrollPrev())) { 
          if (apProgressEl) apProgressEl.style.setProperty('--ap-progress', `100%`); 
          stopPermanent(); 
          return; 
        }

        startTime = Environment.now(); 
        loopProgress();
        playTimer = setTimeout(() => { direction === 1 ? api.internal.navigation.scrollNext() : api.internal.navigation.scrollPrev(); }, api.options.delay);
      };
      const stop = () => { pauseTimer(); if (hasStarted && !isPaused && !permanentlyStopped) { isPaused = true; api.internal.events.emit(EVENTS.AUTOPLAY_PAUSE); } };
      api.autoplayApi = { play: () => { permanentlyStopped = isPaused = false; play(); }, pause: () => { if (hasStarted && !isPaused && !permanentlyStopped) stop(); }, stop: stopPermanent, reset: () => { permanentlyStopped = isPaused = false; if (!hasStarted) play(); }, setDirection: (dir) => { direction = (dir === 'backward' || dir === -1) ? -1 : 1; resetVisual(); if (permanentlyStopped) { permanentlyStopped = isPaused = false; play(); } else if (hasStarted && !isPaused) play(); }, getDirection: () => direction === 1 ? 'forward' : 'backward', getState: () => Object.freeze({ started: hasStarted, paused: isPaused, stopped: permanentlyStopped, direction: direction === 1 ? 'forward' : 'backward' }) };
      api.resetAutoplay = api.autoplayApi.reset;

      const onSettle = () => { if (hasStarted && !isPaused && !permanentlyStopped) play(); };
      const onVisChange = () => document.hidden ? stop() : play();
      const onFocusIn = stop, onFocusOut = play;
      const onBeforeSelect = () => { pauseTimer(); resetVisual(); };
      const onDragStart = () => { stop(); resetVisual(); };
      const onDragEnd = () => { if (hasStarted && isPaused && !permanentlyStopped) { isPaused = false; api.internal.events.emit(EVENTS.AUTOPLAY_RESUME); if (api.internal.state.flags.isSettled) play(); } };
      const onApiPause = stop;
      const onApiResume = () => { if (!permanentlyStopped && hasStarted) { isPaused = false; if (api.internal.state.flags.isSettled) play(); } };

      api.internal.events.on(EVENTS.NAV_BEFORE, onBeforeSelect).on(EVENTS.DRAG_START, onDragStart).on(EVENTS.DRAG_END, onDragEnd).on(EVENTS.SETTLE, onSettle).on(EVENTS.PAUSE, onApiPause).on(EVENTS.RESUME, onApiResume).on(EVENTS.FREEZE, onApiPause).on(EVENTS.UNFREEZE, onApiResume);
      if (api.root.classList.contains('pause-hover')) { api.root.addEventListener('mouseenter', stop); api.root.addEventListener('mouseleave', play); }
      if (Environment.hasDOM()) document.addEventListener('visibilitychange', onVisChange);
      api.root.addEventListener('focusin', onFocusIn); api.root.addEventListener('focusout', onFocusOut);
      if (typeof requestAnimationFrame === 'function') requestAnimationFrame(play);
      return { destroy: () => {
        stop(); if (!permanentlyStopped) api.internal.events.emit(EVENTS.AUTOPLAY_STOP);
        delete api.autoplayApi; delete api.resetAutoplay;
        api.internal.events.off(EVENTS.NAV_BEFORE, onBeforeSelect).off(EVENTS.DRAG_START, onDragStart).off(EVENTS.DRAG_END, onDragEnd).off(EVENTS.SETTLE, onSettle).off(EVENTS.PAUSE, onApiPause).off(EVENTS.RESUME, onApiResume).off(EVENTS.FREEZE, onApiPause).off(EVENTS.UNFREEZE, onApiResume);
        api.root.removeEventListener('mouseenter', stop); api.root.removeEventListener('mouseleave', play);
        if (Environment.hasDOM()) document.removeEventListener('visibilitychange', onVisChange);
        api.root.removeEventListener('focusin', onFocusIn); api.root.removeEventListener('focusout', onFocusOut);
      }};
    }
  }
};

// ==========================================
// MAIN FACADE: ydCarousel
// ==========================================
class ydCarousel {
  static VERSION = '3.0.0-LTS';
  static ENGINE = 'ydCarousel-Enterprise';
  static EVENTS = EVENTS;
  static SNAP_EPSILON = 0.5;
  static _autoInitObserver = null;

  static startAutoInit() {
    if (!Environment.hasDOM()) return;
    const initAll = () => {
      document.querySelectorAll('.yd_carousel:not(.yd_carousel-ready)').forEach(el => {
        if (!el.__ydCarousel) {
          try { new ydCarousel(el); } catch (err) { console.error('[ydCarousel] Auto-init failed:', err); }
        }
      });
    };
    initAll();
    if (!this._autoInitObserver && typeof MutationObserver !== 'undefined') {
      let timeout;
      this._autoInitObserver = new MutationObserver(() => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
          CarouselRegistry._instances.forEach(api => { if (!document.contains(api.root)) api.destroy(); });
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
    if (!this.track) throw new Error('[ydCarousel] Missing .yd_container element');
    this.root.__ydCarousel = this;

    const rM = this.root.dataset.reducedMotion || 'auto';
    this.reducedMotion = rM === 'true' ? true : (rM === 'false' ? false : (Environment.hasDOM() && window.matchMedia('(prefers-reduced-motion: reduce)').matches));
    
    this.options = {
      loop: this.root.classList.contains('loop'), dragFree: this.root.classList.contains('drag-free'),
      alignCenter: this.root.classList.contains('align-center'), alignEnd: this.root.classList.contains('align-end'),
      keyboard: this.root.classList.contains('keyboard'), autoplay: !this.reducedMotion && this.root.classList.contains('autoplay'),
      direction: this.root.classList.contains('rtl') ? 'rtl' : 'ltr', vertical: this.root.classList.contains('vertical'),
      autoHeight: this.root.classList.contains('auto-height'), autoVisibility: this.root.dataset.autoVisibility !== 'false', 
      focusOnChange: this.root.classList.contains('focus-on-change') || this.root.dataset.focusOnChange === 'true',
      duration: this.reducedMotion ? 1 : (parseFloat(this.root.dataset.duration) || 0.1),
      friction: this.reducedMotion ? 1 : (parseFloat(this.root.dataset.friction) || 0.92),
      delay: parseInt(this.root.dataset.delay) || 4000, dragThreshold: parseInt(this.root.dataset.dragThreshold) || 5,
      velocityThreshold: parseFloat(this.root.dataset.velocityThreshold) || 0.5, dragInertia: this.reducedMotion ? 0 : (parseFloat(this.root.dataset.dragInertia) || 40),
      slideSnap: this.root.classList.contains('slide-snap'), groupSnap: this.root.classList.contains('group-snap')
    };
    this.isRTL = this.options.direction === 'rtl';
    this.dir = this.isRTL ? -1 : 1;
    if (this.options.groupSnap) this.options.slideSnap = false;
    if (!this.options.slideSnap && !this.options.groupSnap) this.options.slideSnap = true;

    // Instantiate Architecture Layers into a Sandbox
    const state = new CarouselState();
    const events = new EventBus(this);
    const lifecycle = new Lifecycle(this);
    const measurements = new MeasurementEngine(this);
    const physics = new PhysicsEngine(this);
    const renderer = this.options.loop ? new CloneLoopRenderer(this) : new StandardRenderer(this);
    const drag = new DragModule(this);
    const keyboard = new KeyboardModule(this);
    const navigation = new NavigationEngine(this);
    const observers = new ObserverManager(this);
    const dynamic = new DynamicContentManager(this);
    const accessibility = new AccessibilityManager(this);
    const plugins = new PluginManager(this);
    const diagnostics = new Diagnostics(this);
    const modules = new ModuleManager(this);
    const dependencies = new DependencyManager(this);

    CarouselRegistry.validateRenderer(renderer);

    this.internal = Object.freeze({
      state, events, lifecycle, measurements, physics, renderer, drag, keyboard,
      navigation, observers, dynamic, accessibility, plugins, diagnostics, modules, dependencies
    });

    this.onActivate = () => { CarouselRegistry.activeCarousel = this; }; 
    this.onDeactivate = (e) => {
      if (e && e.type === 'focusout' && this.root.contains(e.relatedTarget)) return;
      if (CarouselRegistry.activeCarousel === this) {
        const fb = [...CarouselRegistry._instances].find(api => api !== this && !api.internal.state.flags.destroyed && api.options.keyboard);
        CarouselRegistry.activeCarousel = fb || null; 
      }
    };

    this.internal.lifecycle.init();
    
    // Bootstrapped safely inside clone boundaries if loop exists
    if (this.internal.renderer.isLoopActive() && this.internal.state.position.current === 0 && this.internal.state.metrics.slideSnaps.length > 0) {
      this.internal.state.position.current = this.internal.state.metrics.slideSnaps[0];
      this.internal.state.position.target = this.internal.state.metrics.slideSnaps[0];
    }
  }

  // Facade Public API
  get currentPos() { return this.internal.state.position.current; }
  get targetPos() { return this.internal.state.position.target; }
  get currentIndex() { return this.internal.state.index.current; }
  get currentGroup() { return this.internal.state.group.current; }
  
  pause() { this.internal.lifecycle.pause(); }
  resume() { this.internal.lifecycle.resume(); }
  freeze(m=true) { this.internal.lifecycle.freeze(m); }
  unfreeze(m=true) { this.internal.lifecycle.unfreeze(m); }
  destroy() { this.internal.lifecycle.destroy(); }
  
  goToSlide(i, imm=false, f=false) { this.internal.navigation.goToSlide(i, imm, f); }
  goToGroup(i, imm=false, f=false) { this.internal.navigation.goToGroup(i, imm, f); }
  scrollNext(f=false) { this.internal.navigation.scrollNext(f); }
  scrollPrev(f=false) { this.internal.navigation.scrollPrev(f); }
  scrollTo(i, imm=false) { this.internal.navigation.goToSlide(i, imm); }
  
  refresh(full=false) { if(this.internal.state.flags.destroyed) return; this.internal.measurements.updateMeasurements(); if(full) this.internal.plugins.initPlugins(); }
  addSlide(h) { this.internal.dynamic.addSlide(h); }
  removeSlide(i) { this.internal.dynamic.removeSlide(i); }
  removeAllSlides() { this.internal.dynamic.removeAllSlides(); }
  
  slideCount() { return this.internal.state.dom.originalSlides.length; }
  groupCount() { return this.internal.state.dom.logicalGroups.length; }
  datasetCount() { return this.internal.state.dom.originalSlides.length; }
  getSlide(i) { return this.internal.state.dom.originalSlides[i] || null; }
  activeSlide() { return this.internal.state.dom.originalSlides[this.internal.state.index.current] || null; }
  slidesInView() { return [...this.internal.state.dom.visibleSlides].sort((a,b)=>a-b); }
  
  on(e, cb) { return this.internal.events.on(e, cb); }
  off(e, cb) { return this.internal.events.off(e, cb); }
  once(e, cb) { return this.internal.events.once(e, cb); }
  
  getTransformValue() { return this.options.vertical ? -this.internal.state.position.current : -this.internal.state.position.current * this.dir; }
  isPaused() { return this.internal.state.flags.isPaused; }
  isFrozen() { return this.internal.state.flags.isFrozen; }
  isDragging() { return this.internal.state.flags.isDraggingActive; }
  isReady() { return this.root.classList.contains('yd_carousel-ready'); }
  isDestroyed() { return this.internal.state.flags.destroyed; }
  
  stateData() { return this.internal.events.getEventPayload(); }
  
  // Diagnostic Proxying
  selfTest() {
    const state = this.internal.state;
    return deepFreeze({
      initialized: this.isReady(),
      renderer: !!this.internal.renderer,
      slides: state.metrics.slideSnaps.length,
      groups: state.metrics.groupSnaps.length,
      currentPos: state.position.current,
      targetPos: state.position.target,
      hasKeyboard: this.options.keyboard,
      observers: {
        resize: !!this.internal.observers.resizeObserver,
        mutation: !!this.internal.observers.mutationObserver,
        visibility: !!this.internal.observers.visibilityObserver
      }
    });
  }
  health() { return this.internal.diagnostics.health(); }
  xray() { return this.internal.diagnostics.xray(); }
  compatibilityReport() { return this.internal.diagnostics.compatibilityReport(); }
  warnings() { return this.internal.diagnostics.warnings(); }
  performanceStats() { return this.internal.diagnostics.performanceStats(); }
  pluginHealth() { return this.internal.diagnostics.pluginHealth(); }
  dependencyReport() { return this.internal.dependencies.dependencyReport(); }
  capabilities() {
    return deepFreeze({
      loop: true, dragFree: true, rtl: true, direction: true, vertical: true, autoHeight: true, autoVisibility: true, dynamicApi: true,
      autoplay: true, autoplayApi: true, keyboard: true, wheel: true, hash: true, sync: true, creative: true, lazyLoad: true, accessibility: true, focusManagement: true,
      once: true, stateExportImport: true, reducedMotion: true, eventWildcards: true, eventStats: true, listenerCount: true, pauseResume: true, freezeUnfreeze: true,
      warnings: true, compatibilityReport: true, pluginHealth: true, debug: true, plugins: true, events: true, diagnostics: true, dependencies: true, snapshots: true, observers: true, registry: true 
    });
  }
  runtimeCapabilities() {
    return deepFreeze({
      loop: this.options.loop, dragFree: this.options.dragFree, rtl: this.isRTL, direction: this.options.direction, vertical: this.options.vertical,
      autoplay: this.options.autoplay, keyboard: this.options.keyboard, autoHeight: this.options.autoHeight, autoVisibility: this.options.autoVisibility, focusOnChange: this.options.focusOnChange,
      reducedMotion: this.reducedMotion, alignCenter: this.options.alignCenter, alignEnd: this.options.alignEnd, slideSnap: this.options.slideSnap, groupSnap: this.options.groupSnap
    });
  }
  version() { return ydCarousel.VERSION; }
  state() {
    const s = this.internal.state;
    return deepFreeze({
      version: this.version(), index: s.index.current, group: s.group.current, previousIndex: s.index.previous,
      position: s.position.current, target: s.position.target, velocity: s.physics.velocity, progress: this.internal.renderer.getScrollProgress(),
      visualProgress: this.internal.renderer.getVisualProgress(), dragging: s.flags.isDraggingActive, settled: s.flags.isSettled, looping: this.options.loop,
      rtl: this.isRTL, direction: this.options.direction, vertical: this.options.vertical, autoHeight: this.options.autoHeight, autoVisibility: this.options.autoVisibility,
      focusOnChange: this.options.focusOnChange, reducedMotion: this.reducedMotion, paused: s.flags.isPaused, frozen: s.flags.isFrozen, autoFrozen: s.flags.isAutoFrozen,
      manualFrozen: s.flags.manualFrozen, slideSnap: this.options.slideSnap, groupSnap: this.options.groupSnap
    });
  }
}

if (Environment.hasDOM()) document.addEventListener('DOMContentLoaded', () => ydCarousel.startAutoInit());
/**
 * ydCarousel 3.0 - MODULAR FRAMEWORK ARCHITECTURE (PRODUCTION LTS)
 * Fully annotated for file extraction based on the target folder tree.
 */

// ==========================================
// core/events.js START
// ==========================================
const EVENTS = Object.freeze({
  INIT: 'init', RESIZE: 'resize', DESTROY: 'destroy',
  PAUSE: 'pause', RESUME: 'resume', FREEZE: 'freeze', UNFREEZE: 'unfreeze',
  DRAG_START: 'drag:start', DRAG_MOVE: 'drag:move', DRAG_END: 'drag:end',
  SCROLL: 'scroll', SETTLE: 'settle', DOM_CHANGED: 'dom:changed',
  NAV_BEFORE: 'nav:before', NAV: 'nav', NAV_AFTER: 'nav:after',
  SELECT_BEFORE: 'select:before', SELECT: 'select', SELECT_AFTER: 'select:after',
  SLIDE_ACTIVE_CHANGE: 'slide:active', GROUP_ACTIVE_CHANGE: 'group:active',
  SNAP_CHANGE: 'snap:change', PREVIEW_UPDATE: 'preview:update', 
  SLIDE_ENTER: 'slide:enter', SLIDE_EXIT: 'slide:exit',
  LOOP_ENTER: 'loop:enter', LOOP_EXIT: 'loop:exit', LOOP_REPOSITION: 'loop:reposition',
  AUTOPLAY_START: 'autoplay:start', AUTOPLAY_PAUSE: 'autoplay:pause', AUTOPLAY_RESUME: 'autoplay:resume', AUTOPLAY_STOP: 'autoplay:stop',
  SYNC_START: 'sync:start', SYNC_UPDATE: 'sync:update', SYNC_STOP: 'sync:stop',
  DEBUG_OPEN: 'debug:open', DEBUG_CLOSE: 'debug:close',
  PLUGIN_ENABLED: 'plugin:enabled', PLUGIN_DISABLED: 'plugin:disabled'
});
// core/events.js END

// ==========================================
// core/constants.js START
// ==========================================
function deepFreeze(obj, visited = new WeakSet()) {
  if (!obj || typeof obj !== 'object' || visited.has(obj) || Object.isFrozen(obj)) return obj;
  visited.add(obj);
  Object.getOwnPropertyNames(obj).forEach(name => {
    const value = obj[name];
    if (value && typeof value === 'object') deepFreeze(value, visited);
  });
  return Object.freeze(obj);
}
// core/constants.js END

// ==========================================
// core/environment.js START
// ==========================================
class Environment {
  static hasDOM() { return typeof window !== 'undefined' && typeof document !== 'undefined'; }
  static now() { return typeof performance !== 'undefined' ? performance.now() : Date.now(); }
}
// core/environment.js END

// ==========================================
// core/registry.js START
// ==========================================
class CarouselRegistry {
  static renderers = new Map();
  static snaps = new Map();
  static inputs = new Map();
  static behaviors = new Map();
  static plugins = new Map();
  static MAX_LOOP_CLONES = 120;
  static activeCarousel = null; 
  static _keyboardInitialized = false; 
  static _keyboardUsers = 0; 
  static _instances = new Set(); 
  static _globalKeyDownHandler(e) {
    const active = CarouselRegistry.activeCarousel;
    if (active && active.options.keyboard) {
      active.internal.events.emit('internal:keydown', { originalEvent: e });
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
  static registerRenderer(def) { if (!def.name) throw new Error('[ydCarousel] Renderer must have a name'); this.renderers.set(def.name, def); }
  static registerSnap(def) { if (!def.name) throw new Error('[ydCarousel] SnapEngine must have a name'); this.snaps.set(def.name, def); }
  static registerInput(def) { if (!def.name) throw new Error('[ydCarousel] Input must have a name'); this.inputs.set(def.name, def); }
  static registerBehavior(def) { if (!def.name) throw new Error('[ydCarousel] Behavior must have a name'); this.behaviors.set(def.name, def); }
  static registerPlugin(def) { if (!def.name) throw new Error('[ydCarousel] Plugin must have a name'); this.plugins.set(def.name, def); }

  static validateRenderer(renderer) {
    const REQUIRED_RENDERER_METHODS = [
      'resolveTarget', 'handleReposition', 'normalizePosition', 'distanceToSnap',
      'getScrollProgress', 'getVisualProgress', 'getSlideProgress',
      'cloneCount', 'cloneDiagnostics', 'getVisualPrev', 'getVisualNext', 'normalizeIndex',
      'slideCount', 'getVisibleElement', 'supportsDynamicManipulation',
      'measureTrack', 'resolveHash', 'getHashByIndex'
    ];
    REQUIRED_RENDERER_METHODS.forEach(method => {
      if (typeof renderer[method] !== 'function') throw new Error(`Renderer missing: ${method}`);
    });
  }
}
// core/registry.js END

// ==========================================
// core/eventbus.js START
// ==========================================
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
    this._dispatch(event, payload);
  }
  // THE FIX: High-performance emit for RAF-bound events, bypassing payload generation
  emitFast(event, customData = null) {
    if (!this.api.internal) return;
    const state = this.api.internal.state;
    if (state.flags.destroyed && event !== EVENTS.DESTROY) return;
    this._eventStats[event] = (this._eventStats[event] || 0) + 1;
    this._dispatch(event, customData);
  }
  _dispatch(event, payload) {
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
      activeSnap: state.index.activeSnap,
      previewIndex: state.preview.index !== undefined ? state.preview.index : state.index.current,
      previewGroup: state.preview.group !== undefined ? state.preview.group : state.group.current,
      slideCount: this.api.internal.renderer.slideCount(),
      snapCount: this.api.internal.snapEngine.getSnapCount(),
      progress: this.api.internal.renderer.getScrollProgress(),
      visualProgress: this.api.internal.renderer.getVisualProgress(),
      isDragging: state.flags.isDraggingActive, isSettled: state.flags.isSettled,
      looping: this.api.options.loop,
      direction: state.physics.velocity > 0 ? 1 : (state.physics.velocity < 0 ? -1 : 0),
      paused: state.flags.isPaused, frozen: state.flags.isFrozen
    };
  }
}
// core/eventbus.js END

// ==========================================
// core/state.js START
// ==========================================
class CarouselState {
  constructor() {
    this.position = { current: 0, target: 0 };
    this.index = { current: 0, previous: 0, activeSnap: 0, previousSnap: 0 };
    this.group = { current: 0, previous: 0 };
    this.preview = { index: 0, group: 0 };
    this.physics = { velocity: 0, inertia: 0 };
    this.flags = {
      isPaused: false, isFrozen: false, isAutoFrozen: false, manualFrozen: false,
      isDraggingActive: false, isSettled: true, destroyed: false,
      _lastIntersectionState: true,
      isClickSuppressed: false, ignoreNextMutation: false, isDynamicRefreshing: false,
      _generatedRootId: false, _generatedTrackId: false, _keyboardRegistered: false, batchDepth: 0,
      layoutPending: false, mutationUsingRAF: false, extensionRefreshUsingRAF: false,
      _isReceivingSync: false 
    };
    this.drag = {
      active: false, startPointer: 0, startTargetPos: 0,
      startPos: 0, startCurrentPos: 0, lastPointerPos: 0, lastPointerTime: 0,
      activePointerId: undefined
    };
    this.metrics = {
      viewportSize: 0, trackSize: 0, realTrackSize: 0, prependOffset: 0, gap: 0,
      slidesPerView: 0, averageSlideSize: 0, maxScroll: 0,
      slideSizes: [], relativeOffsets: [], snapPoints: []
    };
    this.dom = { originalSlides: [], logicalGroups: [], visibleSlides: new Set(), _trackedActiveNode: null };
    this.timers = { rafId: null, mutationRaf: null, extensionRefreshRaf: null };
    this.stats = { renderTicks: 0, layoutCalcs: 0, lastLayoutTime: 0, initTime: Environment.now() };
  }
}
// core/state.js END

// ==========================================
// core/module-loader.js START
// ==========================================
class ModuleLoader {
  static resolveRenderer(api) {
    const explicitRenderer = api.root.getAttribute('data-renderer');
    if (explicitRenderer && CarouselRegistry.renderers.has(explicitRenderer)) {
      const RendererClass = CarouselRegistry.renderers.get(explicitRenderer)?.classRef;
      return new RendererClass(api);
    }
    const classList = api.root.classList;
    let selected = 'standard'; 
    for (const name of CarouselRegistry.renderers.keys()) {
      if (classList.contains(name)) selected = name;
    }

    const RendererClass = CarouselRegistry.renderers.get(selected)?.classRef;
    if (!RendererClass) throw new Error(`[ydCarousel] Renderer '${selected}' not registered.`);
    return new RendererClass(api);
  }
  static resolveSnapEngine(api) {
    const explicitSnap = api.root.getAttribute('data-snap');
    if (explicitSnap && CarouselRegistry.snaps.has(explicitSnap)) {
      const SnapClass = CarouselRegistry.snaps.get(explicitSnap)?.classRef;
      return new SnapClass(api);
    }
    const classList = api.root.classList;
    let selected = 'slide-snap';
    for (const name of CarouselRegistry.snaps.keys()) {
      if (classList.contains(name)) selected = name;
    }

    const SnapClass = CarouselRegistry.snaps.get(selected)?.classRef;
    if (!SnapClass) throw new Error(`[ydCarousel] SnapEngine '${selected}' not registered.`);
    return new SnapClass(api);
  }
}
// core/module-loader.js END

// ==========================================
// core/extension-manager.js START
// ==========================================
class ExtensionManager {
  constructor(api) {
    this.api = api; 
    this.extensions = new Map(); 
  }
  initAll() {
    this.api.internal.events.on(EVENTS.DOM_CHANGED, (api, payload) => {
      if (payload.structureChanged) this.scheduleRefresh();
    });
    const rootClasses = this.api.root.classList;
    CarouselRegistry.inputs.forEach((def, name) => {
      if ((name === 'drag' && !rootClasses.contains('no-drag')) || rootClasses.contains(name) || (name === 'keyboard' && this.api.options.keyboard)) {
        this.enable(CarouselRegistry.inputs, name, 'input');
      }
    });
    CarouselRegistry.behaviors.forEach((def, name) => {
      if (rootClasses.contains(name) || (name === 'autoplay' && this.api.options.autoplay)) {
        this.enable(CarouselRegistry.behaviors, name, 'behavior');
      }
    });
    CarouselRegistry.plugins.forEach((def, name) => {
      let autoDiscover = false;
      if (name === 'controls' && (this.api.root.querySelector('.yd_prev') || this.api.root.querySelector('.yd_next'))) autoDiscover = true;
      if (name === 'dots' && this.api.root.querySelector('.yd_dots')) autoDiscover = true;
      if (name === 'counter' && this.api.root.querySelector('.yd_counter')) autoDiscover = true;
      if (name === 'scrollbar' && this.api.root.querySelector('.yd_scrollbar')) autoDiscover = true;
      if (name === 'progress' && this.api.root.querySelector('.yd_progress')) autoDiscover = true;

      if (rootClasses.contains(name) || autoDiscover) {
        this.enable(CarouselRegistry.plugins, name, 'plugin');
      }
    });
  }
  on(extName, event, callback) {
    const ext = this.extensions.get(extName);
    if (ext && ext.listeners) ext.listeners.push({ event, callback });
    this.api.internal.events.on(event, callback);
  }
  off(extName, event, callback) {
    const ext = this.extensions.get(extName);
    if (ext && ext.listeners) ext.listeners = ext.listeners.filter(l => l.callback !== callback);
    this.api.internal.events.off(event, callback);
  }
  enable(registryMap, name, type) {
    if (this.extensions.has(name)) return;
    const def = registryMap.get(name);
    if (!def) return;

    const deps = def.dependencies || def.requires || [];
    deps.forEach(dep => {
      let depMap = CarouselRegistry.plugins.has(dep) ? CarouselRegistry.plugins : null;
      if (!depMap) depMap = CarouselRegistry.behaviors.has(dep) ? CarouselRegistry.behaviors : null;
      if (!depMap) depMap = CarouselRegistry.inputs.has(dep) ? CarouselRegistry.inputs : null;
      if (depMap) this.enable(depMap, dep, 'auto');
    }); 
    try { 
      const listeners = [];
      this.extensions.set(name, { def, instance: null, listeners, type });
      const instance = def.init(this.api); 
      const ext = this.extensions.get(name);
      if (ext) ext.instance = instance;
      this.api.internal.events.emit(EVENTS.PLUGIN_ENABLED, { name, type }); 
    } catch (err) { this.api.internal.diagnostics._recordPluginError(name, err); }
  }
  disable(name) {
    const ext = this.extensions.get(name);
    if (ext) { 
      if (ext.listeners) ext.listeners.forEach(l => this.api.internal.events.off(l.event, l.callback));
      try {
        if (ext.instance && typeof ext.instance.destroy === 'function') {
          ext.instance.destroy(); 
        }
      } catch(err) {
        this.api.internal.diagnostics._recordPluginError(name, err);
        console.error(`[ydCarousel] Plugin '${name}' threw error during destroy. Listeners forcibly detached.`, err);
      }
      this.extensions.delete(name); 
      this.api.internal.events.emit(EVENTS.PLUGIN_DISABLED, { name }); 
    }
  }
  scheduleRefresh() {
    const state = this.api.internal.state;
    if (state.timers.extensionRefreshRaf) return;

    const refreshFn = () => {
      try {
        state.timers.extensionRefreshRaf = null;
        if (!state.flags.destroyed) this.refreshAll();
      } finally {
        state.flags.extensionRefreshUsingRAF = false;
      }
    };
    if (typeof requestAnimationFrame === 'function') {
      state.flags.extensionRefreshUsingRAF = true;
      state.timers.extensionRefreshRaf = requestAnimationFrame(refreshFn);
    } else {
      state.flags.extensionRefreshUsingRAF = false;
      state.timers.extensionRefreshRaf = setTimeout(refreshFn, 16);
    }
  }
  refreshAll() {
    this.extensions.forEach((ext, name) => { 
      try {
        if (ext.instance && typeof ext.instance.refresh === 'function') {
          ext.instance.refresh(this.api); 
        } else {
          try {
            if (ext.instance && typeof ext.instance.destroy === 'function') {
              if (ext.listeners) ext.listeners.forEach(l => this.api.internal.events.off(l.event, l.callback));
              ext.instance.destroy();
            }
          } catch(err) {
            console.error(`[ydCarousel] Plugin '${name}' threw error during refresh teardown.`, err);
          }
          ext.listeners = [];
          ext.instance = ext.def.init(this.api);
        }
      } catch (err) {
        this.api.internal.diagnostics._recordPluginError(name, err);
      }
    });
  }
destroyAll() {
    // THE FIX: Clone keys to an array to safely iterate while the underlying Map is being mutated by disable()
    for (const name of [...this.extensions.keys()]) {
      this.disable(name);
    }
  }
}
// core/extension-manager.js END

// ==========================================
// core/module-manager.js START
// ==========================================
class ModuleManager {
  constructor(api) { this.api = api; }
  initAll() {
    this.api.internal.accessibility.setupAccessibility();
    this.api.internal.observers.setupObservers();
    this.api.internal.measurements.updateMeasurements();
    this.api.internal.extensions.initAll(); 

    if (!this.api.internal.state.flags.isSettled) {
      this.api.internal.physics.startPhysicsLoop();
    }
  }
  destroyAll() {
    this.api.internal.accessibility.destroy();
    this.api.internal.observers.destroy();
    this.api.internal.extensions.destroyAll();
    this.api.internal.renderer._purgeClones();
  }
}
// core/module-manager.js END

// ==========================================
// engine/lifecycle.js START
// ==========================================
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
    this.api.internal.events.emit('internal:abort-drag'); 
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
    if (state.timers.extensionRefreshRaf) { 
      if (state.flags.extensionRefreshUsingRAF) cancelAnimationFrame(state.timers.extensionRefreshRaf);
      else clearTimeout(state.timers.extensionRefreshRaf); 
      state.timers.extensionRefreshRaf = null; 
    }
    this.api.internal.events.emit('internal:abort-drag');
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
    if (state.timers.extensionRefreshRaf) { 
      if (state.flags.extensionRefreshUsingRAF) cancelAnimationFrame(state.timers.extensionRefreshRaf);
      else clearTimeout(state.timers.extensionRefreshRaf); 
    }
    state.timers.rafId = state.timers.mutationRaf = state.timers.extensionRefreshRaf = null;
    this.api.root.removeAttribute('data-direction');
    if (state.flags._generatedRootId) this.api.root.removeAttribute('id');
    if (state.flags._generatedTrackId) this.api.track.removeAttribute('id');
    
    if (this.api.root.dataset.syncRole === 'thumbnail') {
      this.api.track.removeAttribute('role');
      this.api.track.removeAttribute('aria-orientation');
    }

    this.api.internal.modules.destroyAll();
    this.api.root.classList.remove('yd_carousel-ready');
    this.api.track.style.transform = '';
    
    if (this.api.track) {
      this.api.track.querySelectorAll('[data-slide-index]').forEach(slide => {
        slide.classList.remove('active', 'prev', 'next', 'in-view', 'out-view');
        slide.removeAttribute('aria-current');
        slide.removeAttribute('aria-selected');
        slide.removeAttribute('aria-pressed');
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
// engine/lifecycle.js END

// ==========================================
// engine/measurements.js START
// ==========================================
class MeasurementEngine {
  constructor(api) { this.api = api; }
  getConfiguredSlidesPerView() {
    const match = (this.api.root.className + ' ' + (this.api.track ? this.api.track.className : '')).match(/\bslides-(\d+)\b/);
    return match ? parseInt(match[1], 10) : null;
  }
  updateMeasurements() {
    const state = this.api.internal.state;
    const perfStart = Environment.now();
    try {
      state.dom.visibleSlides.clear();
      this.api.internal.observers.suspendTrackObservers();
      this.api.internal.renderer._purgeClones(); 
      state.dom.originalSlides = Array.from(this.api.track.children).filter(el => !el.classList.contains('yd_virtual-slide'));

      if (state.flags.isDynamicRefreshing && state.dom._trackedActiveNode && state.dom.originalSlides.includes(state.dom._trackedActiveNode)) {
        state.index.current = state.dom.originalSlides.indexOf(state.dom._trackedActiveNode);
      }

      const slideCount = this.api.internal.renderer.slideCount();

      if (!state.dom.originalSlides.length && slideCount === 0) {
        state.metrics.snapPoints = state.metrics.slideSizes = state.metrics.relativeOffsets = [];
        state.dom.logicalGroups = []; state.metrics.maxScroll = state.index.current = state.group.current = state.index.activeSnap = state.position.current = state.position.target = 0;
        this.api.track.style.transform = '';
        const viewportEl = this.api.root.querySelector('.yd_viewport') || this.api.root;
        if (this.api.options.autoHeight && viewportEl) viewportEl.style.height = '';
        this.api.internal.observers.resumeTrackObservers();

        state.stats.layoutCalcs++;
        state.stats.lastLayoutTime = Environment.now() - perfStart;
        return;
      }
      state.dom.originalSlides.forEach((slide, idx) => slide.setAttribute('data-slide-index', idx));
      this.api.internal.renderer.measureTrack();
      state.metrics.trackSize = this.api.options.vertical ? this.api.track.scrollHeight : this.api.track.scrollWidth;
      state.metrics.maxScroll = Math.max(0, state.metrics.realTrackSize - state.metrics.viewportSize);
      this.api.internal.snapEngine.computeSnaps();
      this.api.internal.snapEngine.clampState();
      this.api.internal.observers.resumeTrackObservers();
      this.api.internal.events.emit(EVENTS.RESIZE);

      if (this.api.internal.renderer.isLoopActive() && state.position.current === 0 && state.metrics.snapPoints.length > 0) {
        const safeSnap = this.api.internal.snapEngine.getSnap(state.index.activeSnap);
        state.position.current = state.position.target = safeSnap;
      }

      const rawSnap = this.api.internal.snapEngine.getSnap(state.index.activeSnap);

      if (state.flags.isSettled || Math.abs(state.position.target - state.position.current) < 0.1) {
        state.position.current = rawSnap;
        state.position.target = rawSnap;

        const transformVal = this.api.getTransformValue();
        this.api.track.style.transform = this.api.options.vertical 
          ? `translate3d(0, ${transformVal}px, 0)` 
          : `translate3d(${transformVal}px, 0, 0)`;

      } else {
        state.position.target = this.api.internal.renderer.resolveTarget(rawSnap, state.position.current);
      }
      state.stats.layoutCalcs++;
      state.stats.lastLayoutTime = Environment.now() - perfStart;

    } finally {
      state.flags.layoutPending = false;
    }
  }
}
// engine/measurements.js END

// ==========================================
// engine/physics.js START
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
    this.api.internal.renderer.handleReposition();
    const transformVal = this.api.options.vertical ? -state.position.current : -state.position.current * this.api.dir;
    if (this.api.options.vertical) this.api.track.style.transform = `translate3d(0, ${transformVal}px, 0)`;
    else this.api.track.style.transform = `translate3d(${transformVal}px, 0, 0)`;
    this.api.internal.events.emit(EVENTS.SCROLL);
    if (!state.flags.isSettled && typeof requestAnimationFrame === 'function') state.timers.rafId = requestAnimationFrame(this.tick);
  }
}
// engine/physics.js END

// ==========================================
// engine/navigation.js START
// ==========================================
class NavigationEngine {
  constructor(api) { this.api = api; }
  goToSnap(snapIndex, immediate = false, force = false) {
    const state = this.api.internal.state;
    if (!state.metrics.snapPoints.length || ((state.flags.isPaused || state.flags.isFrozen) && !force)) return;
    const targetSnap = Math.max(0, Math.min(snapIndex, this.api.internal.snapEngine.maxReachableSnap()));

    const changed = (state.index.activeSnap !== targetSnap);
    const targetSlide = this.api.internal.snapEngine.getSlideForSnap(targetSnap);
    const targetGroup = this.api.internal.snapEngine.getGroupForSnap(targetSnap);

    const slideChanged = (state.index.current !== targetSlide);
    const groupChanged = (state.group.current !== targetGroup);
    if (changed) {
      this.api.internal.events.emit(EVENTS.NAV_BEFORE, { currentIndex: state.index.current, targetIndex: targetSlide });
      if (slideChanged) this.api.internal.events.emit(EVENTS.SELECT_BEFORE, { currentIndex: state.index.current, targetIndex: targetSlide });

      state.index.previousSnap = state.index.activeSnap;
      state.index.activeSnap = targetSnap;

      if (slideChanged) {
        state.index.previous = state.index.current;
        state.index.current = targetSlide;
      }
      if (groupChanged) {
        state.group.previous = state.group.current;
        state.group.current = targetGroup;
      }

      this.api.internal.events.emit(EVENTS.NAV, { currentIndex: state.index.current, previousIndex: state.index.previous });
      this.api.internal.events.emit(EVENTS.SNAP_CHANGE, { currentSnap: state.index.activeSnap, previousSnap: state.index.previousSnap });

      if (slideChanged) this.api.internal.events.emit(EVENTS.SLIDE_ACTIVE_CHANGE, { currentIndex: state.index.current, previousIndex: state.index.previous });
      if (groupChanged) this.api.internal.events.emit(EVENTS.GROUP_ACTIVE_CHANGE, { currentGroup: state.group.current, previousGroup: state.group.previous });
    }
    state.preview.index = targetSlide;
    state.preview.group = targetGroup;

    const rawTarget = this.api.internal.snapEngine.getSnap(state.index.activeSnap);
    state.physics.inertia = 0; 

    state.position.target = immediate ? rawTarget : this.api.internal.renderer.resolveTarget(rawTarget, state.position.current);
    if (immediate) {
      state.physics.inertia = state.physics.velocity = 0;
      state.position.current = state.position.target;
      const transformVal = this.api.getTransformValue();
      this.api.track.style.transform = this.api.options.vertical ? `translate3d(0, ${transformVal}px, 0)` : `translate3d(${transformVal}px, 0, 0)`;
      if (!state.flags.isSettled) { state.flags.isSettled = true; this.api.internal.events.emit(EVENTS.SETTLE); }
    } else {
      if (!state.flags.isPaused && !state.flags.isFrozen && state.flags.isSettled) { state.flags.isSettled = false; this.api.internal.physics.startPhysicsLoop(); }
    }
    this.api.internal.accessibility.updateSlideStates();
    this.api.internal.accessibility.updateAutoHeight();
    if (changed) { 
      if (slideChanged) {
        this.api.internal.events.emit(EVENTS.SELECT); 
        this.api.internal.events.emit(EVENTS.SELECT_AFTER); 
      }
      this.api.internal.events.emit(EVENTS.NAV_AFTER, { currentIndex: state.index.current, currentGroup: state.group.current });
    }
  }
  scrollNext(force = false) {
    if ((!this.api.internal.renderer.slideCount()) || ((this.api.internal.state.flags.isPaused || this.api.internal.state.flags.isFrozen) && !force)) return;
    if (this.api.internal.snapEngine.canScrollNext()) this.goToSnap(this.api.internal.snapEngine.nextSnap(), false, force);
  }
  scrollPrev(force = false) {
    if ((!this.api.internal.renderer.slideCount()) || ((this.api.internal.state.flags.isPaused || this.api.internal.state.flags.isFrozen) && !force)) return;
    if (this.api.internal.snapEngine.canScrollPrev()) this.goToSnap(this.api.internal.snapEngine.prevSnap(), false, force);
  }
}
// engine/navigation.js END

// ==========================================
// engine/observers.js START
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
  suspendTrackObservers() {
    if (this.mutationObserver) this.mutationObserver.disconnect();
    if (this.visibilityObserver) this.visibilityObserver.disconnect();
  }
  resumeTrackObservers() {
    const state = this.api.internal.state;
    if (!state.flags.isFrozen) {
      if (this.mutationObserver) this.mutationObserver.observe(this.api.track, { childList: true, subtree: true, attributes: true, attributeFilter: ['src'] });
      if (this.visibilityObserver) {
        state.dom.visibleSlides.clear(); 
        Array.from(this.api.track.children).forEach(node => this.visibilityObserver.observe(node));
      }
    }
  }
  disconnectAll() {
    if (this.resizeObserver) this.resizeObserver.disconnect();
    this.suspendTrackObservers();
  }
  reconnectAll() {
    if (this.resizeObserver && this.api.root) this.resizeObserver.observe(this.api.root);
    this.resumeTrackObservers();
  }
  destroy() {
    this.disconnectAll();
    if (this.rootVisibilityObserver) this.rootVisibilityObserver.disconnect();
    if (Environment.hasDOM()) document.removeEventListener('visibilitychange', this._docVisHandler);
    this.resizeObserver = this.mutationObserver = this.visibilityObserver = this.rootVisibilityObserver = null;
  }
}
// engine/observers.js END

// ==========================================
// engine/dynamic.js START
// ==========================================
class DynamicContentManager {
  constructor(api) { this.api = api; }
  batch(callback) {
    if (!this.api.internal.renderer.supportsDynamicManipulation()) {
      throw new Error('[ydCarousel] Dynamic DOM manipulation is not supported by the active renderer.');
    }
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
    this.api.internal.extensions.scheduleRefresh();
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
// engine/dynamic.js END

// ==========================================
// engine/accessibility.js START
// ==========================================
class AccessibilityManager {
  constructor(api) {
    this.api = api;
    this._announcer = null;
    this.announceHandler = null;
    this.stateUpdateHandler = null;
  }

  setupAccessibility() {
    if (!Environment.hasDOM()) return;
    const state = this.api.internal.state;
    const isThumb = this.api.root.dataset.syncRole === 'thumbnail';

    this.api.root.setAttribute('role', 'region');
    this.api.root.setAttribute('aria-roledescription', 'carousel');

    if (!this.api.root.id) {
      this.api.root.id = `yd_carousel_${Math.random().toString(36).slice(2, 11)}`;
      state.flags._generatedRootId = true;
    }
    if (!this.api.track.id) {
      this.api.track.id = `${this.api.root.id}_track`;
      state.flags._generatedTrackId = true;
    }

    this.api.track.setAttribute('aria-live', this.api.options.autoplay ? 'off' : 'polite');
    if (isThumb) {
      this.api.track.setAttribute('role', 'tablist');
      this.api.track.setAttribute('aria-orientation', this.api.options.vertical ? 'vertical' : 'horizontal');
    }

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
      if (!this._announcer) return;
      this._announcer.textContent = `Slide ${payload.currentIndex + 1} of ${api.internal.renderer.slideCount()}`;
    };
    this.stateUpdateHandler = () => this.updateSlideStates();

    this.api.internal.events.on(EVENTS.NAV_AFTER, this.announceHandler);
    this.api.internal.events.on(EVENTS.NAV_AFTER, this.stateUpdateHandler);
    this.api.internal.events.on(EVENTS.RESIZE, this.stateUpdateHandler);
  }

  updateSlideStates() {
    const state = this.api.internal.state;
    const total = this.api.internal.renderer.slideCount();
    if (total === 0 || state.flags.destroyed) return;

    const currentIdx = state.index.current;
    const prevIdx = this.api.internal.renderer.getVisualPrev(currentIdx);
    const nextIdx = this.api.internal.renderer.getVisualNext(currentIdx);

    this.api.track.querySelectorAll('.yd_slide').forEach(slide => {
      if (!slide.hasAttribute('data-slide-index')) return;

      const idx = parseInt(slide.getAttribute('data-slide-index'), 10);
      const isClone = slide.classList.contains('yd_slide-clone');

      const isActive = idx === currentIdx;
      const isPrev = idx === prevIdx;
      const isNext = idx === nextIdx;

      slide.classList.toggle('active', isActive);
      slide.classList.toggle('prev', isPrev);
      slide.classList.toggle('next', isNext);

      if (!isClone) {
        const isThumb = this.api.root.dataset.syncRole === 'thumbnail';

        if (isThumb) {
          slide.setAttribute('role', 'tab');
          slide.setAttribute('tabindex', isActive ? '0' : '-1'); 
          slide.setAttribute('aria-label', `Thumbnail ${idx + 1} of ${total}`);
          slide.setAttribute('aria-selected', isActive ? 'true' : 'false');
          slide.removeAttribute('aria-current');
        } else {
          slide.setAttribute('role', 'group');
          slide.setAttribute('aria-roledescription', 'slide');
          slide.setAttribute('tabindex', isActive ? '0' : '-1');
          slide.setAttribute('aria-label', `${idx + 1} of ${total}`);
          if (isActive) slide.setAttribute('aria-current', 'true');
          else slide.removeAttribute('aria-current');
          slide.removeAttribute('aria-selected');
        }

        if (!isThumb) {
          const focusables = slide.querySelectorAll('a, button, input, select, textarea, [tabindex]');
          focusables.forEach(node => {
            if (!node.hasAttribute('data-original-tabindex') && node.getAttribute('tabindex') !== '-1') {
              node.setAttribute('data-original-tabindex', node.getAttribute('tabindex') || '0');
            }
            const orig = node.getAttribute('data-original-tabindex') || '0';
            node.setAttribute('tabindex', isActive ? orig : '-1');
          });
        }
      } else {
        slide.setAttribute('aria-hidden', 'true');
        slide.setAttribute('tabindex', '-1');
      }
    });

    if (this.api.options.focusOnChange && Environment.hasDOM() && this.api.root.contains(document.activeElement)) {
      const activeEl = document.activeElement;
      const isInputTag = activeEl && ['INPUT', 'TEXTAREA', 'SELECT', 'OPTION'].includes(activeEl.tagName);
      if (!(isInputTag || (activeEl && activeEl.isContentEditable))) {
        const active = this.api.internal.renderer.getVisibleElement(currentIdx);
        if (active) {
          if (!active.hasAttribute('tabindex')) active.setAttribute('tabindex', '0');
          try { active.focus({ preventScroll: true }); } catch (err) { active.focus(); }
        }
      }
    }
  }

  updateAutoHeight() {
    if (!this.api.options.autoHeight) return;
    const slide = this.api.internal.renderer.getVisibleElement(this.api.internal.state.index.current);
    if (!slide) return;
    const height = slide.offsetHeight;
    if (height <= 0) return;
    const viewport = this.api.root.querySelector('.yd_viewport') || this.api.root;
    viewport.style.height = height + 'px';
  }

  destroy() {
    if (this.announceHandler) {
      this.api.internal.events.off(EVENTS.NAV_AFTER, this.announceHandler);
      this.announceHandler = null;
    }
    if (this.stateUpdateHandler) {
      this.api.internal.events.off(EVENTS.NAV_AFTER, this.stateUpdateHandler);
      this.api.internal.events.off(EVENTS.RESIZE, this.stateUpdateHandler);
      this.stateUpdateHandler = null;
    }
    if (this._announcer && this._announcer.parentNode) {
      this._announcer.parentNode.removeChild(this._announcer);
      this._announcer = null;
    }
  }
}
// engine/accessibility.js END

// ==========================================
// engine/dependencies.js START
// ==========================================
class DependencyManager {
  constructor(api) { this.api = api; }

  _getCombinedRegistry() {
    return new Map([
      ...CarouselRegistry.plugins,
      ...CarouselRegistry.behaviors,
      ...CarouselRegistry.inputs
    ]);
  }
  circularDetection() {
    const registry = this._getCombinedRegistry();
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
    const registry = this._getCombinedRegistry();
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
    const registry = this._getCombinedRegistry();
    const activeNames = new Set([...this.api.internal.extensions.extensions.keys()]);
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
// engine/dependencies.js END

// ==========================================
// engine/diagnostics.js START
// ==========================================
class Diagnostics {
  constructor(api) { this.api = api; this._pluginErrorTracker = new Map(); }
  _recordPluginError(name, err) {
    const c = this._pluginErrorTracker.get(name) || { count: 0, lastError: null };
    this._pluginErrorTracker.set(name, { count: c.count + 1, lastError: err ? (err.message || String(err)) : 'Unknown error' });
  }
  selfTest() {
    const state = this.api.internal.state;
    return deepFreeze({
      initialized: this.api.isReady(),
      renderer: !!this.api.internal.renderer,
      slides: state.metrics.snapPoints.length,
      groups: state.dom.logicalGroups.length,
      currentPos: state.position.current,
      targetPos: state.position.target,
      hasKeyboard: this.api.options.keyboard,
      observers: {
        resize: !!this.api.internal.observers.resizeObserver,
        mutation: !!this.api.internal.observers.mutationObserver,
        visibility: !!this.api.internal.observers.visibilityObserver
      }
    });
  }
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
      loop: this.api.options.loop, dragFree: this.api.options.dragFree, rtl: this.api.isRTL, direction: this.api.options.direction, vertical: this.api.options.vertical,
      autoplay: this.api.options.autoplay, keyboard: this.api.options.keyboard, autoHeight: this.api.options.autoHeight, autoVisibility: this.api.options.autoVisibility, focusOnChange: this.api.options.focusOnChange,
      reducedMotion: this.api.reducedMotion, alignCenter: this.api.options.alignCenter, alignEnd: this.api.options.alignEnd, slideSnap: this.api.options.slideSnap, groupSnap: this.api.options.groupSnap
    });
  }
  state() {
    const s = this.api.internal.state;
    return deepFreeze({
      version: this.api.version(), index: s.index.current, group: s.group.current, previousIndex: s.index.previous,
      position: s.position.current, target: s.position.target, velocity: s.physics.velocity, progress: this.api.internal.renderer.getScrollProgress(),
      visualProgress: this.api.internal.renderer.getVisualProgress(), dragging: s.flags.isDraggingActive, settled: s.flags.isSettled, looping: this.api.options.loop,
      rtl: this.api.isRTL, direction: this.api.options.direction, vertical: this.api.options.vertical, autoHeight: this.api.options.autoHeight, autoVisibility: this.api.options.autoVisibility,
      focusOnChange: this.api.options.focusOnChange, reducedMotion: this.api.reducedMotion, paused: s.flags.isPaused, frozen: s.flags.isFrozen, autoFrozen: s.flags.isAutoFrozen,
      manualFrozen: s.flags.manualFrozen, slideSnap: this.api.options.slideSnap, groupSnap: this.api.options.groupSnap
    });
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
      originalSlides: this.api.internal.renderer.slideCount(), cloneDiagnostics: this.api.internal.renderer.cloneDiagnostics(),
      activeObservers: state.flags.isFrozen ? 0 : ((this.api.internal.observers.resizeObserver ? 1 : 0) + (this.api.internal.observers.mutationObserver ? 1 : 0) + (this.api.internal.observers.visibilityObserver ? 1 : 0))
    });
  }
  warnings() {
    const list = []; const state = this.api.internal.state;
    if (state.flags.destroyed) { list.push('Instance is destroyed.'); return deepFreeze(list); }
    if (this.api.options.loop && this.api.internal.renderer.slideCount() <= 1) list.push('Loop mode is enabled but requires at least 2 slides.');
    if (this.api.options.vertical && this.api.options.loop && this.api.root.classList.contains('wheel')) list.push('Wheel navigation in vertical loop mode may trap page scrolling.');
    if (this.api.internal.renderer.slideCount() === 0) list.push('Carousel track contains no slides.');
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
    const activeNames = new Set(Array.from(this.api.internal.extensions.extensions.keys())); const health = {};
    const registry = this.api.internal.dependencies._getCombinedRegistry();
    registry.forEach((def, name) => { const errInfo = this._pluginErrorTracker.get(name) || { count: 0, lastError: null }; health[name] = Object.freeze({ active: activeNames.has(name), errors: errInfo.count, lastError: errInfo.lastError }); });
    return deepFreeze(health);
  }
  xray() {
    const state = this.api.internal.state;
    return deepFreeze({
      core: { version: this.api.version(), build: { engine: ydCarousel.ENGINE, version: this.api.version(), build: 'enterprise-production', released: '2026-08' }, extensions: Object.freeze([...Array.from(this.api.internal.extensions.extensions.keys())]), events: Object.freeze(this.api.internal.events), capabilities: this.api.capabilities(), runtimeCapabilities: this.api.runtimeCapabilities(), state: this.api.state() },
      inspection: { slidesInView: Object.freeze([...state.dom.visibleSlides].sort((a,b)=>a-b)), slidesNotInView: Object.freeze(Array.from({length: this.api.internal.renderer.slideCount()}, (_, i) => i).filter(i => !state.dom.visibleSlides.has(i))), activeSlide: state.index.current },
      drag: { active: state.drag.active, startIndex: state.drag.startIndex, currentIndex: state.drag.currentIndex },
      health: this.health(), performance: this.performanceStats(), warnings: this.warnings(), compatibility: this.compatibilityReport(),
      plugins: { totalRegistered: this.api.internal.dependencies._getCombinedRegistry().size, totalActive: this.api.internal.extensions.extensions.size, registeredPlugins: Object.freeze(Array.from(this.api.internal.dependencies._getCombinedRegistry().keys())), activePlugins: Object.freeze(Array.from(this.api.internal.extensions.extensions.keys())) },
      pluginHealth: this.pluginHealth(), dependencies: this.api.internal.dependencies.dependencyReport(),
      events: Object.freeze({ stats: this.api.internal.events.eventStats(), totalListeners: this.api.internal.events.listenerCount() }),
      metrics: Object.freeze({ viewportSize: state.metrics.viewportSize, trackSize: state.metrics.trackSize, realTrackSize: state.metrics.realTrackSize, prependOffset: state.metrics.prependOffset, gap: state.metrics.gap, averageSlideSize: state.metrics.averageSlideSize, slideSizes: Object.freeze([...state.metrics.slideSizes]), relativeOffsets: Object.freeze([...state.metrics.relativeOffsets]), snapPoints: Object.freeze([...state.metrics.snapPoints]) }),
      config: Object.freeze({ loop: this.api.options.loop, dragFree: this.api.options.dragFree, alignCenter: this.api.options.alignCenter, alignEnd: this.api.options.alignEnd, keyboard: this.api.options.keyboard, autoplay: this.api.options.autoplay, direction: this.api.options.direction, vertical: this.api.options.vertical, autoHeight: this.api.options.autoHeight, autoVisibility: this.api.options.autoVisibility, focusOnChange: this.api.options.focusOnChange, reducedMotion: this.api.reducedMotion, duration: this.api.options.duration, friction: this.api.options.friction, delay: this.api.options.delay, dragThreshold: this.api.options.dragThreshold, velocityThreshold: this.api.options.velocityThreshold, dragInertia: this.api.options.dragInertia, slideSnap: this.api.options.slideSnap, groupSnap: this.api.options.groupSnap })
    });
  }
}
// engine/diagnostics.js END

// ==========================================
// facade/ydCarousel.js START
// ==========================================
class ydCarousel {
  static VERSION = '3.0.0-LTS';
  static ENGINE = 'ydCarousel-Enterprise';
  static EVENTS = EVENTS;
  static SNAP_EPSILON = 0.5;

  static startAutoInit() {
    if (!Environment.hasDOM()) return;
    document.querySelectorAll('.yd_carousel:not(.yd_carousel-ready)').forEach(el => {
      if (!el.__ydCarousel) {
        try { new ydCarousel(el); } catch (err) { console.error('[ydCarousel] Auto-init failed:', err); }
      }
    });
  }
  static stopAutoInit() {} 

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
      delay: parseInt(this.root.dataset.delay) || 4000, 
      dragThreshold: parseInt(this.root.dataset.dragThreshold) || 5,
      velocityThreshold: parseFloat(this.root.dataset.velocityThreshold) || 0.5, dragInertia: this.reducedMotion ? 0 : (parseFloat(this.root.dataset.dragInertia) || 40),
      slideSnap: this.root.classList.contains('slide-snap'), groupSnap: this.root.classList.contains('group-snap')
    };
    this.isRTL = this.options.direction === 'rtl';
    this.dir = this.isRTL ? -1 : 1;
    if (this.options.groupSnap) this.options.slideSnap = false;
    if (!this.options.slideSnap && !this.options.groupSnap) this.options.slideSnap = true;

    const state = new CarouselState();
    const events = new EventBus(this);
    const lifecycle = new Lifecycle(this);
    const measurements = new MeasurementEngine(this);
    const physics = new PhysicsEngine(this);
    const navigation = new NavigationEngine(this);
    const observers = new ObserverManager(this);
    const dynamic = new DynamicContentManager(this);
    const accessibility = new AccessibilityManager(this);
    
    const renderer = ModuleLoader.resolveRenderer(this);
    const snapEngine = ModuleLoader.resolveSnapEngine(this);

    const extensions = new ExtensionManager(this);
    const dependencies = new DependencyManager(this);
    const diagnostics = new Diagnostics(this);
    const modules = new ModuleManager(this);

    CarouselRegistry.validateRenderer(renderer);

    this.internal = Object.freeze({
      state, events, lifecycle, measurements, snapEngine, physics, renderer, 
      navigation, observers, dynamic, accessibility, extensions, diagnostics, modules, dependencies
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
    
    if (this.internal.renderer.isLoopActive() && this.internal.state.position.current === 0 && this.internal.state.metrics.snapPoints.length > 0) {
      const safeSnap = this.internal.snapEngine.getSnap(0);
      this.internal.state.position.current = safeSnap;
      this.internal.state.position.target = safeSnap;
      const transformVal = this.getTransformValue();
      this.track.style.transform = this.options.vertical ? `translate3d(0, ${transformVal}px, 0)` : `translate3d(${transformVal}px, 0, 0)`;
    }
  }

  get currentPos() { return this.internal.state.position.current; }
  get targetPos() { return this.internal.state.position.target; }
  get currentIndex() { return this.internal.state.index.current; }
  get currentGroup() { return this.internal.state.group.current; }
  
  pause() { this.internal.lifecycle.pause(); }
  resume() { this.internal.lifecycle.resume(); }
  freeze(m=true) { this.internal.lifecycle.freeze(m); }
  unfreeze(m=true) { this.internal.lifecycle.unfreeze(m); }
  destroy() { this.internal.lifecycle.destroy(); }
  
  goToSlide(i, imm=false, f=false) { this.internal.navigation.goToSnap(this.internal.snapEngine.getSnapForSlide(i), imm, f); }
  goToGroup(i, imm=false, f=false) { this.internal.navigation.goToSnap(this.internal.snapEngine.getSnapForGroup(i), imm, f); }
  scrollNext(f=false) { this.internal.navigation.scrollNext(f); }
  scrollPrev(f=false) { this.internal.navigation.scrollPrev(f); }
  scrollTo(i, imm=false) { this.goToSlide(i, imm); }
  
  refresh(full=false) { if(this.internal.state.flags.destroyed) return; this.internal.measurements.updateMeasurements(); if(full) this.internal.extensions.refreshAll(); }
  addSlide(h) { this.internal.dynamic.addSlide(h); }
  removeSlide(i) { this.internal.dynamic.removeSlide(i); }
  removeAllSlides() { this.internal.dynamic.removeAllSlides(); }
  
  slideCount() { return this.internal.renderer.slideCount(); }
  groupCount() { return this.internal.state.dom.logicalGroups.length; }
  datasetCount() { return this.internal.state.dom.originalSlides.length; }
  getSlide(i) { return this.internal.renderer.getVisibleElement(i); }
  activeSlide() { return this.internal.renderer.getVisibleElement(this.internal.state.index.current); }
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
  selfTest() { return this.internal.diagnostics.selfTest(); }
  health() { return this.internal.diagnostics.health(); }
  xray() { return this.internal.diagnostics.xray(); }
  compatibilityReport() { return this.internal.diagnostics.compatibilityReport(); }
  warnings() { return this.internal.diagnostics.warnings(); }
  performanceStats() { return this.internal.diagnostics.performanceStats(); }
  pluginHealth() { return this.internal.diagnostics.pluginHealth(); }
  dependencyReport() { return this.internal.dependencies.dependencyReport(); }
  capabilities() { return this.internal.diagnostics.capabilities(); }
  runtimeCapabilities() { return this.internal.diagnostics.runtimeCapabilities(); }
  version() { return ydCarousel.VERSION; }
  state() { return this.internal.diagnostics.state(); }
}
// facade/ydCarousel.js END

// ==========================================
// renderers/base-renderer.js START
// ==========================================
class BaseRenderer {
  constructor(api) { this.api = api; }
  isLoopActive() { return false; }
  normalizePosition(position) { return position; }
  distanceToSnap(point, position) { return Math.abs(point - position); }
  normalizeIndex(index) { return index; }
  getVisualPrev(index) { return Math.max(index - 1, 0); }
  getVisualNext(index) { const total = this.slideCount(); return total ? Math.min(index + 1, total - 1) : 0; }
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
    const offset = state.metrics.relativeOffsets[index] || 0;
    let distance = state.position.current - offset;
    return Math.max(-1, Math.min(1, distance / (state.metrics.viewportSize || 1)));
  }
  createClone(slide) {}
  _purgeClones() {}
  cloneCount() { return 0; }
  cloneDiagnostics() { return { cloneNodes: 0 }; }

  setupTrack(physicalSize, loopGap) {
    const state = this.api.internal.state;
    state.metrics.gap = loopGap;
    state.metrics.realTrackSize = physicalSize;
    state.metrics.prependOffset = 0;
  }
  resolveTarget(rawTarget, currentTarget) { return rawTarget; }
  handleReposition() {}

  slideCount() { return this.api.internal.state.dom.originalSlides.length; }
  getVisibleElement(index) { return this.api.internal.state.dom.originalSlides[index] || null; }
  supportsDynamicManipulation() { return true; }

  resolveHash(hash) { return this.api.internal.state.dom.originalSlides.findIndex(s => s.dataset.hash === hash); }
  getHashByIndex(index) { const s = this.api.internal.state.dom.originalSlides[index]; return s ? s.dataset.hash : null; }

  measureTrack() {
    const state = this.api.internal.state;
    const viewportEl = this.api.root.querySelector('.yd_viewport') || this.api.root;
    const viewportRect = viewportEl.getBoundingClientRect();
    state.metrics.viewportSize = this.api.options.vertical ? viewportRect.height : viewportRect.width;

    let physicalSize = 0; 
    let loopGap = 0;

    if (state.dom.originalSlides.length > 0) {
      const slideRects = state.dom.originalSlides.map(slide => slide.getBoundingClientRect());
      
      state.metrics.slideSizes = slideRects.map(rect => this.api.options.vertical ? rect.height : rect.width);
      state.metrics.averageSlideSize = state.metrics.slideSizes.reduce((total, size) => total + size, 0) / state.metrics.slideSizes.length;
      
      state.metrics.slidesPerView = this.api.internal.measurements.getConfiguredSlidesPerView() ?? Math.max(1, Math.round(state.metrics.viewportSize / (state.metrics.averageSlideSize + state.metrics.gap)));
      state.dom.logicalGroups = [];
      const total = this.slideCount();
      for (let i = 0; i < total; i += state.metrics.slidesPerView) state.dom.logicalGroups.push(i);

      const firstRect = slideRects[0];
      state.metrics.relativeOffsets = slideRects.map(rect => { 
        if (this.api.options.vertical) return rect.top - firstRect.top; 
        return this.api.isRTL ? firstRect.right - rect.right : rect.left - firstRect.left; 
      });
      
      const lastIdx = state.dom.originalSlides.length - 1; 
      physicalSize = state.metrics.relativeOffsets[lastIdx] + state.metrics.slideSizes[lastIdx];
      if (state.dom.originalSlides.length > 1) {
        loopGap = Math.max(0, state.metrics.relativeOffsets[1] - (state.metrics.relativeOffsets[0] + state.metrics.slideSizes[0]));
      }
    } else {
      state.metrics.averageSlideSize = state.metrics.viewportSize;
      state.metrics.slideSizes = [];
      state.metrics.relativeOffsets = [];
      state.metrics.slidesPerView = 1;
      state.dom.logicalGroups = [];
    }
    
    this.setupTrack(physicalSize, loopGap);
  }
}
// renderers/base-renderer.js END

// ==========================================
// renderers/standard.js START
// ==========================================
class StandardRenderer extends BaseRenderer {}
CarouselRegistry.registerRenderer({ name: 'standard', classRef: StandardRenderer });
// renderers/standard.js END

// ==========================================
// renderers/loop.js START
// ==========================================
class CloneLoopRenderer extends StandardRenderer {
  setupTrack(physicalSize, loopGap) {
    const state = this.api.internal.state;
    state.metrics.gap = loopGap;
    state.metrics.realTrackSize = physicalSize + loopGap;

    if (state.dom.originalSlides.length > 1 && state.metrics.realTrackSize > 0) {
      let clonedSize = 0;
      let setsNeeded = 2; 
      clonedSize = state.metrics.realTrackSize * setsNeeded;
      while (clonedSize < (state.metrics.viewportSize * 5) && setsNeeded < 6 && (state.dom.originalSlides.length * (setsNeeded + 1) * 2) <= CarouselRegistry.MAX_LOOP_CLONES) {
        clonedSize += state.metrics.realTrackSize;
        setsNeeded++;
      }

      setsNeeded = Math.max(1, setsNeeded);
      state.metrics.prependOffset = state.metrics.realTrackSize * setsNeeded;

      if (setsNeeded > 0) {
        for (let i = 0; i < setsNeeded; i++) {
          const clonesBefore = state.dom.originalSlides.map(s => this.createClone(s));
          const clonesAfter = state.dom.originalSlides.map(s => this.createClone(s));
          const firstOriginal = state.dom.originalSlides[0];
          clonesBefore.forEach(c => this.api.track.insertBefore(c, firstOriginal));
          clonesAfter.forEach(c => this.api.track.appendChild(c));
        }
      }
    } else {
      state.metrics.prependOffset = 0;
    }
  }
  handleReposition() {
    if (!this.isLoopActive()) return;
    const state = this.api.internal.state;

    if (typeof window !== 'undefined' && window.ydDebugLoop) {
      console.log('[LOOP]', {
        current: state.position.current,
        target: state.position.target,
        prepend: state.metrics.prependOffset,
        real: state.metrics.realTrackSize
      });
    }

    const firstBoundary = state.metrics.prependOffset;
    const lastBoundary = state.metrics.prependOffset + state.metrics.realTrackSize;
    if (state.position.current < firstBoundary) {
      this.api.internal.events.emit(EVENTS.LOOP_ENTER, { position: 'start' });
      const originalFrom = state.position.current;

      state.position.current += state.metrics.realTrackSize;
      state.position.target += state.metrics.realTrackSize;
      const delta = state.position.current - originalFrom;
      this.api.internal.events.emit(EVENTS.LOOP_REPOSITION, { from: originalFrom, to: state.position.current, delta });
      this.api.internal.events.emit(EVENTS.LOOP_EXIT, { position: 'end' });
    } 
    else if (state.position.current >= lastBoundary) {
      this.api.internal.events.emit(EVENTS.LOOP_ENTER, { position: 'end' });
      const originalFrom = state.position.current;

      state.position.current -= state.metrics.realTrackSize;
      state.position.target -= state.metrics.realTrackSize;
      const delta = state.position.current - originalFrom;
      this.api.internal.events.emit(EVENTS.LOOP_REPOSITION, { from: originalFrom, to: state.position.current, delta });
      this.api.internal.events.emit(EVENTS.LOOP_EXIT, { position: 'start' });
    }
  }
  isLoopActive() {
    const state = this.api.internal.state;
    return this.api.options.loop && state.metrics.snapPoints.length > 0 && state.metrics.realTrackSize > 0;
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
    const total = this.slideCount();
    if (!total) return 0;
    let normalized = index;
    while (normalized < 0) normalized += total;
    while (normalized >= total) normalized -= total;
    return normalized;
  }
  getVisualPrev(index) {
    if (!this.isLoopActive()) return super.getVisualPrev(index);
    const total = this.slideCount();
    return total ? (total + index - 1) % total : 0;
  }
  getVisualNext(index) {
    if (!this.isLoopActive()) return super.getVisualNext(index);
    const total = this.slideCount();
    return total ? (index + 1) % total : 0;
  }
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
    const offset = (state.metrics.relativeOffsets[index] || 0) + state.metrics.prependOffset;
    let distance = state.position.current - offset;
    if (state.metrics.realTrackSize > 0) {
      const distFwd = distance - state.metrics.realTrackSize;
      const distBwd = distance + state.metrics.realTrackSize;
      if (Math.abs(distFwd) < Math.abs(distance)) distance = distFwd;
      if (Math.abs(distBwd) < Math.abs(distance)) distance = distBwd;
    }
    return Math.max(-1, Math.min(1, distance / (state.metrics.viewportSize || 1)));
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
  createClone(slide) {
    const clone = slide.cloneNode(true);
    clone.setAttribute('data-slide-index', slide.getAttribute('data-slide-index'));
    clone.classList.add('yd_slide-clone');
    clone.setAttribute('role', 'presentation');
    clone.setAttribute('aria-hidden', 'true');
    clone.setAttribute('tabindex', '-1');
    if ('inert' in clone) clone.inert = true;
    clone.removeAttribute('aria-current');
    clone.removeAttribute('aria-selected');
    clone.removeAttribute('aria-pressed');
    clone.classList.remove('active', 'prev', 'next');
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
CarouselRegistry.registerRenderer({ name: 'loop', classRef: CloneLoopRenderer });
// renderers/loop.js END

// ==========================================
// renderers/virtual.js START
// ==========================================
class VirtualRenderer extends BaseRenderer {
  constructor(api) {
    super(api);
    this.pool = [];
    this.totalSlides = parseInt(this.api.root.dataset.virtualTotal, 10) || 0;
    this.renderCallback = this.api.root.virtualRender || 
      (typeof window !== 'undefined' && this.api.root.dataset.virtualRender ? window[this.api.root.dataset.virtualRender] : null) || 
      ((idx) => `<div class="yd_virtual-placeholder">Slide ${idx + 1}</div>`);
  }
  isLoopActive() { 
    return this.api.options.loop && this.totalSlides > 0; 
  }
  measureTrack() {
    const state = this.api.internal.state;
    const viewportEl = this.api.root.querySelector('.yd_viewport') || this.api.root;
    const viewportRect = viewportEl.getBoundingClientRect();
    state.metrics.viewportSize = this.api.options.vertical ? viewportRect.height : viewportRect.width;

    state.metrics.averageSlideSize = state.metrics.viewportSize; 
    state.metrics.slideSizes = new Array(this.totalSlides).fill(state.metrics.averageSlideSize);

    state.metrics.slidesPerView = this.api.internal.measurements.getConfiguredSlidesPerView() ?? Math.max(1, Math.round(state.metrics.viewportSize / (state.metrics.averageSlideSize + state.metrics.gap)));
    state.dom.logicalGroups = [];
    for (let i = 0; i < this.totalSlides; i += state.metrics.slidesPerView) state.dom.logicalGroups.push(i);
    state.metrics.relativeOffsets = new Array(this.totalSlides).fill(0).map((_, i) => i * state.metrics.averageSlideSize);
    this.setupTrack(0, 0); 
  }
  setupTrack(physicalSize, loopGap) {
    const state = this.api.internal.state;
    state.metrics.gap = loopGap;
    const slideSize = state.metrics.averageSlideSize || state.metrics.viewportSize;
    state.metrics.realTrackSize = this.totalSlides * (slideSize + loopGap);
    state.metrics.prependOffset = this.isLoopActive() ? (state.metrics.realTrackSize * 2) : 0;

    const buffer = 2; 
    const desiredPoolSize = Math.min(this.totalSlides, (state.metrics.slidesPerView || 1) + (buffer * 2));

    if (this.pool.length !== desiredPoolSize) {
      this.api.internal.observers.suspendTrackObservers();
      this.api.track.innerHTML = '';
      this.pool = [];
      for (let i = 0; i < desiredPoolSize; i++) {
        const node = document.createElement('div');
        node.className = 'yd_slide yd_virtual-slide';
        node.style.position = 'absolute';
        node.style.top = '0';
        node.style.left = '0';
        this.api.track.appendChild(node);
        this.pool.push({ node, index: -1 }); 
      }
      this.api.internal.observers.resumeTrackObservers();
    }

    for (let i = 0; i < this.pool.length; i++) {
       if (!this.api.options.vertical) this.pool[i].node.style.width = `${slideSize}px`;
       else this.pool[i].node.style.height = `${slideSize}px`;
    }
    this._renderVisible();
  }
  _renderVisible() {
    const state = this.api.internal.state;
    if (!this.totalSlides || this.pool.length === 0) return;
    const slideSize = state.metrics.averageSlideSize + state.metrics.gap;
    let startPos = state.position.current - state.metrics.prependOffset;
    if (this.isLoopActive()) startPos = ((startPos % state.metrics.realTrackSize) + state.metrics.realTrackSize) % state.metrics.realTrackSize;
    let startIndex = Math.floor(startPos / slideSize) - 1;
    for (let i = 0; i < this.pool.length; i++) {
      let logicalIndex = startIndex + i;
      let physicalIndex = logicalIndex;
      let offsetPos = logicalIndex * slideSize;
      if (this.isLoopActive()) {
        physicalIndex = ((logicalIndex % this.totalSlides) + this.totalSlides) % this.totalSlides;
      } else {
        if (logicalIndex < 0 || logicalIndex >= this.totalSlides) {
          this.pool[i].node.style.display = 'none';
          continue;
        }
      }
      this.pool[i].node.style.display = '';
      if (this.pool[i].index !== physicalIndex) {
        this.pool[i].index = physicalIndex;
        this.pool[i].node.innerHTML = this.renderCallback(physicalIndex);
        this.pool[i].node.setAttribute('data-slide-index', physicalIndex);
      }
      const transformVal = this.api.options.vertical ? `translate3d(0, ${offsetPos}px, 0)` : `translate3d(${this.api.isRTL ? -offsetPos : offsetPos}px, 0, 0)`;
      this.pool[i].node.style.transform = transformVal;
    }
  }
  handleReposition() {
    if (!this.isLoopActive()) return;
    const state = this.api.internal.state;
    
    if (typeof window !== 'undefined' && window.ydDebugLoop) {
      console.log('[LOOP VIRTUAL]', {
        current: state.position.current,
        target: state.position.target,
        prepend: state.metrics.prependOffset,
        real: state.metrics.realTrackSize
      });
    }

    const firstBoundary = state.metrics.prependOffset;
    const lastBoundary = state.metrics.prependOffset + state.metrics.realTrackSize;
    if (state.position.current < firstBoundary) {
      this.api.internal.events.emit(EVENTS.LOOP_ENTER, { position: 'start' });
      const originalFrom = state.position.current;

      state.position.current += state.metrics.realTrackSize;
      state.position.target += state.metrics.realTrackSize;
      const delta = state.position.current - originalFrom;
      this.api.internal.events.emit(EVENTS.LOOP_REPOSITION, { from: originalFrom, to: state.position.current, delta });
      this.api.internal.events.emit(EVENTS.LOOP_EXIT, { position: 'end' });
    } 
    else if (state.position.current >= lastBoundary) {
      this.api.internal.events.emit(EVENTS.LOOP_ENTER, { position: 'end' });
      const originalFrom = state.position.current;

      state.position.current -= state.metrics.realTrackSize;
      state.position.target -= state.metrics.realTrackSize;
      const delta = state.position.current - originalFrom;
      this.api.internal.events.emit(EVENTS.LOOP_REPOSITION, { from: originalFrom, to: state.position.current, delta });
      this.api.internal.events.emit(EVENTS.LOOP_EXIT, { position: 'start' });
    }

    this._renderVisible();
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
    if (!this.totalSlides) return 0;
    let normalized = index;
    while (normalized < 0) normalized += this.totalSlides;
    while (normalized >= this.totalSlides) normalized -= this.totalSlides;
    return normalized;
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
  getVisualPrev(index) {
    if (!this.isLoopActive()) return Math.max(index - 1, 0);
    return this.totalSlides ? (this.totalSlides + index - 1) % this.totalSlides : 0;
  }
  getVisualNext(index) {
    if (!this.isLoopActive()) return this.totalSlides ? Math.min(index + 1, this.totalSlides - 1) : 0;
    return this.totalSlides ? (index + 1) % this.totalSlides : 0;
  }
  getScrollProgress() {
    const state = this.api.internal.state;
    if (!state.metrics.maxScroll) return 0;
    if (this.isLoopActive() && state.metrics.realTrackSize > 0) {
      let relativePos = (state.position.current - state.metrics.prependOffset) % state.metrics.realTrackSize;
      if (relativePos < 0) relativePos += state.metrics.realTrackSize;
      return Math.max(0, Math.min(1, relativePos / state.metrics.realTrackSize));
    }
    return Math.max(0, Math.min(1, state.position.current / state.metrics.maxScroll));
  }
  getVisualProgress() {
    const p = this.getScrollProgress();
    return (this.api.isRTL && !this.api.options.vertical) ? 1 - p : p;
  }
  getSlideProgress(index) {
    const state = this.api.internal.state;
    const slideSize = state.metrics.averageSlideSize + state.metrics.gap;
    const offset = (index * slideSize) + state.metrics.prependOffset;
    let distance = state.position.current - offset;

    if (this.isLoopActive() && state.metrics.realTrackSize > 0) {
      const distFwd = distance - state.metrics.realTrackSize;
      const distBwd = distance + state.metrics.realTrackSize;
      if (Math.abs(distFwd) < Math.abs(distance)) distance = distFwd;
      if (Math.abs(distBwd) < Math.abs(distance)) distance = distBwd;
    }
    return Math.max(-1, Math.min(1, distance / (state.metrics.viewportSize || 1)));
  }
  slideCount() { return this.totalSlides; }

  getVisibleElement(index) { 
    let match = this.pool.find(p => p.index === index && p.node.style.display !== 'none');
    if (!match) {
      this._renderVisible();
      match = this.pool.find(p => p.index === index && p.node.style.display !== 'none');
    }
    return match ? match.node : null; 
  }

  supportsDynamicManipulation() { return false; }
  resolveHash(hash) { return -1; }
  getHashByIndex(index) { return null; }
  cloneCount() { return 0; }
  cloneDiagnostics() { return { cloneNodes: 0 }; }
  _purgeClones() {}
}
CarouselRegistry.registerRenderer({ name: 'virtual', classRef: VirtualRenderer });
// renderers/virtual.js END

// ==========================================
// snaps/base-snap.js START
// ==========================================
class BaseSnapEngine {
  constructor(api) { this.api = api; }
  computeSnaps(rawSnaps) {
    const state = this.api.internal.state;
    if (!this.api.internal.renderer.isLoopActive()) {
      rawSnaps = rawSnaps.map(snap => Math.max(0, Math.min(snap, state.metrics.maxScroll)));
    }
    let uniqueSnaps = [];
    rawSnaps.forEach(snap => {
      if (uniqueSnaps.length === 0 || Math.abs(uniqueSnaps[uniqueSnaps.length - 1] - snap) > ydCarousel.SNAP_EPSILON) {
        uniqueSnaps.push(snap);
      }
    });
    state.metrics.snapPoints = uniqueSnaps;
  }
  clampState() {}
  getSnapCount() { return this.api.internal.state.metrics.snapPoints.length; }
  getSnap(index) { return this.api.internal.state.metrics.snapPoints[index] ?? 0; }
  maxReachableSnap() { return Math.max(0, this.getSnapCount() - 1); }
  canScrollNext() {
    if (this.api.root.classList.contains('stop-last')) return this.api.internal.state.index.activeSnap < this.maxReachableSnap();
    if (this.api.internal.renderer.isLoopActive()) return true;
    return this.api.internal.state.index.activeSnap < this.maxReachableSnap();
  }
  canScrollPrev() {
    if (this.api.internal.renderer.isLoopActive()) return true;
    return this.api.internal.state.index.activeSnap > 0;
  }
  nextSnap() {
    const current = this.api.internal.state.index.activeSnap;
    if (this.api.internal.renderer.isLoopActive()) return (current + 1) % this.getSnapCount();
    return Math.min(current + 1, this.maxReachableSnap());
  }
  prevSnap() {
    const current = this.api.internal.state.index.activeSnap;
    if (this.api.internal.renderer.isLoopActive()) return (current - 1 + this.getSnapCount()) % this.getSnapCount();
    return Math.max(current - 1, 0);
  }
  findNearestSnap(position) {
    let minDistance = Infinity; let nearest = 0;
    const searchPos = this.api.internal.renderer.normalizePosition(position);
    this.api.internal.state.metrics.snapPoints.forEach((snap, idx) => {
      const dist = this.api.internal.renderer.distanceToSnap(snap, searchPos);
      if (dist < minDistance) { minDistance = dist; nearest = idx; }
    });
    return nearest;
  }
  getSlideForSnap(snapIndex) { return 0; }
  getSnapForSlide(slideIndex) { return 0; }
  getGroupForSnap(snapIndex) { return 0; }
  getSnapForGroup(groupIndex) { return 0; }
}
// snaps/base-snap.js END

// ==========================================
// snaps/slide.js START
// ==========================================
class SlideSnapEngine extends BaseSnapEngine {
  computeSnaps() {
    const state = this.api.internal.state;
    let rawSnaps = [];
    state.metrics.slideSizes.forEach((size, idx) => {
      let snap = state.metrics.prependOffset + state.metrics.relativeOffsets[idx];
      if (this.api.options.alignCenter) snap -= (state.metrics.viewportSize / 2) - (size / 2);
      if (this.api.options.alignEnd) snap -= state.metrics.viewportSize - size;
      rawSnaps.push(Math.max(0, snap));
    });
    super.computeSnaps(rawSnaps);
  }
  clampState() {
    const state = this.api.internal.state;
    if (!state.metrics.snapPoints.length) { state.index.activeSnap = state.index.current = state.group.current = 0; return; }
    state.index.activeSnap = Math.max(0, Math.min(state.index.activeSnap, this.maxReachableSnap()));
    state.index.current = this.getSlideForSnap(state.index.activeSnap);
    state.group.current = this.getGroupForSnap(state.index.activeSnap);
  }
  getSlideForSnap(snapIndex) { return snapIndex; }
  getSnapForSlide(slideIndex) { return slideIndex; }
  getGroupForSnap(snapIndex) {
    const groups = this.api.internal.state.dom.logicalGroups;
    if (!groups || groups.length === 0) return 0;
    const normIndex = this.api.internal.renderer.normalizeIndex(snapIndex);
    let result = 0;
    for (let i = 0; i < groups.length; i++) { if (groups[i] <= normIndex) result = i; else break; }
    return result;
  }
  getSnapForGroup(groupIndex) {
    const logicalGroups = this.api.internal.state.dom.logicalGroups;
    const slideIndex = logicalGroups[groupIndex] || 0;
    return this.getSnapForSlide(slideIndex);
  }
}
CarouselRegistry.registerSnap({ name: 'slide-snap', classRef: SlideSnapEngine });
// snaps/slide.js END

// ==========================================
// snaps/group.js START
// ==========================================
class GroupSnapEngine extends BaseSnapEngine {
  computeSnaps() {
    const state = this.api.internal.state;
    let rawSnaps = [];
    let currentGroupStartOffset = 0; let currentGroupStartSnap = 0;
    state.metrics.slideSizes.forEach((size, idx) => {
      let snap = state.metrics.prependOffset + state.metrics.relativeOffsets[idx];
      if (this.api.options.alignCenter) snap -= (state.metrics.viewportSize / 2) - (size / 2);
      if (this.api.options.alignEnd) snap -= state.metrics.viewportSize - size;
      if (idx === 0) { rawSnaps.push(Math.max(0, snap)); currentGroupStartOffset = state.metrics.relativeOffsets[idx]; currentGroupStartSnap = Math.max(0, snap); } 
      else {
        if ((state.metrics.relativeOffsets[idx] - currentGroupStartOffset) + size > state.metrics.viewportSize) {
          currentGroupStartOffset = state.metrics.relativeOffsets[idx]; currentGroupStartSnap = Math.max(0, snap); rawSnaps.push(currentGroupStartSnap);
        }
      }
    });
    super.computeSnaps(rawSnaps);
  }
  clampState() {
    const state = this.api.internal.state;
    if (!state.metrics.snapPoints.length) { state.index.activeSnap = state.index.current = state.group.current = 0; return; }
    state.index.activeSnap = Math.max(0, Math.min(state.index.activeSnap, this.maxReachableSnap()));
    state.index.current = this.getSlideForSnap(state.index.activeSnap);
    state.group.current = this.getGroupForSnap(state.index.activeSnap);
  }
  getSlideForSnap(snapIndex) {
    return this.api.internal.state.dom.logicalGroups[snapIndex] || 0;
  }
  getSnapForSlide(slideIndex) {
    const normIndex = this.api.internal.renderer.normalizeIndex(slideIndex);
    const groups = this.api.internal.state.dom.logicalGroups;
    if (!groups || groups.length === 0) return 0;
    let result = 0;
    for (let i = 0; i < groups.length; i++) { if (groups[i] <= normIndex) result = i; else break; }
    return result;
  }
  getGroupForSnap(snapIndex) { return snapIndex; }
  getSnapForGroup(groupIndex) { return groupIndex; }
}
CarouselRegistry.registerSnap({ name: 'group-snap', classRef: GroupSnapEngine });
// snaps/group.js END

// ==========================================
// inputs/drag.js START
// ==========================================
CarouselRegistry.registerInput({
  name: 'drag',
  init: (api) => {
    let _dragSurface = null;
    const onLoopReposition = (api, payload) => {
      const state = api.internal.state;
      if (state.flags.isDraggingActive) {
        state.drag.startCurrentPos += payload.delta;
      }
    };
    const getPointerPos = (e) => api.options.vertical ? e.clientY : e.clientX;
    const snapToClosest = (immediate = false, force = false) => {
      const state = api.internal.state;
      const closestIndex = api.internal.snapEngine.findNearestSnap(state.position.target);

      if (api.options.dragFree) {
         const rawSnap = api.internal.snapEngine.getSnap(closestIndex);
         state.position.target = api.internal.renderer.resolveTarget(rawSnap, state.position.current);

         if (immediate) {
           state.position.current = state.position.target;
           const transformVal = api.getTransformValue();
           api.track.style.transform = api.options.vertical ? `translate3d(0, ${transformVal}px, 0)` : `translate3d(${transformVal}px, 0, 0)`;
           if (!state.flags.isSettled) { state.flags.isSettled = true; api.internal.events.emit(EVENTS.SETTLE); }
         } else {
           if (state.flags.isSettled) { state.flags.isSettled = false; api.internal.physics.startPhysicsLoop(); }
         }
      } else {
         api.internal.navigation.goToSnap(closestIndex, immediate, force);
      }
    };
    const onPointerDown = (e) => {
      const state = api.internal.state;
      if (e.button !== 0 || state.flags.isPaused || state.flags.isFrozen) return; 
      state.flags.isDraggingActive = true; state.drag.active = true;
      state.drag.startPointer = getPointerPos(e); state.drag.startTargetPos = state.position.target;
      state.drag.activePointerId = e.pointerId; state.flags.isClickSuppressed = false;

      state.position.target = state.position.current;
      state.drag.startPos = getPointerPos(e); state.drag.startCurrentPos = state.position.current;
      state.drag.lastPointerPos = getPointerPos(e); state.drag.lastPointerTime = Environment.now();
      state.physics.velocity = 0; state.physics.inertia = 0; 

      try { if (_dragSurface) _dragSurface.setPointerCapture(e.pointerId); } catch (err) {}
      api.track.style.cursor = 'grabbing';
      if (Environment.hasDOM()) {
        window.addEventListener('pointermove', onPointerMove);
        window.addEventListener('pointerup', onPointerUp);
        window.addEventListener('pointercancel', onPointerUp);
      }
      if (state.flags.isSettled) { state.flags.isSettled = false; api.internal.physics.startPhysicsLoop(); }
      api.internal.events.emit(EVENTS.DRAG_START);
      e.preventDefault(); 
    };
    const onPointerMove = (e) => {
      const state = api.internal.state;
      if (!state.flags.isDraggingActive) return;
      const currentPointer = getPointerPos(e);
      let dragDistance = state.drag.startPos - currentPointer;
      if (!api.options.vertical) dragDistance *= api.dir;
      if (Math.abs(dragDistance) > api.options.dragThreshold) state.flags.isClickSuppressed = true;

      const now = Environment.now();
      const dt = now - state.drag.lastPointerTime;
      if (dt > 0) {
        let rawVel = (state.drag.lastPointerPos - currentPointer) / dt;
        if (!api.options.vertical) rawVel *= api.dir;
        state.physics.velocity = rawVel;
      }
      state.drag.lastPointerPos = currentPointer; state.drag.lastPointerTime = now;

      let newTarget = state.drag.startCurrentPos + dragDistance;
      if (!api.internal.renderer.isLoopActive()) {
        if (newTarget < 0) newTarget *= 0.3;
        else if (newTarget > state.metrics.maxScroll) newTarget = state.metrics.maxScroll + ((newTarget - state.metrics.maxScroll) * 0.3);
      }
      state.position.target = newTarget;
      if (state.drag.active) {
        const nearestSnap = api.internal.snapEngine.findNearestSnap(state.position.target);
        const nearestSlide = api.internal.snapEngine.getSlideForSnap(nearestSnap);
        const nearestGroup = api.internal.snapEngine.getGroupForSnap(nearestSnap);

        if (nearestSlide !== state.preview.index || nearestGroup !== state.preview.group) {
          state.preview.index = nearestSlide;
          state.preview.group = nearestGroup;
          api.internal.events.emit(EVENTS.PREVIEW_UPDATE);
        }
      }
      if (state.flags.isSettled) { state.flags.isSettled = false; api.internal.physics.startPhysicsLoop(); }
      api.internal.events.emit(EVENTS.DRAG_MOVE);
    };
    const onPointerUp = (e) => {
      const state = api.internal.state;
      if (!state.flags.isDraggingActive) return;
      state.flags.isDraggingActive = false; state.drag.active = false;
      setTimeout(() => { state.flags.isClickSuppressed = false; }, 50);

      const pid = e && e.pointerId !== undefined ? e.pointerId : state.drag.activePointerId;
      if (pid !== undefined) { try { if (_dragSurface) _dragSurface.releasePointerCapture(pid); } catch(err) {} }
      state.drag.activePointerId = undefined; api.track.style.cursor = '';

      if (Environment.hasDOM()) {
        window.removeEventListener('pointermove', onPointerMove);
        window.removeEventListener('pointerup', onPointerUp);
        window.removeEventListener('pointercancel', onPointerUp);
      }
      api.internal.events.emit(EVENTS.DRAG_END);

      if (api.reducedMotion) {
        state.physics.inertia = 0;
        snapToClosest();
        return;
      }
      if (api.options.dragFree) {
        state.physics.inertia = state.physics.velocity * api.options.dragInertia; 
      } else {
        if (Math.abs(state.physics.velocity) > api.options.velocityThreshold) {
          state.physics.velocity > 0 ? api.internal.navigation.scrollNext() : api.internal.navigation.scrollPrev();
        } else {
          snapToClosest();
        }
      }
    };
    const onClick = (e) => { if (api.internal.state.flags.isClickSuppressed) { e.preventDefault(); e.stopPropagation(); } };
    const abortDrag = () => {
      const state = api.internal.state;
      state.flags.isDraggingActive = false; state.drag.active = false; state.flags.isClickSuppressed = false; api.track.style.cursor = '';
      if (Environment.hasDOM()) {
        window.removeEventListener('pointermove', onPointerMove);
        window.removeEventListener('pointerup', onPointerUp);
        window.removeEventListener('pointercancel', onPointerUp);
      }
      if (state.drag.activePointerId !== undefined) {
        try { if (_dragSurface) _dragSurface.releasePointerCapture(state.drag.activePointerId); } catch (err) {}
        state.drag.activePointerId = undefined;
      }
      api.internal.events.emit(EVENTS.DRAG_END);
      snapToClosest(true, true);
    };
    const viewport = api.root.querySelector('.yd_viewport') || api.root;
    _dragSurface = viewport;
    _dragSurface.addEventListener('pointerdown', onPointerDown);
    api.track.addEventListener('click', onClick, { capture: true });

    api.root.addEventListener('mouseenter', api.onActivate);
    api.root.addEventListener('focusin', api.onActivate);
    api.root.addEventListener('mouseleave', api.onDeactivate);
    api.root.addEventListener('focusout', api.onDeactivate);
    _dragSurface.addEventListener('pointerdown', api.onActivate);
    api.internal.events.on(EVENTS.LOOP_REPOSITION, onLoopReposition);
    api.internal.events.on('internal:abort-drag', abortDrag);
    return {
      destroy: () => {
        api.internal.events.off(EVENTS.LOOP_REPOSITION, onLoopReposition);
        api.internal.events.off('internal:abort-drag', abortDrag);
        if (_dragSurface) {
          _dragSurface.removeEventListener('pointerdown', onPointerDown);
          _dragSurface.removeEventListener('pointerdown', api.onActivate);
        }
        api.track.removeEventListener('click', onClick, { capture: true });
        if (Environment.hasDOM()) {
          window.removeEventListener('pointermove', onPointerMove);
          window.removeEventListener('pointerup', onPointerUp);
          window.removeEventListener('pointercancel', onPointerUp);
        }
        api.root.removeEventListener('mouseenter', api.onActivate);
        api.root.removeEventListener('focusin', api.onActivate);
        api.root.removeEventListener('mouseleave', api.onDeactivate);
        api.root.removeEventListener('focusout', api.onDeactivate);
      }
    };
  }
});
// inputs/drag.js END

// ==========================================
// inputs/keyboard.js START
// ==========================================
CarouselRegistry.registerInput({
  name: 'keyboard',
  init: (api) => {
    const state = api.internal.state;
    if (!api.options.keyboard) return { destroy: () => {} };
    if (!state.flags._keyboardRegistered) {
      CarouselRegistry._keyboardUsers++;
      state.flags._keyboardRegistered = true;
    }
    if (!CarouselRegistry._keyboardInitialized) {
      if (Environment.hasDOM()) document.addEventListener('keydown', CarouselRegistry._globalKeyDownHandler);
      CarouselRegistry._keyboardInitialized = true;
    }
    api.root.setAttribute('tabindex', '0');
    const onKeyDown = (api, payload) => {
      const e = payload.originalEvent;
      if ((CarouselRegistry.activeCarousel && CarouselRegistry.activeCarousel !== api) || state.flags.isPaused || state.flags.isFrozen) return;
      const activeElement = Environment.hasDOM() ? document.activeElement : null;
      if (activeElement) {
        const isInputTag = ['INPUT', 'TEXTAREA', 'SELECT', 'OPTION'].includes(activeElement.tagName);
        if (isInputTag || activeElement.isContentEditable) return; 
      }
      const keys = ['Home', 'End', 'PageDown', 'PageUp', 'ArrowRight', 'ArrowLeft', 'ArrowDown', 'ArrowUp'];
      if (keys.includes(e.key)) e.preventDefault();

      const isVert = api.options.vertical;
      if (e.key === 'Home') api.internal.navigation.goToSnap(0);
      if (e.key === 'End') api.internal.navigation.goToSnap(api.internal.snapEngine.maxReachableSnap());
      if (e.key === 'PageDown') api.internal.navigation.scrollNext();
      if (e.key === 'PageUp') api.internal.navigation.scrollPrev();
      if (e.key === 'ArrowRight' && !isVert) api.isRTL ? api.internal.navigation.scrollPrev() : api.internal.navigation.scrollNext();
      if (e.key === 'ArrowLeft' && !isVert) api.isRTL ? api.internal.navigation.scrollNext() : api.internal.navigation.scrollPrev();
      if (e.key === 'ArrowDown' && isVert) api.internal.navigation.scrollNext();
      if (e.key === 'ArrowUp' && isVert) api.internal.navigation.scrollPrev();
    };
    api.internal.events.on('internal:keydown', onKeyDown);
    return {
      destroy: () => {
        api.internal.events.off('internal:keydown', onKeyDown);
        if (!state.flags._keyboardRegistered) return;
        CarouselRegistry._keyboardUsers--;
        state.flags._keyboardRegistered = false;
        if (CarouselRegistry._keyboardUsers <= 0) {
          if (Environment.hasDOM()) document.removeEventListener('keydown', CarouselRegistry._globalKeyDownHandler);
          CarouselRegistry._keyboardInitialized = false;
          CarouselRegistry._keyboardUsers = 0;
        }
      }
    };
  }
});
// inputs/keyboard.js END

// ==========================================
// inputs/wheel.js START
// ==========================================
CarouselRegistry.registerInput({
  name: 'wheel',
  init: (api) => {
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
});
// inputs/wheel.js END

// ==========================================
// behaviors/autoplay.js START
// ==========================================
CarouselRegistry.registerBehavior({
  name: 'autoplay',
  init: (api) => {
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

      if (!api.internal.state.metrics.snapPoints.length) { playTimer = setTimeout(() => play(), 100); return; }
      if (!(direction === 1 ? api.internal.snapEngine.canScrollNext() : api.internal.snapEngine.canScrollPrev())) { if (apProgressEl) apProgressEl.style.setProperty('--ap-progress', `100%`); stopPermanent(); return; }
      startTime = Environment.now(); loopProgress();
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
    api.internal.extensions.on('autoplay', EVENTS.NAV_BEFORE, onBeforeSelect); api.internal.extensions.on('autoplay', EVENTS.DRAG_START, onDragStart); api.internal.extensions.on('autoplay', EVENTS.DRAG_END, onDragEnd); api.internal.extensions.on('autoplay', EVENTS.SETTLE, onSettle); api.internal.extensions.on('autoplay', EVENTS.PAUSE, onApiPause); api.internal.extensions.on('autoplay', EVENTS.RESUME, onApiResume); api.internal.extensions.on('autoplay', EVENTS.FREEZE, onApiPause); api.internal.extensions.on('autoplay', EVENTS.UNFREEZE, onApiResume);
    if (api.root.classList.contains('pause-hover')) { api.root.addEventListener('mouseenter', stop); api.root.addEventListener('mouseleave', play); }
    if (Environment.hasDOM()) document.addEventListener('visibilitychange', onVisChange);
    api.root.addEventListener('focusin', onFocusIn); api.root.addEventListener('focusout', onFocusOut);
    if (typeof requestAnimationFrame === 'function') requestAnimationFrame(play);
    return { destroy: () => {
      stop(); if (!permanentlyStopped) api.internal.events.emit(EVENTS.AUTOPLAY_STOP);
      delete api.autoplayApi; delete api.resetAutoplay;
      api.root.removeEventListener('mouseenter', stop); api.root.removeEventListener('mouseleave', play);
      if (Environment.hasDOM()) document.removeEventListener('visibilitychange', onVisChange);
      api.root.removeEventListener('focusin', onFocusIn); api.root.removeEventListener('focusout', onFocusOut);
    }};
  }
});
// behaviors/autoplay.js END

// ==========================================
// behaviors/hash.js START
// ==========================================
CarouselRegistry.registerBehavior({
  name: 'hash',
  init: (api) => {
    let isSync = false;
    const hashGroup = api.root.dataset.hashGroup;
    const oH = () => { if(isSync) return; const h = window.location.hash.replace('#',''); let slideHash = h; if(hashGroup) { if(h.startsWith(`${hashGroup}:`)) slideHash = h.split(':')[1]; else return; } const idx = api.internal.renderer.resolveHash(slideHash); if(idx>-1 && idx!==api.internal.state.index.current){ isSync=true; api.internal.navigation.goToSnap(api.internal.snapEngine.getSnapForSlide(idx)); isSync=false; } };
    const oS = (a,p) => { if(isSync || a.root.dataset.hashUpdate === 'false') return; const h = a.internal.renderer.getHashByIndex(p.currentIndex); if(h){ isSync=true; history.replaceState(null,null,hashGroup ? `#${hashGroup}:${h}` : `#${h}`); isSync=false; } };
    window.addEventListener('hashchange', oH); api.internal.extensions.on('hash', EVENTS.NAV_AFTER, oS); setTimeout(oH, 0);
    return { destroy: () => { window.removeEventListener('hashchange', oH); } };
  }
});
// behaviors/hash.js END

// ==========================================
// behaviors/sync.js START
// ==========================================
CarouselRegistry.registerBehavior({
  name: 'sync',
  init: (api) => {
    const targetSelector = api.root.dataset.sync;
    const syncGroup = api.root.dataset.syncGroup;
    const syncBy = api.root.dataset.syncBy || 'slide'; 
    const syncRole = api.root.dataset.syncRole; 

    const getTargets = () => {
      const targetSet = new Set();
      
      if (targetSelector) {
        let selector = targetSelector;
        if (!selector.startsWith('#') && !selector.startsWith('.') && !selector.startsWith('[')) {
          selector = `#${selector}`;
        }
        try {
          document.querySelectorAll(selector).forEach(el => {
            if (el && el.__ydCarousel && el.__ydCarousel !== api) {
              targetSet.add(el.__ydCarousel);
            }
          });
        } catch (err) {
          console.warn(`[ydCarousel] Invalid sync selector: ${selector}`);
        }
      }
      
      if (syncGroup) {
        CarouselRegistry._instances.forEach(instance => {
          if (instance !== api && instance.root.dataset.syncGroup === syncGroup) {
            targetSet.add(instance);
          }
        });
      }
      
      return [...targetSet];
    };

    const onNav = (sourceApi, payload) => {
      if (sourceApi.internal.state.flags._isReceivingSync) return;
      
      const targets = getTargets();
      if (!targets.length) return;

      sourceApi.internal.events.emit(EVENTS.SYNC_START);

      targets.forEach(t => {
try {
          t.internal.state.flags._isReceivingSync = true;
          t.internal.events.emit(EVENTS.SYNC_UPDATE, { source: sourceApi });
          
          const maxSlide = Math.max(0, t.slideCount() - 1);
          // THE FIX: Floor clamped to 0 to prevent bizarre negative indexing edge-cases
          const safeIndex = Math.max(0, Math.min(payload.currentIndex, maxSlide));

          if (syncBy === 'group') {
            const targetSnap = t.internal.snapEngine.getSnapForSlide(safeIndex);
            const targetGroup = t.internal.snapEngine.getGroupForSnap(targetSnap);
            t.goToGroup(targetGroup);
          } else {
            t.goToSlide(safeIndex);
          }
        } finally {
          t.internal.state.flags._isReceivingSync = false;
        }
      });

      sourceApi.internal.events.emit(EVENTS.SYNC_STOP);
    };

    const onThumbnailClick = (e) => {
      if (api.internal.state.flags.isClickSuppressed) return;
      
      const slideEl = e.target.closest('.yd_slide');
      if (!slideEl) return;
      
      const idx = parseInt(slideEl.getAttribute('data-slide-index'), 10);
      if (isNaN(idx)) return;
      
      const master = getTargets().find(t => t !== api && t.root.dataset.syncRole !== 'thumbnail');
      if (master) {
        master.goToSlide(idx);
        const originalSlide = api.internal.renderer.getVisibleElement(idx);
        if (originalSlide) {
          originalSlide.focus({ preventScroll: true });
        }
      }
    };

    const onThumbnailKeydown = (e) => {
      const slideEl = e.target.closest('.yd_slide');
      if (!slideEl || slideEl.classList.contains('yd_slide-clone')) return;
      
      const idx = parseInt(slideEl.getAttribute('data-slide-index'), 10);
      if (isNaN(idx)) return;
      
      const isVert = api.options.vertical;
      const isRTL = api.isRTL;
      const total = api.internal.renderer.slideCount();
      let nextIdx = idx;
      let handled = false;

      switch (e.key) {
        case 'Enter':
        case ' ':
          e.preventDefault();
          slideEl.click();
          handled = true;
          break;
        case 'ArrowLeft':
          if (!isVert) { nextIdx = isRTL ? idx + 1 : idx - 1; handled = true; }
          break;
        case 'ArrowRight':
          if (!isVert) { nextIdx = isRTL ? idx - 1 : idx + 1; handled = true; }
          break;
        case 'ArrowUp':
          if (isVert) { nextIdx = idx - 1; handled = true; }
          break;
        case 'ArrowDown':
          if (isVert) { nextIdx = idx + 1; handled = true; }
          break;
        case 'Home':
          nextIdx = 0; handled = true;
          break;
        case 'End':
          nextIdx = total - 1; handled = true;
          break;
      }

      if (handled && e.key !== 'Enter' && e.key !== ' ') {
        e.preventDefault();
        nextIdx = Math.max(0, Math.min(nextIdx, total - 1));
        
        if (nextIdx !== idx) {
          const master = getTargets().find(t => t !== api && t.root.dataset.syncRole !== 'thumbnail');
          if (master) {
            master.goToSlide(nextIdx);
            const nextSlide = api.internal.renderer.getVisibleElement(nextIdx);
            if (nextSlide) nextSlide.focus({ preventScroll: true });
          }
        }
      }
    };

    api.internal.extensions.on('sync', EVENTS.NAV, onNav);

    if (syncRole === 'thumbnail') {
      api.track.addEventListener('click', onThumbnailClick, { capture: true });
      api.track.addEventListener('keydown', onThumbnailKeydown);
      api.root.classList.add('yd_carousel-thumbnail-mode');

      const bootSync = () => {
        const master = getTargets().find(t => t !== api && t.root.dataset.syncRole !== 'thumbnail');
        if (master) {
          api.goToSlide(master.internal.state.index.current, true);
        }
      };

      if (api.isReady()) bootSync();
      else api.internal.events.once(EVENTS.INIT, bootSync);
    }
    
    return {
      destroy: () => {
        if (syncRole === 'thumbnail') {
          api.track.removeEventListener('click', onThumbnailClick, { capture: true });
          api.track.removeEventListener('keydown', onThumbnailKeydown);
          api.root.classList.remove('yd_carousel-thumbnail-mode');
        }
      }
    };
  }
});
// behaviors/sync.js END

// ==========================================
// plugins/controls.js START
// ==========================================
CarouselRegistry.registerPlugin({
  name: 'controls',
  init: (api) => {
    const p = api.root.querySelector('.yd_prev'); const n = api.root.querySelector('.yd_next');
    const hP = () => { if(!api.internal.state.flags.isPaused && !api.internal.state.flags.isFrozen) api.internal.navigation.scrollPrev(); };
    const hN = () => { if(!api.internal.state.flags.isPaused && !api.internal.state.flags.isFrozen) api.internal.navigation.scrollNext(); };
    if (p) { p.addEventListener('click', hP); p.setAttribute('aria-controls', api.track.id); }
    if (n) { n.addEventListener('click', hN); n.setAttribute('aria-controls', api.track.id); }
    return { destroy: () => { if(p) p.removeEventListener('click', hP); if(n) n.removeEventListener('click', hN); } };
  }
});
// plugins/controls.js END

// ==========================================
// plugins/dots.js START
// ==========================================
CarouselRegistry.registerPlugin({
  name: 'dots',
  init: (api) => {
    const c = api.root.querySelector('.yd_dots'); if (!c) return { destroy: ()=>{} };
    let t = c.querySelector('.yd_dot'); 
    const originalTemplate = t ? t.cloneNode(true) : null;
    c.setAttribute('role', 'tablist'); 
    c.setAttribute('aria-orientation', api.options.vertical ? 'vertical' : 'horizontal');

    const onDotClick = (e) => {
      if (api.internal.state.flags.isPaused || api.internal.state.flags.isFrozen) return;
      const dot = e.target.closest('[data-dot-index]');
      if (!dot) return;
      const idx = parseInt(dot.getAttribute('data-dot-index'), 10);
      if (!isNaN(idx)) api.internal.navigation.goToSnap(idx);
    };
    c.addEventListener('click', onDotClick);

    let lastTotal = 0;

    const build = () => {
      c.innerHTML = '';
      const total = api.internal.snapEngine.getSnapCount();
      const fragment = document.createDocumentFragment();
      new Array(total).fill(0).forEach((_, i) => {
        let d = originalTemplate ? originalTemplate.cloneNode(true) : document.createElement('button'); 
        if(!originalTemplate) d.className='yd_dot';
        d.setAttribute('role','tab'); 
        d.setAttribute('aria-controls', api.track.id); 
        d.setAttribute('aria-label', `Go ${i+1}`);
        d.setAttribute('data-dot-index', i);
        fragment.appendChild(d);
      });
      c.appendChild(fragment);
    };

    const uD = () => {
      const aI = api.internal.state.index.activeSnap;
      Array.from(c.children).forEach((d, i) => { 
        const a = i === aI; 
        d.classList.toggle('active', a); 
        d.setAttribute('aria-selected', a); 
        d.setAttribute('tabindex', a?'0':'-1'); 
      });
    };

    const rebuildIfNeeded = () => {
      const total = api.internal.snapEngine.getSnapCount();
      if (total !== lastTotal) { 
        build(); 
        lastTotal = total; 
      }
      uD();
    };

    api.internal.extensions.on('dots', EVENTS.NAV_AFTER, uD); 
    api.internal.extensions.on('dots', EVENTS.SNAP_CHANGE, uD); 
    api.internal.extensions.on('dots', EVENTS.RESIZE, rebuildIfNeeded); 

    lastTotal = api.internal.snapEngine.getSnapCount();
    build(); 
    uD();

    return { 
      destroy: () => { c.removeEventListener('click', onDotClick); }, 
      refresh: () => { rebuildIfNeeded(); }
    };
  }
});
// plugins/dots.js END

// ==========================================
// plugins/counter.js START
// ==========================================
CarouselRegistry.registerPlugin({
  name: 'counter',
  init: (api) => {
    const c = api.root.querySelector('.yd_counter'); if (!c) return { destroy: ()=>{} };
    const cu = c.querySelector('.yd_current'), t = c.querySelector('.yd_total');

    const uC = () => {
      const state = api.internal.state;
      const tot = Math.max(1, api.internal.snapEngine.getSnapCount());
      const cur = Math.min(state.index.activeSnap + 1, tot);

      if (cu && t) { 
        cu.textContent = cur; 
        t.textContent = tot; 
      } else { 
        c.textContent = `${cur} / ${tot}`; 
      }
    };
    api.internal.extensions.on('counter', EVENTS.NAV_AFTER, uC); 
    api.internal.extensions.on('counter', EVENTS.SNAP_CHANGE, uC); 
    api.internal.extensions.on('counter', EVENTS.RESIZE, uC); 

    uC();

    return { destroy: () => {}, refresh: () => { uC(); } };
  }
});
// plugins/counter.js END

// ==========================================
// plugins/scrollbar.js START
// ==========================================
CarouselRegistry.registerPlugin({
  name: 'scrollbar',
  init: (api) => {
    const s = api.root.querySelector('.yd_scrollbar'); 
    if (!s) return { destroy: ()=>{} };
    
    const pD = s.style.display;
    if (api.options.loop) { 
      s.style.display = 'none'; 
      return { destroy: () => { s.style.display = pD; } }; 
    }
    
    let th = s.querySelector('.yd_scrollbar-thumb'); 
    if (!th) { 
      th = document.createElement('div'); 
      th.className = 'yd_scrollbar-thumb'; 
      s.appendChild(th); 
    }

    // THE FIX: ARIA Slider Semantics & Keyboard Focus
    th.setAttribute('role', 'slider');
    th.setAttribute('aria-valuemin', '0');
    th.setAttribute('aria-valuemax', '100');
    th.setAttribute('tabindex', '0');
    th.setAttribute('aria-label', 'Carousel Scrollbar');

    let maxThumbScroll = 0;
    
    const uS = () => {
      if (api.internal.state.metrics.realTrackSize <= api.internal.state.metrics.viewportSize) { 
        s.classList.add('disabled'); 
        th.style.transform = 'translate3d(0,0,0)'; 
      } else { 
        s.classList.remove('disabled'); 
        const r = api.internal.state.metrics.viewportSize / (api.internal.state.metrics.realTrackSize || 1); 
        const p = `${Math.max(10, Math.min(100, r * 100))}%`; 
        if (api.options.vertical) th.style.height = p; 
        else th.style.width = p; 
      }
    };

    // THE FIX: rAF Throttling for High-Frequency Layout Updates
    let pending = false;
    const uP = () => { 
      if (s.classList.contains('disabled') || pending) return; 
      pending = true;
      requestAnimationFrame(() => {
        pending = false;
        if (api.internal.state.flags.destroyed) return;
        
        maxThumbScroll = api.options.vertical ? s.offsetHeight - th.offsetHeight : s.offsetWidth - th.offsetWidth; 
        
        let v = api.internal.renderer.getScrollProgress(); 
        let visualV = v;
        if (api.isRTL && !api.options.vertical) visualV = 1 - v; 

        // THE FIX: ARIA valuenow synchronization
        th.setAttribute('aria-valuenow', Math.round(v * 100));

        if (api.options.vertical) th.style.transform = `translate3d(0,${visualV * maxThumbScroll}px,0)`; 
        else th.style.transform = `translate3d(${visualV * maxThumbScroll}px,0,0)`; 
      });
    };

    // THE FIX: Interactive Mouse/Touch Scrubbing Variables
    let dragging = false;
    let dragStart = 0;
    let thumbStart = 0;

    const onPointerDown = (e) => {
      if (e.button !== 0 || api.internal.state.flags.isPaused || api.internal.state.flags.isFrozen) return;
      e.preventDefault();
      dragging = true;
      
      maxThumbScroll = api.options.vertical ? s.offsetHeight - th.offsetHeight : s.offsetWidth - th.offsetWidth;
      dragStart = api.options.vertical ? e.clientY : e.clientX;
      
      let v = api.internal.renderer.getScrollProgress();
      if (api.isRTL && !api.options.vertical) v = 1 - v;
      thumbStart = v * maxThumbScroll;
      
      th.setPointerCapture(e.pointerId);
    };

    const onPointerMove = (e) => {
      if (!dragging) return;
      
      const currentPointer = api.options.vertical ? e.clientY : e.clientX;
      const delta = currentPointer - dragStart;
      
      let newThumbPos = thumbStart + delta;
      newThumbPos = Math.max(0, Math.min(newThumbPos, maxThumbScroll));

      let ratio = maxThumbScroll > 0 ? newThumbPos / maxThumbScroll : 0;
      if (api.isRTL && !api.options.vertical) ratio = 1 - ratio;

      // Update physical target and wake the physics engine for smooth scrubbing
      const targetPos = ratio * api.internal.state.metrics.maxScroll;
      api.internal.state.position.target = targetPos;
      
      if (api.internal.state.flags.isSettled) {
        api.internal.state.flags.isSettled = false;
        api.internal.physics.startPhysicsLoop();
      }
    };

    const onPointerUp = (e) => {
      if (!dragging) return;
      dragging = false;
      th.releasePointerCapture(e.pointerId);
      
      // THE FIX: Snap to closest valid layout position on release
      const nearestSnap = api.internal.snapEngine.findNearestSnap(api.internal.state.position.target);
      api.internal.navigation.goToSnap(nearestSnap);
    };

    const onTrackClick = (e) => {
      if (e.target === th || dragging || api.internal.state.flags.isPaused || api.internal.state.flags.isFrozen) return;
      
      const sRect = s.getBoundingClientRect();
      const clickPos = api.options.vertical ? (e.clientY - sRect.top) : (e.clientX - sRect.left);
      const thSize = api.options.vertical ? th.offsetHeight : th.offsetWidth;
      
      maxThumbScroll = api.options.vertical ? s.offsetHeight - th.offsetHeight : s.offsetWidth - th.offsetWidth;
      let newThumbPos = clickPos - (thSize / 2);
      newThumbPos = Math.max(0, Math.min(newThumbPos, maxThumbScroll));
      
      let ratio = maxThumbScroll > 0 ? newThumbPos / maxThumbScroll : 0;
      if (api.isRTL && !api.options.vertical) ratio = 1 - ratio;

      const targetPos = ratio * api.internal.state.metrics.maxScroll;
      const nearestSnap = api.internal.snapEngine.findNearestSnap(targetPos);
      api.internal.navigation.goToSnap(nearestSnap);
    };

    const onThumbKeydown = (e) => {
      if (api.internal.state.flags.isPaused || api.internal.state.flags.isFrozen) return;
      const keys = ['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 'Home', 'End'];
      if (!keys.includes(e.key)) return;
      e.preventDefault();
      
      const isVert = api.options.vertical;
      const isRTL = api.isRTL;
      
      if (e.key === 'Home') api.internal.navigation.goToSnap(0);
      if (e.key === 'End') api.internal.navigation.goToSnap(api.internal.snapEngine.maxReachableSnap());
      if (e.key === 'ArrowRight' && !isVert) isRTL ? api.internal.navigation.scrollPrev() : api.internal.navigation.scrollNext();
      if (e.key === 'ArrowLeft' && !isVert) isRTL ? api.internal.navigation.scrollNext() : api.internal.navigation.scrollPrev();
      if (e.key === 'ArrowDown' && isVert) api.internal.navigation.scrollNext();
      if (e.key === 'ArrowUp' && isVert) api.internal.navigation.scrollPrev();
    };

    api.internal.extensions.on('scrollbar', EVENTS.RESIZE, uS); 
    api.internal.extensions.on('scrollbar', EVENTS.SCROLL, uP); 
    
    // Wire up interactions
    th.addEventListener('pointerdown', onPointerDown);
    th.addEventListener('pointermove', onPointerMove);
    th.addEventListener('pointerup', onPointerUp);
    th.addEventListener('pointercancel', onPointerUp);
    th.addEventListener('keydown', onThumbKeydown);
    s.addEventListener('click', onTrackClick);
    
    uS(); 
    uP();

    return { 
      destroy: () => { 
        s.style.display = pD; 
        th.removeEventListener('pointerdown', onPointerDown);
        th.removeEventListener('pointermove', onPointerMove);
        th.removeEventListener('pointerup', onPointerUp);
        th.removeEventListener('pointercancel', onPointerUp);
        th.removeEventListener('keydown', onThumbKeydown);
        s.removeEventListener('click', onTrackClick);
        th.removeAttribute('role');
        th.removeAttribute('aria-valuemin');
        th.removeAttribute('aria-valuemax');
        th.removeAttribute('aria-valuenow');
        th.removeAttribute('tabindex');
      }, 
      refresh: () => { uS(); uP(); } 
    };
  }
});
// plugins/scrollbar.js END

// ==========================================
// plugins/progress.js START
// ==========================================
CarouselRegistry.registerPlugin({
  name: 'progress',
  init: (api) => {
    const p = api.root.querySelector('.yd_progress'); if (!p) return { destroy: ()=>{} };
    const uPr = () => { p.style.setProperty('--progress', `${api.internal.renderer.getVisualProgress() * 100}%`); };
    api.internal.extensions.on('progress', EVENTS.SCROLL, uPr); uPr();
    return { destroy: () => {}, refresh: () => { uPr(); } };
  }
});
// plugins/progress.js END

// ==========================================
// index.js START
// ==========================================
if (Environment.hasDOM()) document.addEventListener('DOMContentLoaded', () => ydCarousel.startAutoInit());
// index.js END
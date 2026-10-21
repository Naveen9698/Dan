/**
 * ydAnimation 1.0 - DECLARATIVE MICROKERNEL ANIMATION ENGINE
 * Architecture: Isolated IIFE, Independent Transforms, Channel Collision Detection, Safe Parsers
 */

const ydAnimation = (() => {

  // ==========================================
  // core/constants.js
  // ==========================================
  const DEFAULT_MODIFIERS = Object.freeze({
    duration: 500, delay: 0, ease: 'ease', repeat: 1, direction: 'normal', fill: 'both',
    amount: null, angle: null, distance: 50, origin: 'center'
  });

  class AnimEnvironment {
    static hasDOM() { return typeof window !== 'undefined' && typeof document !== 'undefined'; }
  }

  // ==========================================
  // core/registry.js
  // ==========================================
  class AnimRegistry {
    static effects = new Map();
    static triggers = new Map();
    
    // THE FIX: Effects now declare their metadata/channels upon registration
    static registerEffect(name, config) { this.effects.set(name, config); }
    static registerTrigger(prefix, handlerClass) { this.triggers.set(prefix, handlerClass); }
  }

  // ==========================================
  // core/parser.js
  // ==========================================
  class AnimParser {
    static getTriggerRegex() {
      const triggerKeys = Array.from(AnimRegistry.triggers.keys()).join('|');
      return new RegExp(`^(${triggerKeys}):([a-z-]+)$`);
    }

    static parse(element) {
      const classes = Array.from(element.classList);
      const config = { effects: {}, triggers: {} };
      const triggerRegex = this.getTriggerRegex();
      
      // 1. Identify Triggers & Base Effects
      classes.forEach(cls => {
        const match = cls.match(triggerRegex);
        if (match) {
          const trigger = match[1];
          const effectName = match[2];
          const baseEffect = effectName.split('-')[0];
          
          // Last declaration wins (overwrites previous of same baseEffect)
          config.effects[baseEffect] = { trigger, effectName, modifiers: { ...DEFAULT_MODIFIERS } };
          if (!config.triggers[trigger]) config.triggers[trigger] = { config: {} };
        }
      });

      // 2. Identify Modifiers
      classes.forEach(cls => {
        // THE FIX: Safe colon parsing (indexOf) allows complex values like URL or cubic-bezier(...)
        const idx = cls.indexOf(':');
        if (idx === -1) return;
        
        const namespace = cls.substring(0, idx);
        const keyval = cls.substring(idx + 1);
        
        if (config.effects[namespace]) {
          const dashIdx = keyval.indexOf('-');
          if (dashIdx > -1) {
            const key = keyval.substring(0, dashIdx);
            const val = keyval.substring(dashIdx + 1);
            config.effects[namespace].modifiers[key] = this._castValue(key, val);
          }
        }
        
        if (config.triggers[namespace]) {
          const dashIdx = keyval.indexOf('-');
          if (dashIdx > -1) {
            const key = keyval.substring(0, dashIdx);
            const val = keyval.substring(dashIdx + 1);
            config.triggers[namespace].config[key] = val;
          } else {
            config.triggers[namespace].config[keyval] = true; 
          }
        }
      });

      return config;
    }

    static _castValue(key, val) {
      if (val === 'inf') return Infinity;
      if (['duration', 'delay', 'repeat', 'amount', 'angle', 'distance'].includes(key)) return parseFloat(val);
      return val;
    }

    static mapEase(easeToken) {
      const map = {
        'linear': 'linear', 'in': 'ease-in', 'out': 'ease-out', 'in-out': 'ease-in-out',
        'back': 'cubic-bezier(0.175, 0.885, 0.32, 1.275)',
        'bounce': 'cubic-bezier(0.68, -0.55, 0.265, 1.55)'
      };
      return map[easeToken] || easeToken; // Fallback assumes developer passed a raw cubic-bezier(...)
    }
  }

  // ==========================================
  // engine/observer-manager.js
  // ==========================================
  class AnimObserverManager {
    constructor() {
      this.intersectionObserver = null;
      this.trackedElements = new Map(); 
      this.scrollElements = new Set();
      this.scrollRaf = null;
      this._onScroll = this._onScroll.bind(this);
    }

    init() {
      if (!AnimEnvironment.hasDOM()) return;
      
      this.intersectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          const data = this.trackedElements.get(entry.target);
          if (data && data.vi) {
            if (entry.isIntersecting) {
              data.vi.play();
              if (data.vi.config.once) this.untrack(entry.target, 'vi');
            } else {
              if (data.vi.config.replay) data.vi.reverse();
            }
          }
        });
      }, { threshold: [0, 0.5, 1] });

      window.addEventListener('scroll', this._onScroll, { passive: true });
      window.addEventListener('resize', this._onScroll, { passive: true });
    }

    _onScroll() {
      if (this.scrollRaf) return;
      this.scrollRaf = requestAnimationFrame(() => {
        this.scrollRaf = null;
        this._processScrollTick();
      });
    }

    _processScrollTick() {
      const wh = window.innerHeight;
      this.scrollElements.forEach(({ el, trigger }) => {
        const rect = el.getBoundingClientRect();
        const startTrigger = trigger.config.start || 'bottom'; 
        const endTrigger = trigger.config.end || 'top';
        
        let startY = startTrigger === 'top' ? 0 : (startTrigger === 'center' ? wh/2 : wh);
        let endY = endTrigger === 'top' ? 0 : (endTrigger === 'center' ? wh/2 : wh);
        
        const totalRange = startY - endY;
        
        // THE FIX: Gracefully handle identical start/end ranges to prevent Divide By Zero failures
        if (totalRange === 0) {
          console.warn(`[ydAnimation] Scroll trigger on element has 0 range (start: ${startTrigger}, end: ${endTrigger}). Adjusted end constraint to prevent failure.`, el);
          endY -= 1; // Slightest possible adjustment to unbreak the math
        }

        const elementY = rect.top + (rect.height / 2); 
        const currentProgress = startY - elementY;
        
        let progress = currentProgress / (startY - endY);
        progress = Math.max(0, Math.min(1, progress));
        
        trigger.scrub(progress);
      });
    }

    track(element, type, triggerInstance) {
      if (!this.trackedElements.has(element)) this.trackedElements.set(element, {});
      const data = this.trackedElements.get(element);
      data[type] = triggerInstance;

      if (type === 'vi' && this.intersectionObserver) this.intersectionObserver.observe(element);
      if (type === 'sc') { this.scrollElements.add({ el: element, trigger: triggerInstance }); this._processScrollTick(); }
    }

    untrack(element, type) {
      const data = this.trackedElements.get(element);
      if (!data) return;
      
      if (type === 'vi' && this.intersectionObserver) this.intersectionObserver.unobserve(element);
      if (type === 'sc') {
        for (const item of this.scrollElements) {
          if (item.el === element) { this.scrollElements.delete(item); break; }
        }
      }
      
      delete data[type];
      if (Object.keys(data).length === 0) this.trackedElements.delete(element);
    }
  }

  const GlobalAnimObserver = new AnimObserverManager();
  if (AnimEnvironment.hasDOM()) GlobalAnimObserver.init();

  // ==========================================
  // engine/animation-manager.js
  // ==========================================
  class AnimManager {
    constructor(element, baseEffect, config) {
      this.element = element;
      this.config = config;
      this.baseEffect = baseEffect;
      this.animation = null;
      this._build();
    }

    _build() {
      if (!this.element.animate) return; 

      const effectDef = AnimRegistry.effects.get(this.baseEffect);
      if (!effectDef) return;

      const { keyframes, waapiOptions } = effectDef.generator(this.config.effectName, this.config.modifiers);
      
      const options = {
        duration: this.config.modifiers.duration,
        delay: this.config.modifiers.delay,
        easing: AnimParser.mapEase(this.config.modifiers.ease),
        iterations: this.config.modifiers.repeat,
        direction: this.config.modifiers.direction,
        fill: this.config.modifiers.fill,
        ...waapiOptions
      };

      this.animation = this.element.animate(keyframes, options);
      this.animation.pause(); 
    }

    play() { if (this.animation) this.animation.play(); }
    pause() { if (this.animation) this.animation.pause(); }
    reverse() { if (this.animation) { this.animation.reverse(); this.animation.play(); } }
    cancel() { if (this.animation) this.animation.cancel(); }
    scrub(progress) { if (this.animation) this.animation.currentTime = this.config.modifiers.duration * progress; }
  }

  // ==========================================
  // registries/effects.js (Independent Transforms)
  // ==========================================
  
  // THE FIX: First-class Origin Support (top-left -> top left)
  const resolveOrigin = (modOrigin) => typeof modOrigin === 'string' ? modOrigin.replace('-', ' ') : 'center';

  AnimRegistry.registerEffect('fade', {
    channels: ['opacity', 'translate'],
    generator: (effectName, mods) => {
      const d = mods.distance;
      const t = {
        'fade': ['0 0', '0 0'],
        'fade-up': [`0 ${d}px`, `0 0`],
        'fade-down': [`0 -${d}px`, `0 0`],
        'fade-left': [`${d}px 0`, `0 0`],
        'fade-right': [`-${d}px 0`, `0 0`]
      };
      return { 
        keyframes: [ 
          { opacity: 0, translate: t[effectName][0], transformOrigin: resolveOrigin(mods.origin) }, 
          { opacity: 1, translate: t[effectName][1], transformOrigin: resolveOrigin(mods.origin) } 
        ] 
      };
    }
  });

  AnimRegistry.registerEffect('slide', {
    channels: ['translate'],
    generator: (effectName, mods) => {
      const d = mods.distance;
      const t = {
        'slide-up': [`0 ${d}px`, `0 0`],
        'slide-down': [`0 -${d}px`, `0 0`],
        'slide-left': [`${d}px 0`, `0 0`],
        'slide-right': [`-${d}px 0`, `0 0`]
      };
      return { 
        keyframes: [ 
          { translate: t[effectName][0], transformOrigin: resolveOrigin(mods.origin) }, 
          { translate: t[effectName][1], transformOrigin: resolveOrigin(mods.origin) } 
        ] 
      };
    }
  });

  AnimRegistry.registerEffect('scale', {
    channels: ['scale'],
    generator: (effectName, mods) => {
      const amount = mods.amount ? (mods.amount / 100) : (effectName === 'scale-up' ? 0.5 : 1.5);
      return { 
        keyframes: [ 
          { scale: amount, transformOrigin: resolveOrigin(mods.origin) }, 
          { scale: 1, transformOrigin: resolveOrigin(mods.origin) } 
        ] 
      };
    }
  });

  AnimRegistry.registerEffect('zoom', {
    channels: ['opacity', 'scale'],
    generator: (effectName, mods) => {
      const amount = mods.amount ? (mods.amount / 100) : (effectName === 'zoom-in' ? 0.5 : 1.5);
      return { 
        keyframes: [ 
          { scale: amount, opacity: 0, transformOrigin: resolveOrigin(mods.origin) }, 
          { scale: 1, opacity: 1, transformOrigin: resolveOrigin(mods.origin) } 
        ] 
      };
    }
  });

  AnimRegistry.registerEffect('rotate', {
    channels: ['rotate'],
    generator: (effectName, mods) => {
      const a = mods.angle || 90;
      const t = { 'rotate-left': `-${a}deg`, 'rotate-right': `${a}deg` };
      return { 
        keyframes: [ 
          { rotate: t[effectName], transformOrigin: resolveOrigin(mods.origin) }, 
          { rotate: `0deg`, transformOrigin: resolveOrigin(mods.origin) } 
        ] 
      };
    }
  });

  AnimRegistry.registerEffect('flip', {
    channels: ['rotate'],
    generator: (effectName, mods) => {
      const t = { 'flip-x': `x 180deg`, 'flip-y': `y 180deg` };
      return { 
        keyframes: [ 
          { rotate: t[effectName], transformOrigin: resolveOrigin(mods.origin) }, 
          { rotate: `x 0deg` } 
        ] 
      };
    }
  });

  AnimRegistry.registerEffect('blur', {
    channels: ['filter', 'opacity'],
    generator: (effectName, mods) => {
      const map = { 'xs': '2px', 'sm': '4px', 'md': '8px', 'lg': '16px', 'xl': '24px' };
      const val = map[mods.amount] || '8px';
      return { 
        keyframes: effectName === 'blur-in' 
          ? [ { filter: `blur(${val})`, opacity: 0 }, { filter: `blur(0px)`, opacity: 1 } ] 
          : [ { filter: `blur(0px)`, opacity: 1 }, { filter: `blur(${val})`, opacity: 0 } ] 
      };
    }
  });

  // ==========================================
  // registries/triggers.js
  // ==========================================
  class AnimTrigger {
    constructor(element, type, config, animManagers) {
      this.element = element; this.type = type; this.config = config; this.animManagers = animManagers;
    }
    play() { this.animManagers.forEach(m => m.play()); }
    reverse() { this.animManagers.forEach(m => m.reverse()); }
    scrub(progress) { this.animManagers.forEach(m => m.scrub(progress)); }
    destroy() { GlobalAnimObserver.untrack(this.element, this.type); }
  }

  AnimRegistry.registerTrigger('lo', class LoadTrigger extends AnimTrigger {
    init() { requestAnimationFrame(() => this.play()); }
  });

  AnimRegistry.registerTrigger('vi', class ViewportTrigger extends AnimTrigger {
    init() { GlobalAnimObserver.track(this.element, 'vi', this); }
  });

  AnimRegistry.registerTrigger('sc', class ScrollTrigger extends AnimTrigger {
    init() { GlobalAnimObserver.track(this.element, 'sc', this); }
  });

  AnimRegistry.registerTrigger('ho', class HoverTrigger extends AnimTrigger {
    init() {
      this._enterFn = () => this.play();
      this._leaveFn = () => this.reverse();
      this.element.addEventListener('mouseenter', this._enterFn);
      this.element.addEventListener('mouseleave', this._leaveFn);
    }
    destroy() {
      this.element.removeEventListener('mouseenter', this._enterFn);
      this.element.removeEventListener('mouseleave', this._leaveFn);
      super.destroy();
    }
  });

  // ==========================================
  // facade/ydAnimation.js
  // ==========================================
  class ydAnimationFacade {
    static _autoInitObserver = null;

    static initAll(rootNode = document) {
      if (!AnimEnvironment.hasDOM()) return;
      const triggerRegex = AnimParser.getTriggerRegex();

      rootNode.querySelectorAll('*').forEach(el => {
        if (!el.__ydAnimation && Array.from(el.classList).some(cls => triggerRegex.test(cls))) {
          new ydAnimationFacade(el);
        }
      });
    }

    static startAutoInit() {
      if (!AnimEnvironment.hasDOM()) return;
      ydAnimationFacade.initAll(); 
      
      if (typeof MutationObserver !== 'undefined' && !this._autoInitObserver) {
        const triggerRegex = AnimParser.getTriggerRegex();
        this._autoInitObserver = new MutationObserver(mutations => {
          mutations.forEach(m => {
            m.addedNodes.forEach(node => {
              if (node.nodeType === 1) { 
                if (!node.__ydAnimation && Array.from(node.classList).some(cls => triggerRegex.test(cls))) {
                  new ydAnimationFacade(node);
                }
                ydAnimationFacade.initAll(node); 
              }
            });
          });
        });
        this._autoInitObserver.observe(document.body, { childList: true, subtree: true });
      }
    }

    constructor(element) {
      this.root = element;
      this.root.__ydAnimation = this;
      this.parsedConfig = AnimParser.parse(this.root);
      
      this.animations = new Map(); 
      this.triggers = [];
      
      // THE FIX: Collision Detection Registry for DOM Nodes
      this.claimedChannels = new Set();

      // 1. Build Animations
      Object.keys(this.parsedConfig.effects).forEach(baseEffect => {
        const effectConf = this.parsedConfig.effects[baseEffect];
        const effectDef = AnimRegistry.effects.get(baseEffect);
        
        if (effectDef) {
          // Verify capability metadata for channel conflicts
          effectDef.channels.forEach(ch => {
            if (this.claimedChannels.has(ch)) {
              console.warn(`[ydAnimation] Channel conflict: Multiple animation effects are attempting to control the '${ch}' property on the same element.`, this.root);
            }
            this.claimedChannels.add(ch);
          });
          
          const manager = new AnimManager(this.root, baseEffect, effectConf);
          if (!this.animations.has(effectConf.trigger)) this.animations.set(effectConf.trigger, []);
          this.animations.get(effectConf.trigger).push(manager);
        }
      });

      // 2. Attach Triggers
      Object.keys(this.parsedConfig.triggers).forEach(triggerPrefix => {
        const TriggerClass = AnimRegistry.triggers.get(triggerPrefix);
        if (TriggerClass) {
          const managers = this.animations.get(triggerPrefix) || [];
          const tInstance = new TriggerClass(this.root, triggerPrefix, this.parsedConfig.triggers[triggerPrefix].config, managers);
          tInstance.init();
          this.triggers.push(tInstance);
        }
      });
    }

    destroy() {
      this.triggers.forEach(t => t.destroy());
      this.animations.forEach(managers => managers.forEach(m => m.cancel()));
      delete this.root.__ydAnimation;
      this.animations.clear();
      this.claimedChannels.clear();
      this.triggers = [];
    }
  }

  // Auto-initialize robustly
  if (AnimEnvironment.hasDOM()) {
    document.addEventListener('DOMContentLoaded', () => ydAnimationFacade.startAutoInit());
  }

  return ydAnimationFacade;

})();
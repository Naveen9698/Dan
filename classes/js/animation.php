/**
 * ydAnimation 1.1.4 LTS - TRIGGER ENGINE
 * Architecture: Frozen. Safe Mutation Diffs, Validation Severities, Pre-Render Sync.
 */
const ydAnimation = (() => {

  class AnimEnvironment {
    static hasDOM() { return typeof window !== 'undefined' && typeof document !== 'undefined'; }
  }

  // ==========================================
  // REGISTRY 
  // ==========================================
  const EFFECT_CHANNELS = {
    'fade': ['opacity', 'translate'], 'slide': ['translate'],
    'scale': ['scale'], 'zoom': ['opacity', 'scale'], 
    'rotate': ['rotate'], 'flip': ['rotate3d'], 'blur': ['blur'],
    'bounce': ['translate'], 'pulse': ['scale'], 'shake': ['translate'], 
    'wobble': ['translate', 'rotate'], 'swing': ['rotate'], 
    'heartbeat': ['scale'], 'float': ['translate'], 'flash': ['opacity']
  };

  const EFFECT_MODIFIERS = {
    'fade': ['distance', 'duration', 'delay', 'ease'],
    'slide': ['distance', 'duration', 'delay', 'ease'],
    'scale': ['amount', 'origin', 'duration', 'delay', 'ease'],
    'zoom': ['amount', 'origin', 'duration', 'delay', 'ease'],
    'rotate': ['angle', 'origin', 'duration', 'delay', 'ease'],
    'flip': ['origin', 'duration', 'delay', 'ease'],
    'blur': ['amount', 'duration', 'delay', 'ease'],
    'bounce': ['duration', 'delay', 'ease'],
    'pulse': ['duration', 'delay', 'ease'],
    'shake': ['duration', 'delay', 'ease'],
    'wobble': ['duration', 'delay', 'ease'],
    'swing': ['duration', 'delay', 'ease'],
    'heartbeat': ['duration', 'delay', 'ease'],
    'float': ['duration', 'delay', 'ease'],
    'flash': ['duration', 'delay', 'ease']
  };

  const TRIGGER_MODIFIERS = {
    'vi': ['once', 'replay'],
    'sc': ['start', 'end']
  };

  // FIX P7: Warning Severities & Debouncing
  const _warned = new Set();
  const warnOnce = (type, msg) => {
    const fullMsg = `ydAnimation ${type}: ${msg}`;
    if (!_warned.has(fullMsg)) { console.warn(fullMsg); _warned.add(fullMsg); }
  };

  class AnimParser {
    static getTriggerRegex(triggerKeys) {
      return new RegExp(`^(${triggerKeys.join('|')}):([a-z-]+)(\\|.*)?$`);
    }

    static parse(element, triggerKeys) {
      const classes = Array.from(element.classList);
      const config = { triggers: {} }; 
      const triggerRegex = AnimParser.getTriggerRegex(triggerKeys);
      const claimedChannels = {}; 

      element.classList.add('yd-anim');

      for (let i = classes.length - 1; i >= 0; i--) {
        const match = classes[i].match(triggerRegex);
        if (!match) continue;

        const trigger = match[1];
        const effectStr = match[2]; 
        
        // FIX P4: Simplified base extraction
        const baseEffect = effectStr.split('-')[0];

        if (!EFFECT_CHANNELS[baseEffect]) {
            warnOnce(`[Effect]`, `Unknown effect '${baseEffect}' on element.`);
            continue; 
        }

        const modStr = match[3] ? match[3].substring(1) : ''; 
        
        if (!config.triggers[trigger]) {
          config.triggers[trigger] = { config: {}, modifiers: {}, cssVars: {}, effects: [] };
        }
        if (!claimedChannels[trigger]) claimedChannels[trigger] = new Set();

        const requiredChannels = EFFECT_CHANNELS[baseEffect] || [];
        let conflict = false;

        for (const ch of requiredChannels) {
          if (claimedChannels[trigger].has(ch)) { 
              conflict = true; 
              warnOnce(`[Conflict]`, `'${effectStr}' dropped. Channel '${ch}' already claimed on trigger '${trigger}'.`);
              break; 
          }
        }

        if (!conflict) {
          requiredChannels.forEach(ch => claimedChannels[trigger].add(ch));
          config.triggers[trigger].effects.unshift({ effect: effectStr, base: baseEffect });

          element.classList.add(`yd-effect-${effectStr}`, `yd-base-${baseEffect}`, `yd-trigger-${trigger}`);

          if (modStr) {
            modStr.split('|').forEach(mod => {
              const dashIdx = mod.indexOf('-');
              const modName = dashIdx > -1 ? mod.substring(0, dashIdx) : mod;
              const modValue = dashIdx > -1 ? mod.substring(dashIdx + 1) : true;
              
              const isValidEffectMod = EFFECT_MODIFIERS[baseEffect]?.includes(modName);
              const isValidTriggerMod = TRIGGER_MODIFIERS[trigger]?.includes(modName);

              if (!isValidEffectMod && !isValidTriggerMod) {
                  warnOnce(`[Modifier]`, `'${modName}' is not supported on '${trigger}:${baseEffect}'. Ignored.`);
              } else {
                  config.triggers[trigger].modifiers[modName] = modValue;
              }
            });
          }
        }
      }

      Object.keys(config.triggers).forEach(t => {
        const mods = config.triggers[t].modifiers;
        
        // FIX P6: Mutually Exclusive Modifier Check
        if (mods.once && mods.replay) {
            warnOnce(`[Modifier]`, `Trigger '${t}' has both 'once' and 'replay'. Defaulting to 'once'.`);
            delete mods.replay;
        }

        const baseEffects = config.triggers[t].effects.map(e => e.base);
        const cssVars = config.triggers[t].cssVars;
        
        if (mods.duration) cssVars['--yd-anim-duration'] = `${mods.duration}ms`;
        if (mods.delay) cssVars['--yd-anim-delay'] = `${mods.delay}ms`;
        if (mods.ease) cssVars['--yd-anim-ease'] = `var(--ease-${mods.ease}, ${mods.ease})`;
        if (mods.origin) cssVars['transform-origin'] = mods.origin.replace('-', ' ');
        if (mods.distance) cssVars['--yd-anim-distance'] = `${mods.distance}px`;
        if (mods.angle) cssVars['--yd-anim-angle'] = `${mods.angle}deg`;
        if (mods.amount) {
          if (baseEffects.includes('blur')) {
            const blurMap = { 'xs': '2px', 'sm': '4px', 'md': '8px', 'lg': '16px', 'xl': '24px' };
            cssVars['--yd-anim-blur-val'] = blurMap[mods.amount] || '8px';
          } else {
            cssVars['--yd-anim-amount'] = mods.amount / 100;
          }
        }
        Object.assign(config.triggers[t].config, mods);
      });
      return config;
    }
  }

  // ==========================================
  // OBSERVERS (IO & Scroll)
  // ==========================================
  class AnimObserverManager {
    constructor() {
      this.io = null; this.scrollElements = new Set(); this.scrollRaf = null;
      this._onScroll = this._onScroll.bind(this);
    }
    init() {
      if (!AnimEnvironment.hasDOM()) return;
      this.io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          const trigger = entry.target.__ydAnimTriggers?.vi;
          if (trigger) {
            if (entry.isIntersecting) {
              trigger.play();
              if (trigger.config.once) this.untrack(trigger);
            } else {
              if (trigger.config.replay) trigger.reverse();
            }
          }
        });
      }, { threshold: [0, 0.1] });
    }
    _onScroll() {
      if (!this.scrollRaf) {
        this.scrollRaf = requestAnimationFrame(() => {
          this.scrollRaf = null;
          this._processScrollTick();
        });
      }
    }
    _processScrollTick() {
      const wh = window.innerHeight;
      this.scrollElements.forEach((trigger) => {
        const rect = trigger.element.getBoundingClientRect();
        const startTrigger = trigger.config.start || 'bottom'; 
        const endTrigger = trigger.config.end || 'top';
        let startY = startTrigger === 'top' ? 0 : (startTrigger === 'center' ? wh/2 : wh);
        let endY = endTrigger === 'top' ? 0 : (endTrigger === 'center' ? wh/2 : wh);
        if (startY - endY === 0) endY -= 1; 
        const elementY = rect.top + (rect.height / 2); 
        let progress = (startY - elementY) / (startY - endY);
        trigger.scrub(Math.max(0, Math.min(1, progress)));
      });
    }
    track(trigger) {
      if (trigger.type === 'vi') this.io.observe(trigger.element);
      if (trigger.type === 'sc') { 
        this.scrollElements.add(trigger); 
        if (this.scrollElements.size === 1) {
          window.addEventListener('scroll', this._onScroll, { passive: true });
          window.addEventListener('resize', this._onScroll, { passive: true });
        }
        this._processScrollTick(); 
      }
    }
    untrack(trigger) {
      if (trigger.type === 'vi') this.io.unobserve(trigger.element);
      if (trigger.type === 'sc') {
        this.scrollElements.delete(trigger);
        if (this.scrollElements.size === 0) {
          window.removeEventListener('scroll', this._onScroll);
          window.removeEventListener('resize', this._onScroll);
        }
        trigger.element.classList.remove('yd-scrubbing');
        trigger.element.style.removeProperty('--yd-anim-scrub');
      }
    }
  }

  const GlobalAnimObserver = new AnimObserverManager();
  if (AnimEnvironment.hasDOM()) GlobalAnimObserver.init();

  // ==========================================
  // TRIGGERS
  // ==========================================
  class AnimTrigger {
    constructor(element, type, parsedTriggerData) { 
      this.element = element; this.type = type; 
      this.config = parsedTriggerData.config; this.cssVars = parsedTriggerData.cssVars; this.effects = parsedTriggerData.effects;
    }
    play() { 
      Object.keys(this.cssVars).forEach(k => this.element.style.setProperty(k, this.cssVars[k]));
      this.element.classList.add(`yd-play-${this.type}`); 
    }
    reverse() { this.element.classList.remove(`yd-play-${this.type}`); }
    scrub(progress) { 
      if (!this.element.classList.contains('yd-scrubbing')) {
        Object.keys(this.cssVars).forEach(k => this.element.style.setProperty(k, this.cssVars[k]));
        this.element.classList.add('yd-scrubbing');
      }
      this.element.style.setProperty('--yd-anim-scrub', progress.toFixed(4)); 
    }
    destroy() { 
      Object.keys(this.cssVars).forEach(k => this.element.style.removeProperty(k));
      this.element.classList.remove(`yd-play-${this.type}`, 'yd-scrubbing'); 
      this.element.style.removeProperty('--yd-anim-scrub');
    } 
  }

  class LoadTrigger extends AnimTrigger { 
    init() { this._r = requestAnimationFrame(() => { this._r2 = requestAnimationFrame(() => this.play()); }); } 
    destroy() { cancelAnimationFrame(this._r); cancelAnimationFrame(this._r2); super.destroy(); }
  }
  class ViewportTrigger extends AnimTrigger { 
    init() { GlobalAnimObserver.track(this); } 
    destroy() { GlobalAnimObserver.untrack(this); super.destroy(); }
  }
  class ScrollTrigger extends AnimTrigger { 
    init() { GlobalAnimObserver.track(this); } 
    destroy() { GlobalAnimObserver.untrack(this); super.destroy(); }
  }
  class HoverTrigger extends AnimTrigger {
    init() {
      this._e = () => this.play(); this._l = () => this.reverse();
      this.element.addEventListener('mouseenter', this._e); this.element.addEventListener('mouseleave', this._l);
    }
    destroy() {
      this.element.removeEventListener('mouseenter', this._e); this.element.removeEventListener('mouseleave', this._l);
      super.destroy();
    }
  }
  class PressTrigger extends AnimTrigger {
    init() {
      this._d = () => this.play(); this._u = () => this.reverse();
      this.element.addEventListener('mousedown', this._d); this.element.addEventListener('touchstart', this._d, {passive:true});
      window.addEventListener('mouseup', this._u); window.addEventListener('touchend', this._u); window.addEventListener('touchcancel', this._u);
    }
    destroy() {
      this.element.removeEventListener('mousedown', this._d); this.element.removeEventListener('touchstart', this._d);
      window.removeEventListener('mouseup', this._u); window.removeEventListener('touchend', this._u); window.removeEventListener('touchcancel', this._u);
      super.destroy();
    }
  }
  class ToggleTrigger extends AnimTrigger {
    init() {
      // FIX P1: Pre-Render Sync. Evaluates only its OWN trigger state.
      this.toggled = this.element.classList.contains(`yd-play-${this.type}`); 
      this._c = () => { this.toggled = !this.toggled; this.toggled ? this.play() : this.reverse(); };
      this.element.addEventListener('click', this._c);
    }
    destroy() { this.element.removeEventListener('click', this._c); super.destroy(); }
  }
  class ClassToggleTrigger extends AnimTrigger {
    constructor(el, type, config, targetClass) { super(el, type, config); this.targetClass = targetClass; }
    init() {
      this.wasActive = this.element.classList.contains(this.targetClass);
      if (this.wasActive) this.play();
      this.mo = new MutationObserver(() => {
        const isActive = this.element.classList.contains(this.targetClass);
        if (isActive !== this.wasActive) { this.wasActive = isActive; isActive ? this.play() : this.reverse(); }
      });
      this.mo.observe(this.element, { attributes: true, attributeFilter: ['class'] });
    }
    destroy() { if (this.mo) this.mo.disconnect(); super.destroy(); }
  }

  const TRIGGER_MAP = {
    'lo': LoadTrigger, 'vi': ViewportTrigger, 'sc': ScrollTrigger, 
    'ho': HoverTrigger, 'pr': PressTrigger, 'tg': ToggleTrigger,
    'ac': (el, t, c) => new ClassToggleTrigger(el, t, c, 'active'),
    'se': (el, t, c) => new ClassToggleTrigger(el, t, c, 'select')
  };

  class ydAnimationFacade {
    static _autoInitObserver = null;

    static initAll(rootNode = document) {
      if (!AnimEnvironment.hasDOM()) return;
      const triggerKeys = Object.keys(TRIGGER_MAP);
      const regex = AnimParser.getTriggerRegex(triggerKeys);
      
      const selector = triggerKeys.map(t => `[class*="${t}:"]`).join(', ');
      const elements = rootNode === document ? document.querySelectorAll(selector) : [rootNode, ...rootNode.querySelectorAll(selector)];
      
      elements.forEach(el => {
        if (el.nodeType === 1 && !el.__ydAnimationConfigured && Array.from(el.classList).some(cls => regex.test(cls))) {
          new ydAnimationFacade(el);
        }
      });
    }

    static _extractAnimClasses(element) {
        const regex = AnimParser.getTriggerRegex(Object.keys(TRIGGER_MAP));
        return Array.from(element.classList).filter(cls => regex.test(cls)).join(' ');
    }

    static startAutoInit() {
      if (!AnimEnvironment.hasDOM()) return;
      ydAnimationFacade.initAll(); 
      if (typeof MutationObserver !== 'undefined' && !this._autoInitObserver) {
        this._autoInitObserver = new MutationObserver(mutations => {
          mutations.forEach(m => {
            if (m.type === 'childList') {
                m.addedNodes.forEach(node => { if (node.nodeType === 1) ydAnimationFacade.initAll(node); });
            } 
            else if (m.type === 'attributes' && m.attributeName === 'class') {
                const el = m.target;
                if (el.nodeType === 1 && !el.__ydAnimationDestroying) {
                    
                    const currentAnimClasses = ydAnimationFacade._extractAnimClasses(el);
                    
                    if (el.__ydAnimationConfigured) {
                        // FIX P2 & P3: Only teardown/rebuild if the actual animation syntax string mutated.
                        if (el.__ydAnimClassSignature !== currentAnimClasses) {
                            el.__ydFacadeInstance?.destroy();
                            if (currentAnimClasses.length > 0) new ydAnimationFacade(el);
                        }
                    } else if (currentAnimClasses.length > 0) {
                        new ydAnimationFacade(el);
                    }
                }
            }
          });
        });
        this._autoInitObserver.observe(document.body, { childList: true, subtree: true, attributes: true, attributeFilter: ['class'] });
      }
    }

    static stopAutoInit() {
      if (this._autoInitObserver) { this._autoInitObserver.disconnect(); this._autoInitObserver = null; }
    }

    constructor(element) {
      this.root = element;
      this.root.__ydAnimationConfigured = true;
      this.root.__ydFacadeInstance = this; 
      
      // Store exact signature to prevent expensive rebuilds on non-anim class toggles (.active)
      this.root.__ydAnimClassSignature = ydAnimationFacade._extractAnimClasses(this.root);
      
      this.parsedConfig = AnimParser.parse(this.root, Object.keys(TRIGGER_MAP));
      this.root.__ydAnimTriggers = {};

      Object.keys(this.parsedConfig.triggers).forEach(t => {
        const ConfigClass = TRIGGER_MAP[t];
        if (ConfigClass) {
          const instance = typeof ConfigClass === 'function' && !ConfigClass.prototype?.init 
            ? ConfigClass(this.root, t, this.parsedConfig.triggers[t]) 
            : new ConfigClass(this.root, t, this.parsedConfig.triggers[t]);
          this.root.__ydAnimTriggers[t] = instance;
          instance.init();
        }
      });
    }

    destroy() {
      // FIX P2: Bypass mutation observer during deliberate teardown
      this.root.__ydAnimationDestroying = true;
      
      if (this.root.__ydAnimTriggers) {
        Object.values(this.root.__ydAnimTriggers).forEach(trigger => {
          if (typeof trigger.destroy === 'function') trigger.destroy();
        });
      }
      Array.from(this.root.classList).forEach(c => {
        if (c.startsWith('yd-')) this.root.classList.remove(c);
      });
      delete this.root.__ydAnimTriggers;
      delete this.root.__ydAnimationConfigured;
      delete this.root.__ydFacadeInstance;
      delete this.root.__ydAnimClassSignature;
      
      // Allow observer to track future changes
      requestAnimationFrame(() => delete this.root.__ydAnimationDestroying);
    }
  }

  if (AnimEnvironment.hasDOM()) document.addEventListener('DOMContentLoaded', () => ydAnimationFacade.startAutoInit());
  return ydAnimationFacade;
})();
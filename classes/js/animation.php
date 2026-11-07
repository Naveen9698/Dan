/**
 * ydAnimation V17.0 LTS - TRIGGER ENGINE
 * Architecture: Frozen. 3D Geometric Tilt Semantics & Base Angle Mapping.
 */
const ydAnimation = (() => {

  class AnimEnvironment {
    static hasDOM() { return typeof window !== 'undefined' && typeof document !== 'undefined'; }
  }

  // ==========================================
  // MASTER CAPABILITY REGISTRY
  // ==========================================
  const EFFECT_REGISTRY = {
    'fade': { channels: ['opacity', 'translate'], modifiers: ['distance', 'duration', 'delay', 'ease'] },
    'slide': { channels: ['translate'], modifiers: ['distance', 'duration', 'delay', 'ease'] },
    'scale': { channels: ['scale'], modifiers: ['amount', 'origin', 'duration', 'delay', 'ease'] },
    'zoom': { channels: ['opacity', 'scale'], modifiers: ['amount', 'origin', 'duration', 'delay', 'ease'] },
    'rotate': { channels: ['rotate'], modifiers: ['angle', 'origin', 'duration', 'delay', 'ease'] },
    'flip': { channels: ['rotate3d'], modifiers: ['origin', 'duration', 'delay', 'ease'] },
    'blur': { channels: ['blur'], modifiers: ['amount', 'duration', 'delay', 'ease'] },
    'bounce': { channels: ['translate'], modifiers: ['duration', 'delay', 'ease'] },
    'pulse': { channels: ['scale'], modifiers: ['duration', 'delay', 'ease'] },
    'shake': { channels: ['translate'], modifiers: ['duration', 'delay', 'ease'] },
    'wobble': { channels: ['translate', 'rotate'], modifiers: ['duration', 'delay', 'ease'] },
    'swing': { channels: ['rotate'], modifiers: ['duration', 'delay', 'ease'] },
    'heartbeat': { channels: ['scale'], modifiers: ['duration', 'delay', 'ease'] },
    'float': { channels: ['translate'], modifiers: ['duration', 'delay', 'ease'] },
    'flash': { channels: ['opacity'], modifiers: ['duration', 'delay', 'ease'] }
  };

  const TRIGGER_MODIFIERS = { 'vi': ['once', 'replay'], 'sc': ['start', 'end'] };

  const _warned = new Set();
  const warnOnce = (type, rule, ctx) => {
    const key = `${type}:${rule}`;
    if (!_warned.has(key)) { 
        console.warn(`ydAnimation ${type}: ${rule} ${ctx ? `(Context: ${ctx})` : ''}`); 
        _warned.add(key); 
    }
  };

  class AnimParser {
    static getTriggerRegex(triggerKeys) { return new RegExp(`^(${triggerKeys.join('|')}):([a-z-]+)(\\|.*)?$`); }

    static parse(element, triggerKeys) {
      const classes = Array.from(element.classList);
      const config = { triggers: {} }; 
      const triggerRegex = AnimParser.getTriggerRegex(triggerKeys);
      const claimedChannels = {}; 
      const elCtx = element.className;

      element.classList.add('yd-anim');

      for (let i = classes.length - 1; i >= 0; i--) {
        const match = classes[i].match(triggerRegex);
        if (!match) continue;

        const trigger = match[1];
        const effectStr = match[2]; 
        const baseEffect = effectStr.split('-')[0];

        if (!EFFECT_REGISTRY[baseEffect]) { warnOnce(`[Effect]`, `Unknown effect '${baseEffect}'.`, elCtx); continue; }

        const modStr = match[3] ? match[3].substring(1) : ''; 
        if (!config.triggers[trigger]) { config.triggers[trigger] = { config: {}, modifiers: {}, persistentVars: {}, activeVars: {}, effects: [] }; }
        if (!claimedChannels[trigger]) claimedChannels[trigger] = new Set();

        const requiredChannels = EFFECT_REGISTRY[baseEffect].channels;
        let conflict = false;

        for (const ch of requiredChannels) {
          if (claimedChannels[trigger].has(ch)) { 
              conflict = true; 
              warnOnce(`[Conflict]`, `'${effectStr}' dropped. Channel '${ch}' claimed by '${trigger}'.`, elCtx); break; 
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
              let modValue = dashIdx > -1 ? mod.substring(dashIdx + 1) : true;
              
              if (modName === 'ease' && dashIdx > -1) {
                  const fullEaseStr = mod.substring('ease-'.length);
                  if (fullEaseStr === 'in' || fullEaseStr === 'out' || fullEaseStr === 'in-out') {
                      modValue = `ease-${fullEaseStr}`; 
                  } else {
                      modValue = fullEaseStr;
                  }
              }
              
              if (!EFFECT_REGISTRY[baseEffect].modifiers.includes(modName) && !TRIGGER_MODIFIERS[trigger]?.includes(modName)) {
                  warnOnce(`[Modifier]`, `'${modName}' not supported on '${trigger}:${baseEffect}'.`, elCtx);
              } else {
                  config.triggers[trigger].modifiers[modName] = modValue;
              }
            });
          }
        }
      }

      Object.keys(config.triggers).forEach(t => {
        const mods = config.triggers[t].modifiers;
        
        if (mods.once && mods.replay) { warnOnce(`[Modifier]`, `Trigger '${t}' has 'once' and 'replay'. Defaulting 'once'.`, elCtx); delete mods.replay; }

        const baseEffects = config.triggers[t].effects.map(e => e.base);
        const effectStrings = config.triggers[t].effects.map(e => e.effect);
        
        const pVars = config.triggers[t].persistentVars;
        const aVars = config.triggers[t].activeVars;
        
        if (mods.duration) aVars[`--yd-${t}-duration`] = `${mods.duration}ms`;
        if (mods.delay) aVars[`--yd-${t}-delay`] = `${mods.delay}ms`;
        if (mods.ease) aVars[`--yd-${t}-ease`] = mods.ease;
        
        if (mods.origin) pVars[`--yd-${t}-origin`] = mods.origin.replace('-', ' ');
        if (mods.distance) pVars[`--yd-${t}-distance`] = `${mods.distance}px`;
        if (mods.angle) pVars[`--yd-${t}-angle-base`] = `${mods.angle}deg`;
        
        const isInteractive = ['ho', 'pr', 'tg', 'ac', 'se'].includes(t);
        const flipAngle = isInteractive ? '45deg' : '180deg';
        if (effectStrings.includes('flip-x')) pVars[`--yd-${t}-rx-base`] = flipAngle;
        if (effectStrings.includes('flip-y')) pVars[`--yd-${t}-ry-base`] = flipAngle;
        
        if (mods.amount) {
          if (baseEffects.includes('blur')) {
            const blurMap = { 'xs': '2px', 'sm': '4px', 'md': '8px', 'lg': '16px', 'xl': '24px' };
            pVars[`--yd-${t}-blur-val`] = blurMap[mods.amount] || '8px';
          } else {
            pVars[`--yd-${t}-amount-base`] = mods.amount / 100;
          }
        }
        
        Object.keys(pVars).forEach(k => element.style.setProperty(k, pVars[k]));
        Object.assign(config.triggers[t].config, mods);
      });
      return config;
    }
  }

  // ==========================================
  // OBSERVERS (IO & Scroll)
  // ==========================================
  class AnimObserverManager {
    constructor() { this.io = null; this.scrollElements = new Set(); this.scrollRaf = null; this._onScroll = this._onScroll.bind(this); }
    init() {
      if (!AnimEnvironment.hasDOM()) return;
      this.io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          const trigger = entry.target.__ydAnimTriggers?.vi;
          if (trigger) { entry.isIntersecting ? (trigger.play(), trigger.config.once && this.untrack(trigger)) : (trigger.config.replay && trigger.reverse()); }
        });
      }, { threshold: [0, 0.1] });
    }
    _onScroll() { if (!this.scrollRaf) { this.scrollRaf = requestAnimationFrame(() => { this.scrollRaf = null; this._processScrollTick(); }); } }
    
    _processScrollTick() {
      const wh = window.innerHeight;
      
      const resolveY = (val) => {
          if (val === 'top') return 0;
          if (val === 'center') return wh / 2;
          if (val === 'bottom' || !val) return wh;
          const parsed = parseFloat(val);
          return !isNaN(parsed) ? (parsed / 100) * wh : wh;
      };

      this.scrollElements.forEach((trigger) => {
        const rect = trigger.element.getBoundingClientRect();
        let startY = resolveY(trigger.config.start || 'bottom');
        let endY = resolveY(trigger.config.end || 'top');
        if (startY - endY === 0) endY -= 1; 
        trigger.scrub(Math.max(0, Math.min(1, (startY - (rect.top + rect.height/2)) / (startY - endY))));
      });
    }
    
    track(trigger) {
      if (trigger.type === 'vi') this.io.observe(trigger.element);
      if (trigger.type === 'sc') { 
        this.scrollElements.add(trigger); 
        if (this.scrollElements.size === 1) { window.addEventListener('scroll', this._onScroll, { passive: true }); window.addEventListener('resize', this._onScroll, { passive: true }); }
        this._processScrollTick(); 
      }
    }
    untrack(trigger) {
      if (trigger.type === 'vi') this.io.unobserve(trigger.element);
      if (trigger.type === 'sc') {
        this.scrollElements.delete(trigger);
        if (this.scrollElements.size === 0) { window.removeEventListener('scroll', this._onScroll); window.removeEventListener('resize', this._onScroll); }
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
      this.config = parsedTriggerData.config; 
      this.persistentVars = parsedTriggerData.persistentVars;
      this.activeVars = parsedTriggerData.activeVars;
      this.effects = parsedTriggerData.effects;
    }
    play() { Object.keys(this.activeVars).forEach(k => this.element.style.setProperty(k, this.activeVars[k])); this.element.classList.add(`yd-play-${this.type}`); }
    reverse() { Object.keys(this.activeVars).forEach(k => this.element.style.removeProperty(k)); this.element.classList.remove(`yd-play-${this.type}`); }
    scrub(progress) { 
      if (!this.element.classList.contains('yd-scrubbing')) { 
        Object.keys(this.activeVars).forEach(k => this.element.style.setProperty(k, this.activeVars[k])); 
        this.element.classList.add('yd-scrubbing'); 
      }
      this.element.style.setProperty('--yd-anim-scrub', progress.toFixed(4)); 
    }
    destroy() { 
      Object.keys(this.persistentVars).forEach(k => this.element.style.removeProperty(k));
      Object.keys(this.activeVars).forEach(k => this.element.style.removeProperty(k));
      this.element.classList.remove(`yd-play-${this.type}`, 'yd-scrubbing'); this.element.style.removeProperty('--yd-anim-scrub');
    } 
  }

  class LoadTrigger extends AnimTrigger { 
    init() { this._r = requestAnimationFrame(() => { this._r2 = requestAnimationFrame(() => this.play()); }); } 
    destroy() { cancelAnimationFrame(this._r); cancelAnimationFrame(this._r2); super.destroy(); }
  }
  class ViewportTrigger extends AnimTrigger { init() { GlobalAnimObserver.track(this); } destroy() { GlobalAnimObserver.untrack(this); super.destroy(); } }
  class ScrollTrigger extends AnimTrigger { init() { GlobalAnimObserver.track(this); } destroy() { GlobalAnimObserver.untrack(this); super.destroy(); } }
  class HoverTrigger extends AnimTrigger {
    init() { this._e = () => this.play(); this._l = () => this.reverse(); this.element.addEventListener('mouseenter', this._e); this.element.addEventListener('mouseleave', this._l); }
    destroy() { this.element.removeEventListener('mouseenter', this._e); this.element.removeEventListener('mouseleave', this._l); super.destroy(); }
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
      this.mo = new MutationObserver(() => { const isActive = this.element.classList.contains(this.targetClass); if (isActive !== this.wasActive) { this.wasActive = isActive; isActive ? this.play() : this.reverse(); } });
      this.mo.observe(this.element, { attributes: true, attributeFilter: ['class'] });
    }
    destroy() { if (this.mo) this.mo.disconnect(); super.destroy(); }
  }

  const TRIGGER_MAP = {
    'lo': LoadTrigger, 'vi': ViewportTrigger, 'sc': ScrollTrigger, 
    'ho': HoverTrigger, 'pr': PressTrigger, 'tg': ToggleTrigger,
    'ac': (el, t, c) => new ClassToggleTrigger(el, t, c, 'active'), 'se': (el, t, c) => new ClassToggleTrigger(el, t, c, 'select')
  };

  class ydAnimationFacade {
    static _autoInitObserver = null;

    static initAll(rootNode = document) {
      if (!AnimEnvironment.hasDOM()) return;
      const tKeys = Object.keys(TRIGGER_MAP); const regex = AnimParser.getTriggerRegex(tKeys);
      const sel = tKeys.map(t => `[class*="${t}:"]`).join(', ');
      const els = rootNode === document ? document.querySelectorAll(sel) : [rootNode, ...rootNode.querySelectorAll(sel)];
      els.forEach(el => { if (el.nodeType === 1 && !el.__ydAnimationConfigured && Array.from(el.classList).some(cls => regex.test(cls))) { new ydAnimationFacade(el); } });
    }
    static _extractAnimClasses(element) {
        const regex = AnimParser.getTriggerRegex(Object.keys(TRIGGER_MAP));
        return Array.from(element.classList).filter(cls => regex.test(cls)).sort().join(' ');
    }
    static startAutoInit() {
      if (!AnimEnvironment.hasDOM()) return;
      ydAnimationFacade.initAll(); 
      if (typeof MutationObserver !== 'undefined' && !this._autoInitObserver) {
        this._autoInitObserver = new MutationObserver(mutations => {
          mutations.forEach(m => {
            if (m.type === 'childList') { m.addedNodes.forEach(n => { if (n.nodeType === 1) ydAnimationFacade.initAll(n); }); } 
            else if (m.type === 'attributes' && m.attributeName === 'class') {
                const el = m.target;
                if (el.nodeType === 1 && !el.__ydAnimationDestroying) {
                    const cAnimClasses = ydAnimationFacade._extractAnimClasses(el);
                    if (el.__ydAnimationConfigured) {
                        if (el.__ydAnimClassSignature !== cAnimClasses) {
                            el.__ydFacadeInstance?.destroy();
                            if (cAnimClasses.length > 0) new ydAnimationFacade(el);
                        }
                    } else if (cAnimClasses.length > 0) { new ydAnimationFacade(el); }
                }
            }
          });
        });
        this._autoInitObserver.observe(document.body, { childList: true, subtree: true, attributes: true, attributeFilter: ['class'] });
      }
    }
    static stopAutoInit() { if (this._autoInitObserver) { this._autoInitObserver.disconnect(); this._autoInitObserver = null; } }

    constructor(element) {
      this.root = element; this.root.__ydAnimationConfigured = true; this.root.__ydFacadeInstance = this; 
      this.root.__ydAnimClassSignature = ydAnimationFacade._extractAnimClasses(this.root);
      this.parsedConfig = AnimParser.parse(this.root, Object.keys(TRIGGER_MAP)); this.root.__ydAnimTriggers = {};
      Object.keys(this.parsedConfig.triggers).forEach(t => {
        const CClass = TRIGGER_MAP[t];
        if (CClass) {
          const inst = typeof CClass === 'function' && !CClass.prototype?.init ? CClass(this.root, t, this.parsedConfig.triggers[t]) : new CClass(this.root, t, this.parsedConfig.triggers[t]);
          this.root.__ydAnimTriggers[t] = inst; 
          if (typeof inst.init === 'function') inst.init();
        }
      });
    }
    destroy() {
      this.root.__ydAnimationDestroying = true;
      if (this.root.__ydAnimTriggers) { Object.values(this.root.__ydAnimTriggers).forEach(t => { if (typeof t.destroy === 'function') t.destroy(); }); }
      Array.from(this.root.classList).forEach(c => { if (c.startsWith('yd-')) this.root.classList.remove(c); });
      delete this.root.__ydAnimTriggers; delete this.root.__ydAnimationConfigured; delete this.root.__ydFacadeInstance; delete this.root.__ydAnimClassSignature;
      requestAnimationFrame(() => delete this.root.__ydAnimationDestroying);
    }
  }

  if (AnimEnvironment.hasDOM()) document.addEventListener('DOMContentLoaded', () => ydAnimationFacade.startAutoInit());
  return ydAnimationFacade;
})();
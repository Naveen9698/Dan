/* ==========================================
   ydAnimation 1.1.2 LTS - CSS RENDER ENGINE
   Architecture: @property Presets & Volumetric Merging
   ========================================== */

/* FIX P1: Registering preset properties for Keyframe interpolation without overwriting Transform */
@property --yd-preset-ty { syntax: '<length>'; inherits: false; initial-value: 0px; }
@property --yd-preset-tx { syntax: '<length>'; inherits: false; initial-value: 0px; }
@property --yd-preset-scale { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-preset-rotate { syntax: '<angle>'; inherits: false; initial-value: 0deg; }
@property --yd-preset-opacity { syntax: '<number>'; inherits: false; initial-value: 1; }

.yd-anim {
  --yd-anim-duration: 500ms;
  --yd-anim-delay: 0ms;
  --yd-anim-ease: ease;
  
  --yd-anim-distance: 50px;
  --yd-anim-amount: 1.1; 
  --yd-anim-angle: 90deg;
  --yd-anim-blur-val: 8px;
  
  --yd-initial-opacity: 1;
  --yd-initial-scale: 1; 
  --yd-initial-rotate: 0deg;
  --yd-initial-rx: 0deg;
  --yd-initial-ry: 0deg;
  --yd-initial-tx: 0px;
  --yd-initial-ty: 0px;
  --yd-initial-blur: 0px;

  --yd-transform-opacity: var(--yd-initial-opacity);
  --yd-transform-scale: var(--yd-initial-scale);
  --yd-transform-rotate: var(--yd-initial-rotate);
  --yd-transform-rx: var(--yd-initial-rx);
  --yd-transform-ry: var(--yd-initial-ry);
  --yd-transform-tx: var(--yd-initial-tx);
  --yd-transform-ty: var(--yd-initial-ty);
  --yd-transform-blur: var(--yd-initial-blur);

  /* Preset baseline reset */
  --yd-preset-ty: 0px;
  --yd-preset-tx: 0px;
  --yd-preset-scale: 1;
  --yd-preset-rotate: 0deg;
  --yd-preset-opacity: 1;

  opacity: calc(var(--yd-transform-opacity) * var(--yd-preset-opacity));
  filter: blur(var(--yd-transform-blur));
  will-change: transform, opacity, filter;

  /* FIX P1: Master Engine natively intertwines Standard Transforms AND Keyframe Presets */
  transform:
    rotateX(var(--yd-transform-rx))
    rotateY(var(--yd-transform-ry))
    rotate(calc(var(--rotate-value, 0deg) + var(--yd-transform-rotate) + var(--yd-preset-rotate)))
    scale(calc(var(--scale-value, 1) * var(--yd-transform-scale) * var(--yd-preset-scale)))
    skewX(var(--skewx-value, 0deg))
    skewY(var(--skewy-value, 0deg))
    translateX(calc(var(--translate-right, 0px) - var(--translate-left, 0px) + var(--yd-transform-tx) + var(--yd-preset-tx)))
    translateY(calc(var(--translate-bottom, 0px) - var(--translate-top, 0px) + var(--yd-transform-ty) + var(--yd-preset-ty)));

  transition: opacity var(--yd-anim-duration) var(--yd-anim-ease) var(--yd-anim-delay),
              transform var(--yd-anim-duration) var(--yd-anim-ease) var(--yd-anim-delay),
              filter var(--yd-anim-duration) var(--yd-anim-ease) var(--yd-anim-delay);
}

@media (prefers-reduced-motion: reduce) {
  .yd-anim { transition-duration: 0ms !important; animation-duration: 0ms !important; }
}
.yd-scrubbing { transition: none !important; }

/* ==========================================
   ENTRY INITIAL STATES
   ========================================== */
.yd-trigger-lo.yd-effect-fade, .yd-trigger-vi.yd-effect-fade, .yd-trigger-sc.yd-effect-fade { --yd-initial-opacity: 0; }

.yd-trigger-lo.yd-effect-fade-up, .yd-trigger-vi.yd-effect-fade-up, .yd-trigger-sc.yd-effect-fade-up { --yd-initial-opacity: 0; --yd-initial-ty: var(--yd-anim-distance); }
.yd-trigger-lo.yd-effect-fade-down, .yd-trigger-vi.yd-effect-fade-down, .yd-trigger-sc.yd-effect-fade-down { --yd-initial-opacity: 0; --yd-initial-ty: calc(var(--yd-anim-distance) * -1); }
.yd-trigger-lo.yd-effect-fade-left, .yd-trigger-vi.yd-effect-fade-left, .yd-trigger-sc.yd-effect-fade-left { --yd-initial-opacity: 0; --yd-initial-tx: var(--yd-anim-distance); }
.yd-trigger-lo.yd-effect-fade-right, .yd-trigger-vi.yd-effect-fade-right, .yd-trigger-sc.yd-effect-fade-right { --yd-initial-opacity: 0; --yd-initial-tx: calc(var(--yd-anim-distance) * -1); }

.yd-trigger-lo.yd-effect-fade-top-left, .yd-trigger-vi.yd-effect-fade-top-left, .yd-trigger-sc.yd-effect-fade-top-left { --yd-initial-opacity: 0; --yd-initial-ty: var(--yd-anim-distance); --yd-initial-tx: var(--yd-anim-distance); }
.yd-trigger-lo.yd-effect-fade-top-right, .yd-trigger-vi.yd-effect-fade-top-right, .yd-trigger-sc.yd-effect-fade-top-right { --yd-initial-opacity: 0; --yd-initial-ty: var(--yd-anim-distance); --yd-initial-tx: calc(var(--yd-anim-distance) * -1); }
.yd-trigger-lo.yd-effect-fade-bottom-left, .yd-trigger-vi.yd-effect-fade-bottom-left, .yd-trigger-sc.yd-effect-fade-bottom-left { --yd-initial-opacity: 0; --yd-initial-ty: calc(var(--yd-anim-distance) * -1); --yd-initial-tx: var(--yd-anim-distance); }
.yd-trigger-lo.yd-effect-fade-bottom-right, .yd-trigger-vi.yd-effect-fade-bottom-right, .yd-trigger-sc.yd-effect-fade-bottom-right { --yd-initial-opacity: 0; --yd-initial-ty: calc(var(--yd-anim-distance) * -1); --yd-initial-tx: calc(var(--yd-anim-distance) * -1); }

.yd-trigger-lo.yd-effect-slide-up, .yd-trigger-vi.yd-effect-slide-up, .yd-trigger-sc.yd-effect-slide-up { --yd-initial-ty: var(--yd-anim-distance); }
.yd-trigger-lo.yd-effect-slide-down, .yd-trigger-vi.yd-effect-slide-down, .yd-trigger-sc.yd-effect-slide-down { --yd-initial-ty: calc(var(--yd-anim-distance) * -1); }
.yd-trigger-lo.yd-effect-slide-left, .yd-trigger-vi.yd-effect-slide-left, .yd-trigger-sc.yd-effect-slide-left { --yd-initial-tx: var(--yd-anim-distance); }
.yd-trigger-lo.yd-effect-slide-right, .yd-trigger-vi.yd-effect-slide-right, .yd-trigger-sc.yd-effect-slide-right { --yd-initial-tx: calc(var(--yd-anim-distance) * -1); }

.yd-trigger-lo.yd-effect-slide-top-left, .yd-trigger-vi.yd-effect-slide-top-left, .yd-trigger-sc.yd-effect-slide-top-left { --yd-initial-ty: var(--yd-anim-distance); --yd-initial-tx: var(--yd-anim-distance); }
.yd-trigger-lo.yd-effect-slide-top-right, .yd-trigger-vi.yd-effect-slide-top-right, .yd-trigger-sc.yd-effect-slide-top-right { --yd-initial-ty: var(--yd-anim-distance); --yd-initial-tx: calc(var(--yd-anim-distance) * -1); }
.yd-trigger-lo.yd-effect-slide-bottom-left, .yd-trigger-vi.yd-effect-slide-bottom-left, .yd-trigger-sc.yd-effect-slide-bottom-left { --yd-initial-ty: calc(var(--yd-anim-distance) * -1); --yd-initial-tx: var(--yd-anim-distance); }
.yd-trigger-lo.yd-effect-slide-bottom-right, .yd-trigger-vi.yd-effect-slide-bottom-right, .yd-trigger-sc.yd-effect-slide-bottom-right { --yd-initial-ty: calc(var(--yd-anim-distance) * -1); --yd-initial-tx: calc(var(--yd-anim-distance) * -1); }

.yd-trigger-lo.yd-effect-zoom, .yd-trigger-vi.yd-effect-zoom, .yd-trigger-sc.yd-effect-zoom { --yd-initial-opacity: 0; --yd-initial-scale: calc(2 - var(--yd-anim-amount)); } 
.yd-trigger-lo.yd-effect-blur-in, .yd-trigger-vi.yd-effect-blur-in, .yd-trigger-sc.yd-effect-blur-in { --yd-initial-opacity: 0; --yd-initial-blur: var(--yd-anim-blur-val); }
.yd-trigger-lo.yd-effect-blur-out, .yd-trigger-vi.yd-effect-blur-out, .yd-trigger-sc.yd-effect-blur-out { --yd-initial-blur: 0px; }

.yd-play-lo, .yd-play-vi, .yd-play-sc { --yd-transform-opacity: 1; --yd-transform-scale: 1; --yd-transform-rotate: 0deg; --yd-transform-rx: 0deg; --yd-transform-ry: 0deg; --yd-transform-tx: 0px; --yd-transform-ty: 0px; --yd-transform-blur: 0px; }

/* ==========================================
   INTERACTIVE TARGET STATES
   ========================================== */
.yd-play-ho.yd-effect-fade, .yd-play-pr.yd-effect-fade, .yd-play-tg.yd-effect-fade, .yd-play-ac.yd-effect-fade, .yd-play-se.yd-effect-fade { --yd-transform-opacity: 0; }

.yd-play-ho.yd-effect-fade-up, .yd-play-pr.yd-effect-fade-up, .yd-play-tg.yd-effect-fade-up, .yd-play-ac.yd-effect-fade-up, .yd-play-se.yd-effect-fade-up,
.yd-play-ho.yd-effect-slide-up, .yd-play-pr.yd-effect-slide-up, .yd-play-tg.yd-effect-slide-up, .yd-play-ac.yd-effect-slide-up, .yd-play-se.yd-effect-slide-up { --yd-transform-ty: calc(var(--yd-anim-distance) * -1); }
.yd-play-ho.yd-effect-fade-up, .yd-play-pr.yd-effect-fade-up, .yd-play-tg.yd-effect-fade-up, .yd-play-ac.yd-effect-fade-up, .yd-play-se.yd-effect-fade-up { --yd-transform-opacity: 0; }

.yd-play-ho.yd-effect-fade-down, .yd-play-pr.yd-effect-fade-down, .yd-play-tg.yd-effect-fade-down, .yd-play-ac.yd-effect-fade-down, .yd-play-se.yd-effect-fade-down,
.yd-play-ho.yd-effect-slide-down, .yd-play-pr.yd-effect-slide-down, .yd-play-tg.yd-effect-slide-down, .yd-play-ac.yd-effect-slide-down, .yd-play-se.yd-effect-slide-down { --yd-transform-ty: var(--yd-anim-distance); }
.yd-play-ho.yd-effect-fade-down, .yd-play-pr.yd-effect-fade-down, .yd-play-tg.yd-effect-fade-down, .yd-play-ac.yd-effect-fade-down, .yd-play-se.yd-effect-fade-down { --yd-transform-opacity: 0; }

.yd-play-ho.yd-effect-fade-left, .yd-play-pr.yd-effect-fade-left, .yd-play-tg.yd-effect-fade-left, .yd-play-ac.yd-effect-fade-left, .yd-play-se.yd-effect-fade-left,
.yd-play-ho.yd-effect-slide-left, .yd-play-pr.yd-effect-slide-left, .yd-play-tg.yd-effect-slide-left, .yd-play-ac.yd-effect-slide-left, .yd-play-se.yd-effect-slide-left { --yd-transform-tx: calc(var(--yd-anim-distance) * -1); }
.yd-play-ho.yd-effect-fade-left, .yd-play-pr.yd-effect-fade-left, .yd-play-tg.yd-effect-fade-left, .yd-play-ac.yd-effect-fade-left, .yd-play-se.yd-effect-fade-left { --yd-transform-opacity: 0; }

.yd-play-ho.yd-effect-fade-right, .yd-play-pr.yd-effect-fade-right, .yd-play-tg.yd-effect-fade-right, .yd-play-ac.yd-effect-fade-right, .yd-play-se.yd-effect-fade-right,
.yd-play-ho.yd-effect-slide-right, .yd-play-pr.yd-effect-slide-right, .yd-play-tg.yd-effect-slide-right, .yd-play-ac.yd-effect-slide-right, .yd-play-se.yd-effect-slide-right { --yd-transform-tx: var(--yd-anim-distance); }
.yd-play-ho.yd-effect-fade-right, .yd-play-pr.yd-effect-fade-right, .yd-play-tg.yd-effect-fade-right, .yd-play-ac.yd-effect-fade-right, .yd-play-se.yd-effect-fade-right { --yd-transform-opacity: 0; }

.yd-play-ho.yd-effect-fade-top-left, .yd-play-pr.yd-effect-fade-top-left, .yd-play-tg.yd-effect-fade-top-left, .yd-play-ac.yd-effect-fade-top-left, .yd-play-se.yd-effect-fade-top-left,
.yd-play-ho.yd-effect-slide-top-left, .yd-play-pr.yd-effect-slide-top-left, .yd-play-tg.yd-effect-slide-top-left, .yd-play-ac.yd-effect-slide-top-left, .yd-play-se.yd-effect-slide-top-left { --yd-transform-ty: calc(var(--yd-anim-distance) * -1); --yd-transform-tx: calc(var(--yd-anim-distance) * -1); }
.yd-play-ho.yd-effect-fade-top-left, .yd-play-pr.yd-effect-fade-top-left, .yd-play-tg.yd-effect-fade-top-left, .yd-play-ac.yd-effect-fade-top-left, .yd-play-se.yd-effect-fade-top-left { --yd-transform-opacity: 0; }

.yd-play-ho.yd-effect-fade-top-right, .yd-play-pr.yd-effect-fade-top-right, .yd-play-tg.yd-effect-fade-top-right, .yd-play-ac.yd-effect-fade-top-right, .yd-play-se.yd-effect-fade-top-right,
.yd-play-ho.yd-effect-slide-top-right, .yd-play-pr.yd-effect-slide-top-right, .yd-play-tg.yd-effect-slide-top-right, .yd-play-ac.yd-effect-slide-top-right, .yd-play-se.yd-effect-slide-top-right { --yd-transform-ty: calc(var(--yd-anim-distance) * -1); --yd-transform-tx: var(--yd-anim-distance); }
.yd-play-ho.yd-effect-fade-top-right, .yd-play-pr.yd-effect-fade-top-right, .yd-play-tg.yd-effect-fade-top-right, .yd-play-ac.yd-effect-fade-top-right, .yd-play-se.yd-effect-fade-top-right { --yd-transform-opacity: 0; }

.yd-play-ho.yd-effect-fade-bottom-left, .yd-play-pr.yd-effect-fade-bottom-left, .yd-play-tg.yd-effect-fade-bottom-left, .yd-play-ac.yd-effect-fade-bottom-left, .yd-play-se.yd-effect-fade-bottom-left,
.yd-play-ho.yd-effect-slide-bottom-left, .yd-play-pr.yd-effect-slide-bottom-left, .yd-play-tg.yd-effect-slide-bottom-left, .yd-play-ac.yd-effect-slide-bottom-left, .yd-play-se.yd-effect-slide-bottom-left { --yd-transform-ty: var(--yd-anim-distance); --yd-transform-tx: calc(var(--yd-anim-distance) * -1); }
.yd-play-ho.yd-effect-fade-bottom-left, .yd-play-pr.yd-effect-fade-bottom-left, .yd-play-tg.yd-effect-fade-bottom-left, .yd-play-ac.yd-effect-fade-bottom-left, .yd-play-se.yd-effect-fade-bottom-left { --yd-transform-opacity: 0; }

.yd-play-ho.yd-effect-fade-bottom-right, .yd-play-pr.yd-effect-fade-bottom-right, .yd-play-tg.yd-effect-fade-bottom-right, .yd-play-ac.yd-effect-fade-bottom-right, .yd-play-se.yd-effect-fade-bottom-right,
.yd-play-ho.yd-effect-slide-bottom-right, .yd-play-pr.yd-effect-slide-bottom-right, .yd-play-tg.yd-effect-slide-bottom-right, .yd-play-ac.yd-effect-slide-bottom-right, .yd-play-se.yd-effect-slide-bottom-right { --yd-transform-ty: var(--yd-anim-distance); --yd-transform-tx: var(--yd-anim-distance); }
.yd-play-ho.yd-effect-fade-bottom-right, .yd-play-pr.yd-effect-fade-bottom-right, .yd-play-tg.yd-effect-fade-bottom-right, .yd-play-ac.yd-effect-fade-bottom-right, .yd-play-se.yd-effect-fade-bottom-right { --yd-transform-opacity: 0; }

.yd-play-ho.yd-effect-scale, .yd-play-pr.yd-effect-scale, .yd-play-tg.yd-effect-scale, .yd-play-ac.yd-effect-scale, .yd-play-se.yd-effect-scale { --yd-transform-scale: var(--yd-anim-amount); } 
.yd-play-ho.yd-effect-rotate-left, .yd-play-pr.yd-effect-rotate-left, .yd-play-tg.yd-effect-rotate-left, .yd-play-ac.yd-effect-rotate-left, .yd-play-se.yd-effect-rotate-left { --yd-transform-rotate: calc(var(--yd-anim-angle) * -1); }
.yd-play-ho.yd-effect-rotate-right, .yd-play-pr.yd-effect-rotate-right, .yd-play-tg.yd-effect-rotate-right, .yd-play-ac.yd-effect-rotate-right, .yd-play-se.yd-effect-rotate-right { --yd-transform-rotate: var(--yd-anim-angle); }
.yd-play-ho.yd-effect-flip-x, .yd-play-pr.yd-effect-flip-x, .yd-play-tg.yd-effect-flip-x, .yd-play-ac.yd-effect-flip-x, .yd-play-se.yd-effect-flip-x { --yd-transform-rx: 180deg; }
.yd-play-ho.yd-effect-flip-y, .yd-play-pr.yd-effect-flip-y, .yd-play-tg.yd-effect-flip-y, .yd-play-ac.yd-effect-flip-y, .yd-play-se.yd-effect-flip-y { --yd-transform-ry: 180deg; }
.yd-play-ho.yd-effect-blur, .yd-play-pr.yd-effect-blur, .yd-play-tg.yd-effect-blur, .yd-play-ac.yd-effect-blur, .yd-play-se.yd-effect-blur { --yd-transform-blur: var(--yd-anim-blur-val); }

/* ==========================================
   SCROLL SCRUBBING
   ========================================== */
.yd-scrubbing.yd-base-fade { --yd-transform-opacity: var(--yd-anim-scrub); }
.yd-scrubbing.yd-effect-blur-in { --yd-transform-opacity: var(--yd-anim-scrub); --yd-transform-blur: calc(var(--yd-initial-blur) - (var(--yd-initial-blur) * var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-blur-out { --yd-transform-opacity: calc(1 - var(--yd-anim-scrub)); --yd-transform-blur: calc(var(--yd-initial-blur) * var(--yd-anim-scrub)); }

.yd-scrubbing.yd-effect-fade-up, .yd-scrubbing.yd-effect-slide-up, .yd-scrubbing.yd-effect-fade-down, .yd-scrubbing.yd-effect-slide-down,
.yd-scrubbing.yd-effect-fade-top-left, .yd-scrubbing.yd-effect-slide-top-left, .yd-scrubbing.yd-effect-fade-top-right, .yd-scrubbing.yd-effect-slide-top-right,
.yd-scrubbing.yd-effect-fade-bottom-left, .yd-scrubbing.yd-effect-slide-bottom-left, .yd-scrubbing.yd-effect-fade-bottom-right, .yd-scrubbing.yd-effect-slide-bottom-right {
  --yd-transform-ty: calc(var(--yd-initial-ty) - (var(--yd-initial-ty) * var(--yd-anim-scrub)));
}
.yd-scrubbing.yd-effect-fade-left, .yd-scrubbing.yd-effect-slide-left, .yd-scrubbing.yd-effect-fade-right, .yd-scrubbing.yd-effect-slide-right,
.yd-scrubbing.yd-effect-fade-top-left, .yd-scrubbing.yd-effect-slide-top-left, .yd-scrubbing.yd-effect-fade-top-right, .yd-scrubbing.yd-effect-slide-top-right,
.yd-scrubbing.yd-effect-fade-bottom-left, .yd-scrubbing.yd-effect-slide-bottom-left, .yd-scrubbing.yd-effect-fade-bottom-right, .yd-scrubbing.yd-effect-slide-bottom-right {
  --yd-transform-tx: calc(var(--yd-initial-tx) - (var(--yd-initial-tx) * var(--yd-anim-scrub)));
}
.yd-scrubbing.yd-effect-zoom { --yd-transform-scale: calc(var(--yd-initial-scale) + ((1 - var(--yd-initial-scale)) * var(--yd-anim-scrub))); --yd-transform-opacity: var(--yd-anim-scrub); }
.yd-scrubbing.yd-effect-rotate-left, .yd-scrubbing.yd-effect-rotate-right { --yd-transform-rotate: calc(var(--yd-initial-rotate) - (var(--yd-initial-rotate) * var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-flip-x { --yd-transform-rx: calc(var(--yd-initial-rx) - (var(--yd-initial-rx) * var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-flip-y { --yd-transform-ry: calc(var(--yd-initial-ry) - (var(--yd-initial-ry) * var(--yd-anim-scrub))); }


/* ==========================================
   INDUSTRY PRESETS (Keyframes bypass transitions)
   FIX P1: Keyframes now animate properties directly!
   ========================================== */
@keyframes yd-bounce { 0%, 20%, 50%, 80%, 100% { --yd-preset-ty: 0px; } 40% { --yd-preset-ty: -30px; } 60% { --yd-preset-ty: -15px; } }
@keyframes yd-pulse { 0% { --yd-preset-scale: 1; } 50% { --yd-preset-scale: 1.05; } 100% { --yd-preset-scale: 1; } }
@keyframes yd-shake { 0%, 100% { --yd-preset-tx: 0px; } 10%, 30%, 50%, 70%, 90% { --yd-preset-tx: -10px; } 20%, 40%, 60%, 80% { --yd-preset-tx: 10px; } }
@keyframes yd-float { 0%, 100% { --yd-preset-ty: 0px; } 50% { --yd-preset-ty: -10px; } }
@keyframes yd-flash { 0%, 50%, 100% { --yd-preset-opacity: 1; } 25%, 75% { --yd-preset-opacity: 0; } }

[class*="yd-play-"].yd-effect-bounce { animation: yd-bounce var(--yd-anim-duration) var(--yd-anim-ease) var(--yd-anim-delay) both; }
[class*="yd-play-"].yd-effect-pulse { animation: yd-pulse var(--yd-anim-duration) var(--yd-anim-ease) var(--yd-anim-delay) both; }
[class*="yd-play-"].yd-effect-shake { animation: yd-shake var(--yd-anim-duration) var(--yd-anim-ease) var(--yd-anim-delay) both; }
[class*="yd-play-"].yd-effect-float { animation: yd-float var(--yd-anim-duration) var(--yd-anim-ease) var(--yd-anim-delay) both infinite; }
[class*="yd-play-"].yd-effect-flash { animation: yd-flash var(--yd-anim-duration) var(--yd-anim-ease) var(--yd-anim-delay) both; }
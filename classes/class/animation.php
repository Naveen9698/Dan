/* ==========================================
   ydAnimation V17.0 LTS - CSS RENDER ENGINE
   Architecture: Property Registration Hardening & 3D Geometry Tilt Fixes
   ========================================== */

@property --yd-anim-scrub { syntax: '<number>'; inherits: false; initial-value: 0; }
@property --yd-sc-amount { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-sc-amount-base { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-ho-amount { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-ho-amount-base { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-pr-amount { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-pr-amount-base { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-tg-amount { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-tg-amount-base { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-ac-amount { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-ac-amount-base { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-se-amount { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-se-amount-base { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-vi-amount { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-vi-amount-base { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-lo-amount { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-lo-amount-base { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-entry-scale { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-initial-scale { syntax: '<number>'; inherits: false; initial-value: 1; }

@property --yd-preset-ty { syntax: '<length>'; inherits: false; initial-value: 0px; }
@property --yd-preset-tx { syntax: '<length>'; inherits: false; initial-value: 0px; }
@property --yd-preset-scale { syntax: '<number>'; inherits: false; initial-value: 1; }
@property --yd-preset-rotate { syntax: '<angle>'; inherits: false; initial-value: 0deg; }
@property --yd-preset-opacity { syntax: '<number>'; inherits: false; initial-value: 1; }

.yd-anim {
  --yd-initial-opacity: 1;
  --yd-initial-scale: 1; 
  --yd-initial-rotate: 0deg;
  --yd-initial-tx: 0px;
  --yd-initial-ty: 0px;
  --yd-initial-blur: 0px;
  --yd-initial-rx: 0deg;
  --yd-initial-ry: 0deg;

  --yd-preset-ty: 0px;
  --yd-preset-tx: 0px;
  --yd-preset-scale: 1;
  --yd-preset-rotate: 0deg;
  --yd-preset-opacity: 1;

  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
  transform-style: preserve-3d;
  perspective: 1000px;

  opacity: calc(var(--yd-entry-opacity, var(--yd-initial-opacity)) 
    * var(--yd-ho-opacity, 1) * var(--yd-pr-opacity, 1) * var(--yd-tg-opacity, 1) 
    * var(--yd-ac-opacity, 1) * var(--yd-se-opacity, 1) * var(--yd-sc-opacity, 1) * var(--yd-vi-opacity, 1) * var(--yd-preset-opacity));
    
  filter: blur(calc(var(--yd-entry-blur, var(--yd-initial-blur)) 
    + var(--yd-ho-blur, 0px) + var(--yd-pr-blur, 0px) + var(--yd-tg-blur, 0px) 
    + var(--yd-ac-blur, 0px) + var(--yd-se-blur, 0px) + var(--yd-sc-blur, 0px) + var(--yd-vi-blur, 0px)));
    
  will-change: transform, opacity, filter;
  transform-origin: var(--yd-ho-origin, var(--yd-tg-origin, var(--yd-pr-origin, var(--yd-ac-origin, var(--yd-se-origin, var(--yd-vi-origin, var(--yd-lo-origin, var(--yd-sc-origin, center))))))));

  transform:
    rotateX(calc(var(--yd-entry-rx, var(--yd-initial-rx)) 
      + var(--yd-ho-rx, 0deg) + var(--yd-pr-rx, 0deg) + var(--yd-tg-rx, 0deg) 
      + var(--yd-ac-rx, 0deg) + var(--yd-se-rx, 0deg) + var(--yd-sc-rx, 0deg)
      + var(--yd-vi-rx, 0deg) + var(--yd-lo-rx, 0deg)))
    rotateY(calc(var(--yd-entry-ry, var(--yd-initial-ry)) 
      + var(--yd-ho-ry, 0deg) + var(--yd-pr-ry, 0deg) + var(--yd-tg-ry, 0deg) 
      + var(--yd-ac-ry, 0deg) + var(--yd-se-ry, 0deg) + var(--yd-sc-ry, 0deg)
      + var(--yd-vi-ry, 0deg) + var(--yd-lo-ry, 0deg)))
    rotate(calc(var(--yd-entry-rotate, var(--yd-initial-rotate)) 
      + var(--yd-ho-angle, 0deg) + var(--yd-pr-angle, 0deg) + var(--yd-tg-angle, 0deg) 
      + var(--yd-ac-angle, 0deg) + var(--yd-se-angle, 0deg) + var(--yd-sc-angle, 0deg)
      + var(--yd-vi-angle, 0deg) + var(--yd-lo-angle, 0deg) + var(--yd-preset-rotate)))
    scale(calc(var(--yd-entry-scale, var(--yd-initial-scale)) 
      * var(--yd-ho-amount, 1) * var(--yd-pr-amount, 1) * var(--yd-tg-amount, 1) 
      * var(--yd-ac-amount, 1) * var(--yd-se-amount, 1) * var(--yd-sc-amount, 1)
      * var(--yd-vi-amount, 1) * var(--yd-lo-amount, 1) * var(--yd-preset-scale)))
    translateX(calc(var(--yd-entry-tx, var(--yd-initial-tx)) 
      + var(--yd-ho-tx, 0px) + var(--yd-pr-tx, 0px) + var(--yd-tg-tx, 0px) 
      + var(--yd-ac-tx, 0px) + var(--yd-se-tx, 0px) + var(--yd-sc-tx, 0px)
      + var(--yd-vi-tx, 0px) + var(--yd-lo-tx, 0px) + var(--yd-preset-tx)))
    translateY(calc(var(--yd-entry-ty, var(--yd-initial-ty)) 
      + var(--yd-ho-ty, 0px) + var(--yd-pr-ty, 0px) + var(--yd-tg-ty, 0px) 
      + var(--yd-ac-ty, 0px) + var(--yd-se-ty, 0px) + var(--yd-sc-ty, 0px)
      + var(--yd-vi-ty, 0px) + var(--yd-lo-ty, 0px) + var(--yd-preset-ty)));

  transition: 
    opacity var(--yd-active-duration, 500ms) var(--yd-active-ease, ease) var(--yd-active-delay, 0ms),
    transform var(--yd-active-duration, 500ms) var(--yd-active-ease, ease) var(--yd-active-delay, 0ms),
    filter var(--yd-active-duration, 500ms) var(--yd-active-ease, ease) var(--yd-active-delay, 0ms);
}

@media (prefers-reduced-motion: reduce) { .yd-anim { transition-duration: 0ms !important; animation-duration: 0ms !important; } }
.yd-scrubbing { transition: none !important; }

/* ==========================================
   TIMING CASCADE
   ========================================== */
.yd-play-lo { --yd-active-duration: var(--yd-lo-duration, 500ms); --yd-active-delay: var(--yd-lo-delay, 0ms); --yd-active-ease: var(--yd-lo-ease, ease); }
.yd-play-vi { --yd-active-duration: var(--yd-vi-duration, 500ms); --yd-active-delay: var(--yd-vi-delay, 0ms); --yd-active-ease: var(--yd-vi-ease, ease); }
.yd-play-sc { --yd-active-duration: var(--yd-sc-duration, 500ms); --yd-active-delay: var(--yd-sc-delay, 0ms); --yd-active-ease: var(--yd-sc-ease, ease); }
.yd-play-ho { --yd-active-duration: var(--yd-ho-duration, 500ms); --yd-active-delay: var(--yd-ho-delay, 0ms); --yd-active-ease: var(--yd-ho-ease, ease); }
.yd-play-pr { --yd-active-duration: var(--yd-pr-duration, 500ms); --yd-active-delay: var(--yd-pr-delay, 0ms); --yd-active-ease: var(--yd-pr-ease, ease); }
.yd-play-tg { --yd-active-duration: var(--yd-tg-duration, 500ms); --yd-active-delay: var(--yd-tg-delay, 0ms); --yd-active-ease: var(--yd-tg-ease, ease); }
.yd-play-ac { --yd-active-duration: var(--yd-ac-duration, 500ms); --yd-active-delay: var(--yd-ac-delay, 0ms); --yd-active-ease: var(--yd-ac-ease, ease); }
.yd-play-se { --yd-active-duration: var(--yd-se-duration, 500ms); --yd-active-delay: var(--yd-se-delay, 0ms); --yd-active-ease: var(--yd-se-ease, ease); }

/* ==========================================
   IMMUTABLE ENTRY STATES (For LO and VI only)
   ========================================== */
.yd-trigger-lo.yd-base-fade, .yd-trigger-vi.yd-base-fade { --yd-initial-opacity: 0; }

.yd-trigger-lo.yd-effect-fade-top, .yd-trigger-lo.yd-effect-slide-top { --yd-initial-ty: calc(var(--yd-lo-distance, 50px) * -1); }
.yd-trigger-vi.yd-effect-fade-top, .yd-trigger-vi.yd-effect-slide-top { --yd-initial-ty: calc(var(--yd-vi-distance, 50px) * -1); }
.yd-trigger-lo.yd-effect-fade-bottom, .yd-trigger-lo.yd-effect-slide-bottom { --yd-initial-ty: var(--yd-lo-distance, 50px); }
.yd-trigger-vi.yd-effect-fade-bottom, .yd-trigger-vi.yd-effect-slide-bottom { --yd-initial-ty: var(--yd-vi-distance, 50px); }
.yd-trigger-lo.yd-effect-fade-left, .yd-trigger-lo.yd-effect-slide-left { --yd-initial-tx: var(--yd-lo-distance, 50px); }
.yd-trigger-vi.yd-effect-fade-left, .yd-trigger-vi.yd-effect-slide-left { --yd-initial-tx: var(--yd-vi-distance, 50px); }
.yd-trigger-lo.yd-effect-fade-right, .yd-trigger-lo.yd-effect-slide-right { --yd-initial-tx: calc(var(--yd-lo-distance, 50px) * -1); }
.yd-trigger-vi.yd-effect-fade-right, .yd-trigger-vi.yd-effect-slide-right { --yd-initial-tx: calc(var(--yd-vi-distance, 50px) * -1); }

.yd-trigger-lo.yd-effect-fade-top-left, .yd-trigger-lo.yd-effect-slide-top-left { --yd-initial-ty: calc(var(--yd-lo-distance, 50px) * -1); --yd-initial-tx: calc(var(--yd-lo-distance, 50px) * -1); }
.yd-trigger-vi.yd-effect-fade-top-left, .yd-trigger-vi.yd-effect-slide-top-left { --yd-initial-ty: calc(var(--yd-vi-distance, 50px) * -1); --yd-initial-tx: calc(var(--yd-vi-distance, 50px) * -1); }
.yd-trigger-lo.yd-effect-fade-top-right, .yd-trigger-lo.yd-effect-slide-top-right { --yd-initial-ty: calc(var(--yd-lo-distance, 50px) * -1); --yd-initial-tx: var(--yd-lo-distance, 50px); }
.yd-trigger-vi.yd-effect-fade-top-right, .yd-trigger-vi.yd-effect-slide-top-right { --yd-initial-ty: calc(var(--yd-vi-distance, 50px) * -1); --yd-initial-tx: var(--yd-vi-distance, 50px); }
.yd-trigger-lo.yd-effect-fade-bottom-left, .yd-trigger-lo.yd-effect-slide-bottom-left { --yd-initial-ty: var(--yd-lo-distance, 50px); --yd-initial-tx: calc(var(--yd-lo-distance, 50px) * -1); }
.yd-trigger-vi.yd-effect-fade-bottom-left, .yd-trigger-vi.yd-effect-slide-bottom-left { --yd-initial-ty: var(--yd-vi-distance, 50px); --yd-initial-tx: calc(var(--yd-vi-distance, 50px) * -1); }
.yd-trigger-lo.yd-effect-fade-bottom-right, .yd-trigger-lo.yd-effect-slide-bottom-right { --yd-initial-ty: var(--yd-lo-distance, 50px); --yd-initial-tx: var(--yd-lo-distance, 50px); }
.yd-trigger-vi.yd-effect-fade-bottom-right, .yd-trigger-vi.yd-effect-slide-bottom-right { --yd-initial-ty: var(--yd-vi-distance, 50px); --yd-initial-tx: var(--yd-vi-distance, 50px); }

.yd-trigger-lo.yd-base-zoom { --yd-initial-opacity: 0; --yd-initial-scale: var(--yd-lo-amount-base, 0.5); }
.yd-trigger-vi.yd-base-zoom { --yd-initial-opacity: 0; --yd-initial-scale: var(--yd-vi-amount-base, 0.5); }
.yd-trigger-lo.yd-effect-blur-in { --yd-initial-opacity: 0; --yd-initial-blur: var(--yd-lo-blur-val, 8px); }
.yd-trigger-vi.yd-effect-blur-in { --yd-initial-opacity: 0; --yd-initial-blur: var(--yd-vi-blur-val, 8px); }
.yd-trigger-lo.yd-effect-blur-out, .yd-trigger-vi.yd-effect-blur-out { --yd-initial-blur: 0px; }

/* FIX V17: Flip entry states firmly anchored to mapping base */
.yd-trigger-lo.yd-effect-flip-x { --yd-initial-rx: var(--yd-lo-rx-base, 180deg); }
.yd-trigger-vi.yd-effect-flip-x { --yd-initial-rx: var(--yd-vi-rx-base, 180deg); }
.yd-trigger-lo.yd-effect-flip-y { --yd-initial-ry: var(--yd-lo-ry-base, 180deg); }
.yd-trigger-vi.yd-effect-flip-y { --yd-initial-ry: var(--yd-vi-ry-base, 180deg); }

/* ==========================================
   ENTRY PLAY STATES (Routing channels to 0px/1)
   ========================================== */
.yd-play-lo, .yd-play-vi {
  --yd-entry-opacity: 1;
  --yd-entry-scale: 1; 
  --yd-entry-rotate: 0deg;
  --yd-entry-tx: 0px;
  --yd-entry-ty: 0px;
  --yd-entry-blur: 0px;
  --yd-entry-rx: 0deg;
  --yd-entry-ry: 0deg;
}

/* ==========================================
   INTERACTIVE PLAY STATES 
   ========================================== */
.yd-play-ho.yd-base-fade { --yd-ho-opacity: 0; }
.yd-play-pr.yd-base-fade { --yd-pr-opacity: 0; }
.yd-play-tg.yd-base-fade { --yd-tg-opacity: 0; }
.yd-play-ac.yd-base-fade { --yd-ac-opacity: 0; }
.yd-play-se.yd-base-fade { --yd-se-opacity: 0; }

.yd-play-ho.yd-effect-fade-top, .yd-play-ho.yd-effect-slide-top { --yd-ho-ty: calc(var(--yd-ho-distance, 50px) * -1); }
.yd-play-pr.yd-effect-fade-top, .yd-play-pr.yd-effect-slide-top { --yd-pr-ty: calc(var(--yd-pr-distance, 50px) * -1); }
.yd-play-tg.yd-effect-fade-top, .yd-play-tg.yd-effect-slide-top { --yd-tg-ty: calc(var(--yd-tg-distance, 50px) * -1); }
.yd-play-ac.yd-effect-fade-top, .yd-play-ac.yd-effect-slide-top { --yd-ac-ty: calc(var(--yd-ac-distance, 50px) * -1); }
.yd-play-se.yd-effect-fade-top, .yd-play-se.yd-effect-slide-top { --yd-se-ty: calc(var(--yd-se-distance, 50px) * -1); }

.yd-play-ho.yd-effect-fade-bottom, .yd-play-ho.yd-effect-slide-bottom { --yd-ho-ty: var(--yd-ho-distance, 50px); }
.yd-play-pr.yd-effect-fade-bottom, .yd-play-pr.yd-effect-slide-bottom { --yd-pr-ty: var(--yd-pr-distance, 50px); }
.yd-play-tg.yd-effect-fade-bottom, .yd-play-tg.yd-effect-slide-bottom { --yd-tg-ty: var(--yd-tg-distance, 50px); }
.yd-play-ac.yd-effect-fade-bottom, .yd-play-ac.yd-effect-slide-bottom { --yd-ac-ty: var(--yd-ac-distance, 50px); }
.yd-play-se.yd-effect-fade-bottom, .yd-play-se.yd-effect-slide-bottom { --yd-se-ty: var(--yd-se-distance, 50px); }

.yd-play-ho.yd-effect-fade-left, .yd-play-ho.yd-effect-slide-left { --yd-ho-tx: calc(var(--yd-ho-distance, 50px) * -1); }
.yd-play-pr.yd-effect-fade-left, .yd-play-pr.yd-effect-slide-left { --yd-pr-tx: calc(var(--yd-pr-distance, 50px) * -1); }
.yd-play-tg.yd-effect-fade-left, .yd-play-tg.yd-effect-slide-left { --yd-tg-tx: calc(var(--yd-tg-distance, 50px) * -1); }
.yd-play-ac.yd-effect-fade-left, .yd-play-ac.yd-effect-slide-left { --yd-ac-tx: calc(var(--yd-ac-distance, 50px) * -1); }
.yd-play-se.yd-effect-fade-left, .yd-play-se.yd-effect-slide-left { --yd-se-tx: calc(var(--yd-se-distance, 50px) * -1); }

.yd-play-ho.yd-effect-fade-right, .yd-play-ho.yd-effect-slide-right { --yd-ho-tx: var(--yd-ho-distance, 50px); }
.yd-play-pr.yd-effect-fade-right, .yd-play-pr.yd-effect-slide-right { --yd-pr-tx: var(--yd-pr-distance, 50px); }
.yd-play-tg.yd-effect-fade-right, .yd-play-tg.yd-effect-slide-right { --yd-tg-tx: var(--yd-tg-distance, 50px); }
.yd-play-ac.yd-effect-fade-right, .yd-play-ac.yd-effect-slide-right { --yd-ac-tx: var(--yd-ac-distance, 50px); }
.yd-play-se.yd-effect-fade-right, .yd-play-se.yd-effect-slide-right { --yd-se-tx: var(--yd-se-distance, 50px); }

.yd-play-ho.yd-effect-fade-top-left, .yd-play-ho.yd-effect-slide-top-left { --yd-ho-ty: calc(var(--yd-ho-distance, 50px) * -1); --yd-ho-tx: calc(var(--yd-ho-distance, 50px) * -1); }
.yd-play-pr.yd-effect-fade-top-left, .yd-play-pr.yd-effect-slide-top-left { --yd-pr-ty: calc(var(--yd-pr-distance, 50px) * -1); --yd-pr-tx: calc(var(--yd-pr-distance, 50px) * -1); }
.yd-play-tg.yd-effect-fade-top-left, .yd-play-tg.yd-effect-slide-top-left { --yd-tg-ty: calc(var(--yd-tg-distance, 50px) * -1); --yd-tg-tx: calc(var(--yd-tg-distance, 50px) * -1); }
.yd-play-ac.yd-effect-fade-top-left, .yd-play-ac.yd-effect-slide-top-left { --yd-ac-ty: calc(var(--yd-ac-distance, 50px) * -1); --yd-ac-tx: calc(var(--yd-ac-distance, 50px) * -1); }
.yd-play-se.yd-effect-fade-top-left, .yd-play-se.yd-effect-slide-top-left { --yd-se-ty: calc(var(--yd-se-distance, 50px) * -1); --yd-se-tx: calc(var(--yd-se-distance, 50px) * -1); }

.yd-play-ho.yd-effect-fade-top-right, .yd-play-ho.yd-effect-slide-top-right { --yd-ho-ty: calc(var(--yd-ho-distance, 50px) * -1); --yd-ho-tx: var(--yd-ho-distance, 50px); }
.yd-play-pr.yd-effect-fade-top-right, .yd-play-pr.yd-effect-slide-top-right { --yd-pr-ty: calc(var(--yd-pr-distance, 50px) * -1); --yd-pr-tx: var(--yd-pr-distance, 50px); }
.yd-play-tg.yd-effect-fade-top-right, .yd-play-tg.yd-effect-slide-top-right { --yd-tg-ty: calc(var(--yd-tg-distance, 50px) * -1); --yd-tg-tx: var(--yd-tg-distance, 50px); }
.yd-play-ac.yd-effect-fade-top-right, .yd-play-ac.yd-effect-slide-top-right { --yd-ac-ty: calc(var(--yd-ac-distance, 50px) * -1); --yd-ac-tx: var(--yd-ac-distance, 50px); }
.yd-play-se.yd-effect-fade-top-right, .yd-play-se.yd-effect-slide-top-right { --yd-se-ty: calc(var(--yd-se-distance, 50px) * -1); --yd-se-tx: var(--yd-se-distance, 50px); }

.yd-play-ho.yd-effect-fade-bottom-left, .yd-play-ho.yd-effect-slide-bottom-left { --yd-ho-ty: var(--yd-ho-distance, 50px); --yd-ho-tx: calc(var(--yd-ho-distance, 50px) * -1); }
.yd-play-pr.yd-effect-fade-bottom-left, .yd-play-pr.yd-effect-slide-bottom-left { --yd-pr-ty: var(--yd-pr-distance, 50px); --yd-pr-tx: calc(var(--yd-pr-distance, 50px) * -1); }
.yd-play-tg.yd-effect-fade-bottom-left, .yd-play-tg.yd-effect-slide-bottom-left { --yd-tg-ty: var(--yd-tg-distance, 50px); --yd-tg-tx: calc(var(--yd-tg-distance, 50px) * -1); }
.yd-play-ac.yd-effect-fade-bottom-left, .yd-play-ac.yd-effect-slide-bottom-left { --yd-ac-ty: var(--yd-ac-distance, 50px); --yd-ac-tx: calc(var(--yd-ac-distance, 50px) * -1); }
.yd-play-se.yd-effect-fade-bottom-left, .yd-play-se.yd-effect-slide-bottom-left { --yd-se-ty: var(--yd-se-distance, 50px); --yd-se-tx: calc(var(--yd-se-distance, 50px) * -1); }

.yd-play-ho.yd-effect-fade-bottom-right, .yd-play-ho.yd-effect-slide-bottom-right { --yd-ho-ty: var(--yd-ho-distance, 50px); --yd-ho-tx: var(--yd-ho-distance, 50px); }
.yd-play-pr.yd-effect-fade-bottom-right, .yd-play-pr.yd-effect-slide-bottom-right { --yd-pr-ty: var(--yd-pr-distance, 50px); --yd-pr-tx: var(--yd-pr-distance, 50px); }
.yd-play-tg.yd-effect-fade-bottom-right, .yd-play-tg.yd-effect-slide-bottom-right { --yd-tg-ty: var(--yd-tg-distance, 50px); --yd-tg-tx: var(--yd-tg-distance, 50px); }
.yd-play-ac.yd-effect-fade-bottom-right, .yd-play-ac.yd-effect-slide-bottom-right { --yd-ac-ty: var(--yd-ac-distance, 50px); --yd-ac-tx: var(--yd-ac-distance, 50px); }
.yd-play-se.yd-effect-fade-bottom-right, .yd-play-se.yd-effect-slide-bottom-right { --yd-se-ty: var(--yd-se-distance, 50px); --yd-se-tx: var(--yd-se-distance, 50px); }

.yd-play-ho.yd-base-scale, .yd-play-ho.yd-base-zoom { --yd-ho-amount: var(--yd-ho-amount-base, 1.1); } 
.yd-play-pr.yd-base-scale, .yd-play-pr.yd-base-zoom { --yd-pr-amount: var(--yd-pr-amount-base, 1.1); } 
.yd-play-tg.yd-base-scale, .yd-play-tg.yd-base-zoom { --yd-tg-amount: var(--yd-tg-amount-base, 1.1); } 
.yd-play-ac.yd-base-scale, .yd-play-ac.yd-base-zoom { --yd-ac-amount: var(--yd-ac-amount-base, 1.1); } 
.yd-play-se.yd-base-scale, .yd-play-se.yd-base-zoom { --yd-se-amount: var(--yd-se-amount-base, 1.1); } 

.yd-play-ho.yd-effect-rotate-left { --yd-ho-angle: calc(var(--yd-ho-angle-base, 90deg) * -1); }
.yd-play-ho.yd-effect-rotate-right { --yd-ho-angle: var(--yd-ho-angle-base, 90deg); }
.yd-play-pr.yd-effect-rotate-left { --yd-pr-angle: calc(var(--yd-pr-angle-base, 90deg) * -1); }
.yd-play-pr.yd-effect-rotate-right { --yd-pr-angle: var(--yd-pr-angle-base, 90deg); }
.yd-play-tg.yd-effect-rotate-left { --yd-tg-angle: calc(var(--yd-tg-angle-base, 90deg) * -1); }
.yd-play-tg.yd-effect-rotate-right { --yd-tg-angle: var(--yd-tg-angle-base, 90deg); }
.yd-play-ac.yd-effect-rotate-left { --yd-ac-angle: calc(var(--yd-ac-angle-base, 90deg) * -1); }
.yd-play-ac.yd-effect-rotate-right { --yd-ac-angle: var(--yd-ac-angle-base, 90deg); }
.yd-play-se.yd-effect-rotate-left { --yd-se-angle: calc(var(--yd-se-angle-base, 90deg) * -1); }
.yd-play-se.yd-effect-rotate-right { --yd-se-angle: var(--yd-se-angle-base, 90deg); }

/* FIX V17: Explicit play state bindings for flip geometries */
.yd-play-ho.yd-effect-flip-x { --yd-ho-rx: var(--yd-ho-rx-base, 45deg); }
.yd-play-pr.yd-effect-flip-x { --yd-pr-rx: var(--yd-pr-rx-base, 45deg); }
.yd-play-tg.yd-effect-flip-x { --yd-tg-rx: var(--yd-tg-rx-base, 45deg); }
.yd-play-ac.yd-effect-flip-x { --yd-ac-rx: var(--yd-ac-rx-base, 45deg); }
.yd-play-se.yd-effect-flip-x { --yd-se-rx: var(--yd-se-rx-base, 45deg); }

.yd-play-ho.yd-effect-flip-y { --yd-ho-ry: var(--yd-ho-ry-base, 45deg); }
.yd-play-pr.yd-effect-flip-y { --yd-pr-ry: var(--yd-pr-ry-base, 45deg); }
.yd-play-tg.yd-effect-flip-y { --yd-tg-ry: var(--yd-tg-ry-base, 45deg); }
.yd-play-ac.yd-effect-flip-y { --yd-ac-ry: var(--yd-ac-ry-base, 45deg); }
.yd-play-se.yd-effect-flip-y { --yd-se-ry: var(--yd-se-ry-base, 45deg); }

.yd-play-ho.yd-base-blur { --yd-ho-blur: var(--yd-ho-blur-val, 8px); } 
.yd-play-pr.yd-base-blur { --yd-pr-blur: var(--yd-pr-blur-val, 8px); }
.yd-play-tg.yd-base-blur { --yd-tg-blur: var(--yd-tg-blur-val, 8px); }
.yd-play-ac.yd-base-blur { --yd-ac-blur: var(--yd-ac-blur-val, 8px); }
.yd-play-se.yd-base-blur { --yd-se-blur: var(--yd-se-blur-val, 8px); }

/* ==========================================
   SCROLL SCRUBBING
   ========================================== */
.yd-trigger-sc.yd-base-fade { --yd-sc-opacity: 0; }
.yd-trigger-sc.yd-effect-blur-in { --yd-sc-blur: var(--yd-sc-blur-val, 8px); }
.yd-trigger-sc.yd-base-scale { --yd-sc-amount: 1; }

.yd-trigger-sc.yd-effect-fade-top, .yd-trigger-sc.yd-effect-slide-top { --yd-sc-ty: calc(var(--yd-sc-distance, 50px) * -1); }
.yd-trigger-sc.yd-effect-fade-bottom, .yd-trigger-sc.yd-effect-slide-bottom { --yd-sc-ty: var(--yd-sc-distance, 50px); }
.yd-trigger-sc.yd-effect-fade-left, .yd-trigger-sc.yd-effect-slide-left { --yd-sc-tx: var(--yd-sc-distance, 50px); }
.yd-trigger-sc.yd-effect-fade-right, .yd-trigger-sc.yd-effect-slide-right { --yd-sc-tx: calc(var(--yd-sc-distance, 50px) * -1); }

.yd-trigger-sc.yd-effect-fade-top-left, .yd-trigger-sc.yd-effect-slide-top-left { --yd-sc-ty: calc(var(--yd-sc-distance, 50px) * -1); --yd-sc-tx: calc(var(--yd-sc-distance, 50px) * -1); }
.yd-trigger-sc.yd-effect-fade-top-right, .yd-trigger-sc.yd-effect-slide-top-right { --yd-sc-ty: calc(var(--yd-sc-distance, 50px) * -1); --yd-sc-tx: var(--yd-sc-distance, 50px); }
.yd-trigger-sc.yd-effect-fade-bottom-left, .yd-trigger-sc.yd-effect-slide-bottom-left { --yd-sc-ty: var(--yd-sc-distance, 50px); --yd-sc-tx: calc(var(--yd-sc-distance, 50px) * -1); }
.yd-trigger-sc.yd-effect-fade-bottom-right, .yd-trigger-sc.yd-effect-slide-bottom-right { --yd-sc-ty: var(--yd-sc-distance, 50px); --yd-sc-tx: var(--yd-sc-distance, 50px); }

.yd-scrubbing.yd-base-fade, .yd-scrubbing.yd-base-zoom { --yd-sc-opacity: var(--yd-anim-scrub); }
.yd-scrubbing.yd-effect-blur-in { --yd-sc-blur: calc(var(--yd-sc-blur-val, 8px) * (1 - var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-blur-out { --yd-sc-blur: calc(var(--yd-sc-blur-val, 8px) * var(--yd-anim-scrub)); }

.yd-scrubbing.yd-effect-fade-top, .yd-scrubbing.yd-effect-slide-top { --yd-sc-ty: calc(var(--yd-sc-distance, 50px) * -1 * (1 - var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-fade-bottom, .yd-scrubbing.yd-effect-slide-bottom { --yd-sc-ty: calc(var(--yd-sc-distance, 50px) * (1 - var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-fade-left, .yd-scrubbing.yd-effect-slide-left { --yd-sc-tx: calc(var(--yd-sc-distance, 50px) * (1 - var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-fade-right, .yd-scrubbing.yd-effect-slide-right { --yd-sc-tx: calc(var(--yd-sc-distance, 50px) * -1 * (1 - var(--yd-anim-scrub))); }

.yd-scrubbing.yd-effect-fade-top-left, .yd-scrubbing.yd-effect-slide-top-left { --yd-sc-ty: calc(var(--yd-sc-distance, 50px) * -1 * (1 - var(--yd-anim-scrub))); --yd-sc-tx: calc(var(--yd-sc-distance, 50px) * -1 * (1 - var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-fade-top-right, .yd-scrubbing.yd-effect-slide-top-right { --yd-sc-ty: calc(var(--yd-sc-distance, 50px) * -1 * (1 - var(--yd-anim-scrub))); --yd-sc-tx: calc(var(--yd-sc-distance, 50px) * (1 - var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-fade-bottom-left, .yd-scrubbing.yd-effect-slide-bottom-left { --yd-sc-ty: calc(var(--yd-sc-distance, 50px) * (1 - var(--yd-anim-scrub))); --yd-sc-tx: calc(var(--yd-sc-distance, 50px) * -1 * (1 - var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-fade-bottom-right, .yd-scrubbing.yd-effect-slide-bottom-right { --yd-sc-ty: calc(var(--yd-sc-distance, 50px) * (1 - var(--yd-anim-scrub))); --yd-sc-tx: calc(var(--yd-sc-distance, 50px) * (1 - var(--yd-anim-scrub))); }

.yd-scrubbing.yd-effect-zoom, .yd-scrubbing.yd-effect-zoom-in { --yd-sc-amount: calc(var(--yd-sc-amount-base, 0.5) + ((1 - var(--yd-sc-amount-base, 0.5)) * var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-zoom-out { --yd-sc-amount: calc(var(--yd-sc-amount-base, 1.5) - ((var(--yd-sc-amount-base, 1.5) - 1) * var(--yd-anim-scrub))); }

.yd-scrubbing.yd-base-scale { --yd-sc-amount: calc(1 + ((var(--yd-sc-amount-base, 1.1) - 1) * var(--yd-anim-scrub))); }
.yd-scrubbing.yd-effect-rotate-right { --yd-sc-angle: calc(var(--yd-sc-angle-base, 90deg) * var(--yd-anim-scrub)); }
.yd-scrubbing.yd-effect-rotate-left { --yd-sc-angle: calc(calc(var(--yd-sc-angle-base, 90deg) * -1) * var(--yd-anim-scrub)); }

/* FIX V17: Map scroll flip strictly to the persistent base angle to preserve semantics */
.yd-scrubbing.yd-effect-flip-x { --yd-sc-rx: calc(var(--yd-sc-rx-base, 180deg) * var(--yd-anim-scrub)); }
.yd-scrubbing.yd-effect-flip-y { --yd-sc-ry: calc(var(--yd-sc-ry-base, 180deg) * var(--yd-anim-scrub)); }

/* ==========================================
   INDUSTRY PRESETS 
   ========================================== */
@keyframes yd-bounce { 0%, 20%, 50%, 80%, 100% { --yd-preset-ty: 0px; } 40% { --yd-preset-ty: -30px; } 60% { --yd-preset-ty: -15px; } }
@keyframes yd-pulse { 0% { --yd-preset-scale: 1; } 50% { --yd-preset-scale: 1.05; } 100% { --yd-preset-scale: 1; } }
@keyframes yd-shake { 0%, 100% { --yd-preset-tx: 0px; } 10%, 30%, 50%, 70%, 90% { --yd-preset-tx: -10px; } 20%, 40%, 60%, 80% { --yd-preset-tx: 10px; } }
@keyframes yd-float { 0%, 100% { --yd-preset-ty: 0px; } 50% { --yd-preset-ty: -10px; } }
@keyframes yd-flash { 0%, 50%, 100% { --yd-preset-opacity: 1; } 25%, 75% { --yd-preset-opacity: 0; } }
@keyframes yd-wobble { 0%, 100% { --yd-preset-tx: 0px; --yd-preset-rotate: 0deg; } 15% { --yd-preset-tx: -25px; --yd-preset-rotate: -5deg; } 30% { --yd-preset-tx: 20px; --yd-preset-rotate: 3deg; } 45% { --yd-preset-tx: -15px; --yd-preset-rotate: -3deg; } 60% { --yd-preset-tx: 10px; --yd-preset-rotate: 2deg; } 75% { --yd-preset-tx: -5px; --yd-preset-rotate: -1deg; } }
@keyframes yd-swing { 20% { --yd-preset-rotate: 15deg; } 40% { --yd-preset-rotate: -10deg; } 60% { --yd-preset-rotate: 5deg; } 80% { --yd-preset-rotate: -5deg; } 100% { --yd-preset-rotate: 0deg; } }
@keyframes yd-heartbeat { 0% { --yd-preset-scale: 1; } 14% { --yd-preset-scale: 1.3; } 28% { --yd-preset-scale: 1; } 42% { --yd-preset-scale: 1.3; } 70% { --yd-preset-scale: 1; } }

[class*="yd-play-"].yd-effect-bounce { animation: yd-bounce var(--yd-active-duration, 500ms) var(--yd-active-ease, ease) var(--yd-active-delay, 0ms) both; }
[class*="yd-play-"].yd-effect-pulse { animation: yd-pulse var(--yd-active-duration, 500ms) var(--yd-active-ease, ease) var(--yd-active-delay, 0ms) both; }
[class*="yd-play-"].yd-effect-shake { animation: yd-shake var(--yd-active-duration, 500ms) var(--yd-active-ease, ease) var(--yd-active-delay, 0ms) both; }
[class*="yd-play-"].yd-effect-float { animation: yd-float var(--yd-active-duration, 500ms) var(--yd-active-ease, ease) var(--yd-active-delay, 0ms) both infinite; }
[class*="yd-play-"].yd-effect-flash { animation: yd-flash var(--yd-active-duration, 500ms) var(--yd-active-ease, ease) var(--yd-active-delay, 0ms) both; }
[class*="yd-play-"].yd-effect-wobble { animation: yd-wobble var(--yd-active-duration, 1000ms) var(--yd-active-ease, ease) var(--yd-active-delay, 0ms) both; }
[class*="yd-play-"].yd-effect-swing { animation: yd-swing var(--yd-active-duration, 1000ms) var(--yd-active-ease, ease) var(--yd-active-delay, 0ms) both; }
[class*="yd-play-"].yd-effect-heartbeat { animation: yd-heartbeat var(--yd-active-duration, 1300ms) var(--yd-active-ease, ease-in-out) var(--yd-active-delay, 0ms) both; }
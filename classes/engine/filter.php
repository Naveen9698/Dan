[class*="blur-"],
[class*="brightness-"],
[class*="contrast-"],
[class*="dsw-"],
[class*="hue-"],
[class*="grayscale"],
[class*="invert"],
[class*="saturate-"],
[class*="sepia"]{         
  filter:
    blur(var(--blur, 0px))
    brightness(var(--brightness, 100%))
    contrast(var(--contrast, 100%))
    drop-shadow(var(--dsw, 0 0 0 rgba(0,0,0,0)))
    grayscale(var(--grayscale, 0%))
    hue-rotate(var(--hue, 0deg))
    invert(var(--invert, 0%))
    saturate(var(--saturate, 100%))
    sepia(var(--sepia, 0%));
}
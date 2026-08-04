[class^="blr-"],
[class*=" blr-"]{
  filter:
    blur(var(--blr, 0px))
    brightness(var(--brightness, 100%))
    contrast(var(--contrast, 100%))
    drop-shadow(var(--dsw, 0 0 0 rgba(0,0,0,0)))
    grayscale(var(--grayscale, 0%))
    hue-rotate(var(--hue, 0deg))
    invert(var(--invert, 0%))
    saturate(var(--saturate, 100%))
    sepia(var(--sepia, 0%));
}

.blr-0px  { --blr: 0px;  }
.blr-1px  { --blr: 1px;  }
.blr-2px  { --blr: 2px;  }
.blr-3px  { --blr: 3px;  }
.blr-4px  { --blr: 4px;  }
.blr-5px  { --blr: 5px;  }
.blr-6px  { --blr: 6px;  }
.blr-7px  { --blr: 7px;  }
.blr-8px  { --blr: 8px;  }
.blr-9px  { --blr: 9px;  }
.blr-10px { --blr: 10px; }

[class^="hs:blr-"]:hover,
[class*=" hs:blr-"]:hover,
.chs-parent:hover [class^="hs:blr-"]:hover,
.chs-parent:hover [class*=" hs:blr-"]:hover{
  --blr: var(--hs\:blr);
}

.hs\:blr-0px  { --hs\:blr: 0px;  }
.hs\:blr-1px  { --hs\:blr: 1px;  }
.hs\:blr-2px  { --hs\:blr: 2px;  }
.hs\:blr-3px  { --hs\:blr: 3px;  }
.hs\:blr-4px  { --hs\:blr: 4px;  }
.hs\:blr-5px  { --hs\:blr: 5px;  }
.hs\:blr-6px  { --hs\:blr: 6px;  }
.hs\:blr-7px  { --hs\:blr: 7px;  }
.hs\:blr-8px  { --hs\:blr: 8px;  }
.hs\:blr-9px  { --hs\:blr: 9px;  }
.hs\:blr-10px { --hs\:blr: 10px; }

.chs-parent:hover [class^="chs:blr-"],
.chs-parent:hover [class*=" chs:blr-"]{
  --blr: var(--chs\:blr);
}

.chs\:blr-0px  { --chs\:blr: 0px;  }
.chs\:blr-1px  { --chs\:blr: 1px;  }
.chs\:blr-2px  { --chs\:blr: 2px;  }
.chs\:blr-3px  { --chs\:blr: 3px;  }
.chs\:blr-4px  { --chs\:blr: 4px;  }
.chs\:blr-5px  { --chs\:blr: 5px;  }
.chs\:blr-6px  { --chs\:blr: 6px;  }
.chs\:blr-7px  { --chs\:blr: 7px;  }
.chs\:blr-8px  { --chs\:blr: 8px;  }
.chs\:blr-9px  { --chs\:blr: 9px;  }
.chs\:blr-10px { --chs\:blr: 10px; }


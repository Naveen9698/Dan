[class^="tt-"],         [class*=" tt-"],
[class^="tr-"],         [class*=" tr-"],
[class^="tb-"],         [class*=" tb-"],
[class^="tl-"],         [class*=" tl-"],
[class^="scale-"],      [class*=" scale-"],
[class^="skewx-"],      [class*=" skewx-"],
[class^="skewy-"],      [class*=" skewy-"],
[class^="rotate-"],     [class*=" rotate-"],

[class^="hs-tt-"],      [class*=" hs-tt-"],
[class^="hs-tr-"],      [class*=" hs-tr-"],
[class^="hs-tb-"],      [class*=" hs-tb-"],
[class^="hs-tl-"],      [class*=" hs-tl-"],
[class^="hs-scale-"],   [class*=" hs-scale-"],
[class^="hs-skewx-"],   [class*=" hs-skewx-"],
[class^="hs-skewy-"],   [class*=" hs-skewy-"],
[class^="hs-rotate-"],  [class*=" hs-rotate-"],

[class^="chs-tt-"],     [class*=" chs-tt-"],
[class^="chs-tr-"],     [class*=" chs-tr-"],
[class^="chs-tb-"],     [class*=" chs-tb-"],
[class^="chs-tl-"],     [class*=" chs-tl-"],
[class^="chs-scale-"],  [class*=" chs-scale-"], 
[class^="chs-skewx-"],  [class*=" chs-skewx-"],
[class^="chs-skewy-"],  [class*=" chs-skewy-"],
[class^="chs-rotate-"], [class*=" chs-rotate-"]{
  transform:
    rotate(var(--rotate-value, 0deg))
    scale(var(--scale-value, 1))
    skewX(var(--skewx-value, 0deg))
    skewY(var(--skewy-value, 0deg))
    translateX(calc(var(--translate-right, 0px) - var(--translate-left, 0px)))
    translateY(calc(var(--translate-bottom, 0px) - var(--translate-top, 0px)));
}
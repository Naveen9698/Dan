<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="transform-system">Transform System</h2>

<section class="px-md stack-y-sm">

  <h3>Transform Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform.php'; ?></code></pre>
  </div>

  <h3>Origin Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-origin.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>origin-*</b> defines the pivot point used by Scale, Rotate and Skew<br>
    🟢 Supports center, edge and corner origins<br>
    🟢 Controls where Scale expands from and where Rotate and Skew pivots from<br>
    🟡 Has no visual effect until used with Scale, Rotate or Skew<br>
    🟡 Transform order is fixed: Rotate → Scale → SkewX → SkewY → TranslateX → TranslateY <br>
    🔴 Origin utilities do not combine — the last origin utility wins<br>
    🔴 Multiple Scale utilities do not combine <br>
    🔴 Use <b>origin-tl</b>, <b>origin-tr</b>, <b>origin-bl</b> or <b>origin-br</b> for corner origins
  </p>


  <h3>Rotate Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/transform-rotate.php'; ?>

}</code></pre>
  </div>

  <h3>Rotate Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-rotate.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-rotate-add.php'; ?></code></pre>
  </div>

  <h3>Rotate Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-rotate-hs.php'; ?></code></pre>
  </div>

  <h3>Rotate Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-rotate-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-rotate-add-hs.php'; ?></code></pre>
  </div>

  <h3>Rotate Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-rotate-chs.php'; ?></code></pre>
  </div>

  <h3>Rotate Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-rotate-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-rotate-add-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>rotate-*</b> rotates rendered orientation in degrees<br>
    🟢 Supports 0°–360° in 10° increments<br>
    🟢 Supports additive precision through <b>rotate-add-*</b><br>
    🟡 Rotation occurs from the current Transform Origin <br>
    🟢 <b>ho:rotate-*</b> applies Rotate on self hover<br>
    🟢 Supports additive precision through <b>ho:rotate-add-*</b><br>
    🟢 Ideal for indicators, menus and interactive controls <br>
    🟢 <b>cho:rotate-*</b> applies Rotate from a <b>cho:parent</b> hover<br>
    🟢 Supports additive precision through <b>cho:rotate-add-*</b><br>
    🟢 Useful for coordinated group interactions
  </p>


  <h3> Rotate Live Demo</h3>

  <?php include 'demo/transform-rotate.php'; ?>

  <h3>Scale Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/transform-scale.php'; ?>

}</code></pre>
  </div>

  <h3>Scale Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-scale.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-scale-add.php'; ?></code></pre>
  </div>

  <h3>Scale Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-scale-hs.php'; ?></code></pre>
  </div>

  <h3>Scale Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-scale-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-scale-add-hs.php'; ?></code></pre>
  </div>

  <h3>Scale Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-scale-chs.php'; ?></code></pre>
  </div>

  <h3>Scale Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-scale-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-scale-add-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>scale-*p</b> scales rendered size using percentages<br>
    🟢 <b>scale-100p</b> represents the original size (100%)<br>
    🟢 Supports values from <b>0%–200%</b><br>
    🟢 Supports additive precision through <b>scale-add-*p</b><br>
    🟢 Example: <b>scale-110p + scale-add-3p = 113%</b><br>
    🟡 Visual scaling only — does not affect layout<br>
    🔴 Use Width and Height utilities for physical sizing<br>
    🟢 <b>ho:scale-*p</b> applies Scale on self hover<br>
    🟢 Supports additive precision through <b>ho:scale-add-*p</b><br>
    🟢 Ideal for buttons, cards and micro-interactions<br>
    🟢 <b>cho:scale-*p</b> applies Scale from a <b>cho:parent</b> hover<br>
    🟢 Supports additive precision through <b>cho:scale-add-*p</b><br>
    🟢 Useful for group interactions and animated layouts<br>
    🔴 Multiple Scale utilities do not combine — the last Scale utility wins
  </p>

  <h3>Scale Live Demo</h3>

  <?php include 'demo/transform-scale.php'; ?>


  <h3>Skew Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/transform-skew.php'; ?>

}</code></pre>
  </div>


  <h3>Skew Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-skew.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-skew-add.php'; ?></code></pre>
  </div>

  <h3>Skew Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-skew-hs.php'; ?></code></pre>
  </div>

  <h3>Skew Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-skew-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-skew-add-hs.php'; ?></code></pre>
  </div>

  <h3>Skew Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-skew-chs.php'; ?></code></pre>
  </div>

  <h3>Skew Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-skew-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-skew-add-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>skewx-*</b> skews horizontally, <b>skewy-*</b> skews vertically<br>
    🟢 Supports additive precision through <b>skewx-add-*</b> and <b>skewy-add-*</b><br>
    🟢 Can be combined with Translate, Scale and Rotate<br>
    🟢 <b>ho:skewx-*</b> / <b>ho:skewy-*</b> apply Skew on self hover<br>
    🟢 <b>cho:skewx-*</b> / <b>cho:skewy-*</b> apply Skew from a <b>cho:parent</b> hover<br>
    🟡 Skew changes visual shape only — does not affect layout
  </p>

  <h3>Skew Live Demo</h3>

  <?php include 'demo/transform-skew.php'; ?>

  <h3>Translate Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/transform-translate.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/transform-translate-hs.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/transform-translate-chs.php'; ?>

}</code></pre>

    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-intrinsic.php'; ?></code></pre>
  </div>

  <h3>Translate % Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-add-1p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-add-1p.php'; ?></code></pre>
  </div>
  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-add-1p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-add-1p.php'; ?></code></pre>
  </div>

  <h3>Translate px Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-add-1px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-add-1px.php'; ?></code></pre>
  </div>
  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-add-1px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-add-1px.php'; ?></code></pre>
  </div>

  <h3>Translate Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-t-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-r-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-b-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-l-hs.php'; ?></code></pre>
  </div>

  <h3>Translate Hover % Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-p-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-add-1p-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-p-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-add-1p-hs.php'; ?></code></pre>
  </div>
  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-p-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-add-1p-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-p-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-add-1p-hs.php'; ?></code></pre>
  </div>

  <h3>Translate Hover px Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-px-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-add-1px-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-px-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-add-1px-hs.php'; ?></code></pre>
  </div>
  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-px-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-add-1px-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-px-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-add-1px-hs.php'; ?></code></pre>
  </div>

  <h3>Translate Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-t-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-r-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-b-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transform-l-chs.php'; ?></code></pre>
  </div>

  <h3>Translate Child Hover % Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-p-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-add-1p-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-p-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-add-1p-chs.php'; ?></code></pre>
  </div>
  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-p-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-add-1p-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-p-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-add-1p-chs.php'; ?></code></pre>
  </div>

  <h3>Translate Child Hover px Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-px-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-t-add-1px-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-px-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-r-add-1px-chs.php'; ?></code></pre>
  </div>
  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-px-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-b-add-1px-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-px-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transform-l-add-1px-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>tt-*</b> up, <b>tr-*</b> right, <b>tb-*</b> down, <b>tl-*</b> left<br>
    🟢 Supports <b>px</b> and <b>%</b> values<br>
    🟢 Directions can be combined (e.g. tt-* + tr-*)<br>
    🟢 Opposite directions replace negative utilities<br>
    🟡 Visual movement only — does not affect layout<br>
    🔴 Use Offset utilities (t-* r-* b-* l-*) for positioning <br>
    🟢 <b>ho:tt-*</b>, <b>ho:tr-*</b>, <b>ho:tb-*</b>, <b>ho:tl-*</b> apply Translate on self hover<br>
    🟢 <b>cho:tt-*</b>, <b>cho:tr-*</b>, <b>cho:tb-*</b>, <b>cho:tl-*</b> apply Translate from a <b>cho:parent</b> hover<br>
    🟢 Supports px, %, additive precision and multi-direction movement<br>
  </p>

  <h3>Translate Live Demo</h3>

  <?php include 'demo/transform-translate.php'; ?>
</section>
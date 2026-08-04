<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="filter-system">Filter System</h2>

<section class="px-md stack-y-sm">

  <h3>Filter Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter.php'; ?></code></pre>
  </div>

  <h3>Blur Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/filter-blur.php'; ?>

}</code></pre>
  </div>

  <h3>Blur Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-blur-hs.php'; ?></code></pre>
  </div>

  <h3>Blur Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16 of-x-scroll w-100p"><code><?php include 'class/filter-blur.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 blur-* applies Gaussian blur using the framework blur scale (xs → xl) <br>
    🟢 Blur values are configurable through CSS variables (--blur-*) <br>
    🟢 ho:* and cho:* provide hover and child-hover blur states <br>
    🟢 cl:* and ccl:* provide click and child-click blur states <br>
    🟢 ac:* and cac:* provide active and child-active blur states <br>
    🟢 sl:* and csl:* provide select and child-select blur states <br>
    🟢 Can be combined with all other Filter utilities <br>
    🟡 Blur affects visual rendering only — layout dimensions remain unchanged <br>
    🔴 Multiple Blur utilities do not stack — the last Blur utility wins
  </p>


  <h3>Blur Live Demo</h3>

  <?php include 'demo/filter-blur.php'; ?>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16 of-x-scroll w-100p"><code><?php include 'js/state-engine.php'; ?></code></pre>
  </div>
  <?php include 'demo/state-engine.php'; ?>



  <h3>Brightness Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-brightness.php'; ?></code></pre>
  </div>

  <h3>Brightness Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-brightness-hs.php'; ?></code></pre>
  </div>

  <h3>Brightness Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-brightness-hs.php'; ?></code></pre>
  </div>

  <h3>Brightness Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-brightness-chs.php'; ?></code></pre>
  </div>

  <h3>Brightness Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-brightness-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 brightness-*p adjusts visual brightness using percentages<br>
    🟢 Supports values from 0%–200%<br>
    🟢 brightness-100p represents the original brightness<br>
    🟢 Values below 100 darken the element<br>
    🟢 Values above 100 brighten the element<br>
    🟢 Can be combined with all other Filter utilities<br>
    🟡 Brightness affects rendered appearance only — does not affect layout<br>
    🟡 Brightness uses fixed percentage values and does not support brightness-add-* <br>
    🔴 Multiple Brightness utilities do not combine — the last Brightness utility wins
  </p>


  <h3>Brightness Live Demo</h3>

  <?php include 'demo/filter-brightness.php'; ?>

  <h3>Contrast Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-contrast.php'; ?></code></pre>
  </div>

  <h3>Contrast Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-contrast-hs.php'; ?></code></pre>
  </div>

  <h3>Contrast Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-contrast-hs.php'; ?></code></pre>
  </div>

  <h3>Contrast Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-contrast-chs.php'; ?></code></pre>
  </div>

  <h3>Contrast Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-contrast-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 contrast-*p adjusts image contrast using percentage values <br>
    🟢 Supports values from 0%–200% <br>
    🟢 contrast-100p represents the original contrast <br>
    🟢 Values below 100% reduce contrast <br>
    🟢 Values above 100% increase contrast <br>
    🟢 Can be combined with all other Filter utilities <br>
    🟢 ho:contrast-* applies Contrast on self hover <br>
    🟢 cho:contrast-* applies Contrast from a cho-parent hover <br>
    🟡 Contrast affects rendered appearance only — does not affect layout <br>
    🟡 Contrast uses fixed percentage values and does not support contrast-add-* <br>
    🔴 Multiple Contrast utilities do not combine — the last Contrast utility wins
  </p>


  <h3>Contrast Live Demo</h3>

  <?php include 'demo/filter-contrast.php'; ?>

  <h3>Drop-shadow Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/filter-drop-shadow.php'; ?>

}</code></pre>
  </div>

  <h3>Drop-shadow Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-drop-shadow.php'; ?></code></pre>
  </div>

  <h3>Drop-shadow Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-drop-shadow-hs.php'; ?></code></pre>
  </div>

  <h3>Drop-shadow Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-drop-shadow-hs.php'; ?></code></pre>
  </div>

  <h3>Drop-shadow Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-drop-shadow-chs.php'; ?></code></pre>
  </div>

  <h3>Drop-shadow Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-drop-shadow-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 dsw-* utilities apply filter-based drop shadows <br>
    🟢 Uses the same elevation scale as the Shadow System (xs → xl) <br>
    🟢 dsw-0 removes the drop shadow entirely <br>
    🟢 Drop Shadow follows image transparency and element shape <br>
    🟢 Can be combined with Blur, Brightness, Contrast, Hue, Saturate and other Filters <br>
    🟢 ho:dsw-* applies Drop Shadow on self hover <br>
    🟢 cho:dsw-* applies Drop Shadow from a cho:parent hover <br>
    🟡 Drop Shadow is rendered through the Filter System, not box-shadow <br>
    🟡 Best suited for images, icons, SVGs and transparent elements <br>
    🔴 Multiple dsw-* utilities do not combine — the last Drop Shadow utility wins
  </p>


  <h3>Drop-shadow Live Demo</h3>

  <?php include 'demo/filter-drop-shadow.php'; ?>


  <h3>Grayscale Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-grayscale.php'; ?></code></pre>
  </div>

  <h3>Grayscale Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-grayscale-hs.php'; ?></code></pre>
  </div>

  <h3>Grayscale Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-grayscale-hs.php'; ?></code></pre>
  </div>

  <h3>Grayscale Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-grayscale-chs.php'; ?></code></pre>
  </div>

  <h3>Grayscale Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-grayscale-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 grayscale applies full grayscale (100%)<br>
    🟢 grayscale-none removes grayscale (0%)<br>
    🟢 Ideal for logos, client showcases, team cards and gallery effects<br>
    🟢 Can be combined with all other Filter utilities<br>
    🟡 Grayscale affects rendered appearance only — does not affect layout<br>
    🔴 Grayscale utilities do not combine — the last Grayscale utility wins
  </p>


  <h3>Grayscale Live Demo</h3>

  <?php include 'demo/filter-grayscale.php'; ?>

  <h3>Hue Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/filter-hue.php'; ?>

}</code></pre>
  </div>

  <h3>Hue Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-hue.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-hue-add.php'; ?></code></pre>
  </div>

  <h3>Hue Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-hue-hs.php'; ?></code></pre>
  </div>

  <h3>Hue Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-hue-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-hue-add-hs.php'; ?></code></pre>
  </div>

  <h3>Hue Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-hue-chs.php'; ?></code></pre>
  </div>

  <h3>Hue Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-hue-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-hue-add-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 hue-* rotates colors around the hue wheel <br>
    🟢 Supports values from 0deg–360deg <br>
    🟢 Provides fine control with 1deg–9deg utilities and broader 10deg increments <br>
    🟢 Can be combined with all other Filter utilities <br>
    🟢 ho:hue-* applies Hue Rotate on self hover <br>
    🟢 cho:hue-* applies Hue Rotate from a cho-parent hover <br>
    🟡 hue-add-* only affects hue values from 10deg–350deg <br>
    🟡 hue-1deg through hue-9deg are absolute values and ignore hue-add-* <br>
    🔴 Multiple Hue utilities do not combine — the last Hue utility wins
  </p>


  <h3>Hue Live Demo</h3>

  <?php include 'demo/filter-hue.php'; ?>

  <h3>Invert Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-invert.php'; ?></code></pre>
  </div>

  <h3>Invert Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-invert-hs.php'; ?></code></pre>
  </div>

  <h3>Invert Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-invert-hs.php'; ?></code></pre>
  </div>

  <h3>Invert Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-invert-chs.php'; ?></code></pre>
  </div>

  <h3>Invert Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-invert-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 invert applies full color inversion (100%) <br>
    🟢 invert-none removes color inversion (0%) <br>
    🟢 Useful for logos, icons and dark-mode asset adaptation <br>
    🟢 Can be combined with all other Filter utilities <br>
    🟡 Invert affects rendered appearance only — does not affect layout <br>
    🔴 Invert utilities do not combine — the last Invert utility wins
  </p>


  <h3>Invert Live Demo</h3>

  <?php include 'demo/filter-invert.php'; ?>

  <h3>Saturate Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-saturate.php'; ?></code></pre>
  </div>

  <h3>Saturate Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-saturate-hs.php'; ?></code></pre>
  </div>

  <h3>Saturate Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-saturate-hs.php'; ?></code></pre>
  </div>

  <h3>Saturate Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-saturate-chs.php'; ?></code></pre>
  </div>

  <h3>Saturate Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-saturate-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 saturate-*p adjusts color intensity using percentage values <br>
    🟢 Supports values from 0%–200% <br>
    🟢 saturate-100p represents the original saturation <br>
    🟢 Values below 100% reduce color intensity <br>
    🟢 Values above 100% increase color intensity <br>
    🟢 Can be combined with all other Filter utilities <br>
    🟢 ho:saturate-* applies Saturation on self hover <br>
    🟢 cho:saturate-* applies Saturation from a cho-parent hover <br>
    🟡 Saturation affects rendered appearance only — does not affect layout <br>
    🟡 Saturation uses fixed percentage values and does not support saturate-add-* <br>
    🔴 Multiple Saturate utilities do not combine — the last Saturate utility wins
  </p>


  <h3>Saturate Live Demo</h3>

  <?php include 'demo/filter-saturate.php'; ?>

  <h3>sepia Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-sepia.php'; ?></code></pre>
  </div>

  <h3>sepia Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-sepia-hs.php'; ?></code></pre>
  </div>

  <h3>sepia Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-sepia-hs.php'; ?></code></pre>
  </div>

  <h3>sepia Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/filter-sepia-chs.php'; ?></code></pre>
  </div>

  <h3>sepia Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/filter-sepia-chs.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 sepia applies a full sepia effect (100%) <br>
    🟢 sepia-none removes the sepia effect (0%) <br>
    🟢 Useful for vintage styling, historical imagery and retro-themed interfaces <br>
    🟢 Can be combined with all other Filter utilities <br>
    🟡 Sepia affects rendered appearance only — does not affect layout <br>
    🔴 Sepia utilities do not combine — the last Sepia utility wins
  </p>


  <h3>sepia Live Demo</h3>

  <?php include 'demo/filter-sepia.php'; ?>



</section>
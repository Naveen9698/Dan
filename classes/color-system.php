<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" data-ut="guide-section" id="color-system">Color System</h2>

<section class="px-md stack-y-sm">
  <h3>Variables</h3>
  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {
<?php include 'root/color.php'; ?>

}</code></pre>
  </div>

  <h3>Color Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/color-clr.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/color-bg.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Base (clr-*, bg-*) set default color <br>
    🟢 Parent (cho:*) applies on parent hover <br>
    🟢 Self (ho:*) applies on hover and overrides parent <br>
    🟢 Color transitions work smoothly with ts-* utilities <br>
    🟡 Last class wins when conflicts occur <br>
    🔴 Colors do not stack — only one applies
  </p>

  <h3>Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/color-clr-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/color-bg-hs.php'; ?></code></pre>
  </div>

  <h3>Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/color-clr-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/color-bg-hs.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>ho:*</b> is written with <b>extra specificity</b> to ensure it works correctly inside parent hover.<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>.ho:*:hover, <br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.cho:parent:hover .ho:*:hover {...}</b><br>
    🟢 It allows self hover to work even when <b>cho:parent + cho:*</b> is active<br>
    🟡 This keeps behavior consistent across shadow, opacity, color and Other systems<br>
    🔴 Without this, <b>cho:*</b> will override <b>ho:*</b> and self hover will not work
  </p>

  <h3>Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/color-clr-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/color-bg-chs.php'; ?></code></pre>
  </div>

  <h3>Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/color-clr-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/color-bg-chs.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Defines the <b>core color palette</b> using CSS variables.<br>
    🟡 Changes at root level affect the entire system — use with awareness.<br>
    🟢 <b>clr-*</b> utilities apply text color consistently.<br>
    🟢 <b>bg-*</b> utilities apply background color using the same system.<br>
    🔴 Avoid using inline colors — breaks system consistency.<br>
    🟢 State variants (<b>-h</b>) are used for <b>interaction states</b> (hover, active).<br>
    🟢 <b>--color-0</b> provides a transparent base value.<br>
    🟡 Transparency may expose underlying layers — use carefully.
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/color-system.php'; ?>

</section>
<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" data-ut="guide-section" id="color-system">Color System</h2>

<section class="px-md stack-y-sm">
  <h3>Variables</h3>
  <div class="d-cols">
    <pre><code>:root {
<?php include 'root/color.php'; ?>

}</code></pre>
  </div>

  <h3>Color Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/color-clr.php'; ?></code></pre>
    <pre><code><?php include 'class/color-bg.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Base (clr-*, bg-*) set default color <br>
    🟢 Parent (chr-*) applies on parent hover <br>
    🟢 Self (hr-*) applies on hover and overrides parent <br>
    🟢 Color transitions work smoothly with tr-* utilities <br>
    🟡 Last class wins when conflicts occur <br>
    🔴 Colors do not stack — only one applies
  </p>

  <h3>Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/color-clr-hr.php'; ?></code></pre>
    <pre><code><?php include 'engine/color-bg-hr.php'; ?></code></pre>
  </div>

  <h3>Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/color-clr-hr.php'; ?></code></pre>
    <pre><code><?php include 'class/color-bg-hr.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>hr-*</b> is written with <b>extra specificity</b> to ensure it works correctly inside parent hover.<br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>.hr-*:hover, <br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.chr-parent:hover .hr-*:hover {...}</b><br>
    🟢 It allows self hover to work even when <b>chr-parent + chr-*</b> is active<br>
    🟡 This keeps behavior consistent across shadow, opacity, color and Other systems<br>
    🔴 Without this, <b>chr-*</b> will override <b>hr-*</b> and self hover will not work
  </p>

  <h3>Child Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/color-clr-chr.php'; ?></code></pre>
    <pre><code><?php include 'engine/color-bg-chr.php'; ?></code></pre>
  </div>

  <h3>Child Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/color-clr-chr.php'; ?></code></pre>
    <pre><code><?php include 'class/color-bg-chr.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
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
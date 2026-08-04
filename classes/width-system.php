<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="width-system">Width System</h2>

<section class="px-md stack-y-sm of-x-hidden">

  <h3>Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/width.php'; ?>

}</code></pre>
  </div>
  <h3>Width Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/width.php'; ?></code></pre>
  </div>
  <h3>Helper Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/width-helper.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Any w-* class activates the width system <br>
    🟢 Each system (width / max / min) operates independently <br>
    🟢 Width is composed using a base (<b>w-*</b>) + additive values (<b>w-add-*</b>)<br>
    🟢 Use only one base class per element (do not mix w-*px, w-*p, w-*vw)<br>
    🟢 Add classes refine the nearest base value using 1-unit increments.<br>
    🟡 Only apply when needed — avoid unnecessary overrides <br>
    🟢 w-auto → default browser behavior, w-fit → content-based sizing <br>
    🟡 These override all width logic <br>
    🔴 Do not combine (w-auto, w-fit) with other w-* classes
  </p>

  <h3>px | min | max - Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/width-px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/width-min.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/width-max.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/width-add-1px.php'; ?></code></pre>
      <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/width-add-1min.php'; ?></code></pre>
      <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/width-add-1max.php'; ?></code></pre>
    </div>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>w-*px</b> Uses true numeric composition and Supports precise values without extra classes <br>
    🟢 <b>w-*min</b> Ensures minimum size <br>
    🟢 <b>w-*max</b> Applies constraint only when used <br>
    🟢 <b>w-*min</b> and <b>w-*max</b> Works with all width types (% / vw / px)

  </p>
  
  <h3>% Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/width-p.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/width-add-1p.php'; ?></code></pre>
    </div>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Base uses 10% steps <br>
    🟢 w-add-* provides 1–9% precision <br>
    🔴 Avoid multiple base classes
  </p>

  <h3>vw Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/width-vw.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/width-add-1vw.php'; ?></code></pre>
    </div>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Behaves exactly like % <br>
    🟢 Responsive to viewport size <br>
    🔴 Do not mix with px base
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/width-system.php'; ?>

</section>
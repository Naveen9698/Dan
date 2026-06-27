<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="width-system">Width System</h2>

<section class="px-md stack-y-sm of-x-hidden">

  <h3>Variables</h3>

  <div class="d-cols">
    <pre><code>:root {<?php include 'root/width.php'; ?>

}</code></pre>
  </div>
  <h3>Width Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/width.php'; ?></code></pre>
  </div>
  <h3>Helper Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/width-helper.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Any w-* class activates the width system <br>
    🟢 Each system (width / max / min) operates independently <br>
    🟢 Width is composed using a base (<b>w-*</b>) + additive values (<b>w-add-*</b>)<br>
    🟢 Use only one base class per element (do not mix w-*px, w-*p, w-*vw)<br>
    🟢 Add classes refine the base value incrementally (base + 10 + 1) <br>
    🟡 Only apply when needed — avoid unnecessary overrides <br>
    🟢 w-auto → default browser behavior, w-fit → content-based sizing <br>
    🟡 These override all width logic <br>
    🔴 Do not combine (w-auto, w-fit) with other w-* classes
  </p>

  <h3>px Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/width-px.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre><code><?php include 'class/width-add-10px.php'; ?></code></pre>
      <pre><code><?php include 'class/width-add-1px.php'; ?></code></pre>
    </div>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Uses true numeric composition <br>
    🟢 Supports precise values without extra classes <br>
    🔴 Only one base w-*px class
  </p>

  <h3>vw Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/width-vw.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre><code><?php include 'class/width-add-1vw.php'; ?></code></pre>
    </div>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Behaves exactly like % <br>
    🟢 Responsive to viewport size <br>
    🔴 Do not mix with px base
  </p>

  <h3>% Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/width-p.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre><code><?php include 'class/width-add-1p.php'; ?></code></pre>
    </div>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Base uses 10% steps <br>
    🟢 w-add-* provides 1–9% precision <br>
    🔴 Avoid multiple base classes
  </p>

  <h3>min Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/width-min.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre><code><?php include 'class/width-add-10min.php'; ?></code></pre>
      <pre><code><?php include 'class/width-add-1min.php'; ?></code></pre>
    </div>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Ensures minimum size <br>
    🟢 Works with all width types (% / vw / px)
  </p>

  <h3>max Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/width-max.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre><code><?php include 'class/width-add-10max.php'; ?></code></pre>
      <pre><code><?php include 'class/width-add-1max.php'; ?></code></pre>
    </div>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Applies constraint only when used <br>
    🟢 Works with all width types (% / vw / px)
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/width-system.php'; ?>

</section>
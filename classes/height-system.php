<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="height-system">Height System</h2>

<section class="px-md stack-y-sm">

  <h3>Variables</h3>

  <div class="d-cols">
    <pre><code>:root {<?php include 'root/height.php'; ?>

}</code></pre>
  </div>
  <h3>Height Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/height.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Any h-* class activates the height system <br>
    🟢 Value is applied via --h-height <br>
    🟢 Height system mirrors the width system — same composition rules apply <br>
    🟡 Use only when necessary — height affects layout strongly <br>
    🟡 Height defines available space — content may overflow, be clipped, or scroll<br>
    🟡 min/max constraints override height when limits are reached <br>
    🟡 Avoid combining conflicting constraints (e.g., very small max with large min) <br>
    🔴 Avoid stacking multiple base h-* classes
  </p>

  <h3>Helper Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/height-helper.php'; ?></code></pre>
  </div>

  <h3>px Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/height-px.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre><code><?php include 'class/height-add-10px.php'; ?></code></pre>
      <pre><code><?php include 'class/height-add-1px.php'; ?></code></pre>
    </div>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🔴 Use only one base h-*px <br>
    🟢 True numeric composition, High precision without many classes
  </p>

  <h3>vh Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/height-vh.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre><code><?php include 'class/height-add-1vh.php'; ?></code></pre>
    </div>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Independent of parent height <br>
    🟢 Fully responsive <br>
    🟢 Most reliable height unit
  </p>

  <h3>% Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/height-p.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre><code><?php include 'class/height-add-1p.php'; ?></code></pre>
    </div>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟡 Avoid using % height unless inside fixed-height or vh-based layouts <br>
    🔴 Will fail in normal flow layouts <br>
    🟢 Use only in controlled containers (flex/grid/viewport layouts)
  </p>

  <h3>min Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/height-min.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre><code><?php include 'class/height-add-10min.php'; ?></code></pre>
      <pre><code><?php include 'class/height-add-1min.php'; ?></code></pre>
    </div>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Ensures minimum size <br>
    🟢 Works with all height types (% / vh / px)
  </p>

  <h3>max Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/height-max.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre><code><?php include 'class/height-add-10max.php'; ?></code></pre>
      <pre><code><?php include 'class/height-add-1max.php'; ?></code></pre>
    </div>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Applies constraint only when used <br>
    🟢 Works with all height types (% / vh / px)
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/height-system.php'; ?>

</section>
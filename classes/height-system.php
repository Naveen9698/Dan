<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="height-system">Height System</h2>

<section class="px-md stack-y-sm">

  <h3>Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/height.php'; ?>

}</code></pre>
  </div>
  <h3>Height Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/height.php'; ?></code></pre>
  </div>

  <h3>Helper Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/height-helper.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Any h-* class activates the height system <br>
    🟢 Each system (height / max / min) operates independently <br>
    🟢 Height is composed using a base (h-*) + additive values (h-add-*) <br>
    🟢 Use only one base class per element <br>
    🟢 Add classes refine the nearest base value using 1-unit increments <br>
    🟡 Use only when necessary — height affects layout strongly <br>
    🟡 Height defines available space — content may overflow, be clipped, or scroll<br>
    🟡 min/max constraints override height when limits are reached <br>
    🟡 Avoid combining conflicting constraints (e.g., very small max with large min) <br>
    🔴 Avoid stacking multiple base h-* classes
  </p>

  <h3>px | min | max - Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/height-px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/height-min.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/height-max.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/height-add-1px.php'; ?></code></pre>
      <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/height-add-1min.php'; ?></code></pre>
      <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/height-add-1max.php'; ?></code></pre>
    </div>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>h-*px</b> Uses true numeric composition and Supports precise values without extra classes<br>
    🟢 <b>h-*min</b> Ensures minimum size <br>
    🟢 <b>h-*max</b> Applies constraint only when used <br>
    🟢 <b>h-*min</b> and <b>h-*max</b> Works with all height types (% / vh / px)
  </p>

  <h3>vh Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/height-vh.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/height-add-1vh.php'; ?></code></pre>
    </div>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Independent of parent height <br>
    🟢 Fully responsive <br>
    🟢 Most reliable height unit
  </p>

  <h3>% Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/height-p.php'; ?></code></pre>
    <div class="flex-y gap-sm">
      <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/height-add-1p.php'; ?></code></pre>
    </div>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟡 Avoid using % height unless inside fixed-height or vh-based layouts <br>
    🔴 Will fail in normal flow layouts <br>
    🟢 Use only in controlled containers (flex/grid/viewport layouts)
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/height-system.php'; ?>

</section>
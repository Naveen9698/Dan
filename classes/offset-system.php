<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="offset-system">Offset System</h2>

<section class="px-md stack-y-sm">

  <h3>Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/offset.php'; ?>

}</code></pre>

    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-intrinsic.php'; ?></code></pre>
  </div>

  <h3>Offset Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/offset.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Any t- / r- / b- / l- class activates the offset system <br>
    🔴 Use only one base class per axis (t / r / b / l) <br>
    🟡 Offsets require pn-relative or pn-absolute to take effect <br>
    🔴 Avoid using offset classes without positioning context <br>
    🟢 Add variables (--*-add-*) enable stackable adjustments <br>
    🟢 <b>*-0</b> reset offset to zero, <b>*-auto</b> restore default (auto) <br>
    🟢 Use offset for positioning (visual movement) <br>
    🟢 Use margin/padding for spacing (layout separation) <br>
    🟡 Offset does not create space — it shifts element position <br>
    🟡 Acts on visual position, not layout flow
  </p>

  <h3>% Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-t-p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-t--p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-t-add-1p.php'; ?></code></pre>
  </div>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-r-p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-r--p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-r-add-1p.php'; ?></code></pre>
  </div>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-b-p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-b--p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-b-add-1p.php'; ?></code></pre>
  </div>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-l-p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-l--p.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-l-add-1p.php'; ?></code></pre>
  </div>

  <p class="fz-14px clr-g5 lh-16 ml-md">
    🟢 % offsets are relative to the containing block <br>
    🟡 Responsive by nature (scales with container) <br>
    🟢 Use base (10–100) + add-* for precision stacking <br>
    🟢 Negative (--*) moves in opposite direction <br>
  </p>

  <h3>px Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-t-px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-t-add-10px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-t-add-1px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-t--px.php'; ?></code></pre>
  </div>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-r-px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-r-add-10px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-r-add-1px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-r--px.php'; ?></code></pre>
  </div>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-b-px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-b-add-10px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-b-add-1px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-b--px.php'; ?></code></pre>
  </div>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-l-px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-l-add-10px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-l-add-1px.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/offset-l--px.php'; ?></code></pre>
  </div>

  <p class="fz-14px clr-g5 lh-16 ml-md">
    🟢 px offsets use fixed values for precise positioning <br>
    🟢 Not responsive — independent of container size <br>
    🟡 Can be combined with % offsets on different axes <br>
    🟢 Supports stackable add-* for fine control (combines large 10px + small 1px adjustments) <br>
    🟢 Negative (--*) moves in opposite direction with exact precision
  </p>

  <!-- ===== Live Demo ===== -->
  <h3>Live Demo</h3>

  <?php include 'demo/offset-system.php'; ?>

</section>
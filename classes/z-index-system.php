<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="z-index-system">Z-Index System</h2>

<section class="px-md stack-y-sm">

  <h3>z-index Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/z-index.php'; ?></code></pre>
    <pre><code>@media (max-width: 990px) {
<?php include 'class-tb/z-index.php'; ?>

}</code></pre>
    <pre><code>@media (max-width: 770px) {
<?php include 'class-mb/z-index.php'; ?>

}</code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>z-*</b> utilities control <b>stacking order</b> (which element appears on top).<br>
    🟢 Higher values appear above lower values.<br>
    🟢 Works only on <b>positioned elements</b> (requires <b>pn-relative</b>, <b>pn-absolute</b>, etc.).<br>
    🟡 Semantic layers (<b>z-overlay</b>, <b>z-modal</b>) define common UI stacking levels.<br>
    🟡 Responsive variants (<b>z-tb-*</b>, <b>z-mb-*</b>) allow layered behavior across devices.<br>
    🔴 Z-index does nothing without positioning.<br>
    🔴 Avoid large arbitrary values — keep stacking levels limited and predictable.
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/z-index-system.php'; ?>

</section>
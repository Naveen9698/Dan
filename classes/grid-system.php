<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="grid-system">Grid System</h2>

<section class="px-md stack-y-sm">
  <h3>Grid Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/grid-prefix.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>.grid</b> creates a <b>12-column</b> layout using equal fractions.<br>
    🟢 Grid items automatically flow left to right, top to bottom. <br>
    🟡 When total span exceeds 12, items wrap to the next row. <br>
    🟡 Grid system focuses on <b>layout structure</b>, not alignment or spacing.<br>
    🟡 Combine with <b>flex</b> or alignment utilities for content positioning. <br>
    🟡 Grid does not include spacing — use <b>gap-*</b>, <b>padding</b>, or <b>margin</b> explicitly.<br>
    🔴 Do not rely on grid for spacing — it only defines structure.
  </p>

  <h3>Grid Column Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/grid.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 990px) {
<?php include 'class-tb/grid.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 770px) {
<?php include 'class-mb/grid.php'; ?>

}</code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>g-*</b> utilities control column span across the 12-column system.<br>
    🟢 Responsive variants (<b>g-tb-*</b>, <b>g-mb-*</b>) override spans at breakpoints.<br>
    🔴 Avoid assigning spans beyond 12 — breaks layout consistency.
  </p>

  <h3>Grid Row Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/grid-y.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 990px) {
<?php include 'class-tb/grid-y.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 770px) {
<?php include 'class-mb/grid-y.php'; ?>

}</code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>gy-*</b> utilities control row span for vertical sizing.<br>
    🟢 Rows expand naturally based on content height.<br>
    🔴 Row spans do not fix height — content still defines final height.
  </p>

  <h3>Live Responsive Demo</h3>

  <?php include 'demo/grid-system.php'; ?>

</section>
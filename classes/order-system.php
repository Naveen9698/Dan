<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="order-system">Order System</h2>

<section class="px-md stack-y-sm">

  <h3>Order Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/order.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 990px) {
<?php include 'class-tb/order.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 770px) {
<?php include 'class-mb/order.php'; ?>

}</code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>ord-*</b> utilities control the visual order of flex and grid items.<br>
    🟢 Higher values appear later in the layout flow.<br>
    🟢 Useful for responsive content reordering without changing HTML structure.<br>
    🟡 Items with the same order value follow normal document order.<br>
    🔴 Order changes visual layout only — it does not change DOM order.<br>
    🔴 Avoid excessive reordering as it may reduce accessibility and maintainability.
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/order-system.php'; ?>

</section>
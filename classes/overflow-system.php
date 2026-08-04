<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="overflow-system">Overflow System</h2>

<section class="px-md stack-y-sm">

  <h3>Overflow Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/overflow.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 990px) {
<?php include 'class-tb/overflow.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 770px) {
<?php include 'class-mb/overflow.php'; ?>

}</code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>of-*</b> utilities control how content behaves when it exceeds container bounds.<br>
    🟢 <b>of-hidden</b> clips overflow, <b>of-auto</b> adds scroll only when needed, <b>of-scroll</b> always shows scrollbars.<br>
    🟢 Axis utilities (<b>of-x-*</b>, <b>of-y-*</b>) provide directional control.<br>
    🟡 Often used with <b>fixed height / width</b> or <b>aspect ratio (ar-*)</b> containers.<br>
    🟡 Responsive variants (<b>of-tb-*</b>, <b>of-mb-*</b>) help manage overflow across devices.<br>
    🔴 Incorrect overflow usage can break layouts (e.g. disabling sticky or clipping content unexpectedly).
  </p>

  <h3>Live Demo</h3>
  <div class="bg-white pa-sm stack-y-md ra-sm bsw-sm">
    <?php include 'demo/overflow-system.php'; ?>
  </div>
</section>
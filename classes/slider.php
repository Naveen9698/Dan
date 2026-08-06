<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="slider">Slider System</h2>

<section class="px-md stack-y-sm">

  <h3>Slider Helper Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/slider-helper.php'; ?></code></pre>
  </div>
  <h3>Slider Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/slider.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 990px) {
<?php include 'class-tb/slider.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 770px) {
<?php include 'class-mb/slider.php'; ?>

}</code></pre>
  </div>

  <h3 id="getting-started">Getting Started</h3>
  <!--
  <div class="flex-x gap-md f-wrap">
     <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'js/slider.php'; ?></code></pre>
  </div>
 -->
  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>z-*</b> utilities control <b>stacking order</b> (which element appears on top).<br>
    🟢 Higher values appear above lower values.<br>
    🟢 Works only on <b>positioned elements</b> (requires <b>pn-relative</b>, <b>pn-absolute</b>, etc.).<br>
    🔴 z-index only affects stacking contexts and overlapping elements. <br>
    🟡 Most common usage is with positioned elements (pn-relative, pn-absolute, pn-fixed, pn-sticky). <br>
    🔴 Avoid large arbitrary values — keep stacking levels limited and predictable.
  </p>

  <h3 id="default">Default Carousel</h3>
  <p class="fz-14 clr-g5 lh-16 ml-md ">
    🟢 Horizontal layout <br>
    🟢 Snap-based scrolling <br>
    🟢 Drag interaction (mouse + touch) <br>
  </p>
  <?php include 'slider/default.php'; ?>
  <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16 w-fit"><code><?= htmlspecialchars(file_get_contents('classes\slider\default.php')) ?></code></pre>

  <h3 id="previous-next-buttons">Previous / Next Buttons</h3>
  <p class="fz-14 clr-g5 lh-16 ml-md ">
    🟢 Navigate slides using external controls <br>
    🟢 Uses yd-prev and yd-next API methods <br>
    🟢 Demonstrates manual user-triggered navigation <br>
  </p>
  <?php include 'slider/previous-next-buttons.php'; ?>
  <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16 w-fit"><code><?= htmlspecialchars(file_get_contents('classes\slider\previous-next-buttons.php')) ?></code></pre>

  <h3 id="pagination-dots">Pagination Dots</h3>
  <p class="fz-14 clr-g5 lh-16 ml-md ">
    🟢 Visual indicators for each slide <br>
    🟢 Click a dot to navigate to that slide <br>
    🟢 Active state reflects current position <br>
  </p>
  <?php include 'slider/pagination-dots.php'; ?>
  <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16 w-fit"><code><?= htmlspecialchars(file_get_contents('classes\slider\pagination-dots.php')) ?></code></pre>

  <h3 id="snap-counter">Snap Counter</h3>
  <p class="fz-14 clr-g5 lh-16 ml-md ">
    🟢 Snap Count = 3 - snaps <br>
    🟢 If Looped Snap Count = 5 - total slides <br>
    🟢 Displays current slide index <br>
    🟢 Shows total number of slides <br>
    🟢 Updates automatically on navigation <br>
  </p>
  <?php include 'slider/snap-counter.php'; ?>
  <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16 w-fit"><code><?= htmlspecialchars(file_get_contents('classes\slider\snap-counter.php')) ?></code></pre>

</section>
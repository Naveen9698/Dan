<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="slider">Slider System</h2>

<section class="px-md stack-y-sm">

  <h3>Slider Helper Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/slider-helper.php'; ?></code></pre>
  </div>

  <h3>Slider Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/slider.php'; ?></code></pre>
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

   
  <h3 id="default">TEST Carousel</h3>

  <?php include 'slider/slider.php'; ?> 
  
</section>
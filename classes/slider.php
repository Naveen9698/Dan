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

    <!--
  <div class="flex-x gap-md f-wrap">
     <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'js/slider.php'; ?></code></pre>
  </div>
 -->
 
  <!-- <h3 id="default">Default Carousel</h3>

  <?php include 'slider/default.php'; ?>
  <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16 w-fit"><code><?= htmlspecialchars(file_get_contents('classes\slider\default.php')) ?></code></pre> -->

  <h3 id="default">TEST Carousel</h3>

  <?php include 'slider/slider.php'; ?>

<h3>
  TEST-001: Slide Snap (Default)
</h3>
<div class="yd_carousel">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

  
<h3>
  TEST-002: Group Snap
</h3>
<div class="yd_carousel group-snap">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

  
<h3>
  TEST-003: Drag Free
</h3>
<div class="yd_carousel drag-free">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-004: Slide Snap + Drag Free
</h3>
<div class="yd_carousel slide-snap drag-free">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-005: Group Snap + Drag Free
</h3>
<div class="yd_carousel group-snap drag-free">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-006: RTL
</h3>
<div class="yd_carousel rtl keyboard">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-007: RTL + Loop
</h3>
<div class="yd_carousel rtl loop">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-008: Vertical
</h3>
<div class="yd_carousel vertical">
  <div class="yd_viewport h-420px h-add-4p w-50p ma-auto">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-008: Vertical + Keyboard
</h3>
<div class="yd_carousel vertical keyboard">
  <div class="yd_viewport h-420px h-add-4p w-50p ma-auto">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-009: Vertical + Loop + Keyboard
</h3>
<div class="yd_carousel debug vertical loop keyboard">
  <div class="yd_viewport h-420px h-add-4p w-50p ma-auto">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-010: Align Start + Loop
</h3>
<div class="yd_carousel loop">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-011: Align Center + Loop
</h3>
<div class="yd_carousel align-center loop">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-012: Align End + Loop
</h3>
<div class="yd_carousel align-end loop">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-013: Loop
</h3>
<div class="yd_carousel loop">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-014: Loop + Drag Free
</h3>
<div class="yd_carousel loop drag-free">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-016: Loop + Autoplay
</h3>
<div class="yd_carousel loop autoplay">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-017: Keyboard
</h3>
<div class="yd_carousel keyboard">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-018: Focus On Change
</h3>
<div class="yd_carousel focus-on-change">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-019: Reduced Motion
</h3>
<div class="yd_carousel" data-reduced-motion="true">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-020: Autoplay
</h3>
<div class="yd_carousel autoplay">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-021: Autoplay Pause Hover
</h3>
<div class="yd_carousel autoplay pause-hover">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>

<h3>
  TEST-022: Autoplay Backward 
</h3>
<div class="yd_carousel autoplay" data-autoplay-direction="backward">
  <div class="yd_viewport">
    <div class="yd_container slides-2 gap-sm">
      <div class="yd_slide"><div class="slide">1</div></div>
      <div class="yd_slide"><div class="slide">2</div></div>
      <div class="yd_slide"><div class="slide">3</div></div>
      <div class="yd_slide"><div class="slide">4</div></div>
      <div class="yd_slide"><div class="slide">5</div></div>
      <div class="yd_slide"><div class="slide">6</div></div>
    </div>
  </div>
</div>


<h3>
  TEST-023: Autoplay API
</h3>


api.autoplayApi.play();
api.autoplayApi.pause();
api.autoplayApi.stop();
api.autoplayApi.reset();

<h3>
  TEST-024: Controls <button class="yd_prev"></button> <button class="yd_next"></button>
</h3>


<h3>
  TEST-025: Dots <div class="yd_dots"></div>
</h3>


<h3>
  TEST-026: Counter <div class="yd_counter"></div>
</h3>


<h3>
  TEST-027: Progress <div class="yd_progress"></div>
</h3>


<h3>
  TEST-028: Scrollbar <div class="yd_scrollbar"></div>
</h3>


<h3>
  TEST-029: Basic Hash <div class="yd_carousel hash"></div>
</h3>


<h3>
  TEST-030: Hash Groups <div class="yd_carousel hash" data-hash-group="gallery"></div>
</h3>


<h3>
  TEST-031: Single Sync <div data-sync="#thumbs"></div>
</h3>


<h3>
  TEST-032: Sync Group <div data-sync-group="gallery"></div>
</h3>


<h3>
  TEST-033: Sync + Loop <div class="yd_carousel loop" data-sync-group="gallery"></div>
</h3>


<h3>
  TEST-034: addSlide()
</h3>


<h3>
  TEST-035: removeSlide()
</h3>


<h3>
  TEST-036: insertSlide()
</h3>


<h3>
  TEST-037: replaceSlide()
</h3>


<h3>
  TEST-038: removeAllSlides()
</h3>


<h3>
  TEST-039: batch()
</h3>



<h3>
  TEST-040: Dynamic + Loop
</h3>


<div class="yd_carousel loop"></div>
Run all dynamic APIs.
RUNTIME LIFECYCLE
This is the area most competitors don't have.

<h3>
  TEST-041: pause()
</h3>


<h3>
  TEST-042: resume()
</h3>


<h3>
  TEST-043: freeze()
</h3>


<h3>
  TEST-044: unfreeze()
</h3>



<h3>
  TEST-045: Manual Freeze Isolation
</h3>


api.freeze(true)
api.unfreeze(false)

<h3>
  TEST-046: Auto Visibility Freeze [data-auto-visibility="true"]
</h3>


<h3>
  TEST-047: health()
</h3>


<h3>
  TEST-048: warnings()
</h3>


<h3>
  TEST-049: xray()
</h3>


<h3>
  TEST-050: compatibilityReport()
</h3>


<h3>
  TEST-051: pluginHealth()
</h3>


<h3>
  TEST-052: dependencyReport()
</h3>


<h3>
  TEST-053: destroy()
</h3>


<h3>
  TEST-054: destroy + loop
</h3>


<h3>
  TEST-055: destroy + autoplay
</h3>


<h3>
  TEST-056: destroy during drag
</h3>


<h3>
  TEST-057: reInit()
</h3>


<h3>
  TEST-058: exportState()
</h3>


<h3>
  TEST-059: importState()
</h3>



<h3>
  TEST-060: reInit + preserveState
</h3>


api.reInit({
  preserveState: true
});

<h3>
  TEST-061 <div class="yd_carousel loop drag-free autoplay"></div>
</h3>


<h3>
  TEST-062 <div class="yd_carousel loop rtl autoplay keyboard"></div>
</h3>


<h3>
  TEST-063 <div class="yd_carousel vertical autoplay keyboard"></div>
</h3>


<h3>
  TEST-064 <div class="yd_carousel loop drag-free auto-height"></div>
</h3>


<h3>
  TEST-065 <div class="yd_carousel loop autoplay focus-on-change keyboard"></div>
</h3>






<div class="yd_carousel slide-snap"></div>
  <div class="yd_viewport"></div>
    <div class="yd_container slides-3 gap-sm"></div>
      <div class="yd_slide"></div>1</div>
      <div class="yd_slide"></div>2</div>
      <div class="yd_slide"></div>3</div>
      <div class="yd_slide"></div>4</div>
      <div class="yd_slide"></div>5</div>
      <div class="yd_slide"></div>6</div>
    </div>
  </div>
</div>


  <h3 id="previous-next-buttons">Previous / Next Buttons</h3>

  <?php include 'slider/previous-next-buttons.php'; ?>
  
  <h3 id="pagination-dots">Pagination Dots</h3>

  <?php include 'slider/pagination-dots.php'; ?>
  
  <h3 id="snap-counter">Snap Counter</h3>

  <?php include 'slider/snap-counter.php'; ?>

  <h3 id="scrollbar">Scrollbar</h3>

  <?php include 'slider/scrollbar.php'; ?>

  <h3 id="progress-indicators">Progress Indicators</h3>

  <?php include 'slider/progress-indicators.php'; ?>

  <h2>Navigation</h2>
  <h3 id="keyboard-navigation">Keyboard Navigation</h3>

  <?php include 'slider/keyboard-navigation.php'; ?>


  <h3 id="getting-started">Getting Started</h3>

  slide-snap
  <div class="yd_carousel slide-snap">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
  group-snap
  <div class="yd_carousel group-snap">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
  drag-free
  <div class="yd_carousel drag-free">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
  rtl
  <div class="yd_carousel rtl">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
  vertical
  <div class="yd_carousel vertical">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
 default (align-start)
  <div class="yd_carousel loop">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
  align-center
  <div class="yd_carousel align-center loop">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
  align-end
  <div class="yd_carousel align-end loop">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide blur-xl ac:blur-0">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
  contain
  <div class="yd_carousel contain">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
  contain-keep
  <div class="yd_carousel contain-keep">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
  autoplay pause-hover
  <div class="yd_carousel autoplay pause-hover">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
  Mousewheel
  <div class="yd_carousel wheel" data-wheel-threshold="80">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
Single Sync
  <div class="yd_carousel" data-sync="#thumbs">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
Sync Groups
  <div class="yd_carousel" data-sync-group="gallery">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
hash
  <div class="yd_carousel hash">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide" data-hash="slide-1">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide" data-hash="slide-2">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide" data-hash="slide-3">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide" data-hash="slide-4">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide" data-hash="slide-5">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide" data-hash="slide-6">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
Lazy Loading
  <div class="yd_carousel ">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
auto-height
  <div class="yd_carousel auto-height">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>
fade
  <div class="yd_carousel fade">
    <div class="yd_viewport">
      <div class="yd_container slides-3 gap-sm">
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
        </div>
        <div class="yd_slide">
          <h2 class="bg-g7 clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
        </div>
      </div>
    </div>
  </div>










</section>
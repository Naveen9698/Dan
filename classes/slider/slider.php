<style>
  .yd_progress{
    height:8px;
    background:#ddd;
    border-radius:999px;
    overflow:hidden;
}

.yd_progress-fill{
    height:100%;
    width:var(--progress,0%);
    background:#0066ff;
    transition:width .15s linear;
}

.yd_autoplay-progress{
    height:8px;
    background:#ddd;
    border-radius:999px;
    overflow:hidden;
}

.yd_autoplay-progress-fill{
    height:100%;
    width:var(--ap-progress,0%);
    background:#ff5500;
    transition:width .05s linear;
}
``
</style>

<div class="yd_carousel pn-relative">

  <div class="yd_viewport of-hidden">
    <div class="yd_container slides-3">
      <div class="yd_slide px-sm">
        <h2 class="bg-sub clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">1</h2>
      </div>
      <div class="yd_slide px-sm">
        <h2 class="bg-sub clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">2</h2>
      </div>
      <div class="yd_slide px-sm">
        <h2 class="bg-sub clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">3</h2>
      </div>
      <div class="yd_slide px-sm">
        <h2 class="bg-sub clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">4</h2>
      </div>
      <div class="yd_slide px-sm">
        <h2 class="bg-sub clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">5</h2>
      </div>
      <div class="yd_slide px-sm">
        <h2 class="bg-sub clr-white fz-60 dis-flex f-center f-middle w-100p h-200px">6</h2>
      </div>
    </div>
  </div>

  <div class="yd_controles">
    <button class="yd_prev bg-g5 clr-white pn-absolute w-100p t-50p tt-50p ra-xs ba-0 l--20px w-fit px-sm py-xs"> Prev </button>
    <button class="yd_next bg-g5 clr-white pn-absolute w-100p t-50p tt-50p ra-xs ba-0 r--20px w-fit px-sm py-xs"> Next </button>

    <div class="yd_dots">
      <div class="yd_dot blur-md ac:blur-o"></div>
    </div>

    <div class="yd_counter"><span class="yd_current">1</span> / <span class="yd_total">4</span></div>

    <div class="yd_progress of-hidden h-10px bg-g5">
      <div class="yd_progress-fill bg-main h-100p ra-xl"></div>
    </div>

    <div class="yd_autoplay-progress of-hidden h-10px bg-g5">
      <div class="yd_autoplay-progress-fill bg-main h-100p ra-xl"></div>
    </div>

    <div class="yd_scrollbar bg-g2 mt-sm ra-xl pa-2px">
      <div class="yd_scrollbar-track h-10px ra-xl">
        <div class="yd_scrollbar-thumb bg-main h-10px ra-xl"></div>
      </div>
    </div>


  </div>

</div>
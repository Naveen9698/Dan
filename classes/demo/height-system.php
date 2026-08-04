<div class="grid gap-sm">

  <div class="g-4 flex-y gap-xxs bg-white ra-sm pa-sm">

    <div class="grid gap-sm mb-sm">

      <span class="g-12 fz-14 fw-600 clr-g8">Height (px)</span>

      <div class="g-4">
        <div class="bg-main clr-white pa-xs h-90px bsw-lg txt-center">
          h-90px <br> <br> 90px
        </div>
      </div>

      <div class="g-4">
        <div class="bg-main clr-white pa-xs h-90px h-add-9px bsw-lg txt-center">
          h-90px <br> h-add-9px <br><br> 99px
        </div>
      </div>

      <div class="g-4">
        <div class="bg-main clr-white pa-xs h-190px h-add-9px bsw-lg txt-center">
          h-190px <br> h-add-9px <br><br> 199px
        </div>
      </div>

      <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
        🟢 Pixel height gives precise control <br>
        🔴 Can clip or overflow content
      </p>

    </div>
  </div>

  <div class="g-4 flex-y gap-xxs bg-white ra-sm pa-sm">

    <div class="grid gap-sm mb-sm">

      <span class="g-12 fz-14 fw-600 clr-g8">Height (vh)</span>

      <div class="g-4">
        <div class="bg-sub clr-white pa-xs h-9vh bsw-lg txt-center">
          h-9vh
        </div>
      </div>

      <div class="g-4">
        <div class="bg-sub clr-white pa-xs h-20vh bsw-lg txt-center">
          h-20vh
        </div>
      </div>

      <div class="g-4">
        <div class="bg-sub clr-white pa-xs h-10vh h-add-9vh bsw-lg txt-center">
          h-10vh <br> h-add-9vh <br><br> 19vh
        </div>
      </div>

      <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
        🟢 vh is independent of parent height <br>
        🟢 Best choice for responsive vertical sizing
      </p>

    </div>
  </div>

  <div class="g-4 flex-y gap-xxs bg-white ra-sm pa-sm">

    <div class="grid gap-sm mb-sm">

      <span class="g-12 fz-14 fw-600 clr-g8">Height (%)</span>

      <div class="g-4">
        <div class="h-200px bsw-sm">
          <div class="bg-acnt clr-white pa-xs h-50p bsw-lg txt-center">
            h-200px <br>
            h-50p <br><br> 50%
          </div>

        </div>
      </div>

      <div class="g-4">
        <div class="h-30vh bsw-sm">

          <div class="bg-acnt clr-white pa-xs h-50p bsw-lg txt-center">
            h-30vh <br>
            h-50p <br><br> 50%
          </div>

        </div>
      </div>

      <div class="g-4">
        <div class="bsw-sm">

          <div class="bg-acnt clr-white pa-xs h-50p bsw-lg txt-center">
            h-50p <br><br> fails ❌
          </div>

        </div>
      </div>

      <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
        🟡 Requires parent height <br>
        🔴 Fails in normal flow layouts
      </p>

    </div>
  </div>

  <div class="g-4 flex-y gap-xxs bg-white ra-md pa-md">
    <span class="fz-14 fw-600 clr-g8">Overflow Behavior</span>

    <div class="grid flex-x gap-sm">

      <div class="g-4 bg-sub clr-g8 pa-xs h-200px">
        <b>No overflow</b><br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line
      </div>

      <div class="g-4 bg-sub clr-white pa-xs h-200px of-auto">
        <b>Scroll</b><br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line
      </div>

      <div class="g-4 bg-sub clr-white pa-xs h-200px of-hidden">
        <b>hidden</b><br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line<br>Line
      </div>

    </div>

    <p class="fz-14 clr-g5 lh-16 ml-md">
      🟡 Height defines available space — content may overflow, be clipped, or scroll<br>
      🟢 Use overflow to control excess content
    </p>
  </div>

  <div class="g-4 flex-y gap-xxs bg-white ra-md pa-md">
    <span class="fz-14 fw-600 clr-g8">Max Height</span>

    <div class="bg-acnt clr-white pa-xs h-200px h-100max of-hidden">
      h-200px <br> h-100max (forces maximum height ✅)<br>
      Line<br>Line<br>Line<br>Line
    </div>

    <div class="bg-acnt clr-white pa-xs h-200px h-300max of-hidden">
      h-200px (height ✅)<br> 
      h-300max<br>
      Line<br>Line<br>Line<br>Line
    </div>

    <p class="fz-14 clr-g5 lh-16 ml-md">
      🟢 Growth stops at max height <br>
      🔴 Content gets clipped
    </p>
  </div>

  <div class="g-4 flex-y gap-xxs bg-white ra-md pa-md">
    <span class="fz-14 fw-600 clr-g8">Min Height</span>

    <div class="bg-g5 clr-white pa-xs h-100px h-20min">
      h-100px (height ✅)<br>
      h-20min 
    </div>

    <div class="bg-g5 clr-white pa-xs h-100px h-300min">
      h-100px <br> h-300min (forces minimum height ✅)
    </div>

    <p class="fz-14 clr-g5 lh-16 ml-md">
      🟢 Prevents collapse below a minimum size
    </p>
  </div>

</div>
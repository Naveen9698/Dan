<div class="grid gap-lg bg-white ra-lg pa-lg">

  <div class="g-6 flex-y gap-xxs">
    <span class="fz-14 fw-600 clr-g8">Floating Card</span>

    <div class="pn-relative bg-g2 h-200px ra-md"></div>

    <div class="pn-relative">

      <div class="pn-absolute fw-700 t--50px r-20px bg-white pa-md ra-md bsw-sm">
        t--50px r-20px
      </div>

    </div>

    <p class="fz-14 clr-g5">
      🟢 Used in dashboards, previews, overlays <br>
      🟡 Negative offsets create overlap between sections
    </p>
  </div>

  <div class="g-6 flex-y gap-xxs">
    <span class="fz-14 fw-600 clr-g8">Centered Modal</span>

    <div class="pn-relative h-200px bg-g2 ra-md">

      <div class="pn-absolute fw-700 pn-center bg-white pa-md ra-md bsw-lg">
        .pn-center
      </div>

    </div>

    <p class="fz-14 clr-g5">
      🟢 pn-center is the most reliable centering pattern <br>
      🟢 Works regardless of content size
    </p>
  </div>

  <div class="g-6 flex-y gap-xxs">
    <span class="fz-14 fw-600 clr-g8">Hero Text Overlay</span>

    <div class="ar-16x9 pn-relative">

      <img src="img/800x500-3.jpg" alt="">

      <div class="pn-absolute b-20px l-20px clr-white bg-g9 pa-md bsw-sm op-70">
        <b class="fz-18">Heading</b><br>
        <span class="fz-12">lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
      </div>

    </div>

    <p class="fz-14 clr-g5">
      🟢 Common in banners, heroes, media cards <br>
      🟢 Uses bottom/left offsets instead of padding hacks
    </p>
  </div>

<div class="g-6 flex-y gap-xxs">
  <span class="fz-14 fw-600 clr-g8">Feature Card (Advanced Composition)</span>

  <div class="pn-relative ar-16x9 ra-md">

    <div class="ar-16x9 ra-md">
      <img src="img/800x500-2.jpg" class="w-100p h-100p obj-cover" alt="">
    </div>

    <div class="pn-absolute pn-center z-2">
      <div class="bg-white pa-xxs ra-sm bsw-lg">
        <div class="ar-1x1 ra-sm w-100px of-hidden">
          <img src="img/800x500-2.jpg" class="w-100p h-100p obj-cover">
        </div>
      </div>
    </div>

    <div class="pn-absolute t-20px r--30px z-3">
      <div class="bg-white pa-xs ra-xs bsw-md fz-12 fw-600">
        Featured
      </div>
    </div>

    <div class="pn-absolute b-20px l-20px z-3">
      <div class="bg-g9 clr-white pa-md ra-md bsw-sm">
        <b class="fz-14">Product Title</b><br>
        <span class="fz-12">Short description</span>
      </div>
    </div>

    <div class="pn-absolute b--20px r-20px z-4">
      <div class="bg-white pa-sm ra-lg bsw-md">
        →
      </div>
    </div>

  </div>

  <p class="fz-14 clr-g5">
    🟢 Multiple offsets work together inside a single component <br>
    🟢 Combines center, corner, stacking, and negative positioning <br>
    🟡 Creates layered UI with clear hierarchy and emphasis
  </p>
</div>


</div>
<div class="grid gap-lg bg-white ra-lg pa-lg">

  <!-- FLOATING CARD (OVERLAP SECTION) -->
  <div class="g-6 flex-y gap-xxs">
    <span class="fs-14 fw-600 clr-g8">Floating Card</span>

    <div class="pn-relative bg-g2 h-200px ra-md"></div>

    <div class="pn-relative">

      <div class="pn-absolute fw-700 t--50px r-20px bg-white pa-md ra-md sw-sm">
        t--50px r-20px
      </div>

    </div>

    <p class="fs-14 clr-g5">
      🟢 Used in dashboards, previews, overlays <br>
      🟡 Negative offsets create overlap between sections
    </p>
  </div>

  <!-- CENTERED MODAL -->
  <div class="g-6 flex-y gap-xxs">
    <span class="fs-14 fw-600 clr-g8">Centered Modal</span>

    <div class="pn-relative h-200px bg-g2 ra-md">

      <div class="pn-absolute fw-700 pn-center bg-white pa-md ra-md sw-lg">
        .pn-center
      </div>

    </div>

    <p class="fs-14 clr-g5">
      🟢 pn-center is the most reliable centering pattern <br>
      🟢 Works regardless of content size
    </p>
  </div>

  <!-- HERO TEXT OVER IMAGE -->
  <div class="g-6 flex-y gap-xxs">
    <span class="fs-14 fw-600 clr-g8">Hero Text Overlay</span>

    <div class="bg-container ar-16x9 pn-relative">

      <img src="img/800x500-3.jpg" alt="">

      <div class="pn-absolute b-20px l-20px clr-white bg-g9 pa-md sw-sm op-70">
        <b class="fs-18">Heading</b><br>
        <span class="fs-12">lorem ipsum dolor sit amet, consectetur adipiscing elit</span>
      </div>

    </div>

    <p class="fs-14 clr-g5">
      🟢 Common in banners, heroes, media cards <br>
      🟢 Uses bottom/left offsets instead of padding hacks
    </p>
  </div>

<!-- FEATURE CARD (ADVANCED COMPOSITION - FIXED) -->
<div class="g-6 flex-y gap-xxs">
  <span class="fs-14 fw-600 clr-g8">Feature Card (Advanced Composition)</span>

  <div class="pn-relative ar-16x9 ra-md">

    <!-- IMAGE (CLIPPED ONLY HERE) -->
    <div class="bg-container ar-16x9 ra-md">
      <img src="img/800x500-2.jpg" class="bg-img" alt="">
    </div>

    <!-- CENTER FOCUS -->
    <div class="pn-absolute pn-center z-2">
      <div class="bg-white pa-xxs ra-sm sw-lg">
        <div class="bg-container ar-1 ra-sm w-100px">
          <img src="img/800x500-2.jpg" class="bg-img">
        </div>
      </div>
    </div>

    <!-- FEATURE BADGE -->
    <div class="pn-absolute t-20px r--30px z-3">
      <div class="bg-white pa-xs ra-xs sw-md fs-12 fw-600">
        Featured
      </div>
    </div>

    <!-- CONTENT CARD (MAIN INFO - CLEAN ANCHOR) -->
    <div class="pn-absolute b-20px l-20px z-3">
      <div class="bg-g9 clr-white pa-md ra-md sw-sm">
        <b class="fs-14">Product Title</b><br>
        <span class="fs-12">Short description</span>
      </div>
    </div>

    <!-- FLOATING ACTION -->
    <div class="pn-absolute b--20px r-20px z-4">
      <div class="bg-white pa-sm ra-lg sw-md">
        →
      </div>
    </div>

  </div>

  <p class="fs-14 clr-g5">
    🟢 Multiple offsets work together inside a single component <br>
    🟢 Combines center, corner, stacking, and negative positioning <br>
    🟡 Creates layered UI with clear hierarchy and emphasis
  </p>
</div>


</div>
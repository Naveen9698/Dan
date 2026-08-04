<div class="grid gap-md">

  <div class="g-6 pn-relative bsw-sm pa-sm ra-xs">
    <span class="fz-14 fw-600 clr-g8">Z-index (Stacking Order)</span>
    <div class="pn-relative h-200px h-add-20px bg-g1 ra-md pa-md">
      <div id="box1"
        class="pn-absolute w-60p z-1 t-30px l-30px bg-main-h clr-white pa-sm ra-sm">
        Box A (z-1)
      </div>
      <div id="box2"
        class="pn-absolute w-60p z-2 t-80px l-60px bg-sub clr-white pa-sm ra-sm">
        Box B (z-2)
      </div>
      <div id="box3"
        class="pn-absolute w-60p z-3 t-100px t-add-30px l-90px bg-acnt clr-white pa-sm ra-sm">
        Box C (z-3)
      </div>
    </div>

    <p class="fz-14 clr-g5 lh-16 mt-sm ml-md">
      🟢 <b>z-*</b> controls which element appears on top.<br>
      🟢 Higher value = appears above others.<br>
      🟢 Works only on <b>positioned elements</b>.<br>
      🔴 Without positioning (pn-*), z-index has no effect.
    </p>

  </div>

  <div class="g-6 bsw-sm pa-sm ra-xs">
    <span class="fz-14 fw-600 clr-g8">
      Without positioning (z-index does NOT work)
    </span>

    <div class="h-200px h-add-20px bg-g1 ra-md pa-md">
      <div id="box1"
        class="w-60p z-1 t-30px l-30px bg-main-h clr-white pa-sm ra-sm">
        Box A (z-1)
      </div>
      <div id="box2"
        class="w-60p z-2 t-80px l-60px bg-sub clr-white pa-sm ra-sm">
        Box B (z-2)
      </div>
      <div id="box3"
        class="w-60p z-3 t-100px t-add-30px l-90px bg-acnt clr-white pa-sm ra-sm">
        Box C (z-3)
      </div>
    </div>

    <p class="fz-14 clr-g5 lh-16 mt-sm ml-md">
      🔴 All elements use <b>z-*</b>, but none are positioned (no pn-*), so z-index has no effect.<br>
      🟡 Elements follow normal document flow instead of overlapping, so stacking cannot occur.<br>
      🟡 Offset utilities (top/left) also require positioning, so they are ignored here.<br>
      🟢 Apply pn-relative, pn-absolute, pn-fixed, or pn-sticky to activate stacking behavior.
    </p>
  </div>

</div>
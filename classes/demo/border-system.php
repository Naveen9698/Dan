<div class="grid gap-md mt-lg bg-white pa-sm sw-sm">

  <h3 class="g-12">ba-*, bt-*, br-*, bb-*, bl-*</h3>

  <div class="g-2">
    <div class="pa-sm bg-white ba-sm clr-main-h sw-sm">
      ba-sm
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-white bt-sm clr-main-h sw-sm">
      bt-sm
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-white br-sm clr-main-h sw-sm">
      br-sm
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-white bb-sm clr-main-h sw-sm">
      bb-sm
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-white bl-sm clr-main-h sw-sm">
      bl-sm
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-white bl-sm bb-sm clr-main-h sw-sm">
      bl-sm bb-sm
    </div>
  </div>

</div>

<div class="grid gap-md mt-lg bg-white pa-sm sw-sm">

  <h3 class="g-12">Scale (xxs → xxl)</h3>

  <div class="g-3">
    <div class="pa-sm bg-white ba-0 clr-main-h sw-sm">
      ba-0
    </div>
  </div>

  <div class="g-3">
    <div class="pa-sm bg-white ba-xxs clr-main-h sw-sm">
      ba-xxs
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-xs clr-main-h sw-sm">
      ba-xs
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-sm clr-main-h sw-sm">
      ba-sm
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-md clr-main-h sw-sm">
      ba-md
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-lg clr-main-h sw-sm">
      ba-lg
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-xl clr-main-h sw-sm">
      ba-xl
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-xxl clr-main-h sw-sm">
      ba-xxl
    </div>
  </div>

  <p class="g-12 fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>ba-*</b> applies border on all sides<br>
    🟢 <b>bt, br, bb, bl</b> control individual sides<br>
    🟢 Uses a semantic scale (xxs → xxl)<br>
    🟡 Border color follows <b>clr-*</b><br>
    🔴 Border width is structural and does not change on interaction
  </p>

</div>

<div class="grid gap-md mt-lg bg-white pa-sm sw-sm">

  <h3 class="g-12">bs-* (Border Style)</h3>

  <div class="g-3">
    <div class="pa-sm bg-white ba-md clr-main bs-solid">
      bs-solid
    </div>
  </div>

  <div class="g-3">
    <div class="pa-sm bg-white ba-md clr-sub bs-dashed">
      bs-dashed
    </div>
  </div>

  <div class="g-3">
    <div class="pa-sm bg-white ba-md clr-acnt bs-dotted">
      bs-dotted
    </div>
  </div>

  <div class="g-3">
    <div class="pa-sm bg-white ba-md clr-g7 bs-double">
      bs-double
    </div>
  </div>

  <p class="g-12 fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>bs-*</b> defines border style independently<br>
    🟢 Combines with <b>ba-*</b> to form the border<br>
    🟡 Style changes are static and not interactive<br>
    🔴 Border structure (width/style) remains fixed
  </p>

</div>

<div class="grid gap-md mt-lg bg-white pa-sm sw-sm">

  <h3 class="g-12">Self Hover (.hr-clr-*)</h3>

  <div class="g-4">
    <div class="pa-sm bg-white ba-md clr-g4 tr-2 hr-clr-main">
      Gray → Main <br> <br> ba-md clr-g4 hr-clr-main
    </div>
  </div>

  <div class="g-4">
    <div class="pa-sm bg-white bl-lg bb-sm clr-g5 tr-2 hr-clr-sub">
      Gray → Sub <br> <br>
      bl-lg bb-sm clr-g5 hr-clr-sub
    </div>
  </div>

  <div class="g-4">
    <div class="pa-sm bg-white bt-md br-xxl clr-g6 tr-2 hr-clr-acnt">
      Gray → Acnt <br> <br>
      bt-md br-xxl clr-g6 hr-clr-acnt
    </div>
  </div>

  <p class="g-12 fs-14 clr-g5 lh-16 ml-md">
    🟢 Border uses <b>currentColor</b> internally<br>
    🟢 <b>hr-clr-*</b> updates border color on hover<br>
    🟡 Interaction is smooth since only color changes<br>
    🔴 Border width and style remain unchanged
  </p>

</div>

<div class="grid gap-x-lg gap-y-sm bg-white sw-md pa-md">

  <div class="g-12">
    <h3>Parent Hover (.chr-clr-*)</h3>
  </div>

  <div class="g-12 flex-y gap-xxs">

    <span class="fs-14 fw-600 clr-g8">
      Parent Hover Area (hover this box)
    </span>

    <div class="chr-parent ba-xxs pa-sm h-100p">

      <p class="fs-12 clr-g6 mb-sm">
        chr-parent
      </p>

      <div class="grid gap-sm">

        <div class="g-4">
          <div class="pn-relative of-hidden bg-white ba-sm clr-g4 tr-2 chr-clr-main">

            <div class="flex-x px-sm pt-xs fs-12 fw-500 op-70">
              chr-clr-main
            </div>

            <div class="pn-absolute inset-0 flex-y f-top f-right pa-sm">
              <p class="fs-24 fw-700 clr-g4">Abc</p>
            </div>

            <div class="flex-y f-bottom pt-md pr-lg">
              <p class="bg-g1 clr-g8 fs-12 px-xxs py-xxs op-70 w-fit">
                clr-g4 → chr-clr-main
              </p>
            </div>

          </div>
        </div>

        <div class="g-4">
          <div class="pn-relative of-hidden bg-white ba-sm clr-g5 tr-2 chr-clr-sub">

            <div class="flex-x px-sm pt-xs fs-12 fw-500 op-70">
              chr-clr-sub
            </div>

            <div class="pn-absolute inset-0 flex-y f-top f-right pa-sm">
              <p class="fs-24 fw-700 clr-g5">Abc</p>
            </div>

            <div class="flex-y f-bottom pt-md pr-lg">
              <p class="bg-g1 clr-g8 fs-12 px-xxs py-xxs op-70 w-fit">
                clr-g5 → chr-clr-sub
              </p>
            </div>

          </div>
        </div>

        <div class="g-4">
          <div class="pn-relative of-hidden bg-white ba-sm clr-g6 tr-2 chr-clr-acnt">

            <div class="flex-x px-sm pt-xs fs-12 fw-500 op-70">
              chr-clr-acnt
            </div>

            <div class="pn-absolute inset-0 flex-y f-top f-right pa-sm">
              <p class="fs-24 fw-700 clr-g6">Abc</p>
            </div>

            <div class="flex-y f-bottom pt-md pr-lg">
              <p class="bg-g1 clr-g8 fs-12 px-xxs py-xxs op-70 w-fit">
                clr-g6 → chr-clr-acnt
              </p>
            </div>

          </div>
        </div>

      </div>

    </div>

    <p class="g-12 fs-14 clr-g5 lh-16 ml-md">
      🟢 Hover this container to apply parent interaction<br>
      🟢 <b>chr-clr-*</b> applies color to children on parent hover<br>
      🟡 All cards update together as a group<br>
      🔴 Requires <b>chr-parent</b> to activate<br>
      🔴 Only color changes — structure remains unchanged
    </p>

  </div>

</div>
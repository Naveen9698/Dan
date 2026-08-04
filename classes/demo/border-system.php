<div class="grid gap-md mt-lg bg-white pa-sm bsw-sm">

  <h3 class="g-12">ba-*, bt-*, br-*, bb-*, bl-*</h3>

  <div class="g-2">
    <div class="pa-sm bg-white ba-sm clr-main-h bsw-sm">
      ba-sm
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-white bt-sm clr-main-h bsw-sm">
      bt-sm
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-white br-sm clr-main-h bsw-sm">
      br-sm
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-white bb-sm clr-main-h bsw-sm">
      bb-sm
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-white bl-sm clr-main-h bsw-sm">
      bl-sm
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-white bl-sm bb-sm clr-main-h bsw-sm">
      bl-sm bb-sm
    </div>
  </div>

</div>

<div class="grid gap-md mt-lg bg-white pa-sm bsw-sm">

  <h3 class="g-12">Scale (xxs → xxl)</h3>

  <div class="g-3">
    <div class="pa-sm bg-white ba-0 clr-main-h bsw-sm">
      ba-0
    </div>
  </div>

  <div class="g-3">
    <div class="pa-sm bg-white ba-xxs clr-main-h bsw-sm">
      ba-xxs
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-xs clr-main-h bsw-sm">
      ba-xs
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-sm clr-main-h bsw-sm">
      ba-sm
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-md clr-main-h bsw-sm">
      ba-md
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-lg clr-main-h bsw-sm">
      ba-lg
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-xl clr-main-h bsw-sm">
      ba-xl
    </div>
  </div>
  <div class="g-3">
    <div class="pa-sm bg-white ba-xxl clr-main-h bsw-sm">
      ba-xxl
    </div>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>ba-*</b> applies border on all sides<br>
    🟢 <b>bt, br, bb, bl</b> control individual sides<br>
    🟢 Uses a semantic scale (xxs → xxl)<br>
    🟡 Border color follows <b>clr-*</b><br>
    🔴 Border width is structural and does not change on interaction
  </p>

</div>

<div class="grid gap-md mt-lg bg-white pa-sm bsw-sm">

  <h3 class="g-12">bstyle-* (Border Style)</h3>

  <div class="g-3">
    <div class="pa-sm bg-white ba-md clr-main bstyle-solid">
      bstyle-solid
    </div>
  </div>

  <div class="g-3">
    <div class="pa-sm bg-white ba-md clr-sub bstyle-dashed">
      bstyle-dashed
    </div>
  </div>

  <div class="g-3">
    <div class="pa-sm bg-white ba-md clr-acnt bstyle-dotted">
      bstyle-dotted
    </div>
  </div>

  <div class="g-3">
    <div class="pa-sm bg-white ba-md clr-g7 bstyle-double">
      bstyle-double
    </div>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>bstyle-*</b> defines border style independently<br>
    🟢 Combines with <b>ba-*</b> to form the border<br>
    🟡 Style changes are static and not interactive<br>
    🔴 Border structure (width/style) remains fixed
  </p>

</div>

<div class="grid gap-md mt-lg bg-white pa-sm bsw-sm">

  <h3 class="g-12">Self Hover (.hs-clr-*)</h3>

  <div class="g-4">
    <div class="pa-sm bg-white ba-md clr-g4 ts-2 hs-clr-main">
      Gray → Main <br> <br> ba-md clr-g4 hs-clr-main
    </div>
  </div>

  <div class="g-4">
    <div class="pa-sm bg-white bl-lg bb-sm clr-g5 ts-2 hs-clr-sub">
      Gray → Sub <br> <br>
      bl-lg bb-sm clr-g5 hs-clr-sub
    </div>
  </div>

  <div class="g-4">
    <div class="pa-sm bg-white bt-md br-xxl clr-g6 ts-2 hs-clr-acnt">
      Gray → Acnt <br> <br>
      bt-md br-xxl clr-g6 hs-clr-acnt
    </div>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 Border uses <b>currentColor</b> internally<br>
    🟢 <b>hs-clr-*</b> updates border color on hover<br>
    🟡 Interaction is smooth since only color changes<br>
    🔴 Border width and style remain unchanged
  </p>

</div>

<div class="grid gap-x-lg gap-y-sm bg-white bsw-md pa-md">

  <div class="g-12">
    <h3>Parent Hover (.chs-clr-*)</h3>
  </div>

  <div class="g-12 flex-y gap-xxs">

    <span class="fz-14 fw-600 clr-g8">
      Parent Hover Area (hover this box)
    </span>

    <div class="chs-parent ba-xxs pa-sm h-100p">

      <p class="fz-12 clr-g6 mb-sm">
        chs-parent
      </p>

      <div class="grid gap-sm">

        <div class="g-4">
          <div class="pn-relative of-hidden bg-white ba-sm clr-g4 ts-2 chs-clr-main">

            <div class="flex-x px-sm pt-xs fz-12 fw-500 op-70">
              chs-clr-main
            </div>

            <div class="pn-absolute inset-0 flex-y f-top f-right pa-sm">
              <p class="fz-24 fw-700 clr-g4">Abc</p>
            </div>

            <div class="flex-y f-bottom pt-md pr-lg">
              <p class="bg-g1 clr-g8 fz-12 px-xxs py-xxs op-70 w-fit">
                clr-g4 → chs-clr-main
              </p>
            </div>

          </div>
        </div>

        <div class="g-4">
          <div class="pn-relative of-hidden bg-white ba-sm clr-g5 ts-2 chs-clr-sub">

            <div class="flex-x px-sm pt-xs fz-12 fw-500 op-70">
              chs-clr-sub
            </div>

            <div class="pn-absolute inset-0 flex-y f-top f-right pa-sm">
              <p class="fz-24 fw-700 clr-g5">Abc</p>
            </div>

            <div class="flex-y f-bottom pt-md pr-lg">
              <p class="bg-g1 clr-g8 fz-12 px-xxs py-xxs op-70 w-fit">
                clr-g5 → chs-clr-sub
              </p>
            </div>

          </div>
        </div>

        <div class="g-4">
          <div class="pn-relative of-hidden bg-white ba-sm clr-g6 ts-2 chs-clr-acnt">

            <div class="flex-x px-sm pt-xs fz-12 fw-500 op-70">
              chs-clr-acnt
            </div>

            <div class="pn-absolute inset-0 flex-y f-top f-right pa-sm">
              <p class="fz-24 fw-700 clr-g6">Abc</p>
            </div>

            <div class="flex-y f-bottom pt-md pr-lg">
              <p class="bg-g1 clr-g8 fz-12 px-xxs py-xxs op-70 w-fit">
                clr-g6 → chs-clr-acnt
              </p>
            </div>

          </div>
        </div>

      </div>

    </div>

    <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
      🟢 Hover this container to apply parent interaction<br>
      🟢 <b>chs-clr-*</b> applies color to children on parent hover<br>
      🟡 All cards update together as a group<br>
      🔴 Requires <b>chs-parent</b> to activate<br>
      🔴 Only color changes — structure remains unchanged
    </p>

  </div>

</div>
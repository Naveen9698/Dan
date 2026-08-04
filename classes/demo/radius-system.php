<div class="grid gap-md mt-lg bg-white ra-sm pa-sm bsw-sm">

  <h3 class="g-12">ra-*, rtl-*, rtr-*, rbr-*, rbl-*</h3>

  <div class="g-2">
    <div class="pa-sm bg-main clr-white ra-lg">
      ra-lg
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-main clr-white rtl-lg">
      rtl-lg
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-main clr-white rtr-lg">
      rtr-lg
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-main clr-white rbr-lg">
      rbr-lg
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-main clr-white rbl-lg">
      rbl-lg
    </div>
  </div>

  <div class="g-2">
    <div class="pa-sm bg-main clr-white rtr-lg rbl-lg">
      rtr-lg | rbl-lg
    </div>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>ra-*</b> applies radius to all corners<br>
    🟢 <b>rtl, rtr, rbr, rbl</b> control individual corners<br>
    🟢 Multiple directional utilities can be combined to create custom shapes <br>
    🟡 Directional utilities allow asymmetric shapes<br>
    🔴 Radius affects only shape, not layout
  </p>

</div>

<div class="grid gap-md mt-lg bg-white ra-sm pa-sm bsw-sm">

  <h3 class="g-12">Scale (xxs → xxl) + max</h3>

  <div class="g-3">
    <div class="pa-md bg-main clr-white ra-0">
      ra-0
    </div>
  </div>

  <div class="g-3">
    <div class="pa-md bg-main clr-white ra-xxs">
      ra-xxs
    </div>
  </div>

  <div class="g-3">
    <div class="pa-md bg-main clr-white ra-xs">
      ra-xs
    </div>
  </div>

  <div class="g-3">
    <div class="pa-md bg-main clr-white ra-sm">
      ra-sm
    </div>
  </div>

  <div class="g-3">
    <div class="pa-md bg-main clr-white ra-md">
      ra-md
    </div>
  </div>

  <div class="g-3">
    <div class="pa-md bg-main clr-white ra-lg">
      ra-lg
    </div>
  </div>

  <div class="g-3">
    <div class="pa-md bg-main clr-white ra-xl">
      ra-xl
    </div>
  </div>

  <div class="g-3">
    <div class="pa-md bg-main clr-white ra-xxl">
      ra-xxl
    </div>
  </div>

  <div class="g-3"></div>

  <div class="g-3">
    <div class="pa-md bg-main clr-white ra-max">
      ra-max
    </div>
  </div>

  <div class="g-3 ma-auto">
    <div class="txt-center px-xs py-md bg-main clr-white ra-max">
      ra-max
    </div>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 Radius uses a semantic scale (xxs → xxl)<br>
    🟢 <b>ra-max</b> creates fully rounded shapes for pills, circles, and avatars<br>
    🔴 <b>ra-max</b> is not part of scale — use intentionally <br>
    🟢 Larger values create softer shapes<br>
    🟡 Choose based on visual feel, not exact size<br>
    🔴 Avoid mixing too many radius levels in one component
  </p>

</div>

<div class="grid gap-md mt-lg bg-white ra-sm pa-sm bsw-sm">

  <h3 class="g-12">Self Hover (.hs-ra-*)</h3>

  <div class="g-3">
    <div class="pa-sm bg-main clr-white ts-2 hs-ra-lg">
      Normal <br> hs-ra-lg
    </div>
  </div>

  <div class="g-3">
    <div class="pa-sm bg-main clr-white ra-sm ts-2 hs-ra-lg">
      ra-sm <br> hs-ra-lg
    </div>
  </div>

  <div class="g-3">
    <div class="pa-sm bg-main clr-white ra-md ts-2 hs-ra-sm">
      ra-md <br> hs-ra-sm
    </div>
  </div>

  <div class="g-3">
    <div class="pa-sm bg-main clr-white ra-sm ts-2 hs-ra-xxl">
      ra-sm <br> hs-ra-xxl
    </div>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>hs-ra-*</b> changes radius on hover<br>
    🟢 Smooth transitions enhance interaction<br>
    🟡 Use subtle changes for better UX<br>
    🔴 Avoid extreme jumps for consistency
  </p>

</div>

<div class="grid gap-x-lg gap-y-sm bg-white bsw-md ra-md pa-md">

  <div class="g-12">
    <h3>Parent & Self Hover (.chs-parent .chs-ra-* .hs-ra-*)</h3>
  </div>

  <div class="g-6 flex-y gap-xxs">

    <span class="fz-14 fw-600 clr-g8">
      Parent Hover Area (hover this box)
    </span>

    <div class="chs-parent ba-xxs pa-sm h-100p">

      <p class="fz-12 clr-g6 mb-sm">
        chs-parent
      </p>

      <div class="grid gap-sm">

        <div class="g-4">
          <div class="pa-sm bg-main clr-white ts-2 chs-ra-lg">
            Normal <br> chs-ra-lg
          </div>
        </div>

        <div class="g-4">
          <div class="pa-sm bg-main clr-white ra-md ts-2 chs-ra-sm">
            ra-md <br> chs-ra-sm
          </div>
        </div>

        <div class="g-4">
          <div class="pa-sm bg-main clr-white ra-sm ts-2 chs-ra-xxl">
            ra-sm <br> chs-ra-xxl
          </div>
        </div>

      </div>

    </div>

    <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
      🟢 Hover this container to apply shape changes<br>
      🟢 <b>chs-ra-*</b> updates radius for all items<br>
      🟡 All cards change together (group behavior)<br>
      🔴 Requires <b>chs-parent</b> to activate<br>
      🔴 Radius affects shape only (no layout change)
    </p>

  </div>

  <div class="g-6 flex-y gap-xxs">

    <span class="fz-14 fw-600 clr-g8">
      Parent sets, Self refines
    </span>

    <div class="chs-parent ba-xxs pa-sm">

      <p class="fz-12 clr-g6 mb-sm">
        chs-parent
      </p>

      <div class="grid gap-sm">

        <div class="g-4">
          <div class="pa-sm bg-main clr-white ts-2 chs-ra-lg hs-ra-sm">
            Normal <br> chs-ra-lg <br> hs-ra-sm
          </div>
        </div>

        <div class="g-4">
          <div class="pa-sm bg-main clr-white ra-md ts-2 chs-ra-xxl hs-ra-0">
            ra-md <br> chs-ra-xxl <br> hs-ra-0
          </div>
        </div>

        <div class="g-4">
          <div class="pa-sm bg-main clr-white ra-sm ts-2 chs-ra-xs hs-ra-0">
            ra-sm <br> chs-ra-xs <br> hs-ra-0
          </div>
        </div>

      </div>

    </div>

    <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
      🟢 <b>chs-ra-*</b> applies radius on parent hover (group shape)<br>
      🟢 <b>hs-ra-*</b> applies radius on self hover (override)<br>
      🟡 Parent sets base shape, self refines it per item<br>
      🔴 <b>hs-*</b> overrides <b>chs-*</b> when both are active<br>
      🔴 Only one radius value applies (no stacking)
    </p>

  </div>

</div>

<div class="grid gap-x-lg">

  <div class="g-6 grid gap-md mt-lg bg-white ra-sm pa-sm bsw-sm">

    <h3 class="g-12">Radius Transition with <b>ra-max</b> (Limitation Demo)</h3>

    <div class="g-6 stack-y-sm">
      <div class="pa-sm bg-main clr-white ra-max ts-4 hs-ra-sm">
        ra-max <br> hs-ra-sm
      </div>
      <div class="px-xs pt-md txt-center w-100px h-100px fz-12 bg-main clr-white ra-max ts-4 hs-ra-sm">
        ra-max <br> hs-ra-sm
      </div>
    </div>

    <div class="g-6 stack-y-sm">
      <div class="pa-sm bg-main clr-white ra-xxl ts-4 hs-ra-sm">
        ra-xxl <br> hs-ra-sm
      </div>
      <div class="px-xs pt-md txt-center w-100px h-100px fz-12 bg-main clr-white ra-xxl ts-4 hs-ra-sm">
        ra-xxl <br> hs-ra-sm
      </div>
    </div>

    <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
      🟢 <b>hs-ra-*</b> updates the radius on hover using smooth transitions<br>
      🟡 When starting from <b>ra-max</b>, the visible radius is already at its maximum limit<br>
      🟡 On hover, the transition appears abrupt because most intermediate values are visually identical<br>
      🟡 The effect is more noticeable on smaller elements (lower max-radius cap)<br>
      🔴 <b>Why this happens:</b> border-radius is constrained by element size (min(width/2, height/2))<br>
      🔴 Values beyond this limit (like <b>ra-max</b>) collapse visually, reducing transition range<br>
      🟢 <b>Best Practice:</b> use <b>ra-xxl</b> for smooth animations<br>
      🟢 use <b>ra-max</b> only for final/static shapes (pills, circles)
    </p>

  </div>

  <div class="g-6 grid gap-md mt-lg bg-white ra-sm pa-sm bsw-sm">

    <h3 class="g-12">Stress and Limitation Test</h3>

    <div class="g-6 flex-y gap-xxs">

      <span class="fz-14 fw-600 clr-g8">
        Parent/Self Hover (Layerd)
      </span>

      <div class="chs-parent ba-xxs pa-sm h-100p">

        <p class="fz-12 clr-g6 mb-sm">
          chs-parent
        </p>

        <div class="px-sm py-xs mt-xs bg-main clr-white ts-2 hs-ra-0 chs-ra-lg">
          Normal | chs-ra-lg | hs-ra-0
          <div class="px-sm py-xs mt-xs bg-sub clr-white ts-2 chs-ra-xxl hs-ra-0">
            Normal | chs-ra-xxl | hs-ra-0
            <div class="px-sm py-xs mt-xs bg-acnt clr-white ra-xxl ts-2 chs-ra-xl hs-ra-sm">
              ra-xxl | chs-ra-xl | hs-ra-sm
            </div>
          </div>
        </div>

      </div>

    </div>

    <div class="g-6 flex-y gap-xxs">

      <span class="fz-14 fw-600 clr-g8">
        Parent/Self Hover (Corners)
      </span>

      <div class="chs-parent ba-xxs pa-sm h-100p">

        <p class="fz-12 clr-g6 mb-sm">
          chs-parent
        </p>

        <div class="px-sm py-xs mt-xs bg-main clr-white ts-2 hs-rtl-xxl chs-rtr-lg">
          Normal | chs-rtr-lg | hs-rtl-xxl
          <div class="px-sm py-xs mt-xs bg-sub clr-white ts-2 chs-rbr-xxl hs-rbr-0">
            Normal | chs-rbr-xxl | hs-rbr-0
            <div class="px-sm py-xs mt-xs bg-acnt clr-white ra-xxl ts-2 chs-rbl-xl hs-rtr-sm hs-rbr-sm">
              ra-xxl | chs-rbl-xl | hs-rtr-sm | hs-rbr-sm
            </div>
          </div>
        </div>

      </div>

    </div>

    <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
      🟢 <b>Layering Test:</b> chs-parent > chs-ra-lg > hs-ra-0<br>
      🟢 <b>Nested Parent Test:</b> chs-parent > chs-ra-lg > chs-ra-xxl > chs-ra-xl.hs-ra-sm<br>
      🟢 <b>Mixed Direction + State Test:</b> hs-rtl-xxl + chs-rtr-lg<br>
      🟢 <b>Multi-State Combination Test:</b> chs-rbl-xl + hs-rtr-sm + hs-rbr-sm<br>
      🟡 <b>Deep Nesting:</b> chs-parent > chs-parent > chs-parent (avoid for readability)
    </p>

  </div>

</div>
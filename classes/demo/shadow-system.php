<div class="grid gap-sm bg-white ra-lg pa-lg">

  <h3 class="g-12">Shadow Levels (.bsw-*)</h3>

  <div class="g-12 flex-y gap-xxs">

    <div class="grid gap-lg mb-sm">
      <div class="g-3">
        <div class="pa-md bg-white ra-sm bsw-0">bsw-0</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm bsw-xxs">bsw-xxs</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm bsw-xs">bsw-xs</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm bsw-sm">bsw-sm</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm bsw-md">bsw-md</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm bsw-lg">bsw-lg</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm bsw-xl">bsw-xl</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm bsw-xxl">bsw-xxl</div>
      </div>
    </div>

    <p class="fz-14 clr-g5 lh-16 ml-md">
      🟢 <b>bsw-*</b> defines the base shadow (default elevation level)<br>
      🟡 Use lower shadows for surfaces, higher shadows for overlays (cards, modals)<br>
      🔴 Shadows are static here — no interaction or state change is applied
    </p>

  </div>

</div>
<div class="grid gap-sm bg-white ra-lg pa-lg">

  <h3 class="g-12">Self Hover (.hs-bsw-*)</h3>

  <div class="g-12 flex-y gap-xxs">

    <div class="grid gap-lg mb-sm">
      <div class="g-3">
        <div class="pa-md bg-white ra-sm ts-3 hs-bsw-lg">Normal <br> hs-bsw-lg</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm bsw-xxs ts-3 hs-bsw-0">bsw-xxs <br> hs-bsw-0</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm bsw-xs ts-3 hs-bsw-xl">bsw-xs <br> hs-bsw-xl</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm bsw-xxl ts-3 hs-bsw-sm">bsw-xxl <br> hs-bsw-sm</div>
      </div>
    </div>

    <p class="fz-14 clr-g5 lh-16 ml-md">
      🟢 <b>hs-bsw-*</b> applies shadow on <b>element hover</b> (self interaction)<br>
      🟢 Useful for direct user feedback on interactive elements (buttons, cards)<br>
      🔴 Overrides base shadow during hover — only one shadow value applies at a time
    </p>
  </div>

</div>
<div class="grid gap-x-lg gap-y-sm bg-white bsw-md ra-md pa-md">

  <div class="g-12">
    <h3>Parent & Self Hover (.chs-parent .chs-bsw-* .hs-bsw-*)</h3>
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

        <div class="g-3">
          <div class="pa-md bg-white ra-sm bsw-xxs ts-3 chs-bsw-xxl">
            bsw-xxs <br> chs-bsw-xxl
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm bsw-xxs ts-3 chs-bsw-xl">
            bsw-xxs <br> chs-bsw-xl
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm bsw-xxs ts-3 chs-bsw-md">
            bsw-xxs <br> chs-bsw-md
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm bsw-xxs ts-3 chs-bsw-0">
            bsw-xxs <br> chs-bsw-0
          </div>
        </div>

      </div>
    </div>

    <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
      🟢 <b>chs-parent</b> enables group-level interaction (container hover)<br>
      🟢 <b>chs-bsw-*</b> defines shadow for elements when the parent is hovered<br>
      🟢 Useful for coordinated UI behavior (cards, lists, grouped elements)<br>
      🟡 Best used to create a <b>unified hover experience</b> across multiple elements<br>
      🔴 Applies the same trigger to all matching children — individual control happens via <b>chs-*</b>
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

        <div class="g-3">
          <div class="pa-md bg-white ra-sm bsw-xxs ts-3 chs-bsw-xxl hs-bsw-sm">
            bsw-xxs <br> chs-bsw-xxl <br> hs-bsw-sm
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm bsw-xxs ts-3 chs-bsw-xxl hs-bsw-md">
            bsw-xxs <br> chs-bsw-xxl <br> hs-bsw-md
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm bsw-xxs ts-3 chs-bsw-md hs-bsw-0">
            bsw-xxs <br> chs-bsw-md <br> hs-bsw-0
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm bsw-xxs ts-3 chs-bsw-sm hs-bsw-0">
            bsw-xxs <br> chs-bsw-sm <br> hs-bsw-0
          </div>
        </div>

      </div>

    </div>

    <p class="fz-14 clr-g5 lh-16 ml-md">
      🟢 <b>chs-bsw-*</b> defines shadow on <b>parent hover</b> (group baseline)<br>
      🟢 <b>hs-bsw-*</b> defines shadow on <b>self hover</b> (element override)<br>
      🟡 Shadow is controlled through a single variable (--bsw) — all interactions modify this <br>
      🟢 Both can work together — self hover <b>always overrides</b> parent hover when active<br>
      🔴 Shadow is a single-value property — <b>no stacking</b>, only one value is applied at a time
    </p>

  </div>

</div>
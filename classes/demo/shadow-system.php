<div class="grid gap-sm bg-white ra-lg pa-lg">

  <h3 class="g-12">Shadow Levels (.sw-*)</h3>

  <div class="g-12 flex-y gap-xxs">

    <div class="grid gap-lg mb-sm">
      <div class="g-3">
        <div class="pa-md bg-white ra-sm sw-0">sw-0</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm sw-xxs">sw-xxs</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm sw-xs">sw-xs</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm sw-sm">sw-sm</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm sw-md">sw-md</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm sw-lg">sw-lg</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm sw-xl">sw-xl</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm sw-xxl">sw-xxl</div>
      </div>
    </div>

    <p class="fs-14 clr-g5 lh-16 ml-md">
      🟢 <b>sw-*</b> defines the base shadow (default elevation level)<br>
      🟡 Use lower shadows for surfaces, higher shadows for overlays (cards, modals)<br>
      🔴 Shadows are static here — no interaction or state change is applied
    </p>

  </div>

</div>
<div class="grid gap-sm bg-white ra-lg pa-lg">

  <h3 class="g-12">Self Hover (.hr-sw-*)</h3>

  <div class="g-12 flex-y gap-xxs">

    <div class="grid gap-lg mb-sm">
      <div class="g-3">
        <div class="pa-md bg-white ra-sm tr-3 hr-sw-lg">Normal <br> hr-sw-lg</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm sw-xxs tr-3 hr-sw-0">sw-xxs <br> hr-sw-0</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm sw-xs tr-3 hr-sw-xl">sw-xs <br> hr-sw-xl</div>
      </div>
      <div class="g-3">
        <div class="pa-md bg-white ra-sm sw-xxl tr-3 hr-sw-sm">sw-xxl <br> hr-sw-sm</div>
      </div>
    </div>

    <p class="fs-14 clr-g5 lh-16 ml-md">
      🟢 <b>hr-sw-*</b> applies shadow on <b>element hover</b> (self interaction)<br>
      🟢 Useful for direct user feedback on interactive elements (buttons, cards)<br>
      🔴 Overrides base shadow during hover — only one shadow value applies at a time
    </p>
  </div>

</div>
<div class="grid gap-x-lg gap-y-sm bg-white sw-md ra-md pa-md">

  <div class="g-12">
    <h3>Parent & Self Hover (.chr-parent .chr-sw-* .hr-sw-*)</h3>
  </div>

  <div class="g-6 flex-y gap-xxs">

    <span class="fs-14 fw-600 clr-g8">
      Parent Hover Area (hover this box)
    </span>

    <div class="chr-parent ba-xxs pa-sm h-100p">

      <p class="fs-12 clr-g6 mb-sm">
        chr-parent
      </p>

      <div class="grid gap-sm">

        <div class="g-3">
          <div class="pa-md bg-white ra-sm sw-xxs tr-3 chr-sw-xxl">
            sw-xxs <br> chr-sw-xxl
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm sw-xxs tr-3 chr-sw-xl">
            sw-xxs <br> chr-sw-xl
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm sw-xxs tr-3 chr-sw-md">
            sw-xxs <br> chr-sw-md
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm sw-xxs tr-3 chr-sw-0">
            sw-xxs <br> chr-sw-0
          </div>
        </div>

      </div>
    </div>

    <p class="g-12 fs-14 clr-g5 lh-16 ml-md">
      🟢 <b>chr-parent</b> enables group-level interaction (container hover)<br>
      🟢 <b>chr-sw-*</b> defines shadow for elements when the parent is hovered<br>
      🟢 Useful for coordinated UI behavior (cards, lists, grouped elements)<br>
      🟡 Best used to create a <b>unified hover experience</b> across multiple elements<br>
      🔴 Applies the same trigger to all matching children — individual control happens via <b>chr-*</b>
    </p>

  </div>

  <div class="g-6 flex-y gap-xxs">

    <span class="fs-14 fw-600 clr-g8">
      Parent sets, Self refines
    </span>

    <div class="chr-parent ba-xxs pa-sm">

      <p class="fs-12 clr-g6 mb-sm">
        chr-parent
      </p>

      <div class="grid gap-sm">

        <div class="g-3">
          <div class="pa-md bg-white ra-sm sw-xxs tr-3 chr-sw-xxl hr-sw-sm">
            sw-xxs <br> chr-sw-xxl <br> hr-sw-sm
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm sw-xxs tr-3 chr-sw-xxl hr-sw-md">
            sw-xxs <br> chr-sw-xxl <br> hr-sw-md
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm sw-xxs tr-3 chr-sw-md hr-sw-0">
            sw-xxs <br> chr-sw-md <br> hr-sw-0
          </div>
        </div>

        <div class="g-3">
          <div class="pa-md bg-white ra-sm sw-xxs tr-3 chr-sw-sm hr-sw-0">
            sw-xxs <br> chr-sw-sm <br> hr-sw-0
          </div>
        </div>

      </div>

    </div>

    <p class="fs-14 clr-g5 lh-16 ml-md">
      🟢 <b>chr-sw-*</b> defines shadow on <b>parent hover</b> (group baseline)<br>
      🟢 <b>hr-sw-*</b> defines shadow on <b>self hover</b> (element override)<br>
      🟡 Shadow is controlled through a single variable (--sw) — all interactions modify this <br>
      🟢 Both can work together — self hover <b>always overrides</b> parent hover when active<br>
      🔴 Shadow is a single-value property — <b>no stacking</b>, only one value is applied at a time
    </p>

  </div>

</div>
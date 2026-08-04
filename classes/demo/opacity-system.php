  <div class="grid gap-x-lg gap-y-sm bg-white bsw-md ra-md pa-md">

    <div class="g-12">
      <h3>Opacity Levels (.op-*)</h3>
    </div>

    <div class="g-6 flex-y gap-xxs bsw-md ra-md pa-md">
      <span class="fz-14 fw-600 clr-g8">Basic Opacity Levels</span>

      <div class="grid gap-sm">

        <div class="g-3 flex-y gap-xxs">
          <div class="pa-md bg-main clr-white ra-sm op-100">op-100</div>
        </div>

        <div class="g-3 flex-y gap-xxs">
          <div class="pa-md bg-main clr-white ra-sm op-70">op-70</div>
        </div>

        <div class="g-3 flex-y gap-xxs">
          <div class="pa-md bg-main clr-white ra-sm op-40">op-40</div>
        </div>

        <div class="g-3 flex-y gap-xxs">
          <div class="pa-md bg-main clr-white ra-sm op-10">op-10</div>
        </div>

      </div>

      <p class="fz-14 clr-g5 lh-16 ml-md">
        🟢 Fades entire element (bg + text + children)<br>
        🔴 Cannot isolate only background when using opacity on parent
      </p>

    </div>

    <div class="g-6 flex-y gap-xxs bsw-md ra-md pa-md">
      <span class="fz-14 fw-600 clr-g8">Text Only Opacity</span>

      <div class="grid gap-sm">

        <div class="g-3 flex-y gap-xxs">
          <div class="pa-md bg-sub ra-sm">
            <p class="clr-white op-100">op-100</p>
          </div>
        </div>

        <div class="g-3 flex-y gap-xxs">
          <div class="pa-md bg-sub ra-sm">
            <p class="op-70 clr-white">op-70</p>
          </div>
        </div>

        <div class="g-3 flex-y gap-xxs">
          <div class="pa-md bg-sub ra-sm">
            <p class="op-40 clr-white">op-40</p>
          </div>
        </div>

        <div class="g-3 flex-y gap-xxs">
          <div class="pa-md bg-sub ra-sm">
            <p class="op-10 clr-white">op-10</p>
          </div>
        </div>

      </div>

      <p class="fz-14 clr-g5 lh-16 ml-md">
        🟢 Apply opacity directly to text<br>
        🟡 Do not use on large text blocks — readability drops
      </p>

    </div>

    <div class="g-6 flex-y gap-xxs bsw-md ra-md pa-md">
      <span class="fz-14 fw-600 clr-g8">Image Opacity</span>

      <div class="grid gap-sm">

        <div class="g-6 flex-y gap-xxs">
          <div class="ra-sm of-hidden">
            <img src="img/800x500-1.jpg" class="img-max">
          </div>
        </div>

        <div class="g-6 flex-y gap-xxs">
          <div class="ra-sm of-hidden">
            <img src="img/800x500-1.jpg" class="img-max op-40">
          </div>
        </div>

      </div>

      <p class="fz-14 clr-g5 lh-16 ml-md">
        🟢 Apply opacity to image directly<br>
        🔴 Avoid applying opacity on parent unless whole card should fade
      </p>

    </div>

    <div class="g-6 flex-y gap-xxs bsw-md ra-md pa-md">
      <span class="fz-14 fw-600 clr-g8">Background Overlay (Isolated Opacity)</span>

      <div class="grid gap-sm">

        <div class="g-6 flex-y gap-xxs">
          <div class="pn-relative ra-sm of-hidden">

            <img src="img/800x500-1.jpg" class="img-max">

            <p class="pn-absolute inset-0 flex-y f-center f-middle clr-white">
              No overlay
            </p>

          </div>
        </div>

        <div class="g-6 flex-y gap-xxs">
          <div class="pn-relative ra-sm of-hidden">

            <img src="img/800x500-1.jpg" class="img-max">

            <div class="pn-absolute inset-0 bg-acnt op-40"></div>

            <p class="pn-absolute inset-0 flex-y f-center f-middle clr-white">
              bg-acnt + op-40
            </p>

          </div>
        </div>

      </div>

      <p class="fz-14 clr-g5 lh-16 ml-md">
        🔴 Do not use container opacity for this case <br>
        🟢 Applying opacity on container fades EVERYTHING<br>
        🟢 Use overlay layering for controlled opacity <br>
        🟢 Separate layers if only background should fade
      </p>

    </div>

  </div>

  <div class="grid gap-x-lg gap-y-sm bg-white bsw-md ra-md pa-md">

    <div class="g-12">
      <h3>Self Hover (.hs-op-*)</h3>
    </div>

    <div class="g-4 flex-y gap-xxs bsw-md ra-md pa-md">
      <span class="fz-14 fw-600 clr-g8">Basic Opacity Levels</span>

      <div class="grid gap-sm">

        <div class="g-6 flex-y gap-xxs">
          <div class="pa-md py-xl bg-main clr-white ra-sm ts-2 hs-op-30">
            Normal → hs-op-30
          </div>
        </div>

        <div class="g-6 flex-y gap-xxs">
          <div class="pa-md py-xl bg-main clr-white ra-sm op-70 ts-2 hs-op-100">
            op-70 → hs-op-100
          </div>
        </div>

      </div>

    </div>

    <div class="g-4 flex-y gap-xxs bsw-md ra-md pa-md">
      <span class="fz-14 fw-600 clr-g8">Text Only Opacity</span>

      <div class="grid gap-sm">

        <div class="g-6 flex-y gap-xxs">
          <div class="pa-md bg-sub ra-sm">
            <p class="fz-20 py-md clr-black ts-2 hs-op-30">op-100 → hs-op-30</p>
          </div>
        </div>

        <div class="g-6 flex-y gap-xxs">
          <div class="pa-md bg-sub ra-sm">
            <p class="fz-20 py-md clr-black op-30 ts-2 hs-op-100">
              op-30 → hs-op-100
            </p>
          </div>
        </div>

      </div>

    </div>

    <div class="g-4 flex-y gap-xxs bsw-md ra-md pa-md">
      <span class="fz-14 fw-600 clr-g8">Image Opacity</span>

      <div class="grid gap-sm">

        <div class="g-6 flex-y gap-xxs">
          <div class="ra-sm of-hidden">
            <img src="img/800x500-1.jpg" class="img-max ts-2 hs-op-30">
          </div>
        </div>

        <div class="g-6 flex-y gap-xxs">
          <div class="ra-sm of-hidden">
            <img src="img/800x500-1.jpg" class="img-max op-40 ts-2 hs-op-100">
          </div>
        </div>

      </div>

    </div>

    <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
      🟢 <b>hs-op-*</b> changes opacity <b>only when you hover that element</b><br>
      🟡 Works on anything: box(fades entire box), text(fades only text), image(fades only image)<br>
      🔴 Opacity affects the <b>whole element</b>(background + text + children will all fade together)<br>
      🔴 You cannot fade only background using this — use overlay for that
    </p>


  </div>

  <div class="grid gap-x-lg gap-y-xs bg-white bsw-md ra-md pa-md">

    <div class="g-12">
      <h3>Parent Hover (.chs-parent .chs-op-*)</h3>
    </div>

    <div class="g-12 flex-y gap-xxs">
      <span class="fz-14 fw-600 clr-g8">Background Overlay (Isolated Opacity)</span>

      <div class="grid gap-x-lg gap-y-sm">

        <div class="g-4 flex-y gap-xxs chs-parent">
          <div class="pn-relative ra-sm of-hidden">

            <img src="img/800x500-1.jpg" class="img-max">

            <div class="pn-absolute inset-0 bg-main ts-2 op-0 chs-op-40"></div>

            <p class="pn-absolute inset-0 flex-y f-center f-middle clr-white txt-center">
              bg-main + op-0 <br> chs-op-40
            </p>

          </div>
        </div>

        <div class="g-4 flex-y gap-xxs chs-parent">
          <div class="pn-relative ra-sm of-hidden">

            <img src="img/800x500-1.jpg" class="img-max">

            <div class="pn-absolute inset-0 bg-acnt ts-2 op-40 chs-op-80"></div>

            <p class="pn-absolute inset-0 flex-y f-center f-middle clr-white txt-center">
              bg-acnt + op-40 <br> chs-op-80
            </p>

          </div>
        </div>

        <div class="g-4 flex-y gap-xxs chs-parent">
          <div class="pn-relative ra-sm of-hidden">

            <img src="img/800x500-1.jpg" class="img-max">

            <div class="pn-absolute inset-0 bg-sub ts-2 op-10 chs-op-100"></div>

            <p class="pn-absolute inset-0 flex-y f-center f-middle clr-white txt-center">
              bg-sub + op-10 <br> chs-op-100
            </p>

          </div>
        </div>

        <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
          🟢 <b>chs-parent</b> lets you trigger hover by hovering the container instead of the element itself<br>
          🟢 <b>chs-op-*</b> changes opacity of inner elements when the parent is hovered<br>
          🟡 Needed when you cannot hover the actual element (like overlay placed above image)<br>
          🟡 Useful for layered UI such as image + overlay + text working together<br>
          🔴 <b>hs-op-*</b> does not work here because the overlay is not directly hoverable<br>
          🔴 Opacity affects the <b>entire overlay layer</b>, not parts inside it
        </p>

      </div>

    </div>

  </div>

  <div class="grid gap-x-lg gap-y-sm bg-white bsw-md ra-md pa-md">

    <div class="g-12">
      <h3>Parent & Self Hover (.chs-parent .chs-op-* .hs-op-*)</h3>
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

          <div class="g-4 pa-md bg-main clr-white ra-sm op-30 ts-2 chs-op-100">
            op-30 <br> chs-op-100
          </div>

          <div class="g-4 pa-md bg-main clr-white ra-sm op-50 ts-2 chs-op-100">
            op-50 <br> chs-op-100
          </div>

          <div class="g-4 pa-md bg-main clr-white ra-sm op-70 ts-2 chs-op-100">
            op-70 <br> chs-op-100
          </div>

        </div>

      </div>

    </div>

    <div class="g-6 flex-y gap-xxs">

      <span class="fz-14 fw-600 clr-g8">
        Parent + Self Interaction
      </span>

      <div class="chs-parent ba-xxs pa-sm">

        <p class="fz-12 clr-g6 mb-sm">
          chs-parent
        </p>

        <div class="grid gap-sm">

          <div class="g-4 pa-md bg-main clr-white ra-sm op-30 ts-2 chs-op-100 hs-op-10">
            op-30 <br> chs-op-100 <br> hs-op-10
          </div>

          <div class="g-4 pa-md bg-main clr-white ra-sm op-50 ts-2 chs-op-100 hs-op-60">
            op-50 <br> chs-op-100 <br> hs-op-60
          </div>

          <div class="g-4 pa-md bg-main clr-white ra-sm op-70 ts-2 chs-op-100 hs-op-90">
            op-70 <br> chs-op-100 <br> hs-op-90
          </div>

        </div>

      </div>

    </div>

  </div>
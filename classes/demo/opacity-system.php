  <div class="grid gap-x-lg gap-y-sm bg-white sw-md ra-md pa-md">

    <div class="g-12">
      <h3>Opacity Levels (.op-*)</h3>
    </div>

    <div class="g-6 flex-y gap-xxs sw-md ra-md pa-md">
      <span class="fs-14 fw-600 clr-g8">Basic Opacity Levels</span>

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

      <p class="fs-14 clr-g5 lh-16 ml-md">
        🟢 Fades entire element (bg + text + children)<br>
        🔴 Cannot isolate only background when using opacity on parent
      </p>

    </div>

    <div class="g-6 flex-y gap-xxs sw-md ra-md pa-md">
      <span class="fs-14 fw-600 clr-g8">Text Only Opacity</span>

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

      <p class="fs-14 clr-g5 lh-16 ml-md">
        🟢 Apply opacity directly to text<br>
        🟡 Do not use on large text blocks — readability drops
      </p>

    </div>

    <div class="g-6 flex-y gap-xxs sw-md ra-md pa-md">
      <span class="fs-14 fw-600 clr-g8">Image Opacity</span>

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

      <p class="fs-14 clr-g5 lh-16 ml-md">
        🟢 Apply opacity to image directly<br>
        🔴 Avoid applying opacity on parent unless whole card should fade
      </p>

    </div>

    <div class="g-6 flex-y gap-xxs sw-md ra-md pa-md">
      <span class="fs-14 fw-600 clr-g8">Background Overlay (Isolated Opacity)</span>

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

      <p class="fs-14 clr-g5 lh-16 ml-md">
        🔴 Do not use container opacity for this case <br>
        🟢 Applying opacity on container fades EVERYTHING<br>
        🟢 Use overlay layering for controlled opacity <br>
        🟢 Separate layers if only background should fade
      </p>

    </div>

  </div>

  <div class="grid gap-x-lg gap-y-sm bg-white sw-md ra-md pa-md">

    <div class="g-12">
      <h3>Self Hover (.hr-op-*)</h3>
    </div>

    <div class="g-4 flex-y gap-xxs sw-md ra-md pa-md">
      <span class="fs-14 fw-600 clr-g8">Basic Opacity Levels</span>

      <div class="grid gap-sm">

        <div class="g-6 flex-y gap-xxs">
          <div class="pa-md py-xl bg-main clr-white ra-sm tr-2 hr-op-30">
            Normal → hr-op-30
          </div>
        </div>

        <div class="g-6 flex-y gap-xxs">
          <div class="pa-md py-xl bg-main clr-white ra-sm op-70 tr-2 hr-op-100">
            op-70 → hr-op-100
          </div>
        </div>

      </div>

    </div>

    <div class="g-4 flex-y gap-xxs sw-md ra-md pa-md">
      <span class="fs-14 fw-600 clr-g8">Text Only Opacity</span>

      <div class="grid gap-sm">

        <div class="g-6 flex-y gap-xxs">
          <div class="pa-md bg-sub ra-sm">
            <p class="fs-20 py-md clr-black tr-2 hr-op-30">op-100 → hr-op-30</p>
          </div>
        </div>

        <div class="g-6 flex-y gap-xxs">
          <div class="pa-md bg-sub ra-sm">
            <p class="fs-20 py-md clr-black op-30 tr-2 hr-op-100">
              op-30 → hr-op-100
            </p>
          </div>
        </div>

      </div>

    </div>

    <div class="g-4 flex-y gap-xxs sw-md ra-md pa-md">
      <span class="fs-14 fw-600 clr-g8">Image Opacity</span>

      <div class="grid gap-sm">

        <div class="g-6 flex-y gap-xxs">
          <div class="ra-sm of-hidden">
            <img src="img/800x500-1.jpg" class="img-max tr-2 hr-op-30">
          </div>
        </div>

        <div class="g-6 flex-y gap-xxs">
          <div class="ra-sm of-hidden">
            <img src="img/800x500-1.jpg" class="img-max op-40 tr-2 hr-op-100">
          </div>
        </div>

      </div>

    </div>

    <p class="g-12 fs-14 clr-g5 lh-16 ml-md">
      🟢 <b>hr-op-*</b> changes opacity <b>only when you hover that element</b><br>
      🟡 Works on anything: box(fades entire box), text(fades only text), image(fades only image)<br>
      🔴 Opacity affects the <b>whole element</b>(background + text + children will all fade together)<br>
      🔴 You cannot fade only background using this — use overlay for that
    </p>


  </div>

  <div class="grid gap-x-lg gap-y-xs bg-white sw-md ra-md pa-md">

    <div class="g-12">
      <h3>Parent Hover (.chr-parent .chr-op-*)</h3>
    </div>

    <div class="g-12 flex-y gap-xxs">
      <span class="fs-14 fw-600 clr-g8">Background Overlay (Isolated Opacity)</span>

      <div class="grid gap-x-lg gap-y-sm">

        <div class="g-4 flex-y gap-xxs chr-parent">
          <div class="pn-relative ra-sm of-hidden">

            <img src="img/800x500-1.jpg" class="img-max">

            <div class="pn-absolute inset-0 bg-main tr-2 op-0 chr-op-40"></div>

            <p class="pn-absolute inset-0 flex-y f-center f-middle clr-white ta-center">
              bg-main + op-0 <br> chr-op-40
            </p>

          </div>
        </div>

        <div class="g-4 flex-y gap-xxs chr-parent">
          <div class="pn-relative ra-sm of-hidden">

            <img src="img/800x500-1.jpg" class="img-max">

            <div class="pn-absolute inset-0 bg-acnt tr-2 op-40 chr-op-80"></div>

            <p class="pn-absolute inset-0 flex-y f-center f-middle clr-white ta-center">
              bg-acnt + op-40 <br> chr-op-80
            </p>

          </div>
        </div>

        <div class="g-4 flex-y gap-xxs chr-parent">
          <div class="pn-relative ra-sm of-hidden">

            <img src="img/800x500-1.jpg" class="img-max">

            <div class="pn-absolute inset-0 bg-sub tr-2 op-10 chr-op-100"></div>

            <p class="pn-absolute inset-0 flex-y f-center f-middle clr-white ta-center">
              bg-sub + op-10 <br> chr-op-100
            </p>

          </div>
        </div>

        <p class="g-12 fs-14 clr-g5 lh-16 ml-md">
          🟢 <b>chr-parent</b> lets you trigger hover by hovering the container instead of the element itself<br>
          🟢 <b>chr-op-*</b> changes opacity of inner elements when the parent is hovered<br>
          🟡 Needed when you cannot hover the actual element (like overlay placed above image)<br>
          🟡 Useful for layered UI such as image + overlay + text working together<br>
          🔴 <b>hr-op-*</b> does not work here because the overlay is not directly hoverable<br>
          🔴 Opacity affects the <b>entire overlay layer</b>, not parts inside it
        </p>

      </div>

    </div>

  </div>

  <div class="grid gap-x-lg gap-y-sm bg-white sw-md ra-md pa-md">

    <div class="g-12">
      <h3>Parent & Self Hover (.chr-parent .chr-op-* .hr-op-*)</h3>
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

          <div class="g-4 pa-md bg-main clr-white ra-sm op-30 tr-2 chr-op-100">
            op-30 <br> chr-op-100
          </div>

          <div class="g-4 pa-md bg-main clr-white ra-sm op-50 tr-2 chr-op-100">
            op-50 <br> chr-op-100
          </div>

          <div class="g-4 pa-md bg-main clr-white ra-sm op-70 tr-2 chr-op-100">
            op-70 <br> chr-op-100
          </div>

        </div>

      </div>

    </div>

    <div class="g-6 flex-y gap-xxs">

      <span class="fs-14 fw-600 clr-g8">
        Parent + Self Interaction
      </span>

      <div class="chr-parent ba-xxs pa-sm">

        <p class="fs-12 clr-g6 mb-sm">
          chr-parent
        </p>

        <div class="grid gap-sm">

          <div class="g-4 pa-md bg-main clr-white ra-sm op-30 tr-2 chr-op-100 hr-op-10">
            op-30 <br> chr-op-100 <br> hr-op-10
          </div>

          <div class="g-4 pa-md bg-main clr-white ra-sm op-50 tr-2 chr-op-100 hr-op-60">
            op-50 <br> chr-op-100 <br> hr-op-60
          </div>

          <div class="g-4 pa-md bg-main clr-white ra-sm op-70 tr-2 chr-op-100 hr-op-90">
            op-70 <br> chr-op-100 <br> hr-op-90
          </div>

        </div>

      </div>

    </div>

  </div>
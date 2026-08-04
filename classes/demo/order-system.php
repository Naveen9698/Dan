<div class="grid gap-lg">

  <div class="g-12 grid gap-md bsw-sm bg-white pa-sm ra-sm">

    <h3 class="g-12">
      Visual Order vs HTML Order
    </h3>

    <div class="g-12 grid gap-md">

      <div class="g-6 g-mb-12 bsw-sm ra-sm pa-sm">

        <div class="flex-y gap-xs mb-sm">

          <div class="bg-main clr-white pa-sm ra-sm">
            Item A
          </div>

          <div class="bg-sub clr-white pa-sm ra-sm">
            Item B
          </div>

          <div class="bg-acnt clr-white pa-sm ra-sm">
            Item C
          </div>

        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">

          <b class="clr-g9">
            Default order
          </b>

          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div&gt;Item A&lt;/div&gt;
&lt;div&gt;Item B&lt;/div&gt;
&lt;div&gt;Item C&lt;/div&gt;</code></pre>

          <span class="fz-12">
            Visual order follows HTML order
          </span>

        </div>

      </div>

      <div class="g-6 g-mb-12 bsw-sm ra-sm pa-sm">

        <div class="flex-y gap-xs mb-sm">

          <div class="ord-3 bg-main clr-white pa-sm ra-sm">
            Item A (ord-3)
          </div>

          <div class="ord-1 bg-sub clr-white pa-sm ra-sm">
            Item B (ord-1)
          </div>

          <div class="ord-2 bg-acnt clr-white pa-sm ra-sm">
            Item C (ord-2)
          </div>

        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">

          <b class="clr-g9">
            Custom order
          </b>

          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ord-3"&gt;Item A&lt;/div&gt;
&lt;div class="ord-1"&gt;Item B&lt;/div&gt;
&lt;div class="ord-2"&gt;Item C&lt;/div&gt;</code></pre>

          <span class="fz-12">
            Visual order becomes B → C → A
          </span>

        </div>

      </div>

    </div>

  </div>

</div>

<div class="bsw-sm bg-white pa-sm ra-sm">

  <h3>
    Responsive Reordering Simulation
  </h3>

  <div class="w-100p bg-white ra-lg pa-sm flex-y gap-md">

    <div class="grid gap-lg">

      <!-- DESKTOP -->

      <div class="g-12 pn-relative bsw-md ra-lg pa-md flex-y gap-xs">

        <span class="fz-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-g6">
          desktop
        </span>

        <div class="flex-y gap-xs">

          <div class="bg-main-h pa-sm ra-xs">
            1. Image
          </div>

          <div class="bg-sub-h pa-sm ra-xs">
            2. Content
          </div>

          <div class="bg-acnt-h pa-sm ra-xs">
            3. CTA
          </div>

        </div>

      </div>

      <!-- TABLET -->

      <div class="g-8 pn-relative bsw-md ra-lg pa-md flex-y gap-xs">

        <span class="fz-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-g6">
          tablet
        </span>

        <div class="flex-y gap-xs">

          <div class="ord-2 bg-main-h pa-sm ra-xs">
            Image (ord-tb-2)<br>
            <span class="clr-white fz-12">↓ Moved Down</span>
          </div>

          <div class="ord-1 bg-sub-h pa-sm ra-xs">
            Content (ord-tb-1)<br>
            <span class="clr-white fz-12">↑ Moved Up</span>
          </div>

          <div class="ord-3 bg-acnt-h pa-sm ra-xs">
            CTA (ord-tb-3)<br>
            <span class="clr-white fz-12">= Not Moved</span>
          </div>

        </div>

      </div>

      <!-- MOBILE -->

      <div class="g-4 pn-relative bsw-md ra-lg pa-md flex-y gap-xs">

        <span class="fz-12 clr-white py-xxs px-xs ra-sm pn-absolute t--10px l--10px bg-g6">
          mobile
        </span>

        <div class="flex-y gap-xs">

          <div class="ord-3 bg-main-h pa-sm ra-xs">
            Image (ord-mb-3)<br>
            <span class="clr-white fz-12">↓ Moved Down</span>
          </div>

          <div class="ord-1 bg-sub-h pa-sm ra-xs">
            Content (ord-mb-1)<br>
            <span class="clr-white fz-12">= Not Moved</span>
          </div>

          <div class="ord-2 bg-acnt-h pa-sm ra-xs">
            CTA (ord-mb-2)<br>
            <span class="clr-white fz-12">↑ Moved Up</span>
          </div>

        </div>

      </div>

    </div>

  </div>

  <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">

    <b class="clr-g9">
      Responsive visual order
    </b>

    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ord-tb-2 ord-mb-3"&gt; Image &lt;/div&gt;
&lt;div class="ord-tb-1 ord-mb-1"&gt; Content &lt;/div&gt;
&lt;div class="ord-tb-3 ord-mb-2"&gt; CTA &lt;/div&gt;</code></pre>

    <p class="fz-14 clr-g5 lh-16 ml-md">
      🟢 This simulation displays desktop, tablet, and mobile results simultaneously for learning purposes.<br>
      🟢 In real usage, a single layout automatically changes order using ord-tb-* and ord-mb-* utilities.<br>
      🔴 Do not create separate layouts per breakpoint in production.
    </p>

  </div>

</div>
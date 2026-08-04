<div class="grid gap-lg">

  <div class="g-12 grid gap-md bsw-sm bg-white pa-sm ra-sm">

    <h3 class="g-12">
      Direct image vs Background image
    </h3>

    <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
      🟢 Direct images follow normal layout flow and preserve intrinsic size.<br>
      🟢 Background images are removed from flow and behave as visual layers.<br>
      🔴 Background images cannot influence layout size or spacing.<br>
      🟡 Use direct images when the image is part of the content, and background images when it's purely decorative.
    </p>

    <div class="g-12 grid gap-md">

      <div class="g-4 g-tb-6 g-mb-12">

        <img src="img/1000x15000.jpg" alt="">

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
          <b class="clr-g9">Direct image</b>
          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;img src="" alt=""&gt;</code></pre>
          <span class="fz-12">Natural flow · intrinsic size</span>
        </div>

      </div>

      <div class="g-8 g-tb-6 g-mb-12">

        <div class="ar-16x9">
          <img src="img/1000x15000.jpg" class="w-100p h-100p obj-cover" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
          <b class="clr-g9">Background like image</b>
          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ar-16x9"&gt;
  &lt;img class="w-100p h-100p obj-cover" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fz-12">Detached from flow · layered · clipped</span>
        </div>

      </div>

    </div>
  </div>

  <div class="g-12 grid gap-md bsw-sm bg-white pa-sm ra-sm">

    <h3 class="g-12">
      Anchoring controls focal point, not size
    </h3>

    <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
      🟡 Anchoring affects which part of the image is visible after cropping.<br>
      🟢 bg-* utilities control object-position inside the container.<br>
      🟢 Works only with object-fit: cover behavior.<br>
      🔴 Anchoring does not change layout or image size.<br>
      🟡 Visual exaggeration (height / offset) is used here for demonstration.
    </p>
    <div class="g-12 grid gap-md">

      <div class="g-4 g-tb-6 g-mb-12">

        <div class="ar-3x2 of-hidden pn-relative">
          <img src="img/1200x800.jpg" class="w-100p obj-cover obj-tl pn-absolute h-700px" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
          <b class="clr-g9">.obj-tl</b>
          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ar-3x2"&gt;
  &lt;img class="w-100p h-100p obj-cover obj-tl" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fz-12">Top · Left</span>
        </div>

      </div>

      <div class="g-4 g-tb-6 g-mb-12">

        <div class="ar-3x2 of-hidden pn-relative">
          <img src="img/1200x800.jpg" class="w-100p obj-cover obj-tc pn-absolute h-700px" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
          <b class="clr-g9">.obj-tc</b>
          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ar-3x2"&gt;
  &lt;img class="w-100p h-100p obj-cover obj-tc" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fz-12">Top</span>
        </div>

      </div>

      <div class="g-4 g-tb-6 g-mb-12">

        <div class="ar-3x2 of-hidden pn-relative">
          <img src="img/1200x800.jpg" class="w-100p obj-cover obj-tr pn-absolute h-700px" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
          <b class="clr-g9">.obj-tr</b>
          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ar-3x2"&gt;
  &lt;img class="w-100p h-100p obj-cover obj-tr" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fz-12">Top · Right</span>
        </div>

      </div>

      <div class="g-4 g-tb-6 g-mb-12">

        <div class="ar-3x2 of-hidden pn-relative">
          <img src="img/1200x800.jpg" class="w-100p obj-cover obj-cl pn-absolute h-700px t--50p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
          <b class="clr-g9">.obj-cl</b>
          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ar-3x2"&gt;
  &lt;img class="w-100p h-100p obj-cover obj-cl" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fz-12">Left</span>
        </div>

      </div>

      <div class="g-4 g-tb-6 g-mb-12">

        <div class="ar-3x2 of-hidden pn-relative">
          <img src="img/1200x800.jpg" class="w-100p obj-cover obj-cc pn-absolute h-700px t--50p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
          <b class="clr-g9">.obj-cc</b>
          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ar-3x2"&gt;
  &lt;img class="w-100p h-100p obj-cover obj-cc" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fz-12">object-position: center</span>
        </div>

      </div>

      <div class="g-4 g-tb-6 g-mb-12">

        <div class="ar-3x2 of-hidden pn-relative">
          <img src="img/1200x800.jpg" class="w-100p obj-cover obj-cr pn-absolute h-700px t--50p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
          <b class="clr-g9">.obj-cr</b>
          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ar-3x2"&gt;
  &lt;img class="w-100p h-100p obj-cover obj-cr" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fz-12">Right</span>
        </div>

      </div>

      <div class="g-4 g-tb-6 g-mb-12">

        <div class="ar-3x2 of-hidden pn-relative">
          <img src="img/1200x800.jpg" class="w-100p obj-cover obj-bl pn-absolute h-700px t--100p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
          <b class="clr-g9">.obj-bl</b>
          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ar-3x2"&gt;
  &lt;img class="w-100p h-100p obj-cover obj-bl" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fz-12">Bottom · Left</span>
        </div>

      </div>

      <div class="g-4 g-tb-6 g-mb-12">

        <div class="ar-3x2 of-hidden pn-relative">
          <img src="img/1200x800.jpg" class="w-100p obj-cover obj-bc pn-absolute h-700px t--100p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
          <b class="clr-g9">.obj-bc</b>
          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ar-3x2"&gt;
  &lt;img class="w-100p h-100p obj-cover obj-bc" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fz-12">Bottom</span>
        </div>

      </div>

      <div class="g-4 g-tb-6 g-mb-12">

        <div class="ar-3x2 of-hidden pn-relative">
          <img src="img/1200x800.jpg" class="w-100p obj-cover obj-br pn-absolute h-700px t--100p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
          <b class="clr-g9">.obj-br</b>
          <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ar-3x2"&gt;
  &lt;img class="w-100p h-100p obj-cover obj-br" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fz-12">Bottom · Right</span>
        </div>

      </div>

    </div>

  </div>

  <div class="g-12 grid gap-md bsw-sm bg-white pa-sm ra-sm">

    <h3 class="g-12">
      Layering
    </h3>

    <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
      🟢 Layering is controlled using pn-* (position) and z-* utilities.<br>
      🟢 enables stacking of image, overlay, and content.<br>
      🟢 Each layer should have explicit z-index for clarity.<br>
      🔴 Avoid relying on default stacking — it becomes unpredictable.<br>
      🟡 Overusing layers may increase complexity and maintenance cost.
    </p>

    <div class="g-3"></div>

    <div class="g-6 g-mb-12 bg-white">

      <div class="ar-16x9 pn-relative">

        <img src="img/3000x3000.jpg" class="w-100p h-100p obj-cover z-1">

        <div class="inset-0 pn-absolute z-2 bg-main op-40"></div>

        <div class="pn-relative z-3 clr-white bg-g7 pn-absolute b-50px w-fit pa-xs">
          <b>Layered content</b><br>
          <span class="fz-12">image · overlay · text</span>
        </div>

      </div>

      <div class="flex-y gap-xs pa-xs clr-g5 bsw-xs bg-g1">
        <b class="clr-g9">Explicit layering</b>

        <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>&lt;div class="ar-16x9 pn-relative"&gt;

  &lt;img class="w-100p h-100p obj-cover z-1" src="" alt=""&gt;

  &lt;div class="inset-0 pn-absolute z-2 bg-main op-40"&gt;&lt;/div&gt;

  &lt;div class="pn-relative z-3 clr-white bg-g7 pn-absolute b-50px w-fit pa-xs"&gt;
    Content
  &lt;/div&gt;

&lt;/div&gt;</code></pre>

        <span class="fz-12">
          Image · overlay · content stacking
        </span>
      </div>

    </div>


  </div>

</div>
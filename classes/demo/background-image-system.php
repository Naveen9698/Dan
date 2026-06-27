<div class="grid gap-lg">

  <!-- ROW 1 -->
  <div class="g-12 grid gap-md bg-g1 pa-sm ra-sm">

    <div class="g-12 fs-14 fw-600 clr-g9">
      1. Direct image vs Background image
      <p class="fs-14 clr-g5 lh-16 ml-md">
        🟢 Direct images follow normal layout flow and preserve intrinsic size.<br>
        🟢 Background images are removed from flow and behave as visual layers.<br>
        🔴 Background images cannot influence layout size or spacing.<br>
        🟡 Use direct images when the image is part of the content, and background images when it's purely decorative.
      </p>
    </div>

    <div class="g-12 grid gap-md">

      <!-- CARD 2 -->
      <div class="g-4 g-tb-6 g-mb-12">

        <img src="img/1000x15000.jpg" alt="">

        <div class="flex-y gap-xs pa-xs clr-g5 bg-white">
          <b class="clr-g9">Direct image</b>
          <pre><code>&lt;img src="" alt=""&gt;</code></pre>
          <span class="fs-12">Natural flow · intrinsic size</span>
        </div>

      </div>

      <!-- CARD 1 -->
      <div class="g-8 g-tb-6 g-mb-12">

        <div class="bg-container ar-16x9">
          <img src="img/1000x15000.jpg" class="bg-img" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bg-white">
          <b class="clr-g9">Background like image</b>
          <pre><code>&lt;div class="bg-container ar-16x9"&gt;
  &lt;img class="bg-img" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Detached from flow · layered · clipped</span>
        </div>

      </div>

    </div>
  </div>

  <div class="g-12 grid gap-md bg-g1 pa-sm ra-sm">

    <div class="g-12 fs-14 fw-600 clr-g9">
      2. Anchoring controls focal point, not size

      <p class="fs-14 clr-g5 lh-16 ml-md">
        🟡 Anchoring affects which part of the image is visible after cropping.<br>
        🟢 bg-* utilities control object-position inside the container.<br>
        🟢 Works only with object-fit: cover behavior.<br>
        🔴 Anchoring does not change layout or image size.<br>
        🟡 Visual exaggeration (height / offset) is used here for demonstration.
      </p>
    </div>

    <div class="g-12 grid gap-md">

      <!-- TL -->
      <div class="g-4 g-tb-6 g-mb-12">

        <div class="bg-container ar-3x2">
          <img src="img/1200x800.jpg" class="bg-img bg-tl h-700px" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bg-white">
          <b class="clr-g9">.bg-tl</b>
          <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-tl" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Top · Left</span>
        </div>

      </div>

      <!-- TOP -->
      <div class="g-4 g-tb-6 g-mb-12">

        <div class="bg-container ar-3x2">
          <img src="img/1200x800.jpg" class="bg-img bg-t h-700px" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bg-white">
          <b class="clr-g9">.bg-t</b>
          <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-t" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Top</span>
        </div>

      </div>

      <!-- TR -->
      <div class="g-4 g-tb-6 g-mb-12">

        <div class="bg-container ar-3x2">
          <img src="img/1200x800.jpg" class="bg-img bg-tr h-700px" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bg-white">
          <b class="clr-g9">.bg-tr</b>
          <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-tr" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Top · Right</span>
        </div>

      </div>

      <!-- LEFT -->
      <div class="g-4 g-tb-6 g-mb-12">

        <div class="bg-container ar-3x2">
          <img src="img/1200x800.jpg" class="bg-img bg-l h-700px t--50p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bg-white">
          <b class="clr-g9">.bg-l</b>
          <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-l" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Left</span>
        </div>

      </div>

      <!-- CENTER -->
      <div class="g-4 g-tb-6 g-mb-12">

        <div class="bg-container ar-3x2">
          <img src="img/1200x800.jpg" class="bg-img h-700px t--50p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bg-white">
          <b class="clr-g9">Center (default)</b>
          <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">object-position: center</span>
        </div>

      </div>

      <!-- RIGHT -->
      <div class="g-4 g-tb-6 g-mb-12">

        <div class="bg-container ar-3x2">
          <img src="img/1200x800.jpg" class="bg-img bg-r h-700px t--50p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bg-white">
          <b class="clr-g9">.bg-r</b>
          <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-r" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Right</span>
        </div>

      </div>

      <!-- BL -->
      <div class="g-4 g-tb-6 g-mb-12">

        <div class="bg-container ar-3x2">
          <img src="img/1200x800.jpg" class="bg-img bg-bl h-700px t--100p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bg-white">
          <b class="clr-g9">.bg-bl</b>
          <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-bl" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Bottom · Left</span>
        </div>

      </div>

      <!-- BOTTOM -->
      <div class="g-4 g-tb-6 g-mb-12">

        <div class="bg-container ar-3x2">
          <img src="img/1200x800.jpg" class="bg-img bg-b h-700px t--100p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bg-white">
          <b class="clr-g9">.bg-b</b>
          <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-b" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Bottom</span>
        </div>

      </div>

      <!-- BR -->
      <div class="g-4 g-tb-6 g-mb-12">

        <div class="bg-container ar-3x2">
          <img src="img/1200x800.jpg" class="bg-img bg-br h-700px t--100p" alt="">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5 bg-white">
          <b class="clr-g9">.bg-br</b>
          <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img bg-br" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Bottom · Right</span>
        </div>

      </div>

    </div>

  </div>

  <!-- ROW 3 (ASPECT RATIO) -->
  <div class="g-12 grid gap-md bg-g1 pa-sm ra-sm">

    <div class="g-12 fs-14 fw-600 clr-g9">
      3. Aspect Ratio

      <p class="fs-14 clr-g5 lh-16 ml-md">
        🟢 ar-* defines layout space before image loads.<br>
        🟢 Prevents layout shift and improves visual stability.<br>
        🟢 Works with bg-container to control media layout consistently.<br>
        🔴 Do not apply aspect-ratio directly on images.<br>
        🟡 Mismatched image proportions may result in cropping with object-fit: cover.
      </p>
    </div>

    <div class="g-12 grid gap-md">

      <!-- 1:1 -->
      <div class="g-3 g-tb-6 g-mb-12 bg-white">

        <div class="bg-container ar-1">
          <img src="img/800x1200.jpg" class="bg-img">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5">
          <b class="clr-g9">1 : 1</b>
          <pre><code>&lt;div class="bg-container ar-1"&gt;
  &lt;img class="bg-img" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Avatar / thumbnail</span>
        </div>

      </div>

      <!-- 4:3 -->
      <div class="g-3 g-tb-6 g-mb-12 bg-white">

        <div class="bg-container ar-4x3">
          <img src="img/800x1200.jpg" class="bg-img">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5">
          <b class="clr-g9">4 : 3</b>
          <pre><code>&lt;div class="bg-container ar-4x3"&gt;
  &lt;img class="bg-img" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Editorial image</span>
        </div>

      </div>

      <!-- 3:2 -->
      <div class="g-3 g-tb-6 g-mb-12 bg-white">

        <div class="bg-container ar-3x2">
          <img src="img/800x1200.jpg" class="bg-img">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5">
          <b class="clr-g9">3 : 2</b>
          <pre><code>&lt;div class="bg-container ar-3x2"&gt;
  &lt;img class="bg-img" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Cards / featured content</span>
        </div>

      </div>

      <!-- 16:9 -->
      <div class="g-3 g-tb-6 g-mb-12 bg-white">

        <div class="bg-container ar-16x9">
          <img src="img/800x1200.jpg" class="bg-img">
        </div>

        <div class="flex-y gap-xs pa-xs clr-g5">
          <b class="clr-g9">16 : 9</b>
          <pre><code>&lt;div class="bg-container ar-16x9"&gt;
  &lt;img class="bg-img" src="" alt=""&gt;
&lt;/div&gt;</code></pre>
          <span class="fs-12">Hero / media banner</span>
        </div>

      </div>

    </div>

  </div>

  <!-- ROW 4 (LAYERING) -->
  <div class="g-12 grid gap-md bg-g1 pa-sm ra-sm">

    <div class="g-12 fs-14 fw-600 clr-g9">
      4. Layering

      <p class="fs-14 clr-g5 lh-16 ml-md">
        🟢 Layering is controlled using pn-* (position) and z-* utilities.<br>
        🟢 bg-container enables stacking of image, overlay, and content.<br>
        🟢 Each layer should have explicit z-index for clarity.<br>
        🔴 Avoid relying on default stacking — it becomes unpredictable.<br>
        🟡 Overusing layers may increase complexity and maintenance cost.
      </p>
    </div>

    <div class="g-3"></div>

    <div class="g-6 g-mb-12 bg-white">

      <div class="bg-container ar-16x9 pn-relative">

        <img src="img/3000x3000.jpg" class="bg-img z-1">

        <!-- overlay (no utility exists yet) -->
        <div class="bg-overlay z-2 bg-g9 op-40"></div>

        <div class="pn-relative z-3 clr-white pa-xs">
          <b>Layered content</b><br>
          <span class="fs-12">image · overlay · text</span>
        </div>

      </div>

      <div class="flex-y gap-xs pa-xs clr-g5">
        <b class="clr-g9">Explicit layering</b>

        <pre><code>&lt;div class="bg-container ar-16x9 pn-relative"&gt;

  &lt;img class="bg-img z-1" src="" alt=""&gt;

  &lt;div class="bg-overlay z-2 bg-g9 op-40"&gt;&lt;/div&gt;

  &lt;div class="pn-relative z-3 clr-white pa-xs"&gt;
    Content
  &lt;/div&gt;

&lt;/div&gt;</code></pre>

        <span class="fs-12">
          Image · overlay · content stacking
        </span>
      </div>

    </div>


  </div>

</div>
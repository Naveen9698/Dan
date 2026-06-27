<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="typography-system">Typography System</h2>

<section class="px-md stack-y-sm">
  <h3>Variables</h3>

  <div class="d-cols">
    <pre><code>:root {<?php include 'root/typography.php'; ?>
  
  }</code></pre>
    <pre><code>@media (max-width: 990px) {
  :root {<?php include 'root-tb/typography.php'; ?>

  }
}</code></pre>
    <pre><code>@media (max-width: 770px) {
  :root {<?php include 'root-mb/typography.php'; ?>

  }
}</code></pre>
  </div>

  <h3>Font Sizes Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/typography-fs.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>fs-*</b> utilities provide a semantic font-size scale (xxs → xxl).<br>
    🟢 Sizes adapt across breakpoints using <b>responsive variable overrides</b>.<br>
    🟢 <b>fs-* numeric</b> classes are available for precise fallback usage.<br>
    🟡 Prefer semantic sizing for consistency across components.<br>
    🔴 Avoid fixed px usage — breaks responsive behavior and system consistency.
  </p>


  <h3>Fallback rem Values</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/typography.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Uses <b>rem units</b> so all sizes scale consistently across breakpoints.<br>
    🟡 Changing <b>html font-size</b> affects the entire typography fallback system — use with awareness.
  </p>

  <h3>Fallback rem Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/typography-fs1.php'; ?></code></pre>
    <pre><code>/* 10px / 8.75px  / 7.5px  */
/* 12px / 10.5px  / 9px    */
/* 14px / 12.25px / 10.5px */
/* 16px / 14px    / 12px   */
/* 18px / 15.75px / 13.5px */
/* 20px / 17.5px  / 15px   */
/* 22px / 19.25px / 16.5px */
/* 24px / 21px    / 18px   */
/* 26px / 22.75px / 19.5px */
/* 28px / 24.5px  / 21px   */
/* 30px / 26.25px / 22.5px */
/* 32px / 28px    / 24px   */
/* 34px / 29.75px / 25.5px */
/* 36px / 31.5px  / 27px   */
/* 38px / 33.25px / 28.5px */
/* 40px / 35px    / 30px   */
/* 42px / 36.75px / 31.5px */
/* 44px / 38.5px  / 33px   */</code></pre>
    <pre><code><?php include 'class/typography-fs2.php'; ?></code></pre>
    <pre><code>/* 46px / 40.25px / 34.5px */
/* 48px / 42px    / 36px   */
/* 50px / 43.75px / 37.5px */
/* 52px / 45.5px  / 39px   */
/* 54px / 47.25px / 40.5px */
/* 56px / 49px    / 42px   */
/* 58px / 50.75px / 43.5px */
/* 60px / 52.5px  / 45px   */
/* 62px / 54.25px / 46.5px */
/* 64px / 56px    / 48px   */
/* 66px / 57.75px / 49.5px */
/* 68px / 59.5px  / 51px   */
/* 70px / 61.25px / 52.5px */
/* 72px / 63px    / 54px   */
/* 74px / 64.75px / 55.5px */
/* 76px / 66.5px  / 57px   */
/* 78px / 68.25px / 58.5px */
/* 80px / 70px    / 60px   */</code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>fs-*</b> fallback utilities provide a consistent font-size scale (10px - 80px).<br>
    🟢 Values are mapped to <b>responsive size adjustments</b> (desktop → tablet → mobile).<br>
    🟡 Semantic (fs-sm) should be preferred over Numeric (fs-16).
  </p>

  <h3>Font Weight / Line Height Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/typography-fw.php'; ?></code></pre>
    <pre><code><?php include 'class/typography-lh.php'; ?></code></pre>

    <div class="w-auto bg-white ra-sm pa-sm flex-y gap-sm sw-xs">

      <!-- CONTROLS -->
      <div class="flex-x gap-md wrap">

        <div class="flex-y gap-xxs">
          <span class="fs-12 clr-g7">Font size (px)</span>
          <input id="fontSize" type="number" value="16" min="10" max="80"
            class="w-150px ba-0 sw-sm pa-xs ra-sm fs-14">
        </div>

        <div class="flex-y gap-xxs">
          <span class="fs-12 clr-g7">Line-height</span>
          <input id="lineHeight" type="number" step="0.1" value="1.2" min="1.0" max="2.0"
            class="w-150px ba-0 sw-sm pa-xs ra-sm fs-14">
        </div>

        <!-- ✅ NEW: FONT WEIGHT -->
        <div class="flex-y gap-xxs">
          <span class="fs-12 clr-g7">Font weight</span>
          <input id="fontWeight" type="number" step="100" value="400" min="100" max="900"
            class="w-150px ba-0 sw-sm pa-xs ra-sm fs-14">
        </div>

      </div>

      <!-- RESULT -->
      <div class="fs-14 clr-g9">
        Line height =
        <b><span id="lhPx">25.6</span>px</b>
        &nbsp;|&nbsp;
        Weight =
        <b><span id="fwVal">400</span></b>
      </div>

      <!-- PREVIEW -->
      <div id="preview" class="bg-g1 pa-sm ra-md">
        This is preview text showing how line-height and weight look.
      </div>

    </div>

    <script>
      const fontSizeInput = document.getElementById('fontSize');
      const lineHeightInput = document.getElementById('lineHeight');
      const fontWeightInput = document.getElementById('fontWeight');

      const result = document.getElementById('lhPx');
      const weightDisplay = document.getElementById('fwVal');
      const preview = document.getElementById('preview');

      function updateLineHeight() {

        const fontSize = parseFloat(fontSizeInput.value) || 0;
        const lineHeight = parseFloat(lineHeightInput.value) || 0;
        const fontWeight = parseInt(fontWeightInput.value) || 400;

        const pxValue = (fontSize * lineHeight).toFixed(1);

        result.textContent = pxValue;
        weightDisplay.textContent = fontWeight;

        // APPLY STYLES
        preview.style.fontSize = fontSize + 'px';
        preview.style.lineHeight = lineHeight;
        preview.style.fontWeight = fontWeight;

      }

      fontSizeInput.addEventListener('input', updateLineHeight);
      lineHeightInput.addEventListener('input', updateLineHeight);
      fontWeightInput.addEventListener('input', updateLineHeight);

      updateLineHeight();
    </script>

  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>fw-*</b> utilities define font weight consistently.<br>
    🟢 <b>lh-*</b> utilities control line-height using relative values.<br>
    🟢 Line-height scales automatically with font size.<br>
    🟡 Tight line-heights may reduce readability for larger text blocks.
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/typography-system.php'; ?>

</section>
<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="background-image-system">Image System</h2>
<section class="px-md stack-y-sm">

  <h3>Direct Image Prefixes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/background-img.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>img</b> elements participate in normal document flow.<br>
    🟢 Preserves <b>intrinsic aspect ratio</b> by default.<br>
    🟢 <b>max-width: 100%</b> prevents overflow without forcing scaling.<br>
    🟡 Use <b>.img-max</b> only when full-width scaling is intended.<br>
    🟡 <b>.img-h-max</b> requires a defined container height to behave predictably.
  </p>

  <h3>Background Like Image Prefixes / Classes</h3>


  <div class="d-cols">
    <pre><code><?php include 'engine/bg-img.php'; ?></code></pre>
    <pre><code><?php include 'class/background-img-intrinsic.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>bg-container</b> creates a positioned container for layered media.<br>
    🟢 <b>bg-img</b> removes the image from flow and fills the container.<br>
    🟢 Uses <b>object-fit: cover</b> for consistent cropping.<br>
    🔴 Do not apply sizing (<b>mw-*, ar-*</b>) on <b>bg-img</b> — apply on container.<br>
    🟡 Background-like images are visual layers, not layout elements. <br>
    🟢 <b>bg-overlay</b> provides a non-interactive visual layer above media.<br>
    🔴 Avoid using overlays for layout — they are purely visual layers.
  </p>

  <h3>Aspect Ratio Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/aspect-ratio.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>aspect ratio (ar-*)</b> defines layout space before image load.<br>
    🟢 Always applied to <b>containers</b>, not images.<br>
    🟢 Ensures predictable and stable layouts.<br>
    🟡 Without <b>ar-*</b>, images use natural sizing (<b>auto</b>).
  </p>

  <h3>Live Demo · Image System in Real Layouts</h3>

  <?php include 'demo/background-image-system.php'; ?>
</section>
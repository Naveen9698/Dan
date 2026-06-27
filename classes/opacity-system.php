<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="opacity-system">Opacity System</h2>

<section class="px-md stack-y-sm">

  <h3>Opacity Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/opacity.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Opacity affects the entire element including all children <br>
    🟢 Opacity transitions smoothly and pairs well with tr-* utilities <br>
    🔴 Cannot isolate only background, text, or image using opacity <br>
    🟢 Use layering (position + overlay) to control opacity precisely <br>
    🟡 Low opacity reduces readability, especially for text <br>
    🟡 Opacity affects visual stacking and contrast in layered UI <br>
    🔴 Very low opacity may reduce visibility of interactive elements
  </p>

  <h3>Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/opacity-hr.php'; ?></code></pre>
  </div>

  <h3>Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/opacity-hr.php'; ?></code></pre>
  </div>

  <h3>Child Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/opacity-chr.php'; ?></code></pre>
  </div>

  <h3>Child Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/opacity-chr.php'; ?></code></pre>
  </div>

  <div class="g-12 fs-14 clr-g5 lh-16 ml-md">
    🟢 Base (op-*) sets default opacity<br>
    🟢 Parent (chr-op-*) applies on parent hover<br>
    🟢 Self (hr-op-*) applies on hover and overrides parent<br>
    🟡 Last class wins when conflicts occur<br>
    🟡 Opacity transitions smoothly and pairs well with tr-* utilities <br>
    🔴 hr-op-* overrides chr-op-* when both are active <br>
    🔴 Opacity affects entire element including children<br>
    🔴 Values do not stack — only one opacity applies
  </div>

  <h3>Live Demo</h3>

  <?php include 'demo/opacity-system.php'; ?>

</section>
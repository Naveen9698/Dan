<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="border-system">Border System</h2>

<section class="px-md stack-y-sm">

  <h3>Variables</h3>

  <div class="d-cols">
    <pre><code>:root {<?php include 'root/border.php'; ?>

}</code></pre>
  </div>
  <h3>Border Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/border.php'; ?></code></pre>
  </div>

  <h3>Border Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/border-a.php'; ?></code></pre>
    <pre><code><?php include 'class/border-t.php'; ?></code></pre>
    <pre><code><?php include 'class/border-r.php'; ?></code></pre>
    <pre><code><?php include 'class/border-b.php'; ?></code></pre>
    <pre><code><?php include 'class/border-l.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>ba-*</b> utilities define border thickness using a semantic scale (xxs → xxl) for clarity and consistency.<br>
    🟢 Directional utilities (<b>bt-, br-, bb-, bl-</b>) control border sides individually. <br>
    🟢 Borders are inactive by default (<b>border-width: 0</b>) and apply only when explicitly used.<br>
    🟢 Uses <b>currentColor</b> to stay aligned with the color system.<br>
    🟡 Each side is controlled independently — no fallback or shared base is used <br>
    🔴 Border uses currentColor → inherits from text color (clr-*) <br>
    🔴 Border-width is not used in hover interactions as it does not transition smoothly<br>
    🔴 Avoid using <b>hr-*</b> or <b>chr-*</b> with border-width — results may feel abrupt or inconsistent
  </p>

  <h3>Helper Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/border-s.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>bs-*</b> defines border style independently from width<br>
    🟢 Works alongside <b>border</b> to form complete border structure<br>
    🟡 Border style changes are immediate and do not transition smoothly<br>
    🔴 Avoid decorative styles like groove or ridge — inconsistent across browsers
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/border-system.php'; ?>


</section>
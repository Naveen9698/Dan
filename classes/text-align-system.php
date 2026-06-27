<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="text-align-system">Text Align System</h2>

<section class="px-md stack-y-sm">

  <!-- ===== Variables ===== -->
  <h3>Text Align Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/ta-align.php'; ?></code></pre>
    <pre><code>@media (max-width: 990px) {
<?php include 'class-tb/ta-align.php'; ?>

}</code></pre>
    <pre><code>@media (max-width: 770px) {
<?php include 'class-mb/ta-align.php'; ?>

}</code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>ta-*</b> utilities control horizontal alignment of text content<br>
    🟢 Works on inline content inside block-level containers<br>
    🟡 Only visible when the container has available horizontal space <br>
    🔴 Does not affect layout structure (flex / grid alignment) <br>
    🟢 ta-start and ta-end use logical alignment based on writing direction <br>
    🟡 In left-to-right (LTR) layouts: start = left, end = right <br>
    🟡 In right-to-left (RTL) layouts: start = right, end = left <br>
    🟢 Prefer start/end for internationalized layouts instead of left/right <br>
    🟡 justify distributes text evenly across the line and works best with longer text blocks
  </p>

  <!-- ===== Live Demo ===== -->
  <h3>Live Demo</h3>

  <?php include 'demo/text-align-system.php'; ?>

</section>
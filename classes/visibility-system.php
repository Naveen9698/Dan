<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="visibility-system">Visibility System</h2>

<section class="px-md stack-y-sm">

  <h3>Visibility Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/visibility.php'; ?></code></pre>
    <pre><code>@media (max-width: 990px) {
<?php include 'class-tb/visibility.php'; ?>

}</code></pre>
    <pre><code>@media (max-width: 770px) {
<?php include 'class-mb/visibility.php'; ?>

}</code></pre>
  </div>

  <h3>Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/visibility-hr.php'; ?></code></pre>
  </div>

  <h3>Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/visibility-hr.php'; ?></code></pre>
  </div>

  <h3>Child Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/visibility-chr.php'; ?></code></pre>
  </div>

  <h3>Child Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/visibility-chr.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Base (vis-*) controls element visibility without affecting layout <br>
    🟢 Parent (chr-vis-*) applies on parent hover <br>
    🟢 Self (hr-vis-*) applies on hover and overrides parent <br>
    🟡 Last class wins when multiple utilities are used <br>
    🔴 visibility: hidden hides element but keeps layout space <br>
    🔴 visibility does not remove element from layout and may still affect interaction depending on context <br>
    🔴 Does not remove element from accessibility tree in all cases (use carefully) <br>
    🟢 visibility can be combined with opacity for smooth transitions
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/visibility-system.php'; ?>

</section>
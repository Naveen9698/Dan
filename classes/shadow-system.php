<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="shadow-system">Shadow System</h2>

<section class="px-md stack-y-sm">


  <h3>Variables</h3>

  <div class="d-cols">
    <pre><code>:root {<?php include 'root/shadow.php'; ?>

}</code></pre>
  </div>

  <h3>Shadow Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/shadow.php'; ?></code></pre>
  </div>

  <h3>Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/shadow-hr.php'; ?></code></pre>
  </div>

  <h3>Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/shadow-hr.php'; ?></code></pre>
  </div>

  <h3>Child Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/shadow-chr.php'; ?></code></pre>
  </div>

  <h3>Child Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/shadow-chr.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>sw-*</b> utilities apply elevation using box-shadow <br>
    🟡 Shadow is controlled as a single value — no directional or partial shadow control is provided <br>
    🟢 Scale ranges from subtle (<b>xxs</b>) to strong (<b>xxl</b>) <br>
    🔴 Shadows do not affect layout, size, or spacing <br>
    🟡 Use sparingly — excessive shadows create visual noise <br>
    🟡 Depth should reflect importance, not decoration
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/shadow-system.php'; ?>

</section>
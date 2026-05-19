<h2 class="d-h2 demo" id="width-system">Width System</h2>

<section class="d-section">

  <!-- ===== Variables & Prefix ===== -->
  <h3 class="d-h3 demo">Width Variables and prefixes</h3>

  <div class="d-cols">
    <pre><code>:root {<?php include 'root/width.php'; ?>

}</code></pre>

    <pre><code><?php include 'prefix/width.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Any <b>w-*</b> class activates the system automatically and sets element width using percentage values. <br>
    * Base utilities define width in steps of 10%, while <b>w-add-*</b> provides fine‑tuning in 1% increments.
  </p>

  <!-- ===== Utilities ===== -->
  <h3 class="d-h3 demo">Width Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/width.php'; ?></code></pre>
    <pre><code><?php include 'class/width-add.php'; ?></code></pre>
  </div>

  <!-- ===== Live Demo ===== -->
  <h3 class="d-h3 demo">Live Demo</h3>

  <?php include 'demo/width_system.php'; ?>
 
</section>
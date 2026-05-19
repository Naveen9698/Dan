<h2 class="d-h2 demo" id="max-width-system">Max Width System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Max Width Variables and prefixes</h3>

  <div class="d-cols">
    <pre><code>:root {
<?php include 'root/max-width.php'; ?>

}</code></pre>
    <pre><code><?php include 'prefix/max-width.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Any <b>mw-*</b> class activates the system automatically, ensuring elements never overflow smaller viewports. <br>
    * Max-width utilities use intentional base tokens with optional additive modifiers to support precise, responsive layouts.
  </p>

  <h3 class="d-h3 demo">Max Width Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/max-width1.php'; ?></code></pre>
    <pre><code><?php include 'class/max-width2.php'; ?></code></pre>
    <pre><code><?php include 'class/max-width3.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Max Width Modifiers</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/max-width-add-1.php'; ?></code></pre>
    <pre><code><?php include 'class/max-width-add-10.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Live Demo</h3>

  <?php include 'demo/max-width_system.php'; ?>
</section>
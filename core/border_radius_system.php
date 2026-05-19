<h2 class="d-h2 demo" id="border-radius-system">Border & Radius System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Prefixes</h3>

  <div class="d-cols">
    <pre><code><?php include 'prefix/border.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Border utilities provide a simple <b>1px, 2px, and 3px</b> thickness scale for consistent use across components. <br>
    * Borders are inactive by default <b>(border-width: 0)</b> and appear only when a width utility is explicitly applied. <br>
    * Border style is fixed to <b>solid</b> and color uses <b>currentColor</b>, keeping borders aligned with the <b>Color System</b> without extra utilities.
  </p>

  <h3 class="d-h3 demo">Border Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/border1.php'; ?></code></pre>
    <pre><code><?php include 'class/border2.php'; ?></code></pre>
    <pre><code><?php include 'class/border3.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Radius Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/radius.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Radius utilities provide a range of options for rounding corners, from subtle curves to fully rounded shapes.
  </p>

  <h3 class="d-h3 demo">Live Demo</h3>

  <?php include 'demo/border_radius_system.php'; ?>


</section>
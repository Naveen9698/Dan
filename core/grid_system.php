<h2 class="d-h2 demo" id="grid-system">Grid System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Prefixes</h3>

  <div class="d-cols">
    <pre><code><?php include 'prefix/grid.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * The grid uses a <b>12-column</b> layout by default, allowing for a wide range of column combinations and responsive design options. <br>
    * The grid does not provide spacing by default. Use spacing utilities <b>(gap-*, padding, margin)</b> explicitly. <br>
    * Row height is driven purely by content and is not constrained by the grid, providing flexibility for various design needs.
  </p>

  <h3 class="d-h3 demo">Grid Column Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/grid1.php'; ?></code></pre>
    <pre><code><?php include 'class/grid2.php'; ?></code></pre>
    <pre><code><?php include 'class/grid3.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Grid Row Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/grid_y1.php'; ?></code></pre>
    <pre><code><?php include 'class/grid_y2.php'; ?></code></pre>
    <pre><code><?php include 'class/grid_y3.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Live Responsive Demo</h3>

  <?php include 'demo/grid_system.php'; ?>

</section>
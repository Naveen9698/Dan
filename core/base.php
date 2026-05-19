<h2 class="d-h2 demo" id="base">Base</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Neutral Prefixes</h3>
  <div class="d-cols">
    <pre><code><?php include 'prefix/base.php'; ?></code></pre>
  </div>
  <p class="d-note">
    * This sets a global box-sizing of border-box <br>
    * This removes default margin and padding from all elements <br>
    * This applies a clean system font stack with a light background and dark text color
  </p>

  <h3 class="d-h3 demo">Display</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/display.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Display behavior is always explicit.<br>
    * <b>Flex / Grid</b> have their own Layout systems.<br>
    * <b>.dis-none</b> removes elements from layout entirely (no space reserved).<br>
    * Avoid mixing implicit component display styles with utilities.
  </p>

  <h3 class="d-h3 demo">Position</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/position.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Positioning is always explicit.<br>
    * Required for z‑index to take effect.<br>
    * Avoid implicit positioning through component styles.
  </p>

  <h3 class="d-h3 demo">Z-index</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/z-index.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Z-index controls stacking only.<br>
    * Requires explicit positioning (<b>.pn-*</b>).<br>
    * Keep stacking shallow to avoid escalation.
  </p>

  <h3 class="d-h3 demo">Overflow</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/overflow.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Overflow is controlled explicitly.<br>
    * Background containers typically combine <b>overflow: hidden</b> with aspect ratio.
  </p>

  <?php include 'demo/base.php'; ?>

</section>
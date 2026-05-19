<h2 class="d-h2 demo" id="flex-system">Flex System</h2>

<section class="d-section flex_system">
  <h3 class="d-h3 demo">Prefixes</h3>

  <div class="d-cols">
    <pre><code><?php include 'prefix/flex.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Elements with <b>flex-*</b> classes automatically become flex containers. <br>
    * Flex layouts <b>wrap</b> by default and align items to the <b>start</b>. <br>
    * <b>no-wrap</b> tells a flex container to keep all its children on a <b>single line</b>, no matter how narrow the container gets. <br>
    * <b>fill</b> makes a flex item grow to fill available space inside a flex container.
  </p>

  <h3 class="d-h3 demo">Flex Direction Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'prefix/flex_direction.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Flex direction defines the primary flow of items along the <b>x‑axis</b> or <b>y‑axis</b>.<br>
    * <b>flex-x</b> creates a <b>row layout</b> and <b>flex-y</b> creates a <b>column layout</b>.<br>
    * Responsive variants (<b>tb-*, mb-*</b>) override direction on smaller screens.
  </p>

  <h3 class="d-h3 demo">Flex (x-axis/align-items) Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex_x-axis1.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_x-axis2.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_x-axis3.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Align‑items controls how items align along the cross axis.<br>
    * In <b>flex-x</b>, this aligns items vertically.<br>
    * In <b>flex-y</b>, this aligns items horizontally.<br>
    * Stretch makes items fill the container along the cross axis.
    * Baseline aligns text baselines for a cohesive look.
  </p>

  <h3 class="d-h3 demo">Flex (y-axis/justiflex-y-content) Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex_y-axis1.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_y-axis2.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_y-axis3.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Justiflex-y‑content controls positioning and spacing along the main axis.<br>
    * top aligns items to the start, middle centers them, and bottom aligns to the end.<br>
    * spread distributes space between items, around places space around items, and even distributes space
    evenly.<br>
    * Avoid combining positional alignment and space distribution at the same breakpoint.
  </p>

  <h3 class="d-h3 demo">Flex (align-content) Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex_align-content1.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_align-content2.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_align-content3.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Align‑content controls how multiple flex lines are positioned when items wrap.<br>
    * This property applies only to wrapped layouts with more than one line.<br>
    * Align‑content has no effect on single‑line flex layouts. <br>
    * Use align‑content to control vertical spacing of rows in <b>flex-x</b> or horizontal spacing of
    columns in <b>flex-y</b>. <br>
    * Avoid using align‑content with align‑items to prevent conflicting alignment rules.
  </p>

  <h3 class="d-h3 demo">Live Demo</h3>

  <?php include 'demo/flex_system.php'; ?>

</section>
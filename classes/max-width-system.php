<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="max-width-system">Max Width System</h2>

<section class="px-md stack-y-sm">
  <h3>Max Width Variables and prefixes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {
<?php include 'root/max-width.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/max-width.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>mw-*</b> utilities define a responsive <b>max-width system</b>.<br>
    🟢 Uses CSS variables (<b>--mw-base + modifiers</b>) for flexible sizing.<br>
    🟢 Ensures elements never exceed <b>100%</b> of the viewport.<br>
    🟡 Any <b>mw-*</b> class activates the system — apply only when needed.
  </p>

  <h3>Max Width Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/max-width1.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/max-width2.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/max-width3.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>mw-10 → mw-1400</b> set base max-width values in px.<br>
    🔴 Avoid stacking multiple base classes — use only one <b>mw-*</b>.
  </p>

  <h3>Max Width Modifiers</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/max-width-add-1.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/max-width-add-10.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>mw-add-*</b> modifiers provide fine-tuning in smaller increments.<br>
    🟢 Combine base + modifiers for precise control.<br>
    🔴 Do not rely on max-width for layout positioning — use grid / flex instead.
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/max-width-system.php'; ?>
</section>
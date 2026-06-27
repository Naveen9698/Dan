<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="space-system">Space System</h2>

<section class="px-md stack-y-sm">
  <h3>Variables</h3>

  <div class="d-cols">
    <pre><code>:root {<?php include 'root/space.php'; ?>}

@media (max-width: 990px) {
  :root {<?php include 'root-tb/space.php'; ?>}
}

@media (max-width: 770px) {
  :root {<?php include 'root-mb/space.php'; ?>}
}</code></pre>
    <pre><code>:root {
<?php include 'root/space-tokens.php'; ?>
}</code></pre>
    <pre><code class="l--50px">
/* 8px  / 6px  / 4px  */
/* 16px / 12px / 8px  */
/* 24px / 18px / 12px */
/* 32px / 24px / 16px */
/* 48px / 36px / 24px */
/* 64px / 48px / 32px */
/* 96px / 72px / 48px */
</code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Spacing is based on a multiplier scale applied to <b>--space-unit</b> <br>
    🟢 Scale follows: ×1, ×2, ×3, ×4, ×6, ×8, ×12 <br>
    🟢 Each step (xxs → xxl) increases spacing consistently across the system
  </p>

  <h3>Padding Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/space-p1.php'; ?></code></pre>
    <pre><code><?php include 'class/space-p2.php'; ?></code></pre>
    <pre><code><?php include 'class/space-p3.php'; ?></code></pre>
    <pre><code><?php include 'class/space-p4.php'; ?></code></pre>
    <pre><code><?php include 'class/space-p5.php'; ?></code></pre>
    <pre><code><?php include 'class/space-p6.php'; ?></code></pre>
    <pre><code><?php include 'class/space-p7.php'; ?></code></pre>
  </div>

  <h3>Margin Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/space-m1.php'; ?></code></pre>
    <pre><code><?php include 'class/space-m2.php'; ?></code></pre>
    <pre><code><?php include 'class/space-m3.php'; ?></code></pre>
    <pre><code><?php include 'class/space-m4.php'; ?></code></pre>
    <pre><code><?php include 'class/space-m5.php'; ?></code></pre>
    <pre><code><?php include 'class/space-m6.php'; ?></code></pre>
    <pre><code><?php include 'class/space-m7.php'; ?></code></pre>
  </div>

  <h3>Gap Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/space-g1.php'; ?></code></pre>
    <pre><code><?php include 'class/space-g2.php'; ?></code></pre>
    <pre><code><?php include 'class/space-g3.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟡 gap utilities require flex or grid containers.
  </p>

  <h3>Stack Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/stack-y.php'; ?></code></pre>
    <pre><code><?php include 'class/stack-x.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Defines a scalable <b>spacing system</b> using CSS variables <br>
    🟢 Spacing values are derived from <b>--space-unit</b> and a fixed multiplier scale <br>
    🟡 Changing <b>--space-unit</b> updates all spacing globally — use with awareness <br>
    🟢 <b>Spacing scale</b> (xxs → xxl) ensures consistent spacing across components <br>
    🟢 <b>pa-*</b>, <b>ma-*</b>, <b>gap-*</b> and <b>stack-*</b> utilities apply spacing uniformly <br>
    🟢 Directional variants (<b>x, y, t, r, b, l</b>) control spacing on specific sides <br>
    🟢 <b>0 utilities</b> (pa-0, ma-0, gap-0, stack-0) reset spacing when needed <br>
    🟡 They act as strong overrides but still follow normal CSS specificity rules <br>
    🔴 May be overridden by more specific selectors or later declarations
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/space-system.php'; ?>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟡 In demos, spacing is calculated using inline calc(var(--space-unit) * n) with same relationship (×1, ×2, ×3, ×4, ×6, ×8, ×12) <br>
    🟢 In real usage, always rely on spacing tokens (--sp-*) for consistency <br>
    🟡 Demos override --space-unit locally to show Desktop, Tablet, and Mobile side-by-side <br>
    🟢 In actual usage, spacing is controlled centrally via :root and media queries
  </p>

</section>
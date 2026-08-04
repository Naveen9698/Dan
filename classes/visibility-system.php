<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="visibility-system">Visibility System</h2>

<section class="px-md stack-y-sm">

  <h3>Visibility Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/visibility.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 990px) {
<?php include 'class-tb/visibility.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 770px) {
<?php include 'class-mb/visibility.php'; ?>

}</code></pre>
  </div>

  <h3>Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/visibility-hs.php'; ?></code></pre>
  </div>

  <h3>Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/visibility-hs.php'; ?></code></pre>
  </div>

  <h3>Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/visibility-chs.php'; ?></code></pre>
  </div>

  <h3>Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/visibility-chs.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Base (vis-*) controls element visibility without affecting layout <br>
    🟢 Parent (cho:vis-*) applies on parent hover <br>
    🟢 Self (ho:vis-*) applies on hover and overrides parent <br>
    🟡 Last class wins when multiple utilities are used <br>
    🔴 visibility: hidden hides element but keeps layout space <br>
    🔴 visibility does not remove element from layout and may still affect interaction depending on context <br>
    🔴 Does not remove element from accessibility tree in all cases (use carefully) <br>
    🟢 visibility can be combined with opacity for smooth transitions
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/visibility-system.php'; ?>

</section>
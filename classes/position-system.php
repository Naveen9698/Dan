<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="position-system">Position System</h2>

<section class="px-md stack-y-sm">

  <h3>Position Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/position.php'; ?></code></pre>
    <pre><code>@media (max-width: 990px) {
<?php include 'class-tb/position.php'; ?>

}</code></pre>
    <pre><code>@media (max-width: 770px) {
<?php include 'class-mb/position.php'; ?>

}</code></pre>
  </div>

  <h3>Helper Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/position-intrinsic.php'; ?></code></pre>
  </div>


  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>pn-* utilities</b> (static, relative, absolute, fixed, sticky) define <b>positioning behavior</b>, not spacing.<br>
    🟢 Works by placing elements relative to a <b>parent container or viewport</b> using positioning context.<br>
    🟢 Supports alignment patterns (e.g., <b>pn-center</b>) for precise placement.<br>
    🟡 Requires proper setup (e.g., <b>pn-relative</b> parent for <b>pn-absolute</b>, or viewport for <b>pn-fixed</b>).<br>
    🟡 Responsive variants (<b>pn-tb-*</b>, <b>pn-mb-*</b>) allow position changes across devices.<br>
    🔴 Some position values (relative, absolute, fixed, sticky) can create stacking contexts <br>
    🔴 Sticky requires a scroll container and may not work inside overflow-hidden parents <br>
    🔴 Does not follow the spacing scale — avoid using positioning for layout spacing; use margin/padding instead.
  </p>


  <h3>Live Demo</h3>
    <?php include 'demo/position-system.php'; ?>

</section>
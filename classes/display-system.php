<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="display-system">Display System</h2>

<section class="px-md stack-y-sm">

  <h3>Display Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/display.php'; ?></code></pre>
    <pre><code>@media (max-width: 990px) {
<?php include 'class-tb/display.php'; ?>

}</code></pre>
    <pre><code>@media (max-width: 770px) {
<?php include 'class-mb/display.php'; ?>

}</code></pre>
  </div>

  <h3>Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/display-hr.php'; ?></code></pre>
  </div>

  <h3>Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/display-hr.php'; ?></code></pre>
  </div>

  <h3>Child Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/display-chr.php'; ?></code></pre>
  </div>

  <h3>Child Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/display-chr.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>dis-*</b> utilities define <b>how elements participate in layout</b> (block, inline, flex, grid).<br>
    🟢 Controls whether elements stack, flow inline, or create layout systems.<br>
    🟢 Used to activate layout engines like <b>flex</b> and <b>grid</b>.<br>
    🟡 Responsive variants (<b>dis-tb-*</b>, <b>dis-mb-*</b>) allow layout changes across devices.<br>
    🟡 <b>dis-none</b> removes elements completely (no space, no rendering).<br>
    🔴 Display cannot be animated using transition — use opacity/visibility for transitions <br>
    🟡 <b>dis-contents</b> removes the wrapper but keeps its children.<br>
    🟡 Use display changes for structural toggling (menus, dropdowns) <br>
    🟡 Avoid using display for visual transitions (use opacity/visibility instead) <br>
    🔴 Elements with display: none are not accessible (no keyboard or screen reader access) <br>
    🔴 Flex and Grid have their own layout systems — avoid mixing display with layout utilities unnecessarily. <br>
    🟢 Base (dis-*) sets default layout behavior <br>
    🟢 Parent (chr-dis-*) applies on parent hover <br>
    🟢 Self (hr-dis-*) applies on hover and overrides parent <br>
    🔴 hr-dis-* overrides chr-dis-* when both are active <br>
    🟡 Last class wins when multiple display utilities are used<br>
    🔴 Display values do not stack — only one display applies <br>
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/display-system.php'; ?>

</section>
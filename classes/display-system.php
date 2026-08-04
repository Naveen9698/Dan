<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="display-system">Display System</h2>

<section class="px-md stack-y-sm">

  <h3>Display Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/display.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 990px) {
<?php include 'class-tb/display.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 770px) {
<?php include 'class-mb/display.php'; ?>

}</code></pre>
  </div>

  <h3>Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/display-hs.php'; ?></code></pre>
  </div>

  <h3>Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/display-hs.php'; ?></code></pre>
  </div>

  <h3>Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/display-chs.php'; ?></code></pre>
  </div>

  <h3>Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/display-chs.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
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
    🟢 Parent (cho:dis-*) applies on parent hover <br>
    🟢 Self (ho:dis-*) applies on hover and overrides parent <br>
    🔴 ho:dis-* overrides cho:dis-* when both are active <br>
    🟡 Last class wins when multiple display utilities are used<br>
    🔴 Display values do not stack — only one display applies <br>
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/display-system.php'; ?>

</section>
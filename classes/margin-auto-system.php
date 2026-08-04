<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="margin-auto-system">Margin Auto System</h2>

<section class="px-md stack-y-sm">

  <h3>Margin Auto Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/ma-auto.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 990px) {
<?php include 'class-tb/ma-auto.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 770px) {
<?php include 'class-mb/ma-auto.php'; ?>

}</code></pre>

  </div>

  <h3>Helper Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/ma-auto-helper.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>ma-auto</b> utilities provide <b>layout alignment behavior</b>, not fixed spacing.<br>
    🟢 In ma-auto <b>"a"</b> represents <b>all sides</b> (top, right, bottom, left) <br>
    🟢 Works by consuming <b>available free space</b> in the layout.<br>
    🟡 Commonly used for <b>alignment</b> in flex and grid layouts.<br>
    🟡 Auto margins override fixed margin values on the same side <br>
    🟡 Only takes effect when free space exists (no effect in tightly packed layouts).<br>
    🟡 <b>mx-auto</b> centers elements horizontally when width is constrained.<br>
    🔴 Does not follow the spacing scale — avoid using for visual spacing. <br>
    🔴 May interfere with position: sticky and scrolling behavior <br>
    🟢 Base (of-*) controls how overflow is handled <br>
    🟡 Axis utilities (of-x-*, of-y-*) override specific directions <br>
    🟡 Last class wins when multiple overflow utilities are applied <br>
    🔴 Overflow values do not stack — only one applies per axis <br>
    🔴 Does not create scroll unless content exceeds container bounds <br>
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/margin-auto-system.php'; ?>

</section>
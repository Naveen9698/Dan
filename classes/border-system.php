<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="border-system">Border System</h2>

<section class="px-md stack-y-sm">

  <h3>Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/border.php'; ?>

}</code></pre>
  </div>
  <h3>Border Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/border.php'; ?></code></pre>
  </div>

  <h3>Border Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/border-a.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/border-t.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/border-r.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/border-b.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/border-l.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>ba-*</b> utilities define border thickness using a semantic scale (xxs → xxl) for clarity and consistency.<br>
    🟢 Directional utilities (<b>bt-, br-, bb-, bl-</b>) control border sides individually. <br>
    🟢 Borders are inactive by default (<b>border-width: 0</b>) and apply only when explicitly used.<br>
    🟢 Border uses currentColor by default <br>
    🟢 bclr-* can override border color independently which include <b>ho:bclr-*</b> and <b>cho:bclr-*</b> <br>
    🔴 clr-* affects text color while bclr-* affects only border color <br>
    🟡 Each side is controlled independently — no fallback or shared base is used <br>
    🔴 Border-width is not used in hover interactions as it does not transition smoothly<br>
    🔴 Avoid using <b>ho:*</b> or <b>cho:*</b> with border-width — results may feel abrupt or inconsistent
  </p>

  <h3>Helper Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/border-s.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>bstyle-*</b> defines border style independently from width<br>
    🟢 Works alongside <b>border</b> to form complete border structure<br>
    🟡 Border style changes are immediate and do not transition smoothly<br>
    🔴 Avoid decorative styles like groove or ridge — inconsistent across browsers
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/border-system.php'; ?>


</section>
<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="radius-system">Radius System</h2>

<section class="px-md stack-y-sm">

  <h3>Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/radius.php'; ?>

}</code></pre>
  </div>

  <h3>Helper Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-helper.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>ra-max</b> is a helper for fully rounded shapes (pills, circles)<br>
    🟡 It is <b>not included in hr/chr transitions</b> because it reaches the visual radius limit instantly<br>
    🟡 Each corner is controlled independently — no fallback or shared base is applied <br>
    🟡 Due to geometric limits, values beyond the element’s max radius are visually identical (no smooth interpolation)<br>
    🟡 Use <b>ra-xxl</b> as the largest animatable radius and <b>ra-max</b> only as a final/static shape<br><br>
  </p>

  <h3>Radius Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-a.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-tl.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-tr.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-br.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-bl.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>ra-*</b> defines corner rounding using a consistent scale (xxs → xxl)<br>
    🟢 Directional utilities (<b>rtl / rtr / rbl / rbr</b>) allow independent control of each corner<br>
    🟢 Radius uses CSS variables to keep values consistent and easily adjustable<br>
    🟢 <b>ho:ra-*</b> enables smooth radius transitions on self hover<br>
    🟢 <b>cho:ra-*</b> applies radius changes when the parent is hovered<br>
    🟡 Parent sets a base shape, self hover refines it per element<br>
    🟡 Use subtle radius changes for better visual transitions<br>
    🔴 Radius affects visual shape only and does not change layout<br>
    🔴 Avoid extreme jumps (e.g., <b>ra-0 → ra-max</b>) as they may feel abrupt
  </p>


  <h3>Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/radius-a-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/radius-tl-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/radius-tr-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/radius-br-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/radius-bl-hs.php'; ?></code></pre>
  </div>

  <h3>Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-a-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-tl-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-tr-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-br-hs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-bl-hs.php'; ?></code></pre>
  </div>

  <h3>Child Hover Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/radius-a-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/radius-tl-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/radius-tr-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/radius-br-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/radius-bl-chs.php'; ?></code></pre>
  </div>

  <h3>Child Hover Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-a-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-tl-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-tr-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-br-chs.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/radius-bl-chs.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Base utilities (ra-*) define default shape<br>
    🟢 Parent utilities (cho:*) apply on parent hover<br>
    🟢 Self utilities (ho:*) apply on element hover and override parent<br>
    🔴 Directional radius overrides full radius when both are applied<br>
    🟡 Last class wins when multiple utilities target the same property<br>
    🔴 Radius values do not stack or blend — only one applies at a time
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/radius-system.php'; ?>

</section>
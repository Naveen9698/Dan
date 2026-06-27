<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="radius-system">Radius System</h2>

<section class="px-md stack-y-sm">

  <h3>Variables</h3>

  <div class="d-cols">
    <pre><code>:root {<?php include 'root/radius.php'; ?>

}</code></pre>
  </div>

  <h3>Helper Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/radius-helper.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>ra-max</b> is a helper for fully rounded shapes (pills, circles)<br>
    🟡 It is <b>not included in hr/chr transitions</b> because it reaches the visual radius limit instantly<br>
    🟡 Each corner is controlled independently — no fallback or shared base is applied <br>
    🟡 Due to geometric limits, values beyond the element’s max radius are visually identical (no smooth interpolation)<br>
    🟡 Use <b>ra-xxl</b> as the largest animatable radius and <b>ra-max</b> only as a final/static shape<br><br>
  </p>

  <h3>Radius Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/radius-a.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-tl.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-tr.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-br.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-bl.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>ra-*</b> defines corner rounding using a consistent scale (xxs → xxl)<br>
    🟢 Directional utilities (<b>rtl / rtr / rbl / rbr</b>) allow independent control of each corner<br>
    🟢 Radius uses CSS variables to keep values consistent and easily adjustable<br>
    🟢 <b>hr-ra-*</b> enables smooth radius transitions on self hover<br>
    🟢 <b>chr-ra-*</b> applies radius changes when the parent is hovered<br>
    🟡 Parent sets a base shape, self hover refines it per element<br>
    🟡 Use subtle radius changes for better visual transitions<br>
    🔴 Radius affects visual shape only and does not change layout<br>
    🔴 Avoid extreme jumps (e.g., <b>ra-0 → ra-max</b>) as they may feel abrupt
  </p>


  <h3>Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/radius-a-hr.php'; ?></code></pre>
    <pre><code><?php include 'engine/radius-tl-hr.php'; ?></code></pre>
    <pre><code><?php include 'engine/radius-tr-hr.php'; ?></code></pre>
    <pre><code><?php include 'engine/radius-br-hr.php'; ?></code></pre>
    <pre><code><?php include 'engine/radius-bl-hr.php'; ?></code></pre>
  </div>

  <h3>Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/radius-a-hr.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-tl-hr.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-tr-hr.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-br-hr.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-bl-hr.php'; ?></code></pre>
  </div>

  <h3>Child Hover Engine</h3>

  <div class="d-cols">
    <pre><code><?php include 'engine/radius-a-chr.php'; ?></code></pre>
    <pre><code><?php include 'engine/radius-tl-chr.php'; ?></code></pre>
    <pre><code><?php include 'engine/radius-tr-chr.php'; ?></code></pre>
    <pre><code><?php include 'engine/radius-br-chr.php'; ?></code></pre>
    <pre><code><?php include 'engine/radius-bl-chr.php'; ?></code></pre>
  </div>

  <h3>Child Hover Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/radius-a-chr.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-tl-chr.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-tr-chr.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-br-chr.php'; ?></code></pre>
    <pre><code><?php include 'class/radius-bl-chr.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Base utilities (ra-*) define default shape<br>
    🟢 Parent utilities (chr-*) apply on parent hover<br>
    🟢 Self utilities (hr-*) apply on element hover and override parent<br>
    🔴 Directional radius overrides full radius when both are applied<br>
    🟡 Last class wins when multiple utilities target the same property<br>
    🔴 Radius values do not stack or blend — only one applies at a time
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/radius-system.php'; ?>

</section>
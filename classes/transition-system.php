<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="transition-system">Transition System</h2>

<section class="px-md stack-y-sm">

  <h3>Transition Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/transition.php'; ?></code></pre>
  </div>

  <h3>Transition Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transition-property.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transition-duration.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transition-ease.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/transition-delay.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 Any ts-* class activates transition automatically <br>
    🟢 ts-* (1–10) define duration <br>
    🟢 ts-* classes can be combined — last applied variable wins <br>
    🟢 Additional ts-* classes modify behavior (property, duration, ease, delay) <br>
    🟡 <b>ts-2 assumes:</b> <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- duration: 0.2s <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- easing: ease-in-out <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- property: all <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- delay: 0s <br>
    🟢 Supports both: <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- simple usage (ts-2) <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- advanced composition (ts-3 ts-ease ts-opacity ts-d4) <br>
    🔴 Avoid mixing too many transition targets (keep it focused) <br>
    🔴 Prefer ts-transform over ts-all for performance <br>
    🔴 Use transform system for movement instead of offset <br>
    🟢 Transition supports only visual properties <br>
    🟢 Focus on opacity, transform, color and effects <br>
    🔴 Layout properties are not supported (width, height, margin, padding) <br>
    🔴 Positional properties are not supported (top, left, right, bottom) <br>
    🔴 Avoid using transition for structural layout changes <br>
    🟡 System is intentionally restricted to ensure smooth performance and predictable UI behavior <br>
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/transition-system.php'; ?>



</section>
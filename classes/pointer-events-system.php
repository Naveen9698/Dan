<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="pointer-events-system">Pointer Events System</h2>

<section class="px-md stack-y-sm">

  <h3>Pointer Events Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/pointer-events.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>pointer-auto</b> enables normal mouse, touch and pointer interactions on an element<br>
    🟢 <b>pointer-none</b> disables mouse, touch and pointer interactions on an element<br>
    🟢 Useful for overlays, decorative elements, disabled UI states and click-through effects<br>
    🟡 Child elements inherit pointer behavior unless explicitly overridden<br>
    🟡 Elements with <b>pointer-none</b> remain visible but cannot receive clicks, hover events or touch interactions<br>
    🔴 Pointer Events utilities affect pointer interaction only and do not control keyboard focus or accessibility behavior
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/pointer-events-system.php'; ?>

</section>
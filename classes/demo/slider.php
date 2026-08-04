<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="z-index-system">Z-Index System</h2>

<section class="px-md stack-y-sm">

  <h3>z-index Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/z-index.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>z-*</b> utilities control <b>stacking order</b> (which element appears on top).<br>
    🟢 Higher values appear above lower values.<br>
    🟢 Works only on <b>positioned elements</b> (requires <b>pn-relative</b>, <b>pn-absolute</b>, etc.).<br>
    🔴 z-index only affects stacking contexts and overlapping elements. <br>
    🟡 Most common usage is with positioned elements (pn-relative, pn-absolute, pn-fixed, pn-sticky). <br>
    🔴 Avoid large arbitrary values — keep stacking levels limited and predictable.
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/z-index-system.php'; ?>

</section>
<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="aspect-ratio-system">Aspect Ratio System</h2>
<section class="px-md stack-y-sm">

  <h3>Aspect Ratio Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/aspect-ratio.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>aspect ratio (ar-*)</b> defines intrinsic layout space before image loads.<br>
    🔴 aspect-ratio must be applied to containers, not replaced elements (img, video, iframe) <br>
    🟢 child media typically requires w-100p and h-100p to fully fill the ratio container <br>
    🟡 Without <b>ar-*</b>, images use natural sizing (<b>auto</b>). <br>
    🟡 object-position (obj-*) can be used to control focal cropping with obj-cover
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/aspect-ratio-system.php'; ?>
</section>
<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="object-system">Object System</h2>
<section class="px-md stack-y-sm">

  <h3>Object Fit Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/obj-fit.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 controls how media is scaled and fitted inside its container <br>
    🟢 works with img, video, canvas, iframe <br>
    🟢 .obj-cover is ideal for background-like visuals <br>
    🟡 .obj-contain preserves full visibility but may introduce empty space
  </p>

  <h3>Object Position Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/obj-position.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 controls which part of the media (focal point) is visible inside the container <br>
    🟢 only noticeable when media is cropped (e.g., with .obj-cover) <br>
    🟢 pairs naturally with .obj-cover <br>
    🟡 think of it as controlling which part of the image stays visible
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/object-system.php'; ?>
</section>
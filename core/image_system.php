<h2 class="d-h2 demo" id="image-system">Image System</h2>
<section class="d-section">

  <h3 class="d-h3 demo">Direct Image Prefixes</h3>

  <div class="d-cols">
    <pre><code><?php include 'prefix/img.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Direct images participate in normal document flow.<br>
    * Intrinsic dimensions are preserved by default.<br>
    * <b>max-width: 100%</b> prevents overflow without forcing scaling.<br>
    * Use <b>.img-max</b> only for explicit max‑width intent. <br>
    * Height utilitie <b>.img-h-max</b> only behave predictably when container height is defined.
  </p>

  <h3 class="d-h3 demo">Background Like Image Prefixes / Classes</h3>


  <div class="d-cols">
    <pre><code><?php include 'prefix/img-bg.php'; ?></code></pre>
    <pre><code><?php include 'class/img-bg.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Set <b>Mx-Width (.mw-*)</b> and <b>aspect ratio (.ar-*)</b> on <b>.bg-container</b>. <br>
    * <b>Don't</b> set them on <b>.bg-img</b> <br>
    * Background‑like images are removed from normal document flow and layered visually.<br>
    * The container defines size, clipping, radius, and aspect ratio — not the image.<br>
    * Images always fill the container using <b>object-fit: cover</b>.<br>
    * <b>object-position</b> controls the visible focal area when cropping occurs.<br>
    * Anchoring utilities (<b>.bg-*</b>) select which part of the image is preserved.<br>
    * Use <b>.bg-overlay</b> only for non-interactive visual layers.
  </p>

  <h3 class="d-h3 demo">Aspect Ratio Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/aspect-ratio.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Aspect ratio applies to containers, never to images directly.<br>
    * Aspect ratio defines the layout space before media loads.<br>
    * Images adapt to the container’s ratio using <b>object-fit</b>.<br>
    * Absence of an <b>.ar-*</b> class implies <b>natural sizing(aspect-ratio: auto;)</b>.<br>
    * <b>.ar-auto</b> is provided as an explicit reset.
  </p>

  <h3 class="d-h3 demo">Live Demo · Image System in Real Layouts</h3>

  <?php include 'demo/image_system.php'; ?>
</section>
<h2 class="d-h2 demo" id="text-align-system">Text Align System</h2>

<section class="d-section">

  <!-- ===== Variables ===== -->
  <h3 class="d-h3 demo">Text Align Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/ta-align.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Text alignment utilities control horizontal alignment of inline content inside a container. <br>
    * They do not affect layout structure, only text flow.
  </p>
  
  <!-- ===== Live Demo ===== -->
  <h3 class="d-h3 demo">Live Demo</h3>

  <div class="grid gap-lg bg-g1 ra-lg p-lg">

    <!-- LEFT -->
    <div class="dp-4 tb-12 flex-y gap-xs">
      <span class="fs-13px clr-g7">ta-left</span>
      <div class="p-sm bg-white ra-sm">
        <p class="fs-14px lh-14">
          This is a sample paragraph to demonstrate how text aligns within a container.
        </p>
      </div>
    </div>

    <!-- CENTER -->
    <div class="dp-4 tb-12 flex-y gap-xs">
      <span class="fs-13px clr-g7">ta-center</span>
      <div class="p-sm bg-white ra-sm">
        <p class="fs-14px lh-14 ta-center">
          This is a sample paragraph to demonstrate how text aligns within a container.
        </p>
      </div>
    </div>

    <!-- RIGHT -->
    <div class="dp-4 tb-12 flex-y gap-xs">
      <span class="fs-13px clr-g7">ta-right</span>
      <div class="p-sm bg-white ra-sm">
        <p class="fs-14px lh-14 ta-right">
          This is a sample paragraph to demonstrate how text aligns within a container.
        </p>
      </div>
    </div>

  </div>

</section>
<h2 class="d-h2 demo" id="width-system">Width System</h2>

<section class="d-section">

  <!-- ===== Variables & Prefix ===== -->
  <h3 class="d-h3 demo">Width Variables and prefixes</h3>

  <div class="d-cols">
    <pre><code>:root {
<?php include 'root/width.php'; ?>

}</code></pre>

    <pre><code><?php include 'prefix/width.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Any <b>w-*</b> class activates the system automatically and sets element width using percentage values. <br>
    * Base utilities define width in steps of 10%, while <b>w-add-*</b> provides fine‑tuning in 1% increments.
  </p>

  <!-- ===== Utilities ===== -->
  <h3 class="d-h3 demo">Width Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/width.php'; ?></code></pre>
    <pre><code><?php include 'class/width-add.php'; ?></code></pre>
  </div>

  <!-- ===== Live Demo ===== -->
  <h3 class="d-h3 demo">Live Demo</h3>

  <style>
    .width_system-demo {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .width_system-track {
      position: relative;
      padding: 6px;
      border-radius: 12px;
      background: linear-gradient(#f9fafb, #f3f4f6);
      border: 1px solid #e5e7eb;
    }

    .width_system-bar {
      height: 40px;
      border-radius: 8px 0 0 8px;
      box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, .7),
        0 6px 18px rgba(0, 0, 0, .08);

      background:
        linear-gradient(to right,

          /* BASE */
          hsl(221 83% 50%) 0%,
          hsl(221 83% 50%) var(--base-end),

          /* ADD */
          hsl(142 76% 40%) var(--base-end),
          hsl(142 76% 40%) var(--total-end),

          /* EMPTY SPACE */
          transparent var(--total-end),
          transparent 100%);
    }

    .width_system-label {
      position: absolute;
      top: 17px;
      left: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 15px;
      font-weight: 600;
      color: #ffffff;
    }

    .width_system-result {
      position: absolute;
      top: 17px;
      font-size: 14px;
      font-weight: 500;
      color: #262626;
    }

    .dot {
      width: 14px;
      height: 14px;
      border-radius: 50%;
      border: 2px solid #fff;
    }

    .dot.base {
      background: hsl(221 83% 50%);
    }

    .dot.plus {
      background: hsl(142 76% 40%);
    }
  </style>

  <div class="width_system-demo">

    <!-- BASE -->
    <div class="width_system-track" style="--base-end:40%; --total-end:40%;">
      <div class="width_system-bar w-100"></div>

      <div class="width_system-label">
        <span class="dot base"></span> w‑40
      </div>

      <span class="width_system-result" style="left: 41%;">→ 40%</span>
    </div>


    <!-- +5 -->
    <div class="width_system-track" style="--base-end:40%; --total-end:45%;">
      <div class="width_system-bar w-100"></div>

      <div class="width_system-label">
        <span class="dot base"></span> w‑40
        <span class="dot plus"></span> w‑add‑5
      </div>

      <span class="width_system-result" style="left: 46%;">→ 45%</span>
    </div>


    <!-- +9 -->
    <div class="width_system-track" style="--base-end:40%; --total-end:49%;">
      <div class="width_system-bar w-100"></div>

      <div class="width_system-label">
        <span class="dot base"></span> w‑40
        <span class="dot plus"></span> w‑add‑9
      </div>

      <span class="width_system-result" style="left: 50%;">→ 49%</span>
    </div>

  </div>

  <p class="note">
    * <span style="font-weight:600; color:hsl(221 83% 50%)">w‑40</span> sets width to 40%.<br>
    * <span style="font-weight:600; color:hsl(142 76% 40%)">w‑add‑5</span> increases it to 45%.<br>
    * This system gives 1% precision without creating 100 separate classes.
  </p>
</section>
<h2 class="d-h2 demo" id="max-width-system">Max Width System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Max Width Variables and prefixes</h3>

  <div class="d-cols">
    <pre><code>:root {
<?php include 'root/max-width.php'; ?>

}</code></pre>
    <pre><code><?php include 'prefix/max-width.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Any <b>mw-*</b> class activates the system automatically, ensuring elements never overflow smaller viewports. <br>
    * Max-width utilities use intentional base tokens with optional additive modifiers to support precise, responsive layouts.
  </p>

  <h3 class="d-h3 demo">Max Width Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/max-width1.php'; ?></code></pre>
    <pre><code><?php include 'class/max-width2.php'; ?></code></pre>
    <pre><code><?php include 'class/max-width3.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Max Width Modifiers</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/max-width-add-1.php'; ?></code></pre>
    <pre><code><?php include 'class/max-width-add-10.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Live Demo</h3>
  <style>
    .max-width_system-demo {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .max-width_system-track {
      position: relative;
      padding: 6px;
      border-radius: 12px;
      background: linear-gradient(#f9fafb, #f3f4f6);
      border: 1px solid #e5e7eb;
    }

    .max-width_system-block {
      height: 40px;
      border-radius: 8px 0 0 8px;
      box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, .7),
        0 6px 18px rgba(0, 0, 0, .08);
      background:
        linear-gradient(to right,
          hsl(221 83% 50%) 0px,
          hsl(221 83% 50%) 500px,
          hsl(142 76% 40%) 500px,
          hsl(142 76% 40%) 550px,
          hsl(0 84% 60%) 550px,
          hsl(0 84% 60%) 555px);
    }

    .max-width_system-label {
      margin-top: -29px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 15px;
      font-weight: 600;
      color: #ffffff;
      position: absolute;
      margin-left: 20px;
    }

    .max-width_system-total-555 {
      color: #262626;
      font-weight: 500;
      position: absolute;
      left: 575px;
      top: 9px;
    }

    .max-width_system-total-550 {
      color: #262626;
      font-weight: 500;
      position: absolute;
      left: 570px;
      top: 9px;
    }

    .max-width_system-total-500 {
      color: #262626;
      font-weight: 500;
      position: absolute;
      left: 520px;
      top: 9px;
    }

    .dot {
      width: 15px;
      height: 15px;
      border-radius: 50%;
      border: 2px solid #fff;
    }

    .max-width_system-demo .dot.base {
      background: hsl(221 83% 50%);
    }

    .max-width_system-demo .dot.plus {
      background: hsl(142 76% 40%);
    }

    .max-width_system-demo .dot.fine {
      background: hsl(0 84% 60%);
    }
  </style>
  <div class="max-width_system-demo">

    <!-- Base -->
    <div class="max-width_system-track">
      <div class="max-width_system-block mw-500"></div>
      <div class="max-width_system-label">
        <span class="dot base"></span> mw‑500
      </div>
      <span class="max-width_system-total-500">→ max 500px</span>
    </div>

    <!-- +50 -->
    <div class="max-width_system-track">
      <div class="max-width_system-block mw-500 mw-add-50"></div>
      <div class="max-width_system-label">
        <span class="dot base"></span> mw‑500
        <span class="dot plus"></span> mw‑add‑50
      </div>
      <span class="max-width_system-total-550">→ max 550px</span>
    </div>

    <!-- +50 +5 -->
    <div class="max-width_system-track">
      <div class="max-width_system-block mw-500 mw-add-50 mw-add-5"></div>
      <div class="max-width_system-label">
        <span class="dot base"></span> mw‑500
        <span class="dot plus"></span> mw‑add‑50
        <span class="dot fine"></span> mw‑add‑5
      </div>
      <span class="max-width_system-total-555">→ max 555px</span>
    </div>

  </div>

  <p class="note">
    * This content can grow, but stops at <span style="font-weight: 600; color: hsl(221 83% 50%);">500px</span>.
    <br>
    * The <span style="font-weight: 600; color: hsl(142 76% 40%);">mw-add-50</span> modifier adds 50px to the
    base, which expand up to <span style="font-weight: 600; color: hsl(142 76% 40%);">550px</span>. <br>
    * Stacking another <span style="font-weight: 600; color: hsl(0 84% 60%);">mw-add-5</span> adds <span
      style="font-weight: 600; color: hsl(0 84% 60%);">5px</span> more, so this block can grow up to
    <span style="font-weight: 600; color: hsl(0 84% 60%);">555px</span>.
  </p>
</section>
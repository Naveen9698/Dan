<h2 class="d-h2 demo" id="typography-system">Typography System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Variables</h3>

  <div class="d-cols">
    <pre><code><?php include 'prefix/typography.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * This typography system is based on <b>HTML</b> that define the font sizes.<br>
    * Font weights is static, like 400 for regular text and 600 for headings and emphasized text. <br>
    * line heights scaling automatically with font size.
  </p>

  <h3 class="d-h3 demo">Font Sizes Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/typography_fs1.php'; ?></code></pre>
    <pre><code><?php include 'class/typography_fs2.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Font Weight / Line Height Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/typography_fw.php'; ?></code></pre>
    <pre><code><?php include 'class/typography_lh.php'; ?></code></pre>
    <style>
      .line_height-calculator {
        max-width: 720px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 20px;
      }

      .line_height-controls {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
      }

      .line_height-controls label {
        font-size: 12px;
        color: #374151;
        display: flex;
        flex-direction: column;
        gap: 6px;
      }

      .line_height-controls input {
        width: 140px;
        padding: 8px 10px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 14px;
      }

      .line_height-result {
        font-size: 14px;
        color: #111827;
      }

      .line_height-preview {
        background: #f9fafb;
        border-radius: 12px;
        padding: 16px;
        border-left: 4px solid hsl(245, 100%, 68%);
      }
    </style>
    <div class="line_height-calculator">
      <div class="line_height-controls">
        <label>
          Font size (px)
          <input type="number" id="fontSize" value="16" />
        </label>

        <label>
          Line‑height
          <input type="number" id="lineHeight" step="0.1" value="1.2" />
        </label>
      </div>

      <div class="line_height-result">
        Line height =
        <strong><span id="lhPx">25.6</span>px</strong>
      </div>
    </div>
    <script>
      const fontSizeInput = document.getElementById('fontSize');
      const lineHeightInput = document.getElementById('lineHeight');
      const result = document.getElementById('lhPx');
      const preview = document.getElementById('preview');

      function updateLineHeight() {
        const fontSize = parseFloat(fontSizeInput.value) || 0;
        const lineHeight = parseFloat(lineHeightInput.value) || 0;
        const pxValue = (fontSize * lineHeight).toFixed(1);

        result.textContent = pxValue;
        preview.style.fontSize = fontSize + 'px';
        preview.style.lineHeight = lineHeight;
      }

      fontSizeInput.addEventListener('input', updateLineHeight);
      lineHeightInput.addEventListener('input', updateLineHeight);

      updateLineHeight();
    </script>
  </div>
  <p class="d-note">
    * Line-height values like 1.2 mean “1.2 × the font size”. <br>
    * At 16px text the line height becomes 19.2px. <br>
    * Scaling automatically with font size.
  </p>
  <h3 class="d-h3 demo">Live Demo</h3>

  <?php include 'demo/typography_system.php'; ?>

</section>
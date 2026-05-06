<h2 class="d-h2 demo" id="typography-system">Typography System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Variables</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/typography_media.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * This typography system is based on <b>HTML</b> that define the font sizes.<br>
    * Font weights is static, like 400 for regular text and 600 for headings and emphasized text. <br>
    * line heights scaling automatically with font size, such as 1.2 or 1.5, which means “1.2 × the font size” or “1.5 × the font size”.
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
    * Line-height values like 1.2 mean “1.2 × the font size”, so at 16px text the line height becomes 19.2px, scaling automatically with font size.
  </p>
  <h3 class="d-h3 demo">Live Demo</h3>
  <style>
    .typography_system-demo {
      display: grid;
      gap: 20px;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
    }

    .typography_system-label {
      font-size: 12px;
      color: #6b7280;
    }
  </style>

  <div style="display: flex; gap: 20px; flex-wrap: wrap;">
    <div style="width: 100%;">
      <div class="typography_system-demo" style="display: flex;">

        <div>
          <div class="typography_system-label">fs-(48px/42px/36px) · fw-700 · lh-12</div>
          <p class="fs-48px fw-700 lh-12">Display Heading</p>
          <p class="fs-42px fw-700 lh-12">Display Heading</p>
          <p class="fs-36px fw-700 lh-12">Display Heading</p>
        </div>

        <div>
          <div class="typography_system-label">fs-(32px/28px/24px) · fw-600 · lh-13</div>
          <p class="fs-32px fw-600 lh-13">Section Heading</p>
          <p class="fs-28px fw-600 lh-13">Section Heading</p>
          <p class="fs-24px fw-600 lh-13">Section Heading</p>
        </div>

        <div>
          <div class="typography_system-label">fs-(20px/17px/15px) · fw-500 · lh-14</div>
          <p class="fs-20px fw-500 lh-14">Subheading</p>
          <p class="fs-17px fw-500 lh-14">Subheading</p>
          <p class="fs-15px fw-500 lh-14">Subheading</p>
        </div>

        <div>
          <div class="typography_system-label">fs-(16px/14px/12px) · fw-400 · lh-12</div>
          <p class="fs-16px fw-400 lh-12">Body text uses a comfortable line-height for long reading.</p>
          <p class="fs-14px fw-400 lh-12">Body text uses a comfortable line-height for long reading.</p>
          <p class="fs-12px fw-400 lh-12">Body text uses a comfortable line-height for long reading.</p>
        </div>

      </div>
    </div>
    <div style="width: 100%;">
      <div class="typography_system-demo" style="gap:20px;">
        <div class="typography_system-label">Desktop</div>
        <div class="fs-48px fw-700 lh-12">
          Display Heading
        </div>

        <div class="fs-32px fw-600 lh-13">
          Section Heading
        </div>

        <div class="fs-20px fw-500 lh-14">
          Subheading
        </div>

        <div class="fs-16px fw-400 lh-12">
          Body text uses a comfortable line-height for long reading. This paragraph
          demonstrates how font size and line height work together for readability
          across screen sizes.
        </div>

      </div>
    </div>
    <div style="width: 60%;">
      <div class="typography_system-demo" style="gap:17.5px;">
        <div class="typography_system-label">Table</div>
        <div class="fs-48px fw-700 lh-12" style="font-size: 42px;">
          Display Heading
        </div>

        <div class="fs-32px fw-600 lh-13" style="font-size: 28px;">
          Section Heading
        </div>

        <div class="fs-20px fw-500 lh-14" style="font-size: 17.5px;">
          Subheading
        </div>

        <div class="fs-16px fw-400 lh-12" style="font-size: 14px;">
          Body text uses a comfortable line-height for long reading. This paragraph
          demonstrates how font size and line height work together for readability
          across screen sizes.
        </div>

      </div>
    </div>
    <div style="width: 25%;">
      <div class="typography_system-demo" style="gap:15px;">
        <div class="typography_system-label">Mobile</div>
        <div class="fs-48px fw-700 lh-12" style="font-size: 36px;">
          Display Heading
        </div>

        <div class="fs-32px fw-600 lh-13" style="font-size: 24px;">
          Section Heading
        </div>

        <div class="fs-20px fw-500 lh-14" style="font-size: 15px;">
          Subheading
        </div>

        <div class="fs-16px fw-400 lh-12" style="font-size: 12px;">
          Body text uses a comfortable line-height for long reading. This paragraph
          demonstrates how font size and line height work together for readability
          across screen sizes.
        </div>

      </div>
    </div>
  </div>

</section>
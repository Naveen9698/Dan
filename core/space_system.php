<h2 class="d-h2 demo" id="space-system">Space System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Variables</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/space_media.php'; ?></code></pre>
    <pre><code>:root {
<?php include 'root/space.php'; ?>

}</code></pre>
  </div>

  <p class="d-note">
    * The space system is based on a set of <b>CSS variables</b> that define the spacing scale. <br>
    * This includes values from <b>extra-extra-small (xxs)</b> to <b>extra-extra-large (xxl)</b> spacing. <br>
    * These variables can be easily customized to create a unique spacing scale for the project.
  </p>

  <h3 class="d-h3 demo">Spacing scale demo</h3>

  <style>
    .space_system-demo-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
    }

    .space_system-demo-panel {
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: 20px;
    }

    .space_system-demo-panel h4 {
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 16px;
      color: #111827;
    }

    .space_system-item {
      display: grid;
      grid-template-columns: 30px 30px auto;
      align-items: center;
      gap: 10px;
      margin-bottom: 5px;
    }

    .space_system-label {
      font-size: 13px;
      font-weight: 600;
      color: #374151;
    }

    .space_system-bar {
      height: 24px;
      border-radius: 6px;
      background: hsl(220.82deg 100% 80.69%);
    }

    .space_system-value {
      font-size: 12px;
      color: #6b7280;
      text-align: right;
    }
  </style>

  <div class="space_system-demo-grid">


    <div class="space_system-demo-panel" style="--space_system-unit:8px;">
      <h4>Desktop · 8px unit</h4>

      <div class="space_system-item">
        <div class="space_system-label">XXS</div>
        <div class="space_system-value">8px</div>
        <div class="space_system-bar" style="width:8px;"></div>
      </div>

      <div class="space_system-item">
        <div class="space_system-label">XS</div>
        <div class="space_system-value">16px</div>
        <div class="space_system-bar" style="width:16px;"></div>
      </div>

      <div class="space_system-item">
        <div class="space_system-label">SM</div>
        <div class="space_system-value">24px</div>
        <div class="space_system-bar" style="width:24px;"></div>
      </div>

      <div class="space_system-item">
        <div class="space_system-label">MD</div>
        <div class="space_system-value">32px</div>
        <div class="space_system-bar" style="width:32px;"></div>
      </div>

      <div class="space_system-item">
        <div class="space_system-label">LG</div>
        <div class="space_system-value">48px</div>
        <div class="space_system-bar" style="width:48px;"></div>
      </div>

      <div class="space_system-item">
        <div class="space_system-label">XL</div>
        <div class="space_system-value">64px</div>
        <div class="space_system-bar" style="width:64px;"></div>
      </div>

      <div class="space_system-item">
        <div class="space_system-label">XXL</div>
        <div class="space_system-value">96px</div>
        <div class="space_system-bar" style="width:96px;"></div>
      </div>
    </div>


    <div class="space_system-demo-panel" style="--space_system-unit:6px;">
      <h4>Tablet · 6px unit</h4>

      <div class="space_system-item">
        <div class="space_system-label">XXS</div>
        <div class="space_system-value">6px</div>
        <div class="space_system-bar" style="width:6px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">XS</div>
        <div class="space_system-value">12px</div>
        <div class="space_system-bar" style="width:12px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">SM</div>
        <div class="space_system-value">18px</div>
        <div class="space_system-bar" style="width:18px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">MD</div>
        <div class="space_system-value">24px</div>
        <div class="space_system-bar" style="width:24px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">LG</div>
        <div class="space_system-value">36px</div>
        <div class="space_system-bar" style="width:36px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">XL</div>
        <div class="space_system-value">48px</div>
        <div class="space_system-bar" style="width:48px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">XXL</div>
        <div class="space_system-value">72px</div>
        <div class="space_system-bar" style="width:72px;"></div>
      </div>
    </div>


    <div class="space_system-demo-panel" style="--space_system-unit:4px;">
      <h4>Mobile · 4px unit</h4>

      <div class="space_system-item">
        <div class="space_system-label">XXS</div>
        <div class="space_system-value">4px</div>
        <div class="space_system-bar" style="width:4px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">XS</div>
        <div class="space_system-value">8px</div>
        <div class="space_system-bar" style="width:8px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">SM</div>
        <div class="space_system-value">12px</div>
        <div class="space_system-bar" style="width:12px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">MD</div>
        <div class="space_system-value">16px</div>
        <div class="space_system-bar" style="width:16px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">LG</div>
        <div class="space_system-value">24px</div>
        <div class="space_system-bar" style="width:24px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">XL</div>
        <div class="space_system-value">32px</div>
        <div class="space_system-bar" style="width:32px;"></div>
      </div>
      <div class="space_system-item">
        <div class="space_system-label">XXL</div>
        <div class="space_system-value">48px</div>
        <div class="space_system-bar" style="width:48px;"></div>
      </div>
    </div>

  </div>


  <h3 class="d-h3 demo">Padding Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/space_p1.php'; ?></code></pre>
    <pre><code><?php include 'class/space_p2.php'; ?></code></pre>
    <pre><code><?php include 'class/space_p3.php'; ?></code></pre>
    <pre><code><?php include 'class/space_p4.php'; ?></code></pre>
    <pre><code><?php include 'class/space_p5.php'; ?></code></pre>
    <pre><code><?php include 'class/space_p6.php'; ?></code></pre>
    <pre><code><?php include 'class/space_p7.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Margin Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/space_m1.php'; ?></code></pre>
    <pre><code><?php include 'class/space_m2.php'; ?></code></pre>
    <pre><code><?php include 'class/space_m3.php'; ?></code></pre>
    <pre><code><?php include 'class/space_m4.php'; ?></code></pre>
    <pre><code><?php include 'class/space_m5.php'; ?></code></pre>
    <pre><code><?php include 'class/space_m6.php'; ?></code></pre>
    <pre><code><?php include 'class/space_m7.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Gap Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/space_g1.php'; ?></code></pre>
    <pre><code><?php include 'class/space_g2.php'; ?></code></pre>
    <pre><code><?php include 'class/space_g3.php'; ?></code></pre>
  </div>

</section>
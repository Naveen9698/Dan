<h2 class="d-h2 demo" id="color-system">Color System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Variables</h3>
  <div class="d-cols">
    <pre><code>:root {
<?php include 'root/color.php'; ?>

}</code></pre>
  </div>
  <p class="d-note">
    * The color system is based on a set of CSS variables that define the main, sub, and neutral colors, as well as their respective shades. <br>
    * These variables can be easily customized to create a unique color palette for the project. <br>
    * The utility classes provide a convenient way to apply these colors to the elements, ensuring consistency across the design. <br>
    * By using the color system, you can maintain a cohesive and visually appealing design while also allowing for flexibility and customization.
  </p>

  <h3 class="d-h3 demo">Live Demo</h3>

  <style>
    .color_system-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 20px;
      margin-top: 28px;
    }

    .color_system-card {
      border-radius: 14px;
      overflow: hidden;
      position: relative;
      border: 1px solid #e5e7eb;
      background: #ffffff;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .color_system-card:h {
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(0, 0, 0, 0.08);
    }

    .color_system-swatch {
      height: 56px;
      display: flex;
      align-items: flex-end;
    }

    .color_system-swatch p {
      margin: 0;
      padding: 4px 6px;
      font-size: 11px;
      color: #fff;
      background: rgba(0, 0, 0, 0.35);
      border-top-right-radius: 6px;
    }

    .color_system-meta {
      padding: 12px 14px;
      font-size: 12px;
      color: #374151;
      font-weight: 500;
      display: flex;
      justify-content: space-between;
    }

    .color_system-text {
      font-size: 24px;
      font-weight: 700;
      color: #111;
      position: absolute;
      top: 5px;
      right: 10px;
    }
  </style>

  <div class="color_system-grid">

    <div class="color_system-card">
      <div class="color_system-meta">Main</div>
      <div class="color_system-text" style="color:var(--color-main)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-main)">
        <p>--color-main</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Main hover</div>
      <div class="color_system-text" style="color:var(--color-main-h)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-main-h)">
        <p>--color-main-h</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Sub</div>
      <div class="color_system-text" style="color:var(--color-sub)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-sub)">
        <p>--color-sub</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Sub hover</div>
      <div class="color_system-text" style="color:var(--color-sub-h)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-sub-h)">
        <p>--color-sub-h</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Black</div>
      <div class="color_system-text" style="color:var(--color-black)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-black)">
        <p>--color-black</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 9</div>
      <div class="color_system-text" style="color:var(--color-g9)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-g9)">
        <p style="color:#000;background:rgba(255,255,255,.6)">--color-g9</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 8</div>
      <div class="color_system-text" style="color:var(--color-g8)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-g8)">
        <p>--color-g8</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 7</div>
      <div class="color_system-text" style="color:var(--color-g7)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-g7)">
        <p>--color-g7</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 6</div>
      <div class="color_system-text" style="color:var(--color-g6)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-g6)">
        <p>--color-g6</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 5</div>
      <div class="color_system-text" style="color:var(--color-g5)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-g5)">
        <p>--color-g5</p>
      </div>
    </div>
    
    <div class="color_system-card">
      <div class="color_system-meta">Gray 4</div>
      <div class="color_system-text" style="color:var(--color-g4)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-g4)">
        <p>--color-g4</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 3</div>
      <div class="color_system-text" style="color:var(--color-g3)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-g3)">
        <p>--color-g3</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 2</div>
      <div class="color_system-text" style="color:var(--color-g2)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-g2)">
        <p>--color-g2</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 1</div>
      <div class="color_system-text" style="color:var(--color-g1)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-g1)">
        <p>--color-g1</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta" style="background:rgba(0,0,0,.3)">White</div>
      <div class="color_system-text" style="color:var(--color-white)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-white)">
        <p style="color:#000;background:rgba(0,0,0,.1)">--color-white</p>
      </div>
    </div>

  </div>

  <h3 class="d-h3 demo">Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/color1.php'; ?></code></pre>
    <pre><code><?php include 'class/color2.php'; ?></code></pre>
  </div>

</section>
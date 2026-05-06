<h2 class="d-h2 demo" id="color-system">Color System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Variables</h3>
  <div class="d-cols">
    <pre><code>:root {
<?php include 'root/color.php'; ?>

}</code></pre>
  </div>
  <p class="d-note">
    * The color system is based on a set of CSS variables that define the primary, secondary, and neutral colors, as well as their respective shades. <br>
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

    .color_system-card:hover {
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
      <div class="color_system-meta">Primary</div>
      <div class="color_system-text" style="color:var(--color-primary)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-primary)">
        <p>--color-primary</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Primary Hover</div>
      <div class="color_system-text" style="color:var(--color-primary-hover)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-primary-hover)">
        <p>--color-primary-hover</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Secondary</div>
      <div class="color_system-text" style="color:var(--color-secondary)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-secondary)">
        <p>--color-secondary</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Secondary Hover</div>
      <div class="color_system-text" style="color:var(--color-secondary-hover)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-secondary-hover)">
        <p>--color-secondary-hover</p>
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
      <div class="color_system-meta">Gray 10</div>
      <div class="color_system-text" style="color:var(--color-gray-10)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-gray-10)">
        <p>--color-gray-10</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 20</div>
      <div class="color_system-text" style="color:var(--color-gray-20)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-gray-20)">
        <p>--color-gray-20</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 30</div>
      <div class="color_system-text" style="color:var(--color-gray-30)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-gray-30)">
        <p>--color-gray-30</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 40</div>
      <div class="color_system-text" style="color:var(--color-gray-40)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-gray-40)">
        <p>--color-gray-40</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 50</div>
      <div class="color_system-text" style="color:var(--color-gray-50)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-gray-50)">
        <p>--color-gray-50</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 60</div>
      <div class="color_system-text" style="color:var(--color-gray-60)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-gray-60)">
        <p>--color-gray-60</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 70</div>
      <div class="color_system-text" style="color:var(--color-gray-70)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-gray-70)">
        <p>--color-gray-70</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 80</div>
      <div class="color_system-text" style="color:var(--color-gray-80)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-gray-80)">
        <p>--color-gray-80</p>
      </div>
    </div>

    <div class="color_system-card">
      <div class="color_system-meta">Gray 90</div>
      <div class="color_system-text" style="color:var(--color-gray-90)">Abc</div>
      <div class="color_system-swatch" style="background:var(--color-gray-90)">
        <p style="color:#000;background:rgba(255,255,255,.6)">--color-gray-90</p>
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
<h2 class="d-h2 demo" id="grid-system">Grid System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Prefixes</h3>

  <div class="d-cols">
    <pre><code><?php include 'prefix/grid.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * The grid uses a <b>12-column</b> layout by default, allowing for a wide range of column combinations and responsive design options. <br>
    * The grid does not provide spacing by default. Use spacing utilities <b>(gap-*, padding, margin)</b> explicitly. <br>
    * Row height is driven purely by content and is not constrained by the grid, providing flexibility for various design needs.
  </p>

  <h3 class="d-h3 demo">Grid Column Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/grid1.php'; ?></code></pre>
    <pre><code><?php include 'class/grid2.php'; ?></code></pre>
    <pre><code><?php include 'class/grid3.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Grid Row Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/grid_y1.php'; ?></code></pre>
    <pre><code><?php include 'class/grid_y2.php'; ?></code></pre>
    <pre><code><?php include 'class/grid_y3.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Live Responsive Demo</h3>

  <style>
    .grid_system-live .demo-preview {
      background:
        linear-gradient(180deg, #fafafa, #f3f4f6);
      padding: var(--sm);
      border-radius: 18px;
      border: 1px solid #e5e7eb;
      display: flex;
      flex-direction: column;
      gap: var(--xs);

      /* subtle elevation */
      box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, .6),
        0 8px 24px rgba(0, 0, 0, .04);
    }

    .grid_system-live .demo-preview-header g-mb-xs {
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .01em;
      color: #111827;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .grid_system-live .demo-preview-header g-mb-xs::before {
      content: "";
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: hsl(221 83% 50%);
      box-shadow: 0 0 0 4px hsl(221 83% 50% / .15);
    }

    .grid_system-live .demo-preview-hint {
      font-size: 12px;
      color: #6b7280;
    }

    .grid_system-live .demo-item {
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: var(--xxs) var(--xs);
      font-size: 12px;
      box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, .8),
        0 2px 6px rgba(0, 0, 0, .04);
    }

    .grid_system-live .demo-item b {
      font-size: 13px;
    }

    .grid_system-live .demo-item.primary {
      background: hsl(221 83% 50% / 0.10);
      border-color: hsl(221 83% 50% / 0.25);
    }

    .grid_system-live .demo-item.secondary {
      background: hsl(142 76% 40% / 0.10);
      border-color: hsl(142 76% 40% / 0.25);
    }

    .grid_system-live .demo-item.accent {
      background: hsl(271 76% 40% / 0.10);
      border-color: hsl(271 76% 40% / 0.25);
    }

    .grid_system-live .demo-code pre {
      margin: 0;
      border-radius: 14px;
      box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .05);
    }
  </style>
  <div class="grid_system-live">
    <div class="demo-preview">
      <pre><code>&lt;div class="grid gap-xs"&gt;
  &lt;div class="g-2 g-tb-3 gy-2 gy-tb-3"&gt;&lt;/div&gt;
  &lt;div class="g-2 g-tb-3 gy-2 gy-tb-1"&gt;&lt;/div&gt;
  &lt;div class="g-2 g-tb-3 g-mb-6 gy-2 gy-tb-1"&gt;&lt;/div&gt;

  &lt;div class="g-3 g-mb-9 gy-tb-3"&gt;&lt;/div&gt;
  &lt;div class="g-3 g-mb-12 gy-tb-2"&gt;&lt;/div&gt;
  
  &lt;div class="g-2 g-mb-12"&gt;&lt;/div&gt;
  &lt;div class="g-1"&gt;&lt;/div&gt;
  
  &lt;div class="g-2 g-mb-12"&gt;&lt;/div&gt;
  &lt;div class="g-1"&gt;&lt;/div&gt;
  
  &lt;div class="g-8"&gt;&lt;/div&gt;
  &lt;div class="g-4"&gt;&lt;/div&gt;
&lt;/div&gt;</code></pre>

      <div class="grid gap-sm">

        <div class="demo-preview g-12">
          <div class="demo-preview-header g-mb-xs">
            desktop (g-*)
          </div>
          <div class="grid gap-xs">
            <div class="demo-item primary g-2 g-tb-3 gy-2 gy-tb-3"><b>g-2</b> g-tb-3 <br> <b>gy-2</b> gy-tb-3</div>
            <div class="demo-item primary g-2 g-tb-3 gy-2 gy-tb-1"><b>g-2</b> g-tb-3 <br> <b>gy-2</b> gy-tb-1</div>
            <div class="demo-item primary g-2 g-tb-3 g-mb-6 gy-2 gy-tb-1"><b>g-2</b> g-tb-3 g-mb-6 <br> <b>gy-2</b>
              gy-tb-1</div>
            <div class="demo-item secondary g-3 g-mb-9 gy-tb-3"><b>g-3</b> g-mb-9 <br> gy-tb-3 gy-mb-2</div>
            <div class="demo-item secondary g-3 g-mb-12 gy-tb-2"><b>g-3</b> g-mb-12 <br> gy-tb-2</div>
            <div class="demo-item primary g-2 g-mb-12"><b>g-2</b> g-mb-12</div>
            <div class="demo-item secondary g-1"><b>g-1</b> g-mb-6</div>
            <div class="demo-item primary g-2 g-mb-12"><b>g-2</b> g-mb-12</div>
            <div class="demo-item secondary g-1"><b>g-1</b> g-mb-6</div>
            <div class="demo-item accent g-8"><b>g-8</b></div>
            <div class="demo-item accent g-4"><b>g-4</b></div>
          </div>
        </div>

        <div class="demo-preview g-8">
          <div class="demo-preview-header g-mb-xs">
            tablet (g-tb-*)
          </div>
          <div class="grid gap-xs">
            <div class="demo-item primary g-3 gy-3">g-2 <b>g-tb-3</b> <br> gy-2 <b>gy-tb-3</b></div>
            <div class="demo-item primary g-3 gy-1">g-2 <b>g-tb-3</b> <br> gy-2 <b>gy-tb-1</b></div>
            <div class="demo-item primary g-3 g-mb-6 gy-1">g-2 <b>g-tb-3</b> g-mb-6 <br> gy-2 <b>gy-tb-1</b></div>
            <div class="demo-item secondary g-3 g-mb-9 gy-3"><b>g-3</b> g-mb-9 <br> <b>gy-tb-3</b> gy-mb-2</div>
            <div class="demo-item secondary g-3 g-mb-12 gy-2"><b>g-3</b> g-mb-12 <br> <b>gy-tb-2</b></div>
            <div class="demo-item primary g-2 g-mb-12"><b>g-2</b> g-mb-12</div>
            <div class="demo-item secondary g-1"><b>g-1</b> g-mb-6</div>
            <div class="demo-item primary g-2 g-mb-12"><b>g-2</b> g-mb-12</div>
            <div class="demo-item secondary g-1"><b>g-1</b> g-mb-6</div>
            <div class="demo-item accent g-8"><b>g-8</b></div>
            <div class="demo-item accent g-4"><b>g-4</b></div>
          </div>
        </div>

        <div class="demo-preview g-4">
          <div class="demo-preview-header g-mb-xs">
            mobile (g-mb-*)
          </div>
          <div class="grid gap-xs">
            <div class="demo-item primary g-3 gy-3">g-2 <b>g-tb-3</b> <br> gy-2 <b>gy-tb-3</b></div>
            <div class="demo-item primary g-3 gy-1">g-2 <b>g-tb-3</b> <br> gy-2 <b>gy-tb-1</b></div>
            <div class="demo-item primary g-6 gy-1">g-2 g-tb-3 <b>g-mb-6</b> <br> gy-2 <b>gy-tb-1</b></div>
            <div class="demo-item secondary g-9 gy-2">g-3 <b>g-mb-9</b> <br> gy-tb-3 <b>gy-mb-2</b></div>
            <div class="demo-item secondary g-12 gy-2">g-3 <b>g-mb-12</b> <br> <b>gy-tb-2</b></div>
            <div class="demo-item primary g-12">g-2 <b>g-mb-12</b></div>
            <div class="demo-item secondary g-6">g-1 <b>g-mb-6</b></div>
            <div class="demo-item primary g-12">g-2 <b>g-mb-12</b></div>
            <div class="demo-item secondary g-6">g-1 <b>g-mb-6</b></div>
            <div class="demo-item accent g-8"><b>g-8</b></div>
            <div class="demo-item accent g-4"><b>g-4</b></div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <style>
    /* Demo visuals only */
    .grid_system .grid-tile {
      width: 200px;
      height: 200px;
      padding: 14px;
      border-radius: 14px;
      border: 1px solid #e5e7eb;
      background: #ffffff;
      gap: 10px;
      align-content: space-between
    }

    .grid_system .cell {
      background: #ef4444;
      color: #ffffff;
      font-size: 12px;
      font-weight: 600;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .grid_system {
      gap: 30px;
      padding: 28px;
      background: #fafafa;
      border-radius: 20px;
      border: 1px solid #e5e7eb;
    }

    .grid_system .demo-max-5px {
      height: 5px;
    }
  </style>

  <div class="grid grid_system">

    <div class="g-2 grid grid-tile">
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
      <div class="cell g-1 gy-1 demo-max-5px"></div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
      <div class="cell g-2 gy-2">2</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
      <div class="cell g-3 gy-3">3 / 3</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-4 gy-4">4 / 4</div>
      <div class="cell g-4 gy-4">4 / 4</div>
      <div class="cell g-4 gy-4">4 / 4</div>
      <div class="cell g-4 gy-4">4 / 4</div>
      <div class="cell g-4 gy-4">4 / 4</div>
      <div class="cell g-4 gy-4">4 / 4</div>
      <div class="cell g-4 gy-4">4 / 4</div>
      <div class="cell g-4 gy-4">4 / 4</div>
      <div class="cell g-4 gy-4">4 / 4</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-6 gy-6">6 / 6</div>
      <div class="cell g-6 gy-6">6 / 6</div>
      <div class="cell g-6 gy-6">6 / 6</div>
      <div class="cell g-6 gy-6">6 / 6</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-12 gy-12">12 / 12</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-12 gy-3">12 / 3</div>
      <div class="cell g-4 gy-9">4 / 9</div>
      <div class="cell g-4 gy-9">4 / 9</div>
      <div class="cell g-4 gy-9">4 / 9</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-3 gy-12">3 / 12</div>
      <div class="cell g-9 gy-4">9 / 4</div>
      <div class="cell g-9 gy-4">9 / 4</div>
      <div class="cell g-9 gy-4">9 / 4</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-9 gy-4">9 / 4</div>
      <div class="cell g-3 gy-12">3 / 12</div>
      <div class="cell g-9 gy-4">9 / 4</div>
      <div class="cell g-9 gy-4">9 / 4</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-4 gy-9">4 / 9</div>
      <div class="cell g-4 gy-9">4 / 9</div>
      <div class="cell g-4 gy-9">4 / 9</div>
      <div class="cell g-12 gy-3">12 / 3</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-6 gy-4">6 / 4</div>
      <div class="cell g-6 gy-4">6 / 4</div>
      <div class="cell g-6 gy-4">6 / 4</div>
      <div class="cell g-6 gy-4">6 / 4</div>
      <div class="cell g-6 gy-4">6 / 4</div>
      <div class="cell g-6 gy-4">6 / 4</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-4 gy-6">4 / 6</div>
      <div class="cell g-4 gy-6">4 / 6</div>
      <div class="cell g-4 gy-6">4 / 6</div>
      <div class="cell g-4 gy-6">4 / 6</div>
      <div class="cell g-4 gy-6">4 / 6</div>
      <div class="cell g-4 gy-6">4 / 6</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-12 gy-8">12 / 8</div>
      <div class="cell g-12 gy-4">12 / 4</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-3 gy-12">3 / 12</div>
      <div class="cell g-9 gy-8">9 / 8</div>
      <div class="cell g-9 gy-4">9 / 4</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-12 gy-3">12 / 3</div>
      <div class="cell g-4 gy-3">4 / 3</div>
      <div class="cell g-4 gy-3">4 / 3</div>
      <div class="cell g-4 gy-3">4 / 3</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-12 gy-3">12 / 3</div>
      <div class="cell g-4 gy-3">4 / 3</div>
      <div class="cell g-4 gy-3">4 / 3</div>
      <div class="cell g-4 gy-3">4 / 3</div>
      <div class="cell g-4 gy-3">4 / 3</div>
      <div class="cell g-4 gy-3">4 / 3</div>
      <div class="cell g-4 gy-3">4 / 3</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-12 gy-4">12 / 4</div>
      <div class="cell g-6 gy-4">6 / 4</div>
      <div class="cell g-6 gy-4">6 / 4</div>
      <div class="cell g-6 gy-4">6 / 4</div>
      <div class="cell g-6 gy-4">6 / 4</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-6 gy-12">6 / 12</div>
      <div class="cell g-3 gy-6">3 / 6</div>
      <div class="cell g-3 gy-6">3 / 6</div>
      <div class="cell g-3 gy-6">3 / 6</div>
      <div class="cell g-3 gy-6">3 / 6</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-12 gy-3">12 / 3</div>
      <div class="cell g-12 gy-3">12 / 3</div>
      <div class="cell g-6 gy-6">6 / 6</div>
      <div class="cell g-6 gy-6">6 / 6</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-9 gy-8">9 / 8</div>
      <div class="cell g-3 gy-4">3 / 4</div>
      <div class="cell g-3 gy-4">3 / 4</div>
      <div class="cell g-12 gy-4">12 / 4</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-8 gy-12">8 / 12</div>
      <div class="cell g-4 gy-4">4 / 4</div>
      <div class="cell g-4 gy-4">4 / 4</div>
      <div class="cell g-4 gy-4">4 / 4</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-4 gy-12">4 / 12</div>
      <div class="cell g-4 gy-6">4 / 6</div>
      <div class="cell g-4 gy-6">4 / 6</div>
      <div class="cell g-4 gy-6">4 / 6</div>
      <div class="cell g-4 gy-6">4 / 6</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-6 gy-12">6 / 12</div>
      <div class="cell g-6 gy-6">6 / 6</div>
      <div class="cell g-3 gy-6">3 / 6</div>
      <div class="cell g-3 gy-6">3 / 6</div>
    </div>

    <div class="g-2 grid grid-tile">
      <div class="cell g-2 gy-6">2 / 6</div>
      <div class="cell g-5 gy-4">5 / 4</div>
      <div class="cell g-5 gy-4">5 / 4</div>
      <div class="cell g-3 gy-4">3 / 4</div>
      <div class="cell g-5 gy-4">5 / 4</div>
      <div class="cell g-2 gy-8">2 / 8</div>
      <div class="cell g-2 gy-6">2 / 6</div>
      <div class="cell g-5 gy-4">5 / 4</div>
      <div class="cell g-3 gy-4">3 / 4</div>
    </div>

  </div>

</section>
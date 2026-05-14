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

    .grid_system-live .demo-preview-header mb-xs {
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .01em;
      color: #111827;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .grid_system-live .demo-preview-header mb-xs::before {
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
  &lt;div class="dp-2 tb-3 dp-y-2 tb-y-3"&gt;&lt;/div&gt;
  &lt;div class="dp-2 tb-3 dp-y-2 tb-y-1"&gt;&lt;/div&gt;
  &lt;div class="dp-2 tb-3 mb-6 dp-y-2 tb-y-1"&gt;&lt;/div&gt;

  &lt;div class="dp-3 mb-9 tb-y-3"&gt;&lt;/div&gt;
  &lt;div class="dp-3 mb-12 tb-y-2"&gt;&lt;/div&gt;
  
  &lt;div class="dp-2 mb-12"&gt;&lt;/div&gt;
  &lt;div class="dp-1"&gt;&lt;/div&gt;
  
  &lt;div class="dp-2 mb-12"&gt;&lt;/div&gt;
  &lt;div class="dp-1"&gt;&lt;/div&gt;
  
  &lt;div class="dp-8"&gt;&lt;/div&gt;
  &lt;div class="dp-4"&gt;&lt;/div&gt;
&lt;/div&gt;</code></pre>

      <div class="grid gap-sm">

        <div class="demo-preview dp-12">
          <div class="demo-preview-header mb-xs">
            desktop (dp-*)
          </div>
          <div class="grid gap-xs">
            <div class="demo-item primary dp-2 tb-3 dp-y-2 tb-y-3"><b>dp-2</b> tb-3 <br> <b>dp-y-2</b> tb-y-3</div>
            <div class="demo-item primary dp-2 tb-3 dp-y-2 tb-y-1"><b>dp-2</b> tb-3 <br> <b>dp-y-2</b> tb-y-1</div>
            <div class="demo-item primary dp-2 tb-3 mb-6 dp-y-2 tb-y-1"><b>dp-2</b> tb-3 mb-6 <br> <b>dp-y-2</b>
              tb-y-1</div>
            <div class="demo-item secondary dp-3 mb-9 tb-y-3"><b>dp-3</b> mb-9 <br> tb-y-3 mb-y-2</div>
            <div class="demo-item secondary dp-3 mb-12 tb-y-2"><b>dp-3</b> mb-12 <br> tb-y-2</div>
            <div class="demo-item primary dp-2 mb-12"><b>dp-2</b> mb-12</div>
            <div class="demo-item secondary dp-1"><b>dp-1</b> mb-6</div>
            <div class="demo-item primary dp-2 mb-12"><b>dp-2</b> mb-12</div>
            <div class="demo-item secondary dp-1"><b>dp-1</b> mb-6</div>
            <div class="demo-item accent dp-8"><b>dp-8</b></div>
            <div class="demo-item accent dp-4"><b>dp-4</b></div>
          </div>
        </div>

        <div class="demo-preview dp-8">
          <div class="demo-preview-header mb-xs">
            tablet (tb-*)
          </div>
          <div class="grid gap-xs">
            <div class="demo-item primary dp-3 dp-y-3">dp-2 <b>tb-3</b> <br> dp-y-2 <b>tb-y-3</b></div>
            <div class="demo-item primary dp-3 dp-y-1">dp-2 <b>tb-3</b> <br> dp-y-2 <b>tb-y-1</b></div>
            <div class="demo-item primary dp-3 mb-6 dp-y-1">dp-2 <b>tb-3</b> mb-6 <br> dp-y-2 <b>tb-y-1</b></div>
            <div class="demo-item secondary dp-3 mb-9 dp-y-3"><b>dp-3</b> mb-9 <br> <b>tb-y-3</b> mb-y-2</div>
            <div class="demo-item secondary dp-3 mb-12 dp-y-2"><b>dp-3</b> mb-12 <br> <b>tb-y-2</b></div>
            <div class="demo-item primary dp-2 mb-12"><b>dp-2</b> mb-12</div>
            <div class="demo-item secondary dp-1"><b>dp-1</b> mb-6</div>
            <div class="demo-item primary dp-2 mb-12"><b>dp-2</b> mb-12</div>
            <div class="demo-item secondary dp-1"><b>dp-1</b> mb-6</div>
            <div class="demo-item accent dp-8"><b>dp-8</b></div>
            <div class="demo-item accent dp-4"><b>dp-4</b></div>
          </div>
        </div>

        <div class="demo-preview dp-4">
          <div class="demo-preview-header mb-xs">
            mobile (mb-*)
          </div>
          <div class="grid gap-xs">
            <div class="demo-item primary dp-3 dp-y-3">dp-2 <b>tb-3</b> <br> dp-y-2 <b>tb-y-3</b></div>
            <div class="demo-item primary dp-3 dp-y-1">dp-2 <b>tb-3</b> <br> dp-y-2 <b>tb-y-1</b></div>
            <div class="demo-item primary dp-6 dp-y-1">dp-2 tb-3 <b>mb-6</b> <br> dp-y-2 <b>tb-y-1</b></div>
            <div class="demo-item secondary dp-9 dp-y-2">dp-3 <b>mb-9</b> <br> tb-y-3 <b>mb-y-2</b></div>
            <div class="demo-item secondary dp-12 dp-y-2">dp-3 <b>mb-12</b> <br> <b>tb-y-2</b></div>
            <div class="demo-item primary dp-12">dp-2 <b>mb-12</b></div>
            <div class="demo-item secondary dp-6">dp-1 <b>mb-6</b></div>
            <div class="demo-item primary dp-12">dp-2 <b>mb-12</b></div>
            <div class="demo-item secondary dp-6">dp-1 <b>mb-6</b></div>
            <div class="demo-item accent dp-8"><b>dp-8</b></div>
            <div class="demo-item accent dp-4"><b>dp-4</b></div>
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

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
      <div class="cell dp-1 dp-y-1 demo-max-5px"></div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
      <div class="cell dp-2 dp-y-2">2</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
      <div class="cell dp-3 dp-y-3">3 / 3</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-4 dp-y-4">4 / 4</div>
      <div class="cell dp-4 dp-y-4">4 / 4</div>
      <div class="cell dp-4 dp-y-4">4 / 4</div>
      <div class="cell dp-4 dp-y-4">4 / 4</div>
      <div class="cell dp-4 dp-y-4">4 / 4</div>
      <div class="cell dp-4 dp-y-4">4 / 4</div>
      <div class="cell dp-4 dp-y-4">4 / 4</div>
      <div class="cell dp-4 dp-y-4">4 / 4</div>
      <div class="cell dp-4 dp-y-4">4 / 4</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-6 dp-y-6">6 / 6</div>
      <div class="cell dp-6 dp-y-6">6 / 6</div>
      <div class="cell dp-6 dp-y-6">6 / 6</div>
      <div class="cell dp-6 dp-y-6">6 / 6</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-12 dp-y-12">12 / 12</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-12 dp-y-3">12 / 3</div>
      <div class="cell dp-4 dp-y-9">4 / 9</div>
      <div class="cell dp-4 dp-y-9">4 / 9</div>
      <div class="cell dp-4 dp-y-9">4 / 9</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-3 dp-y-12">3 / 12</div>
      <div class="cell dp-9 dp-y-4">9 / 4</div>
      <div class="cell dp-9 dp-y-4">9 / 4</div>
      <div class="cell dp-9 dp-y-4">9 / 4</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-9 dp-y-4">9 / 4</div>
      <div class="cell dp-3 dp-y-12">3 / 12</div>
      <div class="cell dp-9 dp-y-4">9 / 4</div>
      <div class="cell dp-9 dp-y-4">9 / 4</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-4 dp-y-9">4 / 9</div>
      <div class="cell dp-4 dp-y-9">4 / 9</div>
      <div class="cell dp-4 dp-y-9">4 / 9</div>
      <div class="cell dp-12 dp-y-3">12 / 3</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-6 dp-y-4">6 / 4</div>
      <div class="cell dp-6 dp-y-4">6 / 4</div>
      <div class="cell dp-6 dp-y-4">6 / 4</div>
      <div class="cell dp-6 dp-y-4">6 / 4</div>
      <div class="cell dp-6 dp-y-4">6 / 4</div>
      <div class="cell dp-6 dp-y-4">6 / 4</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-4 dp-y-6">4 / 6</div>
      <div class="cell dp-4 dp-y-6">4 / 6</div>
      <div class="cell dp-4 dp-y-6">4 / 6</div>
      <div class="cell dp-4 dp-y-6">4 / 6</div>
      <div class="cell dp-4 dp-y-6">4 / 6</div>
      <div class="cell dp-4 dp-y-6">4 / 6</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-12 dp-y-8">12 / 8</div>
      <div class="cell dp-12 dp-y-4">12 / 4</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-3 dp-y-12">3 / 12</div>
      <div class="cell dp-9 dp-y-8">9 / 8</div>
      <div class="cell dp-9 dp-y-4">9 / 4</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-12 dp-y-3">12 / 3</div>
      <div class="cell dp-4 dp-y-3">4 / 3</div>
      <div class="cell dp-4 dp-y-3">4 / 3</div>
      <div class="cell dp-4 dp-y-3">4 / 3</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-12 dp-y-3">12 / 3</div>
      <div class="cell dp-4 dp-y-3">4 / 3</div>
      <div class="cell dp-4 dp-y-3">4 / 3</div>
      <div class="cell dp-4 dp-y-3">4 / 3</div>
      <div class="cell dp-4 dp-y-3">4 / 3</div>
      <div class="cell dp-4 dp-y-3">4 / 3</div>
      <div class="cell dp-4 dp-y-3">4 / 3</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-12 dp-y-4">12 / 4</div>
      <div class="cell dp-6 dp-y-4">6 / 4</div>
      <div class="cell dp-6 dp-y-4">6 / 4</div>
      <div class="cell dp-6 dp-y-4">6 / 4</div>
      <div class="cell dp-6 dp-y-4">6 / 4</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-6 dp-y-12">6 / 12</div>
      <div class="cell dp-3 dp-y-6">3 / 6</div>
      <div class="cell dp-3 dp-y-6">3 / 6</div>
      <div class="cell dp-3 dp-y-6">3 / 6</div>
      <div class="cell dp-3 dp-y-6">3 / 6</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-12 dp-y-3">12 / 3</div>
      <div class="cell dp-12 dp-y-3">12 / 3</div>
      <div class="cell dp-6 dp-y-6">6 / 6</div>
      <div class="cell dp-6 dp-y-6">6 / 6</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-9 dp-y-8">9 / 8</div>
      <div class="cell dp-3 dp-y-4">3 / 4</div>
      <div class="cell dp-3 dp-y-4">3 / 4</div>
      <div class="cell dp-12 dp-y-4">12 / 4</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-8 dp-y-12">8 / 12</div>
      <div class="cell dp-4 dp-y-4">4 / 4</div>
      <div class="cell dp-4 dp-y-4">4 / 4</div>
      <div class="cell dp-4 dp-y-4">4 / 4</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-4 dp-y-12">4 / 12</div>
      <div class="cell dp-4 dp-y-6">4 / 6</div>
      <div class="cell dp-4 dp-y-6">4 / 6</div>
      <div class="cell dp-4 dp-y-6">4 / 6</div>
      <div class="cell dp-4 dp-y-6">4 / 6</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-6 dp-y-12">6 / 12</div>
      <div class="cell dp-6 dp-y-6">6 / 6</div>
      <div class="cell dp-3 dp-y-6">3 / 6</div>
      <div class="cell dp-3 dp-y-6">3 / 6</div>
    </div>

    <div class="dp-2 grid grid-tile">
      <div class="cell dp-2 dp-y-6">2 / 6</div>
      <div class="cell dp-5 dp-y-4">5 / 4</div>
      <div class="cell dp-5 dp-y-4">5 / 4</div>
      <div class="cell dp-3 dp-y-4">3 / 4</div>
      <div class="cell dp-5 dp-y-4">5 / 4</div>
      <div class="cell dp-2 dp-y-8">2 / 8</div>
      <div class="cell dp-2 dp-y-6">2 / 6</div>
      <div class="cell dp-5 dp-y-4">5 / 4</div>
      <div class="cell dp-3 dp-y-4">3 / 4</div>
    </div>

  </div>

</section>
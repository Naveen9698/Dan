<h2 class="d-h2 demo" id="flex-system">Flex System</h2>

<section class="d-section flex_system">
  <h3 class="d-h3 demo">Prefixes</h3>

  <div class="d-cols">
    <pre><code><?php include 'prefix/flex.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Elements with <b>flex-*</b> classes automatically become flex containers. <br>
    * Flex layouts <b>wrap</b> by default and align items to the <b>start</b>. <br>
    * <b>no-wrap</b> tells a flex container to keep all its children on a <b>single line</b>, no matter how narrow the container gets. <br>
    * <b>fill</b> makes a flex item grow to fill available space inside a flex container.
  </p>

  <h3 class="d-h3 demo">Flex Direction Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex_direction.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Flex direction defines the primary flow of items along the <b>x‑axis</b> or <b>y‑axis</b>.<br>
    * <b>fx</b> creates a <b>row layout</b> and <b>fy</b> creates a <b>column layout</b>.<br>
    * Responsive variants (<b>tb-*, mb-*</b>) override direction on smaller screens.
  </p>

  <style>
    /* ---------- Demo visuals only ---------- */
    .flex_system .flex-ref {
      font-family: system-ui, sans-serif;
      background: #fafafa;
      padding: 28px;
      border: 1px solid #e5e7eb;
      border-radius: 20px;
      max-width: 100%;
      gap: 20px;
      display: flex;
      flex-direction: column;
      align-items: stretch;
    }

    .flex_system .ref-title {
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 14px;
    }

    .flex_system .ref-grid {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 10px;
      text-align: -webkit-center;
    }

    .flex_system .ref-grid-5 {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 10px;
      text-align: -webkit-center;
    }

    .flex_system .ref-box {
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 14px;
      padding: 14px;
    }

    .flex_system .ref-label {
      margin-top: 10px;
      font-size: 12px;
      color: #6b7280;
      text-align: center;
    }

    .flex_system .ref-items {
      gap: 10px;
      height: 200px;
      width: 200px;
    }

    .flex_system .item {
      background: #ef4444;
      border-radius: 6px;
      width: 20px;
    }

    .flex_system .item.small {
      height: 13px;
    }

    .flex_system .item.mid {
      height: 25px;
    }

    .flex_system .item.tall {
      height: 50px;
    }

    .flex_system .item-y {
      background: #ef4444;
      border-radius: 6px;
      height: 20px;
    }

    .flex_system .item-y.small {
      width: 13px;
    }

    .flex_system .item-y.mid {
      width: 25px;
    }

    .flex_system .item-y.tall {
      width: 50px;
    }

    .flex_system .text-item {
      font-family: system-ui, sans-serif;
      color: #ef4444;
      padding: 4px 6px;
      border-radius: 6px;
      font-weight: 600;
    }

    .flex_system .text-item.small {
      font-size: 8px;
    }

    .flex_system .text-item.mid {
      font-size: 14px;
    }

    .flex_system .text-item.tall {
      font-size: 30px;
    }
  </style>

  <div class="flex-ref">

    <div class="ref-section">
      <div class="ref-title">Flex Direction</div>
      <div class="ref-grid">

        <div>
          <div class="ref-box fx ref-items">
            <div class="item mid"></div>
            <div class="item tall"></div>
            <div class="item small"></div>
          </div>
          <div class="ref-label">fx</div>
        </div>

        <div>
          <div class="ref-box fy ref-items">
            <div class="item-y mid"></div>
            <div class="item-y tall"></div>
            <div class="item-y small"></div>
          </div>
          <div class="ref-label">fy</div>
        </div>

      </div>
    </div>
  </div>


  <h3 class="d-h3 demo">Flex (x-axis/align-items) Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex_x-axis1.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_x-axis2.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_x-axis3.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Align‑items controls how items align along the cross axis.<br>
    * In <b>fx</b>, this aligns items vertically.<br>
    * In <b>fy</b>, this aligns items horizontally.<br>
    * Stretch makes items fill the container along the cross axis.
    * Baseline aligns text baselines for a cohesive look.
  </p>

  <div class="flex-ref">

    <div class="ref-section">

      <div class="ref-title">Align Items fx</div>

      <div class="ref-grid-5">

        <div>
          <div class="ref-box fx f-left ref-items">
            <div class="item tall"></div>
            <div class="item mid"></div>
            <div class="item small"></div>
          </div>
          <div class="ref-label">f-left</div>
        </div>

        <div>
          <div class="ref-box fx f-center ref-items">
            <div class="item tall"></div>
            <div class="item mid"></div>
            <div class="item small"></div>
          </div>
          <div class="ref-label">f-center</div>
        </div>

        <div>
          <div class="ref-box fx f-right ref-items">
            <div class="item tall"></div>
            <div class="item mid"></div>
            <div class="item small"></div>
          </div>
          <div class="ref-label">f-right</div>
        </div>

        <div>
          <div class="ref-box fx f-stretch ref-items">
            <div class="item"></div>
            <div class="item"></div>
            <div class="item"></div>
          </div>
          <div class="ref-label">f-stretch</div>
        </div>

        <div>
          <div class="ref-box fx f-baseline ref-items">
            <span class="text-item tall">Aa</span>
            <span class="text-item mid">Aa</span>
            <span class="text-item small">Aa</span>
          </div>
          <div class="ref-label">f-baseline</div>
        </div>
      </div>
    </div>

    <div class="ref-section">

      <div class="ref-title">Align Items fy</div>
      <div class="ref-grid-5">

        <div>
          <div class="ref-box fy f-left ref-items">
            <div class="item-y tall"></div>
            <div class="item-y mid"></div>
            <div class="item-y small"></div>
          </div>
          <div class="ref-label">f-left</div>
        </div>

        <div>
          <div class="ref-box fy f-center ref-items">
            <div class="item-y tall"></div>
            <div class="item-y mid"></div>
            <div class="item-y small"></div>
          </div>
          <div class="ref-label">f-center</div>
        </div>

        <div>
          <div class="ref-box fy f-right ref-items">
            <div class="item-y tall"></div>
            <div class="item-y mid"></div>
            <div class="item-y small"></div>
          </div>
          <div class="ref-label">f-right</div>
        </div>

        <div>
          <div class="ref-box fy f-stretch ref-items">
            <div class="item-y"></div>
            <div class="item-y"></div>
            <div class="item-y"></div>
          </div>
          <div class="ref-label">f-stretch</div>
        </div>

        <div>
          <div class="ref-box fy f-baseline ref-items">
            <span class="text-item tall">Aa</span>
            <span class="text-item mid">Aa</span>
            <span class="text-item small">Aa</span>
          </div>
          <div class="ref-label">f-baseline</div>
        </div>

      </div>

    </div>
  </div>

  <h3 class="d-h3 demo">Flex (y-axis/justify-content) Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex_y-axis1.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_y-axis2.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_y-axis3.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Justify‑content controls positioning and spacing along the main axis.<br>
    * top aligns items to the start, middle centers them, and bottom aligns to the end.<br>
    * spread distributes space between items, around places space around items, and even distributes space
    evenly.<br>
    * Avoid combining positional alignment and space distribution at the same breakpoint.
  </p>

  <div class="flex-ref">

    <div class="ref-section">

      <div class="ref-title">Justify Content fx</div>
      <div class="ref-grid">

        <div>
          <div class="ref-box fx f-top ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-top</div>
        </div>

        <div>
          <div class="ref-box fx f-middle ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-middle</div>
        </div>

        <div>
          <div class="ref-box fx f-bottom ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-bottom</div>
        </div>

        <div>
          <div class="ref-box fx f-spread ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-spread</div>
        </div>

        <div>
          <div class="ref-box fx f-around ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-around</div>
        </div>

        <div>
          <div class="ref-box fx f-even ref-items">
            <div class="item tall"></div>
            <div class="item tall"></div>
            <div class="item tall"></div>
          </div>
          <div class="ref-label">f-even</div>
        </div>

      </div>
    </div>
    <div class="ref-section">

      <div class="ref-title">Justify Content fy</div>
      <div class="ref-grid">

        <div>
          <div class="ref-box fy f-top ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-top</div>
        </div>

        <div>
          <div class="ref-box fy f-middle ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-middle</div>
        </div>

        <div>
          <div class="ref-box fy f-bottom ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-bottom</div>
        </div>

        <div>
          <div class="ref-box fy f-spread ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-spread</div>
        </div>

        <div>
          <div class="ref-box fy f-around ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-around</div>
        </div>

        <div>
          <div class="ref-box fy f-even ref-items">
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
            <div class="item-y tall"></div>
          </div>
          <div class="ref-label">f-even</div>
        </div>

      </div>

    </div>
  </div>

  <h3 class="d-h3 demo">Flex (align-content) Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex_align-content1.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_align-content2.php'; ?></code></pre>
    <pre><code><?php include 'class/flex_align-content3.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Align‑content controls how multiple flex lines are positioned when items wrap.<br>
    * This property applies only to wrapped layouts with more than one line.<br>
    * Align‑content has no effect on single‑line flex layouts. <br>
    * Use align‑content to control vertical spacing of rows in <b>fx</b> or horizontal spacing of
    columns in <b>fy</b>. <br>
    * Avoid using align‑content with align‑items to prevent conflicting alignment rules.
  </p>

  <div class="flex-ref">

    <div class="ref-section">
      <div class="ref-title">Align Content fx</div>
      <div class="ref-grid">

        <div>
          <div class="ref-box fx f-lines-top f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-top <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box fx f-lines-middle f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-middle <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box fx f-lines-bottom f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-bottom <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box fx f-lines-spread f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-spread <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box fx f-lines-around f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-around <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box fx f-lines-even f-wrap ref-items">
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
            <div class="item mid"></div>
          </div>
          <div class="ref-label">f-lines-even <br> f-wrap</div>
        </div>

      </div>
    </div>

    <div class="ref-section">
      <div class="ref-title">Align Content fy</div>
      <div class="ref-grid">

        <div>
          <div class="ref-box fy f-lines-top f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lin f-wrapes-top</div>
        </div>

        <div>
          <div class="ref-box fy f-lines-middle f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lines-middle <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box fy f-lines-bottom f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lines-bottom <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box fy f-lines-spread f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lines-spread <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box fy f-lines-around f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lines-around <br> f-wrap</div>
        </div>

        <div>
          <div class="ref-box fy f-lines-even f-wrap ref-items">
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
            <div class="item-y mid"></div>
          </div>
          <div class="ref-label">f-lines-even <br> f-wrap</div>
        </div>

      </div>
    </div>
  </div>

</section>
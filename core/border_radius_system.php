<h2 class="d-h2 demo" id="border-radius-system">Border & Radius System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Prefixes</h3>

  <div class="d-cols">
    <pre><code><?php include 'prefix/border.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Border utilities provide a simple <b>1px, 2px, and 3px</b> thickness scale for consistent use across components. <br>
    * Borders are inactive by default <b>(border-width: 0)</b> and appear only when a width utility is explicitly applied. <br>
    * Border style is fixed to <b>solid</b> and color uses <b>currentColor</b>, keeping borders aligned with the <b>Color System</b> without extra utilities.
  </p>

  <h3 class="d-h3 demo">Border Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/border1.php'; ?></code></pre>
    <pre><code><?php include 'class/border2.php'; ?></code></pre>
    <pre><code><?php include 'class/border3.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Radius Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/radius.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Radius utilities provide a range of options for rounding corners, from subtle curves to fully rounded shapes.
  </p>

  <h3 class="d-h3 demo">Live Demo</h3>

  <style>
    .border-radius-system-demo {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 24px;
    }

    .border-radius-system-sample {
      aspect-ratio: 1 / 1;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      line-height: 1.2;
      text-align: center;
      font-weight: 500;
    }
  </style>

  <div class="border-radius-system-demo bg-g1 p-md ra-xl">

    <div class="border-radius-system-sample ra-full">
      ra-full
    </div>

    <div class="border-radius-system-sample bl-3 ra-full clr-main">
      bl-3 <br> ra-full <br> clr-main
    </div>

    <div class="border-radius-system-sample bw-2 ra-full clr-sub">
      bw-2<br>
      ra-full<br>
      clr-sub
    </div>

    <div class="border-radius-system-sample bl-3 br-3 bb-3 ra-full clr-g3">
      br-3 .
      bb-3 .
      bl-3<br>
      ra-full<br>
      clr-g3
    </div>


    <div class="border-radius-system-sample bl-3 br-3 bb-3 ra-md clr-g3">
      br-3 .
      bb-3 .
      bl-3<br>
      ra-md<br>
      clr-g3
    </div>

    <div class="border-radius-system-sample bw-3 ra-xl clr-g4">
      bw-3<br>
      ra-xl<br>
      clr-g4
    </div>

    <div class="border-radius-system-sample br-2">
      br-2<br>
    </div>

    <div class="border-radius-system-sample ra-xxs">
      ra-xxs<br>
    </div>

    <div class="border-radius-system-sample br-2 ra-xxs clr-main">
      br-2<br>
      ra-xxs<br>
      clr-main
    </div>

    <div class="border-radius-system-sample br-3 ra-sm clr-main">
      br-2<br>
      ra-sm<br>
      clr-main
    </div>

    <div class="border-radius-system-sample bw-1 ra-xl">
      bw-1<br>
      ra-xl
    </div>

    <div class="border-radius-system-sample bt-1 br-3 bb-2 ra-sm clr-sub">
      bt-1 .
      br-3 .
      bb-2<br>
      ra-sm<br>
      clr-sub
    </div>

  </div>


</section>
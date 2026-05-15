<h2 class="d-h2 demo" id="margin-auto-system">Margin Auto System</h2>

<section class="d-section">

  <h3 class="d-h3 demo">Margin Auto Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/m-auto1.php'; ?></code></pre>
    <pre><code><?php include 'class/m-auto2.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Margin auto utilities provide layout alignment behavior instead of fixed spacing. <br>
    * These values do not use the spacing scale and only take effect when free space is available.
  </p>

  <h3 class="d-h3 demo">Live Demo</h3>

  <div class="grid gap-sm bg-g1 ra-lg p-lg">

    <div class="dp-12 flex-y gap-xxs">
      <span class="fs-14px fw-600 clr-g8">ml-auto (push right)</span>

      <div class="grid gap-sm">

        <div class="dp-6 tb-12 flex-y gap-xxs">
          <div class="flex-x gap-xs p-sm bg-white ra-sm">
            <div class="p-xs bg-sub clr-white ra-xs">.</div>
            <div class="p-xs bg-sub clr-white ra-xs">.</div>
          </div>
        </div>

        <div class="dp-6 tb-12 flex-y gap-xxs">
          <div class="flex-x gap-xs p-sm bg-white ra-sm">
            <div class="p-xs bg-sub clr-white ra-xs">.</div>
            <div class="p-xs bg-sub clr-white ra-xs ml-auto">ml-auto</div>
          </div>
        </div>

      </div>
    </div>

    <div class="dp-12 flex-y gap-xxs">
      <span class="fs-14px fw-600 clr-g8">mx-auto (center block)</span>

      <div class="grid gap-sm">

        <div class="dp-6 tb-12 flex-y gap-xxs">
          <div class="p-sm bg-white ra-sm">
            <div class="mw-200 p-xs bg-sub clr-white ra-xs ta-center">
              .
            </div>
          </div>
        </div>

        <div class="dp-6 tb-12 flex-y gap-xxs">
          <div class="p-sm bg-white ra-sm">
            <div class="mw-200 mx-auto p-xs bg-sub clr-white ra-xs ta-center">
              mx-auto
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="dp-12 flex-y gap-xxs">
      <span class="fs-14px fw-600 clr-g8">
        mt-auto (push down), Need fixed height (180px).
      </span>

      <div class="grid gap-sm">

        <div class="dp-6 tb-12 flex-y gap-xxs">
          <div class="flex-y p-sm bg-white ra-sm" style="height:180px;">
            <div class="p-xs bg-sub clr-white ra-xs ta-center">.</div>
            <div class="p-xs bg-sub clr-white ra-xs ta-center">.</div>
          </div>
        </div>

        <div class="dp-6 tb-12 flex-y gap-xxs">
          <div class="flex-y p-sm bg-white ra-sm" style="height:180px;">
            <div class="p-xs bg-sub clr-white ra-xs ta-center">.</div>
            <div class="p-xs bg-sub clr-white ra-xs ta-center mt-auto">mt-auto</div>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>
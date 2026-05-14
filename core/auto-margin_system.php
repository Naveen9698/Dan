<h2 class="d-h2 demo" id="auto-margin-system">Auto Margin System</h2>

<section class="d-section">

  <h3 class="d-h3 demo">Auto Margin Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/m-auto1.php'; ?></code></pre>
    <pre><code><?php include 'class/m-auto2.php'; ?></code></pre>
  </div>

  <p class="d-note">
    * Auto margin utilities provide layout alignment behavior instead of fixed spacing. <br>
    * These values do not use the spacing scale and only take effect when free space is available.
  </p>

  <h3 class="d-h3 demo">Live Demo</h3>

  <div class="flex-y gap-md">

    <!-- Example 1: ml-auto -->
    <div class="flex-x gap-xs p-sm" style="background:#1a1a1a;">
      <div class="p-xs bg-main clr-white ra-6">Item</div>
      <div class="p-xs bg-main clr-white ra-6 ml-auto">
        ml-auto → pushed right
      </div>
    </div>

    <!-- Example 2: mr-auto -->
    <div class="flex-x gap-xs p-sm" style="background:#1a1a1a;">
      <div class="p-xs bg-main clr-white ra-6 mr-auto">
        mr-auto → pushed left
      </div>
      <div class="p-xs bg-main clr-white ra-6">Item</div>
    </div>

    <!-- Example 3: mx-auto -->
    <div class="p-sm" style="background:#1a1a1a;">
      <div class="mw-400 mx-auto p-xs bg-main clr-white ra-6 text-center">
        mx-auto → centered block
      </div>
    </div>

    <!-- Example 4: mt-auto (vertical push) -->
    <div class="flex-y p-sm" style="background:#1a1a1a; height:180px;">
      <div class="p-xs bg-main clr-white ra-6">Top</div>
      <div class="p-xs bg-main clr-white ra-6 mt-auto">
        mt-auto → pushed down
      </div>
    </div>

  </div>

</section>
<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="cursor-system">Cursor System</h2>

<section class="px-md stack-y-sm">

  <h3>Cursor Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/cursor.php'; ?></code></pre>
  </div>

  <h3>Helper Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/cursor-helper.php'; ?></code></pre>
  </div>

<p class="fs-14 clr-g5 lh-16 ml-md">
  🟢 <b>cur-* utilities</b> control <b>cursor behavior</b> (interaction feedback), not layout or spacing.<br>
  🟢 <b>cur-pointer</b> is used for clickable elements (buttons, links, cards).<br>
  🟢 <b>cur-text</b> is used for editable content (inputs, text areas).<br>
  🟢 <b>cur-na</b> indicates disabled or blocked actions.<br>
  🟡 Should match real interaction — cursor must reflect actual behavior.<br>
  🟡 Many elements (button, input, link) already have default cursor behavior.<br>
  🔴 Avoid adding pointer to non-clickable elements — it creates misleading UX.
</p>

  <h3>Live Demo</h3>

  <div class="bg-white pa-sm stack-y-md ra-sm sw-sm">
    <?php include 'demo/cursor-system.php'; ?>
  </div>
</section>
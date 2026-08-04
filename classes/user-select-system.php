<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="user-select-system">User Select System</h2>

<section class="px-md stack-y-sm">

  <h3>User Select Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/user-select.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>uselect-auto</b> uses the browser's default text selection behavior<br>
    🟢 <b>uselect-none</b> prevents users from selecting text and is commonly used for buttons, controls and interactive UI elements<br>
    🟢 <b>uselect-all</b> automatically selects the entire content when any part is selected<br>
    🟢 <b>uselect-text</b> explicitly enables text selection and can override inherited restrictions<br>
    🟡 Use <b>uselect-all</b> for code snippets, URLs, API keys and copyable content<br>
    🟡 Use <b>uselect-none</b> sparingly as users often expect text to remain selectable<br>
    🔴 User selection utilities control selection behavior only and do not affect keyboard focus or accessibility
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/user-select-system.php'; ?>

</section>
<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="list-system">List System</h2>

<section class="px-md stack-y-sm">

  <h3>List Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/li-style-type.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/li-style-position.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>li-none</b> removes list markers and is commonly used for menus, navigation and custom components<br>
    🟢 <b>li-disc</b>, <b>li-circle</b> and <b>li-square</b> provide unordered list markers<br>
    🟢 <b>li-decimal</b>, <b>li-lalpha</b>, <b>li-ualpha</b>, <b>li-lroman</b> and <b>li-uroman</b> provide ordered list markers<br>
    🟢 <b>li-inside</b> places markers inside the content flow<br>
    🟢 <b>li-outside</b> places markers outside the content flow and is the browser default<br>
    🟡 List marker styles rarely need responsive variants and are typically consistent across all screen sizes<br>
    🟡 List marker utilities can be applied to both <b>&lt;ul&gt;</b> and <b>&lt;ol&gt;</b> elements <br>
    🟡 Marker appearance is controlled by CSS while list semantics are determined by the HTML element <br>
    🟢 Use unordered markers (disc, circle, square) with &ltul&gt and ordered markers (decimal, alpha, roman) with &ltol&gt for best semantic accessibility <br>
    🔴 List utilities affect marker appearance and marker positioning only. Item spacing, indentation and layout are controlled by spacing and layout utilities.
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/list-system.php'; ?>


  <h3>Custom List Content Variables</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>:root {<?php include 'root/list.php'; ?>

}</code></pre>
  </div>

  <h3>List Content Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/li-content.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>li-symbol</b> replaces default list markers with a custom symbol defined through the <b>--li-symbol</b> variable<br>
    🟢 <b>li-img</b> replaces default list markers with a custom image defined through the <b>--li-img</b> variable<br>
    🟢 Symbols and images can be changed per project without modifying framework utilities<br>
    🟢 Useful for checklists, navigation menus, feature lists, branding elements and custom UI components<br>
    🟢 Supports project-specific SVG, PNG, WebP and other browser-supported image formats through CSS variables<br>
    🟡 The framework provides the rendering engine while the project controls the displayed symbol or image through variables<br>
    🟢 Additional marker styles can be introduced by updating variables rather than creating new utility classes<br>
    🔴 List content utilities affect marker appearance only and do not control spacing, indentation or layout behavior
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/list-content.php'; ?>

</section>
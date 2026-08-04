<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="resize-system">Resize System</h2>

<section class="px-md stack-y-sm">

  <h3>Resize Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/resize.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>resize-none</b> prevents users from resizing an element<br>
    🟢 <b>resize-both</b> allows horizontal and vertical resizing<br>
    🟢 <b>resize-x</b> allows horizontal resizing only<br>
    🟢 <b>resize-y</b> allows vertical resizing only<br>
    🟢 Commonly used with textareas, editors, panels and custom content regions<br>
    🟡 Resize handles may appear differently across browsers and operating systems <br>
    🟡 Resize behavior is most effective when combined with overflow utilities<br>
    🔴 Resize utilities affect user resizing behavior only and do not control element dimensions directly
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/resize-system.php'; ?>

</section>
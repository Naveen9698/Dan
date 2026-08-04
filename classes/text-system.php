<h2 class="fz-28 fw-700 clr-g9 bg-g2 txt-center pa-xs" id="text-system">Text System</h2>

<section class="px-md stack-y-sm">

  <h3>Text Align Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/text-align.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 990px) {
<?php include 'class-tb/text-align.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 770px) {
<?php include 'class-mb/text-align.php'; ?>

}</code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>txt-left</b> aligns text to the left edge of its container<br>
    🟢 <b>txt-center</b> centers text horizontally within its container<br>
    🟢 <b>txt-right</b> aligns text to the right edge of its container<br>
    🟢 <b>txt-start</b> aligns text to the natural reading start (left in LTR, right in RTL)<br>
    🟢 <b>txt-end</b> aligns text to the natural reading end (right in LTR, left in RTL)<br>
    🟡 <b>txt-justify</b> stretches lines to fill available width and works best for longer paragraphs<br>
    🔴 Text alignment affects content placement only and does not control Flex or Grid alignment
  </p>

  <h3>Align Live Demo</h3>

  <?php include 'demo/text-align.php'; ?>

  <h3>Text Vertical Align Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/text-vertical-align.php'; ?></code></pre>
  </div>

  <p class="fz-14 clr-g5 lh-16 ml-md">
    🟢 txt-top, txt-middle and txt-bottom control the vertical alignment of the element they are applied to.<br>
    🟢 Commonly used with icons, images, badges, inline-block elements and table cells.<br>
    🟡 The surrounding text does not move — the aligned element shifts relative to the current text line.<br>
    🟡 Effects are most noticeable when elements have different sizes.<br>
    🟢 The demo intentionally uses a larger icon beside smaller text to exaggerate the behavior.<br>
    🔴 Vertical alignment does not affect Flex or Grid layouts.
  </p>


  <h3>Vertical Align Live Demo</h3>

  <?php include 'demo/text-vertical-align.php'; ?>

  <h3>Text Direction Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/text-direction.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>txt-ltr</b> displays content from left to right, commonly used for English and most western languages<br>
    🟢 <b>txt-rtl</b> displays content from right to left, commonly used for Arabic and Hebrew<br>
    🟢 Direction directly affects logical utilities such as <b>txt-start</b> and <b>txt-end</b><br>
    🟡 Apply direction to content containers rather than individual words whenever possible<br>
    🔴 Direction changes reading flow only and does not affect Flex or Grid layout behavior
  </p>

  <h3>Direction Live Demo</h3>

  <?php include 'demo/text-direction.php'; ?>

  <h3>Text Transform Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/text-transform.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>txt-uppercase</b> converts all letters to uppercase characters<br>
    🟢 <b>txt-lowercase</b> converts all letters to lowercase characters<br>
    🟢 <b>txt-capitalize</b> converts the first letter of each word to uppercase<br>
    🟢 <b>txt-transform-none</b> displays text using its original casing<br>
    🟢 Useful for labels, buttons, badges, navigation items and consistent UI presentation<br>
    🔴 Text transformation changes appearance only and does not modify the underlying text value
  </p>


  <h3>Transform Live Demo</h3>

  <?php include 'demo/text-transform.php'; ?>

  <h3>Text Decoration Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/text-decoration.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>txt-underline</b> draws a line beneath the text and is commonly used for links and emphasis<br>
    🟢 <b>txt-overline</b> draws a line above the text for special visual emphasis<br>
    🟢 <b>txt-line-through</b> draws a line through the text and is often used for discounts or completed items<br>
    🟢 <b>txt-decoration-none</b> removes decoration lines from decorated text such as links<br>
    🟡 Decoration utilities are mutually exclusive — the last utility wins<br>
    🔴 Decoration changes appearance only and does not affect layout or text behavior
  </p>

  <h3>Decoration Live Demo</h3>

  <?php include 'demo/text-decoration.php'; ?>

  <h3>Text Style Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/text-style.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 txt-italic displays text using an italic font style and is commonly used for quotes, references and emphasis<br>
    🟢 txt-style-none removes italic styling and restores normal text style<br>
    🟡 Font Style utilities are intentionally grouped within the Text System because they affect text presentation<br>
    🔴 Font Style utilities affect text appearance only and do not modify font family, font weight or layout behavior
  </p>

  <h3>Style Live Demo</h3>

  <?php include 'demo/text-style.php'; ?>

  <h3>Text Wrap Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/text-wrap.php'; ?></code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>txt-nowrap</b> forces text to remain on a single line even when space runs out<br>
    🟢 <b>txt-break</b> allows long words, URLs and unbroken strings to split across multiple lines when necessary<br>
    🟡 <b>txt-break</b> is useful for user-generated content, links and dynamic data<br>
    🔴 Wrap utilities control text flow only and do not resize or reposition elements
  </p>

  <h3>Wrap Live Demo</h3>

  <?php include 'demo/text-wrap.php'; ?>

  <h3>Text Ellipsis Engine</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'engine/text-ellipsis.php'; ?></code></pre>
  </div>

  <h3>Text Ellipsis Utility Classes</h3>

  <div class="flex-x gap-md f-wrap">
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code><?php include 'class/text-ellipsis.php'; ?></code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 990px) {
<?php include 'class-tb/text-ellipsis.php'; ?>

}</code></pre>
    <pre class="bg-g9 clr-white ra-sm pa-xs fz-12 lh-16"><code>@media (max-width: 770px) {
<?php include 'class-mb/text-ellipsis.php'; ?>

}</code></pre>
  </div>

  <p class="g-12 fz-14 clr-g5 lh-16 ml-md">
    🟢 <b>ellipsis-1</b> limits content to a single line and displays an ellipsis (...) when text overflows<br>
    🟢 <b>ellipsis-2</b>, <b>ellipsis-3</b>, <b>ellipsis-4</b> and <b>ellipsis-5</b> limit content to a fixed number of visible lines<br>
    🟢 Useful for cards, product grids, article previews, tables and dynamic content layouts<br>
    🟢 Helps maintain consistent component heights when content length varies<br>
    🟡 Requires constrained width to produce visible truncation<br>
    🔴 Hidden content is not removed — only visually clipped from display
  </p>

  <h3>Ellipsis Live Demo</h3>

  <?php include 'demo/text-ellipsis.php'; ?>

</section>
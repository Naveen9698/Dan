<h2 class="fs-28 fw-700 clr-g9 bg-g2 ta-center pa-xs" id="flex-system">Flex System</h2>

<section class="px-md stack-y-sm flex-system">
  <h3>Presets</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex.php'; ?></code></pre>
  </div>

  <h3>Helper Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex-helper.php'; ?></code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 Flex system controls <b>flow and alignment</b>, not structure or spacing.<br>
    🟢 Combine with <b>grid</b> for layout structure and <b>gap / spacing</b> for spacing.<br>
    🔴 Using flex for everything may reduce clarity and maintainability. <br>
    🟢 <b>flex-x / flex-y</b> create flex containers with row or column flow.<br>
    🟡 <b>f-fill</b> allows items to grow and occupy available space.<br>
    🟢 Items align to <b>start by default</b> and <b>wrap when needed</b>.<br>
    🟡 Use <b>f-no-wrap</b> to force a single line layout.
  </p>

  <h3>Flex Direction Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex-direction.php'; ?></code></pre>
    <pre><code>@media (max-width: 990px) {
<?php include 'class-tb/flex-direction.php'; ?>

}</code></pre>
    <pre><code>@media (max-width: 770px) {
<?php include 'class-mb/flex-direction.php'; ?>

}</code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>flex-x</b> = horizontal flow · <b>flex-y</b> = vertical flow.<br>
    🟢 Direction defines the <b>main axis</b> of the layout.<br>
    🟡 Responsive variants (<b>tb / mb</b>) override direction at breakpoints.<br>
    🔴 Changing direction changes how alignment behaves — use with awareness.
  </p>

  <h3>Flex (x-axis/align-items) Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex-x-axis.php'; ?></code></pre>
    <pre><code>@media (max-width: 990px) {
<?php include 'class-tb/flex-x-axis.php'; ?>

}</code></pre>
    <pre><code>@media (max-width: 770px) {
<?php include 'class-mb/flex-x-axis.php'; ?>

}</code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>f-left / f-center / f-right</b> align items on the <b>cross axis</b>.<br>
    🟡 Alignment depends on <b>flex direction</b>: <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- In flex-x → f-left/f-center/f-right align vertically <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- In flex-y → f-left/f-center/f-right align horizontally <br>
    🟢 In <b>flex-x</b> → vertical alignment · in <b>flex-y</b> → horizontal alignment.<br>
    🟢 <b>f-stretch</b> expands items to fill available cross-axis space.<br>
    🟢 <b>f-baseline</b> aligns items based on text baseline (useful for mixed font sizes).<br>
    🔴 Baseline alignment may appear inconsistent if content sizes vary heavily.<br>
    🔴 Misunderstanding axis direction may cause unexpected alignment results.
  </p>

  <h3>Flex (y-axis/justiflex-y-content) Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex-y-axis.php'; ?></code></pre>
    <pre><code>@media (max-width: 990px) {
<?php include 'class-tb/flex-y-axis.php'; ?>

}</code></pre>
    <pre><code>@media (max-width: 770px) {
<?php include 'class-mb/flex-y-axis.php'; ?>

}</code></pre>
  </div>
  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>f-top / f-middle / f-bottom</b> position items on the <b>main axis</b>.<br>
    🟡 f-top / f-middle / f-bottom always follow the <b>main axis</b> (direction) <br>
    🟢 <b>f-spread</b> → space between items only (no space on edges).<br>
    🟢 <b>f-around</b> → equal space around items (edges get half space).<br>
    🟢 <b>f-even</b> → equal spacing everywhere (including edges).<br>
    🔴 Do not mix positioning and spacing utilities at the same breakpoint.<br>
    🟡 Space distribution depends on available free space.
  </p>

  <h3>Flex (align-content) Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/flex-align-content.php'; ?></code></pre>
    <pre><code>@media (max-width: 990px) {
<?php include 'class-tb/flex-align-content.php'; ?>

}</code></pre>
    <pre><code>@media (max-width: 770px) {
<?php include 'class-mb/flex-align-content.php'; ?>

}</code></pre>
  </div>

  <p class="fs-14 clr-g5 lh-16 ml-md">
    🟢 <b>f-lines-*</b> controls alignment of multiple flex rows/columns.<br>
    🟢 Works only when <b>items wrap</b> into more than one line.<br>
    🔴 Has no effect on single-line layouts.<br>
    🟡 Avoid mixing with <b>align-items</b> — may create conflicting alignment.
  </p>

  <h3>Live Demo</h3>

  <?php include 'demo/flex-system.php'; ?>

</section>
<h2 class="d-h2 demo" id="color-system">Color System</h2>

<section class="d-section">
  <h3 class="d-h3 demo">Variables</h3>
  <div class="d-cols">
    <pre><code>:root {
<?php include 'root/color.php'; ?>

}</code></pre>
  </div>
  <p class="d-note">
    * The color system is based on a set of CSS variables that define the main, sub, and neutral colors, as well as their respective shades. <br>
    * These variables can be easily customized to create a unique color palette for the project. <br>
    * The utility classes provide a convenient way to apply these colors to the elements, ensuring consistency across the design. <br>
    * By using the color system, you can maintain a cohesive and visually appealing design while also allowing for flexibility and customization.
  </p>

  <h3 class="d-h3 demo">Utility Classes</h3>

  <div class="d-cols">
    <pre><code><?php include 'class/color1.php'; ?></code></pre>
    <pre><code><?php include 'class/color2.php'; ?></code></pre>
  </div>

  <h3 class="d-h3 demo">Live Demo</h3>

  <?php include 'demo/color_system.php'; ?>

</section>
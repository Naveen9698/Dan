:root {
  <?php
foreach (glob('core/root/*.php') as $file) {
    include $file;
}
?>

}


<?php
foreach (glob('core/class/*.php') as $file) {
    include $file;
}
?>
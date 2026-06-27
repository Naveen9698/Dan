:root {
<?php
foreach (glob('classes/root/*.php') as $file) {
    include $file;
}
?>

}

@media (max-width: 990px) {
    :root {
<?php
foreach (glob('classes/root-tb/*.php') as $file) {
    include $file;
}
?>

    }
}

@media (max-width: 770px) {
    :root {
<?php
foreach (glob('classes/root-mb/*.php') as $file) {
    include $file;
}
?>

    }
}

<?php
foreach (glob('classes/engine/*.php') as $file) {
    include $file;
}
?>

<?php
foreach (glob('classes/class/*.php') as $file) {
    include $file;
}
?>

@media (max-width: 990px) {
<?php
foreach (glob('classes/class-tb/*.php') as $file) {
    include $file;
}
?>

}

@media (max-width: 770px) {
<?php
foreach (glob('classes/class-mb/*.php') as $file) {
    include $file;
}
?>

}
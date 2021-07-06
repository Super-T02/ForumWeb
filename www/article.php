<?php
require_once "src/Theme.php";

try {
    if (isset($_GET['themeID'])) $title = Theme::loadByID($_GET['themeID'])->getHeadline();
    else $title = "";
} catch (Exception $e) {
    $title = "";
}

$active = "n";
require_once "include/head.php";


?>
<!--Start content-->
<div class="article">
    <?php
        require_once "include/theme-feed.php";
    ?>
</div>
<!--End content-->
<?php
require_once "include/foot.php";
?>

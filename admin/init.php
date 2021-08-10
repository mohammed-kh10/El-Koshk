<?php include 'config.php';
// path
// path
$tpl = 'include/templates/';
$lang = 'include/languages/';
$func = 'include/functions/';
$css = 'layout/css/';
$js = 'layout/js/';

// include function file
include $func . 'function.php';
// include english language file
include $lang . 'en.php';

// include arabic language file
include $lang . 'ar.php';


// include navbar and header pages
if (!isset($noHeader)) { include $tpl . 'header.php'; }
if (!isset($noDashNavBar)) { include $tpl . 'dashNav.php'; }

?>
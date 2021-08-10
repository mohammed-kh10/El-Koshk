<?php
// Error Reporting
ini_set('display_error' , 'On');
error_reporting(E_ALL);

$sessionUser = '';
if (isset($_SESSION['user'])) {
    $sessionUser = $_SESSION['user'];
}

include 'admin/config.php';
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

// include navbar file
include $tpl . 'nav.php';

// include header file
if (!isset($noHeader)) { include $tpl . 'header.php'; }



?>
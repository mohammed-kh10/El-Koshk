<?php
session_start();
$noDashNavBar = '';
$pageTitle = 'El Koshk';


if (isset($_SESSION['userName'])) {
    header('Location: dashboard.php'); // redirct to dashboard page
}

include 'init.php';

?>

<?php include $tpl . 'footer.php';?>
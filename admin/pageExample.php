<?php
/*
===========================================
== Manage --Name-- Page
===========================================
*/
ob_start(); // Start Buferring Output

session_start();

if (isset($_SESSION['userName'])) {
    $pageTitle = '';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // start manage page
    if ($do == 'manage') { // manage page 


    }elseif ($do == 'add') { // Add page


    }elseif ($do == 'insert') { // insert page


    }elseif ($do == 'edit') { // edit page 


    }elseif ($do == 'update') { // update page


    }elseif ($do == 'delete') { // delete page


    }elseif ($do == 'activate') { // activate page 


    }

    include $tpl . 'footer.php';

}else {
    header('Location: index.php');
    exit();
}

ob_end_flush();
?>
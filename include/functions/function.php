<?php
// User Section
// User Section

/*
** v1.2
** Get All function 
** function to get all from database [users | items | comments | and more...]
*/
function getAllFrom ($col , $tableName , $where = null , $and = null , $orderBy = null , $ordering = 'DESC') {
    global $con;

    $getAll = $con->prepare("SELECT $col FROM $tableName $where $and ORDER BY $orderBy $ordering");
    $getAll->execute();
    $all = $getAll->fetchAll();
    return $all;
}
// ===============================
// ===============================

/*
** v1.0
** Check If User IS Not Active
** Function To Check RegStatus Of The User 
**
**
*/
function checkUserStatus($user) {
    global $con;
    $stmt = $con -> prepare("SELECT
                                Name , RegStatus
                            FROM
                                users
                            WHERE
                                Name = ?
                            AND
                                RegStatus = 0");
    $stmt->execute(array($user));
    $status = $stmt -> rowCount();

    return $status;
}
// =================================
// =================================

/*
** v 1.0.0
** function to check item in database or not [function accept parameters]
** select = the item to select     [example : user || item || category || and more...]
** from = the table to select from [example : users || items || categories || and more...]
** value = the value of select     [example : mohammed || whatch || clothes || and more...]
*/
function checkItem($select , $from , $value) {
    global $con;
    $statement = $con -> prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count;
}
// ===================================================
// ===================================================










// admin section
// admin section
/*
** v 1.0.0
** title function that echo the page title
** in case the page has the variable $pageTitle
** And echo default title for other pages 
*/
function getTitle() {
    global $pageTitle;

    if (isset($pageTitle)) {
        echo $pageTitle;
    }else {
        echo 'Default';
    }
}
// ===================================================
// ===================================================

/* 
** v 1.1
** Home Redirect function [this function accept parameter]
** Message = print the message [Error | success | warning ]
** seconds = Seconfs before redirect
** url = the link you want to redirecting to
*/
function redirect($message , $url = null , $seconds = 3) {
    if ($url == null) {
        $url = 'index.php';
        $link = 'Home Page';
    }else {
        
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'previous Page';
        }else {
            $url = 'index.php';
            $link = 'Home Page';
        }
    }
    echo $message;
    echo "<div class='container alert alert-info'>You Will Be Redirected To $link After $seconds Seconds</div>";
    header("refresh:$seconds;url=$url");
    exit();
}
// ===================================================
// ===================================================



/*
** v1.0
** count number of items function
** function to count number of item rows
** item = the item to count 
** table = the table choose from
*/
function countItems($item , $table) {
    global $con;

    $stmt = $con->prepare("SELECT COUNT($item) FROM $table");
    $stmt->execute();
    return $stmt->fetchColumn();
}
// ===================================================
// ===================================================

/*
** v1.0
** Get latest record function 
** function to get latest record items from database [users | items | comments | and more...]
** select = field to select
** table = the table to choose from
** limit = number to record get
** order = the order for your record
*/
function getLatest ($select , $table , $order ,$limit = 5) {
    global $con;

    $stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC Limit $limit");
    $stmt->execute();
    $rows = $stmt->fetchAll();
    return $rows;
}

?>
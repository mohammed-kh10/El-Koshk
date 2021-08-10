<?php
/*
===========================================
== Manage Comments Page
== You Can Add || Delete || Edit || and More... Members From Here
===========================================
*/
session_start();

if (isset($_SESSION['userName'])) {
    $noHeader = '';
    $pageTitle = 'Comments';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // start manage page
    if ($do == 'manage') { // manage page 

        $stmt = $con->prepare("SELECT
                                        comments.* ,
                                        items.Name AS ItemName,
                                        users.Name AS UserName
                                    FROM
                                        comments
                                    INNER JOIN
                                        items
                                    ON
                                        items.ItemId = comments.ItemId
                                    INNER JOIN
                                        users
                                    ON
                                        users.UserId = comments.UserId
                                    ORDER BY ComId Desc");
        $stmt->execute();
        // Assign the values in variables
        $rows = $stmt->fetchAll();
    ?>
        <section class="container-fluid comments">
            <h1>Manage Comments</h1>
            <div class="container-fluid">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <tr class="table-warning table-row">
                            <td>Id</td>
                            <td>Comment</td>
                            <td>Item Name</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>Control</td>
                        </tr>

                        <?php foreach($rows as $row){?>
                        
                        <tr class="table-sm">
                            <td><?= $row['ComId']?></td>
                            <td><?= $row['Comment']?></td>
                            <td><?= $row['ItemName']?></td>
                            <td><?= $row['UserName']?></td>
                            <td><?= $row['ComDate']?></td>
                            <td>
                                <a href="comments.php?do=edit&comId=<?= $row['ComId']?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                <a href="comments.php?do=delete&comId=<?= $row['ComId']?>" class="btn btn-danger confirm"><i class="fa fa-times-circle"></i> Delete</a>
                                <?php 
                                if ($row['Status'] == 0) { ?>
                                    <a href="comments.php?do=approve&comId=<?= $row['ComId']?>" class="btn btn-info"><i class="fa fa-check"></i> Approve</a>
                                <?php }

                                ?>
                            </td>
                        </tr>
                        <?php }?>
                    </table>
                </div><!-- table responsive -->
            </div><!-- container -->
        </section>
    <?php

    }elseif ($do == 'edit') { // edit page 
        // check if get request comment id is numeric & get the integer value of it
        $comId = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;

        $stmt = $con -> prepare("SELECT * FROM comments WHERE ComId = ?");
        $stmt->execute(array($comId));
        $row = $stmt -> fetch();
        $count = $stmt -> rowCount();

        if ($count > 0) { ?>
        <section class="container comments">
            <h1>Edit Comment</h1>

            <div class="container">
                <form action="?do=update" method="POST" class="form-horizontal">
                    <input type="hidden" name="comId" value="<?= $comId?>">
                    <!-- start comment -->
                    <div class="form-group">
                        <label for="comment" class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-10">
                            <textarea name="comment" id="comment" cols="30" rows="6" class="form-control" required="required"><?= $row['Comment']?></textarea>
                        </div>
                    </div><!-- form group -->
                    <!-- end comment -->

                    <!-- start submit button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Save" id="save" class="btn btn-warning">
                        </div>
                    </div><!-- form group -->
                    <!-- end submit button -->
                </form>
            </div><!-- container -->
        </section><!-- end of members edit page -->

        <?php }else {
            // message for error id
            echo '<div class="container">';
                $theMsg ='<div class="alert alert-danger">sorrrrrrrry Theres no such This Id <strong>Get Out</strong></div>';
                redirect($theMsg);
            echo '</div>';
            }
            
        }elseif ($do == 'update') {
        // update page
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
            <div class="container comments">
                    <h1>Update Comment</h1>
        <?php   $comId = $_POST['comId'];
                $comment = $_POST['comment'];

                // update the data 
                $stmt = $con->prepare("UPDATE
                                            comments
                                        SET
                                            Comment = ?
                                        WHERE
                                            ComId = ?");
                $stmt->execute(array($comment , $comId));
                // should be $id variable in last variable in array

                // print success message
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Udate</>';
                    redirect($theMsg , 'back');
        ?></div><?php
        }else {
                // message for error id 
                echo '<div class="container">';
                    $theMsg =' sorrrrrrrry you can not brows this page directly <strong>Get Out</strong> ';
                    redirect($theMsg , 'back');
                echo '</div>';
        }
    }elseif ($do == 'delete') {
        // check if get request comment id is numeric & get the integer value of it
        $comId = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;
        $check = checkItem("ComId" , "comments" , $comId);

        if ($check > 0) {?>
            <div class="container comments">
                    <h1>Delete Comment</h1>
    <?php   $stmt = $con->prepare("DELETE FROM comments WHERE ComId = :zcomid");
            $stmt->bindparam(":zcomid" , $comId);
            $stmt->execute();

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
                redirect($theMsg , 'back');

        }else {
            // message for error id 
                $theMsg ='<div class="alert alert-danger"> sorrrrrrrry Theres no such This Id <strong>Get Out</strong> </div>';
                redirect($theMsg , 'back');
        }
        ?></div><?php
    }elseif ($do == 'approve') { // activate page 
        // check if get request comment id is numeric & get the integer value of it
        $comId = isset($_GET['comId']) && is_numeric($_GET['comId']) ? intval($_GET['comId']) : 0;
        $check = checkItem("ComId" , "Comments" , $comId);

        if ($check > 0) {?>
            <div class="container comments">
                    <h1>Approve Comment</h1>
        <?php   $stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE ComId = ?");
                $stmt->execute(array($comId));
            
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Comment Approved</div>';
                redirect($theMsg , 'back');
            
        }else {
            // message for error id 
                $theMsg ='<div class="alert alert-success"> sorrrrrrrry Theres no such This Id <strong>Get Out</strong> </div>';
                redirect($theMsg);
        }
        ?></div><?php
    }
    
    include $tpl . 'footer.php';
}else {
    header('Location: index.php');
    exit();
}
?>
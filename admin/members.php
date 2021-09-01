<?php
/*
===========================================
== Manage Members Page
== You Can Add || Delete || Edit || and More... Members From Here
===========================================
*/
session_start();

if (isset($_SESSION['userName'])) {
    $noHeader = '';
    $pageTitle = 'Members';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // start manage page
    if ($do == 'manage') { // manage page 
        $query = '';

        if (isset($_GET['page']) && $_GET['page'] == 'pending') {
            $query = 'And RegStatus = 0';
        }

        $stmt = $con->prepare("SELECT * FROM users WHERE GroupId != 1 $query ORDER BY UserId Desc");
        $stmt->execute();
        // Assign the values in variables
        $rows = $stmt->fetchAll();
    ?>
        <section class="container members">
            <h1>Manage Members</h1>
            <a href="members.php?do=add" class="btn btn-primary addMember">Add New User +</a>
            <div class="container">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <tr class="table-info table-row">
                            <td>Id</td>
                            <td>Avatar</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Full Name</td>
                            <td>Registered Date</td>
                            <td>Control</td>
                        </tr>

                        <?php foreach($rows as $row){?>
                        
                        <tr class="table-sm">
                            <td><?= $row['UserId']?></td>

                            <td class="image">
                            <?php
                                if (!empty($row['Image'])) { ?>
                                    <img src="../data/uploads/images/<?= $row['Image']?>" alt="">
                                <?php }else { ?>
                                    <img src="../data/uploads/images/defaultProfileImage.jpg" alt="">
                                <?php } ?>
                            </td>
                            
                            <td><?= $row['Name']?></td>
                            <td><?= $row['Email']?></td>
                            <td><?= $row['FullName']?></td>
                            <td><?= $row['Date']?></td>
                            <td>
                                <a href="members.php?do=edit&userId=<?= $row['UserId']?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                <a href="members.php?do=delete&userId=<?= $row['UserId']?>" class="btn btn-danger confirm"><i class="fa fa-times-circle"></i> Delete</a>
                                <?php 
                                if ($row['RegStatus'] == 0) { ?>
                                    <a href="members.php?do=activate&userId=<?= $row['UserId']?>" class="btn btn-info"><i class="fa fa-check"></i> Activate</a>
                                <?php }

                                ?>
                            </td>
                        </tr>
                        <?php }?>
                    </table>
                </div><!-- table responsive -->
            </div><!-- container -->
        </section>
    <?php }elseif ($do == 'add') { // Add page ?>
        <section class="container members">
            <h1>Add New Member</h1>

            <div class="container">
                <form action="?do=insert" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    <!-- start user Name -->
                    <div class="form-group">
                        <label for="userName" class="col-sm-2 control-label">User Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="userName" id="userName" class="form-control" required placeholder="User Name To Login">
                        </div>
                    </div><!-- form group -->
                    <!-- end user Name -->

                    <!-- start password -->
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" id="password" class="password form-control" required placeholder="Password Must Be Hard & Complex">
                            <i class="show-password fa fa-eye fa-2x"></i>
                        </div>
                    </div><!-- form group -->
                    <!-- end password -->

                    <!-- start email -->
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" id="email" class="form-control" required placeholder="Email Must Be Vaild">
                        </div>
                    </div><!-- form group -->
                    <!-- end email -->

                    <!-- start full Name -->
                    <div class="form-group">
                        <label for="fullName" class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="fullName" id="fullName" class="form-control" required placeholder="Full Name Will Be Appear In Your Profile Page">
                        </div>
                    </div><!-- form group -->
                    <!-- end full Name -->

                    <!-- start image -->
                    <div class="form-group">
                        <label for="image" class="col-sm-2 control-label">User Avatar</label>
                        <div class="col-sm-10">
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                    </div><!-- form group -->
                    <!-- end image -->

                    <!-- start submit button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add" id="add Member" class="btn btn-danger">
                        </div>
                    </div><!-- form group -->
                    <!-- end submit button -->
                </form>
            </div><!-- container -->
        </section><!-- end of members Add page -->

        <?php
        
    }elseif ($do == 'insert') {
        // insert member page
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
            <div class="container members">
                    <h1>Insert Member</h1>
                    
        <?php   $name = $_POST['userName'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                $fullName = $_POST['fullName'];

                $hashPassword = sha1($password);

                // uploade Variables
                $imageName  = $_FILES['image']['name'];
                $imageSize  = $_FILES['image']['size'];
                $imageTmp   = $_FILES['image']['tmp_name'];
                $imageType  = $_FILES['image']['type'];

                // list of Allowed file type to uploaded
                $imageAllowedExtension = array("jpg" , "jpeg" , "png");

                // get image extension
                $imageExtensionExplode = explode(' ' , $imageName);
                $imageExtension = strtolower(end($imageExtensionExplode));
                
                // validate the form
                // validate the form
                $formErrors = array();
                if (strlen($name) < 4) {
                    $formErrors[] = 'User Name Can not be <strong>less than 4 characters</strong>'; 
                }

                if (strlen($name) > 30) {
                    $formErrors[] = 'User Name Can not be <strong>greater than 30 characters</strong>'; 
                }

                if (empty($name)) {
                    $formErrors[] = 'User Name Can not be <strong>Empty</strong>';
                }

                if (empty($password)) {
                    $formErrors[] = 'Password Can not be <strong>Empty</strong>';
                }

                if (empty($email)) {
                    $formErrors[] = 'Email Can not be <strong>Empty</strong>';
                }

                if (empty($fullName)) {
                    $formErrors[] = 'Full Name Can not be <strong>Empty</strong>';
                }

                if (!empty($imageName) && in_array($imageExtension , $imageAllowedExtension)) {
                    $formErrors[] = 'This Extention Is Not <strong>Allowed</strong>';
                }

                if ($imageSize > 5194304) {
                    $formErrors[] = "Image Can't Be Larger Than <strong>5MB</strong>";
                }
    
                foreach($formErrors as $error){
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
                
                // check if there's no errors procced the update data
                if (empty($formErrors)) {
                    $image = '';
                    if (!empty($imageName)) {
                        $image = rand(0 , 100000) . '_' . $imageName;
                        move_uploaded_file($imageTmp , '../data/uploads/images/' . $image);
                    }

                    // check if user exist in database or not
                    $check = checkItem("Name" , "users" , $name);
                    if ($check == 1) {
                        
                            $theMsg =' sorrrrrrrry this user is exist <strong>Get Out</strong> ';
                            redirect($theMsg , 'back');
                        
                        }else {
                        
                        // insert the data 
                        $stmt = $con->prepare("INSERT INTO 
                                                users(Name , Password , Email , FullName , RegStatus , Date , Image)
                                                VALUES (:zname , :zpassword , :zemail , :zfullName , 1 , now() , :zimage)");
                        $stmt->execute(array(
                            'zname' => $name,
                            'zpassword' => $hashPassword,
                            'zemail' => $email,
                            'zfullName' => $fullName,
                            'zimage' => $image
                        ));
                        // should be $id variable in last variable in array
    
                        // print success message
                        
                            $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record inserted</div>';
                            redirect($theMsg , 'back');
                        
                    }
                }
            ?></div><?php
            }else {
                $theMsg ='<div class="alert alert-danger"> sorrrrrrrry You can not brows this page directly <strong>Get Out</strong> </div>';
                redirect($theMsg);
            }
    }elseif ($do == 'edit') { // edit page 
        // check if get request user id is numeric & get the integer value of it
        $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;

        $stmt = $con -> prepare("SELECT * FROM users WHERE UserId = ? LIMIT 1");
        $stmt->execute(array($userId));
        $row = $stmt -> fetch();
        $count = $stmt -> rowCount();

        if ($count > 0) { ?>
        <section class="container members">
            <h1>Edit Member</h1>

            <div class="container">
                <form action="?do=update" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="userId" value="<?= $userId?>">
                    <!-- start user Name -->
                    <div class="form-group">
                        <label for="userName" class="col-sm-2 control-label">User Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="userName" id="userName" class="form-control" value="<?= $row['Name']?>" required = "required">
                        </div>
                    </div><!-- form group -->
                    <!-- end user Name -->

                    <!-- start password -->
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="hidden" name="oldPassword" id="password" value="<?= $row['Password']?>">
                            <input type="password" name="newPassword" id="password" class="form-control" placeholder="Leave Blank If You Don't Want TO Change">
                        </div>
                    </div><!-- form group -->
                    <!-- end password -->

                    <!-- start email -->
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" id="email" class="form-control" value="<?= $row['Email']?>" required = "required">
                        </div>
                    </div><!-- form group -->
                    <!-- end email -->

                    <!-- start full Name -->
                    <div class="form-group">
                        <label for="fullName" class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="fullName" id="fullName" class="form-control" value="<?= $row['FullName']?>" required = "required">
                        </div>
                    </div><!-- form group -->
                    <!-- end full Name -->

                    <!-- start image -->
                    <div class="form-group">
                        <label for="image" class="col-sm-2 control-label">User Avatar</label>
                        <div class="col-sm-10">
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                    </div><!-- form group -->
                    <!-- end image -->

                    <!-- start submit button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Save" id="save" class="btn btn-danger">
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
            <div class="container members">
                    <h1>Update Member</h1>
        <?php   $id = $_POST['userId'];
                $name = $_POST['userName'];
                $email = $_POST['email'];
                $fullName = $_POST['fullName'];

                // password Trick
                $password = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);

                // uploade Variables
                $imageName  = $_FILES['image']['name'];
                $imageSize  = $_FILES['image']['size'];
                $imageTmp   = $_FILES['image']['tmp_name'];
                $imageType  = $_FILES['image']['type'];

                // list of Allowed file type to uploaded
                $imageAllowedExtension = array("jpg" , "jpeg" , "png");

                // get image extension
                $imageExtensionExplode = explode(' ' , $imageName);
                $imageExtension = strtolower(end($imageExtensionExplode));

                // validate the form
                // validate the form
                $formErrors = array();
                if (strlen($name) < 4) {
                    $formErrors[] = 'User Name Can not be <strong>less than 4 characters</strong>'; 
                }
    
                if (strlen($name) > 30) {
                    $formErrors[] = 'User Name Can not be <strong>greater than 30 characters</strong>'; 
                }
    
                if (empty($name)) {
                    $formErrors[] = 'User Name Can not be <strong>Empty</strong>';
                }
    
                if (empty($email)) {
                    $formErrors[] = 'Email Can not be <strong>Empty</strong>';
                }
    
                if (empty($fullName)) {
                    $formErrors[] = 'Full Name Can not be <strong>Empty</strong>';
                }

                if (!empty($imageName) && in_array($imageExtension , $imageAllowedExtension)) {
                    $formErrors[] = 'This Extention Is Not <strong>Allowed</strong>';
                }

                if ($imageSize > 5194304) {
                    $formErrors[] = "Image Can't Be Larger Than <strong>5MB</strong>";
                }
    
                foreach($formErrors as $error){
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
                // check if there's no errors procced the update data
                if (empty($formErrors)) {
                    $image = '';
                    if (!empty($imageName)) {
                        $image = rand(0 , 100000) . '_' . $imageName;
                        move_uploaded_file($imageTmp , '../data/uploads/images/' . $image);
                    }

                    $stmt2 = $con -> prepare("SELECT
                                                    *
                                                FROM
                                                    users
                                                WHERE
                                                    Name = ?
                                                AND
                                                    UserId != ?");
                    $stmt2->execute(array($name , $id));
                    $count = $stmt2->rowCount();
                    if ($count == 1) {
                        // message for error id 
                        echo '<div class="container">';
                            $theMsg =' sorrrrrrrry This User Is Exist <strong>Get Out</strong> ';
                            redirect($theMsg , 'back');
                        echo '</div>';
                    }else {
                        // update the data 
                        $stmt = $con->prepare("UPDATE
                                                    users
                                                SET
                                                    Name = ? ,
                                                    Password = ? ,
                                                    Email = ? ,
                                                    FullName = ? ,
                                                    Image = ?
                                                WHERE
                                                    UserId = ?");
                        $stmt->execute(array($name , $password , $email , $fullName , $image , $id));
                        // should be $id variable in last variable in array

                        // print success message
                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Udate</>';
                        redirect($theMsg , 'back');
                    }
                }
                ?></div><?php
            }else {
                // message for error id 
                echo '<div class="container">';
                    $theMsg =' sorrrrrrrry you can not brows this page directly <strong>Get Out</strong> ';
                    redirect($theMsg , 'back');
                echo '</div>';
            }
    }elseif ($do == 'delete') {
        // check if get request user id is numeric & get the integer value of it
        $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;
        $check = checkItem("UserId" , "users" , $userId);

        /*
        $stmt = $con -> prepare("SELECT * FROM users WHERE UserId = ? LIMIT 1");
        $stmt->execute(array($userId));
        $count = $stmt -> rowCount();
        */
        if ($check > 0) {?>
            <div class="container members">
                    <h1>Delete Member</h1>
    <?php   $stmt = $con->prepare("DELETE FROM users WHERE UserId = :zuserid");
            $stmt->bindparam(":zuserid" , $userId);
            $stmt->execute();
            
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
                redirect($theMsg , 'back');
            
        }else {
            // message for error id 
                $theMsg =' sorrrrrrrry Theres no such This Id <strong>Get Out</strong> ';
                redirect($theMsg);
            }
        ?></div><?php
    }elseif ($do == 'activate') { // activate page 
        // check if get request user id is numeric & get the integer value of it
        $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;
        $check = checkItem("UserId" , "users" , $userId);

        /*
        $stmt = $con -> prepare("SELECT * FROM users WHERE UserId = ? LIMIT 1");
        $stmt->execute(array($userId));
        $count = $stmt -> rowCount();
        */
        if ($check > 0) {?>
            <div class="container members">
                    <h1>Activate Member</h1>
    <?php   $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserId = ?");
            $stmt->execute(array($userId));
            
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated</div>';
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
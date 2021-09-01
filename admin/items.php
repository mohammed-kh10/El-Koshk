<?php
/*
===========================================
== Manage --Items-- Page
== 
===========================================
*/
ob_start(); // Start Buferring Output

session_start();

if (isset($_SESSION['userName'])) {
    $noHeader = '';
    $pageTitle = 'Items';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // start manage page
    if ($do == 'manage') { // manage page 

        $stmt = $con->prepare("SELECT
                                    items.* ,
                                    categories.Name AS CatName ,
                                    users.Name AS UserName
                                FROM
                                    items
                                INNER JOIN
                                    categories
                                ON
                                    categories.CatId = items.CatId
                                INNER JOIN
                                    users
                                ON
                                    users.UserId = items.UserId
                                    ORDER BY ItemId Desc");
        $stmt->execute();
        // Assign the values in variables
        $items = $stmt->fetchAll();
    ?>
        <section class="items">
            <h1>Manage Items</h1>
            <a href="items.php?do=add" class="btn addItems">Add New Item +</a>
            <div class="">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <tr class="table-success table-row">
                            <td>Id</td>
                            <td>Image</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Country Of Made</td>
                            <td>Adding Date</td>
                            <td>Category</td>
                            <td>Member</td>
                            <td>Control</td>

                        </tr>
                        
                        <?php foreach($items as $item){?>
                        
                        <tr class="table-sm">
                            <td><?= $item['ItemId']?></td>
                            
                            <td class="image">
                            <?php
                            if (!empty($item['Image'])) { ?>
                                <img src="../data/uploads/images/<?=$item['Image']?>" alt="">
                            <?php }else {?>
                                <img src="../data/uploads/images/defaultItemImage.jpg" alt="">
                            <?php } ?>
                            </td>
                            <td><?= $item['Name']?></td>
                            <td><?= $item['Description']?></td>
                            <td><?= $item['Price']?></td>
                            <td><?= $item['CountryMade']?></td>
                            <td><?= $item['AddDate']?></td>
                            <td><?= $item['CatName']?></td>
                            <td><?= $item['UserName']?></td>
                            <td>
                                <a href="items.php?do=edit&itemId=<?= $item['ItemId']?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                <a href="items.php?do=delete&itemId=<?= $item['ItemId']?>" class="btn btn-danger confirm"><i class="fa fa-times-circle"></i></a>
                            <?php 
                                if ($item['Approve'] == 0) { ?>
                                    <a href="items.php?do=approve&itemId=<?= $item['ItemId']?>" class="btn btn-info"><i class="fa fa-check"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php }?>
                    </table>
                </div><!-- table responsive -->
            </div><!-- container -->
        </section>
    <?php

    }elseif ($do == 'add') { // Add page // Add page ?>
        <section class="container-fluid items">
            <h1>Add New Items</h1>

            <div class="container">
                <form action="?do=insert" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    <!-- start Item Name -->
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control" required = "required" placeholder="Item Name">
                        </div>
                    </div><!-- form group -->
                    <!-- end Item Name -->

                    <!-- start Description -->
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="description" id="description" class="form-control" required = "required" placeholder="Item Description">
                        </div>
                    </div><!-- form group -->
                    <!-- end Description -->

                    <!-- start price -->
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10">
                            <input type="text" name="price" id="price" class="form-control" required = "required" placeholder="Item price">
                        </div>
                    </div><!-- form group -->
                    <!-- end price -->

                    <!-- start country -->
                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10">
                            <input type="text" name="country" id="country" class="form-control" required = "required" placeholder="Item Country Of Made">
                        </div>
                    </div><!-- form group -->
                    <!-- end country -->

                    <!-- start status -->
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <select name="status" id="status">
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Old</option>
                            </select>
                        </div>
                    </div><!-- form group -->
                    <!-- end status -->

                    <!-- start member -->
                    <div class="form-group">
                        <label for="member" class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10">
                            <select name="member" id="member">
                                <option value="0">...</option>
                                <?php
                                    $allMembers = getAllFrom ("*" , "users" , "" , "" , "UserId");
                                    foreach ($allMembers as $user){
                                        echo '<option value="' . $user['UserId'] . '">' . $user['Name'] . '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div><!-- form group -->
                    <!-- end member -->

                    <!-- start category -->
                    <div class="form-group">
                        <label for="category" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10">
                            <select name="category" id="category">
                                <option value="0">...</option>
                                <?php
                                    $allCats = getAllFrom ("*" , "categories" , "WHERE Parent = 0" , "" , "CatId");
                                    foreach ($allCats as $cat){
                                        echo '<option value="' . $cat['CatId'] . '">' . $cat['Name'] . '</option>';
                                        $childCats = getAllFrom ("*" , "categories" , "WHERE Parent = {$cat['CatId']}" , "" , "CatId");
                                        foreach ($childCats as $child){
                                            echo '<option value="' . $child['CatId'] . '"> --- ' . $child['Name'] . ' ' . 'Child From' . ' ' . $cat['Name'] . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div><!-- form group -->
                    <!-- end categories -->

                    <!-- start Tags -->
                    <div class="form-group">
                        <label for="tags" class="col-sm-2 control-label">Tags</label>
                        <div class="col-sm-10">
                            <input type="text" name="tags" id="tags" class="form-control" placeholder="Separate Tegs With Comma ( , )">
                        </div>
                    </div><!-- form group -->
                    <!-- end Tags -->

                    <!-- start image -->
                    <div class="form-group">
                        <label for="image" class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-10">
                            <input type="file" name="image" id="image" class="form-control btn btn-secondary">
                        </div>
                    </div><!-- form group -->
                    <!-- end image -->

                    <!-- start submit button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Item" id="add" class="btn btn-success">
                        </div>
                    </div><!-- form group -->
                    <!-- end submit button -->
                </form>
            </div><!-- container -->
        </section><!-- end of categories Add page -->

        <?php
        
    }elseif ($do == 'insert') { // insert page
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
        <div class="container-fluid items">
                <h1>Insert Items</h1>

    <?php   
            // uploads files
            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageType  = $_FILES['image']['type'];

            // list of Allowed file type to uploaded
            $imageAllowedExtension = array("jpg" , "jpeg" , "png");

            // get image extension
            $imageExtensionExplode = explode(' ' , $imageName);
            $imageExtension = strtolower(end($imageExtensionExplode));
            
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $category = $_POST['category'];
            $member = $_POST['member'];
            $tags = $_POST['tags'];

            // validate the form
            // validate the form
            $formErrors = array();

            if (empty($name)) {
                $formErrors[] = 'Item Name Can not be <strong>Empty</strong>';
            }

            if (empty($description)) {
                $formErrors[] = 'Item Description Can not be <strong>Empty</strong>';
            }

            if (empty($price)) {
                $formErrors[] = 'Item Price Can not be <strong>Empty</strong>';
            }

            if (empty($country)) {
                $formErrors[] = 'Item Country Can not be <strong>Empty</strong>';
            }

            if ($status == 0) {
                $formErrors[] = 'You Must Choose The <strong>Item Status</strong>';
            }

            if ($member == 0) {
                $formErrors[] = 'You Must Choose The <strong>Item Member</strong>';
            }

            if ($category == 0) {
                $formErrors[] = 'You Must Choose The <strong>Item Category</strong>';
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
                    $image = rand(0 , 10000000) . '_' . $imageName;
                    move_uploaded_file($imageTmp , '../data/uploads/images/' . $image);
                }

                // insert the data 
                $stmt = $con->prepare("INSERT INTO 
                items
                    (Name , Description , Price , CountryMade , Status , AddDate , CatId , UserId , Tags , Image)
                VALUES
                    (:zname , :zdescription , :zprice , :zcountry , :zstatus , now() , :zcat , :zuser , :ztags , :zimage)");
                $stmt->execute(array(
                    'zname' => $name,
                    'zdescription' => $description,
                    'zprice' => $price,
                    'zcountry' => $country,
                    'zstatus' => $status,
                    'zcat' => $category,
                    'zuser' => $member,
                    'ztags' => $tags,
                    'zimage' => $image,
                ));
                // should be $id variable in last variable in array

                // print success message
                
                    $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record inserted</div>';
                    redirect($theMsg , 'back');
            }
        ?></div><?php
        }else {
            $theMsg ='<div class="alert alert-danger"> sorrrrrrrry You can not brows this page directly <strong>Get Out</strong> </div>';
            redirect($theMsg);
        }

    }elseif ($do == 'edit') { // edit page 
        // check if get request item id is numeric & get the integer value of it
        $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;

        $stmt = $con -> prepare("SELECT * FROM items WHERE ItemId = ?");
        $stmt->execute(array($itemId));
        $item = $stmt -> fetch();
        $count = $stmt -> rowCount();

        if ($count > 0) { ?>
        <section class="container-fluid items">
            <h1>Edit Item</h1>

            <div class="container">
                <form action="?do=update" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="itemId" value="<?= $itemId?>">
                    <!-- start Item Name -->
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control" required = "required" placeholder="Item Name" value="<?= $item['Name']?>">
                        </div>
                    </div><!-- form group -->
                    <!-- end Item Name -->

                    <!-- start Description -->
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="description" id="description" class="form-control" required = "required" placeholder="Item Description" value="<?= $item['Description']?>">
                        </div>
                    </div><!-- form group -->
                    <!-- end Description -->

                    <!-- start price -->
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10">
                            <input type="text" name="price" id="price" class="form-control" required = "required" placeholder="Item price" value="<?= $item['Price']?>">
                        </div>
                    </div><!-- form group -->
                    <!-- end price -->

                    <!-- start country -->
                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10">
                            <input type="text" name="country" id="country" class="form-control" required = "required" placeholder="Item Country Of Made" value="<?= $item['CountryMade']?>">
                        </div>
                    </div><!-- form group -->
                    <!-- end country -->

                    <!-- start status -->
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <select name="status" id="status">
                                <option value="1" <?php if($item['Status'] == 1){echo 'selected';}?>>New</option>
                                <option value="2" <?php if($item['Status'] == 2){echo 'selected';}?>>Like New</option>
                                <option value="3" <?php if($item['Status'] == 3){echo 'selected';}?>>Used</option>
                                <option value="4" <?php if($item['Status'] == 4){echo 'selected';}?>>Old</option>
                            </select>
                        </div>
                    </div><!-- form group -->
                    <!-- end status -->

                    <!-- start member -->
                    <div class="form-group">
                        <label for="member" class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10">
                            <select name="member" id="member">
                                <?php
                                    $stmt = $con->prepare("SELECT * FROM users");
                                    $stmt -> execute();
                                    $users = $stmt->fetchAll();
                                    foreach ($users as $user){ ?>
                                        <option value="<?= $user['UserId']?>"
                                        <?php if($item['UserId'] == $user['UserId']){echo 'selected';}?>>
                                        <?= $user['Name']?></option>
                                    <?php }
                                ?>
                            </select>
                        </div>
                    </div><!-- form group -->
                    <!-- end member -->

                    <!-- start category -->
                    <div class="form-group">
                        <label for="category" class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10">
                            <select name="category" id="category">
                                <?php
                                    $stmt = $con->prepare("SELECT * FROM categories");
                                    $stmt -> execute();
                                    $cats = $stmt->fetchAll();
                                    foreach ($cats as $cat){ ?>
                                        <option value="<?= $cat['CatId']?>"
                                        <?php if($item['CatId'] == $cat['CatId']){echo 'selected';}?>>
                                        <?= $cat['Name']?></option>
                                    <?php }
                                ?>
                            </select>
                        </div>
                    </div><!-- form group -->
                    <!-- end categories -->

                    <!-- start Tags -->
                    <div class="form-group">
                        <label for="tags" class="col-sm-2 control-label">Tags</label>
                        <div class="col-sm-10">
                            <input type="text" name="tags" id="tags" class="form-control" placeholder="Separate Tegs With Comma ( , )" value="<?= $item['Tags']?>">
                        </div>
                    </div><!-- form group -->
                    <!-- end Tags -->

                    <!-- start image -->
                    <div class="form-group">
                        <label for="image" class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-10">
                            <input type="file" name="image" id="image" class="form-control btn btn-secondary">
                        </div>
                    </div><!-- form group -->
                    <!-- end image -->

                    <!-- start submit button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Save Item" id="add" class="btn btn-success">
                        </div>
                    </div><!-- form group -->
                    <!-- end submit button -->
                </form>

                <!-- comments section -->
                <!-- comments section -->
            <?php $stmt = $con->prepare("SELECT
                                    comments.* ,
                                    users.Name AS UserName
                                FROM
                                    comments
                                INNER JOIN
                                    users
                                ON
                                    users.UserId = comments.UserId
                                WHERE
                                    ItemId = ?");
                $stmt->execute(array($itemId));
                // Assign the values in variables
                $rows = $stmt->fetchAll();
                if (!empty($rows)) { ?>
                <section class="comments">
                    <h1>Manage [ <?= $item['Name']?> ] Comments</h1>
                    <div class="table table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <tr class="table-warning table-row">
                                <td>Comment</td>
                                <td>User Name</td>
                                <td>Added Date</td>
                                <td>Control</td>
                            </tr>

                            <?php foreach($rows as $row){?>
                            <tr class="table-sm">
                                <td><?= $row['Comment']?></td>
                                <td><?= $row['UserName']?></td>
                                <td><?= $row['ComDate']?></td>
                                <td>
                                    <a href="comments.php?do=edit&comId=<?= $row['ComId']?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="comments.php?do=delete&comId=<?= $row['ComId']?>" class="btn btn-danger confirm"><i class="fa fa-times-circle"></i> Delete</a>
                                    <?php 
                                    if ($row['Status'] == 0) { ?>
                                        <a href="comments.php?do=approve&comId=<?= $row['ComId']?>" class="btn btn-info"><i class="fa fa-check"></i> Approve</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php }?>
                        </table>
                    </div><!-- table responsive -->
                </section>
                <?php } ?>
            </div><!-- container -->
        </section><!-- end of items edit page -->

        <?php }else {
            // message for error id
            echo '<div class="container">';
                $theMsg ='<div class="alert alert-danger">sorrrrrrrry Theres no such This Id <strong>Get Out</strong></div>';
                redirect($theMsg);
            echo '</div>';
        }

    }elseif ($do == 'update') { // update page
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
            <div class="container-fluid items">
                    <h1>Update Item</h1>

        <?php   
        
            // uploads files
            $imageName = $_FILES['image']['name'];
            $imageSize = $_FILES['image']['size'];
            $imageTmp = $_FILES['image']['tmp_name'];
            $imageType  = $_FILES['image']['type'];

            // list of Allowed file type to uploaded
            $imageAllowedExtension = array("jpg" , "jpeg" , "png");

            // get image extension
            $imageExtensionExplode = explode(' ' , $imageName);
            $imageExtension = strtolower(end($imageExtensionExplode));

            $id = $_POST['itemId'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $category = $_POST['category'];
            $member = $_POST['member'];
            $tags = $_POST['tags'];

            // validate the form
            // validate the form
            $formErrors = array();

            if (empty($name)) {
                $formErrors[] = 'Item Name Can not be <strong>Empty</strong>';
            }

            if (empty($description)) {
                $formErrors[] = 'Item Description Can not be <strong>Empty</strong>';
            }

            if (empty($price)) {
                $formErrors[] = 'Item Price Can not be <strong>Empty</strong>';
            }

            if (empty($country)) {
                $formErrors[] = 'Item Country Can not be <strong>Empty</strong>';
            }

            if ($status == 0) {
                $formErrors[] = 'You Must Choose The <strong>Item Status</strong>';
            }

            if ($member == 0) {
                $formErrors[] = 'You Must Choose The <strong>Item Member</strong>';
            }

            if ($category == 0) {
                $formErrors[] = 'You Must Choose The <strong>Item Category</strong>';
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
                    $image = rand(0 , 10000000) . '_' . $imageName;
                    move_uploaded_file($imageTmp , '../data/uploads/images/' . $image);
                }

                // update the data 
                $stmt = $con->prepare("UPDATE
                                            items
                                        SET
                                            Name = ? ,
                                            Description = ? ,
                                            Price = ? ,
                                            CountryMade = ? ,
                                            Status = ? ,
                                            CatId = ? ,
                                            UserId = ? ,
                                            Tags = ? ,
                                            Image = ?
                                        WHERE
                                            ItemId = ?");
                $stmt->execute(array($name , $description , $price , $country , $status , $category , $member , $tags , $image , $id));
                // should be $id variable in last variable in array
    
                // print success message
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Udate</div>';
                    redirect($theMsg , 'back');
            }
            ?></div><?php
            }else {
                // message for error id 
                echo '<div class="container>';
                    $theMsg =' sorrrrrrrry you can not brows this page directly <strong>Get Out</strong> ';
                    redirect($theMsg , 'back');
                echo '</div>';
            }
    }elseif ($do == 'delete') { // delete page
        // check if get request user id is numeric & get the integer value of it
        $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;
        $check = checkItem("ItemId" , "items" , $itemId);

        /*
        $stmt = $con -> prepare("SELECT * FROM users WHERE UserId = ? LIMIT 1");
        $stmt->execute(array($userId));
        $count = $stmt -> rowCount();
        */
        if ($check > 0) {?>
            <div class="container-fluid">
                <section class="items">
                    <h1>Delete Item</h1>
                </section><!-- end of member update page -->
    <?php   $stmt = $con->prepare("DELETE FROM items WHERE ItemId = :zitemid");
            $stmt->bindparam(":zitemid" , $itemId);
            $stmt->execute();
            
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
                redirect($theMsg , 'back');
            
        }else {
            // message for error id 
            
                $theMsg =' sorrrrrrrry Theres no such This Id <strong>Get Out</strong> ';
                redirect($theMsg);
            
            }
        ?></div><?php
    }elseif ($do == 'approve') { // approve page
        // check if get request item id is numeric & get the integer value of it
        $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;
        $check = checkItem("ItemId" , "items" , $itemId);

        /*
        $stmt = $con -> prepare("SELECT * FROM users WHERE UserId = ? LIMIT 1");
        $stmt->execute(array($userId));
        $count = $stmt -> rowCount();
        */
        if ($check > 0) {?>
            <div class="container-fluid items">
                    <h1>Approve Item</h1>
    <?php   $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE ItemId = ?");
            $stmt->execute(array($itemId));
            
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Approved</div>';
                redirect($theMsg , 'back');
            
        }else {
            // message for error id 
                $theMsg ='<div class="alert alert-success"> sorrrrrrrry Theres no such This Id <strong>Get Out</strong></div>';
                redirect($theMsg , 'back');
        }
        ?></div><?php
    }

    include $tpl . 'footer.php';

}else {
    header('Location: index.php');
    exit();
}

ob_end_flush();
?>
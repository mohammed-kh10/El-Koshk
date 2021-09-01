<?php
/*
===========================================
== Manage Categories Page
===========================================
*/
    ob_start(); // Start Buferring Output

    session_start();

if (isset($_SESSION['userName'])) {
    $noHeader = '';
    $pageTitle = 'Categories';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

    // start manage page
    if ($do == 'manage') { // manage page 
        $sort = 'ASC';
        $sortArrar = array('ASC' , 'DESC');
        if (isset($_GET['sort']) && in_array($_GET['sort'] , $sortArrar)) {
            $sort = $_GET['sort'];
        }
        $stmt = $con->prepare("SELECT * FROM categories WHERE Parent = 0 ORDER BY Ordering $sort");
        $stmt->execute();
        $cats = $stmt->fetchAll();
        
        ?>
        <section class="container-fluid categories">
            <h1>Manage Categories</h1>
            <a href="categories.php?do=add" class="btn btn-danger addCategories">Add New categories +</a>
            <div class="container">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="text-secondary"><i class="fa fa-edit"></i> Manage Categories</h3>
                        <div class="option fa-pull-right">
                            <i class="fa fa-sort"></i> Ordering : [
                            <a href="?sort=ASC" class="<?php if ($sort == 'ASC'){echo 'active';} ?>">ASC</a>
                            <a href="?sort=DESC" class="<?php if ($sort == 'DESC'){echo 'active';} ?>">DESC</a> ]
                            
                            <i class="fa fa-eye"></i> View : [
                            <span class="active" data-view="full">Full</span>
                            <span data-view="classic">Classic</span> ]
                        </div><!-- ordering -->
                    </div><!-- panel heading -->

                    <div class="panel-body">
                        <?php
                        foreach($cats as $cat){ ?>
                            <div class="cat">
                                <div class="hidden-btn">
                                    <a href="categories.php?do=edit&catId=<?= $cat['CatId']?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="categories.php?do=delete&catId=<?= $cat['CatId']?>" class="btn btn-xs btn-danger confirm"><i class="fa fa-times"></i> Delete</a>
                                </div><!-- hidden btn -->

                                <h3><?= $cat['Name']?><br></h3>
                                <div class="full-view">
                                <p><?php if($cat['Description'] == ''){
                                    echo 'This Category Has No Description';
                                }else {
                                    echo $cat['Description'];
                                }
                                ?><br></p>
                                    <?php if($cat['Visibility'] == 1){?><span class="properties bg-danger"><i class="fa fa-eye"></i> Hidden</span><?php }?>
                                    <?php if($cat['AllowComment'] == 1){?><span class="properties bg-dark"><i class="fa fa-times"></i> Comment disabled</span><?php }?>
                                    <?php if($cat['AllowAds'] == 1){?><span class="properties bg-secondary"><i class="fa fa-times"></i> Ads disabled</span><?php }?>
                                
                                    <!-- Get Child Categories -->
                                    <div class="childs">
                                        <?php
                                        $childCats = getAllFrom("*" , "categories" , "WHERE Parent = {$cat['CatId']}" , "" , "CatId");
                                        if (!empty($childCats)) { ?>
                                            <h4>Child Categories : </h4>
                                            <ul class="list-unstyled">
                                            <?php foreach ($childCats as $child){ ?>
                                                <li class="child-link">
                                                    <a href="categories.php?do=edit&catId=<?= $child['CatId']?>" class="btn btn-xs btn-secondary"><?= $child['Name']?></a>
                                                    <a href="categories.php?do=delete&catId=<?= $child['CatId']?>" class="btn btn-xs btn-danger confirm show-delete"><i class="fa fa-times"></i></a>
                                                </li>
                                            <?php }
                                        } ?>
                                        </ul>
                                    </div><!-- child -->
                                </div><!-- full view -->

                                <div class="line"></div>

                            </div><!-- categories -->
                        <?php } ?>
                    </div><!-- panel  body-->
                </div><!-- panel -->
            </div><!-- container -->
        </section><!-- categories -->
    <?php

    }elseif ($do == 'add') { // Add page ?>
        <section class="container-fluid categories">
            <h1>Add New Category</h1>

            <div class="container">
                <form action="?do=insert" method="POST" class="form-horizontal">
                    <!-- start cat Name -->
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control" required = "required" placeholder="category Name">
                        </div>
                    </div><!-- form group -->
                    <!-- end cat Name -->

                    <!-- start Description -->
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="description" id="description" class="form-control" placeholder="The Category Description">
                        </div>
                    </div><!-- form group -->
                    <!-- end Description -->

                    <!-- start ordering -->
                    <div class="form-group">
                        <label for="ordering" class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10">
                            <input type="text" name="ordering" id="ordering" class="form-control" placeholder="Number To Arrange The Categories">
                        </div>
                    </div><!-- form group -->
                    <!-- end ordering -->

                    <!-- start Category Type -->
                    <div class="form-group">
                        <label for="ordering" class="col-sm-2 control-label">Parent</label>
                        <div class="col-sm-10">
                            <select name="parent" id="parent">
                                <option value="0">None</option>
                                <?php
                                $allCats = getAllFrom ("*" , "categories" , "WHERE Parent = 0" , "" , "CatId");
                                foreach ($allCats as $cat){ ?>
                                    <option value="<?= $cat['CatId']?>"><?= $cat['Name']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div><!-- form group -->
                    <!-- end Category Type -->

                    <!-- start visible -->
                    <div class="form-group">
                        <label for="visible" class="col-sm-2 control-label">Visible</label>
                        <div class="col-sm-10">
                            <div>
                                <input type="radio" name="visible" id="visible-yes" value="0" checked>
                                <label for="visible-yes">Yes</label>

                                <input type="radio" name="visible" id="visible-no" value="1">
                                <label for="visible-no">No</label>
                            </div>
                        </div>
                    </div><!-- form group -->
                    <!-- end visible -->

                    <!-- start comment -->
                    <div class="form-group">
                        <label for="comment" class="col-sm-2 control-label">Allow Commenting</label>
                        <div class="col-sm-10">
                            <div>
                                <input type="radio" name="comment" id="comment-yes" value="0" checked>
                                <label for="comment-yes">Yes</label>

                                <input type="radio" name="comment" id="comment-no" value="1">
                                <label for="comment-no">No</label>
                            </div>
                        </div>
                    </div><!-- form group -->
                    <!-- endcomment -->

                    <!-- start Ads -->
                    <div class="form-group">
                        <label for="ads" class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10">
                            <div>
                                <input type="radio" name="ads" id="ads-yes" value="0" checked>
                                <label for="ads-yes">Yes</label>

                                <input type="radio" name="ads" id="ads-no" value="1">
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div><!-- form group -->
                    <!-- end Ads -->

                    <!-- start submit button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Category" id="add" class="btn btn-info">
                        </div>
                    </div><!-- form group -->
                    <!-- end submit button -->
                </form>
            </div><!-- container -->
        </section><!-- end of categories Add page -->

        <?php
        
    }elseif ($do == 'insert') { // insert page
        // insert categories page
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
            <div class="container-fluid">
                <section class="categories">
                    <h1>Add Category</h1>
                </section><!-- end of categories update page -->
    
        <?php   $name        = $_POST['name'];
                $description = $_POST['description'];
                $parent      = $_POST['parent'];
                $ordering    = $_POST['ordering'];
                $visible     = $_POST['visible'];
                $comment     = $_POST['comment'];
                $ads         = $_POST['ads'];

                // check if Category exist in database or not
                $check = checkItem("Name" , "categories" , $name);
                if ($check == 1) {
                    
                        $theMsg ='<div class="alert alert-danger">sorrrrrrrry this Category is exist <strong>Get Out</strong></div>';
                        redirect($theMsg , 'back');
                    
                } else {
                    
                    // insert the data 
                    $stmt = $con->prepare("INSERT INTO 
                                            categories
                                                (Name , Description , Parent , Ordering , Visibility , AllowComment , AllowAds)
                                            VALUES
                                                (:zName , :zDescription , :zparent , :zOrdering , :zVisibility , :zAllowComment , :zAllowAds)");
                    $stmt -> execute(array(
                        'zName'         => $name,
                        'zDescription'  => $description,
                        'zparent'       => $parent,
                        'zOrdering'     => $ordering,
                        'zVisibility'   => $visible,
                        'zAllowComment' => $comment,
                        'zAllowAds'     => $ads,
                    ));

                    // print success message
                        $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Category inserted</div>';
                        redirect($theMsg , 'back');
                    
                    
                } 
            ?></div><?php
            }else {
                $theMsg ='<div class="alert alert-danger"> sorrrrrrrry You can not brows this page directly <strong>Get Out</strong> </div>';
                redirect($theMsg , 'back');
            }
    }elseif ($do == 'edit') { // edit page 
        // check if get request cat id is numeric & get the integer value of it
        $catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;

        $stmt = $con -> prepare("SELECT * FROM categories WHERE CatId = ?");
        $stmt->execute(array($catId));
        $cat = $stmt -> fetch();
        $count = $stmt -> rowCount();

        if ($count > 0) { ?>
            <section class="container-fluid categories">
            <h1>Edit Category</h1>

            <div class="container">
                <form action="?do=update" method="POST" class="form-horizontal">
                    <input type="hidden" name="catId" value="<?= $catId?>">
                    <!-- start cat Name -->
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control" required = "required" value="<?= $cat['Name']?>" placeholder="category Name">
                        </div>
                    </div><!-- form group -->
                    <!-- end cat Name -->

                    <!-- start Description -->
                    <div class="form-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <input type="text" name="description" id="description" class="form-control" value="<?= $cat['Description']?>" placeholder="The Category Description">
                        </div>
                    </div><!-- form group -->
                    <!-- end Description -->

                    <!-- start ordering -->
                    <div class="form-group">
                        <label for="ordering" class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10">
                            <input type="text" name="ordering" id="ordering" class="form-control" value="<?= $cat['Ordering']?>" placeholder="Number To Arrange The Categories">
                        </div>
                    </div><!-- form group -->
                    <!-- end ordering -->

                    <!-- start Category Type -->
                    <div class="form-group">
                        <label for="ordering" class="col-sm-2 control-label">Parent</label>
                        <div class="col-sm-10">
                            <select name="parent" id="parent">
                                <option value="0">None</option>
                                <?php
                                $allCats = getAllFrom ("*" , "categories" , "WHERE Parent = 0" , "" , "CatId");
                                foreach ($allCats as $c){ ?>
                                    <option value="<?= $c['CatId']?>"
                                    <?php
                                    if ($cat['Parent'] == $c['CatId']) {
                                        echo 'selected';
                                    }
                                    ?>
                                    ><?= $c['Name']?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div><!-- form group -->
                    <!-- end Category Type -->

                    <!-- start visible -->
                    <div class="form-group">
                        <label for="visible" class="col-sm-2 control-label">Visible</label>
                        <div class="col-sm-10">
                            <div>
                                <input type="radio" name="visible" id="visible-yes" value="0" <?php if($cat['Visibility'] == 0){echo 'checked';}?>>
                                <label for="visible-yes">Yes</label>

                                <input type="radio" name="visible" id="visible-no" value="1" <?php if($cat['Visibility'] == 1){echo 'checked';}?>>
                                <label for="visible-no">No</label>
                            </div>
                        </div>
                    </div><!-- form group -->
                    <!-- end visible -->

                    <!-- start comment -->
                    <div class="form-group">
                        <label for="comment" class="col-sm-2 control-label">Allow Commenting</label>
                        <div class="col-sm-10">
                            <div>
                                <input type="radio" name="comment" id="comment-yes" value="0" <?php if($cat['AllowComment'] == 0){echo 'checked';}?>>
                                <label for="comment-yes">Yes</label>

                                <input type="radio" name="comment" id="comment-no" value="1" <?php if($cat['AllowComment'] == 1){echo 'checked';}?>>
                                <label for="comment-no">No</label>
                            </div>
                        </div>
                    </div><!-- form group -->
                    <!-- endcomment -->

                    <!-- start Ads -->
                    <div class="form-group">
                        <label for="ads" class="col-sm-2 control-label">Allow Ads</label>
                        <div class="col-sm-10">
                            <div>
                                <input type="radio" name="ads" id="ads-yes" value="0" <?php if($cat['AllowAds'] == 0){echo 'checked';}?>>
                                <label for="ads-yes">Yes</label>

                                <input type="radio" name="ads" id="ads-no" value="1" <?php if($cat['AllowAds'] == 1){echo 'checked';}?>>
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div><!-- form group -->
                    <!-- end Ads -->

                    <!-- start submit button -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Save" id="add" class="btn btn-info">
                        </div>
                    </div><!-- form group -->
                    <!-- end submit button -->
                </form>
            </div><!-- container -->
        </section><!-- end of categories Add page -->

        <?php }else {
            // message for error id
                $theMsg ='<div class="alert alert-danger">sorrrrrrrry Theres no such This Id <strong>Get Out</strong></div>';
                redirect($theMsg);
            }

    }elseif ($do == 'update') { // update page
        // update page
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
            <div class="container-fluid">
                <section class="categories">
                    <h1>Update Categories</h1>
                </section><!-- end of categories update page -->
    
        <?php   $id          = $_POST['catId'];
                $name        = $_POST['name'];
                $description = $_POST['description'];
                $ordering    = $_POST['ordering'];
                $parent      = $_POST['parent'];
                $visible     = $_POST['visible'];
                $comment     = $_POST['comment'];
                $ads         = $_POST['ads'];

                // update the data 
                $stmt = $con->prepare("UPDATE categories 
                                        SET 
                                            Name = ? , 
                                            Description = ? , 
                                            Ordering = ? , 
                                            Parent = ? , 
                                            Visibility = ? , 
                                            AllowComment = ? , 
                                            AllowAds = ? 
                                        WHERE 
                                        CatId = ?");
                $stmt->execute(array($name , $description , $ordering , $parent , $visible , $comment , $ads , $id));
                // should be $id variable in last variable in array

                // print success message
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Udate</>';
                redirect($theMsg , 'back');
        ?></div><?php
            }else {
                // message for error id 
                echo '<div class="container">';
                    $theMsg ='<div class="alert alert-danger">sorrrrrrrry you can not brows this page directly <strong>Get Out</strong></div>';
                    redirect($theMsg);
                echo '</div>';
            }
    }elseif ($do == 'delete') { // delete page
        // check if get request cat id is numeric & get the integer value of it
        $catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;
        $check = checkItem("CatId" , "categories" , $catId);

        /*
        $stmt = $con -> prepare("SELECT * FROM users WHERE CatId = ? LIMIT 1");
        $stmt->execute(array($userId));
        $count = $stmt -> rowCount();
        */
        if ($check > 0) {?>
            <div class="container-fluid">
                <section class="categories">
                    <h1>Delete Categories</h1>
                </section><!-- end of categories update page -->
    <?php   $stmt = $con->prepare("DELETE FROM categories WHERE CatId = :zcatid");
            $stmt->bindparam(":zcatid" , $catId);
            $stmt->execute();
            
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
            redirect($theMsg , 'back');
            
        }else {
            // message for error id 
            echo '<div class="container">';
                $theMsg ='<div class="alert alert-danger">sorrrrrrrry Theres no such This Id <strong>Get Out</strong></div>';
                redirect($theMsg , 'back');
            echo '</div>';
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
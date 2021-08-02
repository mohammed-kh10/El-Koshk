<?php
ob_start(); // Start Buferring Output
session_start();
$pageTitle = 'New Item';
$noHeader = '';
include 'init.php';

if (isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $formErrors = array();
        
        $title       = filter_var($_POST['title'] , FILTER_SANITIZE_STRING);
        $description = filter_var($_POST['description'] , FILTER_SANITIZE_STRING);
        $price       = filter_var($_POST['price'] , FILTER_SANITIZE_NUMBER_INT);
        $country     = filter_var($_POST['country'] , FILTER_SANITIZE_STRING);
        $status      = filter_var($_POST['status'] , FILTER_SANITIZE_NUMBER_INT);
        $category    = filter_var($_POST['category'] , FILTER_SANITIZE_NUMBER_INT);
        $tags        = filter_var($_POST['tags'] , FILTER_SANITIZE_STRING);

        if (strlen($title) < 4) {
            $formErrors[] = 'Item Title Must Be At Least 4 Characters';
        }

        if (strlen($description) < 10) {
            $formErrors[] = 'Item Description Must Be At Least 10 Characters';
        }

        if (empty($price)) {
            $formErrors[] = 'Item Price Must Be Not Empty';
        }

        if (strlen($country) < 2) {
            $formErrors[] = 'Item Country Must Be At Least 2 Characters';
        }

        if (empty($status)) {
            $formErrors[] = 'Item Status Must Be Not Empty';
        }

        if (empty($category)) {
            $formErrors[] = 'Item Category Must Be Not Empty';
        }
        // check if there's no errors procced the update data
        if (empty($formErrors)) {
            // insert the data 
            $stmt = $con->prepare("INSERT INTO 
                    items
                        (Name , Description , Price , CountryMade , Status , AddDate , CatId , UserId , Tags)
                    VALUES
                        (:zname , :zdescription , :zprice , :zcountry , :zstatus , now() , :zcat , :zuser , :ztags)");
            $stmt->execute(array(
                'zname' => $title,
                'zdescription' => $description,
                'zprice' => $price,
                'zcountry' => $country,
                'zstatus' => $status,
                'zcat' => $category,
                'zuser' => $_SESSION['uId'],
                'ztags' => $tags,
            ));
            // should be $id variable in last variable in array
            if ($stmt) {
                $successMsg = 'Item Has Been Added';
            }
        }
    }
?>
    <h1 class="text-center fa-4x text-primary">Create New Item</h1>

    <div class="creat-item block">
        <div class="container-fluid">
            <div class="panel">
                <div class="panel-heading">
                    <h3>Create New Item</h3>
                </div><!-- panel heading -->

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="<?= $_SERVER['PHP_SELF']?>" method="POST" class="form-horizontal">
                                <!-- start Item Name -->
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10">
                                        <input
                                        pattern=".{4,}"
                                        title="This Field Require At Least 4 Characters"
                                        type="text"
                                        name="title"
                                        id="title"
                                        class="form-control live-name" 
                                        placeholder="Item Name"
                                        >
                                    </div>
                                </div><!-- form group -->
                                <!-- end Item Name -->

                                <!-- start Description -->
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10">
                                        <input
                                        pattern=".{10,}"
                                        title="This Field Require At Least 10 Characters"
                                        type="text"
                                        name="description"
                                        id="description"
                                        class="form-control live-desc"
                                        placeholder="Item Description"
                                        >
                                    </div>
                                </div><!-- form group -->
                                <!-- end Description -->

                                <!-- start price -->
                                <div class="form-group">
                                    <label for="price" class="col-sm-2 control-label">Price</label>
                                    <div class="col-sm-10">
                                        <input
                                        type="text"
                                        name="price"
                                        id="price"
                                        class="form-control live-price"
                                        value="$ "
                                        placeholder="Item price"
                                        >
                                    </div>
                                </div><!-- form group -->
                                <!-- end price -->

                                <!-- start country -->
                                <div class="form-group">
                                    <label for="country" class="col-sm-2 control-label">Country</label>
                                    <div class="col-sm-10">
                                        <input
                                        type="text"
                                        name="country"
                                        id="country"
                                        class="form-control"
                                        placeholder="Item Country Of Made"
                                        >
                                    </div>
                                </div><!-- form group -->
                                <!-- end country -->

                                <!-- start status -->
                                <div class="form-group">
                                    <label for="status" class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-10">
                                        <select name="status" id="status" >
                                            <option value="0">...</option>
                                            <option value="1">New</option>
                                            <option value="2">Like New</option>
                                            <option value="3">Used</option>
                                            <option value="4">Old</option>
                                        </select>
                                    </div>
                                </div><!-- form group -->
                                <!-- end status -->

                                <!-- start category -->
                                <div class="form-group">
                                    <label for="category" class="col-sm-2 control-label">Category</label>
                                    <div class="col-sm-10">
                                        <select name="category" id="category" >
                                            <option value="0">...</option>
                                            <?php
                                                $cats = getAllFrom('*' , 'categories' , '' , '' , 'CatId');
                                                foreach ($cats as $cat){
                                                    echo '<option value="' . $cat['CatId'] . '">' . $cat['Name'] . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div><!-- col-10 -->
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

                                <!-- start submit button -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="submit" value="Add Item" name="addItem" id="addItem" class="btn btn-primary">
                                    </div>
                                </div><!-- form group -->
                                <!-- end submit button -->
                            </form>

                            <div>
                            <?php
                                if (isset($formErrors)) {
                                    foreach($formErrors as $error){
                                        echo '<div class="container alert alert-danger">' . $error . '</div>';
                                    }
                                }
                                if (isset($successMsg)) {
                                    // print success message
                                    echo '<div class="alert alert-success">' . $successMsg . '</div>';
                                }?>
                            </div>
                        </div><!-- col-8 -->

                        <div class="col-md-4">
                            <div class="thumbnail live-preview">
                                <img src="layout/images/messi.jpg" alt="">
                                <div class="caption">
                                    <h4>Title</h4>
                                    <p>Description</p>
                                    <span class="price">Price</span>
                                </div><!-- caption -->
                            </div><!-- thumbnail -->
                        </div><!-- col-4 -->
                    </div><!-- row -->
                </div><!-- panel-body -->
            </div><!-- panel -->
        </div><!-- container -->
    </div><!-- creat-item -->

<?php 
}else {
    header("Location: index.php");
    exit();
}
include $tpl . 'footer.php';

ob_end_flush();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getTitle()?></title>
    <link rel="stylesheet" href="<?=$css?>all.min.css">
    <link rel="stylesheet" href="<?=$css?>jquery-ui.css">
    <link rel="stylesheet" href="<?=$css?>jquery.selectBoxIt.css">
    <link rel="stylesheet" href="<?=$css?>external/aos.css">
    <link rel="stylesheet" href="<?=$css?>external/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$css?>external/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=$css?>user.css">

    <!-- <link rel="shortcut icon" href="layout/images/favicon-32x32.png" type="image/x-icon"> -->
</head>
<body>
    <section class="homeNav">
        <div class="first d-none d-md-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-4">
                        <p><span><i class="fas fa-headphones-alt"></i></span> support (00) 123456789</p>
                    </div><!-- col-4 -->

                    <div class="col-4">
                        <pre><span>&lang;</span>   Free shipping for order over $200   <span>&rang;</span></pre>
                    </div><!-- col-4 -->

                    <div class="col-4 track">
                        <p><span><i class="fas fa-map-marker-alt"></i></span> Order tracking <!-- <img src="" alt=""> علم امريكا للدلالة للغة الانجليزية--> Eng / $ &downarrow;</p>
                    </div><!-- col-4 -->
                </div><!-- row -->
            </div><!-- container -->
        </div><!-- first -->

        <!-- start cart section -->
        <!-- start cart section -->
        
        <?php
        
        $status = "";

        if(isset($_GET["action"]) && $_GET["action"] != "") {

            switch($_GET["action"]) {
                case "add":
                    if(!empty($_POST["quantity"]) && $_POST["quantity"] > 0) {
                        $result  = $con -> prepare("SELECT * FROM items WHERE ItemId='" . $_GET["itemId"] . "'");
                        $result -> execute();
                        $rows  = $result -> fetch();
                        
                        $name = $rows['Name'];
                        $id = $rows['ItemId'];
                        $price = $rows['Price'];
                        $image = $rows['Image'];
                        $quantity = $_POST['quantity'];

                        $itemArray = array(
                            $id => array(
                                'name'     => $name , 
                                'id'       => $id , 
                                'price'    => $price , 
                                'quantity' => $quantity , 
                                'image'    => $image
                            ),
                        );
                        
                        if(!empty($_SESSION["cart_item"])) {

                            $array_keys = array_keys($_SESSION["cart_item"]);

                            if(in_array($id,$array_keys)) {
                                $status=
                                    "<div class='alert alert-info alert-dismissible' role='alert'>
                                        Product is added to your cart!
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>";
                            } else {
                                $_SESSION["cart_item"] = array_merge(
                                    $_SESSION["cart_item"],
                                    $itemArray
                                );
                                $status=
                                    "<div class='alert alert-info alert-dismissible' role='alert'>
                                        Product is added to your cart!
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>";
                            }

                        } else {
                            $_SESSION["cart_item"] = $itemArray;
                            
                            $status=
                            "<div class='alert alert-info alert-dismissible' role='alert'>
                                Product is added to your cart!
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div>";
                        }
                    }
                break;
                case "remove":
                    if(!empty($_SESSION["cart_item"])) {
                        foreach($_SESSION["cart_item"] as $key => $value) {
                            if($_GET["itemId"] == $key){
                                unset($_SESSION["cart_item"][$key]);
                                
                                $status=
                                    "<div class='alert alert-danger alert-dismissible text-danger' role='alert'>
                                        Product is removed from your cart!
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>";
                            }
                            if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                            }		
                    }
                break;
                case "empty":
                    unset($_SESSION["cart_item"]);
                break;	
            }
        }

        ?>
        <!-- Modal -->
        <div class="cartModal modal fade p-0" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Shopping Cart</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true fa-3x">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <?php
                    if(isset($_SESSION["cart_item"])){
                        $total_quantity = 0;
                        $total_price = 0;
                    ?>
                    <table class="tbl-cart table table-hover table-bordered text-center" cellpadding="10" cellspacing="1">
                        <tbody>
                            <tr class="bg-dark text-white text-center">
                                <th>Name</th>
                                <th>ID</th>
                                <th width="5%">Quantity</th>
                                <th width="10%">Unit Price</th>
                                <th width="10%">Price</th>
                                <th width="5%">Remove</th>
                            </tr>	
                            <?php
                                foreach ($_SESSION["cart_item"] as $item){
                                    $item_price = $item["quantity"] * $item["price"];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if (!empty($item['image'])) {?>
                                                <img src="data/uploads/images/<?= $item['image']?>"/>
                                            <?php
                                            }else { ?>
                                                <img src="data/uploads/images/defaultItemImage.jpg"/>
                                            <?php }
                                            ?>
                                            <h3><?= $item["name"]; ?></h3>
                                        </td>
                                        <td><?= $item["id"]; ?></td>
                                        <td><?= $item["quantity"]; ?></td>
                                        <td><?= "$ ".$item["price"]; ?></td>
                                        <td><?= "$".$item["price"] * $item["quantity"]; ?></td>
                                        <td><a href="index.php?action=remove&itemId=<?= $item["id"]; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                    <?php
                                    $total_quantity += $item["quantity"];
                                    $total_price += ($item["price"]*$item["quantity"]);
                                    }
                                    ?>

                            <tr>
                                <td colspan="2" align="right">Total:</td>
                                <td align="right"><?= $total_quantity; ?></td>
                                <td align="right" colspan="2"><strong><?= "$ ". $total_price ?></strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>		
                    <?php
                    } else {
                    ?>
                    <div class="no-records alert alert-info text-primary">Your Cart is Empty</div>
                    <?php 
                    }
                    ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <a id="btnEmpty" href="index.php?action=empty" class="btn border-danger text-right">Empty Cart</a>
                    </div>
                    <div class="message_box" style="margin:10px 0px;">
                        <?= $status ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end cart section -->
        <!-- end cart section -->

        <div class="second">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 logo">
                        <h2><i class="fab fa-opencart"></i> El Koshk</h2>
                    </div><!-- col-2 -->

                    <div class="col-md-5 search">
                        <form action="">
                            <input type="search" name="" id="" placeholder="&#128269;   Search For Products">
                        </form>
                    </div><!-- col-5 -->

                    <div class="col-md-1 col-4 heart">
                        <i class="far fa-heart"></i>
                    </div> <!-- col-1 -->

                    <div class="col-md-2 col-4 sign">
                        <!-- modal button -->
                        <button type="button" data-toggle="modal" data-target="#signModal">
                            <?php
                                if (isset($_SESSION['user'])) { ?>
                                    <p>Hello , <?= $sessionUser?> <br><span><a href="profile.php">My Account</a></span></p>
                                    <a class="text-dark mx-3" href="logout.php">Logout</a>
                                    <?php
                                    $userStatus = checkUserStatus($sessionUser);
                                    if ($userStatus == 1) { ?>
                                        <i title="Your Membership Need To Activate By Admin" class="fas fa-user-times"></i>
                                    <?php }else { ?>
                                        <i class="far fa-user"></i>
                                    <?php } ?>
                                <?php } else { ?>
                                    <p>Hello , sign in <br></p>
                                    <i class="far fa-user"></i>
                                <?php }?>
                        </button>
                    </div><!-- col-2 -->

                    <div class="col-md-2 col-4 cart">
                        <button class="btn badge-light" data-toggle="modal" data-target="#cartModal">
                            <?php
                                if(isset($_SESSION["cart_item"])) {
                                    $cart_count = count(array_keys($_SESSION["cart_item"])); ?>
                                    <span class="count"><?= $cart_count; ?></span>
                                <?php } ?>
                            <i class="fas fa-cart-arrow-down"></i>
                            <p>my cart <br><span class="price"><?php if(isset($total_price)){ echo '$' . $total_price;} ?> &darr;</span></p>
                        </button>
                    </div><!-- col-2 -->
                </div><!-- row -->
            </div><!-- container -->
        </div><!-- second -->

<?php
// check if user coming from HTTP post Request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['login'])) {
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $hashPassword = sha1($password);

        //check if the user exist in database or not
        $stmt = $con -> prepare("SELECT
                                    UserId , Name , Password
                                FROM
                                    users
                                WHERE
                                    Name = ?
                                AND
                                    Password = ?");
        $stmt->execute(array($userName , $hashPassword));
        $get = $stmt->fetch();
        $count = $stmt -> rowCount();

        if ($count > 0) {
            $_SESSION['user'] = $userName; // register session by user name
            $_SESSION['uId'] = $get['UserId']; // register user id is session
            header('Location: index.php'); // redirct to dashboard page
            exit();
        }

    }elseif (isset($_POST['sign'])){

        $formErrors = array();

        $name            = $_POST['name'];
        $signpassword    = $_POST['signpassword'];
        $confirmpassword = $_POST['confirmPassword'];
        $email           = $_POST['email'];
        $fullName        = $_POST['fullName'];

        if (isset($name)) {
            $filterUser = filter_var($name , FILTER_SANITIZE_STRING);
            if (strlen($filterUser) < 4) {
                $formErrors[] = 'User Name Must Be Larger Than 4 Characters';
            }
        }

        if (isset($signpassword) && isset($confirmpassword)) {
            if (empty($signpassword)) {
                $formErrors[] = 'Sorry Password Can Not Be Empty';
            }

            if (sha1($signpassword) !== sha1($confirmpassword)) {
                $formErrors[] = 'Sorry Password Is Not Match';
            }
        }

        if (isset($email)) {
            $filterEmail = filter_var($email , FILTER_SANITIZE_EMAIL);
            if (filter_var($filterEmail , FILTER_VALIDATE_EMAIL) != true) {
                $formErrors[] = 'This Email Is Not Valid';
            }
        }

        if (isset($fullName)) {
            $filterUser = filter_var($fullName , FILTER_SANITIZE_STRING);
            if (strlen($filterUser) < 4) {
                $formErrors[] = 'User Full Name Must Be Larger Than 7 Characters';
            }
        }

        // check if there's no errors procced the user add
        if (empty($formErrors)) {
            // check if user exist in database or not
            $check = checkItem("Name" , "users" , $name);
            if ($check == 1) {
                $formErrors[] = 'Sorry This User Is Exist';
            }else {
                
                // insert the data 
                $stmt = $con->prepare("INSERT INTO 
                                        users(Name , Password , Email , FullName , RegStatus , Date)
                                        VALUES (:zname , :zpassword , :zemail , :zfullName , 0 , now())");
                $stmt->execute(array(
                    'zname'     => $name ,
                    'zpassword' => sha1($signpassword) ,
                    'zemail'    => $email ,
                    'zfullName' => $fullName
                ));
                // should be $id variable in last variable in array

                // print success message
                $successMsg = 'Congrats You Are Now Registerd User Record inserted';
                
            }
        }
    }
}
?>

        <!-- Modal -->
        <div class="signModal modal fade" id="signModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <div class="btns">
                            <button class="btn btn-light btnTab activeBtn" data-mark="login"><i class="fas fa-unlock-alt"></i> Login</button>
                            <button class="btn btn-light btnTab" data-mark="sign"><i class="far fa-user"></i> Sign Up</button>
                        </div><!-- btns -->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- header -->

                    <div class="modal-body">
                        <div class="content">
                            <!-- start login form -->
                            <div class="itemTabs activeItem" id="login">
                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                                    <label for="userName">User Name</label>
                                    <input type="text" name="userName" id="userName" required="required" placeholder="    User Name">

                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" required="required" placeholder="    Password">

                                    <input type="checkbox" name="remember" id="remember">
                                    <label for="remember">Remeber me</label>

                                    <a href="#">Forgot Password?</a>

                                    <input type="submit" value="login" name="login" id="login">
                                </form>
                            </div><!-- end login form -->


                            <!-- start signup form -->
                            <div class="itemTabs " id="sign">


                                <div class="container theErrors text-center">
                                    <?php
                                    if (!empty($formErrors)) {
                                        foreach ($formErrors as $error){
                                            echo '<p class="msg error">' . $error . '</p>';
                                        }
                                    }

                                    if (isset($successMsg)) {
                                        echo '<p class="msg success">' . $successMsg . '</p>';
                                    }
                                    ?>
                                </div><!-- the errors -->


                                <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                                    <label for="name">User Name</label>
                                    <input type="text" name="name" id="name" required="required" placeholder="    User Name">

                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" required="required" placeholder="     mohammed@example.com">
                                    
                                    <label for="signpassword">Password</label>
                                    <input type="password" name="signpassword" id="signpassword" required="required" minlength="5" placeholder="    Your Password">
                                    
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" name="confirmPassword" id="confirmPassword" required="required" minlength="5">

                                    <label for="fullName">Full Name</label>
                                    <input type="text" name="fullName" id="fullName" required="required" placeholder="    User Full Name">

                                    <input type="submit" value="Sign Up" name="sign" id="sign">
                                </form>
                            </div><!-- end signup form -->
                        </div><!-- about-content -->
                    </div><!-- body -->
                </div><!-- content -->
            </div><!-- modal dialog -->
        </div><!-- end of  modal section -->

        <div class="third">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

                            <li class="nav-item categories" id="categories">
                                <a class="nav-link" href="#"><i class="fas fa-boxes"></i> Categories &darr;<span class="sr-only">(current)</span></a>
                            </li>

                            <li class="nav-item active">
                                <a class="nav-link" href="index.php">Home</a>
                            </li>
                            
                            <li class="nav-item" id="brands">
                                <a class="nav-link" href="#">Brands</a>
                            </li>

                            <li class="nav-item" id="pages">
                                <a class="nav-link" href="#">Pages</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">Account</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">Blogs</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">Docs / Components</a>
                            </li>
                        
                        </ul>
                    </div>
                </nav>
            </div><!-- container -->
        </div><!-- third -->

        <div id="categories-drop" class="categories-drop">
            <h1>Categories</h1>
            <div class="category">
                <ul>
                <?php 
                $categories = getAllFrom ("*" , "categories" , "WHERE Parent = 0" , "" , "CatId" , 'ASC');
                foreach ($categories as $cat){ ?>
                    <li><a href="categories.php?pageId=<?= $cat['CatId']?>"><?= $cat['Name']?></a></li>
                    <?php } ?>
                </ul>
            </div><!-- category -->
        </div><!-- categories -->
        <!-- ######################### -->

        <div id="brands-drop" class="brands-drop">
            <h1>Brands</h1>

            <div class="brand">
                <ul>
                    <li>Not available Now</li>
                </ul>
            </div><!-- brand -->
        </div><!-- end of brands part -->
        <!-- ######################### -->

        <div id="pages-drop" class="pages-drop">
            <h1>Pages</h1>

            <div class="page">
                <ul>
                    <li>Not available Now</li>
                </ul>
            </div><!-- end of pages -->
        </div><!-- end of pages part -->

    </section><!-- end of navbar -->

    <section class="demoStore bg-danger p-2">
        <p class="fa-2x text-white text-center">This is a demo store, it's not available to order</p>
    </section><!-- demoStore -->
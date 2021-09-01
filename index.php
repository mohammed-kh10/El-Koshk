<?php
ob_start();
session_start();
$pageTitle = 'El Koshk';
include 'init.php';
?>

<?php
if (isset($_SESSION['user'])) {
    $userId = $_SESSION['uId'];
    
    $stmt = $con -> prepare("SELECT
                                *
                            FROM
                                users
                            WHERE
                                UserId  = ?
                            AND
                            GroupId = 1");
    $stmt->execute(array($userId));
    $count = $stmt -> rowCount();

    if ($count > 0) { ?>
        <section class="goToDashboard">
            <a href="admin/dashboard.php" class="btn btn-light">
                <ul class="list-unstyled">
                    <li>D</li>
                    <li>A</li>
                    <li>S</li>
                    <li>H</li>
                    <li>B</li>
                    <li>O</li>
                    <li>A</li>
                    <li>R</li>
                    <li>D</li>
                </ul>
            </a>
        </section><!-- end of Go To Dashboard section -->
    <?php }
    } ?>


<section class="container-fluid trend">
    <h1>Trending Products</h1>
    <div class="line"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-6">
                <img src="layout/images/01.jpg" alt="">
                <p>Sneakers & Keds</p>
                <h5>Women Colorblock Sneakers</h5>
                <span class="span1">$ 154.00</span>
                <span class="span2">* * * *</span>
                <a href="#" class="btn btn-danger text-white mx-5 my-3 d-block w-50">Add to cart</a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <img src="layout/images/02.jpg" alt="">
                <p>Women's T-shirt</p>
                <h5>Cotton Lace Blouse</h5>
                <span class="span1">$ 28.50</span>
                <span class="span2">* * *</span>
                <a href="#" class="btn btn-danger text-white mx-5 my-3 d-block w-50">Add to cart</a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <img src="layout/images/03.jpg" alt="">
                <p>Women's Short</p>
                <h5>Mom High Waist Shorts</h5>
                <span class="span1">$ 39.50</span>
                <span class="span2">* * * * *</span>
                <a href="#" class="btn btn-danger text-white mx-5 my-3 d-block w-50">Add to cart</a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <img src="layout/images/04.jpg" alt="">
                <p>Men's Pants</p>
                <h5>Men's Pants Jeans</h5>
                <span class="span1">$ 54.00</span>
                <span class="span2">* * * *</span>
                <a href="#" class="btn btn-danger text-white mx-5 my-3 d-block w-50">Add to cart</a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <img src="layout/images/05.jpg" alt="">
                <p>Sportwear</p>
                <h5>Women Sports Jacket</h5>
                <span class="span1">$ 68.40</span>
                <span class="span2">* * * * *</span>
                <a href="#" class="btn btn-danger text-white mx-5 my-3 d-block w-50">Add to cart</a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <img src="layout/images/06.jpg" alt="">
                <p>Men's Sunglasses</p>
                <h5>Polarized Sunglasses</h5>
                <span class="span1">out of stock</span>
                <span class="span2">* * * *</span>
                <a href="#" class="btn btn-danger text-white mx-5 my-3 d-block w-50">Add to cart</a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <img src="layout/images/07.jpg" alt="">
                <p>Backpacks</p>
                <h5>TH Jeans City Backpack</h5>
                <span class="span1">$ 79.99</span>
                <span class="span2">* * *</span>
                <a href="#" class="btn btn-danger text-white mx-5 my-3 d-block w-50">Add to cart</a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <img src="layout/images/08.jpg" alt="">
                <p>Women's Sneakers</p>
                <h5>Leather High -Top Sneakers</h5>
                <span class="span1">$ 215.00</span>
                <span class="span2">* * *</span>
                <a href="#" class="btn btn-danger text-white mx-5 my-3 d-block w-50">Add to cart</a>
            </div><!-- col-3 -->
        </div><!-- row -->
        <button class="btn btn-light">More Products &rarr;</button>
    </div><!-- container -->
</section><!-- trend -->

<section class="userCategories">
    <h1 class="text-center fa-3x my-3">Best Items</h1>
    <div class="line"></div>

    <div class="userItems">
        <div class="row">
            <?php
            $allItems = getAllFrom('*' , 'items' , 'WHERE Approve = 1' , '' , 'ItemId');
            foreach ($allItems as $item){ ?>
                <div class="col-sm-6 col-md-3">
					<form method="POST" action="index.php?action=add&itemId=<?= $item["ItemId"]; ?>">
                        <div class="thumbnail">
                            <?php
                            if (!empty($item['Image'])) { ?>
                                <img src="data/uploads/images/<?= $item['Image']?>" alt="">
                            <?php }else { ?>
                                <img src="data/uploads/images/defaultItemImage.jpg" alt="">
                            <?php } ?>
                            <div class="caption">
                                <h4><a href="item.php?itemId=<?= $item['ItemId']?>"><?= $item['Name']?></a></h4>
                                <p><?= $item['Description']?></p>
                                <span class="price">$ <?= $item['Price']?></span>
                                <span class="stars">
                                    <?php
                                        if ($item['Rating'] == 1) {
                                            echo "*";
                                        }elseif ($item['Rating'] == 2) {
                                            echo "* *";
                                        }elseif ($item['Rating'] == 3) {
                                            echo "* * *";
                                        }elseif ($item['Rating'] == 4) {
                                            echo "* * * *";
                                        }elseif ($item['Rating'] == 5) {
                                            echo "* * * * *";
                                        }else {
                                            echo "not have a rating";
                                        }
                                    ?>
                                </span>
                                <span class="date"><?= $item['AddDate']?></span>
                                <div class="d-inline">
                                    <input type="submit" value="Add to cart" class="btn btn-danger text-white mx-3 my-3 d-inline-block w-50">
                                    <input type="number" class="item-quantity d-inline-block w-25" name="quantity" value="1" />
                                    
                                </div>
                            </div><!-- caption -->
                        </div><!-- thumbnail -->
					</form>
                </div><!-- col-3 -->
            <?php } ?>
        </div><!-- row -->
    </div><!-- User Irems -->
</section><!-- container -->

<section class="banner">
        <div class="row">
            <div class="col-md-9">
                <div class="back">
                    <div class="offer">
                        <p>Hurry Up! Limited time offer</p>
                        <h2>Converse All Star On Sale</h2>
                        <a href="#" class="btn btn-danger">Shop Now</a>
                    </div><!-- content -->
                </div>
            </div><!-- col-8 -->

            <div class="col-md-3">
                <div class="spot">
                    <h3>Your Add Banner Here</h3>
                    <p>Hurry Up to reserve your spot</p>
                    <a href="#" class="btn btn-danger">Contact Us</a>
                </div><!-- content -->
            </div><!-- col-4 -->
        </div><!-- row -->
</section><!-- banner -->

<section class="itemsBrands">
    <h1>Shop By Brand</h1>
    <div class="line"></div>

    <div class="container">
        <div class="row">
            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/01.png" alt="">
                </a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/02.png" alt="">
                </a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/03.png" alt="">
                </a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/04.png" alt="">
                </a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/05.png" alt="">
                </a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/06.png" alt="">
                </a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/07.png" alt="">
                </a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/08.png" alt="">
                </a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/09.png" alt="">
                </a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/10.png" alt="">
                </a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/11.png" alt="">
                </a>
            </div><!-- col-3 -->

            <div class="col-md-3 col-6">
                <a href="#">
                    <img src="layout/images/12.png" alt="">
                </a>
            </div><!-- col-3 -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- brands -->

<section class="social">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="twitter">
                <i class="fab fa-twitter"></i>
                <h4>Read The Blog</h4>
                <p>Latest Store , fasion news and trends</p>
            </div><!-- twitter -->
        </div><!-- col-6 -->

        <div class="col-md-6 col-12">
            <div class="instagram">
                <i class="fab fa-instagram"></i>
                <h4>Follow on Instagram</i></h4>
                <p>#shop_with_elkoshk</p>
            </div><!-- instagram -->
        </div><!-- col-6 -->
    </div><!-- row -->
</section><!-- social -->

<?php
include $tpl . 'footer.php';
ob_end_flush();
?>
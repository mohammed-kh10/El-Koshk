<?php
ob_start();
session_start();
$pageTitle = 'El Koshk';
include 'init.php';


?>

<section class="container trend">
    <h1>Trending Products</h1>
    <div class="line"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <img src="layout/images/01.jpg" alt="">
                <p>Sneakers & Keds</p>
                <h5>Women Colorblock Sneakers</h5>
                <span class="span1">$ 154.00</span>
                <span class="span2">* * * *</span>
            </div><!-- col-3 -->

            <div class="col-3">
                <img src="layout/images/02.jpg" alt="">
                <p>Women's T-shirt</p>
                <h5>Cotton Lace Blouse</h5>
                <span class="span1">$ 28.50</span>
                <span class="span2">* * *</span>
            </div><!-- col-3 -->

            <div class="col-3">
                <img src="layout/images/03.jpg" alt="">
                <p>Women's Short</p>
                <h5>Mom High Waist Shorts</h5>
                <span class="span1">$ 39.50</span>
                <span class="span2">* * * * *</span>
            </div><!-- col-3 -->

            <div class="col-3">
                <img src="layout/images/04.jpg" alt="">
                <p>Men's Pants</p>
                <h5>Men's Pants Jeans</h5>
                <span class="span1">$ 54.00</span>
                <span class="span2">* * * *</span>
            </div><!-- col-3 -->

            <div class="col-3">
                <img src="layout/images/05.jpg" alt="">
                <p>Sportwear</p>
                <h5>Women Sports Jacket</h5>
                <span class="span1">$ 68.40</span>
                <span class="span2">* * * * *</span>
            </div><!-- col-3 -->

            <div class="col-3">
                <img src="layout/images/06.jpg" alt="">
                <p>Men's Sunglasses</p>
                <h5>Polarized Sunglasses</h5>
                <span class="span1">out of stock</span>
                <span class="span2">* * * *</span>
            </div><!-- col-3 -->

            <div class="col-3">
                <img src="layout/images/07.jpg" alt="">
                <p>Backpacks</p>
                <h5>TH Jeans City Backpack</h5>
                <span class="span1">$ 79.99</span>
                <span class="span2">* * *</span>
            </div><!-- col-3 -->

            <div class="col-3">
                <img src="layout/images/08.jpg" alt="">
                <p>Women's Sneakers</p>
                <h5>Leather High -Top Sneakers</h5>
                <span class="span1">$ 215.00</span>
                <span class="span2">* * *</span>
            </div><!-- col-3 -->
        </div><!-- row -->
        <button class="btn btn-light">More Products &rarr;</button>
    </div><!-- container -->
</section><!-- trend -->

<div class="userCategories">
    <div class="container userItems">
        <div class="row">
            <?php
            $allItems = getAllFrom('*' , 'items' , 'WHERE Approve = 1' , '' , 'ItemId');
            foreach ($allItems as $item){ ?>
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="layout/images/01.jpg" alt="">
                        <div class="caption">
                            <h4><a href="item.php?itemId=<?= $item['ItemId']?>"><?= $item['Name']?></a></h4>
                            <p><?= $item['Description']?></p>
                            <span class="price">$ <?= $item['Price']?></span>
                            <span class="stars">* * * *</span>
                            <span class="date"><?= $item['AddDate']?></span>
                        </div><!-- caption -->
                    </div><!-- thumbnail -->
                </div><!-- col-4 -->
            <?php } ?>
        </div><!-- row -->
    </div><!-- User Irems -->

</div><!-- container -->

<?php
include $tpl . 'footer.php';
ob_end_flush();
?>
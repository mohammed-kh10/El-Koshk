<?php
ob_start();
$noHeader = '';
$pageTitle = 'Categories';
session_start();
include 'init.php'; 
if (isset($_GET['name'])) {
    $tagName = $_GET['name'];
?>

<div class="userCategories">

    <div class="container userItems">
        <div class="head">
            <h1><?= $tagName?></h1>
        </div><!-- head -->
        <div class="row">
            <?php
                if (isset($tagName)) {
                $tagItams = getAllFrom ("*" , "items" , "WHERE Tags LIKE  '%$tagName%' " , "AND Approve = 1" , "ItemId");
                foreach ($tagItams as $item){ ?>

                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                        <?php if($item['Approve'] == 0){ ?>
                            <span class="approve">Waiting Approval</span>
                        <?php }?>
                            <img src="layout/images/01.jpg" alt="">
                            <div class="caption">
                                <h4><a href="item.php?itemId=<?= $item['ItemId']?>"><?= $item['Name']?></a></h4>
                                <p><?= $item['Description']?></p>
                                <span class="price">$ <?= $item['Price']?></span>
                                <span class="stars">* * * *</span>
                                <span class="love"><i class="far fa-heart"></i></span>
                                <span class="date"><?= $item['AddDate']?></span>
                            </div><!-- caption -->
                        </div><!-- thumbnail -->
                    </div><!-- col-4 -->
                <?php } 
            }?>
        </div><!-- row -->
    </div><!-- User Irems -->

</div><!-- container -->
<?php } ?>

<?php
include $tpl . 'footer.php';
ob_end_flush();
?>
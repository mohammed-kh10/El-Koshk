<?php
ob_start();
$noHeader = '';
$pageTitle = 'Categories';
session_start();
include 'init.php'; 
if (isset($_GET['pageId'])) {
    $catId = $_GET['pageId'];
?>

<div class="userCategories">

    <div class="container userItems">
        <?php
            $categoryId = isset($_GET['pageId']) && is_numeric($_GET['pageId']) ? intval($_GET['pageId']) : 0;
            if ($categoryId) { 
                $stmt = $con->prepare("SELECT * FROM categories WHERE CatId = ?");
                $stmt->execute(array($catId));
                $rows = $stmt->fetchAll();
                foreach ($rows as $row);
                ?>
                <div class="head">
                    <h1><?= $row['Name']?></h1>
                    <ul class="fa-pull-right">
                        <li><a href="index.php"><i class="fa fa-home"></i> Home > </a></li>
                        <li><a href="#"> Shop > </a></li>
                        <li> Categories</li>
                    </ul>
                </div><!-- head -->
                
                <div class="row">
                <?php }
                if ($categoryId) {
                    $items = getAllFrom ("*" , "items" , "WHERE CatId = $categoryId" , "ANd Approve = 1" , "ItemId");
                    foreach ($items as $item){ ?>
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
<?php
ob_start(); // Start Buferring Output

session_start();
$pageTitle = 'Profile';
$noHeader = '';
include 'init.php';
if (isset($_SESSION['user'])) {
    $stmt = $con->prepare("SELECT * FROM users WHERE Name = ?");
    $stmt->execute(array($sessionUser));
    $row = $stmt->fetch();

?>
    <div class="profile-page">
        <?php
        if (!empty($row['image'])) { ?>
            <img src="data/uploads/images/<?= $row['image']?>" alt="">
        <?php }else { ?>
            <img src="data/uploads/images/defaultProfileImage.jpg" alt="">
        <?php } ?>
        <h1><?= $sessionUser?></h1>
    </div><!-- profile page -->

    <div class="information block">
        <div class="container">
            <div class="panel">
                <div class="panel-heading">
                    <h3>My Information</h3>
                </div><!-- panel heading -->

                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>Login Name</span> : <?= $row['Name']?>
                        </li>

                        <li>
                            <i class="far fa-envelope fa-fw"></i>
                            <span>Email</span> : <?= $row['Email']?>
                        </li>
                        
                        <li>
                            <i class="far fa-user fa-fw"></i>
                            <span>Full Name</span> : <?= $row['FullName']?>
                        </li>
                        
                        <li>
                            <i class="fa fa-calendar-alt fa-fw"></i>
                            <span>Register Date</span> : <?= $row['Date']?>
                        </li>
                        
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Favourite Category</span> :
                        </li>
                    </ul>
                    <a href="#" class="btn btn-danger editButton">Edit Profile</a>
                </div><!-- panel-body -->
            </div><!-- panel -->
        </div><!-- container -->
    </div><!-- information -->



    <div class="myItems block">
        <div class="container">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="d-inline-block">My Items</h3>
                    <a href="newitem.php" class="fa-pull-right btn btn-success">New Item +</a>
                </div><!-- panel heading -->

                <div class="panel-body">
                    <div class="row">
                        <?php
                        $items = getAllFrom ("*" , "items" , "WHERE UserId = {$row['UserId']}" , "" , "ItemId");
                        if (!empty($items)) {
                            foreach ($items as $item){ ?>
                                <div class="col-sm-6 col-md-3">
                                    <div class="thumbnail">
                                        <?php if($item['Approve'] == 0){ ?>
                                            <span class="approve">Waiting Approval</span>
                                        <?php }?>
                                        <img src="layout/images/01.jpg" alt="">
                                        <div class="caption">
                                            <h6><a href="item.php?itemId=<?= $item['ItemId']?>"><?= $item['Name']?></a></h6>
                                            <p><?= $item['Description']?></p>
                                            <span class="price">$ <?= $item['Price']?></span>
                                            <span class="stars">* * * *</span>
                                            <span class="love"><i class="far fa-heart"></i></span>
                                            <span class="date"><?= $item['AddDate']?></span>
                                        </div><!-- caption -->
                                    </div><!-- thumbnail -->
                                </div><!-- col-4 -->
                            <?php }
                        }else {
                            echo 'You Have No Items To Show <a href="newitem.php" class="fa-pull-right mx-3 btn btn-success"> New Item +</a>';
                        } ?>
                    </div><!-- row -->
                </div><!-- panel-body -->
            </div><!-- panel -->
        </div><!-- container -->
    </div><!-- Items -->



    <div class="myComments   block">
        <div class="container">
            <div class="panel">
                <div class="panel-heading">
                    <h3>Latest Comments</h3>
                </div><!-- panel heading -->

                <div class="panel-body">
                    <?php
                    $myComments = getAllFrom ("Comment" , "comments" , "WHERE UserId = {$row['UserId']}" , "" , "ComId");
                    
                    if (!empty($myComments)) {
                        foreach ($myComments as $comment){ ?>
                            <p><?= $comment['Comment']?></p>
                        <?php }
                    }else {
                        echo 'You Have No Comments To Show';
                    }
                    ?>
                </div><!-- panel-body -->
            </div><!-- panel -->
        </div><!-- container -->
    </div><!-- Comments -->

<?php 
}else {
    header("Location: index.php");
    exit();
}
include $tpl . 'footer.php';

ob_end_flush();

?>
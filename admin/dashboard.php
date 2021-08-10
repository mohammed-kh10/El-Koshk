<?php
ob_start("ob_gzhandler"); // Start Output Buffering

session_start();

if (isset($_SESSION['userName'])) {
    $noHeader = '';
    $pageTitle = 'Dashboard';
    // include init file
    include 'init.php';

    // start dashboard page
    
    ?>

    <section class="container dashboard">
        <h1>Dashboard</h1>
        
        <div class="home-stat">
            <div class="row">
                <div class="col-md-2">
                    <div class="stat bg-info text-light text-center">
                        <div class="info">
                            <i class="fas fa-user-plus"></i>
                            <h6>Pending Members</h6>
                            <a href="members.php?do=manage&page=pending" class="text-white"><span data-from="0" data-to="<?= checkItem('RegStatus' , 'users' , 0)?>" data-speed="1000" class="timer d-block"></span></a>
                        </div>
                    </div><!-- statistics -->
                </div><!-- col-3 -->
                
                <div class="col-md-2">
                    <div class="stat bg text-light text-center">
                        <div class="info">
                            <i class="fa fa-tag"></i>
                            <h6>Pendin Items</h6>
                            <a href="#" class="text-white"><span class="d-block">102</span></a>
                        </div>
                    </div><!-- statistics -->
                </div><!-- col-3 -->
                
                <div class="col-md-4">
                    <div class="stat bg-danger text-light text-center">
                        <div class="danger">
                            <i class="fas fa-users"></i>
                            <h6>Total Members</h6>
                            <a href="members.php" class="text-white"><span data-from="0" data-to="<?= countItems('UserId' , 'users')?>" data-speed="1000" class="timer d-block"></span></a>
                        </div>
                    </div><!-- statistics -->
                </div><!-- col-3 -->

                <div class="col-md-2">
                    <div class="stat bg-warning text-light text-center">
                        <div class="info">
                            <i class="fas fa-tag"></i>
                            <h6>Total Items</h6>
                            <a href="items.php" class="text-white"><span data-from="0" data-to="<?= countItems('ItemId' , 'items')?>" data-speed="1000" class="timer d-block"></span></a>
                        </div>
                    </div><!-- statistics -->
                </div><!-- col-3 -->

                <div class="col-md-2">
                    <div class="stat  bg-success text-light text-center">
                        <div class="info">
                            <i class="fas fa-comments"></i>
                            <h6>Total Comments</h6>
                            <a href="comments.php" class="text-white"><span data-from="0" data-to="<?= countItems('ComId' , 'comments')?>" data-speed="1000" class="timer d-block"></span></a>
                        </div>
                    </div><!-- statistics -->
                </div><!-- col-3 -->
            </div><!-- row -->
        </div>
        
        <div class="container latest">
                <!-- user and items section -->
                <!-- user and items section -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel">

                        <?php $numUsers = 4; // number of latest user ?>

                        <div class="panel-heading">
                            <div class="alert alert-info"><i class="fas fa-users"></i> <p>Latest <?= $numUsers?> Users</p></div>
                            <span class="toggle-info fa-pull-right"><i class="fa fa-minus fa-lg"></i></span>
                        </div>

                        
                        <div class="panel-body ">
                            <?php
                            $latestUsers = getLatest('*' , 'users' , 'UserId' , $numUsers);
                            if (!empty($latestUsers)) {
                                
                                foreach ($latestUsers as $user){ ?>
                                    <ul class="alert alert-light list-unstyled latest-user">
                                    <li class="overflow-hidden">
                                    <div>
                                            <p><?= $user['Name']; ?></p>
                                            <a href="members.php?do=edit&userId=<?= $user['UserId']?>" class="text-white">
                                                <span class="btn btn-success fa-pull-right">
                                                    <i class="fa fa-edit"></i> Edit
                                                </span>
                                            </a>

                                                <?php 
                                                if ($user['RegStatus'] == 0) { ?>
                                                    <a href="members.php?do=activate&userId=<?= $user['UserId']?>" class="btn btn-info fa-pull-right activate"><i class="fa fa-check"></i> Activate</a>
                                                <?php } ?>
                                        </div>
                                    </li>
                                </ul>
                                <?php } 
                            }else {
                                echo 'there is no users to show';
                            }?>
                        </div><!-- panel body -->
                    </div>
                </div><!-- col-6 -->

                <div class="col-sm-6">
                    <div class="panel">

                        <?php $numItems = 7; //number of latest Items?>

                        <div class="panel-heading">
                            <div class="alert alert-info"><i class="fas fa-tag"></i> <p>Latest <?= $numItems?> Items Added</p></div>
                            <span class="toggle-info fa-pull-right"><i class="fa fa-minus fa-lg"></i></span>
                        </div>

                        <div class="panel-body">
                        <?php
                        $latestItems = getLatest('*' , 'items' , 'ItemId' , $numItems);
                        if (!empty($latestItems)) {
                            
                            foreach ($latestItems as $item){ ?>
                                <ul class="alert alert-light list-unstyled latest-item">
                                    <li class="overflow-hidden">
                                    <div>
                                            <p><?= $item['Name']; ?></p>
                                            <a href="items.php?do=edit&itemId=<?= $item['ItemId']?>" class="text-white">
                                                <span class="btn btn-success fa-pull-right">
                                                    <i class="fa fa-edit"></i>
                                                </span>
                                            </a>

                                                <?php 
                                                if ($item['Approve'] == 0) { ?>
                                                    <a href="items.php?do=approve&itemId=<?= $item['ItemId']?>" class="btn btn-info fa-pull-right activate"><i class="fa fa-check"></i></a>
                                                <?php } ?>
                                        </div>
                                    </li>
                                </ul>
                            <?php } 
                        }else {
                            echo 'there is no Items to show';
                        }?>
                        </div><!-- panel body -->
                    </div>
                </div><!-- col-6 -->
            </div><!-- row -->
                <!-- end user and items section -->
                <!-- end user and items section -->

                <!-- comments section  -->
                <!-- comments section  -->

            <div class="row comments">
                <div class="col-sm-6">
                    <div class="panel">

                        <?php $numComments = 6; // number of latest user ?>

                        <div class="panel-heading">
                            <div class="alert alert-info"><i class="fas fa-comments"></i> <p>Latest <?= $numComments?> Comments</p></div>
                            <span class="toggle-info fa-pull-right"><i class="fa fa-minus fa-lg"></i></span>
                        </div>


                        <div class="panel-body ">
                            <?php $stmt = $con->prepare("SELECT
                                                comments.* ,
                                                users.Name AS UserName
                                            FROM
                                                comments
                                            INNER JOIN
                                                users
                                            ON
                                                users.UserId = comments.UserId
                                            ORDER BY
                                                ComId DESC
                                            LIMIT
                                                $numComments");
                            $stmt->execute();
                            // Assign the values in variables
                            $comments = $stmt->fetchAll();
                            if (!empty($comments)) {
                                
                                foreach ($comments as $comment){
                                    if (!empty($comments)) { ?>

                                        <div class="comments-box">
                                            <a href="members.php?do=edit&userId=<?= $comment['UserId']?>"><span class="comUser"><?= $comment['UserName']?></span></a>
                                            <p class="comment"><?= $comment['Comment']?></p>
                                        </div><!-- comment box -->
                                    <?php } 
                                } 
                            }else {
                                echo 'there is no Comments to show';
                            }?>
                        </div><!-- panel body -->
                    </div>
                </div><!-- col-6 -->
            </div><!-- row -->
                <!-- end comments section  -->
                <!-- end comments section  -->
        </div><!-- latest -->
    </section><!-- end dashboard page -->

<?php include $tpl . 'footer.php';
}else {
    header('Location: index.php');
    exit();
}

ob_end_flush();

?>
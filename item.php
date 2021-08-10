<?php
ob_start(); // Start Buferring Output

session_start();
$pageTitle = 'Show Item';
$noHeader = '';
include 'init.php';

    // check if get request item id is numeric & get the integer value of it
    $itemId = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ? intval($_GET['itemId']) : 0;

    $stmt = $con -> prepare("SELECT
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
                            WHERE
                                ItemId = ?
                            AND
                                Approve = 1");
    $stmt->execute(array($itemId));
    $count = $stmt -> rowCount();
    $item = $stmt -> fetch();
    
    if ($count > 0) { ?>
        
        
        <section class="item-page">
            <h1 class="text-center fa-4x text-danger mb-4">Show Category</h1>

            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <img src="layout/images/messi.jpg" class="img-thumbnail" alt="">
                    </div><!-- col-3 for image -->

                    <div class="col-md-9 item-info">
                        <h2><?= $item['Name']?></h2>
                        <p><?= $item['Description']?></p>
                        <ul class="list-unstyled">
                            <li>
                                <i class="far fa-calendar-alt"></i>
                                <span>Added Date : </span><?= $item['AddDate']?>
                            </li>

                            <li>
                                <i class="fas fa-money-bill-alt"></i>
                                <span>Price :</span>$ <?= $item['Price']?>
                            </li>
                            
                            <li>
                                <i class="fa fa-building"></i>
                            <span>Made In : </span><?= $item['CountryMade']?>
                            </li>
                            
                            <li>
                                <i class="fa fa-tags"></i>
                                <span>Category : </span><a href="categories.php?pageId=<?= $item['CatId']?>&pageName="><?= $item['CatName']?></a>
                            </li>

                            <li>
                                <i class="far fa-user"></i>
                                <span>Added By : </span><a href="#"><?= $item['UserName']?></a>
                            </li>

                            <li class="tags">
                                <i class="fa fa-tags"></i>
                                <span>Tags : </span>
                                <ul class="list-unstyled">
                                <?php
                                $allTags = explode(',' , $item['Tags']);
                                foreach ($allTags as $tag){
                                    $tag = str_replace(' ' , '' , $tag);
                                    if (!empty($tag)) { ?>
                                        <li><a href="tags.php?name=<?= strtolower($tag)?>"><?= $tag?></a></li>
                                    <?php }
                                } ?>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- col-9 for info -->
                </div><!-- row -->

                <div class="line"></div>
                <div class="row">
                    <div class="col-md-3 offset-3">
                        <?php if (isset($_SESSION['user'])) { ?>
                        <div class="add-comment">
                            <h3>Add Your Comment</h3>
                            <form action="<?= $_SERVER['PHP_SELF']?>?itemId=<?= $item['ItemId']?>" method="POST">
                                <textarea name="comment" id="" cols="30" rows="5" class="form-control" autocomplete="on" required></textarea>
                                <input class="btn btn-danger" type="submit" value="Add Comment">
                            </form>

                            <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $comment  = filter_var($_POST['comment'] , FILTER_SANITIZE_STRING);
                                    $itemId   = $item['ItemId'];
                                    $userId   = $_SESSION['uId'];

                                    if (!empty($comment)) {
                                        $stmt = $con->prepare("INSERT INTO
                                            comments(Comment , Status , ComDate , ItemId , UserID)
                                            VALUES
                                            (:zcomment , 0 , now() , :zitemid , :zuserid)");
                                        
                                        $stmt->execute(array(
                                            'zcomment' => $comment,
                                            'zitemid' => $itemId,
                                            'zuserid' => $userId
                                        ));

                                        if ($stmt) {
                                            echo '<div class="container alert alert-success"> Comment Added</div>';
                                        }
                                    }
                                }
                            ?>
                        </div><!-- add Comment -->
                        <?php }else {
                            echo '<div class="my-4 alert alert-info">Login Or Register To Add Comment</div>';
                        }?>
                    </div><!-- col-3 -->
                </div><!-- row -->

                <div class="line"></div>

                <?php
                    $stmt = $con->prepare("SELECT
                                                comments.* ,
                                                users.Name AS UserName
                                            FROM
                                                comments
                                            INNER JOIN
                                                users
                                            ON
                                                users.UserId = comments.UserId
                                            where
                                                ItemId = ?
                                            AND
                                                Status = 1
                                            ORDER BY ComId Desc");
                    $stmt->execute(array($item['ItemId']));
                    // Assign the values in variables
                    $comments = $stmt->fetchAll();

            foreach ($comments as $comment){ ?>
                <div class="comment-box">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <div class="head">
                                <img src="layout/images/messi.jpg" alt="">
                                <h4><?= $comment['UserName'] ?></h4>
                            </div><!-- head -->
                        </div><!-- col-3 -->
                        
                        <div class="col-md-10">
                            <p class="comment"><?= $comment['Comment']?></p>
                        </div><!-- col-9 -->
                    </div><!-- row -->
                    <div class="line"></div>
                </div><!-- comment box -->
            <?php } ?>
            </div><!-- container -->
        </section><!-- item page -->
        
    <?php }else {
        echo '<div class="container alert alert-danger errorMsg">';
            $errMsg = 'Sorry Theres No Such Id Or This Item Is Waiting Approval</div>';
            redirect($errMsg , 'back');
        echo '</div>';
    } ?>

<?php 
include $tpl . 'footer.php';

ob_end_flush();

?>
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
    <link rel="stylesheet" href="<?=$css?>admin.css">
</head>
<body>

<section class="dashNav">
    <div class="container-fluid">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link <?php if($pageTitle == 'Dashboard'){echo 'active';}?>" href="dashboard.php">Home</a></li>
            <li class="nav-item"><a class="nav-link <?php if($pageTitle == 'Categories'){echo 'active';}?>" href="categories.php">Categories</a></li>
            <li class="nav-item"><a class="nav-link <?php if($pageTitle == 'Items'){echo 'active';}?>" href="items.php">Items</a></li>
            <li class="nav-item"><a class="nav-link <?php if($pageTitle == 'Members'){echo 'active';}?>" href="members.php">Members</a></li>
            <li class="nav-item"><a class="nav-link <?php if($pageTitle == 'Comments'){echo 'active';}?>" href="comments.php">Comments</a></li>
            <li class="nav-item"><a class="nav-link <?php if($pageTitle == 'Statistics'){echo 'active';}?>" href="#">Statistics</a></li>
            <li class="nav-item"><a class="nav-link <?php if($pageTitle == 'Logs'){echo 'active';}?>" href="#">Logs</a></li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle  btn btn-dark" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= $_SESSION['userName']?></a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="members.php?do=edit&userId=<?= $_SESSION['Id']?>">Edit Profile</a>
                    <a class="dropdown-item" href="../index.php">Visit Shop</a>
                    <a class="dropdown-item" href="#">Settings</a>
                <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </div><!-- container -->
</section><!-- end of dashboard navbar -->
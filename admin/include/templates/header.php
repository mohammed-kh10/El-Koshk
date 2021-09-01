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
<?php
// check if user coming from HTTP post Request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                                Password = ?
                            AND
                                GroupId = 1
                            LIMIT 1");
    $stmt->execute(array($userName , $hashPassword));
    $row = $stmt -> fetch();
    $count = $stmt -> rowCount();

    if ($count > 0) {
        $_SESSION['userName'] = $userName; // register session by user name
        $_SESSION['UserId'] = $row['UserId'];
        header('Location: dashboard.php'); // redirct to dashboard page
        exit();
    }
}
?>


<!-- Modal -->
<div class="admin-login" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <div class="btns">
                    <button class="btn btn-light btnTab activeBtn" data-mark="login"><i class="fas fa-unlock-alt"></i> Login</button>
                </div><!-- btns -->
            </div><!-- header -->

            <div class="modal-body">
                <div class="content">
                    <div class="itemTabs activeItem" id="login">
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                            <label for="userName">User Name</label>
                            <input type="text" name="userName" id="userName" placeholder="     mohammed">

                            <label for="password">Password</label>
                            <input type="password" name="password" id="password">

                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remeber me</label>

                            <a href="#">Forgot Password?</a>

                            <input type="submit" value="login" id="login">
                        </form>
                    </div><!-- content activeItem 1 -->

                </div><!-- about-content -->
            </div><!-- body -->
        </div><!-- content -->
    </div><!-- modal dialog -->
</div><!-- end of  modal section -->
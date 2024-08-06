<?php
session_start();
include("backend_handler.php");

$check=new Backend_handler();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .login {
        margin-left:30%;
        margin-top:10%

    }
</style>
<body>
    <div class="container">
        <div class="login col-lg-4 bg-secondary p-4">

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <h2 class="text-white">LOGIN FORM to SMS</h2>
    <div class="row">
        <div class="col-lg-3">
            <label for="email">Email:</label>
        </div>  
        <div class="col">
            <?php
            $emailValue = "";
            if (isset($_COOKIE['user'])) {
                $userinf = unserialize($_COOKIE['user']);
                if (isset($userinf['email'])) {
                    $emailValue = htmlspecialchars($userinf['email']);
                }
            }
            ?>
            <input type="email" name="email" value="<?php echo $emailValue; ?>" class="form-control" placeholder="Enter your email address">
        </div>
    </div> 
    <div class="error">
        <?php echo isset($_POST['email']) ? $check->validateemail($_POST['email']) : ""; ?>
    </div> 
    <br>
    <div class="row">
        <div class="col-lg-3">
            <label for="password">Password:</label>
        </div>  
        <div class="col">
            <?php
            $passwordValue = "";
            if (isset($_COOKIE['user'])) {
                $userinf = unserialize($_COOKIE['user']);
                if (isset($userinf['password'])) {
                    $passwordValue = htmlspecialchars($userinf['password']);
                }
            }
            ?>
            <input type="password" name="password" value="<?php echo $passwordValue; ?>" class="form-control" placeholder="Password">
        </div>
    </div>
    <br>
    <input type="submit" name="login" value="Login" class="btn btn-dark">
</form>

    <?php

    if(isset($_POST['login'])){
     
        $errorvalidateemail= $check->validateemail($_POST['email']);
        $password=$check->test_input($_POST['password']);
        if(!$errorvalidateemail){
            $email=$check->test_input($_POST['email']);
            $check->login($email,$password);
        }
    }
    ?>

    </div>
    </div>
    
</body>
</html>
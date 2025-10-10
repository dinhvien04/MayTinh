<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: login.php");
    exit;
}

require_once "config.php";
require_once "functions.php";

$newform = $email_err = $OTP_err = $confirm_err = $pass_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["password"])){
        $result = reset_password_with_otp($link, $_POST);
        if(is_array($result)) {
            $email_err = $result['email_err'];
            $OTP_err = $result['OTP_err'];
            $pass_err = $result['pass_err'];
            $confirm_err = $result['confirm_err'];
            $newform = $result['newform'];
        } else {
            header("Location: login.php?state=done");
            exit;
        }
    }else{
        $result = send_reset_otp($link, $_POST['email']);
        if(is_array($result)) {
            $email_err = $result['email_err'];
            $newform = $result['newform'];
        } else {
            $newform = $result;
        }
    }
} else {
    $newform = '
    <div class="form-group" >
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
        <span class="invalid-feedback">'.$email_err.'</span>
    </div>
    ';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Horizon Computers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="container-fluid" >
        <div class="row">
            <div class="col-12 d-flex justify-content-center">

                    <h2 style="padding: 80px;">Password reset</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                    <p>Please fill with given OTP to reset the <b>password</b></p>
                            <?php 
                        if(!empty($login_err)){
                            echo '<div class="alert alert-danger">' . $login_err . '</div>';
                        }        
                        ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                            <?php echo $newform; ?>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Verify">
                            </div>
                            <p>Don't have an account? <a href="register.php"></a>.</p>
                        </form>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row"></div>
        <div class="row">
            <div class="col-12">
                <br><br><br><br><br><br><br><br><br><br>
                    <a href="../index.php" class="btn btn-success"><i class="bi bi-arrow-left"></i>         Back to Site</a>
                <br><br><br><br><br><br><br><br><br>
            </div>
        </div>

        <?php include '../preset/footer.php';?>

    </div>
</body>
</html>

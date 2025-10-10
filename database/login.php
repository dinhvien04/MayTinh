<?php
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index.php");
    exit;
}

require_once "config.php";
require_once "functions.php";

$email = $password = "";
$email_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($email_err) && empty($password_err)){
        $login_result = login_user($link, $email, $password);
        if($login_result !== true) {
            $login_err = $login_result;
        }
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>VIEN Computers</title>
    <link rel ="icon" href="assets/V.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <script>
        <?php 
        if (isset($_GET['state']) && $_GET['state'] == "done") {
            echo '
            swal("Reseted!", "Now you can log with new password!", "success");
            ';
          }
        ?>
    </script>
    <div class="container-fluid" >
        <div class="row">
            <div class="col-12 d-flex justify-content-center">

                    <h2 style="padding-top: 40px;padding-bottom: 40px;">VIEN Computers Login</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            <p>Vui lòng điền thông tin đăng nhập của bạn để đăng nhập .</p>

<?php 
if(!empty($login_err)){
    echo '<div class="alert alert-danger">' . $login_err . '</div>';
}        
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group">
        <label>Tài khoản</label>
        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
        <span class="invalid-feedback"><?php echo $email_err; ?></span>
    </div>    
    <div class="form-group">
        <label>Mật khẩu</label>
        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
        <span class="invalid-feedback"><?php echo $password_err; ?></span>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Login">
    </div>
    <p>Bạn chưa có tài khoản: <a href="register.php">Đăng kí ngay bây giờ</a><br>
    <span style="display: block; margin-top: 10px;">Quên mật khẩu: <a href="reset_password.php">Đặt lại mật khẩu</a></span>
</p>

</div>
<div class="col-md-4"></div>
</div>
<div class="row"></div>
<div class="row">
<div class="col-12">
<br><br><br><br><br><br><br><br><br><br>

<a href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php'; ?>" class="btn btn-success">
    <i class="bi bi-arrow-left"></i> Quay lại
</a>
<br><br><br><br><br><br><br><br>
</div>
</div>

<?php include '../preset/footer.php';?>

</div>
</body>
</html>

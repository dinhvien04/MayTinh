<?php
session_start();

require_once "config.php";
require_once "functions.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Logged-in user changing password
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $old_password_err = $new_password_err = $confirm_password_err = $msg = "";

    //Get current password from DB
    $sql = "SELECT password FROM users WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(!password_verify($old_password, $hashed_password)){
                        $old_password_err = "Mật khẩu cũ không đúng.";
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
    }

    if(empty(trim($new_password))){
        $new_password_err = "Vui lòng nhập mật khẩu mới.";
    } elseif(strlen(trim($new_password)) < 6){
        $new_password_err = "Mật khẩu phải có ít nhất 6 ký tự.";
    }

    if(empty(trim($confirm_password))){
        $confirm_password_err = "Vui lòng xác nhận mật khẩu.";
    } else{
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Mật khẩu không khớp.";
        }
    }

    if(empty($old_password_err) && empty($new_password_err) && empty($confirm_password_err)){
        $param_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $param_password, $_SESSION['id']);
            if(mysqli_stmt_execute($stmt)){
                $msg = "done";
            } else{
                $msg = "Rất tiếc! Đã xảy ra lỗi. Vui lòng thử lại sau.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    echo ($old_password_err . "&&" . $new_password_err . "&&" . $confirm_password_err . "&&" . $msg);

} else {
    // Logged-out user resetting password with OTP
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
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>VIEN Computers</title>
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

                    <h2 style="padding: 80px;">Đặt lại mật khẩu</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                    <p>Vui lòng điền OTP đã cho để đặt lại <b>mật khẩu</b></p>
                            <?php 
                        if(!empty($login_err)){
                            echo '<div class="alert alert-danger">' . $login_err . '</div>';
                        }        
                        ?>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                            <?php echo $newform; ?>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Xác minh">
                            </div>
                            <p>Không có tài khoản? <a href="register.php"></a>.</p>
                        </form>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row"></div>
        <div class="row">
            <div class="col-12">
                <br><br><br><br><br><br><br><br><br><br>
                    <a href="../index.php" class="btn btn-success"><i class="bi bi-arrow-left"></i>         Quay lại trang web</a>
                <br><br><br><br><br><br><br><br><br>
            </div>
        </div>

        <?php include '../preset/footer.php';?>

    </div>
</body>
</html>
<?php
}
?>

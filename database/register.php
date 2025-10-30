<?php
require_once "config.php";
require_once "functions.php";

$fname = $lname = $email = $password = $confirm_password = "";
$fname_err = $lname_err = $email_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $trimmed_fname = trim($_POST["fname"]);
    if(empty($trimmed_fname)){
        $fname_err = "Vui lòng nhập tên.";     
    } else{
        $fname = $trimmed_fname;
    }

    $trimmed_lname = trim($_POST["lname"]);
    if(empty($trimmed_lname)){
        $lname_err = "Vui lòng nhập họ.";     
    } else{
        $lname = $trimmed_lname;
    }

    $trimmed_email = trim($_POST["email"]);
    if(empty($trimmed_email)){
        $email_err = "Vui lòng nhập email.";
    } else{
        $email = $trimmed_email;
    }
    
    $trimmed_password = trim($_POST["password"]);
    if(empty($trimmed_password)){
        $password_err = "Vui lòng nhập mật khẩu.";     
    } elseif(strlen($trimmed_password) < 6){
        $password_err = "Mật khẩu phải có ít nhất 6 ký tự.";
    } else{
        $password = $trimmed_password;
    }
    
    $trimmed_confirm_password = trim($_POST["confirm_password"]);
    if(empty($trimmed_confirm_password)){
        $confirm_password_err = "Vui lòng xác nhận mật khẩu.";     
    } else{
        $confirm_password = $trimmed_confirm_password;
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Mật khẩu không khớp.";
        }
    }
    
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($fname_err) && empty($lname_err)){
        $result = register_user($link, $_POST, $_FILES);
        echo $result;
    }
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

                    <h2 style="padding: 80px;">Đăng ký VIEN Computers</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                    <p>Vui lòng điền vào biểu mẫu này để tạo một tài khoản.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Tên</label>
                            <input type="text" name="fname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fname; ?>">
                            <span class="invalid-feedback"><?php echo $fname_err; ?></span>
                        </div>    
                        <div class="form-group">
                            <label>Họ</label>
                            <input type="text" name="lname" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lname; ?>">
                            <span class="invalid-feedback"><?php echo $lname_err; ?></span>
                        </div>    
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>    
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Ảnh</label>
                                    <input type="file" class="form-control-file" name="image" onchange="readURL(this);">
                                </div>
                                <div class="form-group col-md-3">
                                    <img id="preview" src="http://placehold.it/180" alt="your image" style="width: 200px;">
                                </div>
                                <script>
                                    function readURL(input) {
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function (e) {
                                                document.getElementById("preview").src = e.target.result;
                                            };

                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Gửi">
                            <input type="reset" class="btn btn-secondary ml-2" value="Đặt lại">
                        </div>
                        <p>Bạn có sẵn sàng để tạo một tài khoản? <a href="login.php">Đăng nhập tại đây</a>.</p>
                    </form>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row"></div>
        <div class="row">
            <div class="col-12">
                <br><br><br><br><br><br>
                    <a href="../index.php" class="btn btn-success"><i class="bi bi-arrow-left"></i>         Quay lại trang web</a>
                <br><br><br><br><br><br><br><br>
            </div>
        </div>

        <?php include '../preset/footer.php';?>

    </div>   
</body>
</html>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

function send_verification_email($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['GMAIL_EMAIL'];
        $mail->Password   = $_ENV['GMAIL_APP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom($_ENV['GMAIL_EMAIL'], 'VIEN Computers');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Mã đặt lại mật khẩu VIEN Computers của bạn';
        $template = file_get_contents(__DIR__ . '/email_template.html');
        $mail->Body    = str_replace('{{OTP}}', $otp, $template);
        $mail->AltBody = 'Mã đặt lại mật khẩu của bạn là: ' . $otp;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function register_user($link, $post_data, $files) {
    $fname = $post_data['fname'];
    $lname = $post_data['lname'];
    $email = $post_data['email'];
    $password = $post_data['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT verification FROM users WHERE email = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 1 && $row['verification'] == 1) {
        return "Email này đã được sử dụng.";
    } else if (mysqli_num_rows($result) == 1) {
        $sql2 = "UPDATE users SET FirstName=?, LastName=?, password=?, verification=1 WHERE email= ?";
        $stmt2 = mysqli_prepare($link, $sql2);
        mysqli_stmt_bind_param($stmt2, "ssss", $fname, $lname, $hashed_password, $email);
    } else {
        $sql2 = "INSERT INTO users (FirstName, LastName, password, verification, email) VALUES (?,?,?,?,?)";
        $stmt2 = mysqli_prepare($link, $sql2);
        mysqli_stmt_bind_param($stmt2, "sssis", $fname, $lname, $hashed_password, 1, $email);
    }

    if(mysqli_stmt_execute($stmt2)){
        // Handle file upload
        if (isset($files['image']) && $files['image']['error'] == 0) {
            $sql = "SELECT ID FROM users WHERE email = ?";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $imageup = $row['ID'];

            $target_dir = "../photo2/";
            $target_file = $target_dir . $imageup . '.jpg';
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $check = getimagesize($files["image"]["tmp_name"]);
            $mime_type = mime_content_type($files["image"]["tmp_name"]);
            $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif'];

            if($check === false || !in_array($mime_type, $allowed_mime_types)) {
                return "Tệp không phải là hình ảnh hợp lệ.";
            }

            if ($files["image"]["size"] > 500000) {
                return "Xin lỗi, tệp của bạn quá lớn.";
            }

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                return "Xin lỗi, chỉ cho phép các tệp JPG, JPEG, PNG & GIF.";
            }

            if (move_uploaded_file($files["image"]["tmp_name"], $target_file)) {
                $sql = "UPDATE users SET Propic=? WHERE email= ?";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $target_file, $email);
                mysqli_stmt_execute($stmt);
            } else {
                return "Xin lỗi, đã xảy ra lỗi khi tải tệp của bạn lên.";
            }
        }

        header("location: login.php");
        return "Đăng ký thành công. Vui lòng đăng nhập.";
    } else {
        return "Rất tiếc! Đã xảy ra lỗi. Vui lòng thử lại sau.";
    }
}

function login_user($link, $email, $password) {
    $sql = "SELECT id, email, verification, password FROM users WHERE email = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        
        $param_email = $email;
        
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1){                    
                mysqli_stmt_bind_result($stmt, $id, $email, $verification, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if($verification==true){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;                            
                            
                            header("location: ../index.php");
                            return true;
                        } else{
                            return "Email hoặc mật khẩu không hợp lệ.";
                        }
                    }else{
                        header("location: verify.php");
                        return "Vui lòng xác minh địa chỉ email của bạn.";
                    }
                }
            } else{
                return "Email hoặc mật khẩu không hợp lệ.";
            }
        } else{
            return "Rất tiếc! Đã xảy ra lỗi. Vui lòng thử lại sau.";
        }

        mysqli_stmt_close($stmt);
    }
}

function send_reset_otp($link, $email) {
    $email_err = "";
    $OTP_err = "";
    $pass_err = "";
    $confirm_err = "";
    $OTP_err = "";
    $pass_err = "";
    $confirm_err = "";
    $trimmed_email = trim($email);
    if(empty($trimmed_email)){
        $email_err = "Vui lòng nhập email.";
        return ['email_err' => $email_err, 'newform' => '' ];
    }

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $trimmed_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 0){
        $email_err = "Email này chưa được đăng ký.";
        return ['email_err' => $email_err, 'newform' => '' ];
    }

    $otp = rand(100000,999999);
    $sql = "UPDATE users SET otp=? WHERE email= ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $otp, $trimmed_email);
    mysqli_stmt_execute($stmt);

    send_verification_email($trimmed_email, $otp);

    $newform='
    <div class="form-group" >
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="'.$trimmed_email.'" required readonly>
        <span class="invalid-feedback">'.$email_err.'</span>
    </div>
    <div class="form-group">
        <label>OTP</label>
        <input type="text" name="OTP" class="form-control" required>
        <span class="invalid-feedback">'.$OTP_err.'</span>
    </div>
    <div class="form-group">
        <label>Mật khẩu mới</label>
        <input type="password" name="password" class="form-control" required>
        <span class="invalid-feedback">'.$pass_err.'</span>
    </div>
    <div class="form-group">
        <label>Xác nhận mật khẩu</label>
        <input type="password" name="confirm" class="form-control" required>
        <span class="invalid-feedback">'.$confirm_err.'</span>
    </div>
    ';

    return $newform;
}

function reset_password_with_otp($link, $post_data) {
    $password = $post_data["password"];
    $confirm = $post_data["confirm"];
    $email = $post_data["email"];
    $OTP = $post_data["OTP"];

    $pass_err = $confirm_err = $OTP_err = $email_err = "";

    if($confirm!=$password){
        $pass_err="Mật khẩu không khớp";
        $confirm_err ="Mật khẩu không khớp";
    }
    if($confirm=="" || $password==""){
        $pass_err="Mật khẩu trống";
        $confirm_err ="Mật khẩu trống";
    }

    $DOTP=null;
    $sql = "SELECT otp FROM users WHERE email= ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $Row = mysqli_fetch_assoc($result);
    $DOTP = $Row['otp'];

    if($OTP == $DOTP){
        $OTP_err="";
    }else{
        $OTP_err="OTP không khớp";
    }

    if($OTP_err=="" && $confirm_err=="" && $pass_err==""){
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET Password=? WHERE email= ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $param_password, $email);
        mysqli_stmt_execute($stmt);
        return true;
    }else{
        $a1 = !empty($OTP_err) ? "is-invalid" : "";
        $a2 = !empty($pass_err) ? "is-invalid" : "";
        $a3 = !empty($confirm_err) ? "is-invalid" : "";
        $newform='
        <div class="form-group" >
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="'.$email.'" required readonly>
            <span class="invalid-feedback">'.$email_err.'</span>
        </div>
        <div class="form-group">
            <label>OTP</label>
            <input type="text" name="OTP" class="form-control '.$a1.'" value="'.$OTP.'" required>
            <span class="invalid-feedback">'.$OTP_err.'</span>
        </div>
        <div class="form-group">
            <label>Mật khẩu mới</label>
            <input type="password" name="password" class="form-control '.$a2.'" value="'.$password.'" required>
            <span class="invalid-feedback">'.$pass_err.'</span>
        </div>
        <div class="form-group">
            <label>Xác nhận mật khẩu</label>
            <input type="password" name="confirm" class="form-control '.$a3.'" value="'.$confirm.'" required>
            <span class="invalid-feedback">'.$confirm_err.'</span>
        </div>
        ';
        return [
            'email_err' => $email_err,
            'OTP_err' => $OTP_err,
            'pass_err' => $pass_err,
            'confirm_err' => $confirm_err,
            'newform' => $newform
        ];
    }
}

function verify_user($link, $email, $otp) {
    $sql = "SELECT otp, email FROM users WHERE email = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        
        $param_email = $email;
        
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1){                    
                mysqli_stmt_bind_result($stmt, $db_otp, $db_email);
                if(mysqli_stmt_fetch($stmt)){
                    if($db_otp == $otp && $db_email == $email){
                        $sql = "UPDATE users SET verification=1 WHERE email= ?";
 
                        if($stmt_update = mysqli_prepare($link, $sql)){
                            mysqli_stmt_bind_param($stmt_update, "s", $param_email_update);
                            $param_email_update = $email;
                             
                            if(mysqli_stmt_execute($stmt_update)){
                                header("location: login.php");
                                return true;
                            } else{
                                return "Rất tiếc! Đã xảy ra lỗi. Vui lòng thử lại sau.";
                            }
                            mysqli_stmt_close($stmt_update);
                        }
                    } else{
                        return "otp hoặc email không hợp lệ.";
                    }
                }
            } else{
                return "otp hoặc email không hợp lệ.";
            }
        } else{
            return "Rất tiếc! Đã xảy ra lỗi. Vui lòng thử lại sau.";
        }

        mysqli_stmt_close($stmt);
    }
}

?>
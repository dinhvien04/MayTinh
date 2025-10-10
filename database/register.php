<?php
require_once "config.php";
require_once "functions.php";

$fname = $lname = $email = $password = $confirm_password = "";
$fname_err = $lname_err = $email_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate First Name
    if(empty(trim($_POST["fname"]))){
        $fname_err = "Please enter the first name.";     
    } else{
        $fname = trim($_POST["fname"]);
    }

    // Validate Last Name
    if(empty(trim($_POST["lname"]))){
        $lname_err = "Please enter the last name.";     
    } else{
        $lname = trim($_POST["lname"]);
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($fname_err) && empty($lname_err)){
        $result = register_user($link, $_POST, $_FILES);
        echo $result;
    }
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

                    <h2 style="padding: 80px;">Horizon Computers Sign Up</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                    <p>Please fill this form to create an account.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fname; ?>">
                            <span class="invalid-feedback"><?php echo $fname_err; ?></span>
                        </div>    
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lname" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lname; ?>">
                            <span class="invalid-feedback"><?php echo $lname_err; ?></span>
                        </div>    
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
                        </div>    
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Image</label>
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
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                        </div>
                        <p>Already have an account? <a href="login.php">Login here</a>.</p>
                    </form>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row"></div>
        <div class="row">
            <div class="col-12">
                <br><br><br><br><br><br>
                    <a href="../index.php" class="btn btn-success"><i class="bi bi-arrow-left"></i>         Back to Site</a>
                <br><br><br><br><br><br><br><br>
            </div>
        </div>

        <?php include '../preset/footer.php';?>

    </div>   
</body>
</html>

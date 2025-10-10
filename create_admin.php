<?php
require_once "database/config.php";

$username = "admin";
$password = "password";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$email = "admin@example.com";
$sql = "INSERT INTO admin (UserName, Password, Email) VALUES (?, ?, ?)";

if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $email);
    
    if(mysqli_stmt_execute($stmt)){
        echo "A new admin user has been created with the username 'admin' and password 'password'. You can now log in with these credentials.";
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($link);
?>
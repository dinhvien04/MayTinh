<?php
require_once "database/config.php";

$sql = "SELECT UserName, Password FROM admin";
$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo "Username: " . $row["UserName"]. " - Password Hash: " . $row["Password"]. "\n";
    }
} else {
    echo "The admin table is empty.";
}

mysqli_close($link);
?>
<?php
session_start();

$logediin = false;
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $logediin = true;
}
?>
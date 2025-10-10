<?php
require_once "../database/config.php";
require_once "admin_functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if($_POST['task'] == "AddNew"){
        $result = add_product($link, $_POST, $_FILES);
        echo $result;
    }

    if($_POST['task'] == "get_products"){
        $category = $_POST['Category'] ?? 'laptop';
        $brand = $_POST['Brand'] ?? '';
        $limit = $_POST['limit'] ?? 20;
        $products = get_products($link, $category, $brand, $limit);
        echo $products;
    }

    if($_POST['task'] == "ProductUpdate"){
        $result = update_product($link, $_POST);
        echo $result;
    }

    if($_POST['task'] == "delivery"){
        $ID = $_POST['ID'];
        $sql = "UPDATE orders SET DeliveryState='Delivered' WHERE ID=?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $ID);
        if(mysqli_stmt_execute($stmt)) {
            echo "Updated successfully";
        }
        else{
            echo mysqli_error($link);
        }
    }

    if($_POST['task'] == "tableupdate"){
        echo get_orders($link);
    }

    if($_POST['task'] == "showcustomer"){
        $email = $_POST['CustomerEmail'];
        echo get_customer_info($link, $email);
    }

    if($_POST['task'] == "changePassword"){
        echo change_password($link, $_SESSION["ADMINid"], $_POST['new_password'], $_POST['confirm_password']);
    }

    if($_POST['task'] == "adminUpdate"){
        echo admin_update($link, $_SESSION["ADMINid"], $_POST['FirstName'], $_POST['LastName']);
    }

}
?>
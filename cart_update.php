<?php

    
if($_SERVER["REQUEST_METHOD"] == "POST"){

    session_start();
 
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        $logediin=false;
    }else{
        $logediin=true;
    }

    if($logediin==false){
        echo "login";

    }else{
                require_once "database/config.php";

                switch ($_POST['task']) {
                    case 'delete':
                        //============================================================================DELETE=============================================================================
                        $CartID = $_POST['ID'];
            
                        $sql = "DELETE FROM cart WHERE ID = ?";
                        $stmt = mysqli_prepare($link, $sql);
                        mysqli_stmt_bind_param($stmt, "i", $CartID);
                        mysqli_stmt_execute($stmt);
                        echo mysqli_error($link);
        
                        $sql = "SELECT products.Image, products.Price, products.Name, products.ID, cart.Quantity, cart.ID AS cart FROM cart INNER JOIN products ON cart.ProductID = products.ID where cart.CustomerEmail = ?
                        UNION
                        SELECT custompc.Image, custompc.Price, custompc.Name, custompc.ID, cart.Quantity, cart.ID AS cart FROM cart INNER JOIN custompc ON cart.ProductID = custompc.ID where cart.CustomerEmail = ?;";
                        $stmt = mysqli_prepare($link, $sql);
                        mysqli_stmt_bind_param($stmt, "ss", $_SESSION['email'], $_SESSION['email']);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                    
                        if($result = mysqli_query($link, $sql)) {
                            if(mysqli_num_rows($result)>0){
                                $output = '';
                                while($row = mysqli_fetch_assoc($result)){
                                    $output .='  
                                            <div class="row border shadow p-3 mb-3 bg-white rounded" >
                                            <div class="col-3 bg-light">
                                                <img src="'.$row['Image'].'" alt="" width="100%">
                                            </div>
                                            <div class="col-6">
                                                <p class="card-text">'.$row['Name'].'</p><h6>Quantity 
                                                <select name="'.$row['ID'].'" id="'.$row['cart'].'" onchange="cartUpdate(this)" disabled>
                                                    <option value="'.$row['Quantity'].'" disabled selected>'.$row['Quantity'].'</option>
                                                    <option value=1>1</option>
                                                    <option value=2>2</option>
                                                    <option value=3>3</option>
                                                </select>
                                                </h6><h5>RS:'.$row['Price'].'</h5>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" class="btn btn-warning mb-2" value="'.$row['cart'].'" onclick="cartEnable(this)">Edit</button><br>
                                                <button type="button" class="btn btn-danger mb-2" value="'.$row['cart'].'" onclick="cartDelete(this)">Delete</button>
                                                <button type="button" class="btn btn-success mb-2" value="'.$row['ID'].'&&'.$row['Name'].'&&'.$row['Price'].'&&'.$row['cart'].'" onclick="cartBuy(this)">Proceed to Checkout</button>
                                            </div>
                                        </div>
                                        ';
                                }
                                echo $output;
                            }
                            else{
                                echo "nothing";
                            }
                        }
                        else{
                            echo mysqli_error($link);
                        }
                      break;
                    case 'update':
                      //============================================================================DELETE=============================================================================
                        $quantity = $_POST["quantity"];
                        $productID = $_POST["ID"];
                        $sql = "UPDATE cart SET Quantity=? WHERE CustomerEmail=? AND ProductID=? ; ";
                        $stmt = mysqli_prepare($link, $sql);
                        mysqli_stmt_bind_param($stmt, "iss", $quantity, $_SESSION['email'], $productID);

                        if(mysqli_stmt_execute($stmt)) {
                            echo "Successfully Updated";
                        }
                        else{
                            echo mysqli_error($link);
                        }
                      break;
                    case 'userUpdate':
                    //============================================================================DELETE=============================================================================
                        $address = $_POST['address'];
                        $address2 = $_POST['address2'];
                        $city = $_POST['city'];
                        $phone = $_POST['phone'];

                        $sql = "UPDATE users SET AddressLine1=?,AddressLine2=?, City=?, Phone=? WHERE Email=?";
                        $stmt = mysqli_prepare($link, $sql);
                        mysqli_stmt_bind_param($stmt, "sssss", $address, $address2, $city, $phone, $_SESSION['email']);

                        if(mysqli_stmt_execute($stmt)) {
                            echo "Updated successfully";
                        }
                        else{
                            echo mysqli_error($link);
                        }
                    break;
                  }

    }


}

?>
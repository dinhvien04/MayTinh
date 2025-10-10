<?php

function get_total_earnings_last_30_days($link) {
    $sql = "SELECT SUM(TotalAmount) AS total_earnings FROM orders WHERE Date >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_earnings'] ?? 0;
}

function get_total_annual_earnings($link) {
    $sql = "SELECT SUM(TotalAmount) AS total_earnings FROM orders WHERE YEAR(Date) = YEAR(NOW())";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_earnings'] ?? 0;
}

function get_pending_requests($link) {
    $sql = "SELECT COUNT(*) AS pending_requests FROM orders WHERE DeliveryState = 'pending'";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['pending_requests'] ?? 0;
}

function get_product_categories($link) {
    $sql = "SELECT DISTINCT Category FROM products";
    $result = mysqli_query($link, $sql);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['Category'];
    }
    return $categories;
}

function get_category_counts($link) {
    $sql = "SELECT Category, COUNT(*) as count FROM products GROUP BY Category";
    $result = mysqli_query($link, $sql);
    $counts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $counts[] = $row['count'];
    }
    return $counts;
}

function get_monthly_earnings($link) {
    $sql = "SELECT MONTH(Date) as month, SUM(TotalAmount) as earnings FROM orders WHERE YEAR(Date) = YEAR(NOW()) GROUP BY MONTH(Date)";
    $result = mysqli_query($link, $sql);
    $earnings = array_fill(0, 12, 0);
    while ($row = mysqli_fetch_assoc($result)) {
        $earnings[$row['month'] - 1] = $row['earnings'];
    }
    return $earnings;
}

function add_product($link, $post_data, $files) {
    $cat = $post_data['Category'];
    $Price = $post_data['Price'];
    $Brand = $post_data['Brand'];
    $Name = $post_data['Name'];
    $Spec1 = $post_data['Spec1'];
    $Spec2 = $post_data['Spec2'];
    $Spec3 = $post_data['Spec3'];
    $Spec4 = $post_data['Spec4'];
    $Quantity = $post_data['Quantity'];
    $About = $post_data['About'];

    $Category="";
    $IDCat="";
    $img="";

    switch($cat){
        case 'Laptop':
            $Category="laptop";
            $IDCat="LAP";
            $img="laptop";
        break;
        case 'Casing':
            $Category="casing";
            $IDCat="CAS";
            $img="casing";
        break;
        case 'Cooling':
            $Category="cooling";
            $IDCat="COL";
            $img="cooling";
        break;
        case 'Graphics-Card':
            $Category="graphics";
            $IDCat="GPU";
            $img="graphics";
        break;
        case 'MotherBoard':
            $Category="motherboard";
            $IDCat="MBD";
            $img="motherboard";
        break;
        case 'Monitor':
            $Category="monitors";
            $IDCat="MON";
            $img="monitor";
        break;
        case 'Power-Supply':
            $Category="power";
            $IDCat="POW";
            $img="power";
        break;
        case 'Processor':
            $Category="proccessor";
            $IDCat="PRO";
            $img="proccessor";
        break;
        case 'RAM':
            $Category="ram";
            $IDCat="RAM";
            $img="ram";
        break;
        case 'Storage':
            $Category="storage";
            $IDCat="STG";
            $img="storage";
        break;
    }

    $sql = "SELECT ID FROM products WHERE Category = ? ORDER BY ID DESC LIMIT 1";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $Category);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $LastID = $row['ID'];

    $TempID1 = explode($IDCat,$LastID);
    $TempID2 = (int)$TempID1[1];
    $TempID3 = sprintf('%08d',$TempID2+1);
    $NewID = $IDCat.$TempID3;

    $image = "photo2/".$img."/".$NewID.".png";
    $target_file = $image;
    $uploadOk = 1;

    $check = getimagesize($files["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        return "File is not an image.";
    }

    $fileType = strtolower(pathinfo(basename($files["image"]["name"]),PATHINFO_EXTENSION));
    if($fileType != "png") {
        return "Sorry, only PNG files are allowed.";
    }

    if($uploadOk==1){
        if (move_uploaded_file($files["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO products (ID,Category,Price,Brand,Name,  Spec1, Spec2, Spec3, Spec4, Quantity, About,Image) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "ssissssiisss", $NewID, $cat, $Price, $Brand, $Name, $Spec1, $Spec2, $Spec3, $Spec4, $Quantity, $About, $image);

            if(mysqli_stmt_execute($stmt)) {
                return "Product added successfully";
            }
            else{
                return "Error adding product: " . mysqli_error($link);
            }
        } else {
            return "Sorry, there was an error uploading your file.";
        }
    }
}

function get_brands($link) {
    $sql = "SELECT DISTINCT Brand FROM products ORDER BY Brand";
    $result = mysqli_query($link, $sql);
    $brands = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $brands[] = $row['Brand'];
    }
    return $brands;
}

function get_products($link, $category, $brand, $limit) {
    $sql = "SELECT ID,Price,Brand,Name,Availability,Quantity,Spec1, Spec2, Spec3, Spec4,About,Price FROM products WHERE Category = ?";
    $params = ['s', $category];

    if (!empty($brand)) {
        $sql .= " AND Brand = ?";
        $params[0] .= 's';
        $params[] = $brand;
    }

    $sql .= " LIMIT ?";
    $params[0] .= 'i';
    $params[] = $limit;

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $output = '';
    $number = 1;
    while($row = mysqli_fetch_assoc($result)){
        $output .= '                            
        <tr>
        <th scope="row">'.$number.'<hr><h6>Specs</h6></th>
    <form id="'.$row['ID'].'">
        <th scope="col"                      >      <input      class="form-control '.$row['ID'].'" type="text" name="Name" value="'.$row['Name'].'"         style="pointer-events: none;"><input class="form-control '.$row['ID'].'" type="text" name="Spec1" value="'.$row['Spec1'].'" style="pointer-events: none;margin-top:10px;"></th>
        <th style="width: 100px;" scope="col">      <input      class="form-control '.$row['ID'].'" type="text" name="Brand" value="'.$row['Brand'].'"        style="pointer-events: none;"><input class="form-control '.$row['ID'].'" type="text" name="Spec2" value="'.$row['Spec2'].'" style="pointer-events: none;margin-top:10px;"></th>
        <th style="width: 50px;" scope="col" >      <input      class="form-control '.$row['ID'].'" type="text" name="Availability" value="'.$row['Availability'].'" style="pointer-events: none;"><input class="form-control '.$row['ID'].'" type="text" name="Spec3" value="'.$row['Spec3'].'" style="pointer-events: none;margin-top:10px;"></th>
        <th style="width: 50px;" scope="col" >      <input      class="form-control '.$row['ID'].'" type="text" name="Quantity" value="'.$row['Quantity'].'"     style="pointer-events: none;"><input class="form-control '.$row['ID'].'" type="text" name="Spec4" value="'.$row['Spec4'].'" style="pointer-events: none;margin-top:10px;"></th>
        <th style="width: 50px;" scope="col" >      <input      class="form-control '.$row['ID'].'" type="text" name="Price" value="'.$row['Price'].'"        style="pointer-events: none;"></th>
        <th scope="col"                      >      <textarea   class="form-control '.$row['ID'].'" rows="4"    name="About"  cols="50"                    style="pointer-events: none;">'.$row['About'].'</textarea></th>
    </form>
        <th scope="col"                      >      <button onclick="table(\''.$row['ID'].'\')">Edit</button></th>
        <th scope="col"                      >      <button class="'.$row['ID'].'" onclick="submitForm(\''.$row['ID'].'\')" style="pointer-events: none;">Update</button></th>
    </tr>
        
        ';
        $number+=1;
    }
    return $output;
}

function update_product($link, $post_data) {
    $Price = $post_data['Price'];
    $Brand = $post_data['Brand'];
    $Name = $post_data['Name'];
    $Spec1 = $post_data['Spec1'];
    $Spec2 = $post_data['Spec2'];
    $Spec3 = $post_data['Spec3'];
    $Spec4 = $post_data['Spec4'];
    $Quantity = $post_data['Quantity'];
    $About = $post_data['About'];
    $Availability = $post_data['Availability'];
    $ID = $post_data['ID'];

    $sql = "UPDATE products SET Spec1 = ?, Spec2 = ?, Spec3 = ?, Spec4 = ?, Price = ?, Brand = ?, Name = ?, Availability = ?, Quantity = ?, About = ? WHERE ID = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "ssidisisiis", $Spec1, $Spec2, $Spec3, $Spec4, $Price, $Brand, $Name, $Availability, $Quantity, $About, $ID);

    if(mysqli_stmt_execute($stmt)){
        return "Product updated successfully";
    }else{
        return "Error updating product: " . mysqli_error($link);
    }
}

function get_orders($link) {
    $sql = "SELECT orders.*, products.Image, products.Name FROM orders INNER JOIN products ON orders.ItemID = products.ID;";
    $sql2 = "SELECT orders.*, custompc.Name, custompc.CPU, custompc.MotherBoard, custompc.GPU, custompc.RAM, custompc.Cooling, custompc.Storage, custompc.Power, custompc.Casing, custompc.Image FROM orders INNER JOIN custompc ON orders.ItemID = custompc.ID;";

    $result = mysqli_query($link, $sql);
    $result2 = mysqli_query($link, $sql2);

    $output = "";

    while($row = mysqli_fetch_assoc($result)){
        if($row['DeliveryState'] == "pending"){$show = "<span class='badge badge-warning'>Pending</span>";}else{$show = "<span class='badge badge-success'>Delivered</span>";}
        $output.='
                <tr>
                <th scope="row">'.$row['ID'].'</th>
                <td><img src="'.$row['Image'].'" alt="" height="50px"></td>
                <td>'.$row['Name'].'</td>
                <td>'.$row['Quantity'].'</td>
                <td>'.($row['TotalAmount']/$row['Quantity']) .'</td>
                <td>'.$row['TotalAmount'].'</td>
                <td>'.$row['Date'].'</td>
                <td onclick="userinformation(\''.$row['CustomerEmail'].'\')">'.$row['CustomerEmail'].'</td>
                <td>'.$show.'<button onclick="delivery(\''.$row['ID'].'\')">Delivered</button></td>
                </tr>
                ';
    } 

    while($row = mysqli_fetch_assoc($result2)){
            if($row['DeliveryState'] == "pending"){$show = "<span class='badge badge-warning'>Pending</span>";}else{$show = "<span class='badge badge-success'>Delivered</span>";}
            $output.='
                <tr>
                <th scope="row">'.$row['ID'].'</th>
                <td><img src="'.$row['Image'].'" alt="" height="50px"></td>
                <td>'.$row['Name'].'"<br><i>"'.$row['CPU'].' "<br>"'.$row['RAM'].' "<br>"'.$row['Cooling'].' "<br>"'.$row['Storage'].' "<br>"'.$row['Power'].' "<br>"'.$row['Casing']."</i>".'</td>
                <td>'.$row['Quantity'].'</td>
                <td>'.($row['TotalAmount']/$row['Quantity']).'</td>
                <td>'.$row['TotalAmount'].'</td>
                <td>'.$row['Date'].'</td>
                <td onclick="userinformation(\''.$row['CustomerEmail'].'\')">'.$row['CustomerEmail'].'</td>
                <td>'.$show.'<button onclick="delivery(\''.$row['ID'].'\')">Delivered</button></td>
                </tr>
            ';
    } 
    
    return $output;
}

function get_customer_info($link, $email) {
    $sql = "SELECT FirstName,LastName,Email,AddressLine1,AddressLine2,City,Phone FROM users WHERE Email=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $output = $row['FirstName']."<hr>";
    $output .= $row['LastName']."<hr>";
    $output .= $row['Email']."<hr>";
    $output .= $row['AddressLine1']."<hr>";
    $output .= $row['AddressLine2']."<hr>";
    $output .= $row['City']."<hr>";
    $output .= $row['Phone']."<hr>";

    return $output;
}

function change_password($link, $admin_id, $new_password, $confirm_password) {
    $new_password_err = $confirm_password_err = $msg = "";

    if(empty(trim($new_password))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($new_password)) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($new_password);
    }
    
    if(empty(trim($confirm_password))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($confirm_password);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    if(empty($new_password_err) && empty($confirm_password_err)){
        $sql = "UPDATE admin SET password = ? WHERE ID = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $admin_id;
            
            if(mysqli_stmt_execute($stmt)){
                $msg = "done";
            } else{
                $msg = "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    return json_encode([
        'new_password_err' => $new_password_err,
        'confirm_password_err' => $confirm_password_err,
        'msg' => $msg
    ]);
}

function admin_update($link, $admin_id, $fname, $lname) {
    $sql = "UPDATE admin SET FirstName=?, LastName=? WHERE ID=?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $fname, $lname, $admin_id);

    if(mysqli_stmt_execute($stmt)) {
        return "Updated successfully";
    }
    else{
        return mysqli_error($link);
    }
}

?>
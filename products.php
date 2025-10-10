<?php
    if($_SERVER["REQUEST_METHOD"]){ // kiểm tra phương thức yêu cầu

        require_once "database/config.php"; // kết nối cơ sỡ dữ liệu

        // thêm sản phẩm mới (xữ lý khi tast là "AddNew")
        if($_POST['task']=="AddNew"){

            // lấy dữ liệu
            $cat = $_POST['Category'];
            $Price = $_POST['Price'];
            $Brand = $_POST['Brand'];
            $Name = $_POST['Name'];
            $Spec1 = $_POST['Spec1'];
            $Spec2 = $_POST['Spec2'];
            $Spec3 = $_POST['Spec3'];
            $Spec4 = $_POST['Spec4'];
            $Quantity = $_POST['Quantity'];
            $About = $_POST['About'];

            $Category=""; // lưu danh mục sản phẩm 
            $IDCat="";// lưu mã danh mục  
            $img=""; // lưu đường dẫn hình ảnh

    
            // xác định người dùng và mã tương ứng dựa vào lựa chọn của người dùng
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
            //lấy ID của sản phẩm cuối cùng từ cơ sỡ dữ liệu
            $sql = "SELECT ID FROM test_products WHERE Category = '$Category' ORDER BY ID DESC LIMIT 1;";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
            $LastID=$row['ID'];

            // tạo ID mới cho sản phẩm bằng cách tăng số ID lên
            $TempID1 = explode($IDCat,$LastID);
            $TempID2 = (int)$TempID1[1];
            $TempID3 = sprintf('%08d',$TempID2+1);
            $NewID = $IDCat.$TempID3;

            // đường dẫn lưu hình ảnh sản phẩm
            $image = "photo2/".$img."/".$NewID.".png";
            // xử lý hình ảnh tải lên sever
            $target_file = $image;
            $uploadOk = 1;
            // kiểm tra nếu file là ảnh
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;  //hợp lệ
            } else {
                echo "File không phải là ảnh";
                $uploadOk = 0; //k hợp lệ
            }
            // Chỉ cho phép file dạng PNG
            $fileType = strtolower(pathinfo(basename($_FILES["image"]["name"]),PATHINFO_EXTENSION));
            if($fileType != "png") {
                echo "Xin lỗi. Chỉ cho phép file định dạng PNG";
                $uploadOk = 0;
            } 
            // Nếu thành công, Tải flie lên cơ sỡ dữ liệu
            if($uploadOk==1){
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                    // thêm sản phẩm vào csdl
                    $sql = "INSERT INTO test_products (ID,Category,Price,Brand,Name,  Spec1, Spec2, Spec3, Spec4, Quantity, About,Image) VALUES ('$NewID','$cat',$Price,'$Brand','$Name','$Spec1','$Spec2',$Spec3,$Spec4, $Quantity,'$About', '$image')";

                    if(mysqli_query($link, $sql)) {
                        echo "Thêm sản phẩm thành công";
                        echo $LastID,$TempID3,$NewID;
                    }
                    else{
                        echo "Có lỗi khi thêm sản phẩm".mysqli_error($link);
                    
                    }
                //=====================================================================================================================================

                } else {
                    echo "Xin lỗi. Có lỗi xảy ra khi tải file của bạn";
                    echo $image;
                }
            }
        }

        // Cập nhật danh sách sản phẩm (Xữ lý khi tast là "Update")
        if($_POST['task']=="Update"){

            $string="";
            $cat = $_POST['Category'];
            $sql="SELECT ID,Price,Brand,Name,Availability,Quantity,Spec1, Spec2, Spec3, Spec4,About,Price FROM products WHERE Category = '$cat' LIMIT 20";
            $result = mysqli_query($link, $sql);
            $number=1;

            while($row = mysqli_fetch_assoc($result)){
                $string .= '                            
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
                <th scope="col"                      >      <button onclick="table('."'".$row['ID']."'".')">Edit</button></th>
                <th scope="col"                      >      <button class="'.$row['ID'].'" onclick="submitForm('."'".$row['ID']."'".')" style="pointer-events: none;">Update</button></th>
            </tr>
                
                ';
                $number+=1;
            }
            // trả về chuỗi HTML để hiển thị danh sách sản phẩm
            echo $string;
        }

        // Cập nhật sản phẩm (xữ lý khi tast là "ProductUpdate")
        if($_POST['task']=="ProductUpdate"){

            //lấy thông tin sản phẩm cần cập nhật từ form
            $Price = $_POST['Price'];
            $Brand = $_POST['Brand'];
            $Name = $_POST['Name'];
            $Spec1 = $_POST['Spec1'];
            $Spec2 = $_POST['Spec2'];
            $Spec3 = $_POST['Spec3'];
            $Spec4 = $_POST['Spec4'];
            $Quantity = $_POST['Quantity'];
            $About = $_POST['About'];
            $Availability = $_POST['Availability'];
            $ID = $_POST['ID'];
            // cập nhật thông tin về database
            $sql = "UPDATE products SET Spec1 = '$Spec1' ,Spec2 = '$Spec2',Spec3 = $Spec3 ,Spec4 = $Spec4,Price = $Price,Brand = '$Brand' ,Name = '$Name',Availability = '$Availability',Quantity = $Quantity,About = '$About' WHERE ID = '$ID';";

            // thục hiện câu truy vấn cập nhật sản phẩm
            if(mysqli_query($link, $sql)){
                echo "Cập nhật sản phẩm thành công";
            }else{
                echo "Có lỗi khi cập nhật sản phẩm".mysqli_error($link);
            }
        }
    }
    

?>

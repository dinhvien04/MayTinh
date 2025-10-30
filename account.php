<?php
// Initialize the session
require_once "database/session.php";
 
// Check if the user is logged in, if not then redirect him to login page
if(!$logediin){
    header("location: database/login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
        @font-face {
            src: url(font/NEWACADEMY.ttf);
            font-family: NEWACADEMY;
            font-weight: bold;
          }


          .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1200;
            top: 0;
            left: 0;

            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
          }


          .sidenav .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
          }

          #menu{
            visibility: hidden;
          }
          @media only screen and (max-width: 767px) {
            #menu{
            visibility: visible;
          }

          }


          @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
          }


          
    </style>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <title>Vien Computers</title>
</head>
<body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    

  <div class="container-fluid">

    <?php include 'preset/header.php';?>

    <div class="row">

      <div class="col-md-1">
                            <div id="mySidenav" class="sidenav border shadow bg-white">
                              <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

                              <div class="list-group mobile" id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action" id="list-dashboard-list" data-toggle="list" href="#list-dashboard" role="tab" aria-controls="home"><img src="assets/svg/cart.svg" width="30px">Bảng điều khiển</a>
                                <a class="list-group-item list-group-item-action" id="list-cart-list" data-toggle="list" href="#list-cart" role="tab" aria-controls="profile">Giỏ hàng</a>
                                <a class="list-group-item list-group-item-action" id="list-security-list" data-toggle="list" href="#list-security" role="tab" aria-controls="messages">Bảo mật</a>
                                <a class="list-group-item list-group-item-action" id="list-orders-list" data-toggle="list" href="#list-orders" role="tab" aria-controls="settings">Đơn hàng</a>
                                <a class="list-group-item list-group-item-action" id="list-history-list" data-toggle="list" href="#list-history" role="tab" aria-controls="home"><img src="assets/svg/cart.svg" width="30px">Lịch sử</a>
                                <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Hồ sơ</a>
                                <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Tin nhắn</a>
                                <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Cài đặt</a>
                              </div><br>
     
                            </div>
                            <span style="font-size:30px;cursor:pointer" onclick="openNav()" id="menu" >&#9776; Menu</span>
                            <script>
                                function openNav() {
                                  document.getElementById("mySidenav").style.width = "250px";
                                }

                                function closeNav() {
                                  document.getElementById("mySidenav").style.width = "0";
                                }
                            </script>
      </div>

      <div class="col-md-2"><br>
          <div class="list-group desktop" id="list-tab" role="tablist">
          <a class="list-group-item list-group-item-action" id="list-dashboard-list" data-toggle="list" href="#list-dashboard" role="tab" aria-controls="home"><img class="mr-3" src="assets/svg/card-checklist.svg" width="30px">Bảng điều khiển</a>
          <a class="list-group-item list-group-item-action" id="list-cart-list" data-toggle="list" href="#list-cart" role="tab" aria-controls="profile"><img class="mr-3" src="assets/svg/cart.svg" width="30px">Giỏ hàng</a>
          <a class="list-group-item list-group-item-action" id="list-shipping-list" data-toggle="list" href="#list-shipping" role="tab" aria-controls="shipping"><img class="mr-3" src="assets/svg/truck.svg" width="30px">Giao hàng</a>
          <a class="list-group-item list-group-item-action" id="list-orders-list" data-toggle="list" href="#list-orders" role="tab" aria-controls="settings"><img class="mr-3" src="assets/svg/box-seam.svg" width="30px">Đơn hàng</a>
          <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages"><img class="mr-3" src="assets/svg/chat-quote.svg" width="30px">Tin nhắn</a>
          <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings"><img class="mr-3" src="assets/svg/gear.svg" width="30px">Cài đặt</a>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br>
      </div>

      <div class="col-xl-8">
          <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="list-dashboard" role="tabpanel" aria-labelledby="list-dashboard-list">
              <?php
              require_once "database/config.php";
                $sql = "SELECT FirstName, LastName,Propic, AddressLine1,AddressLine2, City, Phone FROM users where Email = ?;";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $userRow = mysqli_fetch_assoc($result);
              ?>

     
                <div class="row rounded bg-secondary text-white" style="margin: 25px;padding: 10px;">
                      <div style="width:20%;float:left;" >
                        <img class="rounded-circle" src="<?php echo $userRow["Propic"]?>" alt="" width="200px" height="200px">
                      </div>
                      <div style="width:80%;float:left;">
                        <h3>Chào mừng</h3>
                        <h5> <?php echo htmlspecialchars($userRow["FirstName"], ENT_QUOTES, 'UTF-8')?> <?php echo htmlspecialchars($userRow["LastName"], ENT_QUOTES, 'UTF-8')?></h5>
                      </div>
                </div>
                <div class="row">
                  <div class="col-12">
                  <div class="card" style="width: 100%;">
                    <div class="card-header">
                          <div class="row">
                            <div class="col-1">
                              <h1><i class="bi bi-person-lines-fill"></i></h1>
                            </div>
                            <div class="col-10" style="padding-top: 10px;">
                              <h5>Hồ sơ khách hàng</h5>
                            </div>
                            <div class="col-12"><hr></div>
                          </div>
                    </div>
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-12 text-secondary"><h5>Tên</h5></div>
                          <div class="col-12"><h5><?php echo htmlspecialchars($userRow["FirstName"], ENT_QUOTES, 'UTF-8')?></h5></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-12 text-secondary"><h5>Họ</h5></div>
                          <div class="col-12"><h5><?php echo htmlspecialchars($userRow["LastName"], ENT_QUOTES, 'UTF-8')?></h5></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-12 text-secondary"><h5>Email</h5></div>
                          <div class="col-12"><h5><?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8'); ?></h5></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-12 text-secondary"><h5>Địa chỉ 1</h5></div>
                          <div class="col-12"><h5><?php echo htmlspecialchars($userRow["AddressLine1"], ENT_QUOTES, 'UTF-8')?></h5></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-12 text-secondary"><h5>Địa chỉ 2</h5></div>
                          <div class="col-12"><h5><?php echo htmlspecialchars($userRow["AddressLine2"], ENT_QUOTES, 'UTF-8')?></h5></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-12 text-secondary"><h5>Thành phố</h5></div>
                          <div class="col-12"><h5><?php echo htmlspecialchars($userRow["City"], ENT_QUOTES, 'UTF-8')?></h5></div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="row">
                          <div class="col-12 text-secondary"><h5>Điện thoại</h5></div>
                          <div class="col-12"><h5><?php echo htmlspecialchars($userRow["Phone"], ENT_QUOTES, 'UTF-8')?></h5></div>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <br><br>
                  </div>
                </div>
          </div>
          <div class="tab-pane fade" id="list-cart" role="tabpanel" aria-labelledby="list-cart-list">
              <div style="width: 70%;float:left;padding:25px" id="list-cart-inside">
                          <?php 
                            $sql = "SELECT products.Image, products.Price, products.Name, products.ID, cart.Quantity, cart.ID AS cart FROM cart INNER JOIN products ON cart.ProductID = products.ID where cart.CustomerEmail = ?
                                    UNION
                                    SELECT custompc.Image, custompc.Price, custompc.Name, custompc.ID, cart.Quantity, cart.ID AS cart FROM cart INNER JOIN custompc ON cart.ProductID = custompc.ID where cart.CustomerEmail = ?;";
                              $stmt = mysqli_prepare($link, $sql);
                              mysqli_stmt_bind_param($stmt, "ss", $_SESSION['email'], $_SESSION['email']);
                              mysqli_stmt_execute($stmt);
                              $result = mysqli_stmt_get_result($stmt);
                              while($row = mysqli_fetch_assoc($result)){  ?> <!-- ==================================== -->
                        
                        <div class="row border shadow p-3 mb-3 bg-white rounded" >
                            <div class="col-3 bg-light">
                                <img src="<?php echo htmlspecialchars($row['Image'], ENT_QUOTES, 'UTF-8')?>" alt="" width="100%">
                            </div>
                            <div class="col-6">
                                <p class="card-text"><?php echo htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8')?></p><h6>Số lượng 
                                <select name="<?php echo htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8')?>" id="<?php echo htmlspecialchars($row['cart'], ENT_QUOTES, 'UTF-8')?>" onchange="cartUpdate(this)" disabled>
                                    <option value="<?php echo htmlspecialchars($row['Quantity'], ENT_QUOTES, 'UTF-8')?>" disabled selected><?php echo htmlspecialchars($row['Quantity'], ENT_QUOTES, 'UTF-8')?></option>
                                    <option value=1>1</option>
                                    <option value=2>2</option>
                                    <option value=3>3</option>
                                </select>
                                </h6><h5><?php echo number_format($row['Price'], 0, '', '.') ?> VND</h5>
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-warning mb-2" value="<?php echo htmlspecialchars($row['cart'], ENT_QUOTES, 'UTF-8')?>" onclick="cartEnable(this)">Chỉnh sửa</button><br>
                                <button type="button" class="btn btn-danger mb-2" value="<?php echo htmlspecialchars($row['cart'], ENT_QUOTES, 'UTF-8')?>" onclick="cartDelete(this)">Xóa</button>
                                <button type="button" class="btn btn-success mb-2" value="<?php echo htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8')?>&&<?php echo htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8')?>&&<?php echo htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8')?>&&<?php echo htmlspecialchars($row['cart'], ENT_QUOTES, 'UTF-8')?>" onclick="cartBuy(this)">Tiến hành thanh toán</button>
                            </div>
                        </div>
                        
                        <?php } ?> <!-- ================================================================================== -->
                        <br><br><br><br><br><br><br>
                        <script>
                          //===================================================================================
                            function cartDelete(btn) {
                              var formData = new FormData(); // Currently empty
                              formData.append('ID', btn.value);
                              formData.append('task', "delete");
                              
                                fetch('cart_update.php', {
                                    method:"POST",
                                    body: formData
                                }).then(function (response) {
                                    return response.text();
                                })
                                .then(function (data) {
                                    document.getElementById("list-cart-inside").innerHTML = data;
                                })
                            }
                          //===================================================================================
                            function cartUpdate(btn) {
                              console.log("amal");
                              var formData = new FormData(); // Currently empty
                              formData.append('ID', btn.name);
                              formData.append('task', "update");
                              formData.append('quantity', btn.value);
                              
                                fetch('cart_update.php', {
                                    method:"POST",
                                    body: formData
                                }).then(function (response) {
                                    return response.text();
                                })
                                .then(function (data) {
                                  document.getElementById(btn.id).disabled = "true";
                                  alert(data);
                                })
                            }
                          //===================================================================================
                            function cartEnable(id) {
                              if(document.getElementById(id.value).disabled==""){
                                document.getElementById(id.value).disabled = "true";
                              }else{
                                document.getElementById(id.value).disabled = "";
                              }
                              
                            }
                          //===================================================================================
                            function cartBuy(btn) {
                              var res = btn.value.split("&&");

                              var tongtien = res[2]*document.getElementById(res[3]).value;
                              var soHD = res[3]; // Using cart ID as invoice number

                              document.getElementById("Item_id").value=res[0];
                              document.getElementById("Name").value=res[1];
                              document.getElementById("Price").value=tongtien;
                              document.getElementById("Cart_id").value=soHD;
                              document.getElementById("Quantity").value = document.getElementById(res[3]).value;

                              var qrSrc = "https://img.vietqr.io/image/VCB-1030721718-qr_only.png?amount=" + tongtien + "&addInfo=Thanh toan hoa don " + soHD;
                              document.getElementById("qrCodeImg").src = qrSrc;

                              var FirstName="<?php echo htmlspecialchars($userRow['FirstName'], ENT_QUOTES, 'UTF-8')?>";
                              var LastName="<?php echo htmlspecialchars($userRow['LastName'], ENT_QUOTES, 'UTF-8')?>";
                              var AddressLine1="<?php echo htmlspecialchars($userRow['AddressLine1'], ENT_QUOTES, 'UTF-8')?>";
                              var AddressLine2="<?php echo htmlspecialchars($userRow['AddressLine2'], ENT_QUOTES, 'UTF-8')?>";
                              var City="<?php echo htmlspecialchars($userRow['City'], ENT_QUOTES, 'UTF-8')?>";
                              var Phone="<?php echo htmlspecialchars($userRow['Phone'], ENT_QUOTES, 'UTF-8')?>";

                              if(FirstName=="" || LastName=="" || AddressLine1=="" || AddressLine2=="" || City=="" || Phone==""){
                                alert("Vui lòng điền đầy đủ thông tin giao hàng");
                              }else{
                                $('#paymentModal').modal('show');
                              }
                            }
                        </script>
              </div>
              <div style="width: 30%;float:left;padding:25px" >
                  <div class="row p-3 mb-3 ml-3">
                        <div class="row">
                          <div class="col-12">
                            <img src="assets/payhere.png" width="300px" alt=""><hr>
                          </div>
                          <div class="col-2">
                            <img src="assets/lock.png" width="50px" alt="">
                          </div>
                          <div class="col-10">
                            <p><i>Thanh toán được thực hiện an toàn bằng cổng thanh toán PayHere</i></p>
                          </div>
                        </div>
                  </div>
                  <!-- =============================================================================================================================== -->
                      <!-- <form method="post" action="https://sandbox.payhere.lk/pay/checkout" id="payhere">   
                        <input class="form-control-plaintext" type="hidden" name="merchant_id" value="1217187">
                        <input class="form-control-plaintext" type="hidden" name="return_url" value="http://localhost/computer/index.php">
                        <input class="form-control-plaintext" type="hidden" name="cancel_url" value="http://localhost/computer/index.php">
                        <input class="form-control-plaintext" type="hidden" name="notify_url" value="http://localhost/computer/notify.php">  

                        <input class="form-control-plaintext" type="text" id="order_id" name="order_id" value="" hidden>
                        <input class="form-control-plaintext" type="text" id="items" name="items" value="" hidden>
                        <input class="form-control-plaintext" type="text" name="currency" value="LKR" hidden>
                        <input class="form-control-plaintext" type="text" id="amount" name="amount" value="" hidden>  

                        <input class="form-control-plaintext" type="text" name="first_name" value="<?php echo $userRow['FirstName']?>" hidden>
                        <input class="form-control-plaintext" type="text" name="last_name" value="<?php echo $userRow['LastName']?>" hidden>
                        <input class="form-control-plaintext" type="text" name="email" value="<?php echo $_SESSION['email'] ?>" hidden>
                        <input class="form-control-plaintext" type="text" name="phone" value="<?php echo $userRow['Phone']?>" hidden>
                        <input class="form-control-plaintext" type="text" name="address" value="<?php echo $userRow['AddressLine1']?>" hidden>
                        <input class="form-control-plaintext" type="text" name="city" value="<?php echo $userRow['City']?>" hidden>
                        <input class="form-control-plaintext" type="hidden" name="country" value="Sri Lanka" hidden><br><br>  
                      </form>   -->
                      <form method="post" action="notify2.php" id="payhere2">   
                        <input class="form-control-plaintext" type="hidden" name="merchant_id" value="1217187">
                        <input class="form-control-plaintext" type="hidden" name="return_url" value="http://localhost/computer/index.php">
                        <input class="form-control-plaintext" type="hidden" name="cancel_url" value="http://localhost/computer/index.php">
                        <input class="form-control-plaintext" type="hidden" name="notify_url" value="http://localhost/computer/notify.php">  

                        <input class="form-control-plaintext" type="text" id="Item_id" name="order_id" value="" hidden>
                        <input class="form-control-plaintext" type="text" id="Name" name="items" value="" hidden>
                        <input class="form-control-plaintext" type="text" name="currency" value="VND" hidden>
                        <input class="form-control-plaintext" type="text" id="Price" name="amount" value="" hidden>  
                        <input class="form-control-plaintext" type="text" id="Quantity" name="quantity_1" value="" hidden>  
                        <input class="form-control-plaintext" type="text" id="Cart_id" name="custom_1" value="" hidden>  

                        <input class="form-control-plaintext" type="text" name="first_name" value="<?php echo htmlspecialchars($userRow['FirstName'], ENT_QUOTES, 'UTF-8')?>" hidden>
                        <input class="form-control-plaintext" type="text" name="last_name" value="<?php echo htmlspecialchars($userRow['LastName'], ENT_QUOTES, 'UTF-8')?>" hidden>
                        <input class="form-control-plaintext" type="text" name="email" value="<?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8') ?>" hidden>
                        <input class="form-control-plaintext" type="text" name="phone" value="<?php echo htmlspecialchars($userRow['Phone'], ENT_QUOTES, 'UTF-8')?>" hidden>
                        <input class="form-control-plaintext" type="text" name="address" value="<?php echo htmlspecialchars($userRow['AddressLine1'], ENT_QUOTES, 'UTF-8')?>" hidden>
                        <input class="form-control-plaintext" type="text" name="city" value="<?php echo htmlspecialchars($userRow['City'], ENT_QUOTES, 'UTF-8')?>" hidden>
                        <input class="form-control-plaintext" type="hidden" name="country" value="Sri Lanka" hidden><br><br>  
                        <input type="hidden" name="payment_method" id="payment_method" value="">
                      </form>
                  <!-- =============================================================================================================================== -->
              </div>

            </div>
            <div class="tab-pane fade" id="list-shipping" role="tabpanel" aria-labelledby="list-shipping-list">
              <br><h1>Cập nhật thông tin</h1><br>
                  <form id="userUpdate" >
                    <div class="form-group">
                      <label>Địa chỉ 1</label>
                      <input type="text" class="form-control" name="address" placeholder="Address Line1" value="<?php echo htmlspecialchars($userRow["AddressLine1"], ENT_QUOTES, 'UTF-8')?>" required>
                    </div>
                    <div class="form-group">
                      <label>Địa chỉ 2</label>
                      <input type="text" class="form-control" name="address2" placeholder="Address Line2" value="<?php echo htmlspecialchars($userRow["AddressLine2"], ENT_QUOTES, 'UTF-8')?>" required>
                    </div>
                    <div class="form-group">
                      <label>Thành phố</label>
                      <input type="text" class="form-control" name="city" placeholder="City" value="<?php echo htmlspecialchars($userRow["City"], ENT_QUOTES, 'UTF-8')?>" required>
                    </div>
                    <div class="form-group">
                      <label>Điện thoại</label>
                      <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo htmlspecialchars($userRow["Phone"], ENT_QUOTES, 'UTF-8')?>" required>
                    </div>
                    <input type="text" hidden name="task" value="userUpdate">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    
                  </form><br><br><br><br><br><br><br>
                  <script>
                        const myForm = document.getElementById('userUpdate');

                        myForm.addEventListener('submit', function(e){
                            e.preventDefault();

                            const formData = new FormData(this);

                            fetch('cart_update.php', {
                                method:"POST",
                                body: formData
                            }).then(function (response) {
                                return response.text();
                            })
                            .then(function (data) {
                                alert(data);
                                location.reload();
                            })
                        })
                  </script>
            </div>
            <div class="tab-pane fade" id="list-orders" role="tabpanel" aria-labelledby="list-orders-list"><br><br>

                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Hình ảnh</th>
                      <th scope="col">Tên sản phẩm</th>
                      <th scope="col">Số lượng</th>
                      <th scope="col">Đơn giá</th>
                      <th scope="col">Tổng tiền</th>
                      <th scope="col">Ngày & Giờ</th>
                      <th scope="col">Trạng thái giao hàng</th>
                      <th scope="col">Trạng thái thanh toán</th>
                    </tr>
                  </thead>
                  <tbody>

                  <?php 
                    $sql = "SELECT orders.*, products.Image, products.Name FROM orders INNER JOIN products ON orders.ItemID = products.ID where orders.CustomerEmail = ?;";
                    $stmt = mysqli_prepare($link, $sql);
                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    $sql2 = "SELECT orders.*, custompc.Name, custompc.CPU, custompc.MotherBoard, custompc.GPU, custompc.RAM, custompc.Cooling, custompc.Storage, custompc.Power, custompc.Casing, custompc.Image FROM orders INNER JOIN custompc ON orders.ItemID = custompc.ID where orders.CustomerEmail = ?;";
                    $stmt2 = mysqli_prepare($link, $sql2);
                    mysqli_stmt_bind_param($stmt2, "s", $_SESSION['email']);
                    mysqli_stmt_execute($stmt2);
                    $result2 = mysqli_stmt_get_result($stmt2);


                      while($row = mysqli_fetch_assoc($result)){  ?> 

                    <tr>
                      <th scope="row"><?=htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8'); ?></th>
                      <td><img src="<?=htmlspecialchars($row['Image'], ENT_QUOTES, 'UTF-8'); ?>" alt="" height="50px"></td>
                      <td><?php echo number_format($row['TotalAmount']/$row['Quantity'], 0, '', '.') ?> VND</td>
                      <td><?php echo number_format($row['TotalAmount'], 0, '', '.') ?> VND</td>
                      <td><?=htmlspecialchars($row['Date'], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td><?php if($row['DeliveryState'] == "pending"){echo "<span class='badge badge-warning'>Chưa giải quyết</span>";}else{echo "<span class='badge badge-success'>Đã giao hàng</span>";}  ?></td>
                      <td><?php if($row['payment_status'] == "unpaid"){echo "<span class='badge badge-danger'>Chưa thanh toán</span>";}else{echo "<span class='badge badge-success'>Đã thanh toán</span>";}  ?></td>
                    </tr>
                    
                        <?php } 

                        while($row = mysqli_fetch_assoc($result2)){  ?> 

                    <tr>
                      <th scope="row"><?=htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8'); ?></th>
                      <td><img src="<?=htmlspecialchars($row['Image'], ENT_QUOTES, 'UTF-8'); ?>" alt="" height="50px"></td>
                      <td><?php echo htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8');echo "<br><i>".htmlspecialchars($row['CPU'], ENT_QUOTES, 'UTF-8');echo "<br>".htmlspecialchars($row['RAM'], ENT_QUOTES, 'UTF-8');echo "<br>".htmlspecialchars($row['Cooling'], ENT_QUOTES, 'UTF-8');echo "<br>".htmlspecialchars($row['Storage'], ENT_QUOTES, 'UTF-8');echo "<br>".htmlspecialchars($row['Power'], ENT_QUOTES, 'UTF-8');echo "<br>".htmlspecialchars($row['Casing'], ENT_QUOTES, 'UTF-8')."</i>"; ?></td>
                      <td><?=htmlspecialchars($row['Quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td><?php echo number_format($row['TotalAmount']/$row['Quantity'], 0, '', '.') ?> VND</td>
                      <td><?php echo number_format($row['TotalAmount'], 0, '', '.') ?> VND</td>
                      <td><?=htmlspecialchars($row['Date'], ENT_QUOTES, 'UTF-8'); ?></td>
                      <td><?php if($row['DeliveryState'] == "pending"){echo "<span class='badge badge-warning'>Chưa giải quyết</span>";}else{echo "<span class='badge badge-success'>Đã giao hàng</span>";}  ?></td>
                      <td><?php if($row['payment_status'] == "unpaid"){echo "<span class='badge badge-danger'>Chưa thanh toán</span>";}else{echo "<span class='badge badge-success'>Đã thanh toán</span>";}  ?></td>
                    </tr>

                        <?php } ?>

                  </tbody>
                </table><br><br><br><br><br><br><br><br><br>

            </div>
            <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">7</div>
            <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
            <br><h1>Cài đặt</h1><br>
            <!-- ======================================================================================================================================================== -->            
              <h4>Thay đổi tên</h4>
              <form id="updateNameForm">
                <div class="form-group">
                    <label>Tên</label>
                    <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($userRow["FirstName"], ENT_QUOTES, 'UTF-8')?>">
                </div>
                <div class="form-group">
                    <label>Họ</label>
                    <input type="text" name="lname" class="form-control" value="<?php echo htmlspecialchars($userRow["LastName"], ENT_QUOTES, 'UTF-8')?>">
                </div>
                <input type="text" hidden name="task" value="updateName">
              <script>
                        const updateNameForm = document.getElementById('updateNameForm');

                        updateNameForm.addEventListener('submit', function(e){
                            e.preventDefault();

                            const formData = new FormData(this);

                            fetch('cart_update.php', {
                                method:"POST",
                                body: formData
                            }).then(function (response) {
                                return response.text();
                            })
                            .then(function (data) {
                                alert(data);
                                location.reload();
                            })
                        })
                  </script>



            <!-- ======================================================================================================================================================== -->
              <h4>Thay đổi mật khẩu</h4>

              <form id="changePass"> 
                  <div class="form-group">
                      <label>Mật khẩu cũ</label>
                      <input type="password" id="oldPass" name="old_password" class="form-control" value="">
                      <span id="soldPass" class=""></span>
                  </div>
                  <div class="form-group">
                      <label>Mật khẩu mới</label>
                      <input type="password" id="newPass" name="new_password" class="form-control" value="">
                      <span id="snewPass" class=""></span>
                  </div>
                  <div class="form-group">
                      <label>Xác nhận mật khẩu</label>
                      <input type="password" id="confirmPass" name="confirm_password" class="form-control">
                      <span id="sconfirmPass" class=""></span>
                  </div>
                  <div class="form-group">
                      <input type="submit" class="btn btn-primary" value="Thay đổi">
                  </div>
              </form>

              <script>
                        const changePass = document.getElementById('changePass');

                        changePass.addEventListener('submit', function(e){
                            e.preventDefault();

                            const formData = new FormData(this);

                            fetch('database/reset_password.php', {
                                method:"POST",
                                body: formData
                            }).then(function (response) {
                                return response.text();
                            })
                            .then(function (data) {
                                const obj = data.split("&&");
                                document.getElementById("oldPass").className = (obj[0] == "" ? 'form-control is-valid' : 'form-control is-invalid');
                                document.getElementById("soldPass").innerHTML = obj[0];
                                document.getElementById("newPass").className = (obj[1] == "" ? 'form-control is-valid' : 'form-control is-invalid');
                                document.getElementById("snewPass").innerHTML = obj[1];
                                document.getElementById("confirmPass").className = (obj[2] == "" ? 'form-control is-valid' : 'form-control is-invalid');
                                document.getElementById("sconfirmPass").innerHTML = obj[2];
                                if(obj[3]=="done"){
                                  swal("Cập nhật thành công!", "  ", "success");
                                  document.getElementById("oldPass").className = 'form-control';
                                  document.getElementById("oldPass").value = "";
                                  document.getElementById("newPass").className = 'form-control';
                                  document.getElementById("newPass").value = "";
                                  document.getElementById("confirmPass").className = 'form-control';
                                  document.getElementById("confirmPass").value = "";
                                }
                            })
                        })
                  </script>

            <!-- ======================================================================================================================================================== -->
                          <h4>Chi tiết giao hàng</h4>

                  <form id="userUpdate2" >
                    <div class="form-group">
                      <label>Địa chỉ 1</label>
                      <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($userRow["AddressLine1"], ENT_QUOTES, 'UTF-8')?>"  required>
                      <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                    </div>
                    <div class="form-group">
                      <label>Địa chỉ 2</label>
                      <input type="text" class="form-control" name="address2" value="<?php echo htmlspecialchars($userRow["AddressLine2"], ENT_QUOTES, 'UTF-8')?>"  required>
                      <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                    </div>
                    <div class="form-group">
                      <label>Thành phố</label>
                      <input type="text" class="form-control" name="city" value="<?php echo htmlspecialchars($userRow["City"], ENT_QUOTES, 'UTF-8')?>" required>
                      <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                    </div>
                    <div class="form-group">
                      <label>Điện thoại</label>
                      <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($userRow["Phone"], ENT_QUOTES, 'UTF-8')?>"  required>
                      <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                    </div>
                    <input type="text" hidden name="task" value="userUpdate">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    
                  </form><br><br><br><br><br><br><br>
                  <script>
                        const myForm2 = document.getElementById('userUpdate2');

                        myForm2.addEventListener('submit', function(e){
                            e.preventDefault();

                            const formData = new FormData(this);

                            fetch('cart_update.php', {
                                method:"POST",
                                body: formData
                            }).then(function (response) {
                                return response.text();
                            })
                            .then(function (data) {
                                alert(data);
                                location.reload();
                            })
                        })
                  </script>
            </div>
          </div>
      </div>
      
    </div>

    <?php include 'preset/footer.php';?>

  </div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">Chọn phương thức thanh toán</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="paymentMethod" id="cashOnDelivery" value="cash" checked>
          <label class="form-check-label" for="cashOnDelivery">
            Thanh toán khi nhận hàng
          </label>
        </div>
        <div class="form-check">
          <input class_="form-check-input" type="radio" name="paymentMethod" id="bankTransfer" value="bank">
          <label class="form-check-label" for="bankTransfer">
            Chuyển khoản ngân hàng
          </label>
        </div>
        <div id="qrCodeContainer" style="display: none; text-align: center; margin-top: 20px;">
            <img id="qrCodeImg" src="" alt="QR Thanh toán">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" onclick="confirmPayment()">Xác nhận thanh toán</button>
      </div>
    </div>
  </div>
</div>

<script>
function confirmPayment() {
    var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
    document.getElementById('payment_method').value = paymentMethod;
    document.getElementById('payhere2').submit();
}
</script>

<script>
$('input[type=radio][name=paymentMethod]').change(function() {
    if (this.value == 'bank') {
        $('#qrCodeContainer').show();
    }
    else if (this.value == 'cash') {
        $('#qrCodeContainer').hide();
    }
});
</script>
</body>
</html>
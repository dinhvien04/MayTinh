<?php
    // lấy ID sản phẩm tư URL(sử dụng phương thức GET)
    $ID = $_GET['i'];
    // kiểm tra ID không tôn tại thì dừng chương trình và thông báo
    if (empty($ID)) {
        exit("ID sản phẩm không tồn tại");
    } else {
        // kết nối cơ sỡ dữ liệu
        require 'database/config.php';

        // Truy vấn để lấy thông tin sản phẩm cơ sỡ dữ liệu dựa vào ID
        $sql = "SELECT * From products WHERE ID=?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "s", $ID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        // Lấy thông tin các sản phẩm từ kết quả truy vấn
        $Image = $row['Image'];
        $price = $row['Price'];
        $Name = $row['Name'];
        $About = $row['About'];
        $Quantity = $row['Quantity'];
        $Availability = $row['Availability'];
        // nếu sản phẩm có sẵn thì đổi Availability thành yes, còn ngược lại thì No
        if($Availability==1){
            $Availability="Yes";
        } else {
            $Availability="No";
        }
    }

    // khởi tạo phiên làm việc
    require_once "database/session.php";
?>




<!DOCTYPE html>
<html lang="en">
<head>
            <style>
                @font-face {
                    src: url(font/NEWACADEMY.ttf);
                    font-family: NEWACADEMY;
                    font-weight: bold;
                }
            </style>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="icon" href="assets/V.png">
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <link rel="stylesheet" href="style/style.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

            <link rel="stylesheet" href="style/owl.carousel.min.css">
            <link rel="stylesheet" href="style/owl.theme.default.min.css">

                <!-- để sửa tên sau -->
            <title>VIEN Computers</title> 

                <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            <script src="style/owl.carousel.min.js"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>




<body>
    <div class="container-fluid">

            <?php include 'preset/header.php';?>
            <?php include 'preset/mcarosal.php';?>

            <div class="container first">

                <div class="row" style="margin-top: 5px;">
                    <!-- Hiển thị thông tin sản phẩm -->
                    <div class="col-md-6">
                        <img src="<?php echo $Image?>" width="500px">
                    </div>
                <!-- hiển thị thông tin sản phẩm  -->
                    <div class="col-md-6">
                         <h2><?php echo $Name?></h2>
                         <br>
                         <div class=descrip>
                           <p>
                                <i class="bi bi-cash"></i>
                                <!-- chỉnh lại giá thêm dấu . -->
                                Giá: <?php echo number_format($price, 0, '', '.') ?> VND 
                           </p>
                           <p>
                                <i class="bi bi-box"></i>
                                Số lượng còn lại: <?php echo $Quantity?> 
                           </p>
                           <p>
                                <i class="bi bi-box-seam"></i>
                                Còn Hàng: <?php echo $Availability?>
                           </p>

                           <br>
                        </div>
                        <script>
                            

                        </script>

                    <!-- thêm sản phảm vào giỏ hàng -->
                         <div>
                                <form id="addToCart">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Số lượng</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="Quantity">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>

                                        </select><br>
                                        <!-- các thông tin sản phẩm -->
                                        <input type="text" name="ProductID" value="<?php echo $ID?>" hidden="true">
                                        <input type="text" name="ProductName" value="<?php echo $Name?>" hidden="true">
                                        <input type="text" name="CustomPC" value="no" hidden>
                                        <button type="submit" class="btn btn-primary mb-2">Thêm vào giỏ hàng</button>
                                    </div>
                                </form>
                                <!-- =================================================================================================================================================== -->
                                <!-- xữ lý sự kiện thêm vào giỏ hàng qua AJAX -->
                                <script>
                                    const myForm = document.getElementById('addToCart');

                                    myForm.addEventListener('submit', function(e){
                                        console.log("Thêm vào giỏ hàng");
                                        e.preventDefault();

                                        const formData = new FormData(this);
                                                // gửi yêu cầu đến sever bằng ferch API
                                                        fetch('cart.php', {
                                                        method:"POST",
                                                        body: formData
                                                    }).then(function (response) {
                                                        return response.text();
                                                    })
                                                    .then(function (data) {
                                                        if(data=="login"){
                                                            window.location.replace("database/login.php");
                                                        }
                                                        else if(data=="ok"){
                                                            Swal.fire({
                                                              icon: 'success',
                                                              title: 'Thành công!',
                                                              text: 'Sản phẩm đã được thêm vào giỏ hàng!',
                                                            }).then((result) => {
                                                              if (result.isConfirmed) {
                                                                window.location.href = "account.php#list-cart";
                                                              }
                                                            })
                                                        }
                                                        else{
                                                            console.log(data);
                                                        }
                                                    }).catch(function(error){
                                                        console.log("có lỗi xảy ra");
                                                    })

                                    })


                                </script>
                                

                                <!-- =================================================================================================================================================== -->
                         </div>

                         <hr>
                         <!-- các nút chia sẽ sản phẩm -->
                         <div>
                            <button type="button" class="btn btn-outline-warning" onclick="shareOnTwitter()">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                Twitter
                            </button>
                            <button type="button" class="btn btn-outline-warning" onclick="shareOnFacebook()">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                Facebook
                            </button>
                          <script>
                            function shareOnTwitter() {
                                var url = "https://twitter.com/intent/tweet?url=" + window.location.href;
                                window.open(url, '_blank');
                            }
                            function shareOnFacebook() {
                                var url = "https://www.facebook.com/sharer/sharer.php?u=" + window.location.href;
                                window.open(url, '_blank');
                            }
                            </script>
                         </div>
                     </div>
                    </div>
                </div>

                <!-- phần mô tả chi tiết sản phẩm -->
                <div class="row " >
                    <div class="col-md-1"><h1>About</h1></div>
                    <div class="col-md-8">
                        <textarea class="form-control" rows="20" disabled style="resize: none; background-color:transparent">
                            <?php echo $About?>
                        </textarea>
                    </div>
                    <div class="col-md-3"></div>
                </div>
        
            </div>
            <!-- chèn footer từ file preset -->
            <?php include 'preset/footer.php';?>

    </div>
</body>
</html>
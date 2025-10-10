<?php
     require 'database/config.php';
     // Initialize the session
     require_once "database/session.php";
?>

<!doctype html>
<html lang="en">
  <head>

            <style>
                @font-face {
                    src: url(font/NEWACADEMY.ttf);
                    font-family: NEWACADEMY;
                    font-weight: bold;
                }
                .laptop {
                          background-image: url("assets/lap.jpg");
                          height: 500px;
                          background-position: center;
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

            <title>VIEN Computers</title>

                <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            <script src="style/owl.carousel.min.js"></script>

  </head>





  <body>

    <div class="container-fluid">
    
        <?php include 'preset/header.php';?>
        <div class="row">
                <div class="col-12 laptop">

                </div>
        </div>



<!-- *********************************************FILTER SECTION********************************************************************** -->
<!-- ********************************************************************************************************************************* -->
<div class="row">
          <div class="col-3">

            <h1>Máy tính</h1>  <!-- ==========CHANGE CAT=================================== -->
            <hr>



            <h3>Thương Hiệu</h3> <!-- ==========CHANGE FIL 1=================================== -->
              <ul class="list-group">
              <?php
                $sql="SELECT DISTINCT Brand FROM products WHERE Category='laptop' ORDER BY Brand"; //<!-- ==========CHANGE SQL 1=================================== -->
                $result = mysqli_query($link, $sql);
                while($row = mysqli_fetch_assoc($result)){
                
              ?>
                <li class="list-group-item">
                  <div class="form-check">
                    <label for="form-check-lable">
                      <input type="checkbox" class="form-chech-input product_check" value="<?=$row['Brand']; ?>" id="Brand"><!-- ==========CHANGE VAL 1=================================== -->
                      <?=$row['Brand']; ?><!-- ==========CHANGE VAL 1=================================== -->
                    </label>
                  </div>
                </li>
              <?php } ?>
              </ul>
<!-- *************************************************************************************************************************************** -->
              <h3>Bộ xữ lý</h3>
              <ul class="list-group">
              <?php
                $sql="SELECT DISTINCT Spec1 AS Processor FROM products WHERE Category='laptop' ORDER BY Spec1";
                $result = mysqli_query($link, $sql);
                while($row = mysqli_fetch_assoc($result)){
                
              ?>
                <li class="list-group-item">
                  <div class="form-check">
                    <label for="form-check-lable">
                      <input type="checkbox" class="form-chech-input product_check" value="<?=$row['Processor']; ?>" id="Processor">
                      <?=$row['Processor']; ?>
                    </label>
                  </div>
                </li>
              <?php } ?>
              </ul>
<!-- *************************************************************************************************************************************** -->
              <h3>Card đồ họa</h3>
              <ul class="list-group">
              <?php
                $sql="SELECT DISTINCT Spec2 AS GPU FROM products WHERE Category='laptop' ORDER BY Spec2";
                $result = mysqli_query($link, $sql);
                while($row = mysqli_fetch_assoc($result)){
                
              ?>
                <li class="list-group-item">
                  <div class="form-check">
                    <label for="form-check-lable">
                      <input type="checkbox" class="form-chech-input product_check" value="<?=$row['GPU']; ?>" id="GPU">
                      <?=$row['GPU']; ?>
                    </label>
                  </div>
                </li>
              <?php } ?>
              </ul>
<!-- **************************************************************************************************************************************** -->
              <h3>Màn Hình</h3>
              <ul class="list-group">
              <?php
                $sql="SELECT DISTINCT Spec4 AS Screen FROM products WHERE Category='laptop' ORDER BY Spec4";
                $result = mysqli_query($link, $sql);
                while($row = mysqli_fetch_assoc($result)){
                
              ?>
                <li class="list-group-item">
                  <div class="form-check">
                    <label for="form-check-lable">
                      <input type="checkbox" class="form-chech-input product_check" value="<?=$row['Screen']; ?>" id="Screen">
                      <?=$row['Screen']; ?>
                    </label>
                  </div>
                </li>
              <?php } ?>
              </ul>




            </div>
<!-- *********************************************FILTER SECTION END********************************************************************** -->
<!-- ********************************************************************************************************************************* -->

          <div class="col-9">
              <h5 id="textChange">Tất cả máy tính</h5>
              <!-- vùng hiện thị hình ảnh 'loading' khi đang tải dữ liệu -->
              <div class="text-center">
                  <img src="image\loader.gif" id="loader" width="400px" style="display: none;">
              </div>

              <!-- vùng hiển thị kết quả sản phẩm , các thẻ sản phẩm được thêm vào vị trí này -->
              <div class="row" id="result">
                  <?php
                  // truy vấn để lất hình ảnh , tên ,giá, ID của sản phẩm
                    $sql="SELECT Image,Name,Price,ID FROM products WHERE Category='laptop'";
                    $result = mysqli_query($link, $sql);
                    // vòng lập các dòng kết quả để hiển thị thông tin sản phẩm
                    while($row = mysqli_fetch_assoc($result)){ 
                  ?>
                  <!-- hiển thị từng sản phẩm một cột -->
                  <div class="col-md-3">
                    <!-- hình ảnh của sản phẩm -->
                      <img src="<?= $row['Image']?>" width="250px"><br>
                      <!-- tên sản phẩm -->
                      <h5><?=$row['Name']?></h5>
                      <!-- hiển thị giá của sản phẩm -->
                      <h6><?php echo number_format($row['Price'], 0, '', '.') ?> VND</h6>
                      <!-- nút bám 'Mua' để xem chi tiết sản phẩm  -->
                      <a class="btn btn-info" href="preview.php?i=<?=$row['ID']?>&t=laptops">Mua</a>
                  </div>
                  <?php } ?>
              </div>
          </div>

        </div>
            <!-- bao gồm file 'footer.php' để thêm phần chân trang vào -->
        <?php include 'preset/footer.php';?>
    </div>

<!-- khi người dùng nhấn vào một bộ lọc sản phẩm -->
    <script type="text/javascript">
      $(document).ready(function(){
//************************************************************CLICK CALL************************************** */
        $(".product_check").click(function(){
          // lấy danh sách check bộ lọc theo thương hiệu, bộ xữ lý, gpu , ma hình
          var arr_Brand = document.querySelectorAll("#Brand");
          var arr_Processor = document.querySelectorAll("#Processor");
          var arr_GPU = document.querySelectorAll("#GPU");
          var arr_Screen = document.querySelectorAll("#Screen");
          // chuổi dữ liệu sẽ được gửi đến máy chủ
          sendstr="";

          // mảng chứa các lựa chọn của người dùng
          Brand = [];
          Processor = [];
          GPU = [];
          Screen = [];
          Category = ["laptop"]; // mặc định là laptop

          // kiểm tra và thêm các giá trị đã được chọn vào mảng tương ứng
          arr_Brand.forEach(pro_filter1);
          arr_Processor.forEach(pro_filter2);
          arr_GPU.forEach(pro_filter3);
          arr_Screen.forEach(pro_filter4);

          // Nếu người dùng chọn THƯƠNG HIỆU, thêm nó vào chuỗi gửi 
          if (Brand.length>0){
            var myJSON = JSON.stringify(Brand);
            sendstr = sendstr.concat("Brand="+myJSON+"&");
          }

          // Nếu người dùng chọn BỘ XỮ LÝ, thêm nó vào chuỗi gửi
          if (Processor.length>0){
            var myJSON = JSON.stringify(Processor);
            sendstr = sendstr.concat("Processor="+myJSON+"&");
          }

          // Nếu người dùng chọn Card ĐỒ HỌA, thêm nó vào chuỗi gửi
          if (GPU.length>0){
            var myJSON = JSON.stringify(GPU);
            sendstr = sendstr.concat("GPU="+myJSON+"&");
          }

          // Nếu người dùng chọn MÀN HÌNH, thêm nó vào chuỗi gữi
          if (Screen.length>0){
            var myJSON = JSON.stringify(Screen);
            sendstr = sendstr.concat("Screen="+myJSON+"&");
          }

          // thêm danh mục sản phẩm vào chuổi gửi
          var myJSON = JSON.stringify(Category);
          sendstr = sendstr.concat("Category="+myJSON+"&");
          console.log(sendstr);

//************************************************************SENDING DATA TO SERVER******************************************** */
          // gửi dữ liệu lọc đến máy chủ AJAX
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("result").innerHTML = this.responseText;
            }
          };
          // Thiết lập phương thức gửi dữ liệu đến trang 'filter.php'
          xmlhttp.open("POST", "filter.php", true);
          xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xmlhttp.send(sendstr);
        });
//********************************************************CLICK CALL END************************************************ */
        // các hàm lọc để kiểm tra checkbox và thêm giá trị hàng
      function pro_filter1(val){
        if(val.checked==true){
            Brand.push(val.value);
        }
    }
    function pro_filter2(val){
        if(val.checked==true){
            Processor.push(val.value);
        }
    }
    function pro_filter3(val){
        if(val.checked==true){
            GPU.push(val.value);
        }
    }
    function pro_filter4(val){
        if(val.checked==true){
            Screen.push(val.value);
        }
    }

//******************************************************************************************************************************** */
      });
    </script>
  </body>
</html>
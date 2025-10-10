<!-- để hiển thị danh sách các sản phẩm và bộ lọc sản phẩm -->
<!-- theo các tiêu chí như "Brand", "Screen Size", "Refresh Rate" và "Resolution" (độ phân giải) cho màn hình (monitors
  Bộ lọc sẽ gửi yêu cầu tới server thông qua AJAX để cập nhật kết quả tìm kiếm sản phẩm mà không cần tải lại trang.
   -->

<?php
    require 'database/config.php'; // kết nối cơ sỡ dữ liệu
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
                    background-image: url("assets/mon.jpg");
                    background-position: center;      
                    height: 500px;                
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

            <h1>Màn Hình</h1>  <!-- ==========CHANGE CAT=================================== -->
            <hr>
            <h3>Thương hiệu</h3> <!-- ==========CHANGE FIL 1=================================== -->
              <ul class="list-group">
              <?php
                $sql="SELECT DISTINCT Brand FROM products WHERE Category='monitors' ORDER BY Brand"; //<!-- ==========CHANGE SQL 1=================================== -->
                $result = mysqli_query($link, $sql);
                while($row = mysqli_fetch_assoc($result)){
                
              ?>
                <li class="list-group-item">
                  <div class="form-check">
                    <label for="form-check-lable">
                      <input type="checkbox" class="form-chech-input product_check" value="<?=$row['Brand']; ?>" id="Filter1"><!-- ==========CHANGE VAL 1=================================== -->
                      <?=$row['Brand']; ?><!-- ==========CHANGE VAL 1=================================== -->
                    </label>
                  </div>
                </li>
              <?php } ?>
              </ul>
<!-- *************************************************************************************************************************************** -->
              <h3>Kích thước màn hình</h3>
              <ul class="list-group">
              <?php
                $sql="SELECT DISTINCT Spec4 AS Size FROM products WHERE Category='monitors' ORDER BY Spec4";
                $result = mysqli_query($link, $sql);
                while($row = mysqli_fetch_assoc($result)){
                
              ?>
                <li class="list-group-item">
                  <div class="form-check">
                    <label for="form-check-lable">
                      <input type="checkbox" class="form-chech-input product_check" value="<?=$row['Size']; ?>" id="Filter2">
                      <?=$row['Size']; ?>
                    </label>
                  </div>
                </li>
              <?php } ?>
              </ul>
<!-- *************************************************************************************************************************************** -->
              <h3>Tần số quét</h3>
              <ul class="list-group">
              <?php
                $sql="SELECT DISTINCT Spec3 AS RefreshRate FROM products WHERE Category='monitors' ORDER BY Spec3";
                $result = mysqli_query($link, $sql);
                while($row = mysqli_fetch_assoc($result)){
                
              ?>
                <li class="list-group-item">
                  <div class="form-check">
                    <label for="form-check-lable">
                      <input type="checkbox" class="form-chech-input product_check" value="<?=$row['RefreshRate']; ?>" id="Filter3">
                      <?=$row['RefreshRate']; ?>
                    </label>
                  </div>
                </li>
              <?php } ?>
              </ul>
<!-- **************************************************************************************************************************************** -->
              <h3>Độ phân giải</h3>
              <ul class="list-group">
              <?php
                $sql="SELECT DISTINCT Spec1 AS Resolution FROM products WHERE Category='monitors' ORDER BY Spec1";
                $result = mysqli_query($link, $sql);
                while($row = mysqli_fetch_assoc($result)){
                
              ?>
                <li class="list-group-item">
                  <div class="form-check">
                    <label for="form-check-lable">
                      <input type="checkbox" class="form-chech-input product_check" value="<?=$row['Resolution']; ?>" id="Filter4">
                      <?=$row['Resolution']; ?>
                    </label>
                  </div>
                </li>
              <?php } ?>
              </ul>




            </div>
<!-- *********************************************FILTER SECTION END********************************************************************** -->
<!-- ********************************************************************************************************************************* -->

          <div class="col-9">
              <h5 id="textChange">Tất cả màn hình</h5>
              <div class="text-center">
                  <img src="image\loader.gif" id="loader" width="400px" style="display: none;">
              </div>
              <div class="row" id="result">
                  <?php
                    $sql="SELECT Image,Name,Price,ID FROM products WHERE Category='monitors' ORDER BY Spec3";
                    $result = mysqli_query($link, $sql);
                    while($row = mysqli_fetch_assoc($result)){ 
                  ?>
                  <div class="col-md-3">
                      <img src="<?= $row['Image']?>" width="250px"><br>
                      <h5><?=$row['Name']?></h5>
                      <h6><?php echo number_format($row['Price'], 0, '', '.') ?> VND</h6>
                      <a class="btn btn-info" href="preview.php?i=<?=$row['ID']?>&t=monitors">Mua</a>
                  </div>
                  <?php } ?>
              </div>
          </div>
        </div>

        <?php include 'preset/footer.php';?>
    </div>

    <script type="text/javascript">
      $(document).ready(function(){
//************************************************************CLICK CALL************************************** */
        $(".product_check").click(function(){
          var arr_Filter1 = document.querySelectorAll("#Filter1");
          var arr_Filter2 = document.querySelectorAll("#Filter2");
          var arr_Filter3 = document.querySelectorAll("#Filter3");
          var arr_Filter4 = document.querySelectorAll("#Filter4");

          sendstr="";

          array1 = [];
          array2 = [];
          array3 = [];
          array4 = [];
          Category = ["monitor"];

          arr_Filter1.forEach(pro_filter1);
          arr_Filter2.forEach(pro_filter2);
          arr_Filter3.forEach(pro_filter3);
          arr_Filter4.forEach(pro_filter4);

          if (array1.length>0){
            var myJSON = JSON.stringify(array1);
            sendstr = sendstr.concat("array1="+myJSON+"&");
          }
          if (array2.length>0){
            var myJSON = JSON.stringify(array2);
            sendstr = sendstr.concat("array2="+myJSON+"&");
          }
          if (array3.length>0){
            var myJSON = JSON.stringify(array3);
            sendstr = sendstr.concat("array3="+myJSON+"&");
          }
          if (array4.length>0){
            var myJSON = JSON.stringify(array4);
            sendstr = sendstr.concat("array4="+myJSON+"&");
          }
          var myJSON = JSON.stringify(Category);
          sendstr = sendstr.concat("Category="+myJSON+"&");
          console.log(sendstr);

//************************************************************SENDING DATA TO SERVER******************************************** */
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("result").innerHTML = this.responseText;
            }
          };
          xmlhttp.open("POST", "filter.php", true);
          xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xmlhttp.send(sendstr);

        });
//********************************************************CLICK CALL END************************************************ */
        function pro_filter1(val){
        if(val.checked==true){
            array1.push(val.value);
        }
    }
    function pro_filter2(val){
        if(val.checked==true){
            array2.push(val.value);
        }
    }
    function pro_filter3(val){
        if(val.checked==true){
            array3.push(val.value);
        }
    }
    function pro_filter4(val){
        if(val.checked==true){
            array4.push(val.value);
        }
    }

//******************************************************************************************************************************** */


      });
    </script>
  </body>
</html>
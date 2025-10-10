<?php
// Kết nối cơ sở dữ liệu
$host = "localhost"; // Tên máy chủ
$username = "root";  // Tên đăng nhập
$password = "";      // Mật khẩu
$dbname = "shop";    // Tên cơ sở dữ liệu

$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu có từ khóa tìm kiếm
if (isset($_GET['query'])) {
    $query = $conn->real_escape_string($_GET['query']); // Bảo vệ chống SQL Injection

    // Truy vấn tìm kiếm
    $sql = "SELECT * FROM products 
            WHERE Name LIKE '%$query%' 
            OR Brand LIKE '%$query%' 
            OR Category LIKE '%$query%'";

    $result = $conn->query($sql);

    // // Hiển thị kết quả
    // if ($result->num_rows > 0) {
    //     echo "<h2>Kết quả tìm kiếm:</h2>";
    //     echo "<div class='row'>";
    //     while ($row = $result->fetch_assoc()) {
    //         echo "<div class='col-md-3'>";
    //         echo "<img src='" . htmlspecialchars($row['Image']) . "' width='250px'><br>";
    //         echo "<h5>" . htmlspecialchars($row['Name']) . "</h5>";
    //         echo "<h6>" . number_format($row['Price'], 0, '', '.') . " VND</h6>";
    //         echo "<a class='btn btn-info' href='preview.php?i=" . htmlspecialchars($row['ID']) . "&t=" . htmlspecialchars($row['Category']) . "'>Mua</a>";
    //         echo "</div>";
    //     }
    //     echo "</div>";
    // } else {
    //     echo "<p>Không tìm thấy kết quả nào cho '<strong>" . htmlspecialchars($query) . "</strong>'</p>";
    // }
}

$conn->close();
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
    </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="assets/V.png">
    <!-- Thư viện Bootstrap CSS -->
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

    <div class="container-fluid" >
          <!-- chèn phần tiêu đề  và carousel -->
          <?php include 'preset/header.php';?>
          <?php include 'preset/mcarosal.php';?>


          <!-- <h1>Tìm kiếm</h1> -->
          <!-- <form action="search.php" method="get">
              <input type="text" name="query" placeholder="Nhập tên sản phẩm, thương hiệu hoặc danh mục" required>
              <button type="submit">Tìm kiếm</button>
          </form> -->

          <div class="container">
              <div class="row">
                  <?php
                  // Kết nối cơ sở dữ liệu
                  $host = "localhost"; // Tên máy chủ
                  $username = "root";  // Tên đăng nhập
                  $password = "";      // Mật khẩu
                  $dbname = "shop";    // Tên cơ sở dữ liệu

                  $conn = new mysqli($host, $username, $password, $dbname);

                  // Kiểm tra kết nối
                  if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                  }

                  // Kiểm tra nếu có từ khóa tìm kiếm
                  if (isset($_GET['query'])) {
                      $query = $conn->real_escape_string($_GET['query']); // Bảo vệ chống SQL Injection

                      // Truy vấn tìm kiếm
                      $sql = "SELECT * FROM products 
                              WHERE Name LIKE '%$query%' 
                              OR Brand LIKE '%$query%' 
                              OR Category LIKE '%$query%'";

                      $result = $conn->query($sql);

                      // Hiển thị kết quả
                      if ($result->num_rows > 0) {
                          echo "<h2>Kết quả tìm kiếm:</h2>";
                          while ($row = $result->fetch_assoc()) {
                              echo "<div class='col-md-3'>";
                              echo "<img src='" . htmlspecialchars($row['Image']) . "' width='250px'><br>";
                              echo "<h5>" . htmlspecialchars($row['Name']) . "</h5>";
                              echo "<h6>" . number_format($row['Price'], 0, '', '.') . " VND</h6>";
                              echo "<a class='btn btn-info' href='preview.php?i=" . htmlspecialchars($row['ID']) . "&t=" . htmlspecialchars($row['Category']) . "'>Mua</a>";
                              echo "</div>";
                          }
                      } else {
                          echo "<p>Không tìm thấy kết quả nào cho '<strong>" . htmlspecialchars($query) . "</strong>'</p>";
                      }
                  }

                  $conn->close();
                  ?>
              </div>
          </div>

          <?php include 'preset/footer.php';?>

    </div>

  </body>
</html>
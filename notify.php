<!-- Đoạn mã này thực hiện xác thực thông tin thanh toán từ PayHere và thêm thông tin đơn hàng vào cơ sở dữ liệu: -->
<?php

// Kết nối tới cơ sở dữ liệu bằng cách yêu cầu tệp cấu hình
require_once "database/config.php";

// Lấy dữ liệu từ POST gửi từ PayHere
$merchant_id         = $_POST['merchant_id']; // ID của thương nhân
$order_id            = $_POST['order_id']; // ID của đơn hàng
$payhere_amount      = $_POST['payhere_amount']; // Số tiền thanh toán
$payhere_currency    = $_POST['payhere_currency']; // Loại tiền tệ
$status_code         = $_POST['status_code']; // Mã trạng thái thanh toán
$md5sig             = $_POST['md5sig']; // Chữ ký MD5 từ PayHere
$custom_1           = $_POST['custom_1']; // Thông tin tùy chỉnh (nếu có)

// Khóa bí mật của thương nhân, được tìm thấy trên trang cài đặt của tài khoản PayHere
$merchant_secret = '8cL2A0OKls48MQrsNo6l9y8RjZtyErACn4eU2cBot7Is';

// Tạo chữ ký MD5 cục bộ để xác thực dữ liệu nhận được
$local_md5sig = strtoupper(md5($merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret))));

// Kiểm tra xem chữ ký cục bộ có khớp với chữ ký nhận được và trạng thái thanh toán có thành công hay không
if (($local_md5sig === $md5sig) && ($status_code == 2)) {
    // TODO: Cập nhật cơ sở dữ liệu khi thanh toán thành công

    // Thêm thông tin đơn hàng vào bảng "orders"
    $sql = "INSERT INTO orders (ID, Items, TotalAmount, CustomerID) VALUES ('ORD00001', 'amal', 1000, 'amal')";

    // Thực hiện truy vấn để thêm đơn hàng
    if (mysqli_query($link, $sql)) {
        echo "New record created successfully"; // Thông báo thêm đơn hàng thành công
    } else {
        // Nếu có lỗi, hiển thị thông báo lỗi
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }

    // Thêm thông tin sản phẩm vào bảng "orders"
    $sql = "INSERT INTO orders (Name, Brand, Socket, Cores, Price, About, Quantity, Image) VALUES ('$Name', '$Brand', '$Socket', $Cores, $Price, '$About', $Quantity, '$Image')";

    // Thực hiện truy vấn để thêm sản phẩm
    if (mysqli_query($link, $sql)) {
        echo "ok"; // Thông báo thêm sản phẩm thành công
    } else {
        // Nếu có lỗi, hiển thị thông báo lỗi
        echo "not" . mysqli_error($link);
    }
}
?>

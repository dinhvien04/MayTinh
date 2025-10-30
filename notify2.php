<?php
session_start();
// Kết nối tới cơ sở dữ liệu bằng cách yêu cầu tệp cấu hình
require_once "database/config.php";

// Lấy dữ liệu từ POST gửi từ PayHere
$merchant_id         = $_POST['merchant_id']; // ID của thương nhân
$item_id             = $_POST['order_id']; // ID của mặt hàng (đơn hàng)
$payhere_amount      = $_POST['amount']; // Số tiền thanh toán
$payhere_currency    = $_POST['currency']; // Loại tiền tệ
$quantity            = $_POST['quantity_1']; // Số lượng sản phẩm
$email               = $_POST['email']; // Địa chỉ email của khách hàng
$cart_id             = $_POST['custom_1']; // ID giỏ hàng, có thể sử dụng để xóa sản phẩm khỏi giỏ hàng
$payment_method      = $_POST['payment_method']; // Phương thức thanh toán

// Thêm đơn hàng vào bảng "orders" trong cơ sở dữ liệu
$payment_status = ($payment_method == 'cash') ? 'unpaid' : 'paid';
$sql = "INSERT INTO orders (ItemID, Quantity, TotalAmount, CustomerEmail, payment_status) VALUES ('$item_id', $quantity, $payhere_amount, '$email', '$payment_status')";

// Thực hiện truy vấn thêm đơn hàng
if (mysqli_query($link, $sql)) {
    // Nếu đơn hàng đã được thêm thành công, xóa sản phẩm khỏi giỏ hàng
    $sql2 = "DELETE FROM cart WHERE ID = $cart_id"; // Truy vấn xóa sản phẩm khỏi giỏ hàng
    if (mysqli_query($link, $sql2)) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Order Status</title>
            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        </head>
        <body>
            <script>
                swal("Thành công!", "Bạn đã đặt hàng thành công!", "success")
                .then((value) => {
                  window.location.href = "account.php#list-orders";
                });
            </script>
        </body>
        </html>
        <?php
    } else {
        // Nếu có lỗi khi xóa, hiển thị lỗi
        echo "Lỗi: " . mysqli_error($link);
    }
} else {
    // Nếu có lỗi khi thêm đơn hàng, hiển thị lỗi
    echo "Lỗi: " . mysqli_error($link);
}

?>
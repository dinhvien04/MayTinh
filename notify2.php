<?php

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

// Hiển thị thông tin nhận được để kiểm tra
echo " mar" . $merchant_id;
echo " orID" . $item_id;
echo " qua" . $quantity;
echo " amt" . $payhere_amount;
echo " aaa" . $payhere_currency;
echo " email" . $email;
echo " cartID" . $cart_id;

// Thêm đơn hàng vào bảng "orders" trong cơ sở dữ liệu
$sql = "INSERT INTO orders (ItemID, Quantity, TotalAmount, CustomerEmail) VALUES ('$item_id', $quantity, $payhere_amount, '$email')";

// Thực hiện truy vấn thêm đơn hàng
if (mysqli_query($link, $sql)) {
    echo "New order added successfully"; // Thông báo thành công khi thêm đơn hàng

    // Nếu đơn hàng đã được thêm thành công, xóa sản phẩm khỏi giỏ hàng
    $sql2 = "DELETE FROM cart WHERE ID = $cart_id"; // Truy vấn xóa sản phẩm khỏi giỏ hàng
    if (mysqli_query($link, $sql2)) {
        echo "Deleted"; // Thông báo xóa thành công
        header("Location: account.php"); // Chuyển hướng đến trang tài khoản
        exit(); // Dừng thực thi mã sau khi chuyển hướng
    } else {
        // Nếu có lỗi khi xóa, hiển thị lỗi
        echo "Error: " . mysqli_error($link);
    }
} else {
    // Nếu có lỗi khi thêm đơn hàng, hiển thị lỗi
    echo "Error: " . mysqli_error($link);
}

?>

<!-- Đoạn mã này xử lý thông tin thanh toán từ dịch vụ PayHere: -->
<?php

$merchant_id         = $_POST['merchant_id']; // Lấy ID của thương nhân từ dữ liệu POST
$order_id            = $_POST['order_id']; // Lấy ID của đơn hàng từ dữ liệu POST
$payhere_amount      = $_POST['payhere_amount']; // Lấy số tiền thanh toán từ dữ liệu POST
$payhere_currency    = $_POST['payhere_currency']; // Lấy loại tiền tệ từ dữ liệu POST
$status_code         = $_POST['status_code']; // Lấy mã trạng thái thanh toán từ dữ liệu POST
$md5sig              = $_POST['md5sig']; // Lấy chữ ký MD5 từ dữ liệu POST

$merchant_secret = 'XXXXXXXXXXXXX'; // Thay thế bằng Mật khẩu Thương nhân của bạn (có thể tìm thấy trên trang Cài đặt tài khoản PayHere)

// Tạo chữ ký MD5 cục bộ bằng cách sử dụng các thông tin đã nhận
$local_md5sig = strtoupper(md5(
    $merchant_id . 
    $order_id . 
    $payhere_amount . 
    $payhere_currency . 
    $status_code . 
    strtoupper(md5($merchant_secret)) 
));

// Kiểm tra xem chữ ký MD5 cục bộ có khớp với chữ ký MD5 từ PayHere không và trạng thái thanh toán có thành công không
if (($local_md5sig === $md5sig) AND ($status_code == 2) ){
    //TODO: Cập nhật cơ sở dữ liệu của bạn về việc thanh toán thành công
}

?>

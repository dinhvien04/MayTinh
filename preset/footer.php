<div class="row pt-3 AVfooter">
  <!-- khoảng trống bên trái để tạo không gian(1/12 chiều rộng) -->
    <div class="col-md-1"></div>

    <div class="col-md-3 A1">
      <div> 
        <p id="title">VIEN Computers</p>
        <p id="sub">Hãy cùng chúng tôi chinh phục ước mơ của bạn</p>
        <p>Chúng tôi sẽ đáp ứng đầy đủ mọi nhu cầu về máy tính và phụ kiện của bạn, hơn cả những gì bạn mong đợi. </p>
      </div>
    </div>

    <!-- phần danh sách địa chỉ -->
    <div class="col-md-2 pt-3 A2">
      <h5>Visit</h5>
      <p>Nguyễn Đình Viễn, </p>
      <p>Lê Văn Hải, </p>
      <p>Đặng Huỳnh Nguyên, </p>
      <p>Phan Thanh Vinh. </p>
    </div>
<!-- phần liên kết mạng xã hội -->
    <div class="col-md-2 pt-3 A3">
      <h5>Follow</h5>
      <!-- các icon dẫn đến các trang mạng xã hội -->
      <a href="https://www.facebook.com/profile.php?id=100048151745011&mibextid=LQQJ4d" class="f"><i class="bi bi-facebook" style="font-size: 30px;"></i></a>
      <a href="https://www.youtube.com/@bwftv" class="y"><i class="bi bi-youtube" style="font-size: 30px;"></i></a>
      <a href="#" class="l"><i class="bi bi-linkedin" style="font-size: 30px;"></i></a>
      <a href="#" class="t"><i class="bi bi-twitter" style="font-size: 30px;"></i></a>
    </div>

    <!-- thông tin liên hệ -->
    <div class="col-md-2 pt-3 A4">
      <h5>Contact US</h5>
      <!-- số điện thoại -->
      <p>Phone : <br> 070 322456</p>
      <p>Phone : <br> 077 888999</p>
    </div>

    <!-- phần nhà phát triển trang web -->
    <div class="col-md-2 pt-3 A5">
      <p>Devoloped By</p>
      <img src="assets/vien.jpg"     class="rounded-circle" width="60px" alt="">
      <img src="assets/hai.jpg" class="rounded-circle" width="60px" alt="">
      <img src="assets/ngen.jpg"   class="rounded-circle" width="60px" alt="">
      <img src="assets/vinh.jpg"   class="rounded-circle" width="60px" alt="">
      
      <div class="col-12"><p>Viễn Hải Nguyên Vinh</p></div>
    </div>

   <!-- ================================================================================================== -->

    <div class="col-md-1" style="background-color: black;"></div>

    <div class="col-md-11 A5" style="background-color: black;">
      <p >@ copyright 2024 VIEN Computers - All right reserved</p>
    </div>

    <!-- ================================================================================================== -->
    <!-- ================================================================================================== -->
    
    <!-- Tích hợp mess Chat Plugin của facebook -->
    <div id="fb-root"></div>

    <!-- plugin chat của facelook -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "108925734735529");
      chatbox.setAttribute("attribution", "biz_inbox");
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v10.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    
    <!-- ================================================================================================== -->
    <!-- ================================================================================================== -->

</div>
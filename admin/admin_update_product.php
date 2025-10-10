<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Cập nhật sản phẩm</h1>

<form id="filter" >
    <div class="form-row">
        <div class="form-group col-md-4">
            <label>Danh mục</label>
            <select class="form-control" id="editcat" name="Category" onchange="filter(this)">
                <option value="laptop" >Laptop</option>
                <option value="desktop" >Desktop</option>
                <option value="casing" >Vỏ máy</option>
                <option value="cooling" >Tản nhiệt</option>
                <option value="graphics" >Card đồ họa</option>
                <option value="motherboard" >Bo mạch chủ</option>
                <option value="monitors" >Màn hình</option>
                <option value="power" >Nguồn điện</option>
                <option value="proccessor" >Bộ xử lý</option>
                <option value="ram" >RAM</option>
                <option value="storage" >Lưu trữ</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Thương hiệu</label>
            <select class="form-control" name="Brand">
            <?php
                $brands = get_brands($link);
                foreach ($brands as $brand) {
                    echo "<option>".$brand."</option>";
                }
            ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Giới hạn</label>
            <input type="number" class="form-control" name="limit">
            <input type="text" name="task" value="Update" hidden>
        </div>

    </div>
</form>

<table class="table">
    <caption>Danh sách người dùng</caption>
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Tên<h6>Thông số 1</h6></th>
        <th scope="col">Thương hiệu<h6>Thông số 2</h6></th>
        <th scope="col">Tình trạng<h6>Thông số 3</h6></th>
        <th scope="col">Số lượng<h6>Thông số 4</h6></th>
        <th scope="col">Giá</th>
        <th scope="col">Giới thiệu</th>
        <th scope="col">Chỉnh sửa</th>
        <th scope="col">Cập nhật</th>
        </tr>
    </thead>
    <tbody id="TableBody">
    <?php
        $products = get_products($link, 'laptop', '', 20);
        echo $products;
    ?>
    </tbody>
</table>

<script>
    function filter(input) {
        const formData = new FormData(document.getElementById('filter'));

        fetch('admin_actions.php?task=get_products', {
            method:"POST",
            body: formData
        }).then(function (response) {
            return response.text();
        })
        .then(function (data) {
            document.getElementById("TableBody").innerHTML = data;
        })
    }

    function table(id) {
        var x = document.getElementsByClassName(id);
        for (var i = 0; i < x.length; i++) {
            x[i].style.pointerEvents = 'all';
        }
    }

    function submitForm(id){
        var y = document.getElementsByClassName(id);
        const formData = new FormData();
        formData.append("Name"  , y[0].value);
        formData.append("Spec1" , y[1].value);
        formData.append("Brand" , y[2].value);
        formData.append("Spec2" , y[3].value);
        formData.append("Availability" , y[4].value);
        formData.append("Spec3" , y[5].value);
        formData.append("Quantity" , y[6].value);
        formData.append("Spec4" , y[7].value);
        formData.append("Price" , y[8].value);
        formData.append("About" , y[9].value);
        formData.append("ID" , id);
        
        formData.append("task", "ProductUpdate");

        fetch('admin_actions.php', {
            method:"POST",
            body: formData
        }).then(function (response) {
            return response.text();
        })
        .then(function (data) {
            alert(data);
        })
    }
</script>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Update Product</h1>

<form id="filter" >
    <div class="form-row">
        <div class="form-group col-md-4">
            <label>Category</label>
            <select class="form-control" id="editcat" name="Category" onchange="filter(this)">
                <option value="laptop" >Laptop</option>
                <option value="desktop" >Desktop</option>
                <option value="casing" >Casing</option>
                <option value="cooling" >Cooling</option>
                <option value="graphics" >Graphics</option>
                <option value="motherboard" >MotherBoard</option>
                <option value="monitors" >Monitors</option>
                <option value="power" >PowerSupply</option>
                <option value="proccessor" >Processor</option>
                <option value="ram" >RAM</option>
                <option value="storage" >Storage</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Brand</label>
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
            <label>limit</label>
            <input type="number" class="form-control" name="limit">
            <input type="text" name="task" value="Update" hidden>
        </div>

    </div>
</form>

<table class="table">
    <caption>List of users</caption>
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Name<h6>Spec1</h6></th>
        <th scope="col">Brand<h6>Spec2</h6></th>
        <th scope="col">Availability<h6>Spec3</h6></th>
        <th scope="col">Quantity<h6>Spec4</h6></th>
        <th scope="col">Price</th>
        <th scope="col">About</th>
        <th scope="col">Edit</th>
        <th scope="col">Update</th>
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

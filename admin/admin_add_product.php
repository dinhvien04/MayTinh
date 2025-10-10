<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Add Product</h1>

<form id="addProductForm" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label>Category</label>
            <select class="form-control" name="Category" onchange="changeSpec(this);">
                <option>Laptop</option>
                <option>Desktop</option>
                <option>Casing</option>
                <option>Cooling</option>
                <option>Graphics</option>
                <option>MotherBoard</option>
                <option>Monitors</option>
                <option>PowerSupply</option>
                <option>Processor</option>
                <option>RAM</option>
                <option>Storage</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label>Price</label>
            <input type="number" class="form-control" name="Price">
        </div>
        <div class="form-group col-md-4">
            <label>Brand</label>
            <select class="form-control" name="Brand">
                <option>ASUS</option>
                <option>ACER</option>
                <option>SAMSUNG</option>
                <option>G-SKILL</option>
                <option>ADATA</option>
                <option>GIGABYTE</option>
                <option>Monitors</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="Name">
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label id="spec1a">Processor</label>
            <input id="spec1b" type="text" class="form-control" name="Spec1">
        </div>
        <div class="form-group col-md-3">
            <label id="spec2a">GPU</label>
            <input id="spec2b" type="text" class="form-control" name="Spec2">
        </div>
        <div class="form-group col-md-3">
            <label id="spec3a">RAM</label>
            <input id="spec3b" type="number" class="form-control" name="Spec3">
        </div>
        <div class="form-group col-md-3">
            <label id="spec4a">Size</label>
            <input id="spec4b" type="number" class="form-control" name="Spec4">
        </div>
    </div>

    <div class="form-group">
        <label>Quantity</label>
        <input type="number" class="form-control" name="Quantity">
    </div>
    <div class="form-group">
        <label>About</label>
        <textarea class="form-control" rows="5" name="About"></textarea>
        <input type="text" name="task" value="AddNew" hidden>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label>Image</label>
            <input type="file" class="form-control-file" name="image" required onchange="readURL(this);">
        </div>
        <div class="form-group col-md-3">
            <img id="preview" src="http://placehold.it/180" alt="your image" style="width: 200px;">
        </div>
    </div>
    <div class="form-group">
        <input type="submit" class="form-control-file" value="Add">
    </div>
</form>

<script>
    const addProductForm = document.getElementById('addProductForm');

    addProductForm.addEventListener('submit', function(e){
        e.preventDefault();

        const formData = new FormData(this);

        fetch('admin_actions.php', {
            method:"POST",
            body: formData
        }).then(function (response) {
            return response.text();
        })
        .then(function (data) {
            alert(data);
        })
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('preview').src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function changeSpec(input) {
        var spec1a = document.getElementById('spec1a');
        var spec1b = document.getElementById('spec1b');
        var spec2a = document.getElementById('spec2a');
        var spec2b = document.getElementById('spec2b');
        var spec3a = document.getElementById('spec3a');
        var spec3b = document.getElementById('spec3b');
        var spec4a = document.getElementById('spec4a');
        var spec4b = document.getElementById('spec4b');

        var cat = input.value;

        // Reset all to visible
        spec1b.hidden=false;spec2b.hidden=false;spec3b.hidden=false;spec4b.hidden=false;

        switch(cat) {
            case 'Laptop':
                spec1a.innerHTML = 'Processor';spec2a.innerHTML='GPU';spec3a.innerHTML='RAM';spec4a.innerHTML='Size';
                break;
            case 'Desktop':
                spec1a.innerHTML = 'Processor';spec2a.innerHTML='GPU';spec3a.innerHTML='RAM';spec4a.innerHTML='Size';
                break;
            case 'Casing':
                spec1a.innerHTML = 'Form Factor';spec2a.innerHTML='';spec3a.innerHTML='';spec4a.innerHTML='';
                spec2b.hidden=true;spec3b.hidden=true;spec4b.hidden=true;
                break;
            case 'Cooling':
                spec1a.innerHTML = 'Socket';spec2a.innerHTML='Liquid/Air';spec3a.innerHTML='Number of Fans';spec4a.innerHTML='';
                spec4b.hidden=true;
                break;
            case 'Graphics':
                spec1a.innerHTML = 'Chipset';spec2a.innerHTML='PCI Version';spec3a.innerHTML='Size';spec4a.innerHTML='Rated Power Supply';
                break;
            case 'MotherBoard':
                spec1a.innerHTML = 'CPU Socket';spec2a.innerHTML='Latest hard disk socket';spec3a.innerHTML='DDR Version';spec4a.innerHTML='PCI Version';
                break;
            case 'Monitors':
                spec1a.innerHTML = 'Resolution';spec2a.innerHTML='';spec3a.innerHTML='Hertz';spec4a.innerHTML='Size';
                spec2b.hidden=true;
                break;
            case 'PowerSupply':
                spec1a.innerHTML = 'Efficiency';spec2a.innerHTML='Watt';spec3a.innerHTML='';spec4a.innerHTML='';
                spec3b.hidden=true;spec4b.hidden=true;
                break;
            case 'Processor':
                spec1a.innerHTML = 'Socket';spec2a.innerHTML='';spec3a.innerHTML='Cores';spec4a.innerHTML='';
                spec2b.hidden=true;spec4b.hidden=true;
                break;
            case 'RAM':
                spec1a.innerHTML = 'DDR Version';spec2a.innerHTML='Package Size';spec3a.innerHTML='Memory';spec4a.innerHTML='Hertz';
                break;
            case 'Storage':
                spec1a.innerHTML = 'Des/Lap/Both';spec2a.innerHTML='Socket';spec3a.innerHTML='Capacity';spec4a.innerHTML='';
                spec4b.hidden=true;
                break;
        }
    }
</script>

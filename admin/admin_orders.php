<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Orders</h1>

<div class="overflow-auto" style="height: 1000px;">
    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">ItemName</th>
            <th scope="col">Quantity</th>
            <th scope="col">UnitPrice</th>
            <th scope="col">TotalAmount</th>
            <th scope="col">Date & Time</th>
            <th scope="col">Customer</th>
            <th scope="col">DeliveryState</th>
            </tr>
        </thead>
        <tbody id="showtable">
            <?php echo get_orders($link); ?>
        </tbody>
    </table>
</div>

<script>
    function userinformation(id){
        const formDataCustomer = new FormData();
        formDataCustomer.append("CustomerEmail", id);
        formDataCustomer.append("task", "showcustomer");

        fetch('admin_actions.php', {
                method:"POST",
                body: formDataCustomer
            }).then(function (response) {
                return response.text();
            })
            .then(function (data) {
                document.getElementById('UserInformation').innerHTML = data;
            })
    }
    function delivery(id){
        swal({
            title: "Are you sure?",
            text: "Once Changed, you will not be able to undo !",
            icon: "warning",
            dangerMode: true,
            buttons: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                const formDatadelivery = new FormData();
                formDatadelivery.append("ID", id);
                formDatadelivery.append("task", "delivery");

                fetch('admin_actions.php', {
                        method:"POST",
                        body: formDatadelivery
                    }).then(function (response) {
                        return response.text();
                    })
                    .then(function (data) {
                        swal("Done!", data, "success");
                        showtable();
                    })
            } else {
                
            }
            });

    }
    function showtable(){
        const formDatashow = new FormData();
        formDatashow.append("task", "tableupdate");

        fetch('admin_actions.php', {
                method:"POST",
                body: formDatashow
            }).then(function (response) {
                return response.text();
            })
            .then(function (data) {
                document.getElementById('showtable').innerHTML = data;
            })
    }
</script>

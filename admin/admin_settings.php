<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Settings</h1>

<h4>Update Password</h4>

<form id="changePass"> 
    <div class="form-group">
        <label>New Password</label>
        <input type="password" id="newPass" name="new_password" class="form-control" value="">
        <span id="snewPass" class=""></span>
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" id="confirmPass" name="confirm_password" class="form-control">
        <span id="sconfirmPass" class=""></span>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Change">
    </div>
</form>

<h4>Update Name</h4>

<form id="userUpdate" >

    <div class="form-group">
    <label>First Name</label>
    <input type="text" class="form-control" name="FirstName"  required>
    </div>

    <div class="form-group">
    <label>Last Name</label>
    <input type="text" class="form-control" name="LastName"  required>
    </div>

    <input type="text" hidden name="task" value="adminUpdate">
    <button type="submit" class="btn btn-primary">Update</button>
    
</form>

<script>
    const changePassForm = document.getElementById('changePass');

    changePassForm.addEventListener('submit', function(e){
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("task", "changePassword");

        fetch('admin_actions.php', {
            method:"POST",
            body: formData
        }).then(function (response) {
            return response.text();
        })
        .then(function (data) {
            const obj = JSON.parse(data);
            document.getElementById("newPass").className = (obj.new_password_err == "" ? 'form-control is-valid' : 'form-control is-invalid');
            document.getElementById("snewPass").innerHTML = obj.new_password_err;
            document.getElementById("confirmPass").className = (obj.confirm_password_err == "" ? 'form-control is-valid' : 'form-control is-invalid');
            document.getElementById("sconfirmPass").innerHTML = obj.confirm_password_err;
            if(obj.msg=="done"){
                swal("successfully Updated!", "  ", "success");
                document.getElementById("newPass").className = 'form-control';
                document.getElementById("newPass").value = "";
                document.getElementById("confirmPass").className = 'form-control';
                document.getElementById("confirmPass").value = "";
            }
        })
    });

    const userUpdateForm = document.getElementById('userUpdate');

    userUpdateForm.addEventListener('submit', function(e){
        e.preventDefault();

        const formData = new FormData(this);
        formData.append("task", "adminUpdate");

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
</script>

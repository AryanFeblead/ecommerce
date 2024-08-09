$(document).ready(function() {
    $("#val_email,#val_password,#val_role,#success,#notsuccess").hide();
    console.log('sadasd');

    $("#login_form").on("submit", function(e) {
        e.preventDefault();
        console.log("sfsdg");
        $("#val_email,#val_password,#val_role").hide();
        var isValid = true;

        var email = $("#emp_email").val();
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email == "") {
            $("#val_email").show().css("color", "red");
            isValid = false;
        } else if (!emailPattern.test(email)) {
            $("#val_email").show().css("color", "red").html("Invalid email format");
            isValid = false;
        }

        if ($("#emp_password").val() == "") {
            $("#val_password").show().css("color", "red");
            isValid = false;
        }

        if (isValid) {
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "./function.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $("#val_email,#val_password,#val_role,#success,#notsuccess").hide();
                    console.log("done");
                    var data1 = JSON.parse(data);
                    if (data1.status == "emp_error") {
                        $("#val_email").show().css("color", "red").html("Invalid email");
                        $("#val_password").show().css("color", "red").html("Password Incorrect");
                    }
                    if (data1.status == "emp_pass_error") {
                        $("#val_password").show().css("color", "red").html("Password Incorrect");
                    }
                    if(data1.status == "success"){
                        window.location.href = "../../fruitables";
                    }
                },
                error: function() {
                    $("#create_user_form")[0].reset();
                    $("#notsuccess").show().html("Employee Addition Failed");
                },
            });
        }
    });
});
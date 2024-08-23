$(document).ready(function() {

    $("#fname,#lname,#address,#city,#country,#postcode,#mobile,#email,#payment").hide();
    $("#mobile1").on("input", function() {
        if ($(this).val().length > 10) {
            $(this).val($(this).val().substring(0, 10));
        }
    });
    $("#checkout").click(function(e) {
        e.preventDefault();
        var isValid = true;
        if ($("#fname1").val() == "") {
            $("#fname").show().css("color", "red");
            isValid = false;
        }
        if ($("#lname1").val() == "") {
            $("#lname").show().css("color", "red");
            isValid = false;
        }
        if ($("#address1").val() == "") {
            $("#address").show().css("color", "red");
            isValid = false;
        }
        if ($("#city1").val() == "") {
            $("#city").show().css("color", "red");
            isValid = false;
        }
        if ($("#country1").val() == "") {
            $("#country").show().css("color", "red");
            isValid = false;
        }
        if ($("#postcode1").val() == "") {
            $("#postcode").show().css("color", "red");
            isValid = false;
        }
        var email = $("#email1").val();
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email == "") {
            $("#email").show().css("color", "red");
            isValid = false;
        } else if (!emailPattern.test(email)) {
            $("#email").show().css("color", "red").html("Invalid email format");
            isValid = false;
        }

        // Validate phone number
        var mobile = $("#mobile1").val();
        if (mobile == "") {
            $("#mobile").show().css("color", "red");
            isValid = false;
        } else if (mobile.length < 10) {
            $("#mobile")
                .show()
                .html("Mobile no. should be 10 digits")
                .css("color", "red");
            isValid = false;
        }

        // Validate role
        if ($(".payment:checked").length === 0) {
            $("#payment").show().css("color", "red");
            isValid = false;
        }

        if (isValid) {
            var fname = $("#fname1").val();
            var lname = $("#lname1").val();
            var address = $("#address1").val();
            var city = $("#city1").val();
            var country = $("#country1").val();
            var postcode = $("#postcode1").val();
            var payment = $(".payment:checked").val();
            mobile = $("#mobile1").val();
            email = $("#email1").val();
            $.ajax({
                type: "POST",
                url: "./php/ajx.php",
                data: {
                    fname: fname,
                    lname: lname,
                    address: address,
                    city: city,
                    country: country,
                    postcode: postcode,
                    payment: payment,
                    mobile: mobile,
                    email: email,
                    actionName: "checkout",
                },
                success: function(data) {
                    $("#fname,#lname,#address,#city,#country,#postcode,#mobile,#email,#payment").hide();
                    var data1 = JSON.parse(data);
                    console.log(data1);
                    if (data1.status == "success") {
                        window.location.href = "./index.php";
                    }
                    if (data1.status == "error") {
                        $("#danger").show().delay(2000).fadeOut().html("Product Not added");
                    }
                },
                error: function() {
                    console.error("error");
                },
            });
        }
    });


});
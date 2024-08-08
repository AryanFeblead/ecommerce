$(document).ready(function() {
    $("#success,#danger").hide();
    $("#search-icon-7").click(function(e) {
        e.preventDefault();
        var search07 = $("#search07").val();
        var isValid = true;
        if (isValid && search07) {
            $.ajax({
                type: "POST",
                url: "./php/ajx.php",
                data: {
                    actionName: "all_search",
                    search07: search07
                },
                success: function(data) {
                    var data1 = JSON.parse(data);
                    console.log(data);

                    if (data1.status == "success") {

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
    $(".del").click(function() {
        var itemId = $(this).data("item-id");
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "./php/ajx.php",
                type: "POST",
                data: { id: itemId, actionName: "add_cart_delete" },
                success: function(data) {
                    var data1 = JSON.parse(data);
                    if (data1.status == "success") {
                        $(this).closest(".item-row").remove();
                        window.location.reload();
                    } else {
                        alert("Failed to remove item.");
                    }
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                },
            });
        }
    });
});
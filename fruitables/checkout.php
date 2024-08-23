<?php

require('conn.php');
session_start();
// include_once 'paypal_config.php';

if (!isset($_SESSION['customer_id']) && !isset($_SESSION['access_token'])) {
    header("Location: ../login/dist/");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Fruitables - Vegetable Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Web Fonts -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
    <script src="./js/checkout.js"></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id=AbbWEwFwFmOcu5N7kKOnLvF9Kge61K8t6zJfHObeXcKzEyPYSjFV4xobD0acNOQ3EoQT5uK52Q6k1Npp&components=buttons&enable-funding=paylater,venmo,card"
        data-sdk-integration-source="integrationbuilder_sc"></script>
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar bg-primary d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#"
                            class="text-white">123 Street, New York</a></small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#"
                            class="text-white">Email@Example.com</a></small>
                </div>
                <div class="top-link pe-2">
                    <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                    <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                    <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                </div>
            </div>
        </div>
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="index.html" class="navbar-brand">
                    <h1 class="text-primary display-6">Fruitables</h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="shop.php" class="nav-item nav-link">Shop</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="cart.php" class="dropdown-item">Cart</a>
                                <a href="checkout.php" class="dropdown-item active">Checkout</a>
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="d-flex m-3 me-0">
                        <button
                            class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4"
                            data-bs-toggle="modal" data-bs-target="#searchModal"><i
                                class="fas fa-search text-primary"></i></button>
                        <a href="#" class="position-relative me-4 my-auto">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span
                                class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                                <?php echo isset($_SESSION['cart_item']) ? count($_SESSION['cart_item']) : 0; ?>
                            </span>
                        </a>
                        <a href="logout.php" class="my-auto">
                            <i class="fa-solid fa-right-from-bracket" style="font-size: 2rem;"></i>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->


    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Checkout</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active text-white">Checkout</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Checkout Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Billing details</h1>
            <form method="POST">
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">First Name<sup>*</sup></label>
                                    <input type="text" class="form-control" id="fname1">
                                </div>
                                <div id="fname">
                                    Please choose a first name.
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">Last Name<sup>*</sup></label>
                                    <input type="text" class="form-control" id="lname1">
                                </div>
                                <div id="lname">
                                    Please choose a last name.
                                </div>
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Address <sup>*</sup></label>
                            <input type="text" class="form-control" placeholder="House Number Street Name"
                                id="address1">
                            <div id="address">
                                Please choose a address.
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Town/City<sup>*</sup></label>
                            <input type="text" class="form-control" id="city1">
                            <div id="city">
                                Please choose a city.
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Country<sup>*</sup></label>
                            <input type="text" class="form-control" id="country1">
                            <div id="country">
                                Please choose a Country.
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Postcode/Zip<sup>*</sup></label>
                            <input type="number" class="form-control" id="postcode1">
                            <div id="postcode">
                                Please choose a postcode.
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Mobile<sup>*</sup></label>
                            <input type="number" class="form-control" id="mobile1">
                            <div id="mobile">
                                Please choose a mobile no.
                            </div>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Email Address<sup>*</sup></label>
                            <input type="email" class="form-control" id="email1">
                            <div id="email">
                                Please choose a email.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-5">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Products</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_SESSION['cart_item']) && !empty($_SESSION['cart_item'])) {
                                        foreach ($_SESSION['cart_item'] as $item) {
                                            $display_cart = '<tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center mt-2">
                                            <img src="' . htmlspecialchars($item['prod_img']) . '" class="img-fluid rounded-circle"
                                                style="width: 90px; height: 90px;" alt="">
                                        </div>
                                    </th>
                                    <td class="py-5">Awesome ' . htmlspecialchars($item['prod_name']) . '</td>
                                    <td class="py-5">' . htmlspecialchars($item['prod_price']) . '</td>
                                    <td class="py-5">' . htmlspecialchars($item['prod_quantity']) . '</td>
                                    <td class="py-5">' . htmlspecialchars($item['prod_total']) . '</td>
                                </tr>';
                                            echo $display_cart;
                                        }
                                        $totalAmount = 0;

                                        // Calculate total amount
                                        foreach ($_SESSION['cart_item'] as $item) {
                                            $itemTotal = $item['prod_price'] * $item['prod_quantity'];
                                            $totalAmount += $itemTotal;
                                        }

                                        // Format the total amount for display
                                        $formattedTotal = number_format($totalAmount, 2);
                                        $total = '<tr>
                                        <th scope="row">
                                        </th>
                                        <td class="py-5">
                                            <p class="mb-0 text-dark text-uppercase py-3">TOTAL</p>
                                        </td>
                                        <td class="py-5"></td>
                                        <td class="py-5"></td>
                                        <td class="py-5">
                                            <div class="py-3 border-bottom border-top">
                                                <p class="mb-0 text-dark">' . $totalAmount . '</p>
                                            </div>
                                        </td>
                                    </tr>';
                                        echo $total;
                                    } else {
                                        $display = "<h1 class='text-center'>Cart is Empty</h1>";
                                    }



                                    ?>

                                </tbody>
                            </table>
                            <?php
                            if (!isset($_SESSION['cart_item'])) {
                                echo $display;
                            }
                            ?>
                        </div>
                        <?php
                        if (isset($_SESSION['cart_item'])) {
                            $payment = '<div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                            <div class="col-12">
                                <div class="form-check text-start my-3">
                                    <input type="radio" class="form-check-input bg-primary border-0 payment" id="Delivery-1"
                                        name="payment" value="COD">
                                    <label class="form-check-label" for="Delivery-1">Cash On Delivery</label>
                                    </div>
                                    <div id="payment">
                                Please choose a payment option.
                            </div>
                            </div>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                            <button id="checkout"
                                class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place
                                Order</button>
                        </div>
                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                            <div id="paypal-button-container"></div>
                        </div>';
                            echo $payment;
                        }
                        ?>
                        <div class="container">
                    </div>
                </div>
            </form>
        </div>
        <?php
                        if (isset($_SESSION['cart_item'])) {
                            $pay = '<div class="row">
                            <div id="stripe" class="col-md-4">
                              <button class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary" style="margin-left: 52rem;">Stripe</button>
                            </div>
                          </div>';
                          echo $pay;
                        }
                        ?>
        
    </div>
    <!-- Checkout Page End -->
  

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <a href="#">
                            <h1 class="text-primary mb-0">Fruitables</h1>
                            <p class="text-secondary mb-0">Fresh products</p>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative mx-auto">
                            <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="number"
                                placeholder="Your Email">
                            <button type="submit"
                                class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white"
                                style="top: 0; right: 0;">Subscribe Now</button>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-end pt-3">
                            <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Why People Like us!</h4>
                        <p class="mb-4">typesetting, remaining essentially unchanged. It was
                            popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.</p>
                        <a href="" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read More</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Shop Info</h4>
                        <a class="btn-link" href="">About Us</a>
                        <a class="btn-link" href="">Contact Us</a>
                        <a class="btn-link" href="">Privacy Policy</a>
                        <a class="btn-link" href="">Terms & Condition</a>
                        <a class="btn-link" href="">Return Policy</a>
                        <a class="btn-link" href="">FAQs & Help</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Account</h4>
                        <a class="btn-link" href="">My Account</a>
                        <a class="btn-link" href="">Shop details</a>
                        <a class="btn-link" href="">Shopping Cart</a>
                        <a class="btn-link" href="">Wishlist</a>
                        <a class="btn-link" href="">Order History</a>
                        <a class="btn-link" href="">International Orders</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Contact</h4>
                        <p>Address: 1429 Netus Rd, NY 48247</p>
                        <p>Email: Example@gmail.com</p>
                        <p>Phone: +0123 4567 8910</p>
                        <p>Payment Accepted</p>
                        <img src="img/payment.png" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site
                            Name</a>, All right reserved.</span>
                </div>
                <div class="col-md-6 my-auto text-center text-md-end text-white">
                    <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                    <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                    <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                    Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a
                        class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script>
        // PayPal button configuration
        paypal.Buttons({
            style: {
                layout: 'vertical', // horizontal | vertical
                color: 'blue', // gold | blue | silver | white | black
                shape: 'pill', // pill | rect
                label: 'paypal' // checkout | pay | buynow | paypal | installment
            },

            // Set up the transaction
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $formattedTotal; ?>', // Total amount
                            currency_code: 'USD'
                        }
                    }]
                });
            },

            // Finalize the transaction after buyer approval
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    // Optionally, send the details to your server for further processing
                    $.ajax({
                        url: 'process_payment.php', // Server-side script to handle payment confirmation
                        type: 'POST',
                        data: {
                            payerID: details.payer.payer_id,
                            paymentID: details.id,
                            amount: '<?php echo $formattedTotal; ?>',
                            currency: 'USD'
                        },
                        success: function (response) {
                            var data1 = JSON.parse(response);
                            console.log(data1);
                            if (data1.success == true) {
                                // Redirect to thank you page or update the UI
                                // console.log('redirect');
                                window.location.href = 'thank_you.php?paymentid=' + data1.message + '';
                            } else {
                                // Handle failure
                                alert('Payment processing failed. Please try again.');
                            }
                        }
                    });
                });
            },

            // Handle payment failure
            onError: function (err) {
                console.error('An error occurred during the transaction', err);
                alert('An error occurred during the transaction. Please try again.');
            }
        }).render('#paypal-button-container'); // Render the PayPal button into the container

    </script>
    <script type="text/javascript">

        var stripedone = false;
        $(document).ready(function () {
            $("#stripe").on('click', (function(e) {
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


        if (isValid) {
            $("#fname,#lname,#address,#city,#country,#postcode,#mobile,#email,#payment").hide();
            var handler = StripeCheckout.configure({
                key: 'pk_test_51Pp54dGC4teGxUj2JRnlqxoUfldOau4rwMTc3GAW8LIbdIcIKh4a9frfWsKlPgkwm3Xc15pLpIonzMqNp8outn5s00qgb4gaur',
                locale: 'auto',
                token: function (token) {
                    $.ajax({
                        url: "stripe/payment.php",
                        method: 'post',
                        data: { tokenId: token.id, amount: <?php echo $totalAmount; ?> },
                        dataType: "json",
                        success: function (response) {
                            if (response.data.object === 'charge') {
                                window.location.href = 'thank_you_1.php?paymentid=' + response.data.balance_transaction + '&orderid=' + response.data.id + '&amount=' + response.data.amount;
                            } else {
                                alert('Payment Failed');
                            }
                        }
                    });
                }
            });

            handler.open({
                name: 'Fruitables',
                description: 'Fruits and Vegetables',
                amount: <?php echo $totalAmount * 100; ?> // Stripe requires amount in cents
            });
        } else {
            alert('Plz fill all detail before payment');
            stripedone = false;
        }

    }));
    });
    // if(stripedone == true){

    //     function pay(amount) {
    //         console.log(amount);
    //         var handler = StripeCheckout.configure({
    //             key: 'pk_test_51Pp54dGC4teGxUj2JRnlqxoUfldOau4rwMTc3GAW8LIbdIcIKh4a9frfWsKlPgkwm3Xc15pLpIonzMqNp8outn5s00qgb4gaur', // your publisher key id
    //             locale: 'auto',
    //             token: function (token) {
    //                 // You can access the token ID with `token.id`.
    //                 // Get the token ID to your server-side code for use.
    //                 // console.log('Token Created!!');
    //                 // console.log(token)
    //                 $('#token_response').html(JSON.stringify(token));

    //                 $.ajax({
    //                     url: "stripe/payment.php",
    //                     method: 'post',
    //                     data: { tokenId: token.id, amount: amount },
    //                     dataType: "json",
    //                     success: function (response) {
    //                         // var data1 = JSON.parse(response);
    //                         var dat = response.data;
    //                         console.log(dat);
    //                         if(dat.object == 'charge'){
    //                             window.location.href = 'thank_you_1.php?paymentid=' + dat.balance_transaction + '&orderid=' + dat.id + '&amount=' + dat.amount + '';
    //                         }else{
    //                             alert('Payment Failed');
    //                         }
    //                     }
    //                 })
    //             }
    //         });

    //         handler.open({
    //             name: 'Fruitables',
    //             description: 'Fruits and Vegetables',
    //             amount: amount * 100
    //         });
    //     }
    // }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
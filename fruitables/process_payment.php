<?php 

session_start();
require('./php/conn.php');

$query2 = "SELECT * FROM `order_tbl` order by order_id desc limit 1";
$a2 = mysqli_query($conn, $query2);
$b2 = mysqli_num_rows($a2);

while ($row2 = mysqli_fetch_assoc($a2)) {
    $z = $row2['order_id'];
    $c_id = $z;
}

if ($c_id == NULL) {
    $order_id = "1001";
} else {
    $order_id = ($c_id + 1);
}
$customer_id = $_SESSION['customer_id'];
$paymentID = $_POST['paymentID'];
$amount = $_POST['amount'];
$currency = $_POST['currency'];

// Validate input data
if (!empty($order_id) && !empty($customer_id) && !empty($paymentID) && !empty($amount) && !empty($currency)) {

    // Prepare and bind the SQL statement
    $sql1 = "INSERT INTO payments (order_id, payer_id, payment_id, amount, currency, status) VALUES ('$order_id', '$customer_id', '$paymentID', '$amount', '$currency', 'Success')";
    mysqli_query($conn, $sql1);
    // Execute the query
    $cart_item = $_SESSION['cart_item'];

    $prod_names = array_column($cart_item, 'prod_name');
    $prod_quantites = array_column($cart_item, 'prod_quantity');
    $prod_prices = array_column($cart_item, 'prod_price');

    $prod_names_string = implode(', ', $prod_names);
    $prod_quantity_string = implode(', ', $prod_quantites);
    $prod_price_string = implode(', ', $prod_prices);


    $sql = "INSERT INTO order_tbl (order_id,prod_name, customer_id, prod_quantity, prod_price, payment_mode)VALUES ('$order_id','$prod_names_string', '$customer_id', '$prod_quantity_string', '$prod_price_string', 'PayPal')";

    if (mysqli_query($conn, $sql)) {
        unset($_SESSION['cart_item']);
        echo json_encode(['success' => true, 'message' => $paymentID]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to record payment.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}




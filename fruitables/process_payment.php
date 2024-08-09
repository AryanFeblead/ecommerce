<?php 

require('./php/conn.php');

$orderID = $_POST['orderID'];
$payerID = $_POST['payerID'];
$paymentID = $_POST['paymentID'];
$amount = $_POST['amount'];
$currency = $_POST['currency'];

// Validate input data
if (!empty($orderID) && !empty($payerID) && !empty($paymentID) && !empty($amount) && !empty($currency)) {

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO payments (order_id, payer_id, payment_id, amount, currency) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $orderID, $payerID, $paymentID, $amount, $currency);

    // Execute the query
    if ($stmt->execute()) {
        // Return success response
        echo json_encode(['success' => true, 'message' => 'Payment recorded successfully.']);
    } else {
        // Return failure response
        echo json_encode(['success' => false, 'message' => 'Failed to record payment.']);
    }

    // Close the statement
    $stmt->close();
} else {
    // Return validation failure response
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}

// Close the connection
$conn->close();


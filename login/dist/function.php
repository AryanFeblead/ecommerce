<?php

require ('conn.php');
function login_user() {
    global $conn;

    // Check if form submitted with method="post"
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve username (email) and password from POST data
        $useremail = $_POST["emp_email"];
        $password = $_POST["emp_password"];

        // Sanitize inputs to prevent SQL injection (optional but recommended)
        $useremail = mysqli_real_escape_string($conn, $useremail);
        $password = mysqli_real_escape_string($conn, $password);

        // Query to retrieve user information based on email
        $sql = "SELECT * FROM customer_tbl WHERE customer_email='$useremail'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                if ($password == $row['customer_password']) {
                    session_start();
                    $_SESSION['customer_id'] = $row['customer_id'];
                    echo json_encode(["status" => "success", "message" => "User login successfully"]);
                } else {
                    
                    echo json_encode(["status" => "emp_pass_error", "message" => "Invalid password"]);
                }
            } else {
              
                echo json_encode(["status" => "emp_error", "message" => "User not found"]);
            }
        } else {
       
            echo json_encode(["status" => "emp_db_error", "message" => "Database error"]);
        }
    }
}
login_user();
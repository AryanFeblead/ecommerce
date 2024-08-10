<?php

require('conn.php');


function view_data()
{
    global $conn;
    $search = $_POST['search'];
    $select = mysqli_query($conn, "SELECT * FROM prod_tbl WHERE prod_name LIKE '%$search%'");
    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
    }

    echo json_encode($users);
}
function fruit_data()
{
    global $conn;
    $select = mysqli_query($conn, "SELECT * FROM prod_tbl WHERE prod_category='fruit'");
    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
    }

    echo json_encode($users);
}
function vegetable_data()
{
    global $conn;
    $select = mysqli_query($conn, "SELECT * FROM prod_tbl WHERE prod_category='vegetable'");
    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
    }

    echo json_encode($users);
}

function searchbar_data()
{
    global $conn;
    $searchprice = $_POST['searchprice'];
    $select = mysqli_query($conn, "SELECT * FROM prod_tbl WHERE prod_price <= $searchprice");
    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
    }

    echo json_encode($users);
}

function lowtohigh_data()
{
    global $conn;

    $searchprice = mysqli_real_escape_string($conn, $_POST['searchprice1']);
    $search = mysqli_real_escape_string($conn, $_POST['search']);


    $queryParts = [];

    if (!empty($search)) {
        $queryParts[] = "prod_name LIKE '%$search%'";
    }

    if (!empty($searchprice)) {
        $queryParts[] = "prod_price <= $searchprice";
    }

    $queryCondition = implode(' AND ', $queryParts);


    if (empty($queryCondition)) {
        $queryCondition = '1';
    }

    $query = "SELECT * FROM prod_tbl WHERE $queryCondition ORDER BY prod_price ASC";

    $select = mysqli_query($conn, $query);

    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
    }

    echo json_encode($users);
}

function hightolow_data()
{
    global $conn;

    $searchprice = mysqli_real_escape_string($conn, $_POST['searchprice1']);
    $search = mysqli_real_escape_string($conn, $_POST['search']);


    $queryParts = [];

    if (!empty($search)) {
        $queryParts[] = "prod_name LIKE '%$search%'";
    }

    if (!empty($searchprice)) {
        $queryParts[] = "prod_price <= $searchprice";
    }

    $queryCondition = implode(' AND ', $queryParts);


    if (empty($queryCondition)) {
        $queryCondition = '1';
    }

    $query = "SELECT * FROM prod_tbl WHERE $queryCondition ORDER BY prod_price DESC";

    $select = mysqli_query($conn, $query);

    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
    }

    echo json_encode($users);
}

function atoz_data()
{
    global $conn;

    $searchprice = mysqli_real_escape_string($conn, $_POST['searchprice1']);
    $search = mysqli_real_escape_string($conn, $_POST['search']);


    $queryParts = [];

    if (!empty($search)) {
        $queryParts[] = "prod_name LIKE '%$search%'";
    }

    if (!empty($searchprice)) {
        $queryParts[] = "prod_price <= $searchprice";
    }

    $queryCondition = implode(' AND ', $queryParts);


    if (empty($queryCondition)) {
        $queryCondition = '1';
    }

    $query = "SELECT * FROM prod_tbl WHERE $queryCondition ORDER BY prod_name ASC";

    $select = mysqli_query($conn, $query);

    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
    }

    echo json_encode($users);
}

function ztoa_data()
{
    global $conn;

    $searchprice = mysqli_real_escape_string($conn, $_POST['searchprice1']);
    $search = mysqli_real_escape_string($conn, $_POST['search']);


    $queryParts = [];

    if (!empty($search)) {
        $queryParts[] = "prod_name LIKE '%$search%'";
    }

    if (!empty($searchprice)) {
        $queryParts[] = "prod_price <= $searchprice";
    }

    $queryCondition = implode(' AND ', $queryParts);


    if (empty($queryCondition)) {
        $queryCondition = '1';
    }

    $query = "SELECT * FROM prod_tbl WHERE $queryCondition ORDER BY prod_name DESC";

    $select = mysqli_query($conn, $query);

    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
    }

    echo json_encode($users);
}

function add_cart_data()
{
    global $conn;
    session_start();

    // Sanitize input
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Fetch product details from the database
    $select = mysqli_query($conn, "SELECT * FROM prod_tbl WHERE prod_id='$id'");

    if (!$select) {
        // Query error
        echo json_encode(['status' => 'error', 'message' => 'Query error']);
        return;
    }

    $product = mysqli_fetch_assoc($select);

    if (!$product) {
        // Product not found
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        return;
    }

    $prod_id = $product['prod_id'];
    $prod_name = $product['prod_name'];
    $prod_price = $product['prod_price'];
    $prod_img = $product['prod_img'];

    // Initialize the cart session if not already set
    if (empty($_SESSION['cart_item'])) {
        $_SESSION['cart_item'] = array(
            $prod_id => array(
                'prod_id' => $prod_id,
                'prod_name' => $prod_name,
                'prod_img' => $prod_img,
                'prod_price' => $prod_price,
                'prod_quantity' => 1,
                'prod_total' => $prod_price
            )
        );
        echo json_encode(["status" => "success", "message" => "Item added to cart"]);
    } else {
        // Check if item already exists in cart
        if (array_key_exists($prod_id, $_SESSION['cart_item'])) {
            // Item exists, update the quantity
            $_SESSION['cart_item'][$prod_id]['prod_quantity'] += 1;
            echo json_encode(["status" => "success", "message" => "Item quantity updated"]);
        } else {
            // Item is not in the cart, add it
            $_SESSION['cart_item'][$prod_id] = array(
                'prod_id' => $prod_id,
                'prod_name' => $prod_name,
                'prod_img' => $prod_img,
                'prod_price' => $prod_price,
                'prod_quantity' => 1,
                'prod_total' => $prod_price
            );
            echo json_encode(["status" => "success", "message" => "Item added to cart"]);
        }
    }
}


function add_cart_delete()
{
    global $conn;
    session_start();

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    if (isset($_SESSION['cart_item'][$id])) {
        unset($_SESSION['cart_item'][$id]);

        echo json_encode(["status" => "success", "message" => "Item removed from cart"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Item not found in cart"]);
    }
}

function update_cart_quantity()
{
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $itemId = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

        if ($itemId > 0 && $quantity > 0) {
            if (isset($_SESSION['cart_item'][$itemId])) {
                $_SESSION['cart_item'][$itemId]['prod_quantity'] = $quantity;
                $_SESSION['cart_item'][$itemId]['prod_total'] = $_SESSION['cart_item'][$itemId]['prod_price'] * $quantity;
                echo json_encode($_SESSION['cart_item']);
            } else {
                // Item not found
                echo json_encode(['status' => 'error', 'message' => 'Item not found']);
            }
        } else {
            // Invalid data
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        }
    } else {
        // Invalid request method
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
}

function all_search()
{
    global $conn;

    $search = mysqli_real_escape_string($conn, $_POST['search07']);

    $query = "SELECT * FROM prod_tbl WHERE prod_name LIKE '%$search%' ORDER BY prod_name ASC";

    $select = mysqli_query($conn, $query);

    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
        echo json_encode($users);
        echo json_encode(["status" => "success", "message" => "Product Search successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No products found"]);
    }
}
function checkout()
{
    session_start();
    global $conn;
    $customer_id = $_SESSION['customer_id'];
    $cart_item = $_SESSION['cart_item'];

    $prod_names = array_column($cart_item, 'prod_name');
    $prod_quantites = array_column($cart_item, 'prod_quantity');
    $prod_prices = array_column($cart_item, 'prod_price');

    $prod_names_string = implode(', ', $prod_names);
    $prod_quantity_string = implode(', ', $prod_quantites);
    $prod_price_string = implode(', ', $prod_prices);


    $totalAmount = 0;

    // Calculate total amount
    foreach ($_SESSION['cart_item'] as $item) {
        $itemTotal = $item['prod_price'] * $item['prod_quantity'];
        $totalAmount += $itemTotal;
    }

    $formattedTotal = number_format($totalAmount, 2);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    $sql = "INSERT INTO order_tbl (order_id,prod_name, customer_id, prod_quantity, prod_price, payment_mode) 
    VALUES ('$order_id','$prod_names_string', '$customer_id', '$prod_quantity_string', '$prod_price_string', 'COD')";

    mysqli_query($conn, $sql);

        // Get form data
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $postcode = $_POST['postcode'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];

        $sql1 = "INSERT INTO bill_tbl (fname, lname, address, city, country, postcode, mobile, email, order_id, subtotal, customer_id) 
                VALUES ( '$fname', '$lname', '$address', '$city', '$country', '$postcode', '$mobile', '$email', '$order_id', '$totalAmount', '$customer_id')";

        if (mysqli_query($conn, $sql1)) {
            unset($_SESSION['cart_item']);
            echo json_encode(["status" => "success", "message" => "User added successfully"]);
        } else {
            echo json_encode(["status" => "error"]);
        }
    }
}

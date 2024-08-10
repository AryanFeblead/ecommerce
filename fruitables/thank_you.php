<?php 
    session_start();
    require('./php/conn.php');
    $paymentID = $_GET['paymentid'];
    function getCurrentDate(){
        $timestamp = time();  
        $date = date("Y-m-d", $timestamp);
        return $date;
    }
    function getCurrentTime(){
        date_default_timezone_set("Asia/Kolkata"); 
        $time = date("H:i:s");
        return $time;
    }


    if(isset($_SESSION['customer_id'])){ 
        $customer_id =$_SESSION['customer_id'];
        // Check if transaction data exists with the same TXN ID. 
        $sql_c = "SELECT * FROM `payments` WHERE `payment_id` = '$paymentID'"; 
        $data_c = mysqli_query($conn,$sql_c) or die('MySQL Error (Paypal Success2)'.mysqli_error($con));

        if(true){
            while ($row = mysqli_fetch_assoc($data_c)) {
                $order_id = $row['order_id'];
                $amount = $row['amount'];
            }
        }

        //Get tansaction data from database
        $sql_tr2 = "SELECT * FROM `customer_tbl` WHERE `customer_id`='$customer_id'";
        $data_tr2 = mysqli_query($conn,$sql_tr2) or die('MySQL Error (Paypal Success1'.mysqli_error($con));
        while ($row = mysqli_fetch_assoc($data_tr2)) {
            $user_name = $row['customer_name'];
        }
    }else{
        echo "<script>alert('Session not set')</script>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Paypal Payment Gateway Integration in PHP </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="./css/paypal.css">
    </head>

    <div class="container">

        <?php if(!empty($paymentID)){ ?>
            <h2 style="text-align: center; color: blue;">Thank You !!</h2>
            <h3 style="text-align: center; color: green;">Your Payment has been Successful. </h3>
        <?php } else { ?>
            <h2 style="text-align: center; color: blue;">Sorry !!</h2>
        <?php } ?>

        <br>
        <div class="row">

            <div class="col-lg-12">
                <div class="status">
                    <?php if(!empty($paymentID)){ ?>
                        <h4 class="heading">Payment Information - </h4>
                        <br>
                        <p><b>Order ID : </b> <strong><?php echo $order_id; ?></strong></p>
                        <p><b>Transaction ID : </b> <?php echo $paymentID; ?></p>
                        <p><b>Paid Amount  : </b> <?php echo $amount;?></p>
                        <p><b>Currency : </b> USD </p>
                        <p><b>Payment Status : </b> Success </p>

                        <h4 class="heading">Product Information - </h4>
                        <br>
                        <p><b>Name : </b> <?php echo $user_name; ?></p>

                        <h4 class="heading">Date & Time</h4>
                        <p><b>Pay Date : </b> <?php echo getCurrentDate(); ?></p>
                        <p><b>Pay Time : </b> <?php echo getCurrentTime(); ?></p>

                    <?php } else { ?>

                        <h1 class="error">Sorry !! Your Payment has Failed.</h1>

                    <?php } ?>
                </div>
            </div>

        </div>

        <h3 style="text-align: center;"><a href="index.php" class="btn-continue">Back to Home</a></h3>

    </div>
</html>



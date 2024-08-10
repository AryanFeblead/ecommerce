<?php

session_start();
$amount = isset($_GET['amount']) ? intval($_GET['amount']) : 0;
define( "STRIPE_SECRET_API_KEY", "sk_test_51Plows02dkkU9uEGOzM8ooBJ0KOHGqo7qxjgcDfbJsvFHvqyNcTAqeRa5DKgq2NCiy9SUBqYF8MhpdwROBIioZNw00cQ7HYFxC" );
define( "STRIPE_PUBLISHABLE_KEY", "pk_test_51Plows02dkkU9uEGj6o1zd2ttuQDLOuzguqIIer9HsbCSD3xeBp2jr0xErKnMVWFddivtFoGvt8HHjJTXTnpDsi800SRepOstE" );

define( 'CURRENCY', 'USD' );
define( 'AMOUNT', '200' );
define( 'DESCRIPTION', 'Fruits and Vegetables' );

?>
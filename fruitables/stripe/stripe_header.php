<?php

require_once 'config.php';


require_once '../vendor/autoload.php';


\Stripe\Stripe::setApiKey( STRIPE_SECRET_API_KEY );


header( 'Content-Type: application/json' );

$jsonStr = file_get_contents( 'php://input' );
$jsonObj = json_decode( $jsonStr );
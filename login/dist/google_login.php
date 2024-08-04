<?php

session_start();

require_once 'vendor/autoload.php'; // Make sure this path is correct

// Initialize Google Client
$google_client = new Google_Client();
$google_client->setClientId('637056954706-a85ik75hqt634uqh64aaiv8qm02v8r30.apps.googleusercontent.com'); // Replace with your Client ID
$google_client->setClientSecret('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'); // Replace with your Client Secret
$google_client->setRedirectUri('http://localhost:8088/fruit/ecommerce/fruitables/'); // Ensure this matches your OAuth 2.0 setup
$google_client->addScope('email');
$google_client->addScope('profile');

// Check if there's an authorization code in the URL
if (isset($_GET['code'])) {
    try {
        // Fetch access token using authorization code
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

        if (!isset($token['error'])) {
            $google_client->setAccessToken($token['access_token']);
            $_SESSION['access_token'] = $token['access_token'];

            // Get user info from Google
            $google_service = new Google_Service_Oauth2($google_client);
            $data = $google_service->userinfo->get();

            // Check if user info is available
            if (!empty($data['given_name'])) {
                $_SESSION['customer_name'] = $data['given_name'];
                $_SESSION['last_name'] = $data['family_name'];
                $_SESSION['email_address'] = $data['email'];
                $_SESSION['profile_picture'] = $data['picture'];
                // Redirect or process the user info as needed
                // header('Location: ../../fruitables/'); // Update to your actual redirect page
                // exit();
            } else {
                echo "Failed to retrieve user information.";
            }
        } else {
            echo "Failed to fetch access token.";
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

?>
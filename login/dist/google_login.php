<?php

session_start();

require_once 'vendor/autoload.php';

// Initialize Google Client
$google_client = new Google_Client();
$google_client->setClientId('621404249359-3si0ntvf50t1oon6nknujt1anmvp636u.apps.googleusercontent.com'); // Replace with your Client ID
$google_client->setClientSecret('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'); // Replace with your Client Secret
$google_client->setRedirectUri('http://localhost/fruit/ecommerce/fruitables/'); // Ensure this matches your OAuth 2.0 setup
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
                echo htmlspecialchars($google_client->createAuthUrl());
                // Redirect or process the user info as needed
                // header('Location: ./ecommerce/fruitables/'); // Update to your actual redirect page
                // exit();
            } else {
                echo "Failed to retrieve user information.";
            }
        } else {
            // Display specific error details
            echo "Failed to fetch access token. Error: " . $token['error'];
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    // If no code, create an authentication URL
    $auth_url = $google_client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit();
}

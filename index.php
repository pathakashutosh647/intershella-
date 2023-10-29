<!DOCTYPE html>
<html>
<head>
    <title>Authentication Form</title>
</head>
<body>
    <h2>Authentication</h2>
    <form method="POST" action="index.php">
        <label for="login_id">Email:</label>
        <input type="email" name="login_id" id="login_id" required><br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        <input type="submit" value="Authenticate">
    </form>
</body>
</html>
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_id = $_POST['login_id'];
    $password = $_POST['password'];

    // Define the API endpoint and request body
    $api_url = 'https://qa2.sunbasedata.com/sunbase/portal/api/assignment_auth.jsp';
    $data = json_encode([
        'login_id' => $login_id,
        'password' => $password
    ]);

    // Set up cURL for the authentication request
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set headers to send and accept JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Accept: application/json'
    ));

    // Execute the request
    $response = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Check for errors and handle the response
    if ($response) {
        $data = json_decode($response, true);

        if (isset($data['access_token'])) {
            $token = $data['access_token'];
            $_SESSION['token']=$token;
            echo "Authentication successful. Bearer token: $token";
        } else {
            echo $response;
            echo "Authentication failed. Please check your credentials.";
        }
    } else {
        echo "Failed to connect to the API.";
    }
}
?>

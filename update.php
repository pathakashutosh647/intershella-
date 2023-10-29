<!DOCTYPE html>
<html>
<head>
    <title>Update Customer</title>
</head>
<body>
    <h2>Update Customer</h2>
    <form method="POST">
        <label for="uuid">Customer UUID:</label>
        <input type="text" name="uuid" id="uuid" required><br><br>
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name"><br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name"><br><br>
        <label for="street">Street:</label>
        <input type="text" name="street" id="street"><br><br>
        <label for="address">Address:</label>
        <input type="text" name="address" id="address"><br><br>
        <label for="city">City:</label>
        <input type="text" name="city" id="city"><br><br>
        <label for="state">State:</label>
        <input type="text" name="state" id="state"><br><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email"><br><br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone"><br><br>
        <input type="submit" value="Update Customer">
    </form>
</body>
</html>
<?php
session_start();
// Ensure you have the Bearer token obtained from the authentication step
$bearer_token = $_SESSION['token'];
echo $bearer_token;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define the API endpoint for updating a customer
    $api_url = 'https://qa2.sunbasedata.com/sunbase/portal/api/assignment.jsp'?cmd=update; 

    // Define the data for updating a customer
    $data = json_encode([
        'cmd' => 'update',
        'uuid' => $_POST['uuid'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'street' => $_POST['street'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone']
    ]);

    // Set up cURL for the API request
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Set the Authorization header with the Bearer token
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $bearer_token,
        'Content-Type: application/json',
        'Accept: application/json'
    ));

    // Execute the request
    $response = curl_exec($ch);

    // Get the HTTP status code
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close cURL session
    curl_close($ch);

    // Check for errors and handle the response
    if ($http_status === 200) {
        echo "Success: 200, Successfully Updated";
    } elseif ($http_status === 500) {
        echo "Failure: 500, UUID not found";
    } elseif ($http_status === 400) {
        echo "Failure: 400, Body is Empty";
    } else {
        echo "An error occurred while updating the customer.";
    }
}
?>

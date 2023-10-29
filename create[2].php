<!DOCTYPE html>
<html>
<head>
    <title>Create Customer</title>
</head>
<body>
    <h2>Create Customer</h2>
    <form method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required><br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required><br><br>
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
        <input type="submit" value="Create Customer">
    </form>
</body>
</html>
<?php
session_start();
// Ensure you have the Bearer token obtained from the authentication step
$bearer_token = $_SESSION['token'];
echo $bearer_token;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define the API endpoint for creating a new customer
    $api_url = 'https://qa2.sunbasedata.com/sunbase/portal/api/assignment.jsp?cmd=create';

    // Define the data for creating a new customer
    $data = json_encode([
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'street' => 'Elvnu Street',
        'address' => 'H no 2',
        'city' => 'Delhi',
        'state' => 'Delhi',
        'email' => 'sam@gmail.com',
        'phone' => '12345678'
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
    if ($http_status === 201) {
        echo "Success: 201, Successfully Created";
    } else {
        echo "Failure: $http_status, ";
        if ($http_status === 400) {
            echo "First Name or Last Name is missing";
        } else {
            echo "An error occurred while creating the customer.";
          }
      }

}
?>

<?php
// Include the database connection
include('db_connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);

    // SQL query to insert the data into the franchise_requests table
    $sql = "INSERT INTO franchise_requests (name, email, contact, location) 
            VALUES ('$name', '$email', '$contact', '$location')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect to WhatsApp with pre-filled message
        $message = "Name: $name%0AEmail: $email%0AContact No.: $contact%0AFranchise Location: $location";
        header("Location: https://wa.me/7039259971?text=" . urlencode($message));
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

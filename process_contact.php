<?php
// Include database connection
include('db_connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // SQL query to insert data into the contact_submissions table
    $sql = "INSERT INTO contact_submissions (name, email, message) 
            VALUES ('$name', '$email', '$message')";

    // Execute the query and check if it was successful
    if (mysqli_query($conn, $sql)) {
        // Redirect to WhatsApp
        echo "<script type='text/javascript'>
                window.location.href = 'https://wa.me/917039259971?text=" . urlencode("Hello, my name is $name. My email is $email. $message") . "';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

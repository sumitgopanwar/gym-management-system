<?php
// career_submit.php
$servername = "localhost"; // Your database host
$username = "root"; // Your database username
$password = "root75"; // Your database password
$dbname = "gym_website"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $certifications = mysqli_real_escape_string($conn, $_POST['certifications']);
    
    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO career_applications (name, email, contact, experience, position, certifications) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $contact, $experience, $position, $certifications);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Application submitted successfully!";
        // Redirect to WhatsApp after successful submission (you can modify this part to stay on the page)
        $message = "New Gym Trainer Application:%0A%0A👤 Name: $name%0A📧 Email: $email%0A📞 Contact: $contact%0A🏋 Position: $position%0A📅 Experience: $experience%0A🎓 Certifications: $certifications";
        header("Location: https://wa.me/7039259971?text=" . urlencode($message));
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

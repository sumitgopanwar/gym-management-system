<?php
// Database credentials
$servername = "localhost"; 
$username = "root"; 
$password = "root75"; 
$dbname = "gym_website"; 

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database Connection Failed: " . $conn->connect_error]));
}

// Check if form was submitted via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (empty($_POST['name']) || empty($_POST['contact']) || empty($_POST['plan']) || empty($_POST['location'])) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit();
    }

    // Get and sanitize form data
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact']);
    $plan = trim($_POST['plan']);
    $location = trim($_POST['location']);
    $questions = !empty($_POST['questions']) ? trim($_POST['questions']) : "No additional questions.";

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO membership_applications (name, contact, plan, location, questions) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $contact, $plan, $location, $questions);

    // Execute and check if successful
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();

        // Prepare WhatsApp message
        $message = "Hello, I would like to join the gym. Here are my details:%0A%0A"
                 . "*Name:* $name%0A"
                 . "*Contact No.:* $contact%0A"
                 . "*Selected Plan:* $plan%0A"
                 . "*Preferred Location:* $location%0A"
                 . "*Questions:* $questions";

        $whatsappURL = "https://wa.me/7039259971?text=" . urlencode($message);

        echo json_encode(["status" => "success", "message" => "Membership submitted successfully!", "whatsappURL" => $whatsappURL]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error inserting data: " . $stmt->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>

<?php
// Database configuration
$host = 'localhost';
$dbname = 'demo';
$username = 'root';
$password = '';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the request is POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve form data
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';

        // Validate form data
        if (!empty($name) && !empty($email) && !empty($message)) {
            // Prepare an insert statement
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':message', $message);

            // Execute the statement
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Form submitted successfully!']);
            } else {
                echo json_encode(['message' => 'Failed to submit form.']);
            }
        } else {
            echo json_encode(['message' => 'Please fill in all fields.']);
        }
    }
} catch (PDOException $e) {
    // Return error message in case of connection or execution failure
    echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
}
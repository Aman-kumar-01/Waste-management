<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "signup_db";

// Database Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Data sanitization
$first_name = htmlspecialchars(strip_tags($_POST['first_name']));
$last_name = htmlspecialchars(strip_tags($_POST['last_name']));
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format!");
}

// Hashing password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Check if email exists
$checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
$checkEmail->bind_param("s", $email);
$checkEmail->execute();
$result = $checkEmail->get_result();
if ($result->num_rows > 0) {
    die("Email already registered!");
}

// Insert data
$sql = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
$sql->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

if ($sql->execute()) {
    echo "Signup Successful!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>

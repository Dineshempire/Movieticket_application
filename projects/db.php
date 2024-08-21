<?php
$email = $_POST['email'];
$password = $_POST['password'];

$conn = new mysqli('localhost', 'root', '', 'connect');



if ($conn->connect_error) {
    die('Connection Failed : ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO login (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss",$email, $password);
    $stmt->execute();
    $stmt->close();
    
    $stmt = $conn->prepare("SELECT * FROM sign WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email and password match in the 'sign' table, login successful
        echo '<script>alert("Login successful"); window.location.href = "index.html";</script>';
    } else {
        // Email or password does not match in the 'sign' table
        echo '<script>alert("Incorrect email or password. Please try again or sign up."); window.location.href = "log.html";</script>';
    }

    $stmt->close();
    $conn->close();
}
?>

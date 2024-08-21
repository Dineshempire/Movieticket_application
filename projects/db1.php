<?php
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

$conn = new mysqli('localhost', 'root', '', 'connect');

if ($conn->connect_error) {
    die('Connection Failed : ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO sign (name, email, password,confirmPassword) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss",$name, $email, $password, $confirmPassword);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    echo '<script>alert("signed successful"); window.location.href = "index.html";</script>';
}
?>

<?php
$cardNumber = $_POST['cardNumber'];
$expiryDate = $_POST['expiryDate'];
$cvv = $_POST['cvv'];
$conn = new mysqli('localhost', 'root', '', 'connect');

if ($conn->connect_error) {
    die('Connection Failed : ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO pay (cardNumber, expiryDate, cvv) VALUES (?, ?, ?)");
    $stmt->bind_param("iii",$cardNumber, $expiryDate, $cvv);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    echo '<script>alert("Payment successful"); window.location.href = "index.html";</script>';
}
?>

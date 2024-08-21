<?php
// db2.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieTime = $_POST['movieTime'];
    $movieTheatre = $_POST['movieTheatre'];
    $selectedSeats = json_decode($_POST['selectedSeats']);

    // Perform database insertion here
    $conn = new mysqli('localhost', 'root', '', 'connect');

    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    } else {
        $success = true;

        // Use a single prepared statement for better performance
        $stmt = $conn->prepare("INSERT INTO bookings (movieTime, movieTheatre, seat) VALUES (?, ?, ?)");

        if (!$stmt) {
            $success = false;
            echo json_encode(array('success' => $success, 'error' => $conn->error));
        } else {
            // Bind parameters
            $stmt->bind_param("sss", $movieTime, $movieTheatre, $seat);

            // Loop through each selected seat and execute the statement
            foreach ($selectedSeats as $seat) {
                $stmt->execute();

                if ($stmt->affected_rows <= 0) {
                    $success = false;
                    echo json_encode(array('success' => $success, 'error' => $stmt->error));
                    break;
                }
            }

            $stmt->close();
        }

        $conn->close();

        // Respond to the client
        echo json_encode(array('success' => $success));
    }
} else {
    // If the request method is not POST, handle accordingly
    echo json_encode(array('success' => false, 'error' => 'Invalid request method.'));
}

?>

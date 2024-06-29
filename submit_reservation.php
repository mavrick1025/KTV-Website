<?php
session_start();
require_once 'db.php';

if (isset($_POST['date']) && isset($_POST['time'])) {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $username = $_SESSION['username'];

    // Fetch the user_id based on the username
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $userId = $user['id'];

    // Check if the time slot is already taken
    $stmt = $conn->prepare("SELECT * FROM events WHERE event_date = ? AND time_slot = ?");
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'This time slot is not available.']);
    } else {
        // Insert the reservation into the database
        $stmt = $conn->prepare("INSERT INTO events (event_date, time_slot, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $date, $time, $userId);
        $stmt->execute();
        echo json_encode(['status' => 'success', 'message' => 'Reservation submitted successfully!']);
    }
}
?>
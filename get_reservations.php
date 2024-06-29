<?php
require_once 'db.php';

$date = isset($_GET['date']) ? $_GET['date'] : null;

if ($date) {
    $sql = "SELECT time_slot FROM events WHERE event_date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();

    $reservations = [];
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
    echo json_encode($reservations);
}
?>
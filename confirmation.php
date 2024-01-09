<?php

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['start_date']) && isset($_GET['end_date']) && isset($_GET['room_type']) && isset($_GET['guest_name'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $room_type = $_GET['room_type'];
    $guest_name = $_GET['guest_name'];

    $stmt = $pdo->prepare("INSERT INTO bookings (start_date, end_date, room_type, guest_name) VALUES (?, ?, ?, ?)");
    $stmt->execute([$start_date, $end_date, $room_type, $guest_name]);

    echo "<h1>Booking Confirmed</h1>";
    echo "<p>Thank you for your booking, $guest_name!</p>";
    echo "<p>Details:</p>";
    echo "<ul>";
    echo "<li>Start Date: $start_date</li>";
    echo "<li>End Date: $end_date</li>";
    echo "<li>Room Type: $room_type</li>";
    echo "<li>Guest Name: $guest_name</li>";
    echo "</ul>";
} else {
    header("Location: index.php");
    exit();
}
?>

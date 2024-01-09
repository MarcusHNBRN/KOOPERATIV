<?php

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];


    $available_room_types = getAvailableRoomTypes($pdo, $start_date, $end_date);


    if (!empty($available_room_types)) {

        header("Location: room_selection.php?start_date=$start_date&end_date=$end_date");
        exit();
    } else {

        echo "<p>Sorry, the selected dates are not available. Please choose different dates or room types.</p>";
    }
}


function getAvailableRoomTypes($pdo, $start_date, $end_date) {
    $available_room_types = [];

    foreach (['basic', 'standard', 'luxury'] as $room_type) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE room_type = ? AND NOT ((end_date < ?) OR (start_date > ?))");
        $stmt->execute([$room_type, $start_date, $end_date]);
        $count = $stmt->fetchColumn();


        $total_rooms = 1;

        if ($count < $total_rooms) {

            $available_room_types[] = $room_type;
        }
    }

    return $available_room_types;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - Step 1</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <ul>
        <li>Home</li>
        <li>About</li>
        <li>Gallery</li>
        <li>Contact us</li>
    </ul>
    <form action="index.php" method="post">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>
        <input type="submit" value="Next">
    </form>
</body>
</html>

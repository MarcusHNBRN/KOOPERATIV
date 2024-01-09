<?php


include 'db.php';


$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $room_type = $_POST['room_type'];
    $guest_name = $_POST['guest_name'];


    if (isRoomAvailable($pdo, $start_date, $end_date, $room_type)) {



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

        echo "<p>Sorry, the selected room type is not available for the specified dates.</p>";
    }

    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - Step 2</title>
</head>
<body>
    <h1>Booking - Step 2</h1>
    <form action="room_selection.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" method="post">
        <label for="room_type">Select Room Type:</label>
        <select id="room_type" name="room_type" required>
    <?php foreach (['basic', 'standard', 'luxury'] as $type): ?>
        <?php $disabled = isRoomAvailable($pdo, $start_date, $end_date, $type) ? '' : 'disabled'; ?>
        <option value="<?php echo $type; ?>" <?php echo $disabled; ?>><?php echo ucfirst($type); ?></option>
    <?php endforeach; ?>
</select>

        <br>

        <label for="guest_name">Your Name:</label>
        <input type="text" id="guest_name" name="guest_name" required>
        <br>
        <input type="submit" value="Next">
    </form>
</body>
</html>

<?php

function isRoomAvailable($pdo, $start_date, $end_date, $room_type) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE room_type = ? AND NOT ((end_date < ?) OR (start_date > ?))");
    $stmt->execute([$room_type, $start_date, $end_date]);
    $count = $stmt->fetchColumn();

    $total_rooms = 1;

    return $count < $total_rooms;
}
?>

?>

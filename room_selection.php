<?php
include 'db.php';

$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $room_type = $_POST['room_type'];
    $guest_name = $_POST['guest_name'];

    $availability = isRoomAvailable($pdo, $start_date, $end_date, $room_type);

    if ($availability['available']) {
        $total_cost = calculateTotalCost($start_date, $end_date, $room_type);

        $stmt = $pdo->prepare("INSERT INTO bookings (start_date, end_date, room_type, guest_name) VALUES (?, ?, ?, ?)");
        $stmt->execute([$start_date, $end_date, $room_type, $guest_name]);

        header("Location: confirmation.php?start_date=$start_date&end_date=$end_date&room_type=$room_type&guest_name=$guest_name");
        exit();
    } else {
        $errorMessage = "Sorry, the selected dates for the $room_type room are not available. Please choose different dates or room types.";
    }
}

function isRoomAvailable($pdo, $start_date, $end_date, $room_type) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE room_type = ? AND NOT ((end_date < ?) OR (start_date > ?))");
    $stmt->execute([$room_type, $start_date, $end_date]);
    $count = $stmt->fetchColumn();

    $total_rooms = 1;

    return [
        'available' => $count < $total_rooms,
        'count' => $count,
    ];
}

function calculateTotalCost($start_date, $end_date, $room_type) {
    $daily_costs = [
        'basic' => 50,
        'premium' => 100,
        'luxury' => 200,
    ];

    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);
    $days = floor(($end_timestamp - $start_timestamp) / (60 * 60 * 24)) + 1;

    $daily_cost = $daily_costs[$room_type];
    $total_cost = $daily_cost * $days;

    return $total_cost;
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
    <div class="head">
        <h1>SELECT YOUR PREFERRED ROOM</h1>
    </div>
    <div class="room-selection">
        <form action="room_selection.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" method="post">
            <label>Select a Room:</label>
            <select name="room_type" onchange="showRoomInfo(this)">
                <option value="basic">Basic</option>
                <option value="premium">Premium</option>
                <option value="luxury">Luxury</option>
            </select>

            <div id="room-info-basic" class="room-info" style="display: none;">
                <h2>Basic Room</h2>
                <img class="roomimg" src="./images/image 3.png" />
                <p>
                    Discover comfort and simplicity in our Basic Room – an ideal
                    choice for budget-conscious travelers looking for a cozy and
                    convenient stay. Our Basic Room provides the essentials for a
                    comfortable night's rest and a relaxing stay during your visit to
                    our beautiful island.
                </p>
            </div>

            <div id="room-info-premium" class="room-info" style="display: none;">
                <h2>Premium Room</h2>
                <img class="roomimg" src="./images/image 3.png" />
                <p>
                    Elevate your island getaway experience with our luxurious Premium
                    Room. Perfectly suited for discerning travelers seeking the
                    ultimate in comfort, style, and relaxation, our Premium Room
                    offers an exceptional stay that exceeds your expectations.
                </p>
            </div>

            <div id="room-info-luxury" class="room-info" style="display: none;">
                <h2>Luxury Suite</h2>
                <img class="roomimg" src="./images/image 3.png"/>
                <p>
                    Experience the pinnacle of opulence and extravagance with our
                    exquisite Luxury Suite. Designed for those who demand nothing but
                    the best, our Luxury Suite offers an unrivaled level of comfort,
                    sophistication, and indulgence, making it the ultimate choice for
                    a truly unforgettable island retreat.
                </p>
            </div>


            <div id="name-input" style="display: none;">
                <label for="guest_name">Your Name:</label>
                <input type="text" id="guest_name" name="guest_name" required>
                <button class="book" type="submit">Book</button>
            </div>
        </form>
    </div>

    <script>
        function showRoomInfo(select) {

            const roomInfos = document.querySelectorAll('.room-info');
            roomInfos.forEach((roomInfo) => {
                roomInfo.style.display = 'none';
            });


            const selectedRoom = select.value;
            const selectedRoomInfo = document.getElementById(`room-info-${selectedRoom}`);
            selectedRoomInfo.style.display = 'block';


            const nameInput = document.getElementById('name-input');
            nameInput.style.display = 'block';
        }
    </script>
</body>
</html>


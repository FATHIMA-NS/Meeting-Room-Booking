<?php
require 'db.php';

// Fetch all rooms
$stmt = $pdo->query('SELECT * FROM rooms');
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meeting Room Booking</title>
</head>
<body>
    <h1>Meeting Rooms</h1>
    <ul>
        <?php foreach ($rooms as $room): ?>
            <li>
                <strong><?php echo htmlspecialchars($room['name']); ?></strong> - Amenities: <?php echo htmlspecialchars($room['amenities']); ?>
                <a href="book_room.php?room_id=<?php echo $room['id']; ?>">Book Room</a>
                <a href="check_availability.php?room_id=<?php echo $room['id']; ?>">Check Availability</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

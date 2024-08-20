<?php
require 'db.php';

$room_id = $_GET['room_id'];

// Fetch room details and bookings
$stmt = $pdo->prepare('SELECT * FROM rooms WHERE id = ?');
$stmt->execute([$room_id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM bookings WHERE room_id = ? ORDER BY start_time');
$stmt->execute([$room_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Room Availability - <?php echo htmlspecialchars($room['name']); ?></title>
</head>
<body>
    <h1>Room Availability for <?php echo htmlspecialchars($room['name']); ?></h1>
    <ul>
        <?php if ($bookings): ?>
            <?php foreach ($bookings as $booking): ?>
                <li>Booked from <?php echo $booking['start_time']; ?> to <?php echo $booking['end_time']; ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No bookings yet</li>
        <?php endif; ?>
    </ul>
    <a href="index.php">Back to Rooms</a>
</body>
</html>

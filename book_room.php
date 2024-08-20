<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Check for conflicting bookings
    $stmt = $pdo->prepare('SELECT * FROM bookings WHERE room_id = ? AND start_time < ? AND end_time > ?');
    $stmt->execute([$room_id, $end_time, $start_time]);
    $conflicting_booking = $stmt->fetch();

    if ($conflicting_booking) {
        echo "Room is already booked for this time frame.";
    } else {
        // Book the room
        $stmt = $pdo->prepare('INSERT INTO bookings (room_id, start_time, end_time) VALUES (?, ?, ?)');
        $stmt->execute([$room_id, $start_time, $end_time]);
        echo "Room booked successfully.";
    }
} else {
    $room_id = $_GET['room_id'];

    // Fetch room details
    $stmt = $pdo->prepare('SELECT * FROM rooms WHERE id = ?');
    $stmt->execute([$room_id]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Room - <?php echo htmlspecialchars($room['name']); ?></title>
</head>
<body>
    <h1>Book <?php echo htmlspecialchars($room['name']); ?></h1>
    <form method="post">
        <input type="hidden" name="room_id" value="<?php echo $room['id']; ?>">
        <label for="start_time">Start Time:</label>
        <input type="datetime-local" id="start_time" name="start_time" required><br>
        <label for="end_time">End Time:</label>
        <input type="datetime-local" id="end_time" name="end_time" required><br>
        <button type="submit">Book Room</button>
    </form>
    <a href="index.php">Back to Rooms</a>
</body>
</html>

<?php
require_once('../../config.php');
require_once('../../db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch events from the database
$events = [];
$query = "SELECT * FROM events"; // Adjust the table name as necessary
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
} else {
    error_log("Database query failed: " . mysqli_error($conn));
}
?>
<html>
<head>
    <title>My Events</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/events.css">
</head>
<body>
    <div class="event-container">
        <div class="event-container-in">
            <div class="event-container-in-heading">
                <h1>My Events</h1>
            </div>
            <div class="event-container-main">
                <div class="event-container-boxes">
                    <?php foreach ($events as $event): ?>
                    <div class="event-box">
                        <div class="event-img">
                            <img src="<?php echo htmlspecialchars($event['image_url']); ?>" alt="Event Image">
                        </div>
                        <div class="event-heading">
                            <h1><?php echo htmlspecialchars($event['name']); ?></h1>
                        </div>
                        <div class="event-options">
                            <a href="event_details.php?id=<?php echo $event['id']; ?>">
                                <button>View Details</button>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="./assets/css/eventDetail.css">
</head>
<body>
<?php include './header.php'; ?>
<?php
include './operations/db_connection.php';
$eventId = isset($_GET['eventId']) ? intval($_GET['eventId']) : 0;

// Query to fetch event details based on eventId
$sql = "SELECT * FROM event WHERE id = $eventId";
$result = $conn->query($sql);
if (!$result) {
    // If query fails, display an error message
    die("Error in query: " . $conn->error);
}
if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
} else {
    echo "<p>Event not found.</p>";
    exit; // Stop execution if no event is found
}

$conn->close();
?>
    <header>
        <h1>Event Details</h1>
    </header>
    <main class="event-container">
        <section class="event-info">
            <h2>Event Name: <span id="event-name"><?php echo htmlspecialchars($event['name']); ?></span></h2>
            <?php if (!empty($event['short_description'])): ?>
                <p class="short-description">
                    <strong>Short Description:</strong> 
                    <?php echo htmlspecialchars($event['short_description']); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($event['long_description'])): ?>
                <p class="long-description">
                    <strong>Long Description:</strong>
                    <?php echo htmlspecialchars($event['long_description']); ?>
                </p>
            <?php endif; ?>

            <div class="details">
                <?php if (!empty($event['eligibility'])): ?>
                    <p><strong>Eligibility:</strong> <?php echo htmlspecialchars($event['eligibility']); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['type'])): ?>
                    <p><strong>Type:</strong> <?php echo htmlspecialchars($event['type']); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['start_date']) && !empty($event['end_date'])): ?>
                    <p><strong>Dates:</strong> <?php echo date("d-m-Y", strtotime($event['start_date'])) . " to " . date("d-m-Y", strtotime($event['end_date'])); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['location'])): ?>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['coordinator'])): ?>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($event['coordinator']); ?> | <?php echo htmlspecialchars($event['coordinator_number']); ?> | <?php echo htmlspecialchars($event['coordinator_emailid']); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['prize'])): ?>
                    <p><strong>Prizes:</strong> <?php echo htmlspecialchars($event['prize']); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['deadline_date'])): ?>
                    <p><strong>Registration Deadline:</strong> <?php echo date("d-m-Y", strtotime($event['deadline_date'])); ?></p>
                <?php endif; ?>

                <?php if (!empty($event['website'])): ?>
                    <p><strong>Official Website:</strong> <a href="<?php echo htmlspecialchars($event['website']); ?>" target="_blank"><?php echo htmlspecialchars($event['website']); ?></a></p>
                <?php endif; ?>
            </div>
        </section>
        <section class="action-buttons">
            <button class="register-button" onclick="submitRegistration(<?php echo $event['id']; ?>)">Register Now</button>
            <button class="back-button" onclick="goBack()">Back to Events</button>
        </section>
    </main>
    <script>
    // Ensure this script runs after the DOM is fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        function submitRegistration(eventId) {
            // Get participant_id from session (this will be handled in PHP)
            let participantId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;

            if (participantId === null) {
                alert('You must be logged in to register.');
                return;
            }

            // Send a request to register the user for this event
            window.location.href = `operations/register-event.php?eventId=${eventId}&participantId=${participantId}`;
        }

        function goBack() {
            window.history.back();
        }

        // Assign functions to buttons
        const registerButton = document.querySelector('.register-button');
        if (registerButton) {
            registerButton.addEventListener('click', function() {
                let eventId = <?php echo $event['id']; ?>;
                submitRegistration(eventId);
            });
        }
    });
</script>

</body>
</html>

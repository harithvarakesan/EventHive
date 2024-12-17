
<?php include './header.php'; ?>
<?php
include './operations/db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit;
}

$userId = $_SESSION['user_id'];

// SQL query to fetch registered events with their scores
$sql = "
    SELECT e.name AS event_name, p.mark
    FROM participant p
    JOIN event e ON p.event_id = e.id
    WHERE p.participant_id = ?";
$stmt = $conn->prepare($sql);

// Check if prepare() returns false
if ($stmt === false) {
    die("Error preparing the SQL query: " . $conn->error);
}

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the events and their marks
$registeredEvents = [];
while ($row = $result->fetch_assoc()) {
    $registeredEvents[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <link rel="stylesheet" href="./assets/css/registrations.css">
</head>
<body>

<header>
    <h1>Event Registration Page</h1>
</header>

<main class="registration-container">
    <!-- Filter Section -->
    <section class="event-filter">
        <h2>Filter Events</h2>
        <label for="event-search">Search by Event Name:</label>
        <input type="text" id="event-search" placeholder="Enter event name" oninput="filterEvents()">
    </section>

    <!-- Previously Registered Events Section -->
    <section class="previous-registrations">
        <h2>Your Previously Registered Events</h2>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody id="registered-events">
                <?php
                    foreach ($registeredEvents as $event) {
                        $score = '';
                        if ($event['mark'] == -1) {
                            $score = 'Absent';
                        } elseif ($event['mark'] == 0) {
                            $score = 'Not yet attended';
                        } else {
                            $score = $event['mark'];
                        }
                        echo "<tr>
                                <td>" . htmlspecialchars($event['event_name']) . "</td>
                                <td>" . htmlspecialchars($score) . "</td>
                              </tr>";
                    }
                ?>
            </tbody>
        </table>
    </section>
</main>

<script>
    // Sample events data for search filter
    const allEvents = <?php echo json_encode($registeredEvents); ?>;

    // Function to filter events based on search input
    function filterEvents() {
        const searchQuery = document.getElementById('event-search').value.toLowerCase();
        const filteredEvents = allEvents.filter(event => 
            event.event_name.toLowerCase().includes(searchQuery)
        );
        
        displayRegisteredEvents(filteredEvents);
    }

    // Function to dynamically display events
    function displayRegisteredEvents(events) {
        const eventTableBody = document.getElementById('registered-events');
        eventTableBody.innerHTML = ''; // Clear the current content

        events.forEach(event => {
            const row = document.createElement('tr');
            let score = '';
            if (event.mark == -1) {
                score = 'Absent';
            } else if (event.mark == 0) {
                score = 'Not yet attended';
            } else {
                score = event.mark;
            }
            row.innerHTML = `<td>${event.event_name}</td><td>${score}</td>`;
            eventTableBody.appendChild(row);
        });
    }

    // Display all events initially
    displayRegisteredEvents(allEvents);
</script>

</body>
</html>

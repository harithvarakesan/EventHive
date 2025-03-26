<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Cards with Filters</title>
    <link rel="stylesheet" href="./assets/css/home.css">
</head>
<body>
<?php include './header.php'; ?>

    <header>
        <h1>Event Listings</h1>
        <div class="filter-search-container">
            <input type="text" id="search-bar" placeholder="Search by event name..." oninput="filterEvents()">
            <input type="text" id="filter-location" placeholder="Search by location" oninput="filterEvents()">

            <!-- <select id="filter-location" onchange="filterEvents()">
                <option value="">All Locations</option>
                <option value="Location A">Location A</option>
                <option value="Location B">Location B</option>
            </select> -->
            <input type="date" id="filter-date" onchange="filterEvents()">
            <select id="filter-type" onchange="filterEvents()">
                <option value="">All Types</option>
                <option value="Paper Presentation">Paper Presentation</option>
                <option value="Competition">Competition</option>
                <option value="Hackathon">Hackathon</option>
            </select>
        </div>
    </header>

    <main id="event-container">
    <?php

        include './operations/db_connection.php';
        // Current date for comparison
        $currentDate = date("Y-m-d H:i:s");

        // Fetch upcoming events where the deadline has not passed
        $sql = "SELECT * FROM event WHERE deadline_date >= '$currentDate' ORDER BY start_date ASC";
        $result = $conn->query($sql);

        // Check if there are events
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='event-card' data-name='" . htmlspecialchars($row['name']) . "' data-location='" . htmlspecialchars($row['location']) . "' data-date='" . htmlspecialchars($row['start_date']) . "' data-type='" . htmlspecialchars($row['type']) . "' data-id='" . htmlspecialchars($row['id']) . "'>
                    <h2>" . htmlspecialchars($row['name']) . "</h2>
                    <p class='description'>" . htmlspecialchars($row['short_description']) . "</p>
                    <p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>
                    <p style='text-align: center;'><strong>Dates:</strong> " . htmlspecialchars($row['start_date']) . "<br> to <br>" . htmlspecialchars($row['end_date']) . "</p>
                    <button onclick=\"navigateToEventDetails('" . htmlspecialchars($row['id']) . "')\">View Details</button>
                    <button class='register-button' onclick=\"submitRegistration('" . htmlspecialchars($row['id']) . "')\">Register</button>
                </div>";
            }
        } else {
            echo "<p>No upcoming events available.</p>";
        }

        $conn->close();
        ?>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
    // Function to submit registration for an event
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

    // Assign the registration function to all register buttons
    const registerButtons = document.querySelectorAll('.register-button');
    registerButtons.forEach(button => {
        // Get the eventId from the data-attribute of the current button
        const eventId = button.closest('.event-card').getAttribute('data-id');
        
        button.addEventListener('click', function() {
            submitRegistration(eventId);
        });
    });
});

        function navigateToEventDetails(eventId) {
            window.location.href = `eventDetails.php?eventId=${eventId}`;
        }

        function filterEvents() {
            const searchValue = document.getElementById("search-bar").value.toLowerCase();
            const locationValue = document.getElementById("filter-location").value.toLowerCase();
            const dateValue = document.getElementById("filter-date").value;
            const typeValue = document.getElementById("filter-type").value;
            const events = document.querySelectorAll(".event-card");

            events.forEach(event => {
                const name = event.getAttribute("data-name").toLowerCase();
                const location = event.getAttribute("data-location").toLowerCase();
                const date = event.getAttribute("data-date");
                const type = event.getAttribute("data-type");

                const matchesSearch = name.includes(searchValue);
                const matchesLocation = location.includes(locationValue);
                const matchesDate = !dateValue || date === dateValue;
                const matchesType = !typeValue || type === typeValue;

                if (matchesSearch && matchesLocation && matchesDate && matchesType) {
                    event.style.display = "block";
                } else {
                    event.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>

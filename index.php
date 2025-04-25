<?php $pageTitle = "Event Cards with Filters"; include 'header.php'; ?>
<div class="pl-60 min-h-screen bg-gray-50 font-inter">
    <div class="flex justify-between items-center mb-8 pt-10 px-8">
        <h2 class="text-2xl font-bold text-gray-900">Upcoming Events</h2>
        <a href="#" class="text-orange-500 font-semibold hover:underline flex items-center gap-1"><i data-lucide="arrow-right"></i> View All</a>
    </div>
    <div class="flex flex-wrap gap-6 px-8">
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
                echo "<div class='event-card bg-white rounded-xl shadow-md border border-orange-100 p-4 w-full md:w-72 flex flex-col' data-name='" . htmlspecialchars($row['name']) . "' data-location='" . htmlspecialchars($row['location']) . "' data-type='" . htmlspecialchars($row['type']) . "' data-id='" . htmlspecialchars($row['id']) . "'>";
                if (!empty($row['image_url'])) {
                    echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='Event image' class='rounded-lg mb-3 h-40 w-full object-cover'>";
                } else {
                    echo "<div class='bg-orange-50 rounded-lg mb-3 h-40 w-full flex items-center justify-center text-4xl text-orange-400'><i class='fa fa-calendar'></i></div>";
                }
                echo "<h3 class='font-semibold text-lg mb-1'>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<div class='text-sm text-gray-500 mb-1'><i class='fa fa-calendar mr-1'></i> " . htmlspecialchars(date('M d, Y', strtotime($row['start_date']))) . "</div>";
                echo "<div class='text-sm text-gray-500 mb-1'><i class='fa fa-map-marker mr-1'></i> " . htmlspecialchars($row['location']) . "</div>";
                echo "<div class='text-sm text-gray-500 mb-2'><i class='fa fa-users mr-1'></i> " . htmlspecialchars($row['participants'] ?? 0) . " participants</div>";
                echo "<p class='text-gray-600 mb-3'>" . htmlspecialchars($row['short_description']) . "</p>";
                echo "<div class='flex gap-2 mt-auto'>";
                echo "<a href='eventDetails.php?eventId=" . urlencode($row['id']) . "' class='px-4 py-2 bg-orange-50 text-orange-500 rounded-lg font-medium hover:bg-orange-100 transition'>View Details</a>";
                echo "<a href='operations/register-event.php?eventId=" . urlencode($row['id']) . "' class='px-4 py-2 bg-orange-500 text-white rounded-lg font-medium hover:bg-orange-600 transition'>Register</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No upcoming events available.</p>";
        }

        $conn->close();
        ?>
    </div>
    <div class="flex flex-col md:flex-row gap-6 mt-10 px-8">
        <div class="flex-1 bg-white rounded-xl shadow-md p-8 border border-orange-100">
            <h3 class="text-xl font-semibold text-orange-500 mb-2 flex items-center gap-2"><i data-lucide="users"></i> For Participants</h3>
            <p class="text-gray-600 mb-4">Browse and register for exciting technical challenges, hackathons, and competitions. Showcase your skills, climb the leaderboards, and connect with like-minded peers.</p>
            <a href="#" class="inline-block mt-2 px-5 py-2 bg-orange-500 text-white rounded-lg font-medium hover:bg-orange-600 transition">Join as Participant</a>
        </div>
        <div class="flex-1 bg-white rounded-xl shadow-md p-8 border border-orange-100">
            <h3 class="text-xl font-semibold text-orange-500 mb-2 flex items-center gap-2"><i data-lucide="star"></i> For Hosts</h3>
            <p class="text-gray-600 mb-4">Create and manage your own events. Set challenges, track participant progress, and build a community around your technical interests.</p>
            <a href="#" class="inline-block mt-2 px-5 py-2 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition">Become a Host</a>
        </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) lucide.createIcons();
      });
    </script>
</div>
</body>
</html>
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

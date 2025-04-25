<?php $pageTitle = "Events - EventHive"; include 'header.php'; ?>

<div class="w-full min-h-screen bg-gray-50 font-inter p-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4 md:mb-0">Explore Events</h2>
        <div class="flex gap-2">
            <input id="search-bar" type="text" placeholder="Search by name, location, or type..." class="border border-orange-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400 w-64" oninput="filterEvents()">
        </div>
    </div>
    <div id="events-list" class="flex flex-wrap gap-6 justify-even">
        <?php
        include './operations/db_connection.php';
        $sql = "SELECT * FROM event ORDER BY start_date ASC";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='event-card bg-white rounded-xl shadow-md border border-orange-100 p-4 w-full md:w-72 flex flex-col' data-name='" . htmlspecialchars($row['name']) . "' data-location='" . htmlspecialchars($row['location']) . "' data-type='" . htmlspecialchars($row['type']) . "'>";
                if (!empty($row['image_url'])) {
                    echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='Event image' class='rounded-lg mb-3 h-40 w-full object-cover'>";
                } else {
                    echo "<div class='bg-orange-50 rounded-lg mb-3 h-40 w-full flex items-center justify-center text-4xl text-orange-400'><i class='fa fa-calendar'></i></div>";
                }
                echo "<h3 class='font-semibold text-lg mb-1'>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<div class='text-sm text-gray-500 mb-1'><i class='fa fa-calendar mr-1'></i> " . htmlspecialchars(date('M d, Y', strtotime($row['start_date']))) . "</div>";
                echo "<div class='text-sm text-gray-500 mb-1'><i class='fa fa-map-marker mr-1'></i> " . htmlspecialchars($row['location']) . "</div>";
                // echo "<div class='text-sm text-gray-500 mb-2'><i class='fa fa-users mr-1'></i> " . htmlspecialchars($row['participants'] ?? 0) . " participants</div>";
                echo "<p class='text-gray-600 mb-3'>" . htmlspecialchars($row['short_description']) . "</p>";
                echo "<div class='flex gap-2 mt-auto'>";
                echo "<a href='eventDetails.php?eventId=" . urlencode($row['id']) . "' class='px-4 py-2 bg-orange-50 text-orange-500 rounded-lg font-medium hover:bg-orange-100 transition'>View Details</a>";
                echo "<a href='operations/register-event.php?eventId=" . urlencode($row['id']) . "' class='px-4 py-2 bg-orange-500 text-white rounded-lg font-medium hover:bg-orange-600 transition'>Register</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No events found.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>
<script>
function filterEvents() {
    const search = document.getElementById('search-bar').value.toLowerCase();
    document.querySelectorAll('.event-card').forEach(card => {
        const name = card.getAttribute('data-name').toLowerCase();
        const location = card.getAttribute('data-location').toLowerCase();
        const type = card.getAttribute('data-type').toLowerCase();
        if (name.includes(search) || location.includes(search) || type.includes(search)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

</body>
</html>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) lucide.createIcons();
      });
    </script>
</div>
</body>
</html>

<?php
include '../operations/db_connection.php';
if (!isset($_SESSION)) session_start();
// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_event_id'])) {
    $deleteEventId = $_POST['delete_event_id'];
    $deleteSql = "DELETE FROM event WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    if ($deleteStmt) {
        $deleteStmt->bind_param("i", $deleteEventId);
        if ($deleteStmt->execute()) {
            echo "<script>alert('Event deleted successfully!');window.location.href = 'admin-your-events.php';</script>";
        } else {
            echo "<script>alert('Failed to delete the event.');</script>";
        }
        $deleteStmt->close();
    }
}
$hostId = isset($_SESSION['host_id']) ? $_SESSION['host_id'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/bee-loader.css">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Events</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <div id="bee-loader" class="bee-loader-container" style="display:none">
      <div class="bee-loader">
        <div class="bee-wings">
          <div class="bee-wing left"></div>
          <div class="bee-wing right"></div>
        </div>
        <div class="bee-body"></div>
        <div class="bee-stripes">
          <span class="stripe1"></span>
          <span class="stripe2"></span>
          <span class="stripe3"></span>
        </div>
        <div class="bee-face">
          <div class="bee-eye"></div>
          <div class="bee-eye"></div>
        </div>
      </div>
    </div>
        <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
    <?php include 'admin_sidebar.php'; ?>
    <div class="md:ml-60 flex flex-col min-h-screen transition-all duration-300">
        <header class="flex items-center justify-between px-6 py-6 border-b bg-white sticky top-0 z-40">
            <h1 class="text-2xl font-bold text-orange-600">Your Events</h1>
            <a href="admin-create-event.php" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-500 text-white hover:bg-orange-600 font-medium transition"><i data-lucide="plus-square" class="w-5 h-5"></i> Create Event</a>
        </header>
        <main class="flex-1 p-6">
            <!-- Filter Form -->
            <div class="mb-6 flex items-center gap-3">
                <input type="text" id="event-name-input" placeholder="Search by Event Name" onkeyup="filterEvents()" class="w-full md:w-1/3 px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-white shadow-sm" aria-label="Search events by name" />
            </div>
            <div class="grid gap-6" id="events-list">
                <?php
                if ($hostId) {
                    $sql = "SELECT id, name, start_date, end_date, short_description FROM event WHERE host = ?";
                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param("i", $hostId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "
                                <div class='event-card bg-white rounded-xl shadow hover:shadow-lg transition p-6 flex flex-col gap-3 border border-orange-100' data-name='" . strtolower($row['name']) . "'>
                                    <h3 class='text-xl font-semibold text-orange-700'>" . htmlspecialchars($row['name']) . "</h3>
                                    <p class='text-gray-700 mb-2'>" . htmlspecialchars($row['short_description']) . "</p>
                                    <p class='text-sm text-gray-500 mb-1'><strong>Start Date:</strong> " . htmlspecialchars($row['start_date']) . "</p>
                                    <p class='text-sm text-gray-500 mb-3'><strong>End Date:</strong> " . htmlspecialchars($row['end_date']) . "</p>
                                    <div class='flex gap-2'>
                                        <a href='admin-event-detail.php?id=" . (int)$row['id'] . "' class='view-btn inline-flex items-center gap-1 px-3 py-1.5 rounded bg-orange-100 text-orange-700 hover:bg-orange-200 font-medium transition'><i data-lucide='eye' class='w-4 h-4'></i> Details</a>
                                        <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this event?\")' style='display:inline;'>
                                            <input type='hidden' name='delete_event_id' value='" . htmlspecialchars($row['id']) . "'>
                                            <button type='submit' class='delete-btn inline-flex items-center gap-1 px-3 py-1.5 rounded bg-red-100 text-red-700 hover:bg-red-200 font-medium transition'><i data-lucide='trash-2' class='w-4 h-4'></i> Delete</button>
                                        </form>
                                    </div>
                                </div>";
                            }
                        } else {
                            echo "<p class='text-gray-500'>No events found.</p>";
                        }
                        $stmt->close();
                    } else {
                        echo "<p class='text-red-500'>Failed to prepare query: " . $conn->error . "</p>";
                    }
                } else {
                    echo "<p class='text-orange-600 font-medium'>Please log in to view your events.</p>";
                }
                $conn->close();
                ?>
            </div>
        </main>
    </div>

    <script>
    // Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) lucide.createIcons();
    });
    // Filter events
    function filterEvents() {
        var input = document.getElementById('event-name-input');
        var filter = input.value.toLowerCase();
        var eventsList = document.getElementById('events-list');
        var events = eventsList.getElementsByClassName('event-card');
        for (var i = 0; i < events.length; i++) {
            var event = events[i];
            var eventName = event.getAttribute('data-name');
            if (eventName.indexOf(filter) > -1) {
                event.style.display = '';
            } else {
                event.style.display = 'none';
            }
        }
    }
    // Modal for delete confirmation
    function openDeleteModal(eventId, eventName) {
        document.getElementById('modal-delete-id').value = eventId;
        document.getElementById('modal-event-name').textContent = 'Are you sure you want to delete "' + eventName + '"?';
        document.getElementById('delete-modal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
    // Accessibility: close modal on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="../assets/js/uiux.js"></script>
<script>
window.showBeeLoader = function(show = true) {
  const loader = document.getElementById('bee-loader');
  if (!loader) return;
  loader.style.display = show ? 'flex' : 'none';
}
</script>
<script>
// Toast utility
window.showToast = function(msg, type = 'info', duration = 3000) {
  const toast = document.createElement('div');
  toast.className = `px-4 py-2 rounded shadow text-white font-semibold toast-${type}`;
  toast.style.background = type === 'success' ? '#16a34a' : type === 'error' ? '#dc2626' : '#ea580c';
  toast.textContent = msg;
  document.getElementById('toast-container').appendChild(toast);
  setTimeout(() => toast.remove(), duration);
}
</script>
<style>.toast-info{background:#ea580c}.toast-success{background:#16a34a}.toast-error{background:#dc2626}</style>
</body>
</html>

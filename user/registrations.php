
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include '../header.php'; ?>
<?php
include '../operations/db_connection.php';

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


  <div class="flex-1 flex flex-col items-center justify-start py-12">
    <div class="w-full max-w-4xl bg-neutral-50 rounded-2xl shadow-2xl p-12 dashboard-widget text-lg">
  <div class="flex flex-col md:flex-row items-center md:items-end gap-6 mb-8">
    <div class="flex items-center gap-4">
      <canvas id="registration-avatar" width="56" height="56" data-name="<?php echo htmlspecialchars(isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'U'); ?>" class="avatar"></canvas>
      <noscript><span class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-orange-100 text-orange-600 font-bold text-2xl"><?php echo strtoupper(substr(isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'U',0,2)); ?></span></noscript>
      <h2 class="text-4xl font-extrabold text-gray-900 flex items-center gap-2">
        <i data-lucide="list-checks" class="w-8 h-8 text-orange-500"></i>
        My Event Registrations
      </h2>
    </div>
  </div>
  <hr class="border-orange-100 mb-8">
  <div class="w-full flex flex-col md:flex-row md:items-center gap-4 mb-10">
    <div class="flex-1 flex items-center gap-3 bg-orange-50 border border-orange-200 rounded-xl px-4 py-3 shadow-sm focus-within:ring-2 focus-within:ring-orange-200">
      <i data-lucide="search" class="w-5 h-5 text-orange-400"></i>
      <input id="event-search" type="text" placeholder="Search events..." class="flex-1 bg-transparent outline-none text-base text-gray-700 placeholder:text-orange-300" oninput="filterEvents()" />
      <button type="button" onclick="document.getElementById('event-search').value=''; filterEvents();" class="text-orange-400 hover:text-orange-600 focus:outline-none" title="Clear search"><i data-lucide="x-circle" class="w-5 h-5"></i></button>
    </div>
  </div>
  <div id="registration-summary" class="mb-4 text-gray-700 text-base font-medium"></div>
  <div id="no-registrations-message" class="hidden text-center text-orange-400 py-12 text-xl font-semibold bg-orange-50 rounded-xl mb-4"></div>
  <div class="overflow-x-auto">
    <table class="min-w-full text-base rounded-xl">
      <thead>
        <tr class="bg-orange-100 text-orange-600">
          <th class="py-4 px-6 font-semibold text-left rounded-tl-xl">Event <i data-lucide="calendar" class="inline w-5 h-5 align-middle"></i></th>
          <th class="py-4 px-6 font-semibold text-left rounded-tr-xl">Score</th>
        </tr>
      </thead>
      <tbody id="registered-events"></tbody>
    </table>
  </div>

    </div>
    
    <script src="assets/js/uiux.js"></script>
    <script>
      const allEvents = <?php echo json_encode($registeredEvents); ?>;
      function displayRegisteredEvents(events) {
        const eventTableBody = document.getElementById('registered-events');
        const summary = document.getElementById('registration-summary');
        const noMsg = document.getElementById('no-registrations-message');
        eventTableBody.innerHTML = '';
        if (!events.length) {
          summary.textContent = '';
          noMsg.classList.remove('hidden');
          noMsg.textContent = 'No registrations found.';
          return;
        } else {
          noMsg.classList.add('hidden');
        }
        summary.textContent = `Showing ${events.length} registration${events.length > 1 ? 's' : ''}`;
        events.forEach((event, idx) => {
          let score = '';
          if (event.mark == -1) score = '<span class="text-red-500 font-semibold">Absent</span>';
          else if (event.mark == 0) score = '<span class="text-gray-400">Not yet attended</span>';
          else score = `<span class="font-bold">${event.mark}</span>`;
          eventTableBody.innerHTML += `
            <tr class="${idx%2===0 ? 'bg-white' : 'bg-orange-50'} hover:bg-orange-100 transition">
              <td class="py-4 px-6 flex items-center gap-2 text-lg">
                <i data-lucide="ticket" class="w-6 h-6 text-orange-400"></i>
                <span>${event.event_name}</span>
              </td>
              <td class="py-4 px-6 text-lg">${score}</td>
            </tr>`;
        });
        if (window.lucide) lucide.createIcons();
      }
      function filterEvents() {
        const searchQuery = document.getElementById('event-search').value.toLowerCase();
        const filteredEvents = allEvents.filter(event => event.event_name.toLowerCase().includes(searchQuery));
        displayRegisteredEvents(filteredEvents);
      }
      displayRegisteredEvents(allEvents);
    </script>
  </div>
</div>

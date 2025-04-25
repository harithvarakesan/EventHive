<?php
include 'admin-header.php';
include './operations/db_connection.php';
if (!isset($_SESSION['host_id'])) {
    echo "<script>alert('You are not authorized to access this page.'); window.history.back();</script>";
    exit();
}
$hostId = $_SESSION['host_id'];
// Total events for this admin
$eventCount = 0;
$participantCount = 0;
$eventResult = $conn->prepare("SELECT COUNT(*) as cnt FROM event WHERE host = ?");
$eventResult->bind_param("i", $hostId);
$eventResult->execute();
$eventResult->bind_result($eventCount);
$eventResult->fetch();
$eventResult->close();
// Total participants in all events by this admin
$participantResult = $conn->prepare("SELECT COUNT(*) as cnt FROM participant p INNER JOIN event e ON p.event_id = e.id WHERE e.host = ?");
$participantResult->bind_param("i", $hostId);
$participantResult->execute();
$participantResult->bind_result($participantCount);
$participantResult->fetch();
$participantResult->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/bee-loader.css">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        <h1 class="text-2xl font-bold text-orange-600">Dashboard</h1>
    </header>
    <main class="flex-1 p-6 flex flex-col items-center justify-center gap-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl">
            <div class="bg-white rounded-xl shadow p-8 border border-orange-100 flex flex-col items-center">
                <i data-lucide="calendar" class="w-10 h-10 text-orange-500 mb-2"></i>
                <div class="text-4xl font-bold text-orange-600"><?php echo $eventCount; ?></div>
                <div class="text-lg text-gray-700 mt-2">Total Events</div>
            </div>
            <div class="bg-white rounded-xl shadow p-8 border border-orange-100 flex flex-col items-center">
                <i data-lucide="users" class="w-10 h-10 text-orange-500 mb-2"></i>
                <div class="text-4xl font-bold text-orange-600"><?php echo $participantCount; ?></div>
                <div class="text-lg text-gray-700 mt-2">Total Participants</div>
            </div>
        </div>

        <!-- Recent Events -->
        <?php
        include './operations/db_connection.php';
        $recentEvents = [];
        $stmt = $conn->prepare("SELECT id, name, start_date, end_date, location FROM event WHERE host = ? ORDER BY start_date DESC LIMIT 5");
        $stmt->bind_param("i", $hostId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $recentEvents[] = $row;
        }
        $stmt->close();
        // Events per month for chart
        $eventsPerMonth = [];
        $labels = [];
        $data = [];
        $stmt = $conn->prepare("SELECT DATE_FORMAT(start_date, '%b %Y') as month, COUNT(*) as cnt FROM event WHERE host = ? GROUP BY month ORDER BY start_date ASC LIMIT 12");
        $stmt->bind_param("i", $hostId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['month'];
            $data[] = (int)$row['cnt'];
        }
        $eventsPerMonth = ['labels' => $labels, 'datasets' => [[
            'label' => 'Events',
            'backgroundColor' => '#fb923c',
            'data' => $data
        ]]];
        $stmt->close();
        // Participants per event for chart
        $participantsLabels = [];
        $participantsData = [];
        $stmt = $conn->prepare("SELECT name, (SELECT COUNT(*) FROM participant WHERE event_id = event.id) as cnt FROM event WHERE host = ? ORDER BY start_date DESC LIMIT 5");
        $stmt->bind_param("i", $hostId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $participantsLabels[] = $row['name'];
            $participantsData[] = (int)$row['cnt'];
        }
        $participantsPerEvent = [
            'labels' => $participantsLabels,
            'datasets' => [[
                'label' => 'Participants',
                'backgroundColor' => ['#fbbf24','#fb923c','#f87171','#34d399','#60a5fa'],
                'data' => $participantsData
            ]]
        ];
        $conn->close();
        ?>

        <div class="w-full max-w-4xl mt-8">
            <div class="bg-white rounded-xl shadow p-8 border border-orange-100">
                <h2 class="text-xl font-semibold text-orange-700 mb-4">Recent Events</h2>
                <?php if (count($recentEvents) > 0): ?>
                <table class="min-w-full divide-y divide-orange-100 mb-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Start Date</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">End Date</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentEvents as $ev): ?>
                        <tr class="border-b">
                            <td class="px-4 py-2 text-gray-800"><?php echo htmlspecialchars($ev['name']); ?></td>
                            <td class="px-4 py-2 text-gray-700"><?php echo htmlspecialchars($ev['start_date']); ?></td>
                            <td class="px-4 py-2 text-gray-700"><?php echo htmlspecialchars($ev['end_date']); ?></td>
                            <td class="px-4 py-2 text-gray-700"><?php echo htmlspecialchars($ev['location']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="text-gray-500">No recent events found.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Analytics Charts -->
        <div class="w-full max-w-4xl mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-xl shadow p-8 border border-orange-100 flex flex-col items-center">
                <h3 class="text-lg font-semibold text-orange-700 mb-4">Events per Month</h3>
                <canvas id="eventsPerMonthChart" width="350" height="250"></canvas>
            </div>
            <div class="bg-white rounded-xl shadow p-8 border border-orange-100 flex flex-col items-center">
                <h3 class="text-lg font-semibold text-orange-700 mb-4">Participants per Recent Event</h3>
                <canvas id="participantsPerEventChart" width="350" height="250"></canvas>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>if(typeof Chart==='undefined'){document.write('<script src="assets/js/Chart.min.js"><\/script>');}</script>
        <script>
        window.eventsPerMonthData = <?php echo json_encode($eventsPerMonth); ?>;
        window.participantsPerEventData = <?php echo json_encode($participantsPerEvent); ?>;
        </script>
        <script src="assets/js/admin_dashboard_charts.js"></script>

        <div class="w-full max-w-4xl mt-8">
            <div class="bg-white rounded-xl shadow p-8 border border-orange-100">
                <h2 class="text-xl font-semibold text-orange-700 mb-4">Analytics Overview</h2>
                <ul class="list-disc pl-6 text-gray-700 space-y-2">
                    <li>Number of events you are hosting: <span class="font-bold text-orange-600"><?php echo $eventCount; ?></span></li>
                    <li>Total participants across all your events: <span class="font-bold text-orange-600"><?php echo $participantCount; ?></span></li>
                    <li>Use the sidebar to manage events and view more details.</li>
                </ul>
            </div>
        </div>
    </main>
</div>
<script>if(window.lucide) lucide.createIcons();</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="assets/js/uiux.js"></script>
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

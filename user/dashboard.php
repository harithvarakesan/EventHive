<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
// User Dashboard for EventHive
$pageTitle = "Dashboard - EventHive";
include '../header.php';
include '../operations/db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$userId = $_SESSION['user_id'];
$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$userEmail = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';

// Fetch event stats for the user

// Fetch event stats for the user
// 1. Total events attended (mark > 0)
// 2. Total events registered
// 3. Total events absent (mark = -1)
// 4. Total score (sum of marks > 0)

$sqlStats = "
    SELECT
        COUNT(*) AS total_registered,
        SUM(CASE WHEN mark > 0 THEN 1 ELSE 0 END) AS attended,
        SUM(CASE WHEN mark = -1 THEN 1 ELSE 0 END) AS absent,
        SUM(CASE WHEN mark > 0 THEN mark ELSE 0 END) AS total_score
    FROM participant
    WHERE participant_id = ?
";
$stmt = $conn->prepare($sqlStats);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch recent events (limit 3)
$sqlRecent = "
    SELECT e.name, e.start_date, p.mark
    FROM participant p
    JOIN event e ON p.event_id = e.id
    WHERE p.participant_id = ?
    ORDER BY e.start_date DESC
    LIMIT 3
";
$stmt = $conn->prepare($sqlRecent);
$stmt->bind_param("i", $userId);
$stmt->execute();
$recentEvents = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch leaderboard rank (demo: static, or query if you have a leaderboard table)
// For demo, we'll use a static value:
$userRank = 5;

// Demo notifications
$notifications = [
    ["msg" => "Leaderboard updated! Check your new rank.", "time" => "2h ago"],
    ["msg" => "Your registration for CodeFest was successful!", "time" => "1d ago"],
];

$conn->close();
?>
<div class=" flex min-h-screen bg-orange-50">
  <div class="flex-1 flex flex-col gap-8 py-8 px-4 md:px-12">
    <div class="max-w-6xl w-full mx-auto flex flex-col gap-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <!-- Profile Widget -->
      <div class="col-span-1 bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center dashboard-widget">
        <canvas id="profile-avatar" width="64" height="64" class="mb-2 rounded-full"></canvas>
<noscript><span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-orange-100 text-orange-600 font-bold text-2xl mb-2"><?php echo strtoupper(substr($userName,0,2)); ?></span></noscript>
        <div class="font-semibold text-lg text-gray-800 mb-1"><?php echo htmlspecialchars($userName); ?></div>
        <div class="text-sm text-gray-500 mb-2"><?php echo htmlspecialchars($userEmail); ?></div>
        <div class="bg-orange-50 text-orange-600 rounded px-3 py-1 text-xs font-semibold">Rank: <?php echo $userRank; ?></div>
      </div>
      <!-- Stats Widgets -->
      <div class="col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-orange-100 rounded-xl p-6 flex flex-col items-center dashboard-widget">
          <i data-lucide="calendar-check" class="w-8 h-8 text-orange-500 mb-2"></i>
          <div class="text-2xl font-bold text-orange-600"><?php echo $stats['attended'] ?? 0; ?></div>
          <div class="text-gray-700">Events Attended</div>
        </div>
        <div class="bg-orange-100 rounded-xl p-6 flex flex-col items-center dashboard-widget">
          <i data-lucide="clipboard-list" class="w-8 h-8 text-orange-500 mb-2"></i>
          <div class="text-2xl font-bold text-orange-600"><?php echo $stats['total_registered'] ?? 0; ?></div>
          <div class="text-gray-700">Events Registered</div>
        </div>
        <div class="bg-orange-100 rounded-xl p-6 flex flex-col items-center dashboard-widget">
          <i data-lucide="star" class="w-8 h-8 text-orange-500 mb-2"></i>
          <div class="text-2xl font-bold text-orange-600"><?php echo $stats['total_score'] ?? 0; ?></div>
          <div class="text-gray-700">Total Score</div>
        </div>
      </div>
    </div>
    <!-- Recent Events & Notifications -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Recent Events -->
      <div class="bg-white rounded-2xl shadow-lg p-6 dashboard-widget">
        <div class="flex items-center gap-2 mb-4">
          <i data-lucide="clock" class="w-5 h-5 text-orange-500"></i>
          <span class="font-semibold text-gray-800">Recent Events</span>
        </div>
        <ul class="divide-y divide-orange-100">
          <?php if ($recentEvents): foreach ($recentEvents as $event): ?>
            <li class="py-3 flex items-center gap-3">
              <span class="font-semibold text-orange-600"><?php echo htmlspecialchars($event['name']); ?></span>
              <span class="ml-auto text-xs text-gray-500"><?php echo date('M d', strtotime($event['start_date'])); ?></span>
              <span class="ml-2 text-xs <?php echo ($event['mark'] > 0) ? 'text-green-600' : (($event['mark'] == -1) ? 'text-red-500' : 'text-gray-400'); ?>">
                <?php echo ($event['mark'] > 0) ? 'Attended' : (($event['mark'] == -1) ? 'Absent' : 'Registered'); ?>
              </span>
            </li>
          <?php endforeach; else: ?>
            <li class="py-3 text-gray-400">No recent events.</li>
          <?php endif; ?>
        </ul>
      </div>
      <!-- Notifications -->
      <div class="bg-white rounded-2xl shadow-lg p-6 dashboard-widget">
        <div class="flex items-center gap-2 mb-4">
          <i data-lucide="bell" class="w-5 h-5 text-orange-500"></i>
          <span class="font-semibold text-gray-800">Notifications</span>
        </div>
        <ul class="divide-y divide-orange-100">
          <?php foreach ($notifications as $note): ?>
            <li class="py-3 flex items-center gap-3">
              <span class="text-gray-700"><?php echo htmlspecialchars($note['msg']); ?></span>
              <span class="ml-auto text-xs text-gray-500"><?php echo $note['time']; ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <!-- Quick Actions -->
      <div class="bg-orange-100 rounded-2xl shadow-lg p-6 flex flex-col gap-4 items-center justify-center dashboard-widget">
        <a href="../user/events.php" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-lg flex items-center justify-center gap-2">
          <i data-lucide="calendar-plus" class="w-5 h-5"></i> Register for Events
        </a>
        <a href="../user/leaderboard.php" class="w-full bg-orange-50 hover:bg-orange-200 text-orange-600 font-semibold px-6 py-3 rounded-lg flex items-center justify-center gap-2">
          <i data-lucide="trophy" class="w-5 h-5"></i> View Leaderboard
        </a>
        <a href="../user/profile.php" class="w-full bg-orange-50 hover:bg-orange-200 text-orange-600 font-semibold px-6 py-3 rounded-lg flex items-center justify-center gap-2">
          <i data-lucide="user" class="w-5 h-5"></i> View Profile
        </a>
      </div>
    </div>
  </div>
</div>
<script src="../assets/js/uiux.js"></script>
<script>if(window.lucide) lucide.createIcons();</script>


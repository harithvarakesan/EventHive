<?php
include '../admin/admin-header.php';
include '../operations/db_connection.php';

if (!isset($_SESSION['host_id'])) {
    echo "<script>alert('You are not authorized to access this page.'); window.history.back();</script>";
    exit();
}

$hostId = $_SESSION['host_id'];
$eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch event details
$query = "SELECT * FROM event WHERE id = ? AND host = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param("ii", $eventId, $hostId);
$stmt->execute();
$result = $stmt->get_result();
if ($result === false || $result->num_rows === 0) {
    echo "<script>alert('Event not found or you are not authorized to view it.'); window.history.back();</script>";
    exit();
}
$event = $result->fetch_assoc();

// Fetch registered students
$query = "SELECT p.id AS participant_id, u.name, p.mark 
          FROM participant p
          INNER JOIN user u ON p.participant_id = u.id
          WHERE p.event_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param("i", $eventId);
$stmt->execute();
$students = $stmt->get_result();

// Submit marks and attendance
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST['participants'] as $participantId => $data) {
        $attendance = isset($data['attendance']) ? 1 : 0;
        $mark = $attendance ? (is_numeric($data['mark']) ? intval($data['mark']) : 0) : -1;
        $updateQuery = "UPDATE participant SET mark = ? WHERE event_id = ? AND id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        if (!$updateStmt) {
            die("Query preparation failed: " . $conn->error);
        }
        $updateStmt->bind_param("iii", $mark, $eventId, $participantId);
        $updateStmt->execute();
    }
    echo "<script>alert('Attendance and marks updated successfully.'); window.location.href = 'admin-event-detail.php?id=$eventId';</script>";
    exit();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/bee-loader.css">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
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
<?php include '../admin/admin_sidebar.php'; ?>
<div class="md:ml-60 flex flex-col min-h-screen transition-all duration-300">
    <header class="flex items-center justify-between px-6 py-6 border-b bg-white sticky top-0 z-40">
        <h1 class="text-2xl font-bold text-orange-600">Event Details</h1>
        <a href="../admin/admin-your-events.php" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-100 text-orange-700 hover:bg-orange-200 font-medium transition"><i data-lucide='arrow-left' class='w-5 h-5'></i> Back to Events</a>
    </header>
    <main class="flex-1 p-6 flex items-center justify-center">
        <div class="w-full max-w-3xl bg-white rounded-xl shadow p-8 border border-orange-100">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-orange-700"><?php echo htmlspecialchars($event['name']); ?></h2>
                <a href="../admin/admin-update-event.php?id=<?php echo (int)$event['id']; ?>" class="inline-flex items-center gap-1 px-4 py-2 rounded-lg bg-orange-500 text-white hover:bg-orange-600 font-medium transition"><i data-lucide='edit-3' class='w-5 h-5'></i> Update Event</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <div class="mb-2"><span class="font-semibold">Type:</span> <?php echo htmlspecialchars($event['type']); ?></div>
                    <div class="mb-2"><span class="font-semibold">Start Date:</span> <?php echo htmlspecialchars($event['start_date']); ?></div>
                    <div class="mb-2"><span class="font-semibold">End Date:</span> <?php echo htmlspecialchars($event['end_date']); ?></div>
                    <div class="mb-2"><span class="font-semibold">Deadline:</span> <?php echo htmlspecialchars($event['deadline_date']); ?></div>
                    <div class="mb-2"><span class="font-semibold">Location:</span> <?php echo htmlspecialchars($event['location']); ?></div>
                </div>
                <div>
                    <div class="mb-2"><span class="font-semibold">Coordinator:</span> <?php echo htmlspecialchars($event['coordinator']); ?></div>
                    <div class="mb-2"><span class="font-semibold">Contact:</span> <?php echo htmlspecialchars($event['coordinator_number']); ?>, <?php echo htmlspecialchars($event['coordinator_emailid']); ?></div>
                    <div class="mb-2"><span class="font-semibold">Prize:</span> <?php echo htmlspecialchars($event['prize']); ?></div>
                    <div class="mb-2"><span class="font-semibold">Website:</span> <a href="<?php echo htmlspecialchars($event['website']); ?>" target="_blank" class="text-orange-500 underline hover:text-orange-700 transition"><?php echo htmlspecialchars($event['website']); ?></a></div>
                </div>
            </div>
            <div class="mb-4">
                <div class="font-semibold mb-1">Short Description:</div>
                <div class="bg-orange-50 rounded p-3 text-gray-700"><?php echo htmlspecialchars($event['short_description']); ?></div>
            </div>
            <div class="mb-4">
                <div class="font-semibold mb-1">Long Description:</div>
                <div class="bg-orange-50 rounded p-3 text-gray-600"><?php echo nl2br(htmlspecialchars($event['long_description'])); ?></div>
            </div>
            <div class="mb-4">
                <div class="font-semibold mb-1">Eligibility:</div>
                <div class="bg-orange-50 rounded p-3 text-gray-600"><?php echo nl2br(htmlspecialchars($event['eligibility'])); ?></div>
            </div>
        </div>
        <!-- Participants Table -->
        <?php if ($students && $students->num_rows > 0): ?>
        <form method="post" class="mt-8">
            <div class="w-full max-w-3xl bg-white rounded-xl shadow p-8 border border-orange-100 mt-6">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-orange-700">Registered Participants</h3>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-orange-500 text-white hover:bg-orange-600 font-medium transition">Update Attendance & Marks</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-orange-100">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Attendance</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Mark</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr class="border-b">
                                <td class="px-4 py-2 text-gray-800"><?php echo htmlspecialchars($student['name']); ?></td>
                                <td class="px-4 py-2">
                                    <input type="checkbox" name="participants[<?php echo $student['participant_id']; ?>][attendance]" value="1" <?php echo ($student['mark'] != -1 ? 'checked' : ''); ?> class="w-5 h-5 text-orange-500 border-gray-300 rounded">
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" name="participants[<?php echo $student['participant_id']; ?>][mark]" min="0" max="100" value="<?php echo ($student['mark'] != -1 ? (int)$student['mark'] : ''); ?>" class="w-20 px-2 py-1 border rounded">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        <?php else: ?>
            <div class="w-full max-w-3xl bg-white rounded-xl shadow p-8 border border-orange-100 mt-6 text-center text-gray-500">
                No participants registered for this event.
            </div>
        <?php endif; ?>
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
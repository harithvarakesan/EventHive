<?php
include 'admin-header.php';
include './operations/db_connection.php';

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 min-h-screen">
<?php include 'admin_sidebar.php'; ?>
<div class="md:ml-60 flex flex-col min-h-screen transition-all duration-300">
    <header class="flex items-center justify-between px-6 py-6 border-b bg-white sticky top-0 z-40">
        <h1 class="text-2xl font-bold text-orange-600">Event Details</h1>
        <a href="admin-your-events.php" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-100 text-orange-700 hover:bg-orange-200 font-medium transition"><i data-lucide='arrow-left' class='w-5 h-5'></i> Back to Events</a>
    </header>
    <main class="flex-1 p-6 flex items-center justify-center">
        <div class="w-full max-w-3xl bg-white rounded-xl shadow p-8 border border-orange-100">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-orange-700"><?php echo htmlspecialchars($event['name']); ?></h2>
                <a href="admin-update-event.php?id=<?php echo (int)$event['id']; ?>" class="inline-flex items-center gap-1 px-4 py-2 rounded-lg bg-orange-500 text-white hover:bg-orange-600 font-medium transition"><i data-lucide='edit-3' class='w-5 h-5'></i> Update Event</a>
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
    </main>
</div>
<script>if(window.lucide) lucide.createIcons();</script>
</body>
</html>
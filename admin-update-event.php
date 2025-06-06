<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['host_id'])) {
    header("Location: login.php");
    exit;
}
include './operations/db_connection.php';
$eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM event WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eventId);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
    $event = $result->fetch_assoc();
} else {
    echo "<script>alert('Event not found.');window.location.href='admin-your-events.php';</script>";
    exit;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 min-h-screen">
<?php include 'admin_sidebar.php'; ?>
<div class="md:ml-60 flex flex-col min-h-screen transition-all duration-300">
    <header class="flex items-center justify-between px-6 py-6 border-b bg-white sticky top-0 z-40">
        <h1 class="text-2xl font-bold text-orange-600">Update Event</h1>
        <a href="admin-event-detail.php?id=<?php echo (int)$event['id']; ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-100 text-orange-700 hover:bg-orange-200 font-medium transition"><i data-lucide='arrow-left' class='w-5 h-5'></i> Back to Details</a>
    </header>
    <main class="flex-1 p-6 flex items-center justify-center">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow p-8 border border-orange-100">
            <form action="operations/update-event.php" method="POST" class="space-y-5" id="update-event-form">
                <input type="hidden" name="id" value="<?php echo (int)$event['id']; ?>">
                <div>
                    <label for="name" class="block font-semibold text-gray-700 mb-1">Event Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($event['name']); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                </div>
                <div>
                    <label for="short_description" class="block font-semibold text-gray-700 mb-1">Short Description</label>
                    <input type="text" id="short_description" name="short_description" value="<?php echo htmlspecialchars($event['short_description']); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                </div>
                <div>
                    <label for="long_description" class="block font-semibold text-gray-700 mb-1">Long Description</label>
                    <textarea id="long_description" name="long_description" rows="4" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50"><?php echo htmlspecialchars($event['long_description']); ?></textarea>
                </div>
                <div>
                    <label for="eligibility" class="block font-semibold text-gray-700 mb-1">Eligibility</label>
                    <textarea id="eligibility" name="eligibility" rows="2" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50"><?php echo htmlspecialchars($event['eligibility']); ?></textarea>
                </div>
                <div>
                    <label for="type" class="block font-semibold text-gray-700 mb-1">Event Type</label>
                    <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($event['type']); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block font-semibold text-gray-700 mb-1">Start Date</label>
                        <input type="datetime-local" id="start_date" name="start_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['start_date'])); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <div>
                        <label for="end_date" class="block font-semibold text-gray-700 mb-1">End Date</label>
                        <input type="datetime-local" id="end_date" name="end_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['end_date'])); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="deadline_date" class="block font-semibold text-gray-700 mb-1">Deadline Date</label>
                        <input type="datetime-local" id="deadline_date" name="deadline_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['deadline_date'])); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <div>
                        <label for="location" class="block font-semibold text-gray-700 mb-1">Location</label>
                        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="coordinator" class="block font-semibold text-gray-700 mb-1">Coordinator Name</label>
                        <input type="text" id="coordinator" name="coordinator" value="<?php echo htmlspecialchars($event['coordinator']); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <div>
                        <label for="coordinator_number" class="block font-semibold text-gray-700 mb-1">Coordinator Number</label>
                        <input type="text" id="coordinator_number" name="coordinator_number" value="<?php echo htmlspecialchars($event['coordinator_number']); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <div>
                        <label for="coordinator_emailid" class="block font-semibold text-gray-700 mb-1">Coordinator Email</label>
                        <input type="email" id="coordinator_emailid" name="coordinator_emailid" value="<?php echo htmlspecialchars($event['coordinator_emailid']); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <div>
                        <label for="prize" class="block font-semibold text-gray-700 mb-1">Prize</label>
                        <input type="text" id="prize" name="prize" value="<?php echo htmlspecialchars($event['prize']); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                </div>
                <div>
                    <label for="website" class="block font-semibold text-gray-700 mb-1">Event Website</label>
                    <input type="text" id="website" name="website" value="<?php echo htmlspecialchars($event['website']); ?>" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                </div>
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 mt-4 rounded-lg bg-orange-500 text-white hover:bg-orange-600 font-semibold text-lg transition disabled:opacity-50" id="submit-btn">
                    <i data-lucide='save' class='w-5 h-5'></i> Update Event
                </button>
            </form>
        </div>
    </main>
</div>
<script>if(window.lucide) lucide.createIcons();
document.getElementById('update-event-form').addEventListener('submit', function(e) {
    var btn = document.getElementById('submit-btn');
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2 text-white inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Updating...';
});</script>
</body>
</html>
<?php $pageTitle = "Event Details - EventHive"; include 'header.php'; ?>
<?php
include './operations/db_connection.php';
$eventId = isset($_GET['eventId']) ? intval($_GET['eventId']) : 0;

// Query to fetch event details based on eventId
$sql = "SELECT * FROM event WHERE id = $eventId";
$result = $conn->query($sql);
if (!$result) {
    // If query fails, display an error message
    die("Error in query: " . $conn->error);
}
if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
} else {
    echo "<p>Event not found.</p>";
    exit; // Stop execution if no event is found
}

$conn->close();
?>
<div class="pl-60 min-h-screen bg-gray-50 font-inter p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md border border-orange-100 p-8 flex flex-col md:flex-row gap-8">
        <!-- Event Image -->
        <div class="md:w-1/2 w-full flex flex-col items-center justify-start">
            <?php if (!empty($event['image_url'])): ?>
                <img src="<?= htmlspecialchars($event['image_url']) ?>" alt="Event image" class="rounded-lg mb-4 h-60 w-full object-cover">
            <?php else: ?>
                <div class="bg-orange-50 rounded-lg mb-4 h-60 w-full flex items-center justify-center text-6xl text-orange-400">
                    <i class="fa fa-calendar"></i>
                </div>
            <?php endif; ?>
            <?php if (!empty($event['prize'])): ?>
                <div class="mt-2 text-orange-600 font-semibold text-sm"><i class="fa fa-gift mr-1"></i> Prizes: <?= htmlspecialchars($event['prize']) ?></div>
            <?php endif; ?>
        </div>
        <!-- Event Details -->
        <div class="md:w-1/2 w-full flex flex-col">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($event['name']) ?></h2>
            <div class="flex flex-wrap gap-3 mb-4 text-sm text-gray-600">
                <?php if (!empty($event['type'])): ?>
                    <span class="inline-flex items-center gap-1 bg-orange-50 px-2 py-1 rounded"><i class="fa fa-tag"></i> <?= htmlspecialchars($event['type']) ?></span>
                <?php endif; ?>
                <?php if (!empty($event['start_date']) && !empty($event['end_date'])): ?>
                    <span class="inline-flex items-center gap-1 bg-orange-50 px-2 py-1 rounded"><i class="fa fa-calendar"></i> <?= date("M d, Y", strtotime($event['start_date'])) ?> to <?= date("M d, Y", strtotime($event['end_date'])) ?></span>
                <?php endif; ?>
                <?php if (!empty($event['location'])): ?>
                    <span class="inline-flex items-center gap-1 bg-orange-50 px-2 py-1 rounded"><i class="fa fa-map-marker"></i> <?= htmlspecialchars($event['location']) ?></span>
                <?php endif; ?>
                <?php if (!empty($event['participants'])): ?>
                    <span class="inline-flex items-center gap-1 bg-orange-50 px-2 py-1 rounded"><i class="fa fa-users"></i> <?= htmlspecialchars($event['participants']) ?> participants</span>
                <?php endif; ?>
                <?php if (!empty($event['deadline_date'])): ?>
                    <span class="inline-flex items-center gap-1 bg-orange-50 px-2 py-1 rounded"><i class="fa fa-clock-o"></i> Register by <?= date("M d, Y", strtotime($event['deadline_date'])) ?></span>
                <?php endif; ?>
            </div>
            <?php if (!empty($event['short_description'])): ?>
                <div class="mb-3 text-gray-700 text-base">
                    <?= htmlspecialchars($event['short_description']) ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($event['long_description'])): ?>
                <div class="mb-3 text-gray-600 text-sm">
                    <?= htmlspecialchars($event['long_description']) ?>
                </div>
            <?php endif; ?>
            <div class="mb-4">
                <?php if (!empty($event['eligibility'])): ?>
                    <div class="text-xs text-gray-500 mb-1"><span class="font-semibold">Eligibility:</span> <?= htmlspecialchars($event['eligibility']) ?></div>
                <?php endif; ?>
                <?php if (!empty($event['coordinator'])): ?>
                    <div class="text-xs text-gray-500 mb-1"><span class="font-semibold">Contact:</span> <?= htmlspecialchars($event['coordinator']) ?> | <?= htmlspecialchars($event['coordinator_number']) ?> | <?= htmlspecialchars($event['coordinator_emailid']) ?></div>
                <?php endif; ?>
                <?php if (!empty($event['website'])): ?>
                    <div class="text-xs text-gray-500 mb-1"><span class="font-semibold">Official Website:</span> <a href="<?= htmlspecialchars($event['website']) ?>" target="_blank" class="text-orange-500 underline hover:text-orange-700 transition"><?= htmlspecialchars($event['website']) ?></a></div>
                <?php endif; ?>
            </div>
            <div class="flex gap-4 mt-auto">
                <a href="operations/register-event.php?eventId=<?= urlencode($event['id']) ?>" class="px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition">Register Now</a>
                <button onclick="window.history.back()" class="px-6 py-2 bg-orange-50 text-orange-500 rounded-lg font-semibold hover:bg-orange-100 transition">Back to Events</button>
            </div>
        </div>
    </div>
</div>

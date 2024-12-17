<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link rel="stylesheet" href="./assets/css/admin-create-event.css">
</head>
<body>
    <header>
        <?php include 'admin-header.php'; ?>
    </header>

    <main class="create-event-container">
        <div class="event-box">
            <h2>Create New Event</h2>
            <form action="operations/insert-event.php" method="POST">
                <div class="input-group">
                    <label for="event-name">Event Name</label>
                    <input type="text" id="event-name" name="name" required>
                </div>
                <div class="input-group">
                    <label for="short-description">Short Description</label>
                    <input type="text" id="short-description" name="short_description" required>
                </div>
                <div class="input-group">
                    <label for="long-description">Long Description</label>
                    <textarea id="long-description" name="long_description" rows="4" required></textarea>
                </div>
                <div class="input-group">
                    <label for="eligibility">Eligibility</label>
                    <textarea id="eligibility" name="eligibility" rows="2" required></textarea>
                </div>
                <div class="input-group">
                    <label for="type">Event Type</label>
                    <input type="text" id="type" name="type" required>
                </div>
                <div class="input-group">
                    <label for="start-date">Start Date</label>
                    <input type="datetime-local" id="start-date" name="start_date" required>
                </div>
                <div class="input-group">
                    <label for="end-date">End Date</label>
                    <input type="datetime-local" id="end-date" name="end_date" required>
                </div>
                <div class="input-group">
                    <label for="deadline-date">Deadline Date</label>
                    <input type="datetime-local" id="deadline-date" name="deadline_date" required>
                </div>
                <div class="input-group">
                    <label for="coordinator">Coordinator Name</label>
                    <input type="text" id="coordinator" name="coordinator" required>
                </div>
                <div class="input-group">
                    <label for="coordinator-number">Coordinator Number</label>
                    <input type="text" id="coordinator-number" name="coordinator_number" required>
                </div>
                <div class="input-group">
                    <label for="coordinator-email">Coordinator Email</label>
                    <input type="email" id="coordinator-email" name="coordinator_emailid" required>
                </div>
                <div class="input-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" required>
                </div>
                <div class="input-group">
                    <label for="prize">Prize</label>
                    <input type="text" id="prize" name="prize" required>
                </div>
                <div class="input-group">
                    <label for="website">Event Website</label>
                    <input type="text" id="website" name="website" required>
                </div>
                <button type="submit" class="create-btn">Create Event</button>
            </form>
        </div>
    </main>
</body>
</html>

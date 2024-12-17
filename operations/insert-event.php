<?php
include './db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from form
    $name = $_POST['name'];
    $short_description = $_POST['short_description'];
    $long_description = $_POST['long_description'];
    $eligibility = $_POST['eligibility'];
    $type = $_POST['type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $deadline_date = $_POST['deadline_date'];
    $coordinator = $_POST['coordinator'];
    $coordinator_number = $_POST['coordinator_number'];
    $coordinator_emailid = $_POST['coordinator_emailid'];
    $location = $_POST['location'];
    $prize = $_POST['prize'];
    $website = $_POST['website'];
    $host = 1; // Replace with actual session value if dynamic (e.g., $_SESSION['host_id'])

    // Prepare SQL query
    $sql = "INSERT INTO event (
        name, host, short_description, long_description, eligibility, 
        type, start_date, end_date, deadline_date, 
        coordinator, coordinator_number, coordinator_emailid, location, prize, website
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters to statement
        $stmt->bind_param(
            "sisssssssssssss",
            $name, $host, $short_description, $long_description, $eligibility,
            $type, $start_date, $end_date, $deadline_date,
            $coordinator, $coordinator_number, $coordinator_emailid, $location, $prize, $website
        );

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>
                alert('Event created successfully!');
                window.location.href = '../admin-your-event.php';
                </script>";
        } else {
            echo "<script>
                alert('Error creating event. Please try again.');
                window.history.back();
                </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
            alert('Database error. Failed to prepare statement.');
            window.history.back();
            </script>";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "<script>
        alert('Invalid request.');
        window.history.back();
        </script>";
}
?>

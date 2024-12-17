<?php
// Start the session to access participant_id
session_start();
include './db_connection.php';

// Check if the session contains participant_id and eventId is passed in the URL
if (!isset($_SESSION['user_id']) || !isset($_GET['eventId'])) {
    echo "Please log in to register for an event.";
    exit;
}

// Get participant_id from session and eventId from URL
$participantId = $_SESSION['user_id'];
$eventId = intval($_GET['eventId']); // Make sure eventId is an integer to prevent SQL injection

// Check if the eventId exists in the events table to avoid invalid registrations
$sql_check_event = "SELECT * FROM events WHERE id = $eventId";
$result_check_event = $conn->query($sql_check_event);

// Check if the participant is already registered for this event
$sql_check_registration = "SELECT * FROM participant WHERE participant_id = $participantId AND event_id = $eventId";
$result_check_registration = $conn->query($sql_check_registration);

if ($result_check_registration->num_rows > 0) {
    // Participant is already registered for this event
    echo "<script>alert('You are already registered for this event.'); window.history.back();</script>";
    exit;
}

// Prepare the insert query to register the participant for the event
$sql_insert_registration = "INSERT INTO participant (participant_id, event_id) VALUES ($participantId, $eventId)";

// Execute the insert query
if ($conn->query($sql_insert_registration) === TRUE) {
    echo "<script>alert('Successfully registered for this event.'); window.history.back();</script>";
    // Optionally, redirect the user to a confirmation page or event page
    // header("Location: eventDetails.php?eventId=$eventId");
} else {
    echo "Error: " . $conn->error;
}

// Close the connection
$conn->close();
?>

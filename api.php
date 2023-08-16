<?php
include 'config.php';

header("Content-Type: application/json");
// Add CORS headers to allow requests from any origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if ($_GET['endpoint'] === 'destinations') {
            // Retrieve a list of available destinations
            $sql = "SELECT * FROM destinations";
        } elseif ($_GET['endpoint'] === 'flights') {
            // Retrieve a list of available flights
            $sql = "SELECT * FROM flights";
        } elseif ($_GET['endpoint'] === 'bookings') {
            // Retrieve a list of all bookings
            $sql = "SELECT * FROM bookings";
        }
        $result = $conn->query($sql);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
        break;

    case 'POST':
        if ($_GET['endpoint'] === 'bookings') {
            // Create a new booking
            $data = json_decode(file_get_contents('php://input'), true);
            $flightId = $data['flight_id'];
            $passengerName = $data['passenger_name'];

            $sql = "INSERT INTO bookings (flight_id, passenger_name) VALUES ('$flightId', '$passengerName')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['message' => 'Booking created successfully']);
            } else {
                echo json_encode(['error' => 'Booking creation failed']);
            }
        }
        break;

    case 'PUT':
        if ($_GET['endpoint'] === 'bookings') {
            // Update an existing booking
            $data = json_decode(file_get_contents('php://input'), true);
            $bookingId = $data['booking_id'];
            $newPassengerName = $data['new_passenger_name'];

            $sql = "UPDATE bookings SET passenger_name='$newPassengerName' WHERE id='$bookingId'";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['message' => 'Booking updated successfully']);
            } else {
                echo json_encode(['error' => 'Booking update failed']);
            }
        }
        break;

    case 'DELETE':
        if ($_GET['endpoint'] === 'bookings') {
            // Delete a booking
            $bookingId = $_GET['booking_id'];

            $sql = "DELETE FROM bookings WHERE id='$bookingId'";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['message' => 'Booking deleted successfully']);
            } else {
                echo json_encode(['error' => 'Booking deletion failed']);
            }
        }
        break;
}

$conn->close();
?>


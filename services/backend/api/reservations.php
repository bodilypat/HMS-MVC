<?php
header("Content-Type: application/json");

// Include the database connection
include('../config/dbconnect.php');

// Get the HTTP request method
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a single reservation
            $id = intval($_GET['id']);
            get_reservation($id);
        } else {
            // Otherwise, fetch all reservations
            get_reservations();
        }
        break;

    case 'POST':
        // Create a new reservation
        create_reservation();
        break;

    case 'PUT':
        // Update an existing reservation
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_reservation($id);
        }
        break;

    case 'DELETE':
        // Delete a reservation
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_reservation($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

// Get all reservations
function get_reservations() {
    global $conn;

    $sql = "SELECT * FROM reservations";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($reservations) {
        echo json_encode($reservations);
    } else {
        echo json_encode(array("message" => "No reservations found"));
    }
}

// Get a single reservation by ID
function get_reservation($id) {
    global $conn;

    $sql = "SELECT * FROM reservations WHERE reservation_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reservation) {
        echo json_encode($reservation);
    } else {
        echo json_encode(array("message" => "Reservation not found"));
    }
}

// Create a new reservation
function create_reservation() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    // Input validation
    if (!isset($data['guest_id'], $data['room_id'], $data['check_in'], $data['check_out'], $data['reservation_status'], $data['payment_status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

    // Prepare SQL to insert data
    $sql = "INSERT INTO reservations (guest_id, room_id, check_in, check_out, reservation_status, payment_status)
            VALUES (:guest_id, :room_id, :check_in, :check_out, :reservation_status, :payment_status)";
    
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':guest_id', $data['guest_id']);
    $stmt->bindParam(':room_id', $data['room_id']);
    $stmt->bindParam(':check_in', $data['check_in']);
    $stmt->bindParam(':check_out', $data['check_out']);
    $stmt->bindParam(':reservation_status', $data['reservation_status']);
    $stmt->bindParam(':payment_status', $data['payment_status']);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "New reservation created successfully", "reservation_id" => $conn->lastInsertId()));
    } else {
        echo json_encode(array("message" => "Error creating reservation"));
    }
}

// Update an existing reservation
function update_reservation($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    // Input validation
    if (!isset($data['guest_id'], $data['room_id'], $data['check_in'], $data['check_out'], $data['reservation_status'], $data['payment_status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

    // Prepare SQL to update data
    $sql = "UPDATE reservations 
            SET guest_id = :guest_id, room_id = :room_id, check_in = :check_in, check_out = :check_out, 
                reservation_status = :reservation_status, payment_status = :payment_status
            WHERE reservation_id = :id";
    
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':guest_id', $data['guest_id']);
    $stmt->bindParam(':room_id', $data['room_id']);
    $stmt->bindParam(':check_in', $data['check_in']);
    $stmt->bindParam(':check_out', $data['check_out']);
    $stmt->bindParam(':reservation_status', $data['reservation_status']);
    $stmt->bindParam(':payment_status', $data['payment_status']);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Reservation updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating reservation"));
    }
}

// Delete a reservation
function delete_reservation($id) {
    global $conn;

    // Prepare SQL to delete reservation
    $sql = "DELETE FROM reservations WHERE reservation_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Reservation deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error deleting reservation"));
    }
}
?>
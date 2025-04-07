<?php
header("Content-Type: application/json");

// Include the database connection
include('../config/dbconnect.php');

// Get the HTTP request method
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a single housekeeping record
            $id = intval($_GET['id']);
            get_housekeeping($id);
        } else {
            // Otherwise, fetch all housekeeping records
            get_housekeepings();
        }
        break;

    case 'POST':
        // Create a new housekeeping record
        create_housekeeping();
        break;

    case 'PUT':
        // Update an existing housekeeping record
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_housekeeping($id);
        }
        break;

    case 'DELETE':
        // Delete a housekeeping record
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_housekeeping($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

// Get all housekeeping records
function get_housekeepings() {
    global $conn;

    $sql = "SELECT * FROM housekeepings";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $housekeepings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($housekeepings) {
        echo json_encode($housekeepings);
    } else {
        echo json_encode(array("message" => "No housekeeping records found"));
    }
}

// Get a single housekeeping record by ID
function get_housekeeping($id) {
    global $conn;

    $sql = "SELECT * FROM housekeepings WHERE housekeeping_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $housekeeping = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($housekeeping) {
        echo json_encode($housekeeping);
    } else {
        echo json_encode(array("message" => "Housekeeping record not found"));
    }
}

// Create a new housekeeping record
function create_housekeeping() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    // Input validation
    if (!isset($data['room_id'], $data['staff_id'], $data['cleaning_date'], $data['cleaning_status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

    // Prepare SQL to insert data
    $sql = "INSERT INTO housekeepings (room_id, staff_id, cleaning_date, cleaning_status)
            VALUES (:room_id, :staff_id, :cleaning_date, :cleaning_status)";
    
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':room_id', $data['room_id'], PDO::PARAM_INT);
    $stmt->bindParam(':staff_id', $data['staff_id'], PDO::PARAM_INT);
    $stmt->bindParam(':cleaning_date', $data['cleaning_date']);
    $stmt->bindParam(':cleaning_status', $data['cleaning_status']);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "New housekeeping record created successfully", "housekeeping_id" => $conn->lastInsertId()));
    } else {
        echo json_encode(array("message" => "Error creating housekeeping record"));
    }
}

// Update an existing housekeeping record
function update_housekeeping($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    // Input validation
    if (!isset($data['room_id'], $data['staff_id'], $data['cleaning_date'], $data['cleaning_status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

    // Prepare SQL to update data
    $sql = "UPDATE housekeepings 
            SET room_id = :room_id, staff_id = :staff_id, cleaning_date = :cleaning_date, cleaning_status = :cleaning_status
            WHERE housekeeping_id = :id";
    
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':room_id', $data['room_id'], PDO::PARAM_INT);
    $stmt->bindParam(':staff_id', $data['staff_id'], PDO::PARAM_INT);
    $stmt->bindParam(':cleaning_date', $data['cleaning_date']);
    $stmt->bindParam(':cleaning_status', $data['cleaning_status']);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Housekeeping record updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating housekeeping record"));
    }
}

// Delete a housekeeping record
function delete_housekeeping($id) {
    global $conn;

    // Prepare SQL to delete housekeeping record
    $sql = "DELETE FROM housekeepings WHERE housekeeping_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Housekeeping record deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error deleting housekeeping record"));
    }
}
?>
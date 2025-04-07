<?php
header("Content-Type: application/json");

// Include the database connection
include('../config/dbconnect.php');

// Get the HTTP request method
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a single guest
            $id = intval($_GET['id']);
            get_guest($id);
        } else {
            // Otherwise, fetch all guests
            get_guests();
        }
        break;

    case 'POST':
        // Create a new guest
        create_guest();
        break;

    case 'PUT':
        // Update an existing guest
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_guest($id);
        }
        break;

    case 'DELETE':
        // Delete a guest
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_guest($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

// Get all guests
function get_guests() {
    global $conn;

    $sql = "SELECT * FROM guests";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $guests = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($guests) {
        echo json_encode($guests);
    } else {
        echo json_encode(array("message" => "No guests found"));
    }
}

// Get a single guest by ID
function get_guest($id) {
    global $conn;

    $sql = "SELECT * FROM guests WHERE guest_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $guest = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($guest) {
        echo json_encode($guest);
    } else {
        echo json_encode(array("message" => "Guest not found"));
    }
}

// Create a new guest
function create_guest() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    // Input validation
    if (!isset($data['first_name'], $data['last_name'], $data['email'], $data['id_type'], $data['id_number'], $data['dob'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

    // Prepare SQL to insert data
    $sql = "INSERT INTO guests (first_name, last_name, email, phone_number, address, id_type, id_number, dob, nationality, check_in_date, check_out_date)
            VALUES (:first_name, :last_name, :email, :phone_number, :address, :id_type, :id_number, :dob, :nationality, :check_in_date, :check_out_date)";
    
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':first_name', $data['first_name']);
    $stmt->bindParam(':last_name', $data['last_name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':phone_number', $data['phone_number']);
    $stmt->bindParam(':address', $data['address']);
    $stmt->bindParam(':id_type', $data['id_type']);
    $stmt->bindParam(':id_number', $data['id_number']);
    $stmt->bindParam(':dob', $data['dob']);
    $stmt->bindParam(':nationality', $data['nationality']);
    $stmt->bindParam(':check_in_date', $data['check_in_date']);
    $stmt->bindParam(':check_out_date', $data['check_out_date']);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "New guest created successfully", "guest_id" => $conn->lastInsertId()));
    } else {
        echo json_encode(array("message" => "Error creating guest"));
    }
}

// Update an existing guest
function update_guest($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    // Input validation
    if (!isset($data['first_name'], $data['last_name'], $data['email'], $data['id_type'], $data['id_number'], $data['dob'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

    // Prepare SQL to update data
    $sql = "UPDATE guests 
            SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, 
                address = :address, id_type = :id_type, id_number = :id_number, dob = :dob, nationality = :nationality, 
                check_in_date = :check_in_date, check_out_date = :check_out_date
            WHERE guest_id = :id";
    
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':first_name', $data['first_name']);
    $stmt->bindParam(':last_name', $data['last_name']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':phone_number', $data['phone_number']);
    $stmt->bindParam(':address', $data['address']);
    $stmt->bindParam(':id_type', $data['id_type']);
    $stmt->bindParam(':id_number', $data['id_number']);
    $stmt->bindParam(':dob', $data['dob']);
    $stmt->bindParam(':nationality', $data['nationality']);
    $stmt->bindParam(':check_in_date', $data['check_in_date']);
    $stmt->bindParam(':check_out_date', $data['check_out_date']);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Guest updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating guest"));
    }
}

// Delete a guest
function delete_guest($id) {
    global $conn;

    // Prepare SQL to delete guest
    $sql = "DELETE FROM guests WHERE guest_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Guest deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error deleting guest"));
    }
}
?>

<?php
header("Content-Type: application/json");

// Include the database connection
include('../config/dbconnect.php');

// Get the HTTP request method
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a single billing
            $id = intval($_GET['id']);
            get_billing($id);
        } else {
            // Otherwise, fetch all billings
            get_billings();
        }
        break;

    case 'POST':
        // Create a new billing
        create_billing();
        break;

    case 'PUT':
        // Update an existing billing
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_billing($id);
        }
        break;

    case 'DELETE':
        // Delete a billing
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_billing($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

// Get all billings
function get_billings() {
    global $conn;

    $sql = "SELECT * FROM billings";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $billings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($billings) {
        echo json_encode($billings);
    } else {
        echo json_encode(array("message" => "No billings found"));
    }
}

// Get a single billing by ID
function get_billing($id) {
    global $conn;

    $sql = "SELECT * FROM billings WHERE billing_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $billing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($billing) {
        echo json_encode($billing);
    } else {
        echo json_encode(array("message" => "Billing not found"));
    }
}

// Create a new billing
function create_billing() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    // Input validation
    if (!isset($data['reservation_id'], $data['total_amount'], $data['payment_status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

    // Prepare SQL to insert data
    $sql = "INSERT INTO billings (reservation_id, service_charge, discount, total_amount, payment_status)
            VALUES (:reservation_id, :service_charge, :discount, :total_amount, :payment_status)";
    
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':reservation_id', $data['reservation_id'], PDO::PARAM_INT);
    $stmt->bindParam(':service_charge', $data['service_charge'], PDO::PARAM_STR);
    $stmt->bindParam(':discount', $data['discount'], PDO::PARAM_STR);
    $stmt->bindParam(':total_amount', $data['total_amount'], PDO::PARAM_STR);
    $stmt->bindParam(':payment_status', $data['payment_status'], PDO::PARAM_STR);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "New billing created successfully", "billing_id" => $conn->lastInsertId()));
    } else {
        echo json_encode(array("message" => "Error creating billing"));
    }
}

// Update an existing billing
function update_billing($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    // Input validation
    if (!isset($data['total_amount'], $data['payment_status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

    // Prepare SQL to update data
    $sql = "UPDATE billings 
            SET service_charge = :service_charge, discount = :discount, total_amount = :total_amount, 
                payment_status = :payment_status
            WHERE billing_id = :id";
    
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':service_charge', $data['service_charge'], PDO::PARAM_STR);
    $stmt->bindParam(':discount', $data['discount'], PDO::PARAM_STR);
    $stmt->bindParam(':total_amount', $data['total_amount'], PDO::PARAM_STR);
    $stmt->bindParam(':payment_status', $data['payment_status'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Billing updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating billing"));
    }
}

// Delete a billing
function delete_billing($id) {
    global $conn;

    // Prepare SQL to delete billing
    $sql = "DELETE FROM billings WHERE billing_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Billing deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error deleting billing"));
    }
}
?>
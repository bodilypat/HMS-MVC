<?php
header("Content-Type: application/json");

// Include the database connection
include('../config/dbconnect.php');

// Get the HTTP request method
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // If an ID is provided, fetch a single payment
            $id = intval($_GET['id']);
            get_payment($id);
        } else {
            // Otherwise, fetch all payments
            get_payments();
        }
        break;

    case 'POST':
        // Create a new payment
        create_payment();
        break;

    case 'PUT':
        // Update an existing payment
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_payment($id);
        }
        break;

    case 'DELETE':
        // Delete a payment
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_payment($id);
        }
        break;

    default:
        // Invalid method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

// Get all payments
function get_payments() {
    global $conn;

    $sql = "SELECT * FROM payments";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($payments) {
        echo json_encode($payments);
    } else {
        echo json_encode(array("message" => "No payments found"));
    }
}

// Get a single payment by ID
function get_payment($id) {
    global $conn;

    $sql = "SELECT * FROM payments WHERE payment_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $payment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($payment) {
        echo json_encode($payment);
    } else {
        echo json_encode(array("message" => "Payment not found"));
    }
}

// Create a new payment
function create_payment() {
    global $conn;

    // Get input data from POST request
    $data = json_decode(file_get_contents("php://input"), true);

    // Input validation
    if (!isset($data['reservation_id'], $data['amount_paid'], $data['payment_date'], $data['payment_method'], $data['payment_status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

    // Prepare SQL to insert data
    $sql = "INSERT INTO payments (reservation_id, amount_paid, payment_date, payment_method, payment_status)
            VALUES (:reservation_id, :amount_paid, :payment_date, :payment_method, :payment_status)";
    
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':reservation_id', $data['reservation_id']);
    $stmt->bindParam(':amount_paid', $data['amount_paid']);
    $stmt->bindParam(':payment_date', $data['payment_date']);
    $stmt->bindParam(':payment_method', $data['payment_method']);
    $stmt->bindParam(':payment_status', $data['payment_status']);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "New payment created successfully", "payment_id" => $conn->lastInsertId()));
    } else {
        echo json_encode(array("message" => "Error creating payment"));
    }
}

// Update an existing payment
function update_payment($id) {
    global $conn;

    // Get input data from PUT request
    $data = json_decode(file_get_contents("php://input"), true);

    // Input validation
    if (!isset($data['reservation_id'], $data['amount_paid'], $data['payment_date'], $data['payment_method'], $data['payment_status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

    // Prepare SQL to update data
    $sql = "UPDATE payments 
            SET reservation_id = :reservation_id, amount_paid = :amount_paid, payment_date = :payment_date, 
                payment_method = :payment_method, payment_status = :payment_status
            WHERE payment_id = :id";
    
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':reservation_id', $data['reservation_id']);
    $stmt->bindParam(':amount_paid', $data['amount_paid']);
    $stmt->bindParam(':payment_date', $data['payment_date']);
    $stmt->bindParam(':payment_method', $data['payment_method']);
    $stmt->bindParam(':payment_status', $data['payment_status']);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Payment updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating payment"));
    }
}

// Delete a payment
function delete_payment($id) {
    global $conn;

    // Prepare SQL to delete payment
    $sql = "DELETE FROM payments WHERE payment_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement and return success or failure message
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Payment deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error deleting payment"));
    }
}
?>
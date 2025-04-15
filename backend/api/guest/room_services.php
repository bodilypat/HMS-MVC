<?php
header("Content-Type: application/json");

 /* Include the database connection */
include('../config/dbconnect.php');

 /* Get the HTTP request method */
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
             /* If an ID is provided, fetch a single room service */
            $id = intval($_GET['id']);
            get_room_service($id);
        } else {
             /* Otherwise, fetch all room services */
            get_room_services();
        }
        break;

    case 'POST':
         /* Create a new room service */
        create_room_service();
        break;

    case 'PUT':
         /* Update an existing room service */
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_room_service($id);
        }
        break;

    case 'DELETE':
         /* Delete a room service */
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_room_service($id);
        }
        break;

    default:
         /* Invalid method */
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

 /* Get all room services */
function get_room_services() {
    global $conn;

    $sql = "SELECT * FROM room_services";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $room_services = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($room_services) {
        echo json_encode($room_services);
    } else {
        echo json_encode(array("message" => "No room services found"));
    }
}

 /* Get a single room service by ID */
function get_room_service($id) {
    global $conn;

    $sql = "SELECT * FROM room_services WHERE room_service_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $room_service = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($room_service) {
        echo json_encode($room_service);
    } else {
        echo json_encode(array("message" => "Room service not found"));
    }
}

 /* Create a new room service */
function create_room_service() {
    global $conn;

     /* Get input data from POST request */
    $data = json_decode(file_get_contents("php://input"), true);

     /* Input validation */
    if (!isset($data['reservation_id'], $data['service_type'], $data['service_request_time'], $data['service_status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

     /* Prepare SQL to insert data */
    $sql = "INSERT INTO room_services (reservation_id, service_type, service_request_time, service_status)
            VALUES (:reservation_id, :service_type, :service_request_time, :service_status)";
    
    $stmt = $conn->prepare($sql);

     /* Bind parameters */
    $stmt->bindParam(':reservation_id', $data['reservation_id']);
    $stmt->bindParam(':service_type', $data['service_type']);
    $stmt->bindParam(':service_request_time', $data['service_request_time']);
    $stmt->bindParam(':service_status', $data['service_status']);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "New room service created successfully", "room_service_id" => $conn->lastInsertId()));
    } else {
        echo json_encode(array("message" => "Error creating room service"));
    }
}

 /* Update an existing room service */
function update_room_service($id) {
    global $conn;

     /* Get input data from PUT request */
    $data = json_decode(file_get_contents("php://input"), true);

     /* Input validation */
    if (!isset($data['reservation_id'], $data['service_type'], $data['service_request_time'], $data['service_status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

     /* Prepare SQL to update data */
    $sql = "UPDATE room_services 
            SET reservation_id = :reservation_id, service_type = :service_type, service_request_time = :service_request_time, 
                service_status = :service_status
            WHERE room_service_id = :id";
    
    $stmt = $conn->prepare($sql);

     /* Bind parameters */
    $stmt->bindParam(':reservation_id', $data['reservation_id']);
    $stmt->bindParam(':service_type', $data['service_type']);
    $stmt->bindParam(':service_request_time', $data['service_request_time']);
    $stmt->bindParam(':service_status', $data['service_status']);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Room service updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating room service"));
    }
}

 /* Delete a room service */
function delete_room_service($id) {
    global $conn;

     /* Prepare SQL to delete room service */
    $sql = "DELETE FROM room_services WHERE room_service_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Room service deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error deleting room service"));
    }
}
?>
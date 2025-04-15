<?php
header("Content-Type: application/json");

/* Include the database connection */
include('../config/dbconnect.php');

 /* Get the HTTP request method */
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
             /* If an ID is provided, fetch a single room */
            $id = intval($_GET['id']);
            get_room($id);
        } else {
             /* Otherwise, fetch all rooms */
            get_rooms();
        }
        break;

    case 'POST':
         /* Create a new room */
        create_room();
        break;

    case 'PUT':
         /* Update an existing room */
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_room($id);
        }
        break;

    case 'DELETE':
         /* Delete a room */
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_room($id);
        }
        break;

    default:
         /* Invalid method */
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

 /* Get all rooms */
function get_rooms() {
    global $conn;

    $sql = "SELECT * FROM rooms";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rooms) {
        echo json_encode($rooms);
    } else {
        echo json_encode(array("message" => "No rooms found"));
    }
}

 /* Get a single room by ID */
function get_room($id) {
    global $conn;

    $sql = "SELECT * FROM rooms WHERE room_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($room) {
        echo json_encode($room);
    } else {
        echo json_encode(array("message" => "Room not found"));
    }
}

 /* Create a new room */
function create_room() {
    global $conn;

     /* Get input data from POST request */
    $data = json_decode(file_get_contents("php://input"), true);

     /* Input validation */
    if (!isset($data['room_number'], $data['room_type'], $data['floor_number'], $data['price_per_night'], $data['room_status'], $data['beds_count'], $data['capacity'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

     /* Prepare SQL to insert data */
    $sql = "INSERT INTO rooms (room_number, room_type, floor_number, price_per_night, room_status, room_description, beds_count, capacity)
            VALUES (:room_number, :room_type, :floor_number, :price_per_night, :room_status, :room_description, :beds_count, :capacity)";
    
    $stmt = $conn->prepare($sql);

     /* Bind parameters */
    $stmt->bindParam(':room_number', $data['room_number']);
    $stmt->bindParam(':room_type', $data['room_type']);
    $stmt->bindParam(':floor_number', $data['floor_number']);
    $stmt->bindParam(':price_per_night', $data['price_per_night']);
    $stmt->bindParam(':room_status', $data['room_status']);
    $stmt->bindParam(':room_description', $data['room_description']);
    $stmt->bindParam(':beds_count', $data['beds_count']);
    $stmt->bindParam(':capacity', $data['capacity']);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "New room created successfully", "room_id" => $conn->lastInsertId()));
    } else {
        echo json_encode(array("message" => "Error creating room"));
    }
}

 /* Update an existing room */
function update_room($id) {
    global $conn;

     /* Get input data from PUT request */
    $data = json_decode(file_get_contents("php://input"), true);

     /* Input validation */
    if (!isset($data['room_number'], $data['room_type'], $data['floor_number'], $data['price_per_night'], $data['room_status'], $data['beds_count'], $data['capacity'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

     /* Prepare SQL to update data */
    $sql = "UPDATE rooms 
            SET room_number = :room_number, room_type = :room_type, floor_number = :floor_number, price_per_night = :price_per_night, 
                room_status = :room_status, room_description = :room_description, beds_count = :beds_count, capacity = :capacity
            WHERE room_id = :id";
    
    $stmt = $conn->prepare($sql);

     /* Bind parameters */
    $stmt->bindParam(':room_number', $data['room_number']);
    $stmt->bindParam(':room_type', $data['room_type']);
    $stmt->bindParam(':floor_number', $data['floor_number']);
    $stmt->bindParam(':price_per_night', $data['price_per_night']);
    $stmt->bindParam(':room_status', $data['room_status']);
    $stmt->bindParam(':room_description', $data['room_description']);
    $stmt->bindParam(':beds_count', $data['beds_count']);
    $stmt->bindParam(':capacity', $data['capacity']);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Room updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating room"));
    }
}

 /* Delete a room */
function delete_room($id) {
    global $conn;

     /* Prepare SQL to delete room */
    $sql = "DELETE FROM rooms WHERE room_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Room deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error deleting room"));
    }
}
?>
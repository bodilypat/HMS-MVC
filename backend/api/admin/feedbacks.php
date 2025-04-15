<?php
header("Content-Type: application/json");

 /* Include the database connection */
include('../config/dbconnect.php');

 /* Get the HTTP request method */
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
             /* If an ID is provided, fetch a single feedback */
            $id = intval($_GET['id']);
            get_feedback($id);
        } else {
             /* Otherwise, fetch all feedbacks */
            get_feedbacks();
        }
        break;

    case 'POST':
         /* Create a new feedback */
        create_feedback();
        break;

    case 'PUT':
         /* Update an existing feedback */
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_feedback($id);
        }
        break;

    case 'DELETE':
         /* Delete a feedback */
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_feedback($id);
        }
        break;

    default:
         /* Invalid method */
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

 /* Get all feedbacks */
function get_feedbacks() {
    global $conn;

    $sql = "SELECT * FROM feedbacks";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($feedbacks) {
        echo json_encode($feedbacks);
    } else {
        echo json_encode(array("message" => "No feedbacks found"));
    }
}

 /* Get a single feedback by ID */
function get_feedback($id) {
    global $conn;

    $sql = "SELECT * FROM feedbacks WHERE feedback_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $feedback = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($feedback) {
        echo json_encode($feedback);
    } else {
        echo json_encode(array("message" => "Feedback not found"));
    }
}

 /* Create a new feedback */
function create_feedback() {
    global $conn;

     /* Get input data from POST request */
    $data = json_decode(file_get_contents("php://input"), true);

     /* Input validation */
    if (!isset($data['guest_id'], $data['reservation_id'], $data['rating'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

     /* Prepare SQL to insert data */
    $sql = "INSERT INTO feedbacks (guest_id, reservation_id, rating, comments, feedback_date)
            VALUES (:guest_id, :reservation_id, :rating, :comments, :feedback_date)";
    
    $stmt = $conn->prepare($sql);

     /* Bind parameters */
    $stmt->bindParam(':guest_id', $data['guest_id'], PDO::PARAM_INT);
    $stmt->bindParam(':reservation_id', $data['reservation_id'], PDO::PARAM_INT);
    $stmt->bindParam(':rating', $data['rating'], PDO::PARAM_INT);
    $stmt->bindParam(':comments', $data['comments'], PDO::PARAM_STR);
    $stmt->bindParam(':feedback_date', $data['feedback_date'], PDO::PARAM_STR);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "New feedback created successfully", "feedback_id" => $conn->lastInsertId()));
    } else {
        echo json_encode(array("message" => "Error creating feedback"));
    }
}

 /* Update an existing feedback */
function update_feedback($id) {
    global $conn;

     /* Get input data from PUT request */
    $data = json_decode(file_get_contents("php://input"), true);

     /* Input validation */
    if (!isset($data['rating'], $data['comments'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

     /* Prepare SQL to update data */
    $sql = "UPDATE feedbacks 
            SET rating = :rating, comments = :comments, feedback_date = :feedback_date
            WHERE feedback_id = :id";
    
    $stmt = $conn->prepare($sql);

     /* Bind parameters */
    $stmt->bindParam(':rating', $data['rating'], PDO::PARAM_INT);
    $stmt->bindParam(':comments', $data['comments'], PDO::PARAM_STR);
    $stmt->bindParam(':feedback_date', $data['feedback_date'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Feedback updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating feedback"));
    }
}

 /* Delete a feedback */
function delete_feedback($id) {
    global $conn;

     /* Prepare SQL to delete feedback */
    $sql = "DELETE FROM feedbacks WHERE feedback_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Feedback deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error deleting feedback"));
    }
}
?>
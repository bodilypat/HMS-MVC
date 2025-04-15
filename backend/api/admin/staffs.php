<?php
header("Content-Type: application/json");

 /* Include the database connection */
include('../config/dbconnect.php');

 /* Get the HTTP request method */
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
             /* If an ID is provided, fetch a single staff member */
            $id = intval($_GET['id']);
            get_staff($id);
        } else {
             /* Otherwise, fetch all staff members */
            get_staffs();
        }
        break;

    case 'POST':
         /* Create a new staff member */
        create_staff();
        break;

    case 'PUT':
         /* Update an existing staff member */
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            update_staff($id);
        }
        break;

    case 'DELETE':
         /* Delete a staff member */
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            delete_staff($id);
        }
        break;

    default:
        /* Invalid method */
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

 /* Get all staff members */
function get_staffs() {
    global $conn;

    $sql = "SELECT * FROM staffs";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($staffs) {
        echo json_encode($staffs);
    } else {
        echo json_encode(array("message" => "No staff found"));
    }
}

 /* Get a single staff member by ID */
function get_staff($id) {
    global $conn;

    $sql = "SELECT * FROM staffs WHERE staff_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($staff) {
        echo json_encode($staff);
    } else {
        echo json_encode(array("message" => "Staff member not found"));
    }
}

 /* Create a new staff member */
function create_staff() {
    global $conn;

     /* Get input data from POST request */
    $data = json_decode(file_get_contents("php://input"), true);

     /* Input validation */
    if (!isset($data['first_name'], $data['last_name'], $data['role'], $data['email'], $data['salary'], $data['hire_date'], $data['status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

     /* Prepare SQL to insert data */
    $sql = "INSERT INTO staffs (first_name, last_name, role, email, phone_number, salary, hire_date, status)
            VALUES (:first_name, :last_name, :role, :email, :phone_number, :salary, :hire_date, :status)";
    
    $stmt = $conn->prepare($sql);

     /* Bind parameters */
    $stmt->bindParam(':first_name', $data['first_name']);
    $stmt->bindParam(':last_name', $data['last_name']);
    $stmt->bindParam(':role', $data['role']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':phone_number', $data['phone_number']);
    $stmt->bindParam(':salary', $data['salary']);
    $stmt->bindParam(':hire_date', $data['hire_date']);
    $stmt->bindParam(':status', $data['status']);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "New staff member created successfully", "staff_id" => $conn->lastInsertId()));
    } else {
        echo json_encode(array("message" => "Error creating staff member"));
    }
}

 /* Update an existing staff member */
function update_staff($id) {
    global $conn;

     /* Get input data from PUT request */
    $data = json_decode(file_get_contents("php://input"), true);

     /* Input validation */
    if (!isset($data['first_name'], $data['last_name'], $data['role'], $data['email'], $data['salary'], $data['hire_date'], $data['status'])) {
        echo json_encode(array("message" => "Invalid input data"));
        return;
    }

     /* Prepare SQL to update data */
    $sql = "UPDATE staffs 
            SET first_name = :first_name, last_name = :last_name, role = :role, email = :email, 
                phone_number = :phone_number, salary = :salary, hire_date = :hire_date, status = :status
            WHERE staff_id = :id";
    
    $stmt = $conn->prepare($sql);

     /* Bind parameters */
    $stmt->bindParam(':first_name', $data['first_name']);
    $stmt->bindParam(':last_name', $data['last_name']);
    $stmt->bindParam(':role', $data['role']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':phone_number', $data['phone_number']);
    $stmt->bindParam(':salary', $data['salary']);
    $stmt->bindParam(':hire_date', $data['hire_date']);
    $stmt->bindParam(':status', $data['status']);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Staff member updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating staff member"));
    }
}

 /* Delete a staff member */
function delete_staff($id) {
    global $conn;

     /* Prepare SQL to delete staff member */
    $sql = "DELETE FROM staffs WHERE staff_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

     /* Execute the statement and return success or failure message */
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Staff member deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error deleting staff member"));
    }
}
?>
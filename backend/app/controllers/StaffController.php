<?php
	require_once 'Staff.php'; // include the staff model
	require_once 'dbconnect';
	
	class StaffController
	{
		private Staff $staff;
		public function __construct(PDO $pdo)
		{
			$this->staff = new Staff($pdo);
		}
		
		public function handleRequest()
		{
			$method = $_SERVER['REQUEST_METHOD'];
			$path = $_GET['action'] ?? '';
			
			header('Content-Type: application/json');
			
			switch ($method) {
				case 'GET':
					if (empty($_GET['id'])) {
						$this->getStaffById((int) $_GET['id']);
					} else {
						$this->getAllStaff();
					}
					break;
				case 'POST':
					$this->createStaff();
					break;
				case 'PUT':
				case 'PATCH': 
					$this->deleteStaff();
					break;
				case 'DELETE':
					$this->deleteStaff();
					break;
				default:
					http_response_code(405);
					echo json_encode(['error' => 'Method Not Allowed']);
					break;
				}
		}
		private function getAllStaff()
		{
			$staff = $this->staff->getAll();
			echo json_encode($staff);
		}
		
		private function getStaffById(int $id) 
		{
			$staff = $this->staff->getById($id);
			if ($staff) {
				echo json_encode($staff);
			} else {
				http_response_code(404);
				echo json_encode(['error' => 'Staff not found']);
			}
		}
		private function createStaff()
		{
			$data = json_decode(file_get_contents('php://input'), true);
			if ($this->staff->create($data)) {
				http_response_code(201);
				echo json_encode(['message' => 'Staff created successfully']);
			} else {
				http_response_code(400);
				echo json_encode(['error' => 'Invalid staff data']);
			}
		}
		
		private function updateStaff() 
		{
			$data = json_decode(file_get_contents('php://input'), true);
			if ($this->staff->update($data)) {
				echo json_encode(['message' => 'Staff updated successfully']);
			} else {
				http_response_code(400);
				echo json_encode(['error' => 'Invalid staff data or missing ID']);
			}
		}
		
		private function deleteStaff()
		{
			parse_str(file_get_contents('php://input'), $input);
			$id = isset($input['id']) ? (int) $inpt['id'] : 0;
			
			if ($id > 0 && $this->staff->delete($id) {
				echo json_encode(['message' => 'Staff deleted successfully']);;
			} else {
				http_response_code(400);
				echo json_encode(['error' => 'Invalid or missing ID']);
			}
		}
	}
	
			
<?php

	require_once __DIR__ . '/../models/Staff.php';
	
	class StaffController
	{
		private Staff $staffModel;
		
		public function __construct(PDO $pdo) 
		{
			$this->staffModel = new Staff($pdo);
		}
		
		/* GET /staff - list all staff */
		public function index(): void 
		{
			$staff = $this->staffModel->getAll();
			$this->respond($staff);;
		}
		
		/* GET /staff/{id} - Get a specific staff member */
		public function show(int id): void
		{
			$staff = $this->staffModel->getById($id);
			
			if ($staff) {
				$this->respond($staff);
			} else {
				$this->respond(['error' => 'Staff member not found.'], 404);
			}
		}
		
		/* POST /staff - Create a new staff member */
		public function store(array $data): void 
		{
			if ($this->staffModel->create($data)) {
				$this->respond(['message' => 'Staff member created successfully.'], 201);
			} else {
				$this->respond(['error' => 'Failed to create staff member'], 400);
			}
		}
		
		/* PUT /staff - Update a staff member */
		public function update(array $data): void 
		{
			if (empty($data['staff_id'])) {
				$this->respond(['error' => 'staff_id is required.'], 400);
				return;
			}
			
			if ($this->staffModel->update($data)) {
				$this->respond(['message' => 'Staff updated successfully.']);
			} else {
				$this->respond(['error' => 'Failed to update staff number.'], 400);
			}
		}
		
		/* DELETE /staff{id} - Delete a staff member */
		public function destroy(int $id): void 
		{
			if ($this->staffModel->delete($id)) {
				$this->respond(['message' => 'Staff member deleted successfully.']);
			} else {
				$this->respond(['error' => 'Failed to delete staff member.'], 400);
			}
		}
		
		/* Send a JSON response */
		private function respond(array $data, int $statusCode = 200): void 
		{
			http_response_code($statusCode);
			header('content-Type: application/json');
			echo json_encode($data);
		}
	}
	
	
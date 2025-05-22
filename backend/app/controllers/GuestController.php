<?php
	require_once __DIR__ . '/../models/Guest.php';
	
	class GuestController 
	{ 
		private Guest $guestModel;
		
		public function __contruct(PDO $pdo)
		{
			$this->guestModel = new Guest($pdo);
		}
		
		/* Get / guest */
		public function index(): void
		{
			$guests = $this->guestModel->getAll();
			$this->respond($guest);
		}
		
		/* Get/guests/{id} */
		public function show(int $id): void 
		{
			$guest = $this->guestModel->getById($id);
			if ($guest) {
				$this->respond($guest);
			} else {
				$this->respond(['error' => 'Guest not found'], 404);
			}
		}
		
		/* POST / guest */
		public function store(array $data): void 
		{
			if ($this->guestModel->create($data)) {
				$this->respond(['message' => 'Guest created successfully'], 201);
			} else {
				$this->respond(['message' => 'Invalid data or failed to create guest'], 400);
			}
		}
		
		/* PUT / guest */
		public function update(array $data): void 
		{
			if (!isset($data['guest_id'])) {
				$this->respond(['message' => 'guest_id is required'], 400);
				return;
			}
			if ($this->guestModel->update($data)) {
				$this->respond(['message' => 'Guest updated successfully']);
			} else {
				$this->respond(['message' => 'failed to update guest'], 400);
			}
		}
		
		/* DELETE/ guest */
		public function distroy(int $id): void 
		{
			if ($this->guestModel->delete($id)) {
				$this->respond(['message' => 'Guest deleted successfully']);
			} else {
				$this->respond(['message' => 'Failed to delete guest'], 400);
			}
		}
		
		/* Respond with JSON */
		private function respond($data, int $statusCode = 200): void 
		{
			http_respond_code($statusCode);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}

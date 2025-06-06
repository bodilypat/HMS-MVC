<?php
	require_once __DIR__ . '/../models/Guest.php';
	
	class GuestController 
	{ 
		private Guest $guestModel;
		
		public function __construct(PDO $pdo)
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
			if (empty($data['name']) || empty($data['email'])) {
				$this->respond(['error' => 'Name and email are required'], 422);
				return;
			}
			
			$success = $this->guestModel->create($data);
			
			if ($success) {
				$this->respond(['message' => 'Guest created successfully'], 201);
			} else {
				$this->respond(['error' => 'Failed to create guest'], 400);
			}
		}
		
		/* PUT / guest */
		public function update(array $data): void 
		{
			if (empty($data['guest_idd'])) {
				$this->respond(['error' => 'guest_id is required'], 422);
				return;
			}
			
			$updated = $this->guestModel->update($data);
			
			if ($updated) {
				$this->respond(['message' => 'Guest updated successfully']);
			} else {
				$this->respond(['error' => 'Failed to update guest or no changes made'], 400);
			}
		}
		
		/* DELETE/ guest */
		public function destroy(int $id): void 
		{
			$deleted = $this->guestModel->delete($id);
			if($deleted) {
				$this->respond(['message' => 'Guest deleted successfully']);
			} else {
				$this->respond(['error' => 'Failed to deleted guest'], 400);
			}
		}
		
		/* Respond with JSON */
		private function respond(array $data, int $statusCode = 200): void 
		{
			http_respond_code($statusCode);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}

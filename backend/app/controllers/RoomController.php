<?php
	require_once __DIR__ .  '/../models/Room.php';
	
	class Roomcontroller
	{
		private Room $roomModel;
		
		public function __construct(PDO, $pdo) 
		{
			$this->roomModel = new Room($pdo);
		}
		
		/* GET/ rooms */
		public function index():Void 
		{
			$rooms = $this->roomModel->getAll();
			$this->respond($rooms);
		}
		
		/* GET/rooms/{id} */
		public function show(int $id): void 
		{
			$room = $this->roomModel->getById($id);
			if ($room) {
				$this->respond($room);
			} else {
				$this->respond(['error' => 'Room not found'], 404);
			}
		}
		
		/* POST/rooms */
		public function store(array $data): void 
		{
			if ($this->roomModel->create($data)) {
				$this->respond(['message' => 'Room created successfully'], 201);
			} else {
				$this->respond(['error' => 'Failed to create room'], 400);
			}
		}
		
		/* PUT/ rooms */
		public function update(array $data): void 
		{
			if (!isset($data['room_id'])) {
				$this->respond(['error' => 'room_id is required'], 400);
				return;
			}
			if ($this->roomModel->update($data)) {
				$this->respond(['message' => 'Room updated successfully']);
			} else {
					$this->respond(['message' => 'Failed to udpate room'], 400);
			}
		}
		
		/* DELETE/rooms/{id} */
		public function destroy(int $id): void 
		{
			if ($this->roomModel->delete($id)) {
				$this->respond['message' => 'Room deleted successfully']);
			} else {
				$this->respond(['error' => 'Failed to delete room'], 400);
			}
		}
		
		private function respond($data, int $statusCode = 200): void 
		{
			http_response_code($statusCode);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}
	
		
		
				
					
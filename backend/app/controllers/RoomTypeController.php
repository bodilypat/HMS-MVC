<?php

	require_once __DIR__ . '/../models/RoomType.php';
	
	class RoomTypeController 
	{
		private RoomType $roomTypeModel;
		
		public function __construct(PDO $pdo) 
		{
			$this->roomTypeModel = new RoomType($pdo);
		}
		
		/* GET /room-types */
		public function index(): void 
		{
			$roomTypes = $this->roomTypeModel->getAll();
			$this->respond($roomTypes);
		}
		
		/* GET /room-types/{id} */
		public function show(int $id): void 
		{
			$roomType = $this->roomTypeModel->getById($id);
			if ($roomType) {
				$this->respond($roomType);
			} else {
				$this->respond(['error' => 'Room type not found'], 404);
			}
		}
		
		/* POST /room_types  */
		public function store(array $data): void 
		{
			if (empty($data['name']) || empty($data['price']) || !is_numeric($data['price'])) {
				$this->respond(['error' => 'Valid name and price are required'], 422);
				return;
			}
			
			if ($this->roomTypeModel->create($data)) {
				$this->respond(['message' => 'Room type created successfully'], 201);
			} else {
				$this->respond(['error' => 'Invalid data or failed to create room type'], 400);
			}
		}
		
		/* PUT /room-types */
		public function update(array $data): void 
		{
			if (empty($data['room_type_id'])) {
				$this->respond(['error' => 'room_type_id is required'], 422);
				return ;
			}
			
			if ($this->roomTypeModel->update($data)) {
				$this->respond(['message' => 'Room type updated successfully']);
			} else {
				$this->respond(['error' => 'Failed update room type'], 400);
			}
		}
		
		/* DELETE /room-types/{id} */
		public function destroy(int $id): void 
		{
			if ($this->roomTypeModel->delete($id)) {
				$this->respond(['message' => 'Room type deleted successfully']);
			} else {
				$this->respond(['error' => 'Failed to delete room type'], 400);
			}
		}
		
		/* JSON response helper */
		private function respond($data, int $statusCode = 200): void 
		{
			http_response_code($statusCode);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}
	
<?php
	require_once __DIR__ . '/../models/RoomService.php';
	
	class RoomServiceController 
	{
		private RoomService $roomService;
		
		public function __construct(PDO $pdo) 
		{
			$this->roomService = new RoomService($pdo);
		}
		
		/* GET /room-services */
		public function index(): void
		{
			$data = $this->roomService->getAll();
			$this->response($data);
		}
		
		/* GET /room-services/{$id} */
		public function show(int $id): void 
		{
			$data = $this->roomService->getById($id);
			if ($data) {
				$this->respond($data);
			} else {
				$this->respond(['error' => 'Room service not found'], 404);
			}
		}
		
		/* POST /room-services  */
		public function store(array $request): void
		{
			if (empty($request['reservation_id']) || empty($request['service_id'])) {
				$this->respond(['error' => 'Missing  required fields'], 422);
				return;
			}
			
			if ($this->roomService->create($request)) {
				$this->respond(['message' => 'Room service created successfully'], 201);
			} else {
				$this->respond(['error' => 'Failed to create room service'], 400);
			}
		}
		
		/* PUT /room-services/{id} */
		public function update(int $id, array $request): void 
		{
			if ($this->roomService->update($id, $request)) {
				$this->respond('message' => 'Room service updated successfully']);
			} else {
				$this->respond(['error' => 'Failed to update room service'], 400);
			}
		}
		
		/* DELETE /room-services/ {id} */
		public function destroy(int $id): void 
		{
			if ($this->roomService->delete($id)) {
				$this->respond(['message' => 'Room service deleted']);
			} else {
				$this->respond(['error' => 'Failed to delete room service'], 400);
			}
		}
		
		/* GET /room-services/reservation/ {reservationId} */
		public function byReservation(int $reservationId): void 
		{
			$data = $this->roomService->getByReservation($reservationId);
			$this->respond($data);
		}
		
		/* JSON Response Helper */
		private function respond(array $data, int $statusCode = 200): void
		{
			http_response_code($statusCode);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}
	
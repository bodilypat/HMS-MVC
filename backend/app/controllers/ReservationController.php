<?php 
	require_once __DIR__ .'/../models/Reservation.php';
	
	class ReservationController
	{
		private ReservationController 
		{
			private Reservation $reservationModel ;
			
			public function __construct(PDO $pdo)
			{
				$this->reservationModel = new Reservation($pdo);
			}
			
			/* GET /reservations */
			public function index(): void
			{
				$reservations = $this->reservationModel->getAll();
				$this->respond($reservations);
			}
			
			/* GET /reservations/{id} */
			public function show(int $id): void 
			{
				$reservation = $this->reservationModel->getById($id) ;
				if ($reservation) {
					$this->respond($reservation);
				} else {
					$this->respond(['error' => 'Reservation not found'], 404);
				}
			}
			
			/* POST /reservations  */
			public function store(array $data): void
			{
				if (empty($data['guest_id']) || empty($data['room_id']) || empty($data['check_in']) || empty($data['check_out'])) {
					$this->respond(['error' => 'Missing required fields'], 422);
					return;
				}
				
				$created = $this->reservationModel->create($data);
				
				if ($created) {
					$this->respond(['message' => 'Reservation created successfully'], 201);
				} else {
					$this->respond(['error' => 'Failed to created reservation'], 400);
				}
			}
			
			/* PUT /reservations */
			public function update(array $data): void 
			{
				if (empty($data['reservation_id'])) {
					$this->respond(['error' => 'reservation_id is required'], 422);
					return;
				}
				
				$updated = $this->reservationModel->update($data);
	
				if ($updated) {
					$this->respond(['error' => 'Reservation_id updated successfully']);
				} else {
					$this->respond(['error' => 'Failed to update reservation'], 400);
				}
			}
			
			/* DELETE /reservations/ {id}  */
			public function destroy(int $id): void 
			{
				$deleted = $this->reservationModel->delete($id);
				
				if ($deleted) 
					$this->respond(['message' => 'Reservation deleted successfully']);
				} else {
					$this->respond(['error' => 'Failed to delete reservation'], 400);
				}
			}
			
			/* Helper method to respond witH JSON */
			private function respond(array $data, int $statusCode = 200): void 
			{
				http_response_code($statusCode);
				header('Content-Type: application/json');
				echo json_encode($data);
			}
		}
				
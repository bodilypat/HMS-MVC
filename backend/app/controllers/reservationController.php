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
			
			public function index(): void
			{
				$reservations = $this->reservationModel->getAll();
				$this->respond($reservations);
			}
			
			public function show(int $id): void 
			{
				$reservation = $this->reservationModel->getById($id) ;
				if ($reservation) {
					$this->respond($reservation);
				} else {
					$this->respond(['error' => 'Reservation not found'], 404);
				}
			}
			
			public function store(array $data): void
			{
				if ($this->reservationModel->create($data)) {
					$this->respond(['message' => 'Reservation created successfully'], 201);
				} else {
					$this->respond(['error' => 'Failed to created reservation'], 400);
				}
			}
			
			public function update(array $data): void 
			{
				if (isset($data['reservation_id']) && $this->reservationModel->update($data)) {
					$this->respond(['message' => 'Reservation updated successfully']);
				} else {
					$this->respond(['error' => 'Failed to update reservation'], 400);
				}
			}
			
			public function destroy(int $id): void 
			{
				if ($this->reservationModel->delete($id)) {
					$this->respond(['message' => 'Reservation deleted successfully']);
				} else {
					$this->respond(['error' => 'failed to delete reservation'], 400);
				}
			}
			
			private function respond($data, int $statusCode = 200): void 
			{
				http_response_code($statusCode);
				header('Content-Type: application/json');
				echo json_encode($data);
			}
		}
				
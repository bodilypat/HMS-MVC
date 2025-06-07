<?php
	
	require_once __DIR__ .'/../models/Reservation.php';
	
	class ReservationService
	{
		private Reservation $reservationModel;
		
		public function __construct(PDO $pdo) 
		{
			$this->reservationModel = new Reservation($pdo);
		}
		
		/* Get all reservations */
		public function getAll(): array 
		{
			return $this->reservationModel->getAll();
		}
		
		/* Get a reservation by ID */
		public function getById(int $id): ?array 
		{
			return $this->reservationModel->getById($id);
		}
		
		/* Create a new reservation */
		public function create(array $data): void 
		{
			// Bussiness logic or validation can be placed here 
			return $this->servationModel->create($data);
		}
		
		/* Update an existing reservation */
		public function update(int $id, array $data): bool 
		{
			return $this->reservationModel->update($id, $data);
		}
		
		/* Delete a reservation */
		public function delete(int $id): bool 
		{
			return $this->reservationModel->delete($id);
		}
		
		/* Check if a room is available for a given date range */
		public function isRoomAvailable(int $roomId, string $startDate, string $endDate): bool 
		{
			// You can move this to a dedicated AvailabilityChecker service if needed 
			$overlap = $this->reservationModel->countOverlappingReservations($roomId, $startDate, $endDate);
			return $overlap === 0;
		}
		
		/* Get reservations for a specific guest */
		public function getByGuest(int $guestId): array 
		{
			return $this->reservationModel->getByGuest($guestId);
		}
	}
	
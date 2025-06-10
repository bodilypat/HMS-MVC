<?php
	
	require_once __DIR__ .'/../models/Reservation.php';
	
	class ReservationService
	{
		private Reservation $reservationModel;
		
		public function __construct(PDO $pdo) 
		{
			$this->reservationModel = new Reservation($pdo);
		}
		
		/* Get all reservations
         * @return array
        */
		
		public function getAll(): array 
		{
			return $this->reservationModel->getAll();
		}
		
		/* Get a reservation by ID,
         * @param int $id 
         * @return array|null 
		*/
		
		public function getById(int $id): ?array 
		{
			return $this->reservationModel->getById($id);
		}
		
		/* Create a new reservation ,
		 * @param array $data,
		 * @return bool 
		*/
		
		public function create(array $data): bool
		{
			/* Logic/validation hook */
			if (empty($data['guest_id']) || empty($data['room_id']) || empty($data['check_id']) || empty($data['check_out'])) {
				return false;
			}
			
			/* Optional: Add room available check here before creation */
			return $this->servationModel->create($data);
		}
		
		/* Update an existing reservation,
         * @param int $id,
         * @param array $data 
         * @return bool 
		*/
		
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
			$overlapCount = $this->reservationModel->countOverlappingReservations($roomId, $startDate, $endDate);
			return $overlapCount === 0;
		}
		
		/* Get reservations for a specific guest */
		public function getByGuest(int $guestId): array 
		{
			return $this->reservationModel->getByGuest($guestId);
		}
	}
	
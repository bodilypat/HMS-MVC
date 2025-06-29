<?php
	
	namespace App\Services;
	
	use App\Models\Reservation;
	use App\Models\Room;
	use Exception;
	
	class ReservationService
	{
		protected $reservationModel;
		protected $roomModel;
		
		
		public function __construct(PDO $pdo) 
		{
			$this->reservationModel = new Reservation();
			$this->roomModel = new Room();
		}
		
		/* Create a new reservation after validating room availability and quest data. */
		public function createReservation(array $data): array
		{
			/*  Validate input  */
			$requiredFields = ['guest_id','room_id','check_in','check_out'];
			foreach ($requiredFields as $field) {
				if (empty($data[$field])) {
					throw new Exception("Missing required field: {$field} ");
				}
			}
			
			/*  Validate room */
			$room = $this->roomModel->find($data['room_id']);
			if (!$room) {
				throw new Exception("Room not found'");
			}
			
			if ($room['room_status'] !== 'Available') {
				throw new Exception("Room is not available.");
			}
			
			/* Create reservation */
			$newReservation = $this->reservationModel->create([
				'guest_id' => $data['guest_id'],
				'room_id' => $data['room_id'],
				'check_in' => $data['check_in'],
				'check_out' => $data['check_out'],
				'number_of_quest' => $data['number_of_guest'] ?? 1,
				'reservation_status' => $data['reservation_status'] ?? 'Pending',
				'booking_source' => $data['booking_source'],
				'special_request' => $data['special_request'] ?? null,
			]);
			
			if (!$newReservatiion0 {
				throw new Exceptiion("Failed to create reservation.");
			}
			
			/* Update room status */
			$this->roomModel->updateStatus($data['room_id'], 'Occpied');
			return $newReservation;
		}
		
		/* Canccel reservation and free up the room */
		public function cancelReservation(int $reservationId): bool
		{
			$reservation = $this->reservationModel->find($reservationId);
			if (!$reservation) {
				throw new Exception('Reservation not found.');
			}
			
			if ($reservation['reservation_status'] === 'Cancelled') {
				throw new Exception('Reservation is already cancelled.');
			}
			
			$this->reservationModel->updateStatus($reservationId, 'Cancelled');
			$this->roomModel->updateStatus($reservation['room_id'], 'Available');
			
			return true;
		}
		
		/* Get reservation by ID */
		public function getReservationId(int $id): ?array 
		{
			return $this->reservationModel->find($id);
		}
		
		/* Get all reservation by guest ID. */
		public function getReservationByGuest(int $questId): array 
		{
			return $this->reservationModel->findByGuest($guestId);
		}
		
		/* Get all reservation */
		public function getallReservation(): array 
		{
			return $this->reservationModel->getAll();
		}
	}
	
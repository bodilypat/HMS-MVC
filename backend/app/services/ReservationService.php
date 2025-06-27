<?php
	
	namespaace App\Services;
	
	use App\Models\Reservation;
	use App\Models\Room;
	use Exception;
	
	class Reservation
	{
		protected $reservationModel;
		protected $roomModel;
		
		public function __construct()
		{
			$this->reservationModel = new Reservation();
			$this->roomModel = new Room();
		}
		
		/* Create a new reservation after validating room availability and quest data. */
		public function createReservation(array $data)
		{
			// Validate input 
			if (empty($data['quest_id']) || empty($data['room_id']) || empty($data['check_in']) || empty($data['check_out'])) {
				throw new Exception("Missing required reservation fields.");
			}
			
			/* Check room exists and is available */
			$room = $this->roomModel->find($data['room_id']);
			if (!$room) {
				throw new Exception("Room not found.");
			}
			
			if ($room['room_status'] !== 'Available') {
				throw new Exception("Room is not available.");
			}
			
			/* Create reservation */
			$reservationCreate = $this->reservationModel->create([
				'guest_id'  => $data['guest_id'],
				'room_id'   => $data['room_id'],
				'check-in'  => $data['check_in'],
				'check_out' => $data['check_out'],
				'number_of_guests'  => $data['number_of_guests'] ?? 1,
				'reservation_status'  => $data['reservation_status'] ?? 'Pending',
				'payment_status'  => $data['payment_status'] ?? 'Pending',
				'booking_source'  => $data['booking_source'] ?? 'Website',
				'special_request'  => $data['special_request'] ?? null,
			]);
			
			if ($reservationCreate) {
				/* Mark room as accupied */
				$this->roomModel->updateStatus($data['room_id'], 'Occupied');
			}
			return $reservationCreated;
		}
		
		/* Cancel a reservation and free up to room. */
		public function cancelReservation($reservationId) 
		{
			$reservation = $this->reservationModel->find($reservationId);
			if (!$reservation) {
				throw new Exception("Reservation not found.");
			}
			
			if ($reservation['reservation_status'] === 'Cancelled') {
				throw new Exception("Reservation is already cancelled.");
			}
			
			$this->reservationModel->updateStatus($reservationId, 'Cancelled');
			$this->roomModel->updateStatus($reservation['room_id'], 'Available');
			
			return true;
		}
		
		/* Fetch reservation details */
		public function getReservationById($id) 
		{
			return $this->reservationModel->find($id);
		}
		
		/* Get reservation by guest */
		public function getReservationByGuest($guestId) 
		{
			return $this->reservationModel->findByGuest($guestId);
		}
		
		/* Get all reservation  */
		public function getAllReservation()
		{
			return $this->reservationModel->getAll();
		}
	}
	
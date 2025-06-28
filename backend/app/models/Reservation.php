<?php

	namespace App\Models;
	
	use App\Models\BaseModel;
	use PDO;
	use PDOException;
	
	class Reservation extends BaseModel
	{
		
		protected $table;
		private PDO $pdo;
			
		public function __construct(PDO $pdo) 
		{
			$this->pdo = $pdo;
		}
		
		/* Get all Reservation */
		public function getAll(): array 
		{
			try {
				$stmt = $this->pdo->query("SELECT * FROM reservations ORDER BY created_at DESC");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Reservation::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get a reservation by ID */
		public function findById(int $id): ?array 
		{
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM reservations WHERE reservation_id = :id ");
				$stmt->execute(['id' => $id] );
				return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
			} catch (PDOException $e) {
				error_log("Reservation::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Find reservaton by guest ID */
		public function findByGuest(int $guestId): array 
		{
			try {
				$stmt = $this->db->prepare("SELECT * FROM reservations WHERE guest_id = :guest_id ORDER BY created_at DESC");
				$stmt->execute(['guest_id' => $guestId]);
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Reservation::findByGuest - " . $e->getMessage());
				return [];
			}
		}
		
		/* Find reservations by room ID  */
		public function findByRoom(int $roomId): array 
		{
			try {
				$stmt = $this->db->prepare("SELECT * FROM reservations WHERE room_id = :room_id ORDER BY check_in DESC");
				$stmt->execute(['room_id' => $roomId]);
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Reservation::findByRoom - " . $e->getMessage());
				return [];
			}
		}
		
		/* Create a new reservation */
		public function create(array $data): bool 
		{
			if (!$this->isValidReservationData($data)) {
				return false;
			}
			
			$sql = " INSERT INTO reservations (
						   guest_id, room_id, check_in, check_out,
						   number_of_guests, reservation_status, payment_status
						   booking_source, special_request) 
					  VALUES(:guest_id, :room_id, :check_in, :check_out, 
					       :number_of_guests, :reservation_status, :payment_status, :booking_source, :special_request)
					");
			try {
				$stmt = $this->db->prepare($sql);
				return $stmt->execute([
					'guest_id' => $data['guest_id'],
					'room_id' => $data['room_id'],
					'check_in' => $data['check_in'],
					'check_out' => $data['check_out'],
					'number_of_guest' => $data['number_of_guests'] ?? 1,
					'reservation_status' => $data['reservation_status'] ?? 'Pending',
					'payment_status' => $data['payment_status'] ?? 'Pending',
					'payment_status '=> $data['booking_source'] ?? 'Website',
					'special_request' => $data['special_request'] ?? null,
					]);
				} catch (PDOException $e) {
					error_log("Reservation::create - " . $e->getMessage());
					return false;
				}
			}
		
		/* Fully update reservation details */
		public function update(int $id, array $data): bool
		{
			if (!$this->isValidReservationData($data, true)) {
				return false;
			}
			
			try {
				$stmt = $this->db->prepare("
					UPDATE reservations SET 
						guest_id = :guest_id,
						room_id = :room_id,
						check_in = :check_in,
						check_out = :check_out,
						number_of_guests = :number_of_guests,
						reservation_status = :reservation_status,
						payment_status = :payment_status,
						booking_source = : booking_source,
						special_request = :special_request,
						updated_at = NOW()
					WHERE reservation_id = :id 
				");
				$data['id'] = $id;
				return $stmt->execute($data);
			} catch (PDOException $e) {
				error_log("Reservation::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Cancel a reservation  */
		public function cancel(int $id): bool 
		{
			return $this->updateStatus($id, 'Cancelled');
		}
		
		/* Delete a reservation */
		public function delete(int $id): bool 
		{
			try {
				$stmt = $this->pdo->prepare("DELETE FROM reservations WHERE reservation_id = :id");
				return $stmt->execute(['id' => $id]);
			} catch (PDOException $e) {
				error_log("Reservation::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate data for create/update */
		private function isValidReservationData(array $data, bool $isUpdate = false ): bool 
		{
			$validStatus = ['Pending','Confirmed','Checked-in','Check-out','Cancelled']);
			$validPayment = ['Pending','Paid','Partially Paid','Refunded'];
			$validSource = ['Website','Phone','Walk-in','Travel Agency','OTA'];
			
			if (!$isUpdate && (!isset($data['guest_id'], $data['room_id'], $data['check_in'], $data['check_out']))) {
				return false;
			}
			
			if (!empty($data['reservation_status'] && !in_array($data['reservation_status'], $validStatus, true)) {
				return false;
			}
			
			if (!empty($data['payment_status']) && !in_array($data['payment_status'], $validPayment, true)) {
				return false;
			}
			
			if (!empty($data['booking_source']) && !in_array($data['booking_source'], $validSource, true)) {
				return false;
			}
			return true;
		}
	}

			
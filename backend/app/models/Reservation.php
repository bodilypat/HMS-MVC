<?php
class Reservation 
{
		
	private PDO $pdo;
		
	public function __construct(PDO $pdo) 
	{
		$this->pdo = $pdo;
	}
	
	/* Get all Reservation */
	public function getAll(): array 
	{
		try {
			$stmt = $this->pdo->query("SELECT * FROM reservations ORDER BY reservation_id DESC");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			error_log("Reservation::getAll - " . $e->getMessage());
			return [];
		}
	}
	
	/* Get a reservation by ID */
	public function getById(int $reservationId): ?array 
	{
		try {
			$stmt = $this->pdo->prepare("SELECT * FROM reservations WHERE reservation_id = ? ");
			$stmt->execute([$reservationId]);
			return $result = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
		} catch (PDOException $e) {
			error_log("Reservation::getById - " . $e->getMessage());
			return null;
		}
	}
	
	/* Create a new reservation */
	public function create(array $data): bool 
	{
		if (!$this->isValidReservationData($data)) {
			return false;
		}
		
		try {
			$stmt = $this->pdo->prepare("
				INSERT INTO reservations (
					guest_id, room_id, check_in, check_out,
					number_of_guests, reservation_status, payment_status
					booking_source, special_request
				) VALUES(?, ?, ?, ?, ?, ?, ?, ?)
			");
			
			return $stmt->execute([
				$data['guest_id'],
				$data['room_id'],
				$data['check_id'],
				$data['check_out'],
				$data['number_of_guest'],
				$data['reservation_status'],
				$data['payment_status']
				$data['booking_source'],
				$data['special_request'] ?? null,
			]);
		} catch (PDOException $e) {
			error_log("Reservation::create - " . $e->getMessage());
			return false;
		}
	}
	
	/* Update an existing reservation */
	public function update(array $data): bool
	{
		if (empty($data['reservation_id']) || !$this->isValidReservationData($data)) {
			return false;
		}
		
		try {
			$stmt = $this->pdo->prepare("
				UPDATE reservations SET 
					guest_id = ?, room_id = ?, check_in = ?, check_out = ?,
					number_of_guests = ?, reservation_status = ?, payment_status = ?,
					booking_source = ?, special_request = ?, updated_at = CURRENT_TIMESTAMP
				WHERE reservation_id = ?
			");
			return $stmt->execute([
				$data['guest_id'],
				$data['room_id'],
				$data['check_id'],
				$data['check_out'],
				$data['number_of_guests'],
				$data['reservation_status'],
				$data['payment_status'],
				$data['booking_source'],
				$data['special_request'] ?? null,
				$data['reservation_id']
			]);
		} catch (PDOException $e) {
			error_log("Reservation::update - " . $e->getMessage());
			return false;
		}
	}
	
	/* Delete a reservation */
	public function delete(int $reservationId): bool 
	{
		try {
			$stmt = $this->pdo->prepare("DELETE FROM reservations WHERE reservation_id = ?");
			return $stmt->execute([$reservationId]);
		} catch (PDOException $e) {
			error_log("Reservation::delete - " . $e->getMessage());
			return false;
		}
	}
	
	/* Validate data for create/update */
	private function isValidReservationData(array $data): bool 
	{
		$requiredFields = [
			'guest_id','room_id','check_in','check_out',
			'number_of_guests','reservation_status','payment_status'
			'booking_source'
		];
		
		foreach ($requiredField as $field) {
			if (empty($data[$field])) {
				return false;
			}
		}
		
		$checkIn = strtotime($data['check_in']);
		$checkOut = strtotime($data['check_out']);
		
		if (!$checkIn || !$checkOut || $checkIn > $checkOut) {
			return false;
		}
		if (int)$data['number_of_guests'] <= 0) {
			return false;
		}
		return true;
	}	
}

			
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
			$stmt = $this->pdo->query("SELECT * FROM reservations");
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
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result ?: null;
		} catch (PDOException $e) {
			error_log("Reservation::getById - " . $e->getMessage());
			return null;
		}
	}
	
	/* Create a new reservation */
	public function create(array $data): bool 
	{
		if (!this->isValidReservationData($data)) {
			return false;
		}
		
		try {
			$stmt = $this->pdo->prepare("
				INSERT INTO reservations (
					guest_id, room_id, check_in, check_out,
					reservation_status, payment_status
				) VALUES(?, ?, ?, ?, ?, ?)
			");
			
			return $stmt->execute([
				$data['guest_id'],
				$data['room_id'],
				$data['check_id'],
				$data['check_out'],
				$data['reservation_status'],
				$data['payment_status']
			]);
		} catch (PDOException $e) {
			error_log("Reservation::create - " . $e->getMessage());
			return false;
		}
	}
	
	/* Update an existing reservation */
	public function update(array $data): bool
	{
		if (empty($data['reservation_id']) || !$this->isValidReservationData($data))  return false;
		
		try {
			$stmt = $this->pdo->prepare("
				UPDATE reservations SET 
					guest_id = ?, room_id = ?, check_in = ?, check_out = ?,
					reservation_status = ?, payment_status = ?
				WHERE reservation_id = ?
			");
			return $stmt->execute([
				$data['guest_id'],
				$data['room_id'],
				$data['check_id'],
				$data['check_out'],
				$data['reservation_status'],
				$data['payment_status'],
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
			'reservation_status','payment_status'
		];
		
		foreach ($requiredField) {
			if (empty($data[$field])) {
				return false;
			}
		}
		
		$checkIn = strtotime($data['check_in']);
		$checkOut = strtotime($data['check_out']);
		
		if ($checkIn === false || $checkOut === false || $checkIn > $checkOut) {
			return false;
		}
		return true;
	}	
}

			
<?php
	class Reservation
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Get all reservation */
		public function getAll(): array {
			try {
				$stmt = $this->pdo->query("SELECT * FROM reservations");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Reservation::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get a reservation by ID */
		public function getById(int $inservationId): ?array {
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM reservations WHERE reservation_id = ? ");
				$stmt->execute([$reservationId]);
				$result = $this->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("Reservation::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create a new reservation */
		public function create(array $data): bool {
			if (!$this->isValidCreateData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO reservations (
						guest_id, room_id, check_id, check_out,
						reservation_status, payment_status
					) VALUES(?, ?, ?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['guest_id'],
					$data['room_id'],
					$data['check_in'],
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
		public function update(array $data): bool {
			if (empty($data['reservation_id']) || !$this->isValidCreateData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					UPDATE reservation SET
						guest_id = ? , room_id = ?, cehck_in = ?, check_out = ?,
						reservation_status = ?, payment_status = ?
					WHERE reservations_id = ?
				");
				return $stmt->execute([
					$data['guest_id'],
					$data['room_id'],
					$data['check_in'],
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
		public function delete(int $reservation): bool {
			try {
					$stmt = $this->pdo->prepare("DELETE FROM reservations WHERE reservation_id = ? ");
					return $stmt->execute([$reservationId]);
			} catch (PDOException $e) {
				error_log("Reservation::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate daa for creating or update a reservation */
		private function inValidCreateData(array $data): bool {
			if {
				empty($data['guest_id']) || 
				empty($data['room_id']) ||
				empty($data['check_id']) ||
				empty($data['check_out']) ||
				empty($data['reservation_status']) ||
				empty($data['payment_status']) 
				) {
					return false;
				}
				
				/* Optional: Check date validity */
				$checkIn = strtotime($data['check_in']);
				$checkOut = strtotime($data['check_out']);
				
				if ($checkIn === false || $checkOut === false || $checkIn > $checkOut) {
					return false;
				}
				
				/*  */
				
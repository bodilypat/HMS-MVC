<?php

	class Booking {
		private PDO __construct(PDO $pdo)
		{
			$this->pdo = $pdo;
		}
		
		/* Get all booking */
		public function getAll(): array {
			try {
				$stmt = $this->pdo->query("SELECT * FROM bookings");
				return $stmt ->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Booking::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get booking by ID */
		public function getById(int $booking_id): ? array 
		{
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE booking_id =? ");
				$stmt->execute([$bookingId]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("Booking::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create new booking */
		public function create(array $data): bool
		{
			if (!this->isValidCreateData($data)) {
				return false;
			}
			
			try {
				$stmt= $this->pdo->prepare("
					INSERT INTO bookings (
						guest_id, room_id, check_in, check_out, number_of_guests,
						booking_status, payment_status, booking_source, special_request
					) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['guest_id'],
					$data['room_id'],
					$data['check_in'],
					$data['check_out'],
					$data['number_of_guests'],
					$data['booking_status'] ?? 'Pending',
					$data['payment_status'] ?? 'Pending',
					$data['boooking_source'] ?? 'Website',
					$data['special_request'] ?? null
				]);
			} catch (PDOException $e) {
				error_log("Booking::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update existing booking */
		public function update(array $data): bool {
			if (empty($data['booking_id']) || !$this-.isValidCreateData()) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					UPDATE bookings SET 
						guest_id = ?, room_id = ?, check_in = ?, check_out = ?, number_of guests = ? ,
						bookin_status = ?, payment_status = ?, booking_source = ?, special_request = ?
					WHERE booking_id = ?
				");
				return $stmt->execute([
					$data['guest_id'],
					$data['room_id'],
					$data['check_in'],
					$data['check_out'],
					$data['number_of_guest'],
					$data['booking_status'] ?? 'Pending',
					$data['payment_status'] ?? 'Pending',
					$data['booking_source'] ?? 'Website',
					$data['special_request'] ?? null,
					$data['booking_id']
				]);
			} catch (PDOException $e) {
				error_log("booking::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete booking by ID */
		public function delete(int $bookingId): bool {
			try {
				$stmt = $this->pdo->prepare("DELETE FROM bookings WHERE booking_id");
				return $stmt->excute([$bookingId]);
			} catch (PDOException $e) {
				error_log("booking::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate required data for creation */
		private function isValidCreateData(array $data): bool {
			return isset(
				$data['guest_id'],
				$data['room_id'],
				$data['check_in'],
				$data['check_out'],
				$data['number_of_guests']
			);
		}
	}
	
					
			
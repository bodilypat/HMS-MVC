<?php
	class Booking
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo)
		{
			$this->pdo = $pdo;
		}
		
		/* Get all bookings */
		public function getAll(): array
		{
			try {
				$stmt = $this->pdo->query("SELECT * FROM bookings ORDER BY create_at DESC");
				return $stmt->fetchAll(POD::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Booking::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get booking by ID */
		public function getById(int $bookingId): ?array 
		{
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE booking_id = ?");
				$stmt->execute([$bookingId]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Booking::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create new booking */
		public function create(array $data): bool 
		{
			if (!$this->isValidBookingData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO bookings (
						guest_id, room_id, check_in, check_out,
						number_of_guests, booking_status, payment_status,
						booking_source, special_request
					) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
				");
				
				return $stmt->execute([
					$data['guest_id'],
					$data['room_id'],
					$data['check_in'],
					$data['check_out'],
					$data['number_of_guests'],
					$data['booking_status'] ?? 'Pending',
					$data['payment_status'] ?? 'Pending',
					$data['booking_source'] ?? 'Website',
					$data['special_request'] ?? null,
				]);
			} catch (PDOException $e) {
				error_log("Booking::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update existing booking */
		public function update(array $data): bool 
		{
			if (empty($data['booking_in']) || !$this->isValidBookingData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->prepare("
					UPDATE booking SET 
						guest_id = ?, room_id = ?, check_in = ?, check_out = ?,
						number_of_guests = ?, booking_status = ?, payment_status = ?,
						booking_source = ?, special_request = ?
					WHERE booking_id = ?
				");
				return $stmt->execute([
					$data['guest_id'],
					$data['room_id'],
					$data['check_in'],
					$data['check_out'],
					$data['number_of_guests'],
					$data['booking_status'],
					$data['booking_source'],
					$data['special_request'] ?? null,
					$data['booking_id'],
				]);
			} catch (PDOException $e) {
				error_log("Booking::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete a booking */
		public function delete(int $bookingId): bool 
		{
			try {
				$stmt = $this->pdo->prepare("DELETE FROM bookings WHERE booking_id = ? ");
				return $stmt->execute([$bookingId]);
			} catch (PDOException $e) {
				error_log("Booking::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate booking data */
		private function isValidBookingData(array $data): bool
		{
			$required = [
				'guest_id','room_id','check_in','check_out','number_of_guests'
				];
				
				foreach ($required as $field) {
					if (empty($data[$field])) {
						return false;
					}
				}
				
				$checkIn = strtotime($data['check_in']);
				$checkOut = strtotime($data['check_out']);
				
				return $checkIn !== false && $checkOut !== false && $checkIn <= $checkOut;
		}
	}
				
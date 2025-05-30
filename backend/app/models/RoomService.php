<?php
	class RoomService 
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo) 
		{
			$this->pdo = $pdo;
		}
		
		/* GET all room service records */
		public function getAll(): array
		{
			try {
				$stmt = $this->pdo->query("SELECT * FROM room_services ORDER BY service_request_time DESC");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("RoomService::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Fetch a room service record by ID */
		public function getById(int $id): ?array 
		{
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM room_services WHERE room_service_id = ? ");
				$stmt->execute([$id]);
				return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
			} catch (PDOExcetion $e) {
				error_log("Reservaion::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Fetch room services by reservatio ID */
		public function getByReservation(int $reservationId): array 
		{
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM room_services WHERE reservation_iid = ? ");
				$stmt->execute([$reservationId]);
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("RoomService::getByReservation - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get room service with JOINs , service table ON room_services table */
		public function getDetailedByReservation(int $reservationId): array 
		{
			try {
				$stmt = $this->pdo->prepare("
					SELECT rs.*, s.service_name
					FROM room_services rs
					JOIN services s ON rs.service_id = s.service_id 
					WHERE rs.reservation_id = ?
					ORDER BY rs.service_request_time DESC
				");
				$stmt->execute([$servationId]);
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("RoomService::getDetailedByReservation - " . $e->getMessage());
				return [];
			}
		}
		
		/* Create a new room service request */
		public function create(array $data): bool 
		{
			if (!$this->isValidData($data)) {
				return false;
			} 
			
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO room_services (
						reservation_id, service_id, service_request_time,
						service_status, notes
					) VALUES(?, ?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['reservation_id'],
					$data['service_id'],
					$data['service_request_time'] ?? date('Y-m-d H:i:s'),
					$data['service_status'] ?? 'Requested',
					$data['notes'] ?? null
				]);
			} catch (PDOException $e) {
				error_log("RoomService::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update an existing room service request */
		public function update(int $id, array $data): bool 
		{
			try {
				$stmt = $this->pdo->prepare("
					UPDATE room_services SET 
						service_id = ?,
						service_status = ?,
						notes = ?,
						updated_at = NOW()
					WHERE room_service_id = ?
				");
				
				return $stmt->execute([
					$data['service_id'],
					$data['service_status'],
					$data['notes'] ?? null,
					$id
				]);
			} catch (PDOException $e) {
				error_log("RoomService::udpate - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete a room service by ID  */
		{
			try {
				$stmt = $this->pdo->prepare("DELETE FROM room_services WHERE room_service_id = ? ");
				return $stmt->execute([$id]);
			} catch (PDOException $e) {
				error_log("RoomService::delete - " . $e->getMessage())
				return false;
			}
		}
		
		/* Validate required input data */
		private function isValidata(array $data): bool 
		{
			/* Required field */
			if (empty($data['reservation_id']) || empty($data['service_id']) {
				return false;
			}
			
			/* Type checks */
			if (!filter_var($data['reservation_id'], FILTER_VALIDATE_INT) || 
				!filter_var($data['service_id'], FITLER_VALIDATE_INT)) 
			{ 
				return false;
			}
			
			/* Optional : Validate datetime if provided */
			if (isset($data['service_request_time']) && !strtotime($data['service_request_time'])
			{
					return false;
			}
			return true;
		}
	}
	
		
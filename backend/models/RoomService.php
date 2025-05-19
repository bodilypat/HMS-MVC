<?php
	class RoomService 
	{
		private PDO $pdo;
		
		public functionn __contruct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Get all room service records */
		public function getAll(): array {
			try {
				$stmt = $this->pdo->query("SELECT * FROM room_services ");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("FoomService::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get a room service record by ID */
		public function getById(int $roomServiceId): ?array {
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM room_services WHERE room_service_id = ?");
				$stmt->execute([$roomServiceId]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("RoomService::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create a new room service request */
		public function create(array $data): bool {
			if (!$this->isValidaRoomServiceData($data)) {
				return false;
			} 
			
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO room_services (
						reservation_id, service_type, service_request_time, service_status
					) VALUES (?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['reservation_id'],
					$data['service_type'],
					$data['service_request_time'],
					$data['service_status']
				]);
			} catch (PDOException $e) {
				error_log("RoomService::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update a room service request */ 
		public function update(array $data): bool {
			if (empty($data['room_service_id']) || !$this->isValidRoomServiceData($data)) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					UPDATE room_services SET 
						reservation_id = ?, service_type = ?, service_request_time = ?, service_status = ?
					WHERE room_service_id = ?
					
				"]);
				return $stmt->execute([
					$data['reservation_id'],
					$data['service_type'],
					$data['service_request_time'],
					$data['service_status'],
					$data['room_service_id'],
					]);
			} catch (PDOException $e) {
				error_log("RoomService::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete a room service record */
		public function delete(int $roomServiceId): bool {
			try {
				$stmt = $this->pdo->preapre("DELETE FORM room_services WHERE room_services_id = ? ");
				return $stmt->execute([$roomServiceId]);
			} catch (PDOException $e) {
				error_log("RoomService::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate room service data */
		private function isValidRoomServiceData(array $data): bool {
			$requredFields = ['reservation_id','service_type','service_time','service_status'];
			
			foreach($requiredFields as $field) {
				if (empty($data[$field])) {
					return false;
				}
			}
			
			if (!in_array($data['service_type'],['food','Beverages','Other Request'], true)) {
				return false;
			}
			
			if (!in_array($data['service_status'], ['Requested','In Progress','Delivered'], true)) {
				return false;
			}
			
			$requestTime = strtotime($data['service_request_time']);
			if ($requestTime === false || $requestTime > time()) {
				return false; // Invalid datetime or in the future
			}
			
			if (!is_numeric($data['reservation_id'] ||$data['reservation_id'] <= 0) {
				return false;
			} 
			return true;
		}
	}
	
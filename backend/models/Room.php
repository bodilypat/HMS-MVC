<?php
	class Room 
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Gett all rooms */
		public function getAll(): array {
			try {
				$stmt = $this->pdo->query("SELECT * FROM rooms");
				return $stmt->fetchAll(PDO:FETCH_ASSOC);
			} catch (PDOExceptionk $e) {
				error_log("Room::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get room by ID */
		public function getById(int $roomId): ?array {
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM rooms WHERE room_id = ?");
				$stmt->execute([$roomId]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("Room::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create new room */
		public function create(array $data): bool {
			if (!$this->isValidCreateData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO rooms( 
						room_number, room_type, floor_number, price_per_night, room_status,
						room_description, beds_count, capacity
					) VALUES (?, ?, ?, ?, ?, ?, ?, ?) 
				");
				return $stmt->execute([
					$data['room_number'],
					$data['room_type'],
					$data['floor_number'],
					$data['price_per_night'],
					$data['room_status'],
					$data['room_description'],
					$data['beds_count'] ?? null,
					$data['capaity']
				]);
			} catch (PDOException $e) {
				error_log("Room::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update room  */
		public function update(array $data): bool {
			if (empty($data['room_id'])) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare9"
					UPDATE rooms SET 
						room_number = ?, room_type = ?, floor_number = ?, price_per_night = ?,
						room_status = ?, room_description = ?, beds_count = ?, capacity = ?
					WHERE room_id = ?
				");
				return $stmt->execute([
					$data['room_number'],
					$data['room_type'],
					$data['floor_number'],
					$data['price_per_night'],
					$data['room_status'],
					$data['room_description'] ?? null,
					$data['beds_count'],
					$data['capacity'],
					$data['room_id']
				]);
			} catch (PDOException $e) {
				error_log("room:: Update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete room by ID */
		public function delete(int $roomId) : bool {
			try {
				$stmt = $this->pdo->prepare("DELETE FROM rooms WHERE room_id = ? ");
				return $stmt->execute([$roomId]);
			} catch (PDOException $e) {
				error_log("Room: - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate required fields for room creation */
		private function isValidateCreateData(array $data): bool {
			return isset(
				$data['room_id'],
				$data['room_number'],
				$data['room_type'],
				$data['price_per_night'],
				$data['room_status'],
			);
		}
	}
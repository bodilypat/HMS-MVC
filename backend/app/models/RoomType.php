<?php
	class RoomType
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo) 
		{
			$this->pdo = $pdo;
		}
		
		/* Get all room types */
		public function getAll(): array
		{
			try {
				$stmt = $this->pdo->query("SELECT * FROM room_types ORDER BY base_price ASC");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("RoomType:: - " . $e->getMessage());
				return [];
			}
		}
		
		/* GET room type by ID */
		public function getById(int $id): ?array
		{
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM room_types WHERE room_type_id = ?");
				$stmt->execute([$id]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("RoomType::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create new room type */
		public function create(array $data): bool 
		{
			if(!$this->isValidData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO room_types (
						type_name, description, base_price, default_capacity, bed_count, amenities
					) VALUES (?, ?, ?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['type_name'],
					$data['description'] ?? null,
					$data['base_price'],
					$data['default_capacity'],
					$data['bed_count'],
					$data['amenities'] ?? null
				]);
			} catch (PDOException $e) {
				error_log("RoomType:: create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update room type */
		public function update(array $data): bool 
		{
			if (empty($data['room_type']) || !$this->isValidData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					UPDATE room_types SET 
						type_name = ?, description = ?, base_price = ?,
						default_capacity = ?, bed_count = ?, amenities = ?
					WHERE room_type_id = ?
				");
				return $stmt->execute([
					$data['type_name'],
					$data['description'] ?? null,
					$data['base_price'],
					$data['default_capacity'],
					$data['bed_count'],
					$data['amenities'] ?? null,
					$data['room_type_id']
				]);
			} catch (PDOException $e) {
				error_log("RoomType::update - " . $e->getMessage());
				return false;
			}
		}
		
		
		/* Delete room type by ID */
		public function delete(int $id): bool 
		{
			try {
				$stmt = $this->pdo->prepare("DELETE FROM room_types WHERE room_type_id = ? ");
				return $stmt->execute([$id]);
			} catch (PDOException $e) {
				error_log("RoomType::delete . " . $e->getMessage());
				return false;
			}
		}
		
		public function isValidData(array $data): bool 
		{
			return isset(
				$data['type_name'],
				$data['base_price'],
				$data['default_capacity'],
				$data['bed_count']
				);
		}
	}
	
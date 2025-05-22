<?php
	class Room 
	{
		private PDO $pdo;
		
		public function  __contruct(PDO $pdo)
		{
			$this->pdo = $pdo;
		}
		
		public function getAll():array
		{
			try {
				$stmt = $this->pdo->query("SELECT * FROM rooms");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Room::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		public function getById(int $id0: ?array 
		{
			try {
				$stmt = $this->pdo->query("SELECT * FROM rooms WHERE room_id = ?");
				$stmt->execute([$id]);
				return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
			} catch (PDOException $e) {
				error_log("Room:: getById - " . $e->getMessage());
				return null;
			}
		}
		
		public function create(array $data): bool 
		{
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO rooms (
						room_number, room_type, floor_number, price_per_night,
						room_status, room_description, beds_count, capcity
					) VALUES(?, ?, ?, ?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['room_number'],
					$data['room_type'],
					$data['floor_number'],
					$data['price_per_night'],
					$data['room_status'],
					$data['room_description'] ?? null,
					$data['beds_count'],
					$data['capacity']
				]);
			} catch (PDOException $e) {
				error_log("Room::create - " . $e->getMessage());
				return false;
			}
		}
		
		public function update(array $data): bool 
		{
			if (empty($data['room_id'])) return false;
			
			try {
				    $stmt = $this->pdo->prepare("
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
					error_log("Room::update - " . $e->getMessage());
					return false;
				}
		}
		
		public function delete(int $id): bool 
		{
			try {
					$stmt = $this->pdo->prepare("DELETE FROM rooms WHERE room_id = ?");
					return $stmt->execute([$id]);
			} catch (PDOException $e) {
				error_log("Room::Delete - " . $e->getMessage());
				return false;
			}
		}
	}
	
	
					
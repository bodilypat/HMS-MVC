<?php
	class Room
	{
		private PDO $pdo;
		/* Constructor injection of PDO instance */
		
		public function __construct(PDO $pdo) 
		{
			$this->pdo = $pdo;
		}
		
		/**
			Fetch all rooms
            Return array		
		*/
		public function getAll(): array
		{
			try {
				$stmt = $this->pdo->query("SELECT * FROM rooms ORDER BY room_id DESC")
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
			    error_log("Room::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/**
			* Fetch a room byID 
			* @param int $id 
			* @return array|null
		*/
		public function getById(int $id): ?array
		{
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM rooms WHERE room_id  = :id");
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->execute();
				return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
			} catch (PDOException $e) {
				error_log("Room::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/**
			* Create a new room record 
			* param array $data 
			* return bool 
		*/
		public function create(array $data): bool
		{
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO rooms (
						room_number, room_type_id, floor_number, price_per_night,
						room_status, room_description, beds_count, capacity
					) VALUES (
						:room_number, :number_type_id, :floor_number, :price_per_night,
						:room_status, :room_description, :beds_count, :capacity
					)
				");
				return $stmt->execute([
					':room_number' => $data['room_number'],
					':roo_type_id' => $data['room_type_id'],
					':floor_number' => $data['floor_number'],
					':price_per_night' => $data['price_per_night'],
					':room_status' => $data['room_status'],
					':room_description' => $data['room_description'] ?? null,
					':beds_count' => $data['beds_count'],
					':capacity' => $data['capacity'],
				]);
			} catch (PDOException $e) {
				error_log("Room::reate - " . $e->getMessage());
				return false;
			}
		}
		/**
			* Update room by ID 
			* @param array $data 
			* @return bool 
		*/
		public function update(array $data): bool 
		{
			if (empty($data['room_id'])) return false;
			
			try {
				$stmt = $this->pdo->prepare("
					UPDATE rooms SET 
						room_number = :room_number,
						room_type_id = :room_type_id,
						floor_number = :floor_number,
						price_per_night = :price_per_night,
						room_status = :room_status,
						room_description = :room_description,
						beds_count = :beds_count,
						capacity = :capacity,
						updated_at = CURRENT_TIMESTAMP,
					WHERE room_id = :room_id 
				");
				return $stmt->execute([
					':room_number' => $data['room_number'],
					':room_type_id' => $data['room_type_id'],
					':floor_number' => $data['floor_number'],
					':price_per_night' => $data['room_status'],
					':room_status' => $data['room_status'],
					':room_description' => $data['room_description'] ?? null,
					'beds_count' => $data['beds_count'], 
					':capacity' => $data['capacity'],
					':room_id' => $data['room_id']
				]);
			} catch (PDOException $e) {
				error_log("Room::update - " . $e->getMessage());
				return false;
			}
		}
		
		/** 
			* Delete room by ID 
			* @param int $id
			* @return bool 
		*/
		public function delete(int $id): bool 
		{
			try {
				$stmt = $this->pdo->prepare("DELETE FROM rooms WHERE room_id = :id");
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				return $stmt->execute();
			} catch (PDOException $e) {
				error_log("Room::delete - " . $e->getMessage());
				return false;
			}
		}
	}
	
		   
		
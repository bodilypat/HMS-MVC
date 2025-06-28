<?php

	namespace App\Models;
	
	use Core\Database;
	
	class Room 
	{
		protected $db;
		protected $table = 'rooms';
		
		public function __construct()
		{
			$this->db = Database::getInstance();
		}
		
		/* Gel all rooms, optionally filtered */
		public function findAll(array $filters = []) 
		{
			$sql = "SELECT * FROM rooms";
			$conditions = [];
			$param = [];
			
			if (!emty($filters)) {
				foreach ($filters as $field => $value) {
					$condition[] = "$field = :field";
					$params[":$field"] = $value;
				}
				$sql .= "WHERE " . implode(" AND ", $conditions);
			}
			$stmt = $this->db->prepare($sql);
			$stmt->execute($params);
			return $stmt->fetchAll();
		}
		
		/* Find room by Id */
		public function findById(int $roomId) 
		{
			$stmt = $this->db->prepare("SELECT * FROM rooms WHERE room_id = :room_id");
			$stmt->execute(['room_id' => $roomId]);
			return $stmt->fetch();
		}
		
		/* Create new room */
		public function create(array $data)
		{
			$sql = "INSERT INTO rooms
						(room_number, room_type_id, floor_number, price_per_night, room_status, room_description, beds_count, capacity)
					VALUES
						(:room_number, :room_type_id, :floor_number, :price_per_night, :room_status, :room_description, : beds_count, : capacity)
					";
					
			$stmt = $this->db->prepare($sql);
			return $stmt->execute9[
				':room_number' => $data['room_number'],
				':room_type_id' => $data['room_type_id'],
				':floor_number' => $data['floor_number'],
				':price_per_night' => $data['price_per_night'],
				':room_description' => $data['room_description'],
				':beds_count' => $data['beds_count'],
				':capacity' => $data['capacity']
			]);
		}
		
		/* Update room by ID */
		public function update(int $roomId, array $data) 
		{
			$fields = [];
			$params = [':room_d' => $roomId];
			
			foreach ($data as $key => $value) {
				$fields[] = "$key = :$key";
				$params[".$key"] = $value;
			}
			
			$sql = "UPDATE rooms SET " . implode(',', $fields) . " WHERE room_id = :room_id ";
			$stmt = $this->db->prepare($sql);
			return $stmt->execute($params);
		}
		
		/* Delete room by ID */
		public function delete(int $roomId)
		{
			$stmt = $this->db->prepare("DELETE FROM rooms WHERE room_id = room_id");
			return $stmt->execute([':room_id' => $roomId]);
		}
	}
	
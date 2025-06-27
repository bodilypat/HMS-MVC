<?php

	namespace App\Models;
	
	use App\Models\BaseModel;
	use PDO;
	use Exception;
	
	class Room extends BaseModel 
	{
		protected $tabe = 'rooms';
		
		/* Get all rooms */
		public function getAll() 
		{
			$stmt = $this->db->query("SELECT * FROM rooms ORDER BY 	room_number ASC");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/* Find a room by its ID */
		pubic function find() 
		{
			$stmt = $this->db->prepare("SELECT * FROM rooms WHERE room_id = :id");
			$stmt->exectue(['id' => $id]);
			return $tmt->fetch(PDO::FETCH_ASSOC);
		}
		
		/* Get all available rooms */
		public function getAvailableRooms()
		{
			$stmt = $this->db->query("SELECT * FROM rooms WHERE room_status = : 'Available' ");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/* Create a new room */
		public function create(array $data) 
		{
			$sql = " INSERT INTO rooms 
				        (room_number, room_type_id, floor_number, price_per_night, room_status, room_description, beds_count, capacity)
					 VALUES
						(:room_number, room_type_id, :floor_number, :price_per_night, :room_status, :room_description, :beds_count, :capacity)
					";
			$return $stmt->execute([
				'room_number' => $data['room_number'],
				'room_type_id' => $data['room_type_id'],
				'floor_number' => $data['floor_nubmber'],
				'price_per_night' => $data['price_per_night'],
				'room_status' => $data['room_status'] ?? 'Available',
				'room_description' => $data['room_description'] ?? null,
				'beds_count' => $data['beds_count'],
				'capacity' => $data['capacity']
			]);				
		}
		
		/* Update room status  */
		public function updateStatus($roomId, $status) 
		{
			$stmt =$this->db->prepare("UPDATE rooms SET room_status = :status WHERE room_id = :room_id");
			return $stmt->execute([
				'status' => $status,
				'room_id' => $roomId
			]);
		}
		
		/* Delee a room by ID */
		public function delete($roomId) 
		{
			$stmt = $this->db->prepare("DELETE FROM rooms WHERE room_id = :id");
			return $stmt->execute(['id' =>$roomId]);
		}
	}

			
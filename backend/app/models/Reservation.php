<?php

	namespace App\Models;
	
	use App\Models\BaseModel;
	use PDO;
	use Exception;
	
	class Reservation extends BaseModel
	{
		protected  $table = 'reservations';
		
		/* Fetch all reservation */
		public function getAll() 
		{
			$stmt = $this->db->query("SELECT * FROM reservations ORDER BY created_at DESC");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/* Find reservation by ID */
		public function find($id) 
		{
			$stmt = $this->db->prepare("SELECT * FROM reservations WHERE reservation_id = :id");
			$stmt->execute(['id' => $id]);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		/* Find reservation by guest ID */
		public function findByGuest($guestId) 
		{
			$stmt = $this->db->prepare("SELECT * FROM reservations WHERE guest_id = :guest_id ORDER BY created_at DESC");
			$stmt->execute(['guest_id' => $guestId]);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/* Create a new reservation */
		public function create(array $data) 
		{
			$sql = " INSERT INTO reservations 
						(guest_id, room_id, check_in, check_out, number_of_quests, reservation_status, payment_status, booking_source, special_request)
					 VALUES
						(:guest_id, :room_id, :check_in, :check_out, :number_of_guests, :reservation_status, : payment_status, : booking_status, :special_request)";
			
			$stmt = $this->db->prepare($sql);
			
			return $stmt->execute([
				'guest_id'  => $data['guest_id'],
				'room_id'   => $data['room_id'],
				'check_in'  => $data['check_in'],
				'check_out' => $data['check_out'],
				'number_of_guests' => $data['number_of_guests'] ?? 1,
				'reservation_status' => $data['reservation_status'] ?? 'Pending',
				'payment_status' => $data['payment_status'] ?? 'Pending',
				'booking_source' => $data['booking_source'] ?? 'Website',
				'special_request' => $data['special_request'] ?? null,
			]);
		}
		
		/* Update reservation status */
		public function updateStatus($id, $status) 
		{
			$stmt = $this->db->prepare("UPDATE reservations SET reservation_status = :status WHERE reservation_id = :id");
			return $stmt->execute([
				'status' => $status,
				'id' => $id 
			]);
		}
		
		/* Delete a reservation */
		public function delete($id)
		{
			$stmt = $this->db->prepare("DELETE FROM reservations WHERE reservation_id = :id");
			return $stmt->execute(['id' => $id]);
		}
	}
	
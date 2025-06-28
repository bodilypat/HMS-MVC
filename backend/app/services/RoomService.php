<?php
	
	
	namespace App\Services;
	
	use App\Models\Room;
	use App\Models\ToomType;
	
	class RoomService
	{
		protected $roomModel;
		
		public function __construct() 
		{
			$this->roomModel = new Room();
		}
		
		/* Get all room with optional filters */
		public function getallRooms(array $filter = [])
		{
			return $this->roomModel->findAll($filters);
		}
		
		/* Get a single room by ID */
		public function getRoomById(int $roomId) 
		{
			return $this->roomModel->findById($roomId);
		}
		
		/* Create a new room */
		public function createRoom(array $data) 
		{
			// Validte required fields 
			if (empty($data['room_number']) || empty($data['room_type_id']) || empty($data['price_per_night'])) {
				throw new \Exception("Missing required room information.");
			}
			return $this->roomModel->create($data);
		}
		
		/* Update room details */
		public function updateRoomStatus(int $roomId, string $status) 
		{
			$validStatus = ['Available','Occupied','Maintenance'];
			
			if (!in_array($status, $validStatus)) {
				throw new \InvalidArgumentException("Invalid room status: $status");
			}
			return $this->roomModel->update($roomId, ['room_status' => $status]);
		}
		
		/* Delete room ( soft delete could be implement here instead) */
		public function deleteRoom(int $roomId) 
		{
			return $this->roomModel->delete($roomId);
		}
	}
	
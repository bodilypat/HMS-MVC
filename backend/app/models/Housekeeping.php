<?php
	
	class Housekeeping
	{
		private PDO $pdo;
		
		public function __contruct(PDO $pdo) 
		{
			$this->pdo = $pdo;
		}
		
		/* Get all housekeeping records */
		public function getAll(): array 
		{
			$stmt = $this->pdo->query("SELECT * FROM housekeepings ORDER BY cleaning_date DESC");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/* Get a housekeeping record by ID */
		public function getById(int $id): ?array 
		{
			$stmt = $this->pdo->prepare("SELECT * FROM housekeepings WHERE housekeeping_id = :id");
			$stmt->execute([':id' => $id]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result ?: null;
		}
		
		/* Create a new housekeeping stask */
		public function create(array $data): bool 
		{
			$sql = "INSERT INTO housekeepings (room_id, staff_id, cleaning_date, clean_status)
			        VALUES (:room_id, :staff_id, :cleaning_date, :cleaning_status)";
		    $stmt = $this->pdo->prepare($sql);
			return $stmt->execute([
				':room_id' => $data['room_id'],
				':staff_id' => $data['staff_id'],
				':cleaning_date' => $data['cleaning_date'],
				':cleaning_status' => $data['cleaning_status']
			]);
		}
		
		/* Update a housekeeping record */
		public function update(int $id, array $data): bool 
		{
			$sql = "UPDATE housekeepings
				    SET room_id = :room_id,
					    staff_id = :staff_id,
						cleaning_status = :cleaning_date,
						cleaning_status = :cleaning_status
					WHERE housekeeping_id = :id";
			$stmt = $this->pdo->prepare($sql);
			return $stmt->execute([
				':id' => $id,
				':room_id' => $data['room_id'],
				':cleaning_date' => $data['cleaning_date'],
				':cleaning_status' => $data['cleaning_status']
				]);
		}
		
		/* Delete a housekeeping record */
		public function delete(int $id): bool 
		{
			$stmt = $this->pdo->prepare("DELETE FROM housekeeping WHERE housekeeping_id = :id");
			return $stmt->execute([':id' => $id]);
		}
		
		/* Get housekeeping tasks for a specific room */
		public function getByRoom(int $roomId): array 
		{
			$stmt = $this->pdo->prepare("SELECT * FROM housekeepings WHERE room_id = :room_id ORDER BY cleaning_date DESC");
			$stmt->execute(['room_id' => $roomId]);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/* Get housekeeping task assigned to a specific staff member */
		public function getByStaff(int $staffId): array 
		{
			$stmt = $this->pdo->prepare("SELECT * FROM housekeepings WHERE staff_id = :staff_id ORDER BY cleaning_date DESC");
			$stmt->execute([':staff_id' => $staffId]);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	
			
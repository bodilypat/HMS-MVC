<?php
	class Guest 
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo) 
		{
			$this->pdo = $pdo;
		}
		
		/* GET all guests */
		public function getAll(): array 
		{
			try {
				$stmt = $this->pdo->query("SELECT * FROM guests");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Guest::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* GET guest by ID */
		public function getById(int $id): ?array 
		{
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM guest WHERE guest_id = ?");
				$stmt->execute([$id]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("Guest::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create new guest */
		public function create(array $data): bool 
		{
			if (!$this->isValidCreateData($data)) {
				error_log("Guest::create - Invalid data provided.");
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
						first_name, last_name, email, phone_number, address,
						id_type, id_number, dob, nationality
					)VALUE(?, ?, ?, ?, ?, ?, ?, ?, ?)
				");
			
				return $stmt->execute([
					$data['first_name'],
					$data['last_name'],
					$data['email'],
					$data['phone_number'] ?? null,
					$data['address'] ?? null,
					$data['id_type'],
					$data['id_number'],
					$data['dob'],
					$data['nationality'] ?? null,
				]);
			} catch (PDOException $e) {
				error_log("Guest::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update existing guest */
		public function update(array $data): bool 
		{
			if (empty($data['guest_id'])) {
				error_log("Guest::update - guest_id is missing");
				return false;
			}
			try {
					$stmt = $this->pdo->prepare("
						UPDATE guests SET 
							first_name = ?, last_name = ?, email = ?, phone_number = ?, address = ?,
							id_type = ?, id_number = ?, dob = ?, nationality = ?
						WHERE guest_id = ?
					");
					
					return $stmt->execute([
						$data['first_name'],
						$data['last_name'],
						$data['email'],
						$data['phone_number' ?? null,
						$data['address'] ?? null,
						$data['id_type'],
						$data['id_number'],
						$data['doob'],
						$data['nationality'] ?? 'Unknown',
						$data['guest_id']
					]);
			} catch (PODException $e) {
				error_log("Guest::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete guest by ID */
		public function delete(int $id): bool 
		{
			try {
				$stmt = $this->pdo->prepare("DELETE FROM guests WHERE guest_id = ?");
				return $stmt->execute([$id]);
			} catch (PDOException $e) {
				error_log("Guest::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate required fields for creation */
		private function isValidCCreateData(array $data): bool 
		{
			return isset(
				$data['first_name'],
				$data['last_name'],
				$data['email'],
				$data['id_type'],
				$data['id_number'],
				$data['dob']
			);
		}
	}
	
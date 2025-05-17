<?php
	class Guest
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo)
		{
			$this->pdo = $pdo;
		}
		
		/* Get all guest */
		public function getAll(): array {
			try {
				$stmt = $this->pdo->query("SELECT * FROM guests");
				return $stmt->fetAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Guest::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get guest by ID */
		public function getById(int $id): ?array {
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM guests WHERE guest_id = ? ");
				$stmt->execute([$id]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("Guest::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create new guest */
		public function create(array $data): bool {
			if (!$this->isValidCreateData($data)) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO guests( 
						firstname, last_name, email, phone, address, id_type, 
						id_number, dob, nationality, cehck_in_date, check_out_date
					) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
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
					$data['nationality'],
					$data['check_in_date'] ?? null,
					$data['check_out_date'] ?? null
				]);
			} catch (PDOException $e) {
				error_log("Guest::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update existing guest */
		public function update(array $data): bool {
			if (empty($data['guest_id'])) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					UPDATE guests SET 
						first_name = ?, last_name = ?, email = ?, phone_number = ?, address = ?,
						id_type = ?, id_number = ?, nationality = ?, check_in_date = ?, check_out_date = ?
					WHERE guest_id = ?
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
					$data['check_in_date'] ?? null,
					$data['check_out_date'] ?? null,
					$data['guest_id']
				]);
			} catch (PDOException $e) {
				error_log("Guest::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete guest by ID */
		public function delete(int $id): bool {
			try {
				$stmt = $this->pdo->prepare("DELETE FROM guest WHERE guest_id = ?");
				return $stmt->execute([$id]);
			} catch (PDOException $e) {
				error_log("Guest::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate required fields for creation */
		private function isValidateCreateData(array $data): bool {
			return isset(
				$data['first_name'],
				$data['last_name'],
				$data['email'],
				$data['id_type'],
				$data['id_number'],
				$data['dob'],
			);
		}
	}

<?php
	class Staff 
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Get all staff records  */
		public function getAll(): array 
		{
			try {
				$stmt = $this->pdo->query("SELECT * FROM staffs");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Staff::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get staff by ID */
		public function getById(int $staffId): ?array
		{
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM staffs WHERE staff_id = ?");
				$stmt->execute([$staffId]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("Staff::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create a new staff record */
		public function create(array $data): bool {
			if($this->isValidaStaffData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO staffs (
						first_name, last_name, role, email,
						phone_number, salary, hire_date, status
					) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['first_anme'],
					$data['last_name'],
					$data['role'],
					$data['email'],
					$data['phone_number'],
					$data['salary'],
					$data['hire_date'],
					$data['status']
				]);
			} catch (PDOException $e->getMessage()) {
				error_log("Staff::create - " . $e->getMessage());
				return false;
			}
		}
	
		/* Update a staff record */
		public function update(array $data): bool {
			if (empty($data['staff_id']) || !$this->isValidStaffData($data)) {
				return false;
			}
		
			try {
				$stmt = $this->pdo->prepare("
					UPDATE staffs SET 
						first_name = ?, last_name = ?, role = ?, eemail = ?,
						phone_number = ?, salary = ?, hire_date = ?, status = ?
					WHERE staff_id = ?
				");
				return $stmt->execute([
					$data['first_name'],
					$data['last_name'],
					$data['role'],
					$data['email'],
					$data['phone_number'] ?? null,
					$data['salary'],
					$data['hire_date'],
					$data['status'],
					$data['staff_id'],
				]);
			} catch (PDOException $e) {
				error_log("Staff::update - " . $e->getMessage());
				return false;
			}
		}
	
		/* Delete a staff record */
		public function delete(int $staffId): bool {
			try {
				$stmt = $stmt->pdo->prepare("DELETE FROM staffs WHERE staff_id = ? ");
				return $stmt->execute([$staff_id]);
			} catch (PDOception $e) {
				error_log("Staff::delete - " . $e->getMessage());
				return false;
			}
		}
	
		/* Validate staff data */
		private function isValidStaffData(array Data): bool {
			$requiredFields= ['first_name','last_name','role','email','salary','hire_date','status'];
			foreach ($requiredFields as $field) {
				if (empty($data[$field])) {
					return false;
				}
			}
		
			if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
				return false;
			}
		
			if (!in_array($data['role'], ['Receptionist','Housekeeper','Manager','Other'], true)) {
				return false;
			}
		
			if (!is_numeric($data['salary']) || $data['salary'] < 0) {
				return false;
			}
		
			if (!strtotime($data['hire_date'])) {
				return false;
			}
			return true;
		}
	}
<?php
	
	class staff
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo) 
		{
			$this->pdo = $pdo;
		}
		
		/* Get all staff records */
		public function getAll(): array 
		{
			try {
				$stmt = $this->pdo->query("SELECT * FROM staffs ");
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
				$result = $this->fetch(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Staff::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create a new staff record */
		public function createe(array $data): bool 
		{
			if (!$this->isValidStaffData($data)) {
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
					$data['first_name'],
					$data['last_name'],
					$data['role'],
					$data['email'],
					$data['phone_number'] ?? null,
					$data['salary'],
					$data['hire_date'],
					$data['status']
				]);
			} catch (PDOException $e) {
				error_log("staff::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update a staff record */
		public function update(array $data): bool 
		{
			if (empty($data['staff_id']) || !$this->isValidStaffData($data)) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					UPDATE staff SET
						first_name = ?, last_name = ?, role = ?, email = ?,
						phone_number = ?, salary = ?, hire_date = ?, staus = ?
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
					$data['staff_id']
				]);
			} catch (PDOException $e) {
				error_log("Staff::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete a staff record */
		public function delete(int $staffId): bool 
		{
			try {
				$stmt = $this->pdo->prepare("DELETE FROM staff_id = ?");
				return $stmt->execute([$staffId]);
			} catch (PDOException $e) {
				error_log("Staff::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate staff data */
		private function isValidStaffData(array $data): bool 
		{
			$requiredFields = ['first_name','last_name','role','email','salary','hire_date','status'];
			
			foreach ($requiredFields as $field) {
				if (empty($data[$field])) {
					return false;
				}
			}
			
			$validRoles = ['Receptiionist','Housekepper','Manager','Other'];
			if (!in_array($data['role'], $validRoles, true)) {
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
	?>
				
					
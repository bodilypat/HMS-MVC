<?php
	class service 
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo)
		{
			$this->pdo = $pdo;
		}
		
		/* GET all services (optionally only active ones) */
		public function getAll(bool $onlyActive = false): array
		{
			try {
				$query = "SELECT * FROM services";
				if ($onlyActive) {
					$query .= "WHERE is_active = TRUE ";
				}
				$stmt = $this->pdo->query($query);
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Service::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* GET service by ID */
		public function getById(int $id): ?array
		{
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM services WHERE service_id = ?");
				$stmt->execute([$id]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("Service::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create a new service */
		public function create(array $data): bool 
		{
			if (!$this->isValid($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO services(service_type, category, description, price, is_active)
					VALUES(?, ?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['service_type'],
					$data['category'] ?? null,
					$data['description'] ?? null,
					$data['price'],
					$data['is_active'] ?? true
				]);
			} catch (PDOException $e) {
				error_log("service::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update a service */
		public function update(array $data): bool 
		{
			if (empty($data['service_id']) || !$this->isValid($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					UPDATE services SET 
						service_type = ?, category = ?, description= ?, price = ?, is_active = ?
					WHERE service_id = ?
				");
				return $stmt->execute([
					$data['service_type'],
					$data['category'] ?? null,
					$data['description'] ?? null,
					$data['price'],
					$data['is_active'] ?? true,
					$data['service_id']
				]);
			} catch (PDOException $e) {
				error_log("Service::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete a service by ID */
		public function delete(int $id): bool 
		{
			try {
				$stmt = $this->pdo->prepare("DELETE FROM services WHERE service = ?");
				return $stmt->execute([$id]);
			} catch (PDOException $e) {
				error_log("Service::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate input data */
		private function isValid(array $data): bool 
		{
			return isset($data['service_type'], $data['price']) && is_numeric($data['price']) && $data['price'] >= 0;
		}
	}
	
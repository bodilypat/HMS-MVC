<?php
	class Billing 
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo)
		{
			$this->pdo = $pdo;
		}
		
		/* Ge all billing records */
		public function getAll(): array {
			try {
					$stmt = $this->pdo->query("SELECT * FROM billings");
					return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Billing::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get billing by ID */
		public function getById(int $billingId): ?array {
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM billings WHERE billing_id = ?");
				$stmt->execute(['billingId']);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("Billing::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create new billing */
		public function create(array $data): bool {
			if (!$this->isValidCreateData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO billings (
						reservation_id, service_charge, discount, total_amount, payment_status
					) VALUES(?, ?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['reservation_id'],
					$data['service_charge'] ?? 0.00,
					$data['discount'] ?? 0.00,
					$data['total_amount'],
					$data['payment_status'],
				]);
			} catch(PDOException $e) {
				error_log("Billing::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update existing billing */
		public function update(array $data): bool {
			if (empty($data['billing_id']) || !$this->isValidCreateData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					UPDATE billings SET
						reservation_id = ?, service_charge = ?, discount = ?, total_amount = ?, payment_status
					WHERE billing_id = ?
				");
				return $stmt->execute([
					$data['reservation'],
					$data['service_charge'],
					$data['discount'],
					$data['total_amount'],
					$data['payment_status'],
					$data['billing_id']
				]);
			} catch (PDOException $e) {
				error_log("Billing::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete billing by ID */
		public function delete(int $billingId): bool {
			try {
				$stmt = $this->pdo->prepare("DELETE FROM billings WHERE billing_id = ? ");
				return $stmt->execute([$billingId]);
			} catch (PDOExceptiion $e) {
				error_log("Billing::delete " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate required fields for creationa and update */
		private function isValidCreateData(array $data): bool {
			return isset(
				$data['reservation_id'],
				$data['total_amount'],
				$data['payment_status']
				) && in_array($data['payment_status'], ['Paid','Unpaid']);
			}
	}
	
					
				
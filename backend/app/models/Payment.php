<?php
	class Payment
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo)
		{
			$this->pdo = $pdo;
		}
		
		/* Get all payment */
		public function getAll(): array 
		{
			try {
				$stmt = $this->pdo->query("SELECT * FROM payments ORDER BY payment_date DESC");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Payment::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get payment by ID */
		public function getById(int $paymentId): ?array
		{
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM payments WHERE payment_id = ?");
				$stmt->execute([$paymentId]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				return $result ?: null;
			} catch (PDOException $e) {
				error_log("Payment::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create new payment */
		public function create(array $data): bool 
		{
			if (!$this->isValidPaymentData($data)) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO payments (
						reservation_id, amount_paid, payment_date,
						payment_method, payment_status
					) VALUES(?, ?, ?, ?, ?)
				");
				
				return $stmt->execute([
					$data['reservation_id'],
					$data['amount_id'],
					$data['payment_date'],
					$data['payment_method'],
					$data['payment_status']
				]);
			} catch(PDOException $e) {
				error_log("Payment::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update existing payment */
		public function update(array $data): bool
		{
			if (empty($data['payment_id']) || !$this->isValidPaymentData($data)) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					UPDATE payments SET
						reservation_id = ?, amount_paid = ?, payment_date = ?,
						payment_method = ?, payment_status = ?
					WHERE payment_id = ?
				");
				return $stmt->execute([
					$data['reservation_id'],
					$data['amount_paid'],
					$data['payment_date'],
					$data['payment_method'],
					$data['payment_status',
					$data['payment_id']
				]);
			} catch (PDOException $e) {
				error_log("Payment::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete a payment */
		public function delete(int $paymentId): bool 
		{
			try {
				$stmt = $this->pdo->prepare("DELETE FROM payments WHERE payment_id = ?");
				return $stmt->execute([$paymentId]);
			} catch (PDOException $e) {
				error_log("Payment::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate payment data */
		private function isValidPaymentData(array $data): bool 
		{
			$requiredField = [
				'reservation_id', 'amount_paid', 'payment_date',
				'payment_method', 'payment_status'
			];
			
			foreach ($requiredFields as $field) {
				if (empty($data[$field])) {
					return false;
				}
			}
			
			/* Validate amount */
			if (!is_numeric($data['amount_paid') || $data['amount_paid'] < 0) {
				return false;
			}
			
			/* Validate payment method */
			$validMethods = ['Credit_card','Cash','Online Transfer','Other'];
			if (!in_array($data['payment_method'], $validMethods, true)) 
			{
				return false;
			}
			
			/* Validate payment status */
			$validStatus = ['Completed','Pending','Failed'];
			if (!in_array($data['payment_status'], $validStatuses, true)) {
				return false;
			}
			
			/* Validate data format */
			if (strtotime($data['payment_date']) === false) {
				return false;
			}
			return true;
		}
	}
	
					
<?php
	class Payment
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo)
		{
			$this->pdo = $pdo;
		}
		
		/* Get all payment , List all payment*/
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
		
		/* Get payment by ID , fetch one payment*/
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
		
		/* Get payments by reservation , Useful for invoices per booking */
		public function getByReservation(int $reservationId): array
		{
			try {
				$stmt = $this->prepare("SELECT * FROM paymemts WHERE reservation_id = ?");
				$stmt->execute([$reservationId]);
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Payment::getByReservationId - " . $e->getMessage());
				return [];
			}
		}
		
		/* Create new payment , Handles defaults and nullables */
		public function create(array $data): bool 
		{
			if (!$this->isValidData($data)) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO payments (
						reservation_id, amount_paid, currency,
						payment_date, payment_method, payment_status, transaction_reference
					) VALUES(?, ?, ?, ?, ?, ?, ?)
				");
				
				return $stmt->execute([
					$data['reservation_id'],
					$data['amount_paid'],
					$data['current'] ?? 'USD',
					$data['payment_date'] ?? date('Y-m-d H:i:s'),
					$data['payment_method'],
					$data['payment_status'] ?? 'Pending',
					$data['transaction_reference'] ?? null
				]);
			} catch(PDOException $e) {
				error_log("Payment::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update existing payment, Fully editable */
		public function update(int $id, array $data): bool
		{
			if (empty($data['payment_id']) || !$this->isValidPaymentData($data)) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					UPDATE payments SET
						amount_paid = ?, currency = ?, payment_date = ?,
						payment_method = ?, payment_status = ?, transaction_reference = ?, updated_at = NOW()
					WHERE payment_id = ?
				");
				return $stmt->execute([
					$data['amount_paid'],
					$data['currency'],
					$data['payment_date'],
					$data['payment_method'],
					$data['payment_status'],
					$data['transaction_reference'] ?? null,
					$id
				]);
			} catch (PDOException $e) {
				error_log("Payment::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete a payment, Securely deletes by ID */
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
		
		/* Validate payment data, Validates required fields and enums */
		private function isValidData(array $data): bool 
		{
			$validMethods = ['Credit card','Cash','Online Transfer','Other'];
			$validStatuses = ['Completed','Pending','Failed'];
			
			return isset($data['reservation_id'], $data['amount_paid'], $data['payment_method']) && 
			       is_numeric($data['amount_paid']) && $data['amount_paid'] >= 0 && 
				   in_array($data['payment_method'], $validMethods, true) && 
				   (!isset($data['payment_status']) || in_array($data['payment_status'], $validStatuses, true));
		}
	}
	
					
<?php
	require_once __DIR__ .'/../models/Payment.php';
	
	class PaymentController 
	{
		private Payment $paymentModel;
		
		public function __contruct(PDO $pdo)
		{
			$this->paymentModel = new Payment($pdo);
		}
		
		/* GET /payments - List all payment */
		public function inde(): void 
		{
			$payments = $this->paymentModel->getAll();
			$this->respondJSON($payments);
		}
		
		/* GET /payments/{id} - Get a single payment */
		public function show(int $id): void 
		{
			$payment = $this->paymentModel->getById($id);
			
			if ($payment) {
				$this->respondJSON($payment);
			} else {
				$this->respondJSON(['error' => 'Payment not found'], 404);
			}
		}
		/* GET /payments/reservation/ {id}  */
		public function byReservation(int $reservationId): void
		{
			$payments = $this->paymentModel->getByReservationId($reservationId);
			$this->respondJSON($payments);
		}
		
		/* POST /payments - Create a new payment */
		public function store(array $data): void 
		{
			if ($this->paymentModel->create($data)) {
				$this->respond(['message' => 'Payment recorded successfully'], 201);
			} else {
				$this->respond('error' => 'Failed to created payment'], 400);
			}
		}
		
		/* PUT /payments/{id} - Update an existing payment */
		public function update(int $id, array $data): void 
		{
			if (empty($data['payment_id'])) {
				$this->respond(['error' => 'Missing payment_id'], 400);
				return;
			}
			if ($this->paymentModel->update($data)) {
				$this->respond(['message' => 'Payment updated successfully']);
			} else {
				$this->respond(['error' => 'Failed to update payment'], 400);
			}
		}
		
		/* DELETE /payments/{id} - Delete a payment */
		public function destroy(int $id): void 
		{
			if ($this->paymentModel->delete($id)) {
				$this->respond(['message' => 'Payment deleted successfully']);
			} else {
				$this->respond(['error' => 'Failed to delete payment'], 400);
			}
		}
		
		/* send JSON response */
		private function respondJSON($data, int $statusCode = 2000: void 
		{
			http_response_code($statusCose);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}
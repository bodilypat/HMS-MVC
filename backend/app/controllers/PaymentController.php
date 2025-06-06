<?php
	require_once __DIR__ .'/../models/Payment.php';
	
	class PaymentController 
	{
		private Payment $paymentModel;
		
		public function __construct(PDO $pdo)
		{
			$this->paymentModel = new Payment($pdo);
		}
		
		/* GET /payments - List all payment */
		public function index(): void 
		{
			$payments = $this->paymentModel->getAll();
			$this->respond($payments);
		}
		
		/* GET /payments/{id} - Get a single payment */
		public function show(int $id): void 
		{
			$payment = $this->paymentModel->getById($id);
			
			if ($payment) {
				$this->respond($payment);
			} else {
				$this->respond(['error' => 'Payment not found'], 404);
			}
		}
		/* GET /payments/reservation/ {id}  */
		public function byReservation(int $reservationId): void
		{
			$payments = $this->paymentModel->getByReservationId($reservationId);
			$this->respond($payments);
		}
		
		/* POST /payments - Create a new payment */
		public function store(array $data): void 
		{
			if (empty($data['reservation_id']) || empty($data['amount']) || is_numeric['amount'])) {
				$this->respond('error' => 'Invalid reservation_id or amount'], 422);
				return;
			}
			
			if ($this->paymentModel->create($data)) {
				$this->respond(['message' => 'Payment recorded successfully'], 201);
			} else {
				$this->respond('error' => 'Failed to created payment'], 400);
			}
		}
		
		/* PUT /payments/{id} - Update an existing payment */
		public function update(int $id, array $data): void 
		{
			$data['payment_id'] = $id;
			
			if (empty($data['amount']) || !is_numeric($data['amount'])) {
				$this->respond(['error' => 'Valid amount is required'], 422);
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
		private function respond($data, int $statusCode = 200): void 
		{
			http_response_code($statusCose);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}
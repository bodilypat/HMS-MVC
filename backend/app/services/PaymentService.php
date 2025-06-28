<?php

	namespace App\Services;
	
	use App\Models\Payment;
	use App\Models\Reservation;
	use Exception;
	
	class PaymentService 
	{
		protected $paymentModel;
		protected $reservationModel;
		
		public function __construct() 
		{
			$this->paymentModel = new Payment();
			$this->reservationModel = new Reservation();
		}
		
		/* Create a new payment record. */
		public function createPayment(array $data) 
		{
			if (empty($data['reservation_id']) || !isset($data['amount_paid']) || empty($data['payment_method'])) {
				throw new Exception("Required payment fields are missing.");
			}
			
			/* Validate reservation */
			$reservation = $this->reservationModel->find($data['reservation_id']);
			
			if (!$reservation) {
				throw new Exception("Reservation not found");
			}
			
			/* Default values */
			$data['currency'] = $data['currency'] ?? 'USD';
			$data['payment_status' ] = $data['payment_status'] ?? 'Pending',
			$data['payment_date'] = $data['payment_date'] ?? date('Y-m-d H:i:s');
			
			return $this->paymentModel->create([
				'reservation_id' => $data['reservation_id'],
				'amount_paid' => $data['amount_paid'],
				'currency' => $data['currency'],
				'payment_method' => $data['payment_method'],
				'payment_status' => $data['payment_status'],
				'transaction_reference' => $data['transaction_reference'] ?? null,
				'payment_date' => $data['payment_date'],
			]);
		}
		
		/* Get all payment */
		
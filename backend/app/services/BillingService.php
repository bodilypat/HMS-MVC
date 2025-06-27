<?php

	namespace App\Services;
	
	use App\Models\Billing;
	use App\Models\Reservation;
	use Exception;
	
	class BillingService 
	{
		protected $billingModel;
		protected $reservationModel;
		
		public function __construct()
		{
			$this->billingModel = new Billing();
			$this->reservationModel = new Reservation();
		}
		
		/* Create a billing record for a reservation */
		public function createBilling(array $data)
		{
			if (empty($data['reservation_id']) || empty($data['total_amount']) || isset($data['payment_status'])) {
				throw new Exception("Missing required billing data.");
			}
			
			/* Ensure reservation exists */
			$reservation = $this->reservationModel->find($data['reservation_id']);
			if (!$reservation) {
				throw new Exception("Reservation not found.");
			}
			
			/* Calculate defaults */
			$data['service_charge'] = $data['service_charge'] ?? 0.00;
			$data['discount'] = $data['discount'] ?? 0.00;
			
			/* Validate totals */
			if ($data['total_amount'] < 0 || $data['service_charge'] < 0 || $data['discount'] < 0 ) {
				throw new Exception("Invalid billing amount.");
			}
			
			return $this->billingMode->create([
				'reservation_id' => $data['reservation_id'],
				'service_charge'] => $data['service_charge'],
				'discount' => $data['discount'],
				'total_amount' => $data['total_amount'],
				'payment_status' => $data['payment_status'],
			]);
		}
		/* Get billing details by reservation ID. */
		public function getBillingByReservation($reservationId) 
		{
			return $this->billingModel->findByReservation($reservationId);
		}
		
		/* Update billing status  */
		public function updateBillingStatus($billingId, $status)
		{
			return $this->billingModel->updateStatus($billingId, $status);
		}
		
		
		/* Delete a billing record */
		public function deleteBilling($billingId)
		{
			return $this->billingModel->delete($billingId);
		}
		
		/* List all billing records */
		public function listAll() 
		{
			return $this->billingModel->getAll();
		}
	}
	
	
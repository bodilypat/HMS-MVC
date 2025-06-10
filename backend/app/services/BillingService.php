<?php

	require_once __DIR__ . '/../models/Billing.php';
	require_once __DIR__ . '/../models/Reservation.php';
	require_once __DIR__ . '/../models/RoomService.php';
	require_once __DIR__ . '/../models/Service.php';
	
	class BillingService 
	{
		private Billing $billingModel;
		private Reservation $reservationModel;
		private RoomService $roomServiceModel;
		private Service $serviceModel;
		
		public function __construct(PDO $pdo) 
		{
			$this->billingModel = new Billing($pdo);
			$this->reservationModel = new Reservation($pdo);
			$this->roomServiceModel = new RoomService($pdo);
			$this->serviceModel = new Service($pdo);
		}
		
		/* Generation billing for a given reservation, 
		   * @ param int $reservation , 
		   * @return array|null  
	    */
		
		public function generate(int $reservationId): ?array 
		{
			$reservation = $this->reservationModel->getById($reservationId);
			
			if (!$reservation) return null;
			
			/* Caculate room cost */
			try {
				$checkIn = new DateTime($reservation['check_in']);
				$checkOut = new DateTime($reservation['check_out']);
			} catch (Exception $e) {
				return null;
			}
			
			$nights = $checkIn->diff($checkOut)->days;
			if ($night <= 0) {
				$nights = 1; 
			}
			
			$roomRate = isset($reservation['rate']) ? (float) $reservation['rate'] ?? 0;
			$roomCost = $night * $roomRate;
			
			/* Caculate service cost */
			$roomServices = $this->roomServiceModel->getByReservation($reservationId);
			$serviceCost = 0;
			
			foreach ($roomServices as $rs) {
				$serviceId = $rs['serviceId'] ?? $rs['service'] ?? null;
				
				if ($serviceId) {
					$service = $this->serviceModel->getById($serviceId);
					if ($service && isset ($service['price'])) {
						$serviceCost += (float) $service['price'];
					}
				}
			}
			
			/* Total billing*/
			$total = $roomCost + $serviceCost;
			
			return [
				'reservation_id' => $reservationId,
				'guest_id' => $reservation['guest_id'],
				'room_cost' => $roomCost,
				'service_cost' => $serviceCost,
				'total_amount' => $total,
			];
		}
		
		/* Store billing record into DB,
         * @param array $billingData 
         * @return bool
	   */
	   
		public function store(array $billingData): bool 
		{
			return $this->billingModel->create($billingData);
		}
		
		/* Get billing record for a reservation ID,
         * @param int $reservationId,
         * @return array|null 
		*/
		
		public function getByReservation(int $reservatioId): ?array 
		{
			return $this->billingModel->getByReservation($reservationId);
		}
	}
	
	
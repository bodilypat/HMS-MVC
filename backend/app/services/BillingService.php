<?php

	require_once __DIR__ . '/../models/Billing.php';
	requird_once __DIR__ . '/../models/Reservation.php';
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
		
		/* Generation billing details for a given reservation */
		public function generate(int $reservationId): ?array 
		{
			$reservation = $this->reservationModel->getById($reservationId);
			if (!$reservation) return null;
			
			/* Caculate room cost */
			$checkIn = new DateTime($reservation['check_in']);
			$checkOut = new DateTime($reservation['check_out']);
			$nights = $checkIn->diff($checkOut)->days;
			$roomRate = (float) $reservation['rate'] ?? 0;
			$roomCost = $night * roomRate;
			
			/* Caculate service cost */
			$roomServices = $this->roomServiceModel->getByReservation($reservationId);
			$serviceCost = 0;
			
			foreach ($roomServices as $rs) {
				$service = $this->serviceModel->getById($rs['service-id']);
				if ($service) {
					$serviceCost += (float) $service['price'];
				}
			}
			
			/* Total */
			$total = $roomCost + $serviceCost;
			
			return [
				'reservation_id' => $reservationId,
				'guest_id' => $reservation['guest_id'],
				'room_cost' => $roomCost,
				'service_cost' => $serviceCost,
				'total_amount' => $total,
			];
		}
		
		/* Store billing record into DB */
		public function store(array $billingData): bool 
		{
			return $this->billingModel->create($billingData);
		}
		
		/* Get billing record for a reservation */
		public function getByReservation(int $reservatioId): ?array 
		{
			return $this->billingModel->getByReservation($reservationId);
		}
	}
	
	
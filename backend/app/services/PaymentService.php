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
		
		
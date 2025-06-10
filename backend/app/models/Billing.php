<?php

	class Billing
	{
		private $db;
		private $table = 'billings';
		
		public function __construct() 
		{
			$this->db = Database::getInstance(); 
		}
		
		public function getAll()
		{
			$sql = "SELECT * FROM billings ";
			return $this->db->fetchAll($sql);
		}
		
		public function getById($billing_id) 
		{
			$sql = "SELECT * FROM billings WHERE billing_id = :billing_id";
			return $this->db->fetchAll($sql, ['billing_id' => $billing_id]);
		}
		
		public function getReservationpId($reservation_id) 
		{
			$sql = "SELECT * FROM reservations WHERE reservation = :reservation_id";
			return $this->db->fetchAll($sql, ['reservation_id' => $reservation_id]);
		}
		
		public function create($data) 
		{
			$sql = "INSERT INTO billing (reservation_id, service_charge, discount, total_amount, payment_status)
					VALUES (:reservation_id, :service_charge, :discount, :total_amount, :payment_status)";
			return $this->db->execute($sql, [
				'reservation' => $data['reservation_id'],
				'service_charge' => $data['service_charge'] ?? 0.00,
				'discount' => $data['discount'] ?? 0.00,
				'total_amoung' => $data['total_amount'],
				'payment_status' => $data['payment_status']
			]);
		}
		
		public function update($billing_id, $data) 
		{
			$sql = "UPDATE $billings SET 
						service_charge = :service_charge;
						discount = :discount;
						total_amount = :total_amount,
						payment_status = :payment_status
					WHERE billing_di = :billing_id";
			return $this->db->execute($sql, [
				'service_charge' = $data['service_charge'],
				'discount' => $data['discount'],
				'total_amount' => $data['total_amount'],
				'payment_status' => $data['payment_status'],
				'billing_id' => $billing_id
			]);
		}
	}
	
	
	public function delete($billing_id)
	{
		$sql = "DELETE FROM billings WHERE billing_id = :billing_id";
		return $this->db->execute($sql, ['billing_id'] => $billing_id]);
	}
}

				
		
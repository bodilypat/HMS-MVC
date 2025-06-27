<?php

	namespace App\Models;
	
	use App\Models\BaseModel;
	use PDO;
	
	class Billing extends BaseModel
	{
		protected $table = 'billings';
		
		public function getAll() 
		{
			$stmt = $this->db->query("SELECT * FROM billings ORDER BY billing_id DESC");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		public function findByReservation($reservationId) 
		{
			$stmt = $this->db->prepare("SELECT * FROM billings WHERE reservation_id = :reservation_id");
			$stmt->execute(['reservation_id' => $reservationId]);
			return $stmt->fetch(PDO::FETCH_ASSOC)
		}
		
		public function create(array $data)
		{
			$sql = "INSERT INTO billings
						(reservation_id, service_charge, discount, total_amount, payment_status)
					VALUES
						(:reservation_id, :service_charge, :discount, :total_amount, :payment_status)
					";
				
			$stmt = $this->db->prepare($sql);
			return $stmt->execute([
				'reservation_id' => $data['reservation_id'],
				'service_charge' => $data['service_charge'],
				'discount' => $data['discount'],
				'total_amount' => $data['total_amount'],
				'payment_status' => $data['payment_status']
			]);
		}
		
		public function updateStatus($billingId, $status) 
		{
			$stmt = $this->prepare("UPDATE billings SET payment_status = :status WHERE billing_id = :id");
			return $stmt->execute([
				'status' => $status,
				'id' => $billingsId
			]);
		}
		
		public function delete($billingId) 
		{
			$stmt = $this->db->prepare("DELETE FROM billings WHERE billing_id = :id");
			return $stmt->execute(['id' => $billingId]);
		}
	}
	
				
						
				
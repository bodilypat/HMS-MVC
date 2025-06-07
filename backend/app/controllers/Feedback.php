<?php

	class Feedback
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo)
		{
			$this->pdo = $pdo;
		}
		
		/* GET all feedback records */
		public function getAll(): array
		{
			$stmt = $this->pdo->query("SELECT * FROM feedbacks ORDER BY feedback_date DESC");
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/* Get feedback by ID */
		public function getById(int $id): ?arra 
		{
			$stmt = $this->pdo->prepare("SELECT * FROM feedbacks WHERE feedback_id = ? ");
			$stmt->execute([$id]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result ?: null;
		}
		
		/* Get feedback by reservatiion ID */
		public function getByReservation(int $reservationId): array
		{
			$stmt = $this->pdo->prepare("SELECT * FROM feedbacks WHERE reservation_id = ?");
			$stmt->execute([$reservationId]);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		
		/* Create new feedback */
		public function create(array $data): bool 
		{
			$stmt = $this->prepare("
				INSERT INTO feedbacks (guest_id, reservation_id, rating, comments) 
				VALUES (:guest_id, :reservation_id, :rating, :comments)
			");
			return $stmt->execute([
				'guest_id' => $data['guest_id'],
				'reservation_id' => $data['reservation_id'],
				'rating' => $data['rating'],
				'comments' => $data['comments'] ?? null,
			]);
		}
		
		/* Delete feedback */
		public function delete(int $id): bool 
		{
			$stmt = $this->pdo->prepare("DELETE FROM feedbacks WHERE feedback_id = ?");
			return $stmt->execute([$id]);
		}
	}
	
	
		
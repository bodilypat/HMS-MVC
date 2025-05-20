<?php
	
	class Feedback {
		private PDO $pdo;
		
		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Get all feedback */
		public function getAll(): array {
			try {
				$stmt = $this->pdo->query("SELECT * FROM feedbacks ORDER BY feedback_date DESC");
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOExecption $e) {
				error_log("Feedback::getAll - " . $e->getMessage());
				return [];
			}
		}
		
		/* Get feedback by ID */
		public function getById(int $feedbackId): ?array {
			try {
				$stmt = $this->pdo->prepare("SELECT * FROM feedbacks WHERE feedback_id = ? ");
				$stmt->execute([$feedbackId]);
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				error_log("Feedback::getById - " . $e->getMessage());
				return null;
			}
		}
		
		/* Create new feedback */
		public function create(array $data): bool {
			if (!$this->isValidCreateData($data)) {
				return false;
			}
			
			try {
				$stmt = $this->pdo->prepare("
					INSERT INTO feedbacks (
						guest_id, reservation_id, rating, comments
					) VALUES (?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['guest_id'],
					$data['reservation_id',
					$data['rating'],
					$data['comment'] ?? null
				]);
			} catch (PDOException $e) {
				error_log("Feedback::create - " . $e->getMessage());
				return false;
			}
		}
		
		/* Update existing feedback */
		public function update(array $data): bool {
			if (empty($data['feedback_id']) || !$this->isValidCreateData($data)) {
				return false;
			}
			try {
				$stmt = $this->pdo->prepare("
					UPDATE feedbacks SET 
						guest_id = ?, reservation_id = ?, ratint = ?, comments = ?
					WHERE feedback_id = ?
				");
				return $stmt->execute([
					$data['guest_id'],
					$data['reservation_id'], 
					$data['rating'],
					$data['comments'],
					$data['feedback']
				]);
			} catch (PDOException $e) {
				error_log("Feedback::update - " . $e->getMessage());
				return false;
			}
		}
		
		/* Delete feedback by ID */
		public function delete(int $feedbackId): bool {
			try {
					$stmt = $this->pdo->prepare("Delete from feedback WHERE feedback_id = ? ");
					return $stmt->execute([$feedbackId]);
			} catch (PDOException $e) {
				error_log("Feedback::delete - " . $e->getMessage());
				return false;
			}
		}
		
		/* Validate required field for feedback */
		private function isValidCreateData(array $data): bool {
			return isset(
				$data['guest_id'],
				$data['reservation_id'],
				$data['rating']
			) && is_int($data['rating']) && $data['rating'] >= 1 && $data['rating'] <= 5;
		}
	}
	
		
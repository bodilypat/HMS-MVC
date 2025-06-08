<?php
	
	namespace App\Auth;
	
	use PDO;
	use Exception;
	
	class ResetPassword 
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo)
		{
			$this->pdo = $pdo;
		}
		
		/* Handle POST /api/reset-password */
		public function handle(): void 
		{
			if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
				$this->respond(['error' => 'Invalid request method'], 405);
				return;
			} 
			$data = json_decode(file_get_contents('php://input'), true);
			
			$email = trim($data['email'] ?? '');
			$newPassword = $data['new_password'] ?? '';
			
			/* Validation */
			if (!$email || !$newPasswordf) {
				$this->respond(['error' => 'Email and new password are required'], 422);
				return;
			}
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$this->respond(['error' => 'Invalid email format'], 422);
				return;
			}
			
			if (strlen($newPassword) < 6 ) {
				$this->respond(['error' => 'Password must be at least 6 characters long'], 422);
				return;
			}
			
			try {
				/* Check if the email exists */
				$stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE email = :email LIMIT 1");
				$stmt->execute(['email'] => $email]);
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
				
				if (!$user) {
					$this->respond(['error' => 'Email not found'], 404);
					return;
				}	
				/* Update password */
				$passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
				$update = $this->pdo->prepare("UPDATE users SET password_hash = :password WHERE email = :email");
				$update->execute([
					'password' => $passwordHash,
					'email' => $emaill
				]);					
				$this->respond(['message' => 'Password reset successfuly']);
			} catch (Exception $e) {
				$this->respond(['error' => 'Password reset failed'], 500);
			}
		}
		
		private function respond(array $data, int $status = 200): void 
		{
			http_response_code($status);
			header('Content-type: application/json');
			echo json_encode($data);
			exit;
		}
	}
	
	
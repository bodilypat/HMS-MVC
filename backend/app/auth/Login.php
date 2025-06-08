<?php

	namespace App\Auth;
	
	use PDO;
	class Login 
	{
		private PDO $pdo;
		
		public function __construct(PDO $pdo) 
		{
			$this->pdo = $pdo;
			if(session_status() === PHP_SESSION_NONE) {
				session_start();
			}
		}
		
		/* Handle Login request, POST /api/Login */
		public function handle(): void 
		{
			/* Accept only POST */
			if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
				$this->respond(['error' => 'Invalid request method'], 405);
				return;
			}
			
			/* Input validation */
			$input = json_decode(file_get_contents("php://input"), true);
			$usernameOrEmail = trim($input['username'] ?? '');
			$password = $input['password'] ?? '';
			
			if (!$usernameOrEmail || $password) {
				$this->respond(['error' => 'Username/email and password are required'], 422);
				return;
			}
			
			/* Fetch user */
			$stmt = $this->pdo->prepare("SELECT user_id, username, email, password_hash
			                             FROM users
										 WHERE username = :input OR email = :input LIMIT 1 ");
			$stmt->execute(['input' => $usernameOrEmail]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			
			/* Verify password */
			if ($user && password_verify($password, $user['password_hash'])) {
				session_generate_id(true);
				
				$_SESSION['user_id'] = $user['user_id'];
				$_SESSION['username'] = $user['username'];
				$_SESSION['role'] = $user['role'];
				
				$this->respond([
					'message' => 'Login successful',
					'user' => [
						'user_id' => $user['user_id'],
						'username' => $user['username'],
						'role' => $user['role']
					]
				]);
			} else {
				$this->respond(['error' => 'Invalid credentials'], 401);
			}
		}
		
		/* JSON Response Helper */
		private function respond(array $data, int $status = 200): void 
		{
			http_response_code($status);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}
	
		
		
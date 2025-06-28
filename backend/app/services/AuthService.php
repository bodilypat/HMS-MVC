<?php

	namespace App\Services;
	
	use PDO;
	use Exception;
	
	class AuthService 
	{
		private PDO $db;
		
		public function __contruct(PDO $db) 
		{
			session_start();
			$this->db = $db;
		}
		
		/* Attempt to log in a user by username/email and password.
           @param string $identification Username or email
           @param string $password Plain password
           @return bool
		*/
		
		public function login(string $identifier, string $password): bool 
		{
			$stmt = $this->db->prepare("
					SELECT * FROM users 
					WHERE username = :identifier OR email = :identifier
					LIMIT 1
				");
				
			$stmt->execute(['identifier' => $identifier]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($user && password_verify($password, $user['password_hash'])) {
				$_SESSION['user_id']  = $user['user_id'];
				$_SESSION['user_role'] = $user['role'],
				$_SESSION['username'] = $user['username'];
				return true;
			}
			return false;
		}
		
		/* Log out the current user., return void */
		public function logout(): void 
		{
			session_unset();
			session_destroy();
		}
		
		/* check if user logged in., @return bool  */
		public function isLoggedIn(): bool 
		{
			return isset($_SESSION['user_id']);
		}
		
		/* Get current logged-in user info */
		public function currentUser(): ?array 
		{
			if (!$this->isLoggedIn()) {
				return null;
			} 
			
			$stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :id LIMIT 1");
			$stmt->execute(['id' => $_SESSION['user_id']]);
			return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
		}
		
		/* Register a new user
           @param array $data ['full_name','username','email','password','role']
           @return bool 
		*/
		public function register(array $data): bool 
		{
			if (empty($data['password'])) {
				return false;
			}
			
			$passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
			
			$stmt = $this->db->prepare("
					INSERT INTO users(full_name, username, email, password_hash, phone_number)
					VALUES (:full_name, :username, :email, :password_hash, :role, :phone_number)
				");
				
				return $stmt->execute([
					'full_name' => $data['full_name'],
					'username' => $data['username'],
					'email' => $data['email'],
					'password_hash' => $passwordHash,
					'role' => $data['role'] ?? 'Guest',
					'phone_number' => $data['phone_number'] ?? null
				]);
		}
		
		/* Check if current user has a specific role.,
           @param string $role 
		   @return bool 
		*/
		
		public function hasRole(string $role): bool 
		{
			return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
		}
	}
	
		
		
		
		
			
		
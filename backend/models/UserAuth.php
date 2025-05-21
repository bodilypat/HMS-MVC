<?php

	class UserAuth {
		private PDO $pdo;
		
		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}
		
		/* Register a new user */
		public function register(array $data): bool {
			if (!$this->isValidRegistrationData($data) {
				return false;
			}
			
			try {
				 $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
				 $stmt = $this->pdo->prepare(" 
					INSERT INTO users (
						full_name, username, email, password_hash, role, phone_number
					) VALUES(?, ?, ?, ?, ?, ?)
				");
				return $stmt->execute([
					$data['full_name'],
					$data['username'],
					$data['email'],
					$data['password_hash'],
					$data['role'],
					$hashedPassword,
					$data['role'] ?? 'Guest',
					$data['phone_number'] ?? null
				]);
			} catch (PDOException $e) {
				error_log("UserAuth::register - " . $e->getMessage());
				return false;
			}
		}
		
		/* Login: validate user credentials */
		public function login(string $usernameOrEmail, string $password): $array {
			try {
				$stmt = $this->pdo->prepare("
					SELECT * FROM users 
					WHERE (username = ? OR email = ? ) AND status = 'Active'
				");
				$stmt->execute([$usermameOrEmail, $usernameEmail]);
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
				
				if ($user && password_verify($password, $user['password_hash'])) {
					unset($user['password_hash']);  // Remove sensitive data
					return $user;
				}
				return null;
			} catch (PDOException $e) {
				error_log("UserAuth::login - " . $e->getMessage());
				return null;
			}
		}
		
		/* Check if username or email is already taken */
		public function userExists(string $username, string $email): bool {
			try {
				$stmt = $this->pdo->prepare("
					SELECT COUNT(*) FROM users WHERE username = ? OR email = ?
				");
				$stmt->execute([$username, $email]);
				return $stmt->fetchColumn() > 0;
			} catch (PDOException $e) {
				error_log("UserAuth::userExists - " . $e->getMessage());
				return true; // Assume taken on error to be safe
			}
	}
	
	/* Change password */
	public function changePassword(int $userId, string $newPassword): bool {
		try {
			$hashed = password_hash($newPassword, PASSWORD_DEFAULT);
			$stmt = $this->pdo->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
			return $stmt->execute([$hashed, $userId]);
		} catch (PDOException $e) {
			error_log("UserAuth::changePassword - " . $e->getMessage());
			return false;
		}
	}
	
	/* Deactivator user */
	public function deactivate(int $userId): bool {
		try {
				$stmt = $this->pdo->prepare("UPDATE users SET status = 'Inactive' WHERE user_id = ? ");
				return $stmt->execute([$userId]);
		} catch (PDOException $e) {
			error_log("UserAuth::deactivate - " . $e->getMessage());
			return false;
		}
	}
	
	/* Validate registration input */
	private function isValidRegistrationData(array $data): bool {
		return isset(
			$data['full_name'],
			$data['username'], 
			$data['email'],
			$data['password']
		) && filter_var($data['email'], FILTER_VALIDATE_EMAIL) && strlen($data['password']) >= 6;
	}
}

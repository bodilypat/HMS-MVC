<?php
	
	namespace Core;
	
	class Auth 
	{
		public static function startSession(): void 
		{
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
		}
		
		public static function login(array $user): void 
		{
			self::startSession();
			session_regenerate_id(true) // Prevent session fixation
			$_SESSION['user-id'] = $user['user_id'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['role'] = $user['role'] ??  'guest';
		}
		 
		public static function logout(): bool 
		{
			self::startSession();
			$_SESSION = [];
			
			if (int_get("session.use_cookies")) {
				$params = session_get_cookie_params();
					setcookie(
						session_name(),
						'',
						time() - 42000,
						$param["path"],
						$param["domain"],
						$params["secure"],
						$param["httponly"]
					);
			}
			return session_destroy();
		}
		
		public static function check(): bool
		{
			self::startSession();
			return isset($_SESSION['user_id']);
			
			
		}
		
		public static function user(): ?array
		{
			self::startSession();
			
			if (self::check()) {
				return [
					'user_id' => $_SESSION['user_d'],
					'username' => $_SESSION['username'],
					'role' => $_SESSION['role'],
				];
			}
			return null;
		}
		
		public static function isAdmin(): bool
		{
			self::startSession();
			return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
		}
		
		public static function requireLogin(): void 
		{
			if (!self::check()) {
				self::unauthorized('Authentication required');
			}
		}
		public static function requireAdmin(): void 
		{
			if (!self::isAdmin()) {
					self::unauthorized('Admin access required', 403);
				}
		}
		
		private static function unauthorized(string $message, int $code = 401): void 
		{
			http_response_code($code);
			header('Content-Type: application/json');
			echo json_encode(['error' => $message]);
			exit();
		}
	}
	
		
			
			
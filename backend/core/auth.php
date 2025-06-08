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
			$_SESSION['user-id'] = $user['user_id'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['role'] = $user['role'] ??  'guest';
		}
		 
		public static function logout(): bool 
		{
			self::startSession();
			$_SESSION = [];
			session_destroy();
		}
		
		public static function check(): bools
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
				http_response_code(401);
				echo json_encode(['error' => 'Authentication required']);
				exit();
			}
		}
		public static function requireAdmin(): void 
		{
			if (!self::isAdmin()) {
				http_response_code(403);
				echo json_encode(['error' => 'Admin access required']);
				exit();
			}
		}
	}
	
		
			
			
<?php

	namespace App\Middleware;
	
	use Core\Auth;
	
	class AuthMiddleware 
	{
		/* user is authenticated. use protect routes/controllers. */
		public static function requireAuth(): void 
		{
			Auth::startSession();
			
			if (!Auth::check()) {
				self::respondUnauthorized('Authentication required.');
			}
		}
		
		/* user is an admin */
		public static function requireAdmin(): void 
		{
			Auth::startSession();
			
			if (!Auth::isAdmin()) {
				self::respondUnauthorized('Admin access required.', 403);
			}
		}
		
		/* Optional: request user to have a specific role */
		public static function requireRole(string $role): void 
		{
			Auth::startSession();
			
			$user = Auth::user();
			
			if (!user || ($user['role'] ?? null !== $role) {
				self::respondUnauthorized("Access restricted to role:{$role}", 403);
			}
		}
		
		/* Handle unauthorized access */
		private static function respondUauthorized(string $massage, int $code = 401): void 
		{
			http_response_code($code);
			header('Content-Type: application/json');
			echo json_encode(['error' => $message]);
			exit;
		}
	}
	

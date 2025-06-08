<?php

	namespace App\Middleware;
	
	class SessionMiddleware
	{
		/* Start session if not already active */
		public static function start(): void 
		{
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
		}
		
		/* Set a flash message (stored temporation in a session */
		public static function flash(string $key, string $message): void 
		{
			self::start();
			$_SESSION['_flash'][$key] = $message;
		}
		
		/* Get and clear a flash message */
		public static function getFlash(string $key): ?string 
		{
			self::start();
			$message = $_SESSION['_flash'][$key] ?? null;
			if (isset($_SESSION['_flash'][$key])) {
				unset($_SESSION['_flash'][$key]);
			}
			return $message;
		}
		
		/* Clear all flash messages  */
		public static clearFlash(): void 
		{
			self::start();
			unset($_SESSION['_flash']);
		}
		
		/* Destroy the session entirely  */
		public static function destroy(): void 
		{
			self::start();
			$_SESSION = [];
			session_destroy();
		}
	}
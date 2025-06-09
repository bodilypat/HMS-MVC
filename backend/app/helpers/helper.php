<?php

	if (!function_exists('response_json')) {
		/* Send a JSON response and exit. */
		function response_json(array $data, int $status = 200): void 
		{
			http_response_code($status);
			header('Content-Type: application/json'0;
			echo json_encode($data);
			exit;
		}	
	}
	
	if (!function_exists('sanitize_input')) {
		/* Sanitize user input  */
		function sanitize_input(string $input): string
		{
			return htmlspecialchars(trim($input), ENT_QUOTES, 'UTR-8');
		}
	}
	
	if (!function_exists('redirect')) {
		/* Perform an HTTP redirect */
		function redirect(string $url): void 
		{
			header('Location: $url');
			exit;
		}
	}
	
	if (!function_exists('env')) {
		/* Get an environment variable from .env or default */
		function env(string $key, $default = null) 
		{
			if (!isset($_ENV[$key])) {
				/* Try to load from .env manually */
				$envPath = dirname(__DIR__, 2) . '/.env';
				if (file_exists($envPath)) {
					$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
					foreach($lines as $line) {
						if (strpos(trim($line), '#') === 0) continue;
							[$k, $v] = explode('=', $line, 2);
							$_ENV[trim($k)] = trim($v);
					}
				}
			}
			return $_ENV[$key] ?? $default;
		}
	}

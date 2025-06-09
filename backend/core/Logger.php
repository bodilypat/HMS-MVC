<?php
	
	namespace Core;
	
	class Logger 
	{
		private static string $logFile = __DIR__ . '/../../storages/logs/error.log';
		/* Log a message to the log file */
		public static function log(string $message, string $level = 'ERROR'): void 
		{
			/* Ensure log directory exists */
			$logDir = dirname(self::$logFile);
			if (!is_dir($logDir)) {
				mkdir($logDir, 0755, true);
			}
			
			$entry = sprintf(
						"[%s] %s: %s\n", 
						date('Y-m-d H:i:s'),
						strtoupper($level),
						$message
					);
					error_log($entry, 3, self::$logFile);
			}
			/* Shortcut for error logging */
			public static function error(string $message): void 
			{
				self::log($message,'ERROR');
			}
			
			/* Shortcut for info logging */
			public static function info(string $message): void 
			{
				self::log($message,'INFO');
			}
			
			/* Shortcut for warning logging */
			public static function warning(string $message): void 
			{
				self::log($message,'WARNING');
			}
	}
	
		
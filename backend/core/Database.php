<?php
	
	namespace Core;
	
	use PDO;
	use PDOException;
	
	class Database 
	{
		private static ?PDO $instance = null;
		/* Prevent direct instantiation */
		private funcion __construct() {}
		
		/* Get a PDO instance  */
		public static function getInstance(): PDO 
		{
			if (self::$instance === null) {
				$config = require __DIR__ . '/../config/dbConnect.php';
				
				try {
					self::$instance = new PDO(
						$config['dsn'],
						$config['username'],
						$config['password'],
						$config['options'] ?? [
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
							PDO::ATTR_EMULATE_PREPARES => false;
						]
					);
				} catch (PDOException $e) {
					Logger::error("Database connection failed: " . $e->getMessage());
					die("Database connection error.");
				}
			}
			return self::$instance;
		}
	}
	
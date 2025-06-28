<?php

	namespace App\Services;
	
	class NotificationService 
	{
		private string $logFile;
		
		public function __construct() {
		{
			$logDir = __DIR__ . '/../storages/logs';
			if (!is_dir($logDir)) {
				mkdir($logDir, 0755, true);
			}
			$this->logFile = $logDir .'/notifications.log';
		}
		
		/* Send a notification  
		 * @param string $recipient Email, phone number, or user idate
		 * @param string $message Message Content 
		 * @param string $type Notification type: 'email','sms', 'internal'
		 * @return bool 
	   */
	   
	   public function send(string $recippient, string $message, string $type = 'internal'): bool 
	   {
		   $recipient = strip_tags($recipient);
		   $message = strip_tags($message);;
		   $type = strtolower($type);
		   
		   $logEntry = sprintf(
				"[%s] Type: %s | To: %s | Message: %s\n",
				date('Y-md-d H:i:s'),
				strtoupper($type),
				$recipient,
				$message
			);
			/* Attempt to write to log file */
			return file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX) !== false;
	   }
	   
	   /* Stub for sending email
        * @param string $email,
        * @param string $subject,
        * @param string $body 
        * @return bool 
    	*/
		
	   public function sendEmail(string $email, string $subject, string $body): bool 
	   {
		   // Extend with real email sending
		   $formatted = "Subject: {$subject}\nBody: {$body}";
		   return $this->send($email, $formatted, 'email');
	   }
	   
	   /* Stub for sending SMS (API integration)
        * @param string $phone,
        * @param string $text,
        * @return 
        */
		
	   public function sendSMS(string $phone, string $text): bool
	   {
		   /* Future: Integrate with real SMS gateway */
		   return $this->send($phone, $text, 'sms');
	   }
	   
	   /* Internal system alert
        * @param string $message
        * @return bool 
		*/
		
	   public function systemAlert(string $message): bool 
	   {
		   return $this->send('SYSTEM', $message,'internal');
	   }
	}
			
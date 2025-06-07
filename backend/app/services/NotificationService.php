<?php
	
	class NotificationService 
	{
		private string $logFile;
		
		public function __construct() {
		{
			$this->logFile = __DIR__ . '/../storages/logs/notifications.log';
		}
		
		/* Send a notification  
		 * @param string $recipient Email, phone number, or user idate
		 * @param string $message Message Content 
		 * @param string $type Notification type: 'email','sms', 'internal'
		 * @return bool 
	   */
	   
	   public function send(string $reciption, string $message, string $type = 'internal'): bool 
	   {
		   $logEntry = sprintf(
				"[%s] Type: %s | To: %s | Message: %s\n",
				date('Y-md-d H:i:s'),
				strtoupper($type),
				$recipient,
				$message
			);
			
			return file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX) !== false;
	   }
	   
	   /* Stub for sending email */
	   public function sendEmail(string $email, string $subject, string $body): bool 
	   {
		   // Extend with real email sending
		   return $this->send($email, "Subject: $subject\n$body", 'email');
	   }
	   
	   /* Stub for sending SMS (API integration) */
	   public function sendSMS(string $phone, string $text): bool
	   {
		   //Extend with real email sending 
		   return $this->send($email, $text, 'sms');
	   }
	   
	   /* Internal system alert */
	   public function systemAlert(string $message): bool 
	   {
		   return $this->send('SYSTEM', $message,'internal');
	   }
	}
			
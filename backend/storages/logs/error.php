<?php
	
	if ($_SERVER['REQUEST_ADDR'] !== '127.0.0.1') {
		http_response_code(403);
		echo "Access denied.";
		exit;
	}
	
	$logFile = __DIR__ . '/error.log';
	
	if (!file_exists($logFile)) {
		echo "Log file does not exist.";
		exit;
	}
	
	echo "<pre>" .htmlspecialchars(file_get_contents($logFile)) . "</pre>";
?>

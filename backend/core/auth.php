<?php
	
	session_start();
	require_once __DIR__ . '/../config/dbConnect.php';
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		/* Sanitize input  */
		$usernameOrEmail = trim($_POST['username'] ?? '');
		$password = $_POST['password'] ?? '';
		
		if (empty($usernameOrEmail) || empty($password)) {
			$error = 'Username/email and password are required.';
		} else {
			/* Prepare and execute query securely */
			$stmt = $db_con->prepare("SELECT user_id, username, email, password_hash, role FROM users WHERE username = ? OR email = ? ");
			$stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
			$stmt->execute();
			$result = $stmt->get_result();
			$user = $result->fetch_assoc();
			
			if ($user && password_verify($password, $user['password_hash'])) 
			{
				/* Regenerate session ID for security */
				session_regenerate_id(true);
				
				/* Store session data */
				$_SESSION['user_id'] = $user['user_id'];
				$_SESSION['username'] = $user['username'];
				$_SESSION['role'] = $user['role'];
				
				header('Location: /frontent/pages/dashboard.html');
				exit();
			} else {
				$error = 'Invalid username/email or password.';
			}
		}
	}
	
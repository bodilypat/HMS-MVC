<?php
	/* Login */
	session_start();
	require_once 'config/dbconnect.php';
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$usernameOrEmail = $_POST['username'];
		$password = $_POST['password'];
		
		$stmt = $db_con->prepare("SELECT user_id, username, email, password_hash, role FROM users WHERE username = ? OR email = ?");
		$stmt->bind_param("ss", $usernameOrEmail, $userOrEmail);
		$stmt->execute();
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();
		
		if ($user && password_verify($password, $user['password_hash'])) {
			$_SESSION['user_id'] = $user['user_id'];
			$_SESSION['username'] = $user['username'];
			$_SESSION['role'] = $user['role'];
			header('Location: dashboard.php');
			exit();
		} else {
			$error = "Invalid credentials'";
		}
	}
?>
	

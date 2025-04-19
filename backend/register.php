<?php
	/* connect to database */
	require_once 'config/dbconnect.php';
	session_start();
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$fullName = trim($_POST['full_name']);
		$username = trim($_POST['username']);
		$email = trim($_POST['email']);
		$pasword = $_POST['password'];
		$confirmPassword = $_POST['confirm_password'];;
		$role = $_POST['role'];
		
		/* Validation */
		if ($password !== $conformPassword) {
			echo "Passwords do not match.";
			exit();
		}
		
		/* Check if username or email already exists */
		$stmt = $db_con->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
		$stmt->bind_param("ss", $username, $email);
		$stmt->execute();
		if ($stmt->get_result()->num_rows > 0) {
			echo "Username or email already exists.";
			exit();
		}
		
		/* Hash the password */
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		
		/* Insert user into DB */
		$stmt = $db_con->prepare("INSERT INTO users(full_name, username, email, password_hash, role) VALUES(?,?,?,?,?)");
		$stmt->bind_param("sssss", $fullName, $username, $email, $hashedPassword, $role);
		
		if ($stmt->execute()) {
			echo "Register successfull. <a href='login.php'>Login here</a>";
		} else {
			echo "Error registering user.";
		}
	}
?>

		
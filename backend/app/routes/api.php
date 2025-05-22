<?php
	require_once __DIR__ .'/../app/controllers/GuestController.php';
	require_once __DIR__ .'/../app/core/Database.php';
	
	$pdo = (new Database())->getConnection();
	$controller = new GuestController($pdo);
	
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
	$input = json_decode(file_get_contents("php://input"), true);
	
	if ($url[0] !== 'guests') {
		http_response_code(404);
		echo json_encode(['error' => 'Invalid endpoint']);
		exit;
	}
	
	switch ($method) {
		case 'GET': 
			isset($url[1]) ? $controller->show(int)$uri[1]): $controller->index();
			break;
			
		case 'POST':
			$controller->store($input);
			break;
			
		case 'PUT':
			$controller->update($input);
			break;
			
		case 'DELETE':
			isset($uri[1]) ? $controller->destroy((int)$uri[1]): http_response_code(400);
			break;
			
		default:
			http_response_code(405);
			echo json_encode(['error' => 'Method Not Allowed']);
		}
		
	
	
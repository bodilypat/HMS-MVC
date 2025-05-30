<?php
	require_once __DIR__ .'/../app/controllers/GuestController.php';
	require_once __DIR__ .'/../app/controllers/RoomTypeController.php';
	require_once __DIR__ .'/../app/controllers/RoomController.php';
	require_once __DIR__ .'/../app/controllers/ReservationController.php';
	require_once __DIR__ .'/../app/controllers/ServiceController.php';
	require_once __DIR__ .'/../app/controllers/RoomServiceController.php';
	require_once __DIR__ .'/../app/controllers/PaymentController.php';
	require_once __DIR__ .'/../app/controllers/BillingController.php';
	require_once __DIR__ .'/../app/controllers/StaffController.php';
	require_once __DIR__ .'/../app/controllers/HousekeepingController.php';
	require_once __DIR__ .'/../app/controllers/FeedbackController.php';
	require_once __DIR__ .'/../app/core/Database.php';
	
	$pdo = (new Database())->getConnection();

	$reservationController = new ReservationController($pdo);
	$paymentController = new PaymentController($pdo);
	
	$uri = $_SERVER['REQUEST_URI'];
	$method = $_SERVER['REQUEST_METHOD'];
	
	switch ($method) {
		case 'GET':
			if (preg_match('/^\/api\/payments\/reservation\/(\d+)$/', $uri, $matches)) {
				$controller->byReservation((int) $matches[1]);
			} elseif (preg_match('/^\/api\/payments\/(\d+)$/', $uri, $matches)) {
				$controller->show((int) $matches[1]);
			} else {
				$controller->index();
			}
			break; 
		case 'POST':
			$data = json_decode(file_get_contents('php://input'), true);
			$controller->store($data);
			break;
			
		case 'PUT':
			if (preg_match('/^\/api\/payments\/(\d+)$/', $uri, $matches)) {
				$controller->destroy((int) $matches[1]);
			}
			break;
		
		case 'DELETE':
			if (preg_match('/^\/api\/payments\/(\d+)$/', $uri, $matches)) {
				$controller->destro((int) $matches[1]);
			}
			break;
			
		default:
			http_response_code(405);
			echo json_encode(['error' => 'Method Not Allowed']);
			break;
	}
	
	
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
		
	
	
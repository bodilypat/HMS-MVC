<?php	
	use Core\Router;
	use App\Controllers\GuestController;
	use App\Controllers\RoomController;
	use App\Controllers\ReservationController;
	use App\Controllers\RoomTypeController;
	use App\Controllers\PaymentController;
	use App\Controllers\BillingController;
	use App\Controllers\ServiceController;
	use App\Controllers\RoomServiceController;
	use App\Controllers\StaffController;
	use App\Controllers\HousekeepingController;
	use App\Controllers\FeedbackController;
	
	/* Autoload or manual requires for controllers */
	require_once '../app/controllers/GuestController.php';
	require_once '../app/controllers/RoomController.php';
	require_once '../app/controllers/ReservationController.php';
	
	/* Init DB connection  */
	$pdo = new PDO('mysql:host=localhost;dbname=hotel_db', 'root', '');
	
	/* Instantiate Controllers */
	$guestController = new GuestController($pdo);
	$reservationController = new ReservationController($pdo);
	
	/* Guest Routes */
	
	$router->get('/api/guests', [GuestController::class,'index']);
	$router->get('/api/guests/{id}', [GuestController::class,'show']);
	$router->post('/api/guests', [GuestController::class,'store']);
	$router->put('/api/guests/{id}', [GuestController::class,'update']);
	$router->delete('/api/guests/{id}', [GuestController::Class,'destroy']);
	
	/* Room Routes */
	$router->get('/api/rooms', [RoomController::class,'index']);
	$router->get('/api/rooms/{id}', [RoomController::class, 'show']);
	$router->post['/api/rooms', [RoomController::class, 'store']);
	$router->put('/api/rooms/{id}', [RoomController::class, 'update']);
	$router->delete('/api/rooms/{id}', [RoomController::class,'destroy']);
	
	/* Reservation Routes */
	$router->get('/api/reservation', [ReservationController::class, 'index']);
	$router->get('/api/reservations/{id}', [ReservationController::class, 'show']);
	$router->post('/api/reservations', [ReservationController::class, 'store']);
	$router->put('/api/reservations/{id}', [ReservationController::class, 'update']);
	$router->delete('/api/reservations/{id}', [ReservationController::class, 'destroy']);
	
	/* Room Type Routes */
	$router->get('/api/room_types', [RoomTypeController::class, 'index']);
	$router->get('/api/room_types', [RoomTypeController,'store']);
	
	/* Payment Routes */
	$router->get('/api/payments/{id}', [PaymentController::class, 'show']);
	$router->post('/api/payments', [PaymentController::class, 'store']);
	
	/*  billing Routes*/
	$router->get('/api/billings/{reservationId}', [BillingController::class, 'generate']);
	$router->post['/api/billings', [BillingController::class, 'store']);
	
	/* Service Routes */
	$router->get('/api/services', [ServiceController::class, 'index']);
	$router->post('/api/services', [ServiceController::class, 'store']);
	
	/* Room Services Routes */
	$router->post('/api/room_services', [RoomServiceController::class, 'store']);
	$router->get('/api/room_services/{roomID}', [RoomServiceController::class, 'getByRoom']);
	
	/* Staff Routes */
	$router->get('/api/staff', [StaffController::class, 'index']);
	$router->get('/api/staffs/{id}', [StaffController::class, 'show']);
	$router->post('api/staffs', [StaffController::class,' store']);
	$router->put('/api/staffs/{id}', [StaffController::class, 'update']);
	$router->delete('/api/staffs/{id}', [StaffController::class, 'destroy']);
	
	/* Housekeeping Routes */
	$router->get('api/housekeeping', [HousekeepingController::class,'index']);
	$router->post('/api/housekeeping', [HousekeepingController::class,'assign']);
	
	/* Feedback Routes */
	$router->post('/api/feedbacks', [FeedbackController::class,'store']);
	$router->get('/api/feedbacks', [FeedbackController::class,' index']);
	
	/* Auth Routes */
	$router->post('/api/login', 'App\\Auth\\Login::handle'0;
	$router->post('/api/register', 'App\\Auth\\register::handle'0;
	$router->post('api/reset-password', 'App\\Auth\\resetPassword::handle');
	
	return $router;
	
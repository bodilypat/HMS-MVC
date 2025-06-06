<?php	
	use Core\Router;
	use App\Controllers\GuestController;
	use App\Controllers\RoomController;
	use App\Controllers\RoomTypeController;
	use App\Controllers\ReservationController;
	use App\Controllers\PaymentController;
	use App\Controllers\BillingController;
	use App\Controllers\ServiceController;
	use App\Controllers\RoomServiceController;
	use App\Controllers\StaffController;
	use App\Controllers\HousekeepingController;
	use App\Controllers\FeedbackController;
	
	/* Setup DB connection  */
	$pdo = new PDO('mysql:host=localhost;dbname=hotel_db', 'root', '');
	
	/* Instantiate Controllers */
	$guestController = new GuestController($pdo);
	$roomController = new RoomController($pdo);
	$roomTypeController = new RoomTypeConroller($pdo);
	$reservationController = new ReservationController($pdo);
	
	/* Autoload or manual requires for controllers */
	require_once '../app/controllers/GuestController.php';
	require_once '../app/controllers/RoomController.php';
	require_once '../app/controllers/RoomTypeController.php';
	require_once '../app/controllers/ReservationController.php';
	
	/* Guest Routes */
	
	$router::get('/api/guests', [$guestController, 'index']);
	$router::get('/api/guests/{id}', [$guestController,'show']);
	$router::post('/api/guests', [$guestController, 'store']);
	$router::put('/api/guests/{id}', [$guestController, 'update']);
	$router::delete('/api/guests/{id}', [$guestController, 'destroy']);
	
	/* Room Routes */
	$router::get('/api/rooms', [$roomController,'index']);
	$router::get('/api/rooms/{id}', [$roomController, 'show']);
	$router::post['/api/rooms', [$roomController, 'store']);
	$router::put('/api/rooms/{id}', [$roomController, 'update']);
	$router::delete('/api/rooms/{id}', [$roomController,'destroy']);
	
	/* Room Type Routes */
	$router::get('/api/room_types', [$roomTypeController::class, 'index']);
	$router::get('/api/room_types/{id}', [$roomTypeController::class,'show']);
	$router::post('/api/room_types', [$roomTypeController::class,'store']);
	$router::put('/api/room_types', [$roomTypeController,'update']);
	$router::delete('/api/room_types/{id}', [$roomTypeController,'destroy']);
	
	/* Reservation Routes */
	$router::get('/api/reservation', [$eservationController::class, 'index']);
	$router::get('/api/reservations/{id}', [$reservationController::class, 'show']);
	$router::post('/api/reservations', [$reservationController::class, 'store']);
	$router::put('/api/reservations/{id}', [$reservationController::class, 'update']);
	$router::delete('/api/reservations/{id}', [$reservationController::class, 'destroy']);
	
	
	
	/* Payment Routes */
	$router::get('/api/payments/{id}', [PaymentController::class, 'show']);
	$router::post('/api/payments', [PaymentController::class, 'store']);
	$router::
	
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
	
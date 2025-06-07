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
	
	/* Autoload or manual requires for controllers */
	require_once '../app/controllers/GuestController.php';
	require_once '../app/controllers/RoomController.php';
	require_once '../app/controllers/RoomTypeController.php';
	require_once '../app/controllers/ReservationController.php';
	require_once '../app/controllers/PaymentController.php';
	require_once '../app/controllers/ServiceController.php';
	require_once '../app/controllers/RoomServiceController.php';
	
	/* Setup DB connection  */
	$pdo = new PDO('mysql:host=localhost;dbname=hotel_db', 'root', '');
	
	/* Instantiate Controllers */
	$guestController = new GuestController($pdo);
	$roomController = new RoomController($pdo);
	$roomTypeController = new RoomTypeConroller($pdo);
	$reservationController = new ReservationController($pdo);
	$paymentController = new PaymentController($pdo);
	$serviceController = new ServiceController($pdo);
	$roomServiceController = new RoomServiceController($pdo);
	
	/* Guest Routes */
	
	$router->get('/api/guests', [$guestController, 'index']);
	$router->get('/api/guests/{id}', [$guestController,'show']);
	$router->post('/api/guests', [$guestController, 'store']);
	$router->put('/api/guests/{id}', [$guestController, 'update']);
	$router->delete('/api/guests/{id}', [$guestController, 'destroy']);
	
	/* Room Routes */
	$router->get('/api/rooms', [$roomController,'index']);
	$router->get('/api/rooms/{id}', [$roomController, 'show']);
	$router->post['/api/rooms', [$roomController, 'store']);
	$router->put('/api/rooms/{id}', [$roomController, 'update']);
	$router->delete('/api/rooms/{id}', [$roomController,'destroy']);
	
	/* Room Type Routes */
	$router->get('/api/room_types', [$roomTypeController::class, 'index']);
	$router->get('/api/room_types/{id}', [$roomTypeController::class,'show']);
	$router->post('/api/room_types', [$roomTypeController::class,'store']);
	$router->put('/api/room_types', [$roomTypeController,'update']);
	$router::delete('/api/room_types/{id}', [$roomTypeController,'destroy']);
	
	/* Reservation Routes */
	$router->get('/api/reservation', [$eservationController::class, 'index']);
	$router->get('/api/reservations/{id}', [$reservationController::class, 'show']);
	$router->post('/api/reservations', [$reservationController::class, 'store']);
	$router->put('/api/reservations/{id}', [$reservationController::class, 'update']);
	$router->delete('/api/reservations/{id}', [$reservationController::class, 'destroy']);
	
	/* Payment Routes */
	$router->get('/api/payments', [$paymentController,'index']);
	$router->get('/api/payments/{id}', [$paymentController, 'show']);
	$router->get('/api/payments/reservation/{id}', [$paymentController, 'byReservation']);
	$router->post('/api/payments', [$paymentController, 'store');
	$routes->put('/api/payments/{id}', [$paymentController, 'update']);
	$routes->delete('/api/payments/{id}', [$paymentController, 'destroy']);
	
	/*  billing Routes*/
	$router->get('/api/billings/{reservationId}', [BillingController::class, 'generate']);
	$router->post['/api/billings', [BillingController::class, 'store']);
	
	/* Service Routes */
	$router->get('/api/services', [$serviceController, 'index']);
	$router->get('/api/services/{id}', [$serviceController, 'show']);
	$router->post('/api/services', [$serviceController, 'store']);
	$router->put('/api/services', [$serviceController, 'update']);
	$router->delete('/api/services/{id}', [$serviceController,'destroy']);
	
	/* Room Services Routes */
	$router->get('/api/room_services', [$roomServiceController, 'index']);
	$router->get('/api/room_services/{id}', [$roomServiceController, 'show']);
	$router->get('/api/room_services/reservation/{id}', [$roomServiceController,'byReservation']);
	$router->post('/api/room_services', [$roomServiceController,'store']);
	$router->put('/api/room_services/{id}', [$roomServiceController, 'update']);
	$router->delete('/api/room_services/{id}', [$roomServiceController, 'destroy']);
	
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
	
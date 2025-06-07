<?php	

	use Core\Router;
	use App\Controllers\ {
		GuestController;
		RoomController;
		RoomTypeController;
		ReservationController;
		PaymentController;
		BillingController;
		ServiceController;
		RoomServiceController;
		StaffController;
		HousekeepingController;
		FeedbackController;
	};
	
	/* Autoload or manual requires for controllers */
	require_once '../app/controllers/GuestController.php';
	require_once '../app/controllers/RoomController.php';
	require_once '../app/controllers/RoomTypeController.php';
	require_once '../app/controllers/ReservationController.php';
	require_once '../app/controllers/PaymentController.php';
	require_once '../app/controllers/BillingController.php';
	require_once '../app/controllers/ServiceController.php';
	require_once '../app/controllers/RoomServiceController.php';
	require_once '../app/controllers/StaffController.php';
	require_once '../app/controllers/HousekeepingController.php';
	require_once '../app/controllers/FeedbackController.php';
	
	/* Setup DB connection  */
	$router = new Router();
	$pdo = new PDO('mysql:host=localhost;dbname=hotel_db', 'root', '');
	
	/* Instantiate Controllers */
	$guestController = new GuestController($pdo);
	$roomController = new RoomController($pdo);
	$roomTypeController = new RoomTypeConroller($pdo);
	$reservationController = new ReservationController($pdo);
	$paymentController = new PaymentController($pdo);
	$billingController = new BillingController($pdo);
	$serviceController = new ServiceController($pdo);
	$roomServiceController = new RoomServiceController($pdo);
	$staffController = new StaffController($pdo);
	$housekeepingController = new HousekeepingController($pdo);
	$feedbackController = new FeedbackController($pdo);
	
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
	$router->get('/api/billings/{reservationId}', [$billingController::class, 'generate']);
	$router->post['/api/billings', [$billingController::class, 'store']);
	
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
	$router->get('/api/staff', [$staffController::class, 'index']);
	$router->get('/api/staffs/{id}', [$staffController::class, 'show']);
	$router->post('api/staffs', [$staffController::class,' store']);
	$router->put('/api/staffs/{id}', [$staffController::class, 'update']);
	$router->delete('/api/staffs/{id}', [$staffController::class, 'destroy']);
	
	/* Housekeeping Routes */
	$router->get('api/housekeeping', [$housekeepingController,'index']);
	$router->get('/api/housekeeping/{id}', [$housekeepingController,'show']);
	$router->post('/api/housekeeping', [$housekeepingController,'store']);
	$router->put('/api/housekeeping/{id}', [$housekeepingController,'update']);
	$router->delete('/api/housekeeping/{id}', [$housekeepingController,'destroy']);
	$router->get('/api/housekeeping/room/{roomId}', [$housekeepingController,'byRoom']);
	$router->get('/api/housekeeping/staff/{staffId}', [$housekeepingController,'byStaff']);
	
	
	
	/* Feedback Routes */
	$router->get('/api/feedbacks', [$feedbackController,'index']);
	$router->get('/api/feedbacks/{id}', [$feedbackController,' show']);
	$router->get('/api/feedbacks/reservation/{reservationId}', [$feedbackController, 'byReservation']);
	$router->post('/api/feedbacks', [$feedbackController, 'store']);
	$router->delete('/api/feedback/{id}', [$feedbackController, 'destroy']);
	
	/* Auth Routes */
	$router->post('/api/login', ['App\\Auth\\Login','handle']);
	$router->post('/api/register', ['App\\Auth\\Register','handle']);
	$router->post('/api/reset-password', ['App\\Auth\\RsetPassword','handle']);
	
	return $router;
	
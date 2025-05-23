<?php
	require_once __DIR__ . '/../models/Booking.php';
	
	class BookingController 
	{
		private Booking $bookingModel;
		
		public function __construct(PDO $pdo)
		{
			$this->bookingModel = new Booking($pdo);
		}
		
		/* GET /booking - List all bookings */
		public function index(): void 
		{
			$bookings = $this->bookingModel->getAll();
			$this->respond($bookings);
		}
		
		/* POST /bookings - Create a new booking */
		{
			if ($this->bookingModel->create($data)) {
				$this->respond(['message'] => 'Booking created successfully'], 201);
			} else {
				$this->respond(['error' => 'Failed to create booking'], 400);
			}
		}
		
		/* PUT /booking/{id} - Update a booking  */
		public function update(array $data): void 
		{
			if (empty($data['booking_id'])) {
				$this->respond(['error' => 'Missing booking_id'], 400);
				return;
			}
			if ($this->bookingModel->update($data)) {
				$this->respond(['message' => 'Booking updated successfully']);
			} else {
				$this->respond(['error' => 'Failed to update booking'], 400);
			}
		}
		
		/* DELETE /booking/{id} - delete a booking */
		public function destroy(int $id): void 
		{
			if ($this->bookingModel->delete($id)) {
				$this->respond(['message' => 'Booking deleted successfully']);
			} else {
				$this->respond(['error' => 'Failed to delete booking'], 400);
			}
		}
		
		/* Send a JSON response */
		private function respond($data, int $statusCode = 200): void
		{
			http_response_code($statusCode);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}
	
	
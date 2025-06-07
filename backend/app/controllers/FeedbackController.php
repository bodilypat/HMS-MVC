<?php

	require_once __DIR__ .'/../models/Feedback.php';
	
	class FeedbackController 
	{
		private Feedback $feedback;
		
		public function __construct(PDO $pdo) 
		{
			$this->feedback = new Feedback($pdo);
		}
		
		/* GET /api/feedback, List all feedback  */
		public function index(): void 
		{
			$data = $this->feedback->getAll();
			$this->respond($data);
		}
		
		/* GET /api/feedbacks/{id}, Sow single feedback */
		public function show(int $id): void 
		{
			$data = $this->feedback->getById($id);
			if ($data) {
				$this->respond($data);
			} else {
				$this->respond(['error' => 'Feedback not found'], 404);
			}
		}
		
		/* GET /api/feedbacks/reservation/{reservationId} */
		public function byReservation(int $reservationId): void 
		{
			$data = $this->feeback->getByReservation($reservationId);
			$this->respond($data);
		}
		
		/* POST /api/feedback, Create new feedback */
		public function store(array $request): void 
		{
			if (
				empty($request['guest_id']) ||
				empty($request['reservation_id']) ||
				empty($request['rating']) ||
				!in_array($request['rating'], [1, 2, 3, 4, 5])
			   ) {
				   $this->respond(['error' => 'Missing or invalid field'], 422);
				   return;
			   }
			   if ($this->feedback->create($request)) {
				   $this->respond(['message'] => 'feedback submitted successfully'], 201);
			   } else {
				   $this->respond(['error' => 'Failed to submit feedback'], 500);
			   }
		}
		
		/* DELETE /api/feedback/{id} */
		public function destroy(int $id): void 
		{
			if ($this->feedback->delete($id)) {
				$this->respond(['message' => 'Feedback deleted successfully']);
			} else {
				$this->respond(['error' => 'Failed to delete feedback'], 500);
			}
		}
		
		/* JSON Response helper */
		private function respond(array $data, int $statusCode = 200): void 
		{
			http_response_code($statusCode);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}
	
			   
				
	
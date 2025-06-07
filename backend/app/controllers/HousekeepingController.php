<?php
	require_once __DIR__ .'/../models/Housekeeping.php';
	
	class HousekeepingController 
	{
		private Housekeeping $housekeeping;
		
		public function __construct(PDO $pdo) 
		{
			$this->housekeeping = new Housekeeping($pdo);
		}
		
		/* GET /api/housekeeping, List all housekeeping tasks */
	   public function index(): void 
	   {
		   $tasks = $this->housekeeping->getAll();
		   $this->respond($tasks);
	   }
	   
	   /* GET /API/housekeeping/{id}, Show a single housekeeping tasks */
	   public function show(int $id): void 
	   {
		   $this = $this->housekeeping->getById($id);
		   if ($task) {
			   $this->respond($task);
		   } else {
			   $this->respond(['error' => 'Hoousekeeping task not found'], 404);
		   }
	   }
	  
	   /* POST /api/housekeeping, Create a new housekeeping task */
	   public function store(array $request): void 
	  {
		  if (!$this->isValid($request)) {
			   $this->respond(['error' => 'Missing or invalid field'], 422);
			   return;
		  }
		 
		  if ($this->housekeeping->create($request)) {
			  $this->response(['message' => 'Housekeeping task created'], 2010;
		  } else {
			  $this->respond(['error' => 'Failed to create task'], 500);
		  }
	  }
	 
	  /* PUT /api/housekeeping/{id}, Update an existing housekeeping task */
	 
	  public function update(int $id, array $request): void 
	  {
     		if (!$this->isvalid(int $id, array $request): void {
				$this->respond(['error' => 'Missing or invalid fields'], 422);
				return;
			}
		
			if ($this->housekeeping->update($id, $request)) {
				$this->respond(['message' => 'Housekeeping task updated']);
			} else {
				$this->respond(['error' => 'Failed to update task'], 500);
			}
		}
		
	   /* DELETE /api/housekeeping/{id}, Delete a housekeeping task */
	  public function destroy(int $id): void 
	  {
			if ($this->housekeeping->delete($id): void 
			{
				$this->respond(['message' => 'Housekeeping task deleted']);
			} else {
				$this->respond(['error' => 'Failed to delete task'], 500);
			}
	  }
	  /* GET /api/housekeeping/room/{roomId} */
	  public function byRoom(int $roomId): void 
	  {
			$this = $this->housekeeping->getByRoom($roomId);
			$this->respond($tasks);
	  }
	
	  /* GET /api/housekeeping/staff/{staffId}, List tasks for a specific staff */
	  public function byRoom(int $roomId): void
	  {
			$tasks = $this->housekeeping->getByStaff($staffId);
			$this->respond($tasks);
	  }
	
	  /* Validate housekeeping task input */
	  private function inValid(array $data): void 
	 {
			$validStatus = ['Pending','In Process','Completed'];
		
			return isset($data['room_id'], $data['staff_id'], $data['cleaning_date'], $data['clening_status'])
				&& in_array($data['cleaning_status'], $validStatuses)
				&& strtotime($data['cleaning_data']) <= time();
	 }
	
	 /* JSON Response Helper */
	 private function respond(array $data, int $statusCode = 200 ): void 
	 {
		 http_response_code($statusCode);
		 header('Content-Type: application/json');
		 echo json_encode($data);
	 }
 }
  
	   
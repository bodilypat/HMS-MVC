<?php
	require_once __DIR__ .'/../models/Housekeeping.php';
	
	class HousekeepingController 
	{
		private Housekeeping $housekeeping;
		
		public function __construct(PDO $pdo) 
		{
			$this->housekeeping = new Housekeeping($pdo);
		}
		
		/* GET /api/housekeeping
           List all housekeeping tasks
	   */
	   public function index(): void 
	   {
		   $tasks = $this->housekeeping->getAllTasks();
		   $this->respond($tasks);
	   }
	   
	   /* POST /api/housekeeping
          Assign a housekeeping task (clean room X by staff Y)
          room_id, staff_id, task_description
	  */
	  public function assign(array $request): void 
	  {
		  if (empty($request['room_id']) || empty($request['staff_id']) || empty($request['task_description'])) {
			  $this->respond(['error' => 'Missing requried fields'], 422);
			  return;
		  }
		  $success = $this->housekeeping->assignTask($request);
		  
		  if ($success) {
			  $this->respond(['message' => 'Task assigned successfully'], 201);
		  } else {
			  $this->respond(['error' => 'Failed to assign task'], 500);
		  }
	  }
	  
	  /* Common JSON response */
	  private function respond(array $data, int $status = 200): void 
	  {
		  http_response_code($status);
		  header('Content-Type: application/json');
		  echo json_encode($data);
	  }
   }
		   
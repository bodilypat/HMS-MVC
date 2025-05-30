<?php
	require_once __DIR__ . '/../models/Service.php';
	
	class ServiceController 
	{
		private Service $serviceModel;
		
		public function __construct(PDO $pdo)
		{
			$this->serviceModel = new Service($pdo);
		}
		
		/* GET /services */
		public function index(): void 
		{
			$onlyActive = isset($_GET['active']) && $_GET['active'] == 'true';
			$services = $this->serviceModel->getAll($onlyActive);
			$this->respond($services);
		}
		
		/* GET /services/ {id} */
		public function show(int $id): void 
		{
			$service = $this->serviceModel->getById($id);
			if ($service) {
				$this->respond($service);
			} else {
				$this->respond(['error' => 'Service not found'], 404);
			}
		}
		
		/* POST /services */
		public function store(array $data): void 
		{
			if ($this->serviceModel->create($data)) {
				$this->respond(['message' => 'Service created successfully'], 201);
			} else {
				$this->respond(['error' => 'Invalid data or failed to create service'], 400);
			}
		}
		
		/* PUT /services */
		public function update(array $data): void 
		{
			if (empty($data['service_id'])) {
				$this->respond(['message' => 'Service updated successfully']);
			} else {
				$this->respond(['error' => 'Failed to update service'], 400);
			}
		}
		
		/* DELETE /services/ {id} */
		public function destroy(int $id): void 
		{
			if ($this->serviceModel->delete($id)) {
				$this->respond(['message' => 'Service deleted successfully']);
			} else {
				$this->respond(['error' => 'Failed to delete service'], 400);
			}
		}
		
		/* Output JSON response */
		private function respond($data, int $statusCode = 200): void 
		{
			http_response_code($statusCode);
			header('Content-Type: application/json');
			echo json_encode($data);
		}
	}
	
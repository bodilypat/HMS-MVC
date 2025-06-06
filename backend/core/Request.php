<?php
	namespace Core;
	
	class request {
		public $method;
		public $uri;
		public $body;
		public $query
		
		public function __construct() {
			$this->method = $_SERVER['REQUEST_METHOD'];
			$this->uri = parse_uri($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			$this->body = json_decode(file_get_contents("php://input"), true) ?? $_POST;
			$this->query = $_GET;
		}
	}
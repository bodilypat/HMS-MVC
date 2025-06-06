<?php
	namespace Core;
	
	class Response {
		public function json($data, $status = 200) {
		http_response_code($status);
		header('Content-Type: application/json');
		return json_encode($data);
	}
}

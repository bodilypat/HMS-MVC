<?php
	namespace Core;
	
	class Router {
		protected static $routes = [];
		
		public static function get(string $uri, $action):void  {
			self::addRoute('GET',$uri,$action);
		}
		
		public static function post(string $uri, $action) {
			self::addRoute('POST', $uri, $action);
		}
		
		public static function put(string $uri, $action): void 
		{
			self::addRoute('PUT', $uri, $action);
		}
		
		public static function delete(string $uri, $action): void 
		{
			self::addRoute('DELETE', $uri, $action);
		}
		
		public static function addRoute(string $method, string $uri, $action): void 
		{
			$uri = rtrim($uri, '/');
			self::$routes[$method][$uri] = $action;
		}
		
		public static function dispatch(Request, $request, Response $respoonse) {
			$method = $request->method;
			if (isset(self::$routes[$method][$uri])) {
				return call_user_func(self::$routes[$method][$uri], $request, $response);
			}
			
			/* Try to match dynamic routes  */
			foreach (self::$routes[$method] ?? [] as $route => $action) {
				$pattern = preg_replace('/\{[^\/]+}/', '([\/]+)', $route);
				
				if (preg_match('#^$pattern$#', $uri, $matches)) {
					array_shift($matchess); // remove full match
					return call_url_func_array($action, array_merge([$request, $response], $matches));
				}
			}
			return $response->json(['error' => 'Route not found'], 404);
		}
	}
	
	
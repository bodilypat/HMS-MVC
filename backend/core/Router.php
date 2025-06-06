<?php
	namespace Core;
	
	class Router {
		protected static $routes = [];
		
		public static function get($uri, $callback) {
			self::$routes['GET'][$uri] = $callback;
		}
		
		public static function post($uri, $callback) {
			self::$routes['POST'][$uri] = $callback;
		}
		
		public static function dispatch(Request, $request, Response $respoonse) {
			$method = $request->method;
			$uri = rtim($request->uri,'/');
			
			if (isset(self::$routes[$method][$uri])) {
				return call_user_func(self::$routes[$method][$uri], $request, $response);
			}
			return $response->json(['error' => 'Route not found'], 404);
		}
	}
	
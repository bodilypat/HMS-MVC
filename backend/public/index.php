<?php
	require_once '../config/config.php';
	require_once '../core/Router.php';
	require_once '../core/Request.php';
	require_once '../core/Response.php';
	
	/* Load routes */
	require_once '../routes/api.php';
	
	use Core\Router;
	use Core\Request;
	use Core\Response;
	
	$request = new Request;
	$response = new Response();
	
	/* Dispatch request */
	echo Router::dispatch($request, $response);
	

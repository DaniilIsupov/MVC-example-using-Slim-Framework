<?php

class GuestMiddleware extends Middleware {

	public function __invoke($request, $response, $next)
	{
		// if ($this->container->auth->check()) {
			return $response->withRedirect('/');
		// }
		$response = $next($request, $response);
		return $response;
	}
}
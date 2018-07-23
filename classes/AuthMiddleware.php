<?php

class AuthMiddleware extends BaseMiddleware
{
    public function __invoke($request, $response, $next)
    {
        if (!$this->container->auth->check()) {
            return $response->withRedirect($this->container->router->pathFor('login'));
        }
        $response = $next($request, $response);
        return $response;
    }
}

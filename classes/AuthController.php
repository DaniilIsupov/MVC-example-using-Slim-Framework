<?php

class AuthController extends BaseController
{

    public function login($request, $response)
    {
        return $this->view->render($response, '../view/login.phtml');
    }

    public function postLogin($request, $response)
    {
        $auth = $this->auth->attempt(
            $request->getParam('username'),
            $request->getParam('password')
        );
        if (!$auth) {
            return $response->withRedirect($this->router->pathFor('login'));
        }
        return $response->withRedirect('/');
    }

    public function logout($request, $response)
    {
        $this->auth->logout();
        return $response->withRedirect('/');
    }
}

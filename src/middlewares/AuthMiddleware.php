<?php

namespace src\middlewares;

use src\helpers\Auth;
use Slim\Http\Request;
use Slim\Http\Response;
use src\exceptions\AuthException;

/**
 * Class OldInputMiddleware
 * @author Jules Sayer <jules.sayer@protonmail.com>
 * @package src\middlewares
 */
class AuthMiddleware extends Middleware {

    /**
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next) {
        try {
            if (!Auth::check()) throw new AuthException();
        } catch(AuthException $e) {
            $this->container->flash->addMessage('error', 'Vous devez être connecté pour effectuer cette action.');
            return $response->withRedirect($this->container->router->pathFor('showLogin'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
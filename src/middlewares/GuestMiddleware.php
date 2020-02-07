<?php

namespace src\middlewares;

use src\exceptions\AuthException;
use src\helpers\Auth;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class OldInputMiddleware
 * @author Jules Sayer <jules.sayer@protonmail.com>
 * @package src\middlewares
 */
class GuestMiddleware extends Middleware {

    /**
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next) {
        try {
            if (Auth::check()) throw new AuthException();
        } catch(AuthException $e) {
            $this->container->flash->addMessage('error', 'Vous ne pouvez pas effectuer cette action en étant connecté.');
            return $response->withRedirect($this->container->router->pathFor('appHome'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
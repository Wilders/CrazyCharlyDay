<?php


namespace src\middlewares;

use Slim\Http\Request;
use Slim\Http\Response;
use src\exceptions\AuthException;
use src\helpers\Auth;

/*
 * Class AuthMiddleware
 * @author Flavien Chagras <flavien.chagras@protonmail.com>
 * @package src\middlewares
 */
class AdminMiddleware extends Middleware {
    /**
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next) {
        try {
            if (!Auth::check()) throw new AuthException();
            if (!Auth::user()->admin) throw new AuthException();
        } catch(AuthException $e) {
            $this->container->flash->addMessage('error', "Vous n'avez pas les permissions pour accéder à cette page.");
            return $response->withRedirect($this->container->router->pathFor('home'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
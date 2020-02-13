<?php

namespace src\controllers;

use src\exceptions\AuthException;
use src\helpers\Auth;
use src\models\User;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class AuthController
 * @author Jules Sayer <jules.sayer@protonmail.com>
 * @package src\controllers
 */
class AuthController extends Controller {

    public function showLogin(Request $request, Response $response, array $args): Response {
        $this->view->render($response, 'pages/login.twig');
        return $response;
    }

    public function logout(Request $request, Response $response, array $args): Response {
        Auth::logout();
        $response = $response->withRedirect($this->router->pathFor('showLogin'));
        return $response;
    }

    public function login(Request $request, Response $response, array $args): Response {
        try {
            $login = filter_var($request->getParsedBodyParam('id'), FILTER_SANITIZE_STRING);
            $password = filter_var($request->getParsedBodyParam('password'), FILTER_SANITIZE_STRING);

            if(!Auth::attempt($login, $password)) throw new AuthException();

            $response = $response->withRedirect($this->router->pathFor('home'));
        } catch (AuthException $e) {
            $this->flash->addMessage('error', "Identifiant ou mot de passe invalide.");
            $response = $response->withRedirect($this->router->pathFor('showLogin'));
        }
        return $response;
    }

    public function showHome(Request $request, Response $response, array $args): Response {
        $this->view->render($response, 'pages/home.twig', [
            "current_page" => "home"
        ]);
        return $response;
    }
}
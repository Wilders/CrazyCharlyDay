<?php

namespace src\controllers;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class AccountController
 * @author Jules Sayer <jules.sayer@protonmail.com>
 * @package src\controllers
 */
class AccountController extends Controller {

    /**
     * Appel home.twig
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function showAccount(Request $request, Response $response, array $args): Response {
        $this->view->render($response, 'pages/account.twig');
        return $response;
    }
}
<?php

namespace src\controllers;

use src\exceptions\RegistrationException;
use src\models\Registration;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class NicheController
 * @author Anthony Pernot <Anthony Pernot>
 * @package src\controllers
 */
class RegistrationController extends Controller{

    public function registrations(Request $request, Response $response, array $args) : Response {
        try{
            $registrations = Registration::get();

            $this->view->render($response, 'pages/registration.twig',[
                "registrations" => $registrations,
            ]);
            return $response;

        }catch (RegistrationException $e){
            $this->flash->addMessage('error', $e->getMessage());
            $response = $response->withRedirect($this->router->pathFor('showRegistration'));
        }
    }

}
<?php

namespace src\controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use src\exceptions\AuthException;
use src\models\User;
use src\helpers\Auth;


/**
 * Class AccountController
 * @author Jules Sayer <jules.sayer@protonmail.com>
 * @author Flavien Chagras <flavien.chagras@protonmail.com>
 * @package src\controllers
 */
class AccountController extends Controller {

    public function showMyProfile(Request $request, Response $response, array $args): Response {
        $this->view->render($response, 'pages/myprofile.twig');
        return $response;
    }

    public function showProfile(Request $request, Response $response, array $args): Response
    {
        $this->view->render($response, 'pages/profile.twig');
        return $response;
    }

    public function updateMyProfile(Request $request, Response $response, array $args): Response {
        try {
            $name = filter_var($request->getParsedBodyParam('name'), FILTER_SANITIZE_STRING);
            $forename = filter_var($request->getParsedBodyParam('forename'), FILTER_SANITIZE_STRING);
            $address = filter_var($request->getParsedBodyParam('address'), FILTER_SANITIZE_STRING);
            $email = filter_var($request->getParsedBodyParam('email'), FILTER_SANITIZE_EMAIL);
            $phone = filter_var($request->getParsedBodyParam('phone'), FILTER_SANITIZE_NUMBER_INT);
            $description = filter_var($request->getParsedBodyParam('description'), FILTER_SANITIZE_STRING);

            $user = Auth::user();

            if (mb_strlen($name, 'utf8') < 1 || mb_strlen($name, 'utf8') > 50) throw new AuthException("Votre nom doit contenir entre 2 et 50 caractères.");
            if (mb_strlen($forename, 'utf8') < 1 || mb_strlen($forename, 'utf8') > 50) throw new AuthException("Votre prénom doit contenir entre 2 et 50 caractères.");

            /**
             * @todo: vérifier numéro tel
             */

            if($user->email != $email){
                if (User::where('email', $email)->exists()) throw new AuthException("Cet email est déjà utilisée.");
            }

            $user->name = $name;
            $user->forename = $forename;
            $user->email = $email;
            $user->address = $address;
            $user->phone = $phone;
            $user->description = $description;
            $user->save();

            $response = $response->withRedirect($this->router->pathFor('home'));
        } catch (AuthException $e) {
            $this->flash->addMessage('error', $e->getMessage());
            $response = $response->withRedirect($this->router->pathFor("showAccount"));
        }
        return $response;
    }
}
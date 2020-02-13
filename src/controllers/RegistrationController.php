<?php

namespace src\controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use src\exceptions\RegistrationException;
use src\helpers\Auth;
use src\models\Need;
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

    public function inscription(Request $request, Response $response, array $args) : Response {
        try {
            $need = Need::where("id","=",$args['id'])->firstOrFail();
            if(Registration::where(["need_id" => $args['id']])->exists()) throw new RegistrationException();

            $registration = new Registration();
            $registration->user_id = Auth::user()->id;
            $registration->need_id = $need->id;
            $registration->recurring = 0;
            $registration->save();

            $this->flash->addMessage('success', "Vous avez bien été inscrit.");
            $response = $response->withRedirect($this->router->pathFor('showsNeedsNiche', ["id" => $need->niche_id]));
        } catch(ModelNotFoundException $e) {
            $this->flash->addMessage('error', $e->getMessage());
            $response = $response->withRedirect($this->router->pathFor('showsNeedsNiche', ["id" => $need->niche_id]));
        } catch(RegistrationException $e) {
            $this->flash->addMessage('error', "Impossible de s'inscrire.");
            $response = $response->withRedirect($this->router->pathFor('showsNeedsNiche', ["id" => $need->niche_id]));
        }
        return $response;
    }

}
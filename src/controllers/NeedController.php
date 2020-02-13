<?php


namespace src\controllers;

use src\models\Need;
use src\models\Role;
use src\exceptions\NeedException;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class NeedController
 * @package src\controllers
 * @author Nathan CHEVALIER
 */
class NeedController extends Controller {

    public function showNeeds(Request $request, Response $response, array $args) : Response {
        try{
            $need = Need::select()->get();

            $this->view->render($response, 'pages/need.twig',[
                "needs" => $need
            ]);
            return $response;
        }catch(NeedException $e){
            $this->flash->addMessage('error', "Vous rencontrez un problème pour la création d'un besoin, veuillez réessayer ultérieurement.");
            $response = $response->withRedirect($this->router->pathFor('home'));
        }
    }

    public function createNeed(Request $request, Response $response, array $args) : Response {
        try{
            $niche_id = filter_var($request->getParsedBodyParam('id_niche'), FILTER_SANITIZE_NUMBER_INT);
            $role_id = filter_var($request->getParsedBodyParam('day'), FILTER_SANITIZE_NUMBER_INT);

            $need = new Need();
            $need->niche_id = $niche_id;
            $need->role_id = $role_id;
            $need->save();

            $this->flash->addMessage('success', "Votre besoin a bien été enregistré.");
            $response = $response->withRedirect($this->router->pathFor('showAdmin'));

        }catch (NeedException $e){
            $this->flash->addMessage('error', "Vous rencontrez un problème pour la création d'un besoin, veuillez réessayer ultérieurement.");
            $response = $response->withRedirect($this->router->pathFor('home'));
        }
    }

}
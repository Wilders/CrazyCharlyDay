<?php


namespace src\controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use src\helpers\Auth;
use src\models\Need;
use src\models\Niche;
use src\models\Registration;
use src\models\Role;
use src\exceptions\NeedException;

use Slim\Http\Request;
use Slim\Http\Response;
use src\models\User;

/**
 * Class NeedController
 * @package src\controllers
 * @author Nathan CHEVALIER
 */
class NeedController extends Controller {

    public function showAll(Request $request, Response $response, array $args) : Response {
        $needs = Need::all();
        $roles = Role::all();
        $registrations = Registration::all();
        $this->view->render($response, 'pages/needs.twig',[
            "needs" => $needs,
            "roles" => $roles,
            "registrations" => $registrations,
            "current_page" => "needs"
        ]);
        return $response;
    }

    public function showCreateNeed(Request $request, Response $response, array $args) : Response {
        try {
            $niche = Niche::where("id","=",$args['id'])->firstOrFail();
            $this->view->render($response, 'pages/admin/needCreation.twig',[
                "niche" => $niche,
                "roles" => Role::all()
            ]);
        } catch(ModelNotFoundException $e) {
            $this->flash->addMessage('error', "Ce créneau n'existe pas.");
            $response = $response->withRedirect($this->router->pathFor('showAdmin'));
        }
        return $response;
    }

    public function createNeed(Request $request, Response $response, array $args) : Response {
        try{
            $role_id = filter_var($request->getParsedBodyParam('role'), FILTER_SANITIZE_NUMBER_INT);

            $need = new Need();
            $need->niche_id = $args['id'];
            $need->role_id = $role_id;
            $need->save();

            $this->flash->addMessage('success', "Votre besoin a bien été enregistré.");
            $response = $response->withRedirect($this->router->pathFor('showAdmin'));

        }catch (NeedException $e){
            $this->flash->addMessage('error', "Vous rencontrez un problème pour la création d'un besoin, veuillez réessayer ultérieurement.");
            $response = $response->withRedirect($this->router->pathFor('home'));
        }
        return $response;
    }

    public function updateNeed(Request $request, Response $response, array $args) : Response {
        try{
            $idNeed = filter_var($request->getParsedBodyParam("idneed"), FILTER_SANITIZE_NUMBER_INT);
            $idNiche = filter_var($request->getParsedBodyParam("idniche"), FILTER_SANITIZE_NUMBER_INT);
            $idRole = filter_var($request->getParsedBodyParam("idrole"), FILTER_SANITIZE_NUMBER_INT);

            $need = Need::where("id","=",$idNeed)->firstOrFail();
            $need->niche_id = $idNiche;
            $need->role_id = $idRole;
            $need->save();

            $this->flash->addMessage('success', "Votre besoin a bien été remis à jour.");
            $response = $response->withRedirect($this->router->pathFor('showAdmin'));
        }catch(NeedException $e){
            $this->flash->addMessage('error', "Vous rencontrez un problème pour la modification d'un besoin, veuillez réessayer ultérieurement.");
            $response = $response->withRedirect($this->router->pathFor('home'));
        }
        return $response;
    }

    public function deleteNeed(Request $request, Response $response, array $args) : Response {
        try{

            $idNeed = filter_var($request->getParsedBodyParam("idneed"), FILTER_SANITIZE_NUMBER_INT);
            $need = Need::where("id","=",$idNeed)->firstOrFail();
            $need->destroy();
            $this->flash->addMessage('success', "Votre besoin a bien été supprimé.");
            $response = $response->withRedirect($this->router->pathFor('showAdmin'));
        }catch(NeedException $e){
            $this->flash->addMessage('error', "Vous rencontrez un problème pour la suppression d'un besoin, veuillez réessayer ultérieurement.");
            $response = $response->withRedirect($this->router->pathFor('home'));
        }
        return $response;
    }

    public function showNeedsNiche(Request $request, Response $response, array $args) : Response {
        try{
            $needs = Need::where('niche_id',$args['id'])->get();
            $roles = Role::all();
            $registered = Registration::where('user_id', Auth::user()->id)->get();
            $registrations = Registration::all();
            $this->view->render($response, 'pages/needniche.twig',[
                "current_page" => "need",
                "needs" => $needs,
                "roles" => $roles,
                "registrations" => $registrations,
                "registered" => $registered
            ]);
        } catch (ModelNotFoundException $e) {
            $this->flash->addMessage('error', $e->getMessage());
            $response = $response->withRedirect($this->router->pathFor("home"));
        }
        return $response;
    }
}
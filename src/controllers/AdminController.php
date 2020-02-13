<?php


namespace src\controllers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;
use src\models\User;

/**
 * Class AdminController
 * @author Flavien Chagras <flavien.chagras@protonmail.com>
 * @package src\controllers
 */
class AdminController extends Controller{
    public function showAdmin(Request $request, Response $response, array $args): Response {
        $users = User::All();
        $this->view->render($response, 'pages/admin.twig',[
            "current_page" => "admin",
            "users" => $users,
            "nbUsers" => $users->Count()
        ]);
        return $response;
    }

    public function deleteUser(Request $request, Response $response, array $args): Response{
        try {
            $id = filter_var($args['id'], FILTER_SANITIZE_STRING);

            $user = User::where('id',$id)->firstOrFail();
            $user->delete();
            $this->flash->addMessage('success', "L'utilisateur a bien été supprimé !");
        } catch (ModelNotFoundException $e) {
            $this->flash->addMessage('error', 'Nous n\'avons pas pu supprimer cet utilisateur.');
        } catch (Exception $e) {
            $this->flash->addMessage('error', $e->getMessage());}
        return $response->withRedirect($this->router->pathFor('showAdmin'));;
    }

    public function updateUser(Request $request, Response $response, array $args): Response{

    }
}
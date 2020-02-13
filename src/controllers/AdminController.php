<?php


namespace src\controllers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Slim\Http\Request;
use Slim\Http\Response;
use src\exceptions\AuthException;
use src\helpers\Auth;
use src\models\User;

/**
 * Class AdminController
 * @author Flavien Chagras <flavien.chagras@protonmail.com>
 * @package src\controllers
 */
class AdminController extends Controller{
    public function showAdmin(Request $request, Response $response, array $args): Response {
        $users = User::All();
        $this->view->render($response, 'pages/admin/admin.twig',[
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

    public function updateProfile(Request $request, Response $response, array $args): Response{
        try {
            $id = filter_var($args['id'], FILTER_SANITIZE_STRING);
            $name = filter_var($request->getParsedBodyParam('name'), FILTER_SANITIZE_STRING);
            $forename = filter_var($request->getParsedBodyParam('forename'), FILTER_SANITIZE_STRING);
            $address = filter_var($request->getParsedBodyParam('address'), FILTER_SANITIZE_STRING);
            $email = filter_var($request->getParsedBodyParam('email'), FILTER_SANITIZE_EMAIL);
            $phone = filter_var($request->getParsedBodyParam('phone'), FILTER_SANITIZE_NUMBER_INT);
            $description = filter_var($request->getParsedBodyParam('description'), FILTER_SANITIZE_STRING);

            $user = User::where('id',$id)->firstOrFail();

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

            $this->flash->addMessage('success', "Votre modification a été enregistrée");
            $response = $response->withRedirect($this->router->pathFor('updateProfileAdmin', ['id' => $id]));
        } catch (AuthException $e) {
            $this->flash->addMessage('error', $e->getMessage());
            $response = $response->withRedirect($this->router->pathFor("showAdmin"));
        }
        return $response;
    }

    public function updateProfileAdmin(Request $request, Response $response, array $args): Response
    {
        $id = filter_var($args['id'], FILTER_SANITIZE_STRING);
        $user = User::where('id', $id)->firstOrFail();
        $this->view->render($response, 'pages/admin/profile.twig',[
            'user' => $user
        ]);
        return $response;
    }

    public function register(Request $request, Response $response, array $args): Response {
        try {
            $name = filter_var($request->getParsedBodyParam('name'), FILTER_SANITIZE_STRING);
            $forename = filter_var($request->getParsedBodyParam('forename'), FILTER_SANITIZE_STRING);
            $username = filter_var($request->getParsedBodyParam('username'), FILTER_SANITIZE_STRING);
            $address = filter_var($request->getParsedBodyParam('address'), FILTER_SANITIZE_STRING);
            $email = filter_var($request->getParsedBodyParam('email'), FILTER_SANITIZE_EMAIL);
            $password = filter_var($request->getParsedBodyParam('password'), FILTER_SANITIZE_STRING);
            $password_conf = filter_var($request->getParsedBodyParam('password_conf'), FILTER_SANITIZE_STRING);
            $phone = filter_var($request->getParsedBodyParam('phone'), FILTER_SANITIZE_STRING);
            $obligations = filter_var($request->getParsedBodyParam('obligations'), FILTER_SANITIZE_STRING);
            $description = filter_var($request->getParsedBodyParam('description'), FILTER_SANITIZE_STRING);

            if (mb_strlen($username, 'utf8') < 3 || mb_strlen($username, 'utf8') > 35) throw new AuthException("Votre pseudo doit contenir entre 3 et 35 caractères.");
            if (mb_strlen($name, 'utf8') < 1 || mb_strlen($name, 'utf8') > 50) throw new AuthException("Votre nom doit contenir entre 2 et 50 caractères.");
            if (mb_strlen($forename, 'utf8') < 1 || mb_strlen($forename, 'utf8') > 50) throw new AuthException("Votre prénom doit contenir entre 2 et 50 caractères.");
            if (mb_strlen($password, 'utf8') < 8) throw new AuthException("Votre mot de passe doit contenir au moins 8 caractères.");
            if (User::where('username', '=', $username)->exists()) throw new AuthException("Ce pseudo est déjà pris.");
            if (User::where('email', '=', $email)->exists()) throw new AuthException("Cet email est déjà utilisée.");
            if ($password != $password_conf) throw new AuthException("La confirmation du mot de passe n'est pas bonne.");

            $user = new User();
            $user->name = $name;
            $user->forename = $forename;
            $user->username = $username;
            $user->email = $email;
            $user->address = $address;
            $user->password = password_hash($password_conf, PASSWORD_DEFAULT);
            $user->phone = $phone;
            $user->picture = 'default.jpg';
            if ($obligations==''){
                $obligations = 3;
            }
            $user->obligations = $obligations;
            $user->absences = 0;
            $user->description = $description;
            $user->admin = 0;
            $user->first = 1;
            $user->save();

            $this->flash->addMessage('success', "Le compte a été créé! Vous pouvez dès à présent vous connecter.");
            $response = $response->withRedirect($this->router->pathFor('showLogin'));
        } catch (AuthException $e) {
            $this->flash->addMessage('error', $e->getMessage());
            $response = $response->withRedirect($this->router->pathFor("showRegister"));
        }
        return $response;
    }

    public function showRegister(Request $request, Response $response, array $args): Response {
        $this->view->render($response, 'pages/admin/register.twig');
        return $response;
    }

}
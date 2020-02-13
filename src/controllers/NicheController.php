<?php

namespace src\controllers;

use src\exceptions\NicheException;
use src\models\Niche;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class NicheController
 * @author Anthony Pernot <Anthony Pernot>
 * @package src\controllers
 */
class NicheController extends Controller{

    public function showNiche(Request $request, Response $response, array $args) : Response {
        $this->view->render($response, 'pages/niche.twig');
        return $response;
    }

}
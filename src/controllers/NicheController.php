<?php

namespace src\controllers;

use src\exceptions\NicheException;
use src\models\Niche;

use Slim\Http\Request;
use Slim\Http\Response;

class NicheController extends Controller{

    public function showNiches(Request $request, Response $response, array $args) : Response {
            $niches = Niche::all();

            $this->view->render($response, 'pages/niches.twig',[
                "niches" => $niches
            ]);
        return $response;
    }

    public function addNiche(Request $request, Response $response, array $args) : Response {
        try{
            $day = filter_var($request->getParsedBodyParam('day'), FILTER_SANITIZE_NUMBER_INT);
            $week = filter_var($request->getParsedBodyParam('week'), FILTER_SANITIZE_SPECIAL_CHARS);
            $begin = filter_var($request->getParsedBodyParam("begin"), FILTER_SANITIZE_NUMBER_INT);
            $end = filter_var($request->getParsedBodyParam("end"), FILTER_SANITIZE_NUMBER_INT);
            $cycle = filter_var($request->getParsedBodyParam("cycle"), FILTER_SANITIZE_NUMBER_INT);

            is_null($request->getParsedBodyParam("statut"))? $statut = 0 : $statut = 1;
            if($begin>=$end) throw new NicheException("L'heure de début est supérieure ou égale à l'heure de fin");
            if($day != (1 || 2 || 3 || 4 || 5 || 6 || 7)) throw new NicheException("Le jour sélectionnée ne peut pas être choisi");
            if($week != ("A" || "B" || "C" || "D")) throw new NicheException("La semaine sélectionnée ne peut pas etre choisi");
            if (Niche::where(['begin' => $begin, 'end' => $end, 'day' => $day, 'week' => $week, 'cycle_id' => $cycle])->exists()) throw new NicheException("Ce créaneau est déjà pris.");

            $niche = new Niche();
            $niche->day = $day;
            $niche->week = $week;
            $niche->begin = $begin;
            $niche->end = $end;
            $niche->cycle_id = $cycle;
            $niche->statut = $statut;
            $niche->save();

            $this->flash->addMessage('success', "Votre créneau a bien été enregistré.");
            $response = $response->withRedirect($this->router->pathFor('showAdmin'));

        }catch (NicheException $e){
            $this->flash->addMessage('error', $e->getMessage());
            $response = $response->withRedirect($this->router->pathFor('formNiche'));
        }
        return $response;
    }

    public function formNiche(Request $request, Response $response, array $args) : Response{
        $this->view->render($response, 'pages/nicheCreation.twig');
        return $response;
    }
}
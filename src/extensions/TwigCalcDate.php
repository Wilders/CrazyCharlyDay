<?php

namespace src\extensions;

use Exception;
use src\helpers\DateHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class TwigCalcDate
 * @author Jules Sayer <jules.sayer@protonmail.com>
 * @package src\extensions
 */
class TwigCalcDate extends AbstractExtension {

    /**
     * Nom de l'extension
     *
     * @return string
     */
    public function getName() {
        return 'slim-twig-calcdate';
    }

    /**
     * Callback pour twig.
     *
     * @return array
     */
    public function getFunctions() {
        return [
            new TwigFunction('calcdate', [$this, 'calcdate']),
        ];
    }

    public function calcdate($ancre, $semaine, $jour, $cycle = 0) {
        try {
            return DateHelper::calc_date($ancre, $semaine, $jour, $cycle);
        } catch (Exception $e) {
        }
    }
}
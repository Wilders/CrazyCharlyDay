<?php

namespace src\helpers;

use DateTime;
use Exception;
use DateInterval;

/**
 * Class DateHelper
 * @author Anthony Pernot <Anthony Pernot>
 * @package src\helpers
 */
class DateHelper {

    static function calc_date($ancre, $semaine, $jour, $cycle = 0) {
        $nb_jours = $cycle * 28 + (ord($semaine) - ord('A')) * 7 + $jour - 1;
        $date_init = new DateTime($ancre);
        $date_res = $date_init->add(new DateInterval('P' . $nb_jours . 'D'))->format('U');
        return strftime('%e/%m/%Y', $date_res);
    }
}
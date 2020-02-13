<?php


namespace src\models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Niche
 * @package src\models
 */
class Niche extends Model{
    public $timestamps = false;
    protected $table = "niche";
    protected $primaryKey = "id";
    protected $fillable = [
        'begin',
        'end',
        'day',
        'week',
        'cycle_id',
        'statut'
    ];
}
<?php


namespace src\models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Registration
 * @package src\models
 */
class Registration extends Model {
    public $timestamps = false;
    protected $table = "registration";
    protected $primaryKey = "id";
    protected $fillable = [
        'user_id',
        'need_id',
        'recurring'
    ];
}
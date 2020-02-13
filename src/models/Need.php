<?php


namespace src\models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Need
 * @package src\models
 */
class Need extends Model {
    public $timestamps = false;
    protected $table = "need";
    protected $primaryKey = "id";
    protected $fillable = [
        'niche_id',
        'role_id'
    ];
}
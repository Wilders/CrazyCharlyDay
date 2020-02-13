<?php


namespace src\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package src\models
 */
class Role extends Model{
    public $timestamps = false;
    protected $table = "role";
    protected $primaryKey = "id";
    protected $fillable = [
        'label'
    ];

}
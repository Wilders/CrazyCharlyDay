<?php

namespace src\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class User
 * @package src\models
 */
class User extends Model {
    public $timestamps = false;
    protected $table = "users";
    protected $primaryKey = "id";
    protected $fillable = [
        'pseudo',
        'email',
        'password',
        'name',
        'forename',
        'address'
    ];
}
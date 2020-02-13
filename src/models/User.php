<?php

namespace src\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class User
 * @package src\models
 */
class User extends Model {
    public $timestamps = true;
    protected $table = "user";
    protected $primaryKey = "id";
    protected $fillable = [
        'username',
        'email',
        'password',
        'name',
        'forename',
        'address',
        'amdin',
        'phone',
        'obligations',
        'absences',
        'first',
        'picture',
        'description'
    ];
}
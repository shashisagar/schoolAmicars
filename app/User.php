<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * It have existing DB table name and it connect to this model with existing DB table
     */
    protected $table = 'users';

    /**
     * It have existing table's primary Key column name and it connect to this model with existing table's primary Key
     * Primary key should have always auto increment property.
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'email', 'password', 'profilepic', 'role', 'status', 'schools_id'];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['password', 'remember_token'];
}

<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model
{

    public $table = 'roles';

    protected $fillable = [
        'name', 'permissions'
    ];
}

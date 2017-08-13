<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $fillable = ["id", "name", "lastname", "gender", "telephone_number", "direction", "email", "birth_date"];

    public function Accounts()
    {
        return $this->hasMany('App\Account');
    }
}

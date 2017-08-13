<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = "accounts";
    protected $fillable=["number","amount", "password", "type", "user_id"];

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function deposits()
    {
        return $this->hasMany("App\Deposit");
    }
    public function credits()
    {
        return $this->hasMany("App\Credit");
    }
    public function withdrawls()
    {
        return $this->hasMany("App\Withdrawl");
    }
    public function transfers()
    {
        return $this->hasMany("App\Transfer");
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = "deposits";
    protected $fillable = ["amount", "account_number"];

    public function account()
    {
        return $this->belongsTo("App\Account");
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $table = "credits";
    protected $fillable = ["amount", "final_date","percentage", "fee", "cost", "account_number"];

    public function account()
    {
        return $this->belongsTo("App\Account");
    }

    public function payments()
    {
        return $this->hasMany("App\Payment");
    }
}

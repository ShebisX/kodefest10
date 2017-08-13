<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdrawl extends Model
{
    protected $table = "withdrawls";
    protected $fillable = ["amount", "account_number"];

    public function account()
    {
        return $this->belongsTo("App\Account");
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = "transfers";
    protected $fillable = ["amount", "account_number", "to", "from"];

    public function account()
    {
        return $this->belongsTo("App\Account");
    }
}

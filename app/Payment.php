<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "payments";
    protected $fillable = ["credit_id"];

    public function credit()
    {
        return $this->belongsTo("App\Credit");
    }
}

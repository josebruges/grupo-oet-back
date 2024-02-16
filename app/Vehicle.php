<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
    protected $fillable = ['plate','model','picture','setting_id','bodywork_id','user_id'];


    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

    public function bodywork()
    {
        return $this->belongsTo(Bodywork::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

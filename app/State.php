<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public function communities() {
        return $this->hasOne('App\community');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uygulama extends Model
{
    use HasFactory;

    public function getPeriods () {
        return $this->hasMany('App\Models\InternshipPeriot', 'uygulama_id', 'id');
    }
}

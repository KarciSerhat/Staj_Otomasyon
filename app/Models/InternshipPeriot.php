<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipPeriot extends Model
{
    use HasFactory;

    public function getUygulama () {
        return $this->belongsTo('App\Models\Uygulama', 'uygulama_id', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class Company extends Model
{
    protected $fillable=['name','number','adres','vergi_no','order_data'];
    protected $table='companies';

    public function getApplication () {
        return $this->hasOne('App\Models\Application', 'company_id', 'id');
    }
}

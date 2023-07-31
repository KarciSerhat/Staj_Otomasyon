<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateOfInternship extends Model
{
    protected $fillable=['start_date','expire_date'];
    protected $table='date_of_internships';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    public function getCompany () {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    public function getStatus () {
        return $this->belongsTo('App\Models\Status', 'status_id', 'id');
    }

    public function getDocument () {
        return $this->belongsTo('App\Models\StudentDocument', 'student_document_id', 'id');
    }

    public function getPeriot () {
        return $this->belongsTo('App\Models\InternshipPeriot', 'internship_periot', 'id');
    }

    public function getUser () {
        return $this->belongsTo('App\Models\User', 'student_id', 'id');
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentCompany;
use App\Models\User;
use Illuminate\Http\Request;

class StudentInfoApiController extends Controller
{
    public function getStudent(Request $request){
    $company = StudentCompany::where('company_id',$request->company_id)->first();
    $student = User::where('id',$company->student_id)->get();
    if($student){
        return response()->json(['code'=>200,'data'=>$student]);
    }
        return response()->json(['code'=>500,'Error']);

    }
}

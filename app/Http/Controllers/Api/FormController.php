<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Input;
use App\Models\InputValue;
use App\Models\UserForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function getFormDetails(Request $request){
        $validator = Validator::make($request->all(), [
            'form_id'=>'integer|required',
            'user_id'=>'integer|required'
        ]);
        if($validator->fails()){
            return response()->json(['Validation Error.', $validator->errors()]);
        }
        $formDatas = array();
        $formInputs = Input::where('form_id',$request->form_id)->get();  //id si request->id olan forma ait tüm inputlar getirildi
        if (Auth::user()->is_student == 1){
            foreach ($formInputs as $inputs){
                $inpVal = InputValue::where('user_id',Auth::user()->id)->where('input_id',$inputs->id)->first()->value;
                array_push($formDatas,$inpVal);
            }
            return response()->json(['code'=>200,'data'=>$formDatas]);
        }
        foreach ($formInputs as $inputs){
            $inpVal = InputValue::where('user_id',$request->user_id)->where('input_id',$inputs->id)->first()->value;
            array_push($formDatas,$inpVal);
        }
        return response()->json(['code'=>200,'data'=>$formDatas]);
    }
    public function postFormDatas(Request $request){
        $validator = Validator::make($request->all(), [
            'form_id'=>'integer|required',
        ]);
        if($validator->fails()){
            return response()->json(['Validation Error.', $validator->errors()]);
        }
        $formInputs = Input::where('form_id',$request->form_id)->get();  //id si request->id olan forma ait tüm inputlar getirildi
        $userForm = new UserForm();
        $userForm->user_id = Auth::user()->id;
        $userForm->form_id = $request->form_id;
        $userForm->save();
        foreach ($formInputs as $input){
            $field = $input->name;
            $inputVal = new InputValue();
            $inputVal->user_id = Auth::user()->id;
            $inputVal->input_id = $input->id;
            $inputVal->value  = $request->$field;
            $inputVal->save();
        }
        return response()->json(['code'=>200]);

    }
}

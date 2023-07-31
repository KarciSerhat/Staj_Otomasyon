<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Mail\CompanyLoginMail;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use OpenApi\Annotations as OA;

class CompanyApiController extends Controller
{
    /**
     * @OA\Get (
     *     tags={"Şirket"},
     *     path="/api/v1/company/all",
     *     description="Şirketleri getir",
     *     @OA\Response(response="200", description="Ok"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */

    public function getAll(){
        $companies = Company::where('is_deleted',0)->get();
        if (!$companies){
            return response()->json(['company'=>'not_found']);
        }
        return response()->json(['companies'=>$companies]);
    }

    /**
     * @OA\Get (
     *     tags={"Şirket"},
     *     path="/api/v1/company/get",
     *     description="Şirketleri id'ye göre getir",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Parametre açıklaması",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Ok"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function getCompany(Request $request){
        $request->validate([
            'id' => ['required', 'integer']
        ]);
        $company = Company::where('id',$request->id)->first();
        if (!$company){
            return response()->json(['company'=>'not_found']);
        }

        return response()->json(['company'=>$company]);
    }

    /**
     * @OA\Post (
     *     tags={"Şirket"},
     *     path="/api/v1/company/create",
     *     description="Şirket oluştur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"name", "number", "adres", "vergi_no", "order_data"},
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="number", type="integer"),
     *                 @OA\Property(property="adres", type="string"),
     *                 @OA\Property(property="vergi_no", type="string"),
     *                 @OA\Property(property="order_data", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function createCompany(Request $request){
        $request->validate([
            'name'=>'string|| required',
            'number'=>'integer || required',
            'adres'=>'string || required',
            'vergi_no'=>'string || required',
            'order_data'=>'string || required',
        ]);
        $company = new Company();
        $company->name = $request->name;
        $company->number = $request->number;
        $company->vergi_no = $request->vergi_no;
        $company->adres = $request->adres;
        $company->order_data = $request->order_data;
        if (!$company){
            return response()->json(['status'=>500,'company'=>"bilinmeyen bir hata oluştu"]);
        }
        $company->save();
        return response()->json(['status'=>200,'company'=>$company]);
    }
    /**
     * @OA\Post (
     *     tags={"Şirket"},
     *     path="/api/v1/company/update",
     *     description="Şirket Güncelle",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"id"},
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="number", type="integer"),
     *                 @OA\Property(property="adres", type="string"),
     *                 @OA\Property(property="vergi_no", type="string"),
     *                 @OA\Property(property="order_data", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function updateCompany(Request $request){
        $request->validate([
            'id'=>'integer||required',
            'name'=>'string',
            'number'=>'integer ',
            'adres'=>'string ',
            'vergi_no'=>'string ',
            'order_data'=>'string ',
        ]);
        $company = Company::where('id',$request->id)->first();
        if (!$company){
            return response()->json(['company'=>'not_found']);
        }
        $company->name = $request->name;
        $company->number = $request->number;
        $company->vergi_no = $request->vergi_no;
        $company->adres = $request->adres;
        $company->order_data = $request->order_data;

        $company->save();
        return response()->json(['status'=>200,'company'=>$company]);
    }
    /**
     * @OA\Post (
     *     tags={"Şirket"},
     *     path="/api/v1/company/delete",
     *     description="Şirket Sil",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"id"},
     *                 @OA\Property(property="id", type="integer"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function deleteCompany(Request $request){
        $request->validate([
            'id'=>'integer || required',
        ]);
        $company = Company::where('id',$request->id)->first();
        if (!$company){
            return response()->json(['company'=>'not_found']);
        }
        $company->is_deleted = 1;
        $company->save();
        return response()->json(['status'=>200]);
    }
    /**
     * @OA\Post (
     *     tags={"Şirket"},
     *     path="/api/v1/company/checkCompany",
     *     description="Şirket Sorgula",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"vergi_no"},
     *                 @OA\Property(property="vergi_no", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function checkCompany(Request $request){
        $company = Company::where('vergi_no',$request->vergi_no)->first();
        if(isset($company)){
            Mail::to($company->company_mail)->send(new CompanyLoginMail($company));
            return response()->json(['company'=>$company]);
        }
        return response()->json(['company'=>'not_found']);
    }
}

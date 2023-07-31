<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InternshipPeriot;
use Illuminate\Http\Request;

class InternshipPeriotApiController extends Controller
{
    /**
     * @OA\Get  (
     *     tags={"Staj Dönemi"},
     *     path="/api/v1/internshipperiot/all",
     *     description="Staj Dönemlerini Getir",
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function getAll()
    {
        $periot = InternshipPeriot::where('is_deleted',0)->get();
        if (!$periot){
            return response()->json(['periot'=>'not_found']);
        }

        return response()->json(['internship_periots' => $periot]);
    }
    /**
     * @OA\Get (
     *     tags={"Staj Dönemi"},
     *     path="/api/v1/internshipperiot/get",
     *     description="Staj Dönemini id'ye göre getir",
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
    public function getPeriot(Request $request){
        $request->validate([
            'id' => ['required', 'integer']
        ]);
        $periot = InternshipPeriot::where('id',$request->id)->first();
        if (!$periot){
            return response()->json(['periot'=>'not_found']);
        }

        return response()->json(['internship_periot' => $periot]);
    }
    /**
     * @OA\Post (
     *     tags={"Staj Dönemi"},
     *     path="/api/v1/internshipperiot/create",
     *     description="Staj Dönemi Oluştur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"periot_start_date", "expire_date", "periot_type"},
     *                 @OA\Property(property="periot_start_date", type="string", format="date", date_format="m/d/Y"),
     *                 @OA\Property(property="periot_expire_date", type="string", format="date", date_format="m/d/Y"),
     *                 @OA\Property(property="periot_type", type="integer"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function create(Request $request)
    {
        $request->validate([
            'periot_start_date' => 'required|date',
            'periot_expire_date' => 'required|date',
            'periot_type' => 'required',
        ]);
        $periot = new InternshipPeriot();
        $periot->start_date = $request->periot_start_date;
        $periot->expire_date = $request->periot_expire_date;
        $periot->type = strip_tags($request->periot_type);

        if (!$periot) {
            return response()->json(['status' => 500, 'internship_periots' => "bilinmeyen bir hata oluştu"]);
        }
        $periot->save();
        return response()->json(['status' => 200, 'internship_periots' => $periot]);

    }
    /**
     * @OA\Post (
     *     tags={"Staj Dönemi"},
     *     path="/api/v1/internshipperiot/update",
     *     description="Staj Dönemi Güncelle",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"id", "periot_start_date", "expire_date", "periot_type"},
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="periot_start_date", type="string", format="date", date_format="m/d/Y"),
     *                 @OA\Property(property="periot_expire_date", type="string", format="date", date_format="m/d/Y"),
     *                 @OA\Property(property="periot_type", type="integer"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function update(Request $request)
    {
            $request->validate([
            'periot_start_date' => 'date',
            'periot_expire_date' => 'date',
            'periot_type' => 'required',
            'id' => 'required',
        ]);
        $periot = InternshipPeriot::where('id' ,$request->id)->first();
        if (!$periot){
            return response()->json(['periot'=>'not_found']);
        }
        $periot->start_date = $request->periot_start_date;
        $periot->expire_date = $request->periot_expire_date;
        $periot->type = strip_tags($request->periot_type);

        if (!$periot) {
            return response()->json(['status' => 500, 'internship_periots' => "bilinmeyen bir hata oluştu"]);
        }
        $periot->save();
        return response()->json(['status' => 200, 'internship_periots' => $periot]);
    }
    /**
     * @OA\Post (
     *     tags={"Staj Dönemi"},
     *     path="/api/v1/internshipperiot/delete",
     *     description="Staj Dönemi Sil",
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
    public function delete(Request $request){
        $periot=InternshipPeriot::find($request->id);
        if (!$periot){
            return response()->json(['periot'=>'not_found']);
        }
        $periot->is_deleted = 1;
        $periot->save();
       return response()->json(['status'=>200]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DateOfInternship;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DateOfInternshipApiController extends Controller
{
    /**
     * @OA\Get  (
     *     tags={"Staj Tarihi"},
     *     path="/api/v1/dateofintern/all",
     *     description="Staj Tarihlerini Getir",
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function getAll(){
          $dateOfInternship = DateOfInternship::where('is_deleted',0)->get();
        if (!$dateOfInternship){
            return response()->json(['dateIntern'=>'not_found']);
        }
          return response()->json(['date_of_internship' => $dateOfInternship]);
    }
    /**
     * @OA\Get (
     *     tags={"Staj Tarihi"},
     *     path="/api/v1/dateofintern/get",
     *     description="Staj Tarihlerini id'ye Göre Getir",
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
    public function getDateOfIntern(Request $request){
        $dateIntern = DateOfInternship::where('id',$request->id)->first();
        if (!$dateIntern){
            return response()->json(['dateIntern'=>'not_found']);
        }

        return response()->json(['date_of_internship'=>$dateIntern]);
    }
    /**
     * @OA\Post (
     *     tags={"Staj Tarihi"},
     *     path="/api/v1/dateofintern/create",
     *     description="Staj Tarihi Oluştur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"start_date", "expire_date"},
     *                 @OA\Property(property="start_date", type="string", format="date", date_format="m/d/Y"),
     *                 @OA\Property(property="expire_date", type="string", format="date", date_format="m/d/Y"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function createDateOfIntern(Request $request){
        $request->validate([
            'start_date' => 'date || required',
            'expire_date' => 'date || required'
        ]);
        $dateIntern= new DateOfInternship();
        $dateIntern->start_date = $request->start_date;
        $dateIntern->expire_date = $request->expire_date;

        if (!$dateIntern){
            return response()->json(['dateIntern'=>'not_found']);
        }
        $dateIntern->save();
        return response()->json(['status'=>200,'date_of_internship'=>$dateIntern]);
    }
    /**
     * @OA\Post (
     *     tags={"Staj Tarihi"},
     *     path="/api/v1/dateofintern/update",
     *     description="Staj Tarihi Güncelle",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"id"},
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="start_date", type="string", format="date", date_format="m/d/Y"),
     *                 @OA\Property(property="expire_date", type="string", format="date", date_format="m/d/Y"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function updateDateOf(Request $request){
        $request->validate([
            'id'=>'integer|| required',
            'start_date'=>'date',
            'expire_date'=>'date',
        ]);
        $dateIntern = DateOfInternship::where('id',$request->id)->first();
        if (!$dateIntern){
            return response()->json(['dateIntern'=>'not_found']);
        }
        $dateIntern->start_date = $request->start_date;
        $dateIntern->expire_date = $request->expire_date;
        $dateIntern->save();
        return response()->json(['status'=>200,'date_of_internship'=>$dateIntern]);
    }
    /**
     * @OA\Post (
     *     tags={"Staj Tarihi"},
     *     path="/api/v1/dateofintern/delete",
     *     description="Staj Tarihi Sil",
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
    public function deleteDateOfIntern(Request $request){
        $request->validate([
            'id'=>'integer|| required',
        ]);
        $dateIntern=DateOfInternship::where('id',$request->id)->first();
        if (!$dateIntern){
            return response()->json(['dateIntern'=>'not_found']);
        }
        $dateIntern->is_deleted =1;
        $dateIntern->save();
        return response()->json(['status'=>200]);
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementApiController extends Controller
{
    /**
     * @OA\Get  (
     *     tags={"Duyuru"},
     *     path="/api/v1/announcement/all",
     *     description="Duyuruları Getir",
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function getAll(){
        $announcements = Announcement::where('is_deleted',0)->get();
        if (!$announcements){
            return response()->json(['announcement'=>'not_found']);
        }
        return response()->json(['announcements'=>$announcements]);
    }
    /**
     * @OA\Get (
     *     tags={"Duyuru"},
     *     path="/api/v1/announcement/get",
     *     description="Duyuruları id'ye göre getir",
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
    public function getAnnouncement(Request $request){
        $announcement = Announcement::where('id',$request->id)->first();
        if (!$announcement){
            return response()->json(['announcement'=>'not_found']);
        }

        return response()->json(['announcement'=>$announcement]);
    }
    /**
     * @OA\Post (
     *     tags={"Duyuru"},
     *     path="/api/v1/announcement/create",
     *     description="Duyuru Oluştur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"title", "content"},
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="content", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function createAnnouncement(Request $request){
        $request->validate([
            'title'=>'string|| required',
            'content'=>'string || required'
        ]);
        $announcement = new Announcement();
        $announcement->title = $request->title;
        $announcement->content = $request->input('content');
        $announcement->status = 1;
        if (!$announcement){
            return response()->json(['status'=>500,'announcement'=>"bilinmeyen bir hata oluştu"]);
        }
        $announcement->save();
        return response()->json(['status'=>200,'announcement'=>$announcement]);
    }
    /**
     * @OA\Post (
     *     tags={"Duyuru"},
     *     path="/api/v1/announcement/update",
     *     description="Duyuru Güncelle",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"id"},
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="content", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function updateAnnouncement(Request $request){
        $request->validate([
            'id'=>'integer || required',
            'title'=>'string',
            'content'=>'string '
        ]);
        $announcement = Announcement::where('id',$request->id)->first();
        if (!$announcement){
            return response()->json(['announcement'=>'not_found']);
        }
        $announcement->title = $request->title;
        $announcement->content = $request->input('content');
        $announcement->status = 1;
        if (!$announcement){
            return response()->json(['status'=>500,'announcement'=>"bilinmeyen bir hata oluştu"]);
        }
        $announcement->save();
        return response()->json(['status'=>200,'announcement'=>$announcement]);
    }
    /**
     * @OA\Post (
     *     tags={"Duyuru"},
     *     path="/api/v1/announcement/delete",
     *     description="Duyuru Sil",
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
    public function deleteAnnouncement(Request $request){
        $request->validate([
            'id'=>'integer || required',
        ]);
        $announcement = Announcement::where('id',$request->id)->first();
        if (!$announcement){
            return response()->json(['announcement'=>'not_found']);
        }
        $announcement->is_deleted = 1;
        $announcement->save();
        return response()->json(['status'=>200]);
    }

}

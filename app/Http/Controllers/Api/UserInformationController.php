<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInformationController extends Controller
{
    /**
     * @OA\Get  (
     *     tags={"Kullanıcı Bilgileri"},
     *     path="/api/v1/user/info",
     *     description="Kullanıcı Bilgilerini Getir",
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function getUser () {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['user' => 'not_found']);
        }
        return response()->json(['user' => $user]);
    }
    /**
     * @OA\Get  (
     *     tags={"Kullanıcı Bilgileri"},
     *     path="/api/v1/user/auth/check",
     *     description="Kullanıcı Giriş Yapmış mı?",
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası"),
     * )
     */
    public function authCheck() {
        $user = Auth::check();
        if (!$user) {
            return response()->json(['auth' => $user]);
        }
        return response()->json(['auth' => $user]);
    }
}

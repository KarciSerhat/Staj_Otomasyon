<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InternshipDocumentes extends Controller
{
    /**
     * @OA\Get (
     *     tags={"Staj Doküman"},
     *     path="/api/v1/internshipdocument/all",
     *     description="Staj Dokümanları getir",
     *     @OA\Response(response="200", description="Ok"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="404", description="Not Found"),
     *     @OA\Response(response="500", description="Server Error"),
     * )
     */
    public function getAll(){
        $studentDocument = StudentDocument::where('is_deleted',0)->get();
        if (!$studentDocument){
            return response()->json(['internship_document' => 'not_found']);
        }
        return response()->json(['student_documents'=>$studentDocument]);
    }
    /**
     * @OA\Get (
     *     tags={"Staj Doküman"},
     *     path="/api/v1/internshipdocument/get",
     *     description="Staj Doküman id'ye göre getir",
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
    public function getDocuments(Request $request){
        $dataDocument = StudentDocument::where('id',$request->id)->first();
        if (!$dataDocument){
            return response()->json(['internship_document' => 'not_found']);
        }

        return response()->json(['student_documents'=>$dataDocument]);
    }
    /**
     * @OA\Post(
     *     tags={"Staj Doküman"},
     *     path="/api/v1/internshipdocument/create",
     *     description="Staj Dokümanı Oluştur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"internship_accept", "internship_payment_accept", "insurance_required", "user_id"},
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="insurance_required", type="string", format="binary"),
     *                 @OA\Property(property="internship_accept", type="string", format="binary"),
     *                 @OA\Property(property="internship_payment_accept", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası")
     * )
     */
    public function createDocuments(Request $request)
    {
        $request->validate([
            'internship_accept' => 'required|mimes:pdf|max:2048',
            'internship_payment_accept' => 'required|mimes:pdf|max:2048',
            'insurance_required' => 'required|mimes:pdf|max:2048',
        ]);
        $error = false;
        if ($request->hasFile('internship_accept')) {
            $file = $request->file('internship_accept');

            if ($file->isValid()) {
                $fileName = $this->generateUniqueFileName($file);
                $file->storeAs('student_documents', $fileName);
                $internship_accept_path = asset('student_documents/' . $fileName);
            } else {
                $error = true;
            }
        }
        if ($request->hasFile('internship_payment_accept')) {
            $file = $request->file('internship_payment_accept');

            if ($file->isValid()) {
                $fileName = $this->generateUniqueFileName($file);
                $file->storeAs('student_documents', $fileName);
                $internship_payment_accept_path = asset('student_documents/' . $fileName);
            } else {
                $error = true;
            }
        }
        if ($request->hasFile('insurance_required')) {
            $file = $request->file('insurance_required');

            if ($file->isValid()) {
                $fileName = $this->generateUniqueFileName($file);
                $file->storeAs('student_documents', $fileName);
                $insurance_required_path = asset('student_documents/' . $fileName);
            } else {
                $error = true;
            }
        }
        if (!$error) {
            $file = new StudentDocument();
            $file->internship_accept = $internship_accept_path;
            $file->internship_payment_accept = $internship_payment_accept_path;
            $file->insurance_required = $insurance_required_path;
            $file->user_id = $request->user_id ? $request->user_id : Auth::id();
            if(!$file){
                return response()->json(['status'=>500,'student_documents'=>"bilinmeyen bir hata oluştu"]);
            }
            $file->save();
            return response()->json(['status'=>200,'student_documents' => $file]);
        }
        return response()->json(['error' => 'Geçersiz dosya'], 400);
    }

    function generateUniqueFileName($file)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = str_replace(' ', '_', $fileName);
        $fileName = $fileName . '_' . uniqid() . '.' . $extension;

        return $fileName;
    }

    /**
     * @OA\Post(
     *     tags={"Staj Doküman"},
     *     path="/api/v1/internshipdocument/update",
     *     description="Staj Dokümanı Oluştur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"id", "user_id", "internship_accept", "internship_payment_accept", "insurance_required"},
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="insurance_required", type="string", format="binary"),
     *                 @OA\Property(property="internship_accept", type="string", format="binary"),
     *                 @OA\Property(property="internship_payment_accept", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası")
     * )
     */
    public function updateDocuments(Request $request)
    {
        $request->validate([
            'id'=> 'required',
            'user_id' => 'required',
            'internship_accept' => 'nullable|mimes:pdf|max:2048',
            'internship_payment_accept' => 'nullable|mimes:pdf|max:2048',
            'insurance_required' => 'nullable|mimes:pdf|max:2048',
        ]);

        $file = StudentDocument::where('id', $request->id)->first();

        if (!$file) {
            return response()->json(['error' => 'Belge bulunamadı'], 404);
        }

        $error = false;

        if ($request->hasFile('internship_accept')) {
            $newFile = $request->file('internship_accept');

            if ($newFile->isValid()) {
                $this->deleteFileIfExists($file->internship_accept); // Mevcut dosyayı sil
                $fileName = $this->generateUniqueFileName($newFile);
                $newFile->storeAs('student_documents', $fileName);
                $file->internship_accept = asset('student_documents/' . $fileName);
            } else {
                $error = true;
            }
        }

        if ($request->hasFile('internship_payment_accept')) {
            $newFile = $request->file('internship_payment_accept');

            if ($newFile->isValid()) {
                $this->deleteFileIfExists($file->internship_payment_accept); // Mevcut dosyayı sil
                $fileName = $this->generateUniqueFileName($newFile);
                $newFile->storeAs('student_documents', $fileName);
                $file->internship_payment_accept = asset('student_documents/' . $fileName);
            } else {
                $error = true;
            }
        }

        if ($request->hasFile('insurance_required')) {
            $newFile = $request->file('insurance_required');

            if ($newFile->isValid()) {
                $this->deleteFileIfExists($file->insurance_required); // Mevcut dosyayı sil
                $fileName = $this->generateUniqueFileName($newFile);
                $newFile->storeAs('student_documents', $fileName);
                $file->insurance_required = asset('student_documents/' . $fileName);
            } else {
                $error = true;
            }
        }

        if (!$error) {
            $file->save();
            return response()->json(['status' => 200, 'student_documents' => $file]);
        }

        return response()->json(['error' => 'Geçersiz dosya'], 400);
    }

    private function deleteFileIfExists($filePath)
    {
        if ($filePath) {
            $path = parse_url($filePath, PHP_URL_PATH);
            $path = public_path($path);

            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    /**
     * @OA\Post(
     *     tags={"Staj Doküman"},
     *     path="/api/v1/internshipdocument/delete",
     *     description="Staj Dokümanı Sil",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"id", "user_id"},
     *                 @OA\Property(property="id", type="integer"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="İşlem başarılı"),
     *     @OA\Response(response="400", description="Geçersiz istek"),
     *     @OA\Response(response="401", description="Yetkisiz"),
     *     @OA\Response(response="500", description="Sunucu hatası")
     * )
     */
    public function deleteDocuments(Request $request){
        $request->validate([
            'id'=>'integer|| required',
        ]);
        $dataDoc = StudentDocument::where('id',$request->id)->first();
        if (!$dataDoc){
            return response()->json(['internship_document' => 'not_found']);
        }
        $dataDoc->is_deleted =1;
        $dataDoc->save();
        return response()->json(['status'=>200]);
    }

}

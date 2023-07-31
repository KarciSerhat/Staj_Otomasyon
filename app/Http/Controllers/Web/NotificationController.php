<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index ($url, $id) {
        $notification = Notification::where('id', $id)->first();
        $notification->is_read = 1;
        $notification->save();
        $newUrl = str_replace('$$', '/', $url);
        return redirect()->to($newUrl);
    }

    public function remove($id) {
        $notification = Notification::findOrFail($id);
        $notification->is_read = 1;
        $notification->save();

        return response()->json([
            'status' => 'success',
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function clearAll () {
        Notification::where('user_id', Auth::id())->update(['is_read' => 1]);
        return response()->json([
            'status' => 'success',
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }
}

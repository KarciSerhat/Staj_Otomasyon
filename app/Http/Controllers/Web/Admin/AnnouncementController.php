<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\User;
use App\Models\Uygulama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $announcements = Announcement::where('is_deleted', 0)->where('status', 1)->get();
        view()->share('announcements', $announcements);
    }

    public function index () {
        return view('admin.pages.announcements');
    }

    public function getAnnouncement (Request $request) {
        if ($request->ajax()) {
            $data = Announcement::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" onClick="editBtn(' . $row->id . ')" class="edit btn btn-info btn-sm"> Düzenle </a>';

                })
                ->editColumn('change', function ($row) {
                    $text = '';
                    $status = '';
                    if ($row->status == 1) {
                        $text = 'Aktif';
                        $status = 'checked';
                    } else {
                        $text = 'Pasif';
                    }
                    return '<div class="custom-control custom-switch">
                              <input onchange="change(' . $row->id . ')" type="checkbox" class="custom-control-input switchChange" ' . $status . ' id="customSwitch1' . $row->id . '">
                              <label class="custom-control-label" for="customSwitch1' . $row->id . '">' . $text . '</label>
                            </div>';
                })
                ->rawColumns(['action', 'period', 'change'])
                ->make(true);
        }
    }

    public function announcementCreate(Request $request) {
        $request->validate([
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ]);
        $announcement = new Announcement();
        $announcement->title = $request->input('title');
        $announcement->content = $request->input('content');
        $announcement->link = $request->input('link');
        $announcement->save();

        $users = User::all();
        foreach ($users as $user) {
            $notificationData [] = [
                'title' => 'Yeni Bir Duyuru Yayımlandı',
                'content' => $announcement->title . ' adlı yeni duyuru yayımlandı',
                'user_id' => $user->id,
                'link' => route('homepage'),
                'created_at' => now()
            ];
        }
        DB::table('notifications')->insert($notificationData);

        return response()->json([
            'status' => 'success',
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function change ($id) {
        $announcement = Announcement::where('id', $id)->first();
        if (!$announcement) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        $announcement->status = !$announcement->status;
        $announcement->save();
        return response()->json([
            'status' => 'success',
            'data' => $announcement
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function detail ($id) {
        $announcement = Announcement::where('id', $id)->first();
        if (!$announcement) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        return response()->json([
            'status' => 'success',
            'data' => $announcement
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function update(Request $request) {
        $announcement = Announcement::where('id', $request->id)->first();
        if (!$announcement) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        $announcement->title = $request->input('title');
        $announcement->content = $request->input('content');
        $announcement->link = $request->input('link');
        $announcement->save();
        return response()->json([
            'status' => 'success',
            'data' => $announcement
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

}

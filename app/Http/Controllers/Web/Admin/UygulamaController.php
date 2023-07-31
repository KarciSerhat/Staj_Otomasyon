<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Application;
use App\Models\InternshipPeriot;
use App\Models\Uygulama;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UygulamaController extends Controller
{
    public function __construct()
    {
        $announcements = Announcement::where('is_deleted', 0)->where('status', 1)->get();
        view()->share('announcements', $announcements);
    }

    public function index () {
        return view('admin.pages.uygulama');
    }
    public function getUygulama (Request $request) {
        if ($request->ajax()) {
            $data = Uygulama::latest()->with('getPeriods')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" onClick="editBtn(' . $row->id . ')" class="edit btn btn-info btn-sm"> Düzenle </a>';

                })
                ->editColumn('period', function ($row) {
                    return $row->getPeriods->count();
                })
                ->editColumn('change', function ($row) {
                    $text = '';
                    $status = '';
                    if ($row->is_active == 1) {
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

    public function detail ($id) {
        $uygulama = Uygulama::where('id', $id)->first();
        if (!$uygulama) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        return response()->json([
            'status' => 'success',
            'data' => $uygulama
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function change ($id) {
        $uygulama = Uygulama::where('id', $id)->first();
        if (!$uygulama) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        $uygulama->is_active = !$uygulama->is_active;
        $uygulama->save();
        return response()->json([
            'status' => 'success',
            'data' => $uygulama
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function update(Request $request) {
        $uygulama = Uygulama::where('id', $request->id)->first();
        if (!$uygulama) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        $uygulama->title = $request->input('title');
        $uygulama->save();
        return response()->json([
            'status' => 'success',
            'data' => $uygulama
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function uygulamaCreate(Request $request) {
        $request->validate([
            'title' => ['required', 'string'],
        ]);
        $internship = new Uygulama();
        $internship->title = $request->input('title');
        $internship->save();
        return response()->json([
            'status' => 'success',
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }
}

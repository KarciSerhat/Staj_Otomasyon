<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Application;
use App\Models\InternshipPeriot;
use App\Models\Uygulama;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InternshipPeriodController extends Controller
{
    public function __construct()
    {
        $announcements = Announcement::where('is_deleted', 0)->where('status', 1)->get();
        view()->share('announcements', $announcements);
    }

    public function index () {
        $uygulama = Uygulama::where('is_deleted', 0)->where('is_active', 1)->get();
        return view('admin.pages.internshipPeriod', compact('uygulama'));
    }

    public function getInternshipPeriods (Request $request) {
        if ($request->ajax()) {
            $data = InternshipPeriot::latest()->with('getUygulama')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" onClick="editBtn(' . $row->id . ')" class="edit btn btn-info btn-sm"> Düzenle </a>';

                })
                ->editColumn('request_count', function ($row) {
                    return Application::where('internship_periot', $row->id)->count();
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
                ->editColumn('uygulama', function ($row) {
                    return $row->getUygulama->title;
                })
                ->rawColumns(['action', 'request_count', 'change', 'uygulama'])
                ->make(true);
        }
    }

    public function update(Request $request) {
        $request->validate([
            'title' => ['required', 'string'],
            'start_date' => ['required'],
            'expire_date' => ['required'],
            'uygulama' => ['required'],
        ]);
        $start_date = $request->start_date;
        $expire_date = $request->expire_date;

        if (strtotime($start_date) > strtotime($expire_date)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lütfen tarihleri kontrol ediniz.'
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }

        $current_date = date('Y-m-d H:i:s');

        if ($current_date > $expire_date) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lütfen tarihleri kontrol ediniz.'
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        $internship = InternshipPeriot::where('id', $request->id)->first();
        if (!$internship) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        $internship->title = $request->input('title');
        $internship->title = $request->input('title');
        $internship->start_date = $request->input('start_date');
        $internship->expire_date = $request->input('expire_date');
        $internship->uygulama_id = $request->input('uygulama');
        $internship->save();
        return response()->json([
            'status' => 'success',
            'data' => $internship
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function intershipCreate(Request $request) {
        $request->validate([
            'title' => ['required', 'string'],
            'start_date' => ['required'],
            'expire_date' => ['required'],
            'uygulama' => ['required'],
        ]);
        $start_date = $request->start_date;
        $expire_date = $request->expire_date;

        if (strtotime($start_date) > strtotime($expire_date)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lütfen tarihleri kontrol ediniz.'
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }

        $current_date = date('Y-m-d H:i:s');

        if ($current_date > $expire_date) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lütfen tarihleri kontrol ediniz.'
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }

        $internship = new InternshipPeriot();
        $internship->title = $request->input('title');
        $internship->start_date = $request->input('start_date');
        $internship->expire_date = $request->input('expire_date');
        $internship->uygulama_id = $request->input('uygulama');
        $internship->save();
        return response()->json([
            'status' => 'success',
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function detail ($id) {
        $internship = InternshipPeriot::where('id', $id)->first();
        if (!$internship) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        return response()->json([
            'status' => 'success',
            'data' => $internship
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function change ($id) {
        $internship = InternshipPeriot::where('id', $id)->first();
        if (!$internship) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        $internship->is_active = !$internship->is_active;
        $internship->save();
        return response()->json([
            'status' => 'success',
            'data' => $internship
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }
}

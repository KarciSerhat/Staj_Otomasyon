<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Application;
use App\Models\Company;
use App\Models\Notification;
use App\Models\Status;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminApplicationControlle extends Controller
{
    public function __construct()
    {
        $announcements = Announcement::where('is_deleted', 0)->where('status', 1)->get();
        view()->share('announcements', $announcements);
    }

    public function index () {
        return view('admin.pages.applications');
    }

    public function getApplications (Request $request) {
        if ($request->ajax()) {
            $data = Application::latest()->with(['getCompany', 'getDocument', 'getUser', 'getPeriot' => function($query) {
                $query->with('getUygulama')->get();
            }])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->getStatus->id == 1) {
                        return '<a href="javascript:void(0)" onClick="showApplication(' . $row->id . ')" class="edit btn btn-info btn-sm"> Başvuruyu Gör </a>';
                    } elseif ($row->getStatus->id == 2) {
                        $text = 'Staj Evraklarını Gör';
                        $disabled = '';
                        if (!$row->getDocument) {
                            $text = 'Evraklar Henüz Yüklenmemiş';
                            $disabled = 'disabled';
                        }
                        return '<a href="javascript:void(0)" onClick="showDocument(' . $row->id . ')" class="edit btn btn-primary btn-sm ' . $disabled . '"> ' . $text . ' </a> <hr> <a href="javascript:void(0)" onClick="showApplication(' . $row->id . ')" class="edit btn btn-info btn-sm"> Başvuruyu Gör </a>';
                    }  elseif ($row->getStatus->id == 4) {
                        return '<a href="javascript:void(0)" onClick="showDocument(' . $row->id . ')" class="edit btn btn-primary btn-sm"> Staj Evraklarını Gör </a> <hr> <a href="javascript:void(0)" onClick="showApplication(' . $row->id . ')" class="edit btn btn-info btn-sm"> Başvuruyu Gör </a> ';
                    } elseif ($row->getStatus->id == 3) {
                        return '<a href="javascript:void(0)" onClick="showDocument(' . $row->id . ')" class="edit btn btn-primary btn-sm"> Staj Evraklarını Gör </a> <hr> <a href="javascript:void(0)" onClick="showApplication(' . $row->id . ')" class="edit btn btn-info btn-sm"> Başvuruyu Gör </a>';
                    }
                    elseif ($row->getStatus->id == 5) {
                        return '<a href="javascript:void(0)" onClick="showInternshipBook(' . $row->id . ')" class="edit btn btn-primary btn-sm"> Staj Defterini Gör </a> <hr> <a href="javascript:void(0)" onClick="showDocument(' . $row->id . ')" class="edit btn btn-primary btn-sm"> Staj Evraklarını Gör </a> <hr> <a href="javascript:void(0)" onClick="showApplication(' . $row->id . ')" class="edit btn btn-info btn-sm"> Başvuruyu Gör </a>';
                    } elseif ($row->getStatus->id == 6) {
                        return '<a href="javascript:void(0)" onClick="showInternshipBook(' . $row->id . ')" class="edit btn btn-info btn-sm"> Staj Defterini Gör </a> <hr> <a href="javascript:void(0)" onClick="showDocument(' . $row->id . ')" class="edit btn btn-primary btn-sm"> Staj Evraklarını Gör </a> <hr> <a href="javascript:void(0)" onClick="showApplication(' . $row->id . ')" class="edit btn btn-info btn-sm"> Başvuruyu Gör </a>';
                    } elseif ($row->getStatus->id == 7) {
                        return '<a href="javascript:void(0)" class="edit btn btn-success btn-sm disabled"> Staj Başarılı Bir Şekilde Bitti </a> <hr> <a href="javascript:void(0)" onClick="showInternshipBook(' . $row->id . ')" class="edit btn btn-info btn-sm"> Staj Defterini Gör </a> <hr> <a href="javascript:void(0)" onClick="showDocument(' . $row->id . ')" class="edit btn btn-primary btn-sm"> Staj Evraklarını Gör </a> <hr> <a href="javascript:void(0)" onClick="showApplication(' . $row->id . ')" class="edit btn btn-info btn-sm"> Başvuruyu Gör </a>';
                    }

                })
                ->addColumn('step', function ($row) {
                    $id = $row->id;
                    $checkbox0 = '<input onclick="step0(' . $row->id . ', ' . $row->status_id . ')" type="checkbox" class="form-check-input" id="step0-' . $id . '"';
                    $checkbox1 = '<input onclick="step1(' . $row->id . ', ' . $row->status_id . ')" type="checkbox" class="form-check-input" id="step1-' . $id . '"';
                    $checkbox2 = '<input onclick="step2(' . $row->id . ', ' . $row->status_id . ')" type="checkbox" class="form-check-input" id="step2-' . $id . '"';
                    $checkbox3 = '<input onclick="step3(' . $row->id . ', ' . $row->status_id . ')" type="checkbox" class="form-check-input" id="step3-' . $id . '"';
                    $checkbox4 = '<input onclick="step4(' . $row->id . ', ' . $row->status_id . ')" type="checkbox" class="form-check-input" id="step4-' . $id . '"';
                    $checkbox5 = '<input onclick="step5(' . $row->id . ', ' . $row->status_id . ')" type="checkbox" class="form-check-input" id="step5-' . $id . '"';

                    if ($row->status_id == 1) {
                        $checkbox0 .= ' checked';
                    }
                    elseif ($row->status_id == 2) {
                        $checkbox0 .= ' checked';
                        $checkbox1 .= ' checked';
                    } elseif ($row->status_id == 3) {
                        $checkbox0 .= ' checked';
                        $checkbox1 .= ' checked';
                    } elseif ($row->status_id == 4) {
                        $checkbox0 .= ' checked';
                        $checkbox1 .= ' checked';
                        $checkbox2 .= ' checked';
                    } elseif ($row->status_id == 5) {
                        $checkbox0 .= ' checked';
                        $checkbox1 .= ' checked';
                        $checkbox2 .= ' checked';
                        $checkbox3 .= ' checked';
                    } elseif ($row->status_id == 6) {
                        $checkbox0 .= ' checked';
                        $checkbox1 .= ' checked';
                        $checkbox2 .= ' checked';
                        $checkbox3 .= ' checked';
                        $checkbox4 .= ' checked';
                    } elseif ($row->status_id == 7) {
                        $checkbox0 .= ' checked';
                        $checkbox1 .= ' checked';
                        $checkbox2 .= ' checked';
                        $checkbox3 .= ' checked';
                        $checkbox4 .= ' checked';
                        $checkbox5 .= ' checked';
                    }


                    $checkbox0 .= '>';
                    $checkbox1 .= '>';
                    $checkbox2 .= '>';
                    $checkbox3 .= '>';
                    $checkbox4 .= '>';
                    $checkbox5 .= '>';

                    $button = '<div class="form-check">
                    ' . $checkbox0 . '
                    <label class="form-check-label" for="step0-' . $id . '">Başvuru Alındı</label>
                </div>'
                        .'<div class="form-check">
                    ' . $checkbox1 . '
                    <label class="form-check-label" for="step1-' . $id . '">Şirketi Onayla</label>
                </div>'
                        . '<div class="form-check">
                    ' . $checkbox2 . '
                    <label class="form-check-label" for="step2-' . $id . '">Evrakları Onayla</label>
                </div>'
                        . '<div class="form-check">
                    ' . $checkbox3 . '
                    <label class="form-check-label" for="step3-' . $id . '">Defter Teslim Onayla (Öğrenci)</label>
                </div>'
                        . '<div class="form-check">
                    ' . $checkbox4 . '
                    <label class="form-check-label" for="step4-' . $id . '">Defter Teslim Onayla (Akademisyen)</label>
                </div>'
                        . '<div class="form-check">
                    ' . $checkbox5 . '
                    <label class="form-check-label" for="step5-' . $id . '">Staj Bitir</label>
                </div>';
                    return $button;
                })
            ->editColumn('company', function ($row) {
                    return $row->getCompany->name;
                })
                ->editColumn('status', function ($row) {
                    return $row->getStatus->title;
                })
                ->editColumn('adres', function ($row) {
                    return $row->getCompany->adres;
                })
                ->editColumn('student', function ($row) {
                    return $row->getUser->userFullName;
                })
                ->editColumn('companyPhone', function ($row) {
                    return $row->getCompany->number;
                })
                ->editColumn('companyMail', function ($row) {
                    return $row->getCompany->email;
                })
                ->editColumn('period', function ($row) {
                    return $row->getPeriot->title;
                })
                ->editColumn('uygulama', function ($row) {
                    return $row->getPeriot->getUygulama->title;
                })
                ->editColumn('rejection', function ($row) {
                    if ($row->description) {
                        return $row->description;
                    }
                    return '';
                })
                ->rawColumns(['action', 'company', 'student', 'companyPhone', 'companyMail', 'period', 'uygulama', 'adres', 'step', 'rejection'])
                ->make(true);
        }
    }

    private function changeStatus ($id, $statusId, $rejectionReason = false) {
        $application = Application::where('id', $id)->first();
        $application->status_id = $statusId;
        if ($rejectionReason) {
            $application->description = $rejectionReason;
        } else {
            $application->description = null;
        }
        $application->save();

        $status = Status::where('id', $statusId)->first();

        $content = ($rejectionReason) ? 'Başvurunun durumu akademisyen tarafından ' . $rejectionReason . ' dan dolayı reddedildi.' : 'Başvurunun durumu akademisyen tarafından ' . $status->title . ' olrak değiştirdi.';

        $notification = new Notification();
        $notification->title = 'Başvuru Akdemesyen Tarafından Güncellendi';
        $notification->content = $content;
        $notification->link = route('application');
        $notification->user_id = $application->student_id;
        $notification->created_at = now();
        $notification->save();

        return true;
    }

    public function step0 (Request $request) {
        if ($request->step == 0) {
            if ($request->rejectionReason) {
                $this->changeStatus($request->id, 1, $request->rejectionReason);

            } else {
                $this->changeStatus($request->id, 1);

            }
            return response()->json([
                'status' => 'success',
            ])->header('Content-Type', 'application/json')->setStatusCode(200);
        } else {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
    }
    public function step1 (Request $request) {
        if ($request->step == 1) {
            if ($request->rejectionReason) {
                $this->changeStatus($request->id, 2, $request->rejectionReason);
            } else {
                $this->changeStatus($request->id, 2);
            }
            return response()->json([
                'status' => 'success',
            ])->header('Content-Type', 'application/json')->setStatusCode(200);
        } else {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
    }

    public function step2 (Request $request) {
        if ($request->step == 2) {
            if ($request->rejectionReason) {
                $this->changeStatus($request->id, 4, $request->rejectionReason);
            } else {
                $this->changeStatus($request->id, 4);
            }
            return response()->json([
                'status' => 'success',
            ])->header('Content-Type', 'application/json')->setStatusCode(200);
        } else {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
    }

    public function step3 (Request $request) {
        if ($request->step == 3) {
            if ($request->rejectionReason) {
                $this->changeStatus($request->id, 5, $request->rejectionReason);
            } else {
                $this->changeStatus($request->id, 5);
            }
            return response()->json([
                'status' => 'success',
            ])->header('Content-Type', 'application/json')->setStatusCode(200);
        } else {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
    }

    public function step4 (Request $request) {
        if ($request->step == 4) {
            if ($request->rejectionReason) {
                $this->changeStatus($request->id, 6, $request->rejectionReason);
            } else {
                $this->changeStatus($request->id, 6);
            }
            return response()->json([
                'status' => 'success',
            ])->header('Content-Type', 'application/json')->setStatusCode(200);
        } else {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
    }

    public function step5 (Request $request) {
        if ($request->step == 5) {
            if ($request->rejectionReason) {
                $this->changeStatus($request->id, 7, $request->rejectionReason);
            } else {
                $this->changeStatus($request->id, 7);
            }
            return response()->json([
                'status' => 'success',
            ])->header('Content-Type', 'application/json')->setStatusCode(200);
        } else {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
    }

    public function getAdminApplicationDetail($id) {
        $application = Application::where('id', $id)->with(['getCompany', 'getUser'])->first();
        if (!$application) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        return response()->json([
            'status' => 'success',
            'data' => $application
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }
    public function getDocument ($id){
        $application = Application::where('id', $id)->with(['getDocument', 'getUser'])->first();
        if (!$application) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        return response()->json([
            'status' => 'success',
            'data' => [$application, $application->getDocument]
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function documentDownload (Request $request) {
        $dataName = $request->input('fileName');

        $filePath = storage_path('app\\' . $dataName);

        return response()->download($filePath);
    }
}

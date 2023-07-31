<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Application;
use App\Models\Company;
use App\Models\InternshipPeriot;
use App\Models\StudentCompany;
use App\Models\StudentDocument;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $announcements = Announcement::where('is_deleted', 0)->where('status', 1)->get();
        view()->share('announcements', $announcements);
    }

    public function index () {
        $user = User::where('id', Auth::id())->with('getApplication')->first();
        $isHasApplication = false;
        if ($user->getApplication) {
            $isHasApplication = true;
        }
        $periots = InternshipPeriot::where('is_deleted', 0)->where('is_active', 1)->with('getUygulama')->get();
        return view('front.pages.application', compact('isHasApplication', 'periots'));
    }

    public function create(Request $request) {
        $periyot = InternshipPeriot::where('id', $request->input('internship_periot'))->first();
        $user = User::where('id', Auth::id())->with('getApplication')->first();
        $application = Application::where('student_id', $user->id)->where('internship_periot', $periyot->id)->first();
        if ($application) {
            return redirect()->back()->withErrors('Zaten Başvurunuz Bulunmaktadır');
        } else {
            $request->validate([
                'name' => ['required', 'string'],
                'email' => ['required', 'email'],
                'number' => ['required', 'string'],
                'adres' => ['required', 'string'],
                'accept' => ['required']
            ]);
            if ($request->accept != 'on') {
                return redirect()->back()->withErrors('Onayladığınızı Kabul Edin!');
            }

            if ($periyot) {
                $start_date = Carbon::parse($periyot->start_date);
                $end_date = Carbon::parse($periyot->expire_date);

                $basvuruTarihi = Carbon::now();

                if ($basvuruTarihi->between($start_date, $end_date)) {
                    $company = new Company();
                    $company->name = $request->input('name');
                    $company->number = $request->input('number');
                    $company->adres = $request->input('adres');
                    $company->order_data = $request->input('order_data');
                    $company->vergi_no = $request->input('vergi_no');
                    $company->email = $request->input('email');
                    $company->save();

                    $application = new Application();
                    $application->company_id = $company->id;
                    $application->status_id = 1;
                    $application->student_id = Auth::id();
                    $application->internship_periot = $periyot->id;
                    $application->save();

                    $adminUsers = User::where('user_type', '!=', '0')->get();
                    $fullName = Auth::user()->userFirstName . ' ' . Auth::user()->userLastName . ' - ' . Auth::user()->userLogonNamePreWindows2000;
                    foreach ($adminUsers as $user) {
                        $notificationData [] = [
                            'title' => 'Yeni Başvuru',
                            'content' => $fullName . ' Yeni bir başvuru yaptı.' . $company->name . ' Şirket için başvuruda bulundu.',
                            'user_id' => $user->id,
                            'link' => route('admin.application'),
                            'created_at' => now()
                        ];
                    }
                    DB::table('notifications')->insert($notificationData);

                    return redirect()->route('applications')->with('success', 'Başvuru başarıyla alındı.');

                } else {
                    return redirect()->back()->withErrors('Başvurunuz bu tarih aralığı için yapılamaz');
                }
            } else {
                return "Geçersiz periyot ID'si.";
            }
        }
    }

    public function applications () {
        $rejectionReasons = Application::where('student_id', Auth::id())->whereNotNull('description')->with(['getCompany', 'getPeriot'])->get();
        return view('front.pages.applications', compact('rejectionReasons'));
    }

    public function getApplications (Request $request) {
        if ($request->ajax()) {
            $data = Application::latest()->with(['getCompany', 'getPeriot' => function($query) {
                $query->with('getUygulama')->get();
            }])->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    if ($row->getStatus->id == 1) {
                        return '<a href="javascript:void(0)" onClick="editBtn(' . $row->id . ')" class="edit btn btn-info btn-sm"> Düzenle </a>';
                    } elseif ($row->getStatus->id == 2) {
                        return '<a href="javascript:void(0)" onClick="sendDocument(' . $row->id . ')" class="edit btn btn-primary btn-sm"> Staj Evrakları Gönderilebilir </a>';
                    }  elseif ($row->getStatus->id == 3) {
                        return '<a href="javascript:void(0)" onClick="updateDocument(' . $row->id . ')" class="edit btn btn-info btn-sm"> Staj Evrakları Güncellenebilir </a>';
                    } elseif ($row->getStatus->id == 4) {
                        return '<a href="javascript:void(0)" onClick="checkInterShipDocForStudent(' . $row->id . ')" class="edit btn btn-primary btn-sm"> Staj Defteri Teslim Edilebilir </a>';
                    } elseif ($row->getStatus->id == 5) {
                        return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm disabled"> Staj Defteri Akedemisyen Tarafından Onay Bekliyor </a>';
                    } elseif ($row->getStatus->id == 6) {
                        return '<a href="javascript:void(0)" class="edit btn btn-info btn-sm disabled"> Staj Bitirme Bekleniyor </a>';
                    } elseif ($row->getStatus->id == 7) {
                        return '<a href="javascript:void(0)" class="edit btn btn-success btn-sm disabled"> Staj Başarılı Bir Şekilde Bitti </a>';
                    }

                })
                ->editColumn('company', function ($row) {
                    return $row->getCompany->name;
                })
                ->editColumn('status', function ($row) {
                    return $row->getStatus->title;
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
                ->rawColumns(['action', 'company', 'companyPhone', 'companyMail', 'period', 'uygulama'])
                ->make(true);
        }
    }

    public function getApplicationDetail ($id) {
        $application = Application::where('id', $id)->first();
        $company = Company::where('id', $application->company_id)->first();
        if (!$company) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);
        }
        return response()->json([
            'status' => 'success',
            'data' => [$company, $application]
        ])->header('Content-Type', 'application/json')->setStatusCode(200);
    }

    public function update (Request $request) {
        $application = Application::where('id', $request->dataId)->first();
        if ($application->status_id != 1) {
            return response()->json([
                'status' => 'error',
            ])->header('Content-Type', 'application/json')->setStatusCode(400);

        } else {
            $request->validate([
                'name' => ['required', 'string'],
                'email' => ['required', 'email'],
                'number' => ['required', 'string'],
                'adres' => ['required', 'string'],
                'accept' => ['required']
            ]);
            if ($request->accept != 'on') {
                return redirect()->back()->withErrors('Onayladığınızı Kabul Edin!');
            }
            $company = Company::where('id', $request->id)->first();
            if (!$company) {
                return response()->json([
                    'status' => 'error',
                ])->header('Content-Type', 'application/json')->setStatusCode(400);
            }

            $company->name = $request->name;
            $company->email = $request->email;
            $company->number = $request->number;
            $company->adres = $request->adres;
            $company->vergi_no = $request->vergi_no;
            $company->order_data = $request->order_data;
            $company->save();
            return response()->json([
                'status' => 'success',
            ])->header('Content-Type', 'application/json')->setStatusCode(200);
        }
    }

    public function sendDocument(Request $request)
    {
        $userName = Auth::user()->userFullName;
        $documentExist = StudentDocument::where('user_id', Auth::id())->first();
        if ($documentExist) {
            $document = $documentExist;

        } else {
            $document = new StudentDocument();
        }

        $internship_accept_path = '';
        $internship_payment_accept_path = '';
        $insurance_required_path = '';
        if ($request->hasFile('stajKabulFormu')) {
            $file = $request->file('stajKabulFormu');

            if ($file->isValid()) {
                $fileName = $userName . '-' . 'stajKabulFormu' . '.' . $file->getClientOriginalExtension();
                if ($document->internship_accept) {
                    $existingFile = basename($document->internship_accept);
                    Storage::delete('app\\' . $existingFile);
                }
                $file->storeAs('student_documents', $fileName);
                $internship_accept_path ='student_documents/' . $fileName;
            }
        }
        $document->internship_accept = $internship_accept_path;

        if ($request->hasFile('iszizlikFonu')) {
            $file = $request->file('iszizlikFonu');

            if ($file->isValid()) {
                $fileName = $userName . '-' . 'iszizlikFonu' . '.' . $file->getClientOriginalExtension();
                if ($document->internship_payment_accept) {
                    $existingFile = basename($document->internship_payment_accept);
                    Storage::delete('app\\' . $existingFile);
                }
                $file->storeAs('student_documents', $fileName);
                $internship_payment_accept_path = 'student_documents/' . $fileName;
            }
        }
        $document->internship_payment_accept = $internship_payment_accept_path;

        if ($request->hasFile('mustahaklikBelgesi')) {
            $file = $request->file('mustahaklikBelgesi');

            if ($file->isValid()) {
                $fileName = $userName . '-' . 'mustahaklikBelgesi' . '.' . $file->getClientOriginalExtension();
                if ($document->insurance_required) {
                    $existingFile = basename($document->insurance_required);
                    Storage::delete('app\\' . $existingFile);
                }
                $file->storeAs('student_documents', $fileName);
                $insurance_required_path = 'student_documents/' . $fileName;
            }
        }
        $document->insurance_required = $insurance_required_path;
        if ($request->hasFile('nufusCuzdan')) {
            $file = $request->file('nufusCuzdan');

            if ($file->isValid()) {
                $fileName = $userName . '-' . 'nufusCuzdan' . '.' . $file->getClientOriginalExtension();
                if ($document->national_wallet_path) {
                    $existingFile = basename($document->national_wallet_path);
                    Storage::delete('app\\' . $existingFile);
                }
                $file->storeAs('student_documents', $fileName);
                $national_wallet_path = 'student_documents/' . $fileName;
            }
        }
        $document->national_wallet = $national_wallet_path;

        $document->user_id = Auth::id();
        $document->save();

        $application = Application::where('id', $request->application_id)->first();
        $application->status_id = 3;
        $application->student_document_id = $document->id;
        $application->save();

        $adminUsers = User::where('user_type', '!=', '0')->get();
        $fullName = Auth::user()->userFirstName . ' ' . Auth::user()->userLastName . ' - ' . Auth::user()->userLogonNamePreWindows2000;
        foreach ($adminUsers as $user) {
            $notificationData [] = [
                'title' => 'Staj Everak Teslim',
                'content' => $fullName . ' staj evraklarını yolladı',
                'user_id' => $user->id,
                'link' => route('admin.application'),
                'created_at' => now()
            ];
        }
        DB::table('notifications')->insert($notificationData);

        return response()->json([
            'status' => 'success',
        ])->header('Content-Type', 'application/json')->setStatusCode(200);

    }

    public function getDocument ($id){
        $application = Application::where('id', $id)->with('getDocument')->first();
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

    public function internshipsBook(Request $request) {
        $application = Application::where('id', $request->id)->first();
        $document = StudentDocument::where('user_id', Auth::id())->first();
        $application->status_id = 5;
        $application->save();
        $userName = Auth::user()->userFullName;
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if ($file->isValid()) {
                $fileName = $userName . '-' . 'stajDefteri' . '.' . $file->getClientOriginalExtension();
                if ($document->internships_book) {
                    $existingFile = basename($document->internships_book);
                    Storage::delete('app\\' . $existingFile);
                }
                $file->storeAs('student_documents', $fileName);
                $internships_book_path = 'student_documents/' . $fileName;
            }
        }
        $document->internships_book = $internships_book_path;
        $document->save();

        $adminUsers = User::where('user_type', '!=', '0')->get();
        $fullName = Auth::user()->userFirstName . ' ' . Auth::user()->userLastName . ' - ' . Auth::user()->userLogonNamePreWindows2000;
        foreach ($adminUsers as $user) {
            $notificationData [] = [
                'title' => 'Staj Defterini Sisteme Yükledi',
                'content' => $fullName . ' staj defterini sisteme yükledi',
                'user_id' => $user->id,
                'link' => route('admin.application'),
                'created_at' => now()
            ];
        }
        DB::table('notifications')->insert($notificationData);

        return response()->json([
            'status' => 'success',
        ])->header('Content-Type', 'application/json')->setStatusCode(200);

    }

}

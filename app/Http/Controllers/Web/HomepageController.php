<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    public function __construct()
    {
        $announcements = Announcement::where('is_deleted', 0)->where('status', 1)->get();
        view()->share('announcements', $announcements);
    }

    public function index() {
        $applicationCount = Application::where('status_id', '!=', 7)->count();
        $announcements = Announcement::where('is_deleted', 0)->where('status', 1)->get();
        $data = [];
        $uygulamalar = DB::table('uygulamas')->get();
        foreach ($uygulamalar as $uygulama) {
            $uygulamaName =  "Uygulama Adı: " . $uygulama->title;

            $periottakiBasvurular = DB::table('applications')
                ->join('internship_periots', 'applications.internship_periot', '=', 'internship_periots.id')
                ->join('uygulamas', 'internship_periots.uygulama_id', '=', 'uygulamas.id')
                ->where('uygulamas.id', $uygulama->id)
                ->groupBy('internship_periots.title')
                ->select('internship_periots.title', DB::raw('count(applications.id) as basvuru_sayisi'))
                ->get();

            foreach ($periottakiBasvurular as $periottakiBasvuru) {
                $data [] = [
                    $uygulamaName . ' - ' . $periottakiBasvuru->title . " - " . $periottakiBasvuru->basvuru_sayisi . " Başvuru"
                ];
            }
        };
        $finshApplication = Application::where('status_id', 7)->count();
        return view('front.pages.homepage', compact('announcements', 'applicationCount', 'data', 'finshApplication'));
    }
}

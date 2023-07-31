@section('sidebar')

    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center ml-3 mt-3" href="{{ route('homepage') }}">
            <div class="sidebar-brand-icon text-white">
                <img style="width: 75px" src="https://www.firat.edu.tr/front/images/firat_orj_b.png" alt="">
            </div>
            <div class="sidebar-brand-text mx-3">F.Ü. Staj Otomasyonu</div>
        </a>
        <br>
        <hr class="sidebar-divider my-0">
        <li class="nav-item @if(\Request::getRequestUri() == '/') active @endif">
            <a class="nav-link" href="{{ route('homepage') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Anasayfa</span></a>
        </li>
        <hr class="sidebar-divider">
        @php
            $userType = \App\Models\User::where('id', \Illuminate\Support\Facades\Auth::id())->first(['id', 'user_type']);
        @endphp
        @if($userType->user_type == 0)
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link collapsed" href="{{ asset('dashboard') }}/#" data-toggle="collapse" data-target="#collapseTwo"--}}
{{--                   aria-expanded="true" aria-controls="collapseTwo">--}}
{{--                    <i class="fas fa-fw fa-cog"></i>--}}
{{--                    <span>Başvurular</span>--}}
{{--                </a>--}}
{{--                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">--}}
{{--                    <div class="bg-white py-2 collapse-inner rounded">--}}
{{--                        <a class="collapse-item" href="{{ route('application') }}">Başvuru Yap</a>--}}
{{--                        <a class="collapse-item" href="{{ route('applications') }}">Başvurularım</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </li>--}}
            <li class="nav-item @if(\Request::getRequestUri() == '/application') active @endif">
                <a class="nav-link" href="{{ route('application') }}">
                    <i class="fa fa-file-text" aria-hidden="true"></i>
                    <span>Başvuru Yap</span></a>
            </li>
            <li class="nav-item @if(\Request::getRequestUri() == '/application/applications') active @endif">
                <a class="nav-link" href="{{ route('applications') }}">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    <span>Başvurularım</span></a>
            </li>
            <li class="nav-item @if(\Request::getRequestUri() == '/documents') active @endif">
                <a class="nav-link" href="{{ route('documents') }}">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    <span>Staj Evrakları</span></a>
            </li>
        @elseif($userType->user_type == 1)
            <li class="nav-item @if(\Request::getRequestUri() == '/admin/application') active @endif">
                <a class="nav-link" href="{{ route('admin.application') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Başvuruları Görüntüle</span></a>
            </li>
            <li class="nav-item @if(\Request::getRequestUri() == '/admin/internship/period') active @endif">
                <a class="nav-link" href="{{ route('admin.internship.period') }}">
                    <i class="fas fa-fw fa-clock"></i>
                    <span>Staj Dönemi</span></a>
            </li>
            <li class="nav-item @if(\Request::getRequestUri() == '/admin/uygulama') active @endif">
                <a class="nav-link" href="{{ route('admin.uygulama') }}">
                    <i class="fas fa-fw fa-calendar"></i>
                    <span>Uygulama</span></a>
            </li>
            <li class="nav-item @if(\Request::getRequestUri() == '/admin/announcement') active @endif">
                <a class="nav-link" href="{{ route('admin.announcement') }}">
                    <i class="fa-sharp fa-solid fa-bullhorn"></i>
                    <span>Duyurular</span></a>
            </li>
        @endif

    </ul>
@endsection

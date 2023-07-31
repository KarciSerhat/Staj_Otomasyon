@section('toolbar')
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

{{--        <!-- Topbar Search -->--}}
{{--        <form--}}
{{--            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">--}}
{{--            <div class="input-group">--}}
{{--                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."--}}
{{--                       aria-label="Search" aria-describedby="basic-addon2">--}}
{{--                <div class="input-group-append">--}}
{{--                    <button class="btn btn-primary" type="button">--}}
{{--                        <i class="fas fa-search fa-sm"></i>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->

            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="{{ asset('dasboard') }}/#" id="alertsDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-sharp fa-solid fa-bullhorn text-primary"></i>
                    <!-- Counter - Alerts -->
                </a>

                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                     aria-labelledby="alertsDropdown" style="max-height: 400px; overflow-y: auto;">
                    <h6 class="dropdown-header">
                        Duyurular
                    </h6>
                    @if($announcements->first())
                        @foreach($announcements as $item)
                            @php
                                $createdAt = \Carbon\Carbon::parse($item->created_at);
                                $today = \Carbon\Carbon::today();
                                if ($createdAt->isSameDay($today)) {
                                    $date =  "Bugün";
                                } else {
                                    $daysAgo = $createdAt->diffInDays($today);
                                    $date =  $daysAgo . " gün önce";
                                }
                            @endphp
                            <a class="dropdown-item d-flex align-items-center" href="{{ $item->link }}">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fa-sharp fa-solid fa-bullhorn text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-800">{{ $date }}</div>
                                    <span class="font-weight-bold">{{ $item->title }}</span>
                                    <hr>
                                    <small class="font-weight-normal">{{ $item->content }}</small>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="dropdown-item d-flex align-items-center disabled">
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold"><strong>Henüz Duyuru Yok</strong></span>
                            </div>
                        </div>
                    @endif
                </div>
            </li>


            <!-- Nav Item - Messages -->

            <div class=" topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                @php
                    $notifications = \App\Models\Notification::where('user_id', \Illuminate\Support\Facades\Auth::id())->where('is_active', 1)->where('is_deleted', 0)->where('is_read', 0)->orderBy('created_at', 'desc')->get();
                    $notificationCount =  \App\Models\Notification::where('user_id', \Illuminate\Support\Facades\Auth::id())->where('is_active', 1)->where('is_deleted', 0)->where('is_read', 0)->count();
                @endphp
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw text-primary"></i>
                    <!-- Counter - Alerts -->
                    @if($notificationCount > 0)
                        <span class="badge badge-danger badge-counter">{{ $notificationCount }}+</span>
                    @endif
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                     aria-labelledby="alertsDropdown" style="max-height: 400px; overflow-y: auto;">
                    <div class="bg-primary d-flex justify-content-between">
                        <h6 class="dropdown-header">
                            Bildirimler
                        </h6>
                        <a href="" onclick="clearNotification()">
                            <h6 class="dropdown-header">
                                Tümünü Sil
                            </h6>
                        </a>
                    </div>

                    @if($notifications->first())
                        @foreach($notifications as $item)
                            @php
                                $createdAt = \Carbon\Carbon::parse($item->created_at);
                                $today = \Carbon\Carbon::today();
                                if ($createdAt->isSameDay($today)) {
                                    $date =  "Bugün";
                                } else {
                                    $daysAgo = $createdAt->diffInDays($today);
                                    $date =  $daysAgo . " gün önce";
                                }

                                $url = str_replace('/', '$$', $item->link);
                            @endphp
                            <div class="dropdown-item d-flex align-items-center">
                                <a href="{{ route('notification', [$url, $item->id]) }}">
                                    <div>
                                        <div class="small text-gray-800"><strong>{{ $date }}</strong></div>
                                        <span class="font-weight-bold">{{ $item->title }}</span>
                                        <hr>
                                        <small class="font-weight-normal">{{ $item->content }}</small>
                                    </div>
                                </a>
                                <div>
                                    <a href="#" onclick="removeNotification('{{ $item->id }}')">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-times text-white"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="dropdown-item d-flex align-items-center disabled">
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold"><strong>Henüz Bildirim Yok</strong></span>
                            </div>
                        </div>
                    @endif
                </div>
            </li>
            <!-- Nav Item - Messages -->

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="{{ asset('dasboard') }}/#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @php
                        $user = \Illuminate\Support\Facades\Auth::user();
                        $userName = $user->userFirstName . ' ' . $user->userLastName;
                        $userTitle = $user->userDescription;
                    @endphp
                    <span class="mr-2 d-none d-lg-inline text-gray-800 small"><strong>{{ $userName . ' - ' . $userTitle }}</strong></span>
{{--                    <img class="img-profile rounded-circle"--}}
{{--                         src="{{ asset('dashboard') }}/img/undraw_profile.svg">--}}
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                     aria-labelledby="userDropdown">
{{--                    <a class="dropdown-item" href="{{ asset('dasboard') }}/#">--}}
{{--                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                        Profile--}}
{{--                    </a>--}}
{{--                    <a class="dropdown-item" href="{{ asset('dasboard') }}/#">--}}
{{--                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                        Settings--}}
{{--                    </a>--}}
{{--                    <a class="dropdown-item" href="{{ asset('dasboard') }}/#">--}}
{{--                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                        Activity Log--}}
{{--                    </a>--}}
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ asset('dasboard') }}/#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>


        </ul>

    </nav>

@endsection

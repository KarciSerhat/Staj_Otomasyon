@extends('front.layouts.app')
@include('front.layouts.sidebar')
@include('front.layouts.toolbar')

@section('content')
    <div class="container-fluid">
        @php
            $userType = \App\Models\User::where('id', \Illuminate\Support\Facades\Auth::id())->first(['id', 'user_type']);
        @endphp
        @if($userType->user_type == 1)
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card " style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Stajı Devam Eden Öğrenci Sayısı</strong></h5>
                                <hr>
                                <p class="card-text align-items-center text-center"><strong>{{ $applicationCount }}</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="card " style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Stajı Devam Eden Öğrenci Sayısı</strong></h5>
                                <hr>
                                @foreach($data as $key => $item)
                                    <p class="card-text align-items-center text-center">{{ $item[0] }}<hr></p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card" style="width: 18rem;">
                            <div class="card " style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Stajı Biten Öğrenci Sayısı</strong></h5>
                                    <hr>
                                    <p class="card-text align-items-center text-center"><strong>{{ $finshApplication }}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        @endif


        @if($announcements->first())
            <h3>Duyurular</h3>
            <hr>
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
                <div class="card mb-3">
                    <a class="list-group-item list-group-item-action" href="{{ $item->link }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <hr>
                            <p class="card-text">{{ $item->content }}</p>
                            <p class="card-text"><small class="text-muted">{{ $date }}</small></p>
                        </div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
@endsection

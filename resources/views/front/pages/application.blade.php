@extends('front.layouts.app')
@include('front.layouts.sidebar')
@include('front.layouts.toolbar')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Başvuru</h1>
        </div>
        <hr>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{$error}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if($isHasApplication)
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                Bir başvurunuz zaten bulunmaktadır!
            </div>
        @endif
        <form action="{{ route('application.create') }}" method="POST" disabled="true">
            @csrf
            <div class="mb-3">
                <label for="internshipPeriot" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Staj Dönemi</label>
                <select name="internship_periot" id="internship_periot" class="form-control">
                    <option disabled>Seçiniz}</option>
                    @foreach($periots as $periot)
                        <option value="{{ $periot->id }}">{{ $periot->title . ' - ' . $periot->getUygulama->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Şirket Adı</label>
                <input type="text" class="form-control" required id="name" name="name" value="{{ old('name') }}" aria-describedby="nameHelp">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Şirket Email</label>
                <input type="email" class="form-control" required id="email" name="email" value="{{ old('email') }}" aria-describedby="nameHelp">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Şirket Telefon Numarası</label>
                <input type="text" class="form-control" required id="phone" name="number" value="{{ old('number') }}" placeholder="(555) 555 55 55" aria-describedby="numberHelp">
            </div>
            <div class="mb-3">
                <label for="adres" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Şirket Adresi</label>
                <textarea class="form-control" required id="adres" name="adres" rows="3">{{ old('adres') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="vergi_no" class="form-label">Şirket Vergi No (Varsa)</label>
                <input type="text" class="form-control" id="vergi_no" name="vergi_no" value="{{ old('vergi_no') }}" aria-describedby="vergi_noHelp">
            </div>
            <div class="mb-3">
                <label for="order_data" class="form-label">Şirket Hakkında Bilgi (Varsa)</label>
                <textarea class="form-control" name="order_data"  id="order_data" rows="3">{{ old('order_data') }}</textarea>
            </div>
            <div class="mb-3 form-check">
                <input name="accept" type="checkbox"  class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1"><span class="text-danger" style="font-size: 20px">*</span> Doğruluğunu Kabul Ediyorum</label>
            </div>
            <figure class="text-center">
                <blockquote class="blockquote">
                    <p>Başında "<span class="text-danger" style="font-size: 20px">*</span>" olanların doldurulması zorunludur.</p>
                </blockquote>
            </figure>
            @if($isHasApplication)
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    Bir başvurunuz zaten bulunmaktadır!
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Gönder</button>
        </form>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#phone').on('keyup', function() {
                var deger = $(this).val().replace(/\D/g, '');
                var formatliDeger = '';

                if (deger.length > 0) {
                    formatliDeger = deger.match(/(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
                    formatliDeger = (!formatliDeger[2] ? formatliDeger[1] : '(' + formatliDeger[1] + ') ') + formatliDeger[2] + (formatliDeger[3] ? ' ' + formatliDeger[3] : '') + (formatliDeger[4] ? ' ' + formatliDeger[4] : '');
                }

                $(this).val(formatliDeger);
            });
        });
    </script>
    <script>
{{--        @if($isHasApplication)--}}
{{--            Swal.fire({--}}
{{--                icon: 'warning',--}}
{{--                title: 'Başvuru Bulunmaktadır',--}}
{{--                text: ' Bir başvurunuz zaten bulunmaktadır!',--}}
{{--                confirmButtonText: 'Tamam',--}}
{{--            })--}}
{{--        @endif--}}
    </script>
@endsection

@extends('front.layouts.app')
@include('front.layouts.sidebar')
@include('front.layouts.toolbar')

@section('content')
    <div class="container-fluid">
        <h3>Belgeler</h3>
        <hr>
        <div class="card">
            <div class="card-header">
                Staj Formları
            </div>
            <div class="card-body">
                <h5 class="card-title">Staj Yapacak Öğrencilerin Dikkatine</h5>
                <p class="card-text">Staj Formları Staj yapacak öğrenci SGK girişi için müstahak veya müstahak değildir belgesini kendi (e- Devlet)şifresi ile çıkarmalıdır.</p>
                <ul class="list-group list-group-flush">
                    <a href="https://yazmf.firat.edu.tr/tr/document/013">
                        <li class="list-group-item">FORM-1 Staj Başvuru Dilekçesi ve Kabul Formu</li>
                    </a>
                    <a href="https://yazmf.firat.edu.tr/tr/document/01223">
                        <li class="list-group-item">FORM-2 Staj Ücretlerine İşsizlik Fonu Katkısı Bilgi ve Onay Formu</li>
                    </a>
                    <a href="https://yazmf.firat.edu.tr/tr/document/015">
                        <li class="list-group-item">FORM-3 Staj Değerlendirme Formu</li>

                    </a>
                    <a href="https://yazmf.firat.edu.tr/tr/document/016">
                        <li class="list-group-item">FORM-4 Zorunlu Staj ve Sigorta Belgesi</li>
                    </a>
                </ul>
                <br>
                <h5 class="card-title">Staj Dosyası kapağı Dekanlık Staj Biriminden temin edilebilir.</h5>
                <ul class="list-group list-group-flush">
                    <a href="https://yazmf.firat.edu.tr/subdomain_files/yaz.mf.firat.edu.tr/files/24/Staj%20Defteri%20(2).docx">
                        <li class="list-group-item">STAJ DEFTERİ</li>
                    </a>
                </ul>
            </div>
        </div>
        <br>

    </div>
@endsection

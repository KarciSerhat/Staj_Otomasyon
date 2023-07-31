@extends('front.layouts.app')
@include('front.layouts.sidebar')
@include('front.layouts.toolbar')
@section('style')
    <style>
        .dataTables_filter {
            display: flex;
            justify-content: flex-end;
        }
        .hidden {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tüm Başvurularım</h1>
        </div>
        <hr>
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    @if($rejectionReasons)
                        @foreach($rejectionReasons as $item)
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading">{{ $item->getCompany->name . ' ' . $item->getPeriot->title . ' Stajı Hakkında' }} </h4>
                                <p>{{ $item->description }}</p>
                            </div>
                        @endforeach
                    @endif
                    <div class="card mb-4">
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6>Başvurular Tablosu</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Şirket Adı</th>
                                        <th>Şirket Telefon</th>
                                        <th>Şirket Email</th>
                                        <th>Staj Dönemi</th>
                                        <th>Uygulama Dersi</th>
                                        <th>Durumu</th>
                                        <th>İşlemler</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editModalForm" method="post" >
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Şirket Adı</label>
                            <input type="text" class="form-control" required id="name" name="name" value="{{ old('name') }}" aria-describedby="nameHelp">
                            <input type="hidden" class="form-control" required id="id" name="id">
                            <input type="hidden" class="form-control" required id="dataId" name="dataId">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Şirket Email</label>
                            <input type="email" class="form-control" required id="email" name="email" value="{{ old('email') }}" aria-describedby="nameHelp">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Şirket Telefon Numarası</label>
                            <input type="text" class="form-control" required id="number" name="number" value="{{ old('number') }}" placeholder="(555) 555 55 55" aria-describedby="numberHelp">
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="sendDocumentModal" tabindex="-1" role="dialog" aria-labelledby="sendDocumentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendDocumentLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="sendDocumentForm" method="post" >
                        <figure class="text-center">
                            <blockquote class="blockquote">
                                <p>Belgelerin hepsini <strong>PDF</strong> formatında yükleyiniz</p>
                            </blockquote>
                        </figure>
                        <hr>
                        @csrf
                        <input type="hidden" class="form-control" required id="id" name="id">
                        <input type="hidden" class="form-control" required id="dataId" name="dataId">
                        <div class="form-group">
                            <label for="stajKabulFormu">Staj Kabul Formu</label>
                            <input type="file" class="form-control-file" name="stajKabulFormu" id="stajKabulFormu" accept=".pdf">
                            <div>
                                <hr>
                                <p id="stajKabulFormuNamePreview"></p>
                                <button id="stajKabulFormuDownloadBtn" class="btn btn-outline-info previewDoc hidden" type="button">Görüntüle</button>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nufusCuzdan">Nüfus Cüzdan Çıktısı</label>
                            <input type="file" class="form-control-file" name="nufusCuzdan" id="nufusCuzdan" accept=".pdf">
                            <div>
                                <hr>
                                <p id="nufusCuzdanNamePreview"></p>
                                <button id="nufusCuzdanDownloadBtn" class="btn btn-outline-info previewDoc hidden" type="button">Görüntüle</button>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="iszizlikFonu">İşsizlik Fonu</label>
                            <input type="file" class="form-control-file" name="iszizlikFonu" id="iszizlikFonu" accept=".pdf">
                            <div>
                                <hr>
                                <p id="iszizlikFonuNamePreview"></p>
                                <button data-name="" id="iszizlikFonuDownloadBtn" class="btn btn-outline-info previewDoc hidden" type="button">Görüntüle</button>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mustahaklikBelgesi">Müstahaklık Belgesi</label>
                            <input type="file" class="form-control-file" name="mustahaklikBelgesi" id="mustahaklikBelgesi" accept=".pdf">
                            <div>
                                <hr>
                                <p id="mustahaklikBelgesiNamePreview"></p>
                                <button id="mustahaklikBelgesiDownloadBtn" class="btn btn-outline-info previewDoc hidden" type="button">Görüntüle</button>
                                <hr>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input name="accept" type="checkbox"  class="form-check-input" id="exampleCheck2">
                            <label class="form-check-label" for="exampleCheck2"><span class="text-danger" style="font-size: 20px">*</span> Doğruluğunu Kabul Ediyorum</label>
                        </div>
                        <figure class="text-center">
                            <blockquote class="blockquote">
                                <p>Başında "<span class="text-danger" style="font-size: 20px">*</span>" olanların doldurulması zorunludur.</p>
                            </blockquote>
                        </figure>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" id="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">

        function successReloadDT () {
            Swal.fire({
                icon: 'success',
                title: 'Başarılı',
                text: 'İşlem Başarılı',
            }).then(function () {
                $('.datatable').DataTable().ajax.reload();
            });
        }
        $(function () {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                },
                ajax: "{{ route('getApplications') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'company', name: 'company'},
                    {data: 'companyPhone', name: 'companyPhone'},
                    {data: 'companyMail', name: 'companyMail'},
                    {data: 'period', name: 'period'},
                    {data: 'uygulama', name: 'uygulama'},
                    {data: 'status', name: 'status'},

                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        });

        function editBtn (id) {
            $('#editModal').modal('toggle');
            $.ajax({
                url: 'application/detail/' + id,
                method: 'GET',
                success: function(response) {
                    $("#editModalLabel").text(response.data[0].name);
                    $("#name").val(response.data[0].name);
                    $("#email").val(response.data[0].email);
                    $("#number").val(response.data[0].number);
                    $("#adres").val(response.data[0].adres);
                    $("#order_data").val(response.data[0].order_data);
                    $("#vergi_no").val(response.data[0].vergi_no);
                    $("#id").val(response.data[0].id);
                    $("#dataId").val(response.data[1].id);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: 'İşlem Sırasında Bir Hata Oluştu',
                    })
                }
            });
        }

        $("#editModalForm").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('application.update') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    $('#editModal').modal('toggle');
                    successReloadDT();
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';

                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + "<br>";
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            html: errorMessage,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: 'İşlem Sırasında Bir Hata Oluştu',
                        });
                    }
                }
            });
        });

        function sendDocument (id) {
            $('#sendDocumentModal').modal('toggle');
            $.ajax({
                url: 'application/detail/' + id,
                method: 'GET',
                success: function(response) {
                    $("#sendDocumentLabel").text(response.data[0].name);
                    $("#id").val(response.data[0].id);
                    $("#dataId").val(response.data[1].id);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: 'İşlem Sırasında Bir Hata Oluştu',
                    })
                }
            });
        }

        function updateDocument (id) {
            $('#sendDocumentModal').modal('toggle');
            $.ajax({
                url: 'application/get/document/' + id,
                method: 'GET',
                success: function(response) {
                    console.log(response)
                    $('.previewDoc').removeClass('hidden');
                    $("#dataId").val(response.data[0].id);

                    $('#stajKabulFormuNamePreview').html((response.data[1].internship_accept));
                    $('#nufusCuzdanNamePreview').html((response.data[1].national_wallet));
                    $('#mustahaklikBelgesiNamePreview').html((response.data[1].insurance_required));
                    $('#iszizlikFonuNamePreview').html((response.data[1].internship_payment_accept));

                    $('#iszizlikFonuDownloadBtn').attr('data-name', (response.data[1].internship_payment_accept));
                    $('#nufusCuzdanDownloadBtn').attr('data-name', (response.data[1].national_wallet));
                    $('#mustahaklikBelgesiDownloadBtn').attr('data-name', (response.data[1].insurance_required));
                    $('#stajKabulFormuDownloadBtn').attr('data-name', (response.data[1].internship_accept));
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: 'İşlem Sırasında Bir Hata Oluştu',
                    })
                }
            });
        }

        $('#iszizlikFonuDownloadBtn').click(function () {
            var fileName = $(this).data('name');
            download(fileName);
        })
        $('#mustahaklikBelgesiDownloadBtn').click(function () {
            var fileName = $(this).data('name');
            download(fileName);
        })
        $('#nufusCuzdanDownloadBtn').click(function () {
            var fileName = $(this).data('name');
            download(fileName);
        })
        $('#stajKabulFormuDownloadBtn').click(function () {
            var fileName = $(this).data('name');
            download(fileName);
        })

        function download (fileName) {
            $.ajax({
                url: '{{ route("documentDownload") }}',
                type: 'POST',
                data: { fileName: fileName, '_token' : "{{ csrf_token() }}" },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var filename = fileName;
                    var blob = new Blob([response], { type: 'application/octet-stream' });
                    var url = URL.createObjectURL(blob);

                    var link = document.createElement('a');
                    link.href = url;
                    link.download = filename;
                    link.click();
                    URL.revokeObjectURL(url);
                },
                error: function() {
                    console.log('AJAX isteği sırasında bir hata oluştu.');
                }
            });
        }

        function checkInterShipDocForStudent (id) {
            Swal.fire({
                title: 'Onay Kutusu',
                icon: 'question',
                html: '<p>Staj defterinizi teslim ettiyseniz eğer buradan teslim ettiğinize dair <strong>onay</strong> vermeniz gerekiyor.' +
                    ' Eğer teslim edilmemiş ise <strong>onay vermeyiniz</strong>. <br> <hr> <strong>(Not : Eğer varsa elinizde staj defterinin pdf halini yükleyebilirsiniz.)</strong></p>' +
                    '<hr> <input type="file" id="intershipFile" name="intershipFile" accept=".pdf">',
                showCancelButton: true,
                confirmButtonText: 'Evet',
                cancelButtonText: 'Hayır'
            }).then((result) => {
                if (result.isConfirmed) {
                    const file = $('#intershipFile')[0].files[0];
                    console.log($('#intershipFile')[0].files[0])
                    sendAjaxRequest(id, file);
                }
            });
        }

        function sendAjaxRequest(id, file) {
            var formData = new FormData();
            formData.append('file', file);
            formData.append('id', id);
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: '{{route('internshipsBook')}}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    successReloadDT();
                },
                error: function() {
                    Swal.fire({
                        title: 'Hata',
                        text: 'Ajax isteği sırasında bir hata oluştu.',
                        icon: 'error'
                    });
                }
            });
        }


        $('#submit').click(function(e) {
            e.preventDefault();

            var formData = new FormData();
            var mustahaklikBelgesi = $('#mustahaklikBelgesi')[0].files[0];
            var nufusCuzdan = $('#nufusCuzdan')[0].files[0];
            var iszizlikFonu = $('#iszizlikFonu')[0].files[0];
            var stajKabulFormu = $('#stajKabulFormu')[0].files[0];

            if (!mustahaklikBelgesi || !nufusCuzdan || !iszizlikFonu || !stajKabulFormu) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata',
                    text: 'Tüm dosyalar eksiksiz olmalıdır',
                });
                return;
            }
            if ($('#exampleCheck2').is(':checked')) {
                formData.append('mustahaklikBelgesi', mustahaklikBelgesi);
                formData.append('nufusCuzdan', nufusCuzdan);
                formData.append('iszizlikFonu', iszizlikFonu);
                formData.append('stajKabulFormu', stajKabulFormu);
                formData.append('company_id', $('#id').val());
                formData.append('application_id', $('#dataId').val());
                formData.append('_token', "{{ csrf_token() }}");

                // SweetAlert loading ekranı
                var loadingSwal = Swal.fire({
                    title: 'Yükleniyor...',
                    html: 'İşlem tamamlanana kadar bekleyiniz.',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    },
                    showCancelButton: false, // İptal butonunu gizle
                    showConfirmButton: false, // Onay butonunu gizle
                    allowEscapeKey: false // ESC tuşuna izin verme
                });

                $.ajax({
                    url: '{{ route("sendDocument") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        loadingSwal.close(); // Yükleme ekranını kapat

                        $('#sendDocumentModal').modal('toggle');
                        successReloadDT();
                    },
                    error: function(xhr, status, error) {
                        loadingSwal.close(); // Yükleme ekranını kapat

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';

                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + "<br>";
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Hata',
                                html: errorMessage,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata',
                                text: 'İşlem Sırasında Bir Hata Oluştu',
                            });
                        }
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata',
                    text: 'Doğruluğunu Kabul ediniz.',
                });
            }
        });

    </script>
@endsection

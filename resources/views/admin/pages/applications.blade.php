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
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tüm Başvurular</h1>
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
                                        <th>Adımlar</th>
                                        <th>Öğrenci</th>
                                        <th>Red Nedeni</th>
                                        <th>Şirket Adı</th>
                                        <th>Şirket Telefon</th>
                                        <th>Şirket Email</th>
                                        <th>Şirket Adres</th>
                                        <th>Uygulama Dersi</th>
                                        <th>Staj Dönemi</th>
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
    <div class="modal fade" id="showApplication" tabindex="-1" role="dialog" aria-labelledby="showApplicationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showApplicationLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Öğrenci Bilgileri</h5>
                    <div class="mb-3">
                        <label for="studentName" class="form-label"> Öğrenci Adı</label>
                        <input disabled type="text" class="form-control" required id="studentName" name="studentName" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                        <label for="studentNo" class="form-label"> Öğrenci Email</label>
                        <input disabled type="text" class="form-control" required id="studentNo" name="studentNo" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                        <label for="studentDep" class="form-label"> Öğrenci Bölümü</label>
                        <input disabled type="text" class="form-control" required id="studentDep" name="studentDep" aria-describedby="nameHelp">
                    </div>
                    <hr>
                    <h5>Şirket Bilgileri</h5>
                    <div class="mb-3">
                        <label for="name" class="form-label"> Şirket Adı</label>
                        <input disabled type="text" class="form-control" required id="name" name="name" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"> Şirket Email</label>
                        <input disabled type="email" class="form-control" required id="email" name="email" aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label"> Şirket Telefon Numarası</label>
                        <input disabled type="text" class="form-control" required id="number" name="number" placeholder="(555) 555 55 55" aria-describedby="numberHelp">
                    </div>
                    <div class="mb-3">
                        <label for="adres" class="form-label"> Şirket Adresi</label>
                        <textarea disabled class="form-control" required id="adres" name="adres" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="vergi_no" class="form-label">Şirket Vergi No (Varsa)</label>
                        <input disabled type="text" class="form-control" id="vergi_no" name="vergi_no" aria-describedby="vergi_noHelp">
                    </div>
                    <div class="mb-3">
                        <label for="order_data" class="form-label">Şirket Hakkında Bilgi (Varsa)</label>
                        <textarea disabled class="form-control" name="order_data"  id="order_data" rows="3"></textarea>
                    </div>
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
                    <div class="form-group">
                        <label for="stajKabulFormu"><strong>Staj Kabul Formu</strong></label>
                        <div>
                            <p id="stajKabulFormuNamePreview"></p>
                            <button id="stajKabulFormuDownloadBtn" class="btn btn-outline-info previewDoc" type="button">Görüntüle</button>
                            <hr>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nufusCuzdan"><strong>Nüfus Cüzdan Çıktısı</strong></label>
                        <div>
                            <p id="nufusCuzdanNamePreview"></p>
                            <button id="nufusCuzdanDownloadBtn" class="btn btn-outline-info previewDoc" type="button">Görüntüle</button>
                            <hr>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="iszizlikFonu"><strong>İşsizlik Fonu</strong></label>
                        <div>
                            <p id="iszizlikFonuNamePreview"></p>
                            <button data-name="" id="iszizlikFonuDownloadBtn" class="btn btn-outline-info previewDoc" type="button">Görüntüle</button>
                            <hr>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mustahaklikBelgesi"><strong>Müstahaklık Belgesi</strong></label>
                        <div>
                            <p id="mustahaklikBelgesiNamePreview"></p>
                            <button id="mustahaklikBelgesiDownloadBtn" class="btn btn-outline-info previewDoc" type="button">Görüntüle</button>
                            <hr>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="internshipBookModal" tabindex="-1" role="dialog" aria-labelledby="internshipBookLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="internshipBookLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="stajDefteri"><strong>Staj Defteri</strong></label>
                        <div>
                            <p id="stajDefteriNamePreview"></p>
                            <button id="stajDefteriDownloadBtn" class="btn btn-outline-info previewDoc" type="button">Görüntüle</button>
                            <hr>
                        </div>
                    </div>
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
                ajax: "{{ route('admin.getApplications') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'step', name: 'step'},
                    {data: 'student', name: 'student'},
                    {data: 'rejection', name: 'rejection'},
                    {data: 'company', name: 'company'},
                    {data: 'companyPhone', name: 'companyPhone'},
                    {data: 'companyMail', name: 'companyMail'},
                    {data: 'adres', name: 'adres'},
                    {data: 'uygulama', name: 'uygulama'},
                    {data: 'period', name: 'period'},
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

        function step0(id, statusId) {
            var reject = false;
            if(statusId > 0) {
                reject = true;
            }
            sendAjaxRequest(id, 0, reject)

        }

        function step1(id, statusId) {
            var reject = false;
            if(statusId > 1) {
                reject = true;
            }
            sendAjaxRequest(id, 1, reject)
        }

        function step2(id, statusId) {
            var reject = false;
            if(statusId > 4) {
                reject = true;
            }
            sendAjaxRequest(id, 2, reject)
        }

        function step3(id, statusId) {
            var reject = false;
            if(statusId > 5) {
                reject = true;
            }
            sendAjaxRequest(id, 3, reject)
        }

        function step4(id, statusId) {
            var reject = false;
            if(statusId > 6) {
                reject = true;
            }
            sendAjaxRequest(id, 4, reject)
        }

        function step5(id, statusId) {
            var reject = false;
            if(statusId > 7) {
                reject = true;
            }
            sendAjaxRequest(id, 5, reject)
        }

        function sendAjaxRequest (id, step, reject = false ) {
            if (reject) {
                Swal.fire({
                    title: 'Red Nedeni',
                    html: '<textarea id="rejectionReason" rows="4" cols="50" placeholder="Reddetme nedenini girin"></textarea>',
                    showCancelButton: true,
                    confirmButtonText: 'Gönder',
                    cancelButtonText: 'İptal',
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            resolve([
                                $('#rejectionReason').val()
                            ]);
                        });
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        var rejectionReason = result.value[0];
                        if (rejectionReason.trim() !== '') {
                            // AJAX isteğini burada gönder
                            $.ajax({
                                url: '/admin/step/step' + step,
                                method: 'POST',
                                data: {
                                    '_token' : '{{ csrf_token() }}',
                                    'id': id,
                                    'step': step,
                                    'rejectionReason': rejectionReason
                                },
                                success: function(response) {
                                    successReloadDT();
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Hata',
                                        text: 'İşlem Sırasında Bir Hata Oluştu',
                                    })
                                }
                            });
                        } else {
                            Swal.fire('Uyarı!', 'Red nedenini girin.', 'warning');
                        }
                    }
                });
            } else {
                $.ajax({
                    url: '/admin/step/step' + step,
                    method: 'POST',
                    data: {
                        '_token' : '{{ csrf_token() }}',
                        'id': id,
                        'step': step
                    },
                    success: function(response) {
                        successReloadDT();
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
        }

        function showApplication (id) {
            $('#showApplication').modal('toggle');
            $.ajax({
                url: 'step/getAdminApplicationDetail/' + id,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#showApplicationLabel').html(response.data.get_user.userFullName)
                    $('#name').val(response.data.get_company.name)
                    $('#email').val(response.data.get_company.email)
                    $('#number').val(response.data.get_company.number)
                    $('#adres').val(response.data.get_company.adres)
                    $('#vergi_no').val(response.data.get_company.vergi_no)
                    $('#studentDep').val(response.data.get_user.userOfficeLocation)
                    $('#studentName').val(response.data.get_user.userFirstName + ' ' + response.data.get_user.userLastName)
                    $('#studentNo').val(response.data.get_user.userEMailAddress)
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

        function showDocument (id) {
            $('#sendDocumentModal').modal('toggle');
            $.ajax({
                url: 'step/get/document/' + id,
                method: 'GET',
                success: function(response) {
                    console.log(response)
                    $('#sendDocumentLabel').html(response.data[0].get_user.userFullName)

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

        function showInternshipBook (id) {
            $('#internshipBookModal').modal('toggle');
            $.ajax({
                url: 'step/get/document/' + id,
                method: 'GET',
                success: function(response) {
                    console.log(response)
                    $('#internshipBookLabel').html(response.data[0].get_user.userFullName)
                    $('#stajDefteriNamePreview').html((response.data[1].internships_book));
                    $('#stajDefteriDownloadBtn').attr('data-name', (response.data[1].internships_book));
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
        $('#stajDefteriDownloadBtn').click(function () {
            var fileName = $(this).data('name');
            download(fileName);
        })

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

    </script>
@endsection

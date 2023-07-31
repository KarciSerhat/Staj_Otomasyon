@extends('front.layouts.app')
@include('front.layouts.sidebar')
@include('front.layouts.toolbar')
@section('style')
    <style>
        .dataTables_filter {
            display: flex;
            justify-content: flex-end;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tüm Staj Dönemi</h1>
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
                            <h6>Staj Dönemi Tablosu</h6>
                            <button id="create" class="btn btn-primary m-3"> Oluştur</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered datatable">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Adı</th>
                                        <th>Uygulama</th>
                                        <th>Başlangıç Tarihi</th>
                                        <th>Bitiş Tarihi</th>
                                        <th>Toplam Başvuru Sayısı</th>
                                        <th>Aktif/Pasif</th>
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
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Staj</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createModalForm" method="post" >
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Dönem Adı</label>
                            <input type="text" class="form-control" required id="title" name="title" placeholder="Dönem Adı" value="{{ old('title') }}">
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Başlangıç Tarihi</label>
                            <input type="datetime-local" class="form-control" required id="start_date" name="start_date" value="{{ old('start_date') }}">
                        </div>
                        <div class="mb-3">
                            <label for="expire_date" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Bitiş Tarihi</label>
                            <input type="datetime-local" class="form-control" required id="expire_date" name="expire_date" value="{{ old('expire_date') }}">
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="uygulama" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Uygulama Adı</label>
                                <select name="uygulama" id="uygulama" class="form-control">
                                    <option selected disabled>Seçiniz</option>
                                    @foreach($uygulama as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </form>
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
                            <label for="titleUpdate" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Dönem Adı</label>
                            <input type="text" class="form-control" required id="titleUpdate" name="title" placeholder="Dönem Adı" value="{{ old('titleUpdate') }}">
                            <input type="hidden" class="form-control" name="id" id="id">
                        </div>
                        <div class="mb-3">
                            <label for="start_dateUpdate" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Başlangıç Tarihi</label>
                            <input type="datetime-local" class="form-control" required id="start_dateUpdate" name="start_date" value="{{ old('start_dateUpdate') }}">
                        </div>
                        <div class="mb-3">
                            <label for="expire_dateUpdate" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Bitiş Tarihi</label>
                            <input type="datetime-local" class="form-control" required id="expire_dateUpdate" name="expire_date" value="{{ old('expire_dateUpdate') }}">
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="uygulamaUpdate" class="form-label"><span class="text-danger" style="font-size: 20px">*</span> Uygulama Adı</label>
                                <select name="uygulama" id="uygulamaUpdate" class="form-control">
                                    <option selected disabled>Seçiniz</option>
                                    @foreach($uygulama as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
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
                ajax: "{{ route('getInternshipPeriods') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {data: 'uygulama', name: 'uygulama'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'expire_date', name: 'expire_date'},
                    {data: 'request_count', name: 'request_count'},
                    {data: 'change', name: 'change'},

                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
        });

        $('#create').click(function () {
            $('#createModal').modal('toggle');
        });
        $("#editModalForm").submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            var start_date = new Date($('#start_dateUpdate').val());
            var expire_date = new Date($('#expire_dateUpdate').val());

            if (start_date > expire_date) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata',
                    text: 'Lütfen Tarihleri Kontrol Ediniz!',
                });
                return;
            }
            var current_date = new Date();
            if (current_date > expire_date) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata',
                    text: 'Lütfen Tarihleri Kontrol Ediniz!',
                });
                return;
            }
            $.ajax({
                url: "{{ route('admin.internship.period.update') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    $('#editModal').modal('toggle');
                    successReloadDT();
                },
                error: function(response, xhr, status, error) {
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
                    } else if (response.responseJSON.message) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: response.responseJSON.message,
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
        $("#createModalForm").submit(function(event) {
            event.preventDefault();
            var start_date = new Date($('#start_date').val());
            var expire_date = new Date($('#expire_date').val());

            if (start_date > expire_date) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata',
                    text: 'Lütfen Tarihleri Kontrol Ediniz!',
                });
                return;
            }
            var current_date = new Date();
            if (current_date > expire_date) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata',
                    text: 'Lütfen Tarihleri Kontrol Ediniz!',
                });
                return;
            }
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('admin.internship.period.create') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    $('#createModalForm')[0].reset();
                    $('#createModal').modal('toggle');
                    successReloadDT();
                },
                error: function(response, xhr, status, error) {
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
                    } else if (response.responseJSON.message) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: response.responseJSON.message,
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

        function editBtn (id) {
            $('#editModal').modal('toggle');
            $.ajax({
                url: 'period/detail/' + id,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    $("#titleUpdate").val(response.data.title);
                    $("#editModalLabel").html(response.data.title);
                    $("#editModalLabel").val(response.data.title);
                    $("#expire_dateUpdate").val(response.data.expire_date);
                    $("#start_dateUpdate").val(response.data.start_date);
                    $("#uygulamaUpdate").val(response.data.uygulama_id);
                    $("#id").val(response.data.id);
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

        function change(id) {
            $.ajax({
                url: 'period/change/' + id,
                method: 'GET',
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

    </script>
@endsection

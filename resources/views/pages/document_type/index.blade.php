@extends('layouts.master')

@section('title')
    @lang('Document Type')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Management Document
        @endslot
        @slot('title')
            Document Type
        @endslot
    @endcomponent

    <div id="documentTypeModal" class="modal fade" tabindex="-1" aria-labelledby="documentTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentTypeModalLabel">Form Document Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="documentTypeForm" name="documentTypeForm">
                        @csrf
                        <input id="id" type="hidden" class="form-control" name="id">
                        <div class="form-group row">
                            <label for="file_extension_id" class="col-md-4 form-label text-md-left">File
                                Extension<span style="color:red;">*</span></label>
                            <div class="col-md-12 validate">
                                <select id="file_extension_id" type="text" class="form-control" name="file_extension_id"
                                    style="width: 100%"></select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect waves-light btn-sm" id="saveBtn"
                        name="saveBtn">Save</button>
                    <button type="button" class="btn btn-secondary waves-effect btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if (auth()->user()->can('Create Document Type'))
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light btn-sm"
                            data-bs-toggle="modal" data-bs-target="#documentTypeModal" id="addNew" name="addNew"><i
                                class="mdi mdi-plus-circle mr-1"></i> Add Data</a>
                    @endif
                </div>
                <div class="card-body">
                    <table id="documentTypesTable" class="table table-striped table-bordered dt-responsive nowrap w-100"
                        width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Document Type</th>
                                @if (auth()->user()->can('Edit Document Type'))
                                    <th>Status</th>
                                @endif
                                @if (auth()->user()->can('Delete Document Type'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            let request = {
                start: 0,
                length: 10
            };
            var isUpdate = false;

            var documentTypesTable = $('#documentTypesTable').DataTable({
                "language": {
                    "paginate": {
                        "next": '<i class="fas fa-arrow-right"></i>',
                        "previous": '<i class="fas fa-arrow-left"></i>'
                    }
                },
                "aaSorting": [],
                "autoWidth": false,
                "ordering": false,
                "responsive": true,
                "serverSide": true,
                "lengthMenu": [
                    [10, 15, 25, 50, -1],
                    [10, 15, 25, 50, "All"]
                ],
                "ajax": {
                    "url": "{{ route('document-type/getData') }}",
                    "type": "POST",
                    "headers": {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    },
                    "beforeSend": function(xhr) {
                        xhr.setRequestHeader("Authorization", "Bearer " + $('#secret').val());
                    },
                    "Content-Type": "application/json",
                    "data": function(data) {
                        request.draw = data.draw;
                        request.start = data.start;
                        request.length = data.length;
                        request.searchkey = data.search.value || "";

                        return (request);
                    },
                },
                "columns": [{
                        "data": null,
                        "width": '5%',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "data": "file_extension",
                        "width": '50%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return data.description + " (." + data.extension + ")";
                        }
                    },
                    @if (auth()->user()->can('Edit Document Type'))
                        {
                            "data": "id",
                            "width": '35%',
                            "defaultContent": "-",
                            render: function(data, type, row) {
                                let isChecked = (row.status) ? "checked" : "";
                                let checkbox = '  <div class="form-check form-switch mb-3">' +
                                    '<input type="checkbox" class="form-check-input status" name="status" id="status' +
                                    data + '" data-id="' + data + '"  ' + isChecked + '>' +
                                    '<span class="custom-switch-indicator"></span>' +
                                    '</div>';
                                return checkbox;
                            }
                        },
                    @endif
                    @if (auth()->user()->can('Delete Document Type'))
                        {
                            "data": "id",
                            "width": '10%',
                            render: function(data, type, row) {
                                var btnDelete = "";
                                btnDelete += '<button name="btnDelete" data-id="' + data +
                                    '" type="button" class="btnDelete btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete Department"><i class="fa fa-trash"></i></button>';
                                return btnDelete;
                            },
                        },
                    @endif
                ]
            });

            function reloadTable() {
                documentTypesTable.ajax.reload(null, false); //reload datatable ajax
            }

            $("#file_extension_id").select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#documentTypeModal'),
                placeholder: "Choose Extension",
                ajax: {
                    url: "{{ route('file-extension/getData') }}",
                    dataType: 'json',
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    method: 'POST',
                    delay: 250,
                    destroy: true,
                    data: function(params) {
                        var query = {
                            searchkey: params.term || '',
                            start: 0,
                            length: 50
                        }
                        return JSON.stringify(query);
                    },
                    processResults: function(data) {
                        var result = {
                            results: [],
                            more: false
                        };
                        if (data && data.data) {
                            $.each(data.data, function() {
                                result.results.push({
                                    id: this.id,
                                    text: this.description + " (." + this.extension +
                                        ")"
                                });
                            })
                        }
                        return result;
                    },
                    cache: false
                },
            });
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#documentTypeForm").valid();
                if (isValid) {
                    if (!isUpdate) {
                        var url = "{{ route('document-type/store') }}";
                    } else {
                        var url = "{{ route('document-type/update') }}";
                    }
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    var formData = new FormData($('#documentTypeForm')[0]);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire(
                                (data.status) ? 'Success' : 'Error',
                                data.message,
                                (data.status) ? 'success' : 'error'
                            )
                            $('#saveBtn').text('Save');
                            $('#saveBtn').attr('disabled', false);
                            reloadTable();
                            $('#documentTypeModal').modal('hide');
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#saveBtn').text('Save');
                            $('#saveBtn').attr('disabled', false);
                        }
                    });
                }
            });

            $('#documentTypesTable').on("click", ".status", function() {
                var id = $(this).attr('data-id');
                let req = {
                    "status": this.checked,
                    "id": id,
                };
                var url = "{{ route('document-type/update') }}";
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: 'POST',
                    url: url,
                    data: req,
                    success: function(response) {
                        toastr.success(response.message)
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    },
                });
            });

            $('#documentTypesTable').on("click", ".btnDelete", function() {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Confirmation',
                    text: "You will delete this data. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('document-type/delete', ['id' => ':id']) }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            headers: {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            },
                            url: url,
                            type: "POST",
                            success: function(data) {
                                Swal.fire(
                                    (data.status) ? 'Success' : 'Error',
                                    data.message,
                                    (data.status) ? 'success' : 'error'
                                )
                                reloadTable();
                            },
                            error: function(response) {
                                Swal.fire(
                                    'Error',
                                    'A system error has occurred. please try again later.',
                                    'error'
                                )
                            }
                        });
                    }
                })
            });

            $('#documentTypeForm').validate({
                rules: {
                    file_extension_id: {
                        required: true,
                    },
                },
                errorElement: 'em',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.validate').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('#addNew').on('click', function() {
                $('#file_extension_id').val('').trigger('change');
                isUpdate = false;
            });
        });
    </script>
@endpush

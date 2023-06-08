@extends('layouts.master')

@section('title')
    @lang('User')
@endsection

@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <!-- choices css -->
    <link href="{{ URL::asset('/assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- color picker css -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/@simonwep/pickr/themes/classic.min.css') }}" />
    <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/@simonwep/pickr/themes/monolith.min.css') }}" />
    <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/@simonwep/pickr/themes/nano.min.css') }}" />
    <!-- 'nano' theme -->

    <!-- datepicker css -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Management User
        @endslot
        @slot('title')
            User
        @endslot
    @endcomponent

    <div id="userModal" class="modal fade" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Form User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('user/store') }}" id="userForm" name="userForm">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="row mb-4">
                            <label for="name" class="col-sm-3 col-form-label">Name<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9 validate">
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="username" class="col-sm-3 col-form-label">Username<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9 validate">
                                <input id="username" type="text" class="form-control" name="username">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="email" class="col-sm-3 col-form-label">Email<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9 validate">
                                <input id="email" type="email" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="role_id" class="col-sm-3 col-form-label">Role<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9 validate">
                                <select name="role_id" id="role_id" class="form-control role_id"></select>
                            </div>
                        </div>
                        <div id="showPassword" class="row mb-4">
                            <label for="password" class="col-sm-3 col-form-label">Password<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9 validate">
                                <input id="password" type="password" class="form-control" name="password" />
                            </div>
                        </div>
                        <div id="showConfirmPassword" class="row mb-4">
                            <label for="password_confirm" class="col-sm-3 col-form-label">Confirm Password<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9 validate">
                                <input id="password_confirm" type="password" class="form-control" name="password_confirm" />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="photo" class="col-sm-3 col-form-label">Upload Foto</label>
                            <div class="col-sm-9 validate">
                                <input id="photo" type="file" class="form-control" name="photo">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect waves-light btn-sm" id="createBtn"
                        name="createBtn">Save</button>
                    <button type="button" class="btn btn-secondary waves-effect btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="changePasswordModal" class="modal fade" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Form Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('user/password') }}" id="changePasswordForm"
                        name="changePasswordForm">
                        @csrf
                        <input id="idUser" type="hidden" class="form-control" name="id" />
                        <div class="row mb-4">
                            <label for="newPassword" class="col-sm-3 col-form-label">New Password<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9 validate">
                                <input id="newPassword" type="password" class="form-control" name="password" />
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="newPasswordConfirm" class="col-sm-3 col-form-label">Confirm Password<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9 validate">
                                <input id="newPasswordConfirm" type="password" class="form-control"
                                    name="password_confirm" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect waves-light btn-sm" id="passwordBtn"
                        name="passwordBtn">Save</button>
                    <button type="button" class="btn btn-secondary waves-effect btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if (auth()->user()->can('Create User'))
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light btn-sm"
                            data-bs-toggle="modal" data-bs-target="#userModal" id="addNew" name="addNew"><i
                                class="mdi mdi-plus-circle mr-1"></i> Add User</a>
                    @endif
                </div>
                <div class="card-body">
                    <table id="usersTable" class="table table-striped table-bordered dt-responsive  nowrap w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Active</th>
                                @if (auth()->user()->can('Edit User') ||
                                        auth()->user()->can('Delete User'))
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

@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ URL::asset('/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ URL::asset('/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>


    <!-- choices js -->
    <script src="{{ URL::asset('/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- color picker js -->
    <script src="{{ URL::asset('/assets/libs/@simonwep/pickr/pickr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- datepicker js -->
    <script src="{{ URL::asset('/assets/libs/flatpickr/flatpickr.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
@endsection

@push('js')
    <script type="text/javascript">
        $(function() {
            let request = {
                start: 0,
                length: 10
            };

            var usersTable = $('#usersTable').DataTable({
                "language": {
                    "paginate": {
                        "next": '<i class="tf-icon bx bx-chevrons-right"></i>',
                        "previous": '<i class="tf-icon bx bx-chevrons-left"></i>'
                    }
                },
                "aaSorting": [],
                "ordering": false,
                "responsive": true,
                "serverSide": true,
                "lengthMenu": [
                    [10, 15, 25, 50, -1],
                    [10, 15, 25, 50, "All"]
                ],
                "ajax": {
                    "url": "{{ route('user/getData') }}",
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
                        "data": "name",
                        "width": '25%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "username",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "email",
                        "width": '30%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "roles",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + (data.length > 0) ? data[0].name :
                                '-' + "</div>";
                        }
                    },
                    {
                        "data": "id",
                        "width": '35%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let isChecked = (row.is_active) ? "checked" : "";
                            let checkbox = '  <div class="form-check form-switch mb-3">' +
                                '<input type="checkbox" class="form-check-input is_active" name="is_active" id="is_active' +
                                data + '" data-id="' + data + '"  ' + isChecked + '>' +
                                '<span class="custom-switch-indicator"></span>' +
                                '</div>';
                            return checkbox;
                        }
                    },
                    @if (auth()->user()->can('Edit User') ||
                            auth()->user()->can('Delete User'))
                        {
                            "data": "id",
                            "width": "10%",
                            render: function(data, type, row) {
                                let btnEdit = "";
                                let btnChangePassword = "";
                                let btnDelete = "";
                                if ("{{ Auth::user()->can('Edit User') }}") {
                                    btnEdit += '<button name="btnEdit" data-id="' + data +
                                        '" type="button" class="btn btn-warning btn-sm btnEdit" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-user-edit"></i></button>';
                                    btnChangePassword +=
                                        '<button name="btnChangePassword" data-id="' + data +
                                        '" type="button" class="btn btn-dark btn-sm btnChangePassword" data-toggle="tooltip" data-placement="top" title="Change Password"><i class="fa fa-user-lock"></i></button>';
                                }
                                if ("{{ Auth::user()->can('Delete User') }}") {
                                    btnDelete += '<button name="btnDelete" data-id="' + data +
                                        '" type="button" class="btn btn-danger btn-sm btnDelete" data-toggle="tooltip" data-placement="top" title="Delete User"><i class="fa fa-trash"></i></button>';
                                }
                                return btnEdit + " " + btnChangePassword + " " + btnDelete;
                            },
                        },
                    @endif
                ]
            });

            function reloadTable() {
                usersTable.ajax.reload(null, false); //reload datatable ajax
            }
            $(".role_id").select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#userModal'),
                placeholder: "Choose Role",
                ajax: {
                    url: "{{ route('role/getData') }}",
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
                                    id: this.name,
                                    text: this.name
                                });
                            })
                        }
                        return result;
                    },
                    cache: false
                },
            });
            $('#createBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#userForm").valid();
                if (isValid) {
                    console.log('test');
                    $('#createBtn').text('Save...');
                    $('#createBtn').attr('disabled', true);
                    if (!isUpdate) {
                        var url = "{{ route('user/store') }}";
                    } else {
                        var url = "{{ route('user/update') }}";
                    }
                    var formData = new FormData($('#userForm')[0]);
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
                            $('#createBtn').text('Save');
                            $('#createBtn').attr('disabled', false);
                            reloadTable();
                            $('#userModal').modal('hide');
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#createBtn').text('Save');
                            $('#createBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#usersTable').on("click", ".btnEdit", function() {
                isUpdate = true;
                $('#userModal').modal('show');
                $('#showPassword').hide();
                $('#showConfirmPassword').hide();
                $("#password").rules('remove', 'required')
                $("#password_confirm").rules('remove', 'required')
                var id = $(this).attr('data-id');
                var url = "{{ route('user/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        var role = (response.data.roles.length > 0) ? new Option(response.data
                            .roles[0].name, response.data.roles[0].name, true, true) : null;
                        $('#id').val(response.data.id);
                        $('#name').val(response.data.name);
                        $('#username').val(response.data.username);
                        $('#email').val(response.data.email);
                        $('.role_id').append(role).trigger('change');
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
            $('#usersTable').on("click", ".btnChangePassword", function() {
                $('#newPassword').val("");
                $('#newPasswordConfirm').val("");
                $('#changePasswordModal').modal('show');
                var id = $(this).attr('data-id');
                $('#idUser').val(id);
            });
            $('#passwordBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#changePasswordForm").valid();
                var formData = new FormData($('#changePasswordForm')[0]);
                if (isValid) {
                    $('#passwordBtn').text('Save...');
                    $('#passwordBtn').attr('disabled', true);
                    var url = "{{ route('user/password') }}";
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function(data) {
                            Swal.fire(
                                (data.status) ? 'Success' : 'Error',
                                data.message,
                                (data.status) ? 'success' : 'error'
                            )
                            $('#passwordBtn').text('Save');
                            $('#passwordBtn').attr('disabled', false);
                            reloadTable();
                            $('#changePasswordModal').modal('hide');
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#passwordBtn').text('Save');
                            $('#passwordBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#usersTable').on("click", ".is_active", function() {
                var id = $(this).attr('data-id');
                let req = {
                    "is_active": this.checked,
                    "id": id,
                };
                var url = "{{ route('user/updateActive') }}";
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
            $('#usersTable').on("click", ".btnDelete", function() {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Confirmation',
                    text: "You will delete this user. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('user/delete', ['id' => ':id']) }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    'content'),
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

            $('#userForm').validate({
                rules: {
                    username: {
                        required: true,
                    },
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirm: {
                        required: true,
                        minlength: 8,
                        equalTo: "#password"
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
            $('#changePasswordForm').validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirm: {
                        required: true,
                        minlength: 8,
                        equalTo: "#newPassword"
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
                $('#name').val("");
                $('#username').val("");
                $('#email').val("");
                $('#role_id').val("").trigger('change');
                $('#showPassword').show();
                $("#password").rules("add", {
                    required: true,
                });
                $('#password').val("");
                $('#password_confirm').val("");
                $('#showConfirmPassword').show();
                $("#password_confirm").rules("add", {
                    required: true,
                });
                $('#photo').val("");
                isUpdate = false;
            });
            //
        });
    </script>
@endpush

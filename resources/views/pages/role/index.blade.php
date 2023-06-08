@extends('layouts.master')

@section('title')
    @lang('Role')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Management User
        @endslot
        @slot('title')
            Role
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if (auth()->user()->can('Create Role'))
                        <a href="{{ route('role/create') }}" class="btn btn-dark waves-effect waves-light btn-sm"><i
                                class="mdi mdi-plus-circle mr-1"></i> Add Role</a>
                    @endif
                </div>
                <div class="card-body">
                    <table id="rolesTable" class="table table-striped table-bordered dt-responsive nowrap w-100"
                        width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Role Name</th>
                                <th>Description</th>
                                @if (auth()->user()->can('Edit Role') ||
                                        auth()->user()->can('Delete Role'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            let request = {
                start: 0,
                length: 10
            };

            var rolesTable = $('#rolesTable').DataTable({
                "language": {
                    "paginate": {
                        "next": '<i class="fa fa-angle-right"></i>',
                        "previous": '<i class="fa fa-angle-left"></i>'
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
                    "url": "{{ route('role/getData') }}",
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
                        "width": '30%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "description",
                        "width": '55%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + (data) ? data : '-' + "</div>";
                        },
                    },
                    @if (auth()->user()->can('Edit Role') ||
                            auth()->user()->can('Delete Role'))
                        {
                            "data": "id",
                            "width": '10%',
                            render: function(data, type, row) {
                                let btnEdit = "";
                                let btnDelete = "";
                                if ("{{ Auth::user()->can('Edit Role') }}") {
                                    btnEdit += '<a href="/role/edit/' + data +
                                        '" name="btnEdit" data-id="' + data +
                                        '" type="button" class="btn btn-warning btn-sm btnEdit" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>';
                                }
                                if ("{{ Auth::user()->can('Delete Role') }}") {
                                    btnDelete += '<button name="btnDelete" data-id="' + data +
                                        '" type="button" class="btn btn-danger btn-sm btnDelete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>';
                                }

                                return btnEdit + " " + btnDelete;
                            },
                        },
                    @endif
                ]
            });

            function reloadTable() {
                rolesTable.ajax.reload(null, false); //reload datatable ajax
            }
            $('#rolesTable').on("click", ".btnDelete", function() {
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Confirmation',
                    text: "You will delete this role. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, im sure',
                    cancelButtonText: 'Cancel'
                }).then(function(result) {
                    if (result.value) {
                        var url = "{{ route('role/delete', ['id' => ':id']) }}";
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

        });
    </script>
@endpush

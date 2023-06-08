@extends('layouts.master')

@section('title')
    @lang('Schedule Email')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Sales
        @endslot
        @slot('title')
            Schedule Email
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if (auth()->user()->can('Create Schedule Email'))
                        <a href="{{ route('schedule-mail/create') }}"
                            class="btn btn-dark waves-effect waves-light btn-sm"><i class="mdi mdi-plus-circle mr-1"></i>
                            Create Schedule Email</a>
                    @endif
                </div>
                <div class="card-body">
                    <table id="scheduleEmailsTable" class="table table-striped table-bordered dt-responsive nowrap w-100"
                        width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Date</th>
                                <th>Scope</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Action</th>
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
            let user_id = "{{ Auth::user()->id }}";
            let request = {
                start: 0,
                length: 10
            };

            let scheduleEmailsTable = $('#scheduleEmailsTable').DataTable({
                "language": {
                    "paginate": {
                        "next": '<i class="fas fa-arrow-right"></i>',
                        "previous": '<i class="fas fa-arrow-left"></i>'
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
                    "url": "{{ route('schedule-mail/getData') }}",
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
                        "data": "user.name",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "date",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + moment(data).locale('id').format(
                                "DD MMMM YYYY") + "</div>";
                        },
                    },
                    {
                        "data": "id",
                        "width": '25%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let scope = ''
                            $.each(row.schedule_email_scopes, function(key, value) {
                                let no = key + 1;
                                scope += no + '. ' + value.scope.name + '<br>';
                            });
                            return "<div class='text-wrap'>" + scope + "</div>";
                        },
                    },
                    {
                        "data": "subject",
                        "width": '20%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "</div>";
                        },
                    },
                    {
                        "data": "schedule_status",
                        "width": '5%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let status = ''
                            if (data == '1') {
                                status =
                                    '<span class="badge rounded-pill bg-warning">Pending</span>';
                            } else if (data == '2') {
                                status =
                                    '<span class="badge rounded-pill bg-success">Success</span>';
                            } else if (data == '3') {
                                status =
                                    '<span class="badge rounded-pill bg-danger">Failed</span>';
                            }
                            return "<div class='text-wrap'>" + status + "</div>";
                        },
                    },
                    {
                        "data": "id",
                        "width": '15%',
                        render: function(data, type, row) {
                            let btnDetail = "";
                            let btnEdit = "";
                            let btnDelete = "";

                            btnDetail += '<a href="/schedule-mail/detail/' + data +
                                '" name="btnEdit" type="button" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>';
                            if (user_id == row.user_id && row.schedule_status === '1') {
                                if ("{{ Auth::user()->can('Edit Schedule Email') }}") {
                                    btnEdit += '<a href="/schedule-mail/edit/' + data +
                                        '" name="btnEdit" type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>';
                                }
                                if ("{{ Auth::user()->can('Delete Schedule Email') }}") {
                                    btnDelete += '<button name="btnDelete" data-id="' + data +
                                        '" type="button" class="btn btn-danger btn-sm btnDelete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>';
                                }
                            }
                            return btnDetail + " " + btnEdit + " " + btnDelete;
                        },
                    },
                ]
            });

            function reloadTable() {
                scheduleEmailsTable.ajax.reload(null, false); //reload datatable ajax
            }
            $('#scheduleEmailsTable').on("click", ".btnDelete", function() {
                let id = $(this).attr('data-id');
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
                        let url = "{{ route('schedule-mail/delete', ['id' => ':id']) }}";
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

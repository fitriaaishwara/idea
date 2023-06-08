@extends('layouts.master')

@section('title')
    @lang('Client')
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
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Sales
        @endslot
        @slot('title')
            Client
        @endslot
    @endcomponent

    <div id="followUpModal" class="modal fade" tabindex="-1" aria-labelledby="followUpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="followUpModalLabel">Form Follow Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="followUpForm" name="followUpForm">
                        @csrf
                        <input id="client_id" type="hidden" class="form-control" name="client_id">
                        <input id="type" type="hidden" class="form-control" name="type">
                        <div class="mb-3 form-group row">
                            <label for="textType" class="col-md-2 form-control-label text-md-left">Type</label>
                            <div class="col-md-10 validate">
                                <input disabled id="textType" type="text" class="form-control" name="textType">
                            </div>
                        </div>
                        <div class="mb-3 form-group row">
                            <label for="name" class="col-md-2 form-control-label text-md-left">Client</label>
                            <div class="col-md-10 validate">
                                <input disabled id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="mb-3 form-group row">
                            <label for="address" class="col-md-2 form-control-label text-md-left">Address</label>
                            <div class="col-md-10 validate">
                                <textarea disabled id="address" name="address" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div id="showAmountProposal" class="form-group row mb-3" style="display: none;">
                            <label for="amount" class="col-md-2 form-control-label text-md-left">Amount<span
                                    style="color:red;">*</span></label>
                            <div class="col-md-10 validate">
                                <input id="amount" type="number" class="form-control currency" name="amount"
                                    placeholder="0">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="note" class="col-md-2 form-control-label text-md-left">Note<span
                                    style="color:red;">*</span></label>
                            <div class="col-md-10 validate">
                                <textarea id="note" name="note" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="attachment" class="col-md-2 form-control-label text-md-left">Attachment</label>
                            <div class="col-md-10 validate">
                                <input id="attachment" type="file" class="form-control" name="attachment">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect waves-light btn-sm" id="followUpBtn"
                        name="followUpBtn">Save</button>
                    <button type="button" class="btn btn-secondary waves-effect btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="clientWinModal" class="modal fade" tabindex="-1" aria-labelledby="clientWinModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientWinModalLabel">Form Follow Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="clientWinForm" name="clientWinForm">
                        @csrf
                        <input type="hidden" class="form-control client_id" name="client_id">
                        <div class="row mb-3">
                            <label for="name" class="col-sm-3 form-control-label text-md-left">Client</label>
                            <div class="col-sm-9 validate">
                                <input disabled id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address" class="col-sm-3 form-control-label text-md-left">Address</label>
                            <div class="col-sm-9 validate">
                                <textarea disabled id="address" name="address" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="amount" class="col-sm-3 form-control-label text-md-left">Amount<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9 validate">
                                <input id="amount" type="number" class="form-control currency" name="amount"
                                    placeholder="0">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="note" class="col-sm-3 form-control-label text-md-left">Note<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9 validate">
                                <textarea id="note" name="note" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3 ">
                            <label for="attachment" class="col-sm-3 form-control-label text-md-left">Attachment</label>
                            <div class="col-sm-9 validate">
                                <input id="attachment" type="file" class="form-control" name="attachment">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect waves-light btn-sm" id="clientWinBtn"
                        name="clientWinBtn">Save</button>
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
                    @if (auth()->user()->can('Create Client'))
                        <a href="{{ route('client/create') }}" class="btn btn-dark waves-effect waves-light btn-sm m-1"
                            id="addNew" name="addNew"><i class="mdi mdi-plus-circle mr-1"></i> Add Client</a>
                    @endif
                </div>
                <div class="card-body">
                    <table id="clientTable" class="table table-striped table-bordered dt-responsive  nowrap w-100">
                        <thead><thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Client</th>
                                <th>Scope</th>
                                <th>PIC</th>
                                @if (auth()->user()->can('Follow Up Client'))
                                    <th>Follow Up</th>
                                @endif
                                <th>Action</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection

@push('js')
    <script type="text/javascript">
        $(function() {
            let request = {
                start: 0,
                length: 10
            };

            var clientTable = $('#clientTable').DataTable({
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
                    [10, 15, 25, 50, 100, 250, 500],
                    [10, 15, 25, 50, 100, 250, 500]
                ],
                "ajax": {
                    "url": "{{ route('client/getData') }}",
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
                        "data": "id",
                        "width": '25%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let regency = (row.regency) ? row.regency.name : '-';
                            let address = (row.address) ? row.address : '-';
                            let sales = (row.user) ? row.user.name : '-';
                            let client = '<b>' + row.name + '</b><br>' + regency + '<br>' +
                                address + '<br>Sales : ' + sales;
                            return "<div class='text-wrap'>" + client + "</div>";
                        },
                    },
                    {
                        "data": "id",
                        "width": '25%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let scope1 = (row.scope_1) ? row.scope_1.name : '-';
                            let scope2 = (row.scope_2) ? row.scope_2.name : '-';
                            let scope3 = (row.scope_3) ? row.scope_3.name : '-';
                            let scope = '1. ' + scope1 + '<br>2. ' + scope2 + '<br>3. ' + scope3;
                            return "<div class='text-wrap'>" + scope + "</div>";
                        },
                    },
                    {
                        "data": "id",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let pic = (row.pic) ? row.pic : '-';
                            let mobile_phone = (row.mobile_phone) ? row.mobile_phone : '-';
                            let email = (row.email) ? row.email : '-';
                            let detail = '<b>' + pic + '</b><br>' + mobile_phone + '<br>' + email;
                            return "<div class='text-wrap'>" + detail + "</div>";
                        },
                    },
                    @if (auth()->user()->can('Follow Up Client'))
                        {
                            "data": "id",
                            "className": 'text-center',
                            "width": '15%',
                            render: function(data, type, row) {
                                let typeFollowUp = (row.last_follow_up_client) ? row
                                    .last_follow_up_client.type : '';
                                if (typeFollowUp == '1') {
                                    typeFollowUp = 'Call';
                                } else if (typeFollowUp == '2') {
                                    typeFollowUp = 'Meeting';
                                } else if (typeFollowUp == '3') {
                                    typeFollowUp = 'Proposal';
                                } else if (typeFollowUp == '4') {
                                    typeFollowUp = 'Email';
                                }
                                let date = (row.last_follow_up_client) ? moment(row
                                    .last_follow_up_client.date).format("DD MMMM YYYY") : ''
                                let last_follow_up_client = typeFollowUp + '<br>' + date
                                let btnCall = "";
                                let btnMeeting = "";
                                let btnQuotation = "";

                                btnCall += '<button name="btnCall" data-type="1" data-id="' + row
                                    .id +
                                    '" type="button" class="btn btn-success btn-sm btnFollowUp m-1" data-toggle="tooltip" data-placement="top" title="Call"><i class="fa fa-phone"></i></button>';
                                btnMeeting += '<button name="btnMeeting" data-type="2" data-id="' +
                                    row
                                    .id +
                                    '" type="button" class="btn btn-warning btn-sm btnFollowUp m-1" data-toggle="tooltip" data-placement="top" title="Meeting"><i class="fa fa-user-friends"></i></button>';
                                btnQuotation +=
                                    '<button name="btnQuotation" data-type="3" data-id="' +
                                    row.id +
                                    '" type="button" class="btn btn-info btn-sm btnFollowUp m-1" data-toggle="tooltip" data-placement="top" title="Proposal"><i class="fa fa-file-alt"></i></button>';
                                let detail = btnCall + btnMeeting + btnQuotation + '<br>' +
                                    last_follow_up_client;
                                return detail;
                            },
                        },
                    @endif {
                        "data": "id",
                        "width": '15%',
                        render: function(data, type, row) {
                            let btnWin = "";
                            let btnFollowUp = "";
                            let btnDetail = "";
                            let btnEdit = "";
                            let btnDelete = "";
                            let user_id = '{{ Auth::user()->id }}';
                            if (!row.is_win) {
                                if (user_id == row.user_id) {
                                    btnWin += '<button data-id="' + data +
                                        '" type="button" class="btn btn-success btn-sm btnWin" data-toggle="tooltip" data-placement="top" title="Win"><i class="fas fa-check-double"></i></button>';
                                }
                            }
                            btnFollowUp += '<a href="/client/detail/follow-up/' + data +
                                '" type="button" class="btn btn-dark btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Detail Follow Up"><i class="fa fa-list-ul"></i></a>';
                            btnDetail += '<a href="/client/detail/' + data +
                                '" name="btnDetail" type="button" class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>';
                            if ("{{ Auth::user()->can('Edit Client') }}") {
                                btnEdit += '<a href="/client/edit/' + data +
                                    '" name="btnEdit" type="button" class="btn btn-warning btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>';
                            }
                            if ("{{ Auth::user()->can('Delete Client') }}") {
                                btnDelete += '<button name="btnDelete" data-id="' + data +
                                    '" type="button" class="btn btn-danger btn-sm btnDelete m-1" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>';
                            }
                            return btnWin + btnFollowUp + btnDetail + btnEdit + btnDelete;
                        },
                    },
                ]
            });

            function reloadTable() {
                clientTable.ajax.reload(null, false); //reload datatable ajax
            }
            $('#clientTable').on("click", ".btnWin", function() {
                let id = $(this).attr('data-id');
                $('#clientWinModal').modal('show');
                let url = "{{ route('client/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('.client_id').val(response.data.id);
                        $('#name').val(response.data.name);
                        $('#address').val(response.data.address);
                        $('#note').val('');
                        $('#attachment').val('');
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

            $('#clientTable').on("click", ".btnDelete", function() {
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
                        var url = "{{ route('client/delete', ['id' => ':id']) }}";
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

            $('#clientTable').on("click", ".btnFollowUp", function() {
                let id = $(this).attr('data-id');
                let type = $(this).attr('data-type');
                if (type == 1) {
                    textType = 'Call';
                    $('#showAmountProposal').hide();
                    $("#amount").rules('remove', 'required')
                    $('#amount').val('');
                } else if (type == 2) {
                    textType = 'Meeting';
                    $('#showAmountProposal').hide();
                    $("#amount").rules('remove', 'required')
                    $('#amount').val('');
                } else if (type == 3) {
                    textType = 'Proposal';
                    $('#showAmountProposal').show();
                    $("#amount").rules("add", {
                        required: true,
                    });
                    $('#amount').val('');
                }
                $('#followUpModal').modal('show');
                let url = "{{ route('client/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('#client_id').val(response.data.id);
                        $('#type').val(type);
                        $('#textType').val(textType);
                        $('#name').val(response.data.name);
                        $('#address').val(response.data.address);
                        $('#note').val('');
                        $('#attachment').val('');
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

            $('#followUpBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#followUpForm").valid();
                if (isValid) {
                    let url = "{{ route('client/follow-up') }}";
                    $('#followUpBtn').text('Save...');
                    $('#followUpBtn').attr('disabled', true);
                    var formData = new FormData($('#followUpForm')[0]);
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
                            $('#followUpBtn').text('Save');
                            $('#followUpBtn').attr('disabled', false);
                            reloadTable();
                            $('#followUpModal').modal('hide');
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#followUpBtn').text('Save');
                            $('#followUpBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#followUpForm').validate({
                rules: {
                    note: {
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
            $('#clientWinForm').validate({
                rules: {
                    amount: {
                        required: true,
                    },
                    note: {
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
            $('#clientWinBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#clientWinForm").valid();
                if (isValid) {
                    let url = "{{ route('client/win') }}";
                    $('#clientWinBtn').text('Save...');
                    $('#clientWinBtn').attr('disabled', true);
                    let formData = new FormData($('#clientWinForm')[0]);
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
                            $('#clientWinBtn').text('Save');
                            $('#clientWinBtn').attr('disabled', false);
                            reloadTable();
                            $('#clientWinModal').modal('hide');
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#clientWinBtn').text('Save');
                            $('#clientWinBtn').attr('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
@endpush

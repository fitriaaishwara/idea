@extends('layouts.master')

@section('title')
    @lang('Edit Project')
@endsection
<style>
    .select2-container .select2-search--inline:first-child .select2-search__field {
        width: 100% !important;
    }
</style>
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Project
        @endslot
        @slot('title')
            Edit Project
        @endslot
    @endcomponent

    <!-- sample modal content -->
    <div id="monitoringProjectDetailModal" class="modal fade" tabindex="-1" aria-labelledby="monitoringProjectDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="monitoringProjectDetailModalLabel">Form Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('monitoring-project-detail/store') }}"
                        id="monitoringProjectDetailForm" name="monitoringProjectDetailForm">
                        <div class="modal-body">
                            @csrf
                            <input id="monitoring_project_detail_id" type="hidden" class="form-control" name="id">
                            <input type="hidden" class="form-control monitoring_project_id" name="monitoring_project_id"
                                value="{{ $id }}">
                            <div class="mb-3 validate">
                                <label for="name" class="form-label">Activity<span style="color:red;">*</span></label>
                                <input id="activity" type="text" class="form-control" name="activity">
                            </div>
                            <div class="mb-3 validate">
                                <label for="monitoring_project_description" class="form-label">Description</label>
                                <textarea rows="3" id="monitoring_project_description" name="description" class="form-control"></textarea>
                            </div>
                            <div class="mb-3 validate">
                                <label for="percentage" class="form-label">Percentage(%)<span
                                        style="color:red;">*</span></label>
                                <input id="percentage" type="number" min="1" class="form-control" name="percentage">
                            </div>
                            <div class="mb-3 validate">
                                <label for="plan_date" class="form-label">Plan Date<span style="color:red;">*</span></label>
                                <input id="plan_date" name="plan_date" class="form-control date" type="date" />
                            </div>
                            <div class="mb-3 validate">
                                <label for="user_id" class="form-label">PIC<span style="color:red;">*</span></label><br>
                                <select multiple id="user_id" type="text" class="form-select user_id"
                                    name="user_id[]"></select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark waves-effect waves-light btn-sm"
                                id="saveMonitoringProjectDetailBtn" name="saveMonitoringProjectDetailBtn">Save</button>
                            <button type="button" class="btn btn-secondary waves-effect btn-sm"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
                <h4 class="card-title">Detail Follow Up</h4>
            </div> --}}
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div>
                                <form method="POST" action="{{ route('monitoring-project/create') }}"
                                    id="monitoringProjectForm" name="monitoringProjectForm">
                                    @csrf
                                    <input type="hidden" class="form-control monitoring_project_id" name="id"
                                        value="{{ $id }}">
                                    <div class="row mb-4">
                                        <label for="address" class="col-sm-3 col-form-label">Status<span
                                                style="color:red;">*</span></label>
                                        <div class="col-sm-9 validate">
                                            <select id="project_status" type="text" class="form-control project_status"
                                                name="project_status">
                                                <option></option>
                                                <option value="1">Internal</option>
                                                <option value="2">Eksternal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="monitoring_client_id" class="col-sm-3 col-form-label">Client Name<span
                                                style="color:red;">*</span></label>
                                        <div class="col-sm-9 validate">
                                            <select type="text" class="form-control" id="monitoring_client_id"
                                                name="monitoring_client_id">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="name" class="col-sm-3 col-form-label">Project Name<span
                                                style="color:red;">*</span></label>
                                        <div class="col-sm-9 validate">
                                            <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="description" class="col-sm-3 col-form-label">Project
                                            Description</label>
                                        <div class="col-sm-9 validate">
                                            <textarea rows="5" id="description" name="description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="start_date" class="col-sm-3 col-form-label">Start Date<span
                                                style="color:red;">*</span></label>
                                        <div class="col-sm-9 validate">
                                            <input id="start_date" type="text" class="form-control date"
                                                style="background-color: #fff" name="start_date">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="end_date" class="col-sm-3 col-form-label">End Date<span
                                                style="color:red;">*</span></label>
                                        <div class="col-sm-9 validate">
                                            <input id="end_date" type="text" class="form-control date"
                                                style="background-color: #fff" name="end_date">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="note" class="col-sm-3 col-form-label">Note</label>
                                        <div class="col-sm-9 validate">
                                            <textarea rows="3" id="note" name="note" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group row ml-2 mr-2">
                        <div class="table-responsive mt-3">
                            <button type="button" class="btn btn-dark waves-effect waves-light btn-sm mb-3"
                                data-bs-toggle="modal" data-bs-target="#monitoringProjectDetailModal" id="activityBtn"
                                name="activityBtn"><i class="mdi mdi-plus-circle"></i> Add Activity</button>
                            <table class="table table-bordered table-hover nowrap" id="monitoringProjectDetailTable"
                                style="width: 100%;">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Activity</th>
                                        <th>Description</th>
                                        <th>Percentage</th>
                                        <th>Date</th>
                                        <th>PIC</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align: right;">Total</td>
                                        <td colspan="4">
                                            <h5 id="total">0%</h5>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-dark waves-effect waves-light btn-sm"
                        id="saveMonitoringProjectBtn" name="saveMonitoringProjectBtn">Save</button>
                    <a href="{{ route('monitoring-project') }}" class="btn btn-secondary waves-effect btn-sm">Cancel</a>
                </div>
            </div>
        </div> <!-- end col -->

    </div>
    <!-- end row -->
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

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            var monitoring_project_id = $('.monitoring_project_id').val();
            show(monitoring_project_id)
            totalActicity(monitoring_project_id)
            var request = {
                start: 0,
                length: -1,
                monitoring_project_id: monitoring_project_id,
            };
            var monitoringProjectDetailTable = $('#monitoringProjectDetailTable').DataTable({
                "language": {
                    "paginate": {
                        "next": '<i class="fas fa-arrow-right"></i>',
                        "previous": '<i class="fas fa-arrow-left"></i>'
                    }
                },
                "aaSorting": [],
                "autoWidth": false,
                "ordering": false,
                "searching": false,
                "lengthChange": false,
                "info": false,
                "paging": false,
                "responsive": true,
                "serverSide": true,
                "lengthMenu": [
                    [10, 15, 25, 50, -1],
                    [10, 15, 25, 50, "All"]
                ],
                "ajax": {
                    "url": "{{ route('monitoring-project-detail/getData') }}",
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
                        "data": "activity",
                        "width": '20%',
                        "defaultContent": "-",
                        "render": function(data, type, row) {
                            let activity = (data) ? data : '-'
                            return "<div class='text-wrap'>" + activity + "</div>";
                        }
                    },
                    {
                        "data": "description",
                        "width": '20%',
                        "defaultContent": "-",
                        "render": function(data, type, row) {
                            let description = (data) ? data : '-'
                            return "<div class='text-wrap'>" + description + "</div>";
                        }
                    },
                    {
                        "data": "percentage",
                        "width": '10%',
                        "defaultContent": "-",
                        "render": function(data, type, row) {
                            return "<div class='text-wrap'>" + data + "%</div>";
                        }
                    },
                    {
                        "data": "id",
                        "width": '20%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let plan_date = moment(row.plan_date).format("DD MMMM YYYY");
                            let detail = '<b>Plan Date</b><br>' + plan_date + '<br>';
                            if (row.monitoring_project_detail_dates) {
                                $.each(row.monitoring_project_detail_dates, function(key, value) {
                                    let no = key + 1;
                                    let revise_date = moment(value.revise_date).format(
                                        "DD MMMM YYYY");
                                    detail += '<b>Revise ' + no + ' Plan Date</b><br>' +
                                        revise_date + '<br>' + value.revise_comment +
                                        '<br>';
                                });
                            }
                            return "<div class='text-wrap'>" + detail + "</div>";
                        },
                    },
                    {
                        "data": "monitoring_project_detail_pic",
                        "width": '15%',
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            let pic = "";
                            $.each(data, function(key, value) {
                                let no = key + 1;
                                pic += no + '. ' + value.user.name + '<br>';
                            });
                            return "<div class='text-wrap'>" + pic + "</div>";
                        }
                    },
                    {
                        "data": "id",
                        "width": '10%',
                        render: function(data, type, row, meta) {
                            let btnEdit = "";
                            let btnDelete = "";
                            let btnMoveUP = "";
                            let btnMoveDown = "";
                            if (meta.row > 0) {
                                btnMoveUP += '<button name="btnMoveUP" data-id="' + data +
                                    '" data-order="' + row.order +
                                    '" data-monitoring_project_id="' + row.monitoring_project_id +
                                    '" data-type="Up" type="button" class="btnMove btn btn-dark btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Up"><i class="fa fa-arrow-up"></i></button>';
                            }
                            if ((meta.row + 1) < meta.settings.json.data.length) {
                                btnMoveDown += '<button name="btnMoveDown" data-id="' + data +
                                    '" data-order="' + row.order +
                                    '" data-monitoring_project_id="' + row.monitoring_project_id +
                                    '" data-type="Down" type="button" class="btnMove btn btn-dark btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Down"><i class="fa fa-arrow-down"></i></button>';
                            }

                            btnEdit += '<button name="btnEdit" data-id="' + data +
                                '" type="button" class="btn btn-warning btn-sm btnEdit m-1" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                            btnDelete += '<button name="btnDelete" data-id="' + data +
                                '" type="button" class="btn btn-danger btn-sm btnDelete m-1" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>';
                            return btnMoveUP + btnMoveDown + btnEdit + btnDelete;
                        },
                    },
                ]
            });

            function reloadTable() {
                monitoringProjectDetailTable.ajax.reload(null, false); //reload datatable ajax
            }
            $("#project_status").select2({
                theme: 'bootstrap-5',
                placeholder: "Choose Status"
            });
            $("#project_type").select2({
                theme: 'bootstrap-5',
                placeholder: "Choose Type"
            });
            $("#monitoring_client_id").select2({
                theme: 'bootstrap-5',
                placeholder: "Choose Client",
                ajax: {
                    url: "{{ route('monitoring-client/getData') }}",
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
                            length: -1
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
                                    text: this.name
                                });
                            })
                        }
                        return result;
                    },
                    cache: false
                },
            });
            $(".user_id").select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#monitoringProjectDetailModal'),
                placeholder: "Choose PIC",
                ajax: {
                    url: "{{ route('user/getData') }}",
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
                            length: -1
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
                                    text: this.name
                                });
                            })
                        }
                        return result;
                    },
                    cache: false
                },
            });
            $('.date').flatpickr({
                dateFormat: "Y-m-d"
            });
            $("#revise").select2({
                placeholder: "Choose Revise"
            }).on("change", function(e) {
                if ($(this).val() == '1') {
                    $('#showReviseDate').show();
                    $("#revise_date").rules("add", {
                        required: true,
                    });
                    $('#revise_date').val('');

                    $('#showReviseComment').show();
                    $("#revise_comment").rules("add", {
                        required: true,
                    });
                    $('#revise_comment').val('');
                } else {
                    $('#showReviseDate').hide();
                    $("#revise_date").rules('remove', 'required')
                    $('#revise_date').val('');

                    $('#showReviseComment').hide();
                    $("#revise_comment").rules('remove', 'required')
                    $('#revise_comment').val('');
                }
            });
            $('#monitoringProjectDetailTable').on("click", ".btnMove", function() {
                let id = $(this).attr('data-id');
                let order = $(this).attr('data-order');
                let monitoring_project_id = $(this).attr('data-monitoring_project_id');
                let type = $(this).attr('data-type');
                Swal.fire({
                    title: 'Confirmation',
                    text: "You will move this data. Are you sure you want to continue?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "Yes, I'm sure",
                    cancelButtonText: 'No'
                }).then(function(result) {
                    if (result.value) {
                        let url = "{{ route('monitoring-project-detail/move') }}";
                        let data = {
                            id: id,
                            order: order,
                            monitoring_project_id: monitoring_project_id,
                            type: type,
                        };
                        $.ajax({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    'content'),
                            },
                            url: url,
                            type: "POST",
                            data: data,
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
            $('#monitoringProjectDetailTable').on("click", ".btnEdit", function() {
                $('#monitoringProjectDetailModal').modal('show');
                isUpdate = true;
                var id = $(this).attr('data-id');
                var url = "{{ route('monitoring-project-detail/show', ['id' => ':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('#user_id').val("").trigger('change');
                        $('#activity').val(response.data.activity);
                        $('#monitoring_project_description').val(response.data.description);
                        $('#percentage').val(response.data.percentage);
                        $('#plan_date').val(response.data.plan_date);
                        $.each(response.data.monitoring_project_detail_pic, function(key,
                            value) {
                            let pic = (value.user) ? new Option(value.user.name, value
                                .user.id, true, true) : null;
                            $('#user_id').append(pic).trigger('change');
                        });
                        $('#monitoring_project_detail_id').val(response.data.id);
                        $("#divRevise").children().remove();
                        if (response.data.monitoring_project_detail_dates) {
                            let divRevise = '';

                            $.each(response.data.monitoring_project_detail_dates, function(key,
                                value) {
                                let no = key + 1;
                                divRevise += '<div class="form-group row">' +
                                    '<label class="col-md-3 form-control-label text-md-left">Revise ' +
                                    no +
                                    ' Plan Date<span style="color:red;">*</span></label>' +
                                    '<div class="col-md-9">' +
                                    '<input disabled type="text" class="form-control" value="' +
                                    value.revise_date + '">' +
                                    '</div>' +
                                    '</div>';
                                divRevise += '<div class="form-group row">' +
                                    '<label class="col-md-3 form-control-label text-md-left"></label>' +
                                    '<div class="col-md-9">' +
                                    '<textarea disabled rows="3" class="form-control">' +
                                    value.revise_comment + '</textarea>' +
                                    '</div>' +
                                    '</div>';
                            });
                            $('#divRevise').append(divRevise);
                        }
                        $('#showRevise').show();

                        $('#plan_date').prop('readonly', true);
                        let plan_date = document.getElementById("plan_date");
                        plan_date.style.backgroundColor = "#e9ecef";
                        plan_date.classList.remove("date");
                        $("#revise").rules("add", {
                            required: true,
                        });
                        $('#revise').val('').trigger('change');

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
            $('#monitoringProjectDetailTable').on("click", ".btnDelete", function() {
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
                        var url =
                            "{{ route('monitoring-project-detail/delete', ['id' => ':id']) }}";
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
                                totalActicity(monitoring_project_id);
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
            $('#saveMonitoringProjectBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#monitoringProjectForm").valid();
                if (isValid) {
                    let url = "{{ route('monitoring-project/edit', ['id' => ':id']) }}";
                    url = url.replace(':id', monitoring_project_id);
                    $('#saveMonitoringProjectBtn').text('Save...');
                    $('#saveMonitoringProjectBtn').attr('disabled', true);
                    var formData = new FormData($('#monitoringProjectForm')[0]);
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
                            $('#saveMonitoringProjectBtn').text('Save');
                            $('#saveMonitoringProjectBtn').attr('disabled', false);
                            (data.status) ? window.location.href =
                                "{{ route('monitoring-project') }}": "";
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#saveMonitoringProjectBtn').text('Save');
                            $('#saveMonitoringProjectBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#saveMonitoringProjectDetailBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#monitoringProjectDetailForm").valid();
                if (isValid) {
                    if (!isUpdate) {
                        var url = "{{ route('monitoring-project-detail/store') }}";
                    } else {
                        var url = "{{ route('monitoring-project-detail/update') }}";
                    }
                    $('#saveMonitoringProjectDetailBtn').text('Save...');
                    $('#saveMonitoringProjectDetailBtn').attr('disabled', true);
                    var formData = new FormData($('#monitoringProjectDetailForm')[0]);
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
                            $('#saveMonitoringProjectDetailBtn').text('Save');
                            $('#saveMonitoringProjectDetailBtn').attr('disabled', false);
                            reloadTable();
                            totalActicity(monitoring_project_id);
                            $('#monitoringProjectDetailModal').modal('hide');
                        },
                        error: function(data) {
                            Swal.fire(
                                'Error',
                                'A system error has occurred. please try again later.',
                                'error'
                            )
                            $('#saveMonitoringProjectDetailBtn').text('Save');
                            $('#saveMonitoringProjectDetailBtn').attr('disabled', false);
                        }
                    });
                }
            });
            $('#monitoringProjectForm').validate({
                rules: {
                    project_status: {
                        required: true,
                    },
                    project_type: {
                        required: true,
                    },
                    monitoring_client_id: {
                        required: true,
                    },
                    name: {
                        required: true,
                    },
                    start_date: {
                        required: true,
                    },
                    end_date: {
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
            $('#monitoringProjectDetailForm').validate({
                rules: {
                    activity: {
                        required: true,
                    },
                    percentage: {
                        required: true,
                    },
                    plan_date: {
                        required: true,
                    },
                    "user_id[]": {
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
            $('#activityBtn').on('click', function() {
                $("#divRevise").children().remove();
                $('#activity').val("");
                $('#monitoring_project_description').val("");
                $('#percentage').val("");
                $('#plan_date').prop('readonly', false);
                let plan_date = document.getElementById("plan_date");
                plan_date.style.backgroundColor = "#FFF";
                plan_date.classList.add("date");
                $('#plan_date').val("");
                $('#user_id').val("").trigger('change');
                $('.date').flatpickr({
                    dateFormat: "Y-m-d"
                });
                $('#showRevise').hide();
                $('#revise').val('').trigger('change');
                isUpdate = false;
            });

            function show(monitoring_project_id) {
                let url = "{{ route('monitoring-project/show', ['id' => ':id']) }}";
                url = url.replace(':id', monitoring_project_id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('#project_status').val(response.data.project_status).trigger('change');
                        $('#project_type').val(response.data.project_type).trigger('change');
                        let monitoring_client_id = (response.data.monitoring_client) ? new Option(
                            response.data.monitoring_client.name, response.data.monitoring_client
                            .id, true, true) : null;
                        $('#monitoring_client_id').append(monitoring_client_id).trigger('change');
                        $('#name').val(response.data.name);
                        $('#description').val(response.data.description);
                        $('#start_date').val(response.data.start_date);
                        $('#end_date').val(response.data.end_date);
                        $('#note').val(response.data.note);
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    },
                });
            }

            function totalActicity(monitoring_project_id) {
                var url = "{{ route('monitoring-project/total/activity', ['id' => ':id']) }}";
                url = url.replace(':id', monitoring_project_id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        $('#total').text(response.data + '%')
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    },
                });
            }

        });
    </script>
@endpush

@extends('layouts.master')

@section('title') @lang('Follow Up') @endsection

@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ URL::asset('/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Sales @endslot
@slot('title') Follow Up @endslot
@endcomponent

<div id="exportReportModal" class="modal fade" tabindex="-1" aria-labelledby="exportReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportReportModalLabel">Form Follow Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('follow-up-client/export/report') }}" id="exportReportForm" name="exportReportForm">
                @csrf
                @method('POST')
                <div class="form-group row">
                    <label for="reportSalesUserID" class="col-md-12 col-form-label text-md-left">Sales<span style="color:red;">*</span></label>
                    <div class="col-md-12 validate">
                        <select id="reportSalesUserID" type="text" class="form-control user_id" name="user_id">
                        </select>
                    </div>
                </div>
                <div class="form-group row mt--3">
                    <label for="reportSalesType" class="col-md-12 col-form-label text-md-left">Type<span style="color:red;">*</span></label>
                    <div class="col-md-12 validate">
                        <select id="reportSalesType" type="text" class="form-control type" name="type">
                            <option></option>
                            <option value="1">Follow Up</option>
                            <option value="2">Prospect</option>
                            <option value="3">Achievement</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mt--3">
                    <label for="reportSalesPeriod" class="col-md-12 col-form-label text-md-left">Period<span style="color:red;">*</span></label>
                    <div class="col-md-12 validate">
                        <select id="reportSalesPeriod" type="text" class="form-control period" name="period">
                            <option></option>
                            <option value="1">Daily</option>
                            <option value="2">Monthly</option>
                            <option value="3">Range</option>
                        </select>
                    </div>
                </div>
                <div id="showReportSalesDate" class="form-group ml--3 mt--3" style="display: none;">
                    <label for="reportSalesDate" class="col-md-12 col-form-label text-md-left">Date<span style="color:red;">*</span></label>
                    <div class="col-md-12 validate">
                        <input type="text" name="date" id="reportSalesDate" class="form-control date" style="background-color: #fff;">
                    </div>
                </div>
                <div id="showReportSalesRange" class="ml--3" style="display: none;">
                    <div class="form-group mt--3">
                        <label for="reportSalesStartDate" class="col-md-12 col-form-label text-md-left">Start Date<span style="color:red;">*</span></label>
                        <div class="col-md-12 validate">
                            <input type="text" name="start_date" id="reportSalesStartDate" class="form-control start_date" style="background-color: #fff;">
                        </div>
                    </div>
                    <div class="form-group mt--3">
                        <label for="reportSalesEndDate" class="col-md-12 col-form-label text-md-left">End Date<span style="color:red;">*</span></label>
                        <div class="col-md-12 validate">
                            <input type="text" name="end_date" id="reportSalesEndDate" class="form-control end_date" style="background-color: #fff;">
                        </div>
                    </div>
                </div>
                <div id="showReportSalesMonth" class="form-group ml--3 mt--3" style="display: none;">
                    <label for="reportSalesMonth" class="col-md-12 col-form-label text-md-left">Month<span style="color:red;">*</span></label>
                    <div class="col-md-12 validate">
                        <input type="text" name="month" id="reportSalesMonth" class="form-control month" style="background-color: #fff;">
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark waves-effect waves-light btn-sm" id="followUpBtn" name="followUpBtn">Save</button>
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <a type="button" class="btn btn-dark waves-effect waves-light btn-sm" data-bs-toggle="modal" data-bs-target="#exportReportModal" id="btnExportReport"><i class="fas fa-file-export"></i> Export Report</a>
            </div> --}}
            <div class="card-body">
                <table href="javascript:void(0)" id="clientTable" class="table table-striped table-bordered dt-responsive  nowrap w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Note</th>
                            <th>Sales</th>
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
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

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
            "url": "{{ route('follow-up-client/getData') }}",
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
                let regency = (row.client.regency) ? row.client.regency.name : '-';
                let address = (row.client.address) ? row.client.address : '-';
                let client = '<b>' + row.client.name + '</b><br>' + regency + '<br>' + address;
                return "<div class='text-wrap'>" + client + "</div>";
                },
            },
            {
                "data": "date",
                "width": '15%',
                "defaultContent": "-",
                render: function(data, type, row) {
                let date = moment(data).format("DD MMMM YYYY");
                return "<div class='text-wrap'>" + date + "</div>";
                },
            },
            {
                "data": "type",
                "width": '10%',
                "defaultContent": "-",
                "render": function(data, type, row) {
                let typeFollowUp = ''
                if (data == '1') {
                    typeFollowUp = 'Call';
                } else if (data == '2') {
                    typeFollowUp = 'Meeting';
                } else if (data == '3') {
                    typeFollowUp = 'Proposal';
                } else if (data == '4') {
                    typeFollowUp = 'Email';
                }
                return "<div class='text-wrap'>" + typeFollowUp + "</div>";
                }
            },
            {
                "data": "note",
                "width": '25%',
                "defaultContent": "-",
                "render": function(data, type, row) {
                let note = (data) ? data : '-';
                return "<div class='text-wrap'>" + note + "</div>";
                }
            },
            {
                "data": "created_by.name",
                "width": '15%',
                "defaultContent": "-",
                "render": function(data, type, row) {
                let sales = (data) ? data : '-';
                return "<div class='text-wrap'>" + sales + "</div>";
                }
            },
            ]
        });

        function reloadTable() {
            clientTable.ajax.reload(null, false); //reload datatable ajax
        }
        $("#reportSalesType").select2({
            placeholder: "Choose Type"
        });
        $("#reportSalesPeriod").select2({
            placeholder: "Choose Period"
        }).on("change", function(e) {
            if ($(this).val() != null) {
            if ($(this).val() == '1') {
                $('#showReportSalesDate').show();
                $("#reportSalesDate").rules("add", {
                required: true,
                });
                $('#reportSalesDate').val('');

                $('#showReportSalesMonth').hide();
                $("#reportSalesMonth").rules('remove', 'required')
                $('#reportSalesMonth').val('');

                $('#showReportSalesRange').hide();
                $("#reportSalesStartDate").rules('remove', 'required')
                $('#reportSalesStartDate').val('');
                $("#reportSalesEndDate").rules('remove', 'required')
                $('#reportSalesEndDate').val('');
            } else if ($(this).val() == '2') {
                $('#showReportSalesMonth').show();
                $("#reportSalesMonth").rules("add", {
                required: true,
                });
                $('#reportSalesMonth').val('');

                $('#showReportSalesDate').hide();
                $("#reportSalesDate").rules('remove', 'required');
                $('#reportSalesDate').val('');
                $('#showReportSalesRange').hide();
                $("#reportSalesStartDate").rules('remove', 'required')
                $('#reportSalesStartDate').val('');
                $("#reportSalesEndDate").rules('remove', 'required')
                $('#reportSalesEndDate').val('');
            } else if ($(this).val() == '3') {
                $('#showReportSalesRange').show();
                $("#reportSalesStartDate").rules("add", {
                required: true,
                });
                $("#reportSalesEndDate").rules("add", {
                required: true,
                });
                $('#reportSalesEndDate').val('');

                $('#showReportSalesDate').hide();
                $("#reportSalesDate").rules('remove', 'required')
                $('#reportSalesDate').val('');

                $('#showReportSalesMonth').hide();
                $("#reportSalesMonth").rules('remove', 'required')
                $('#reportSalesMonth').val('');
            }
            }
        });
        $('#reportSalesDate').flatpickr({
            dateFormat: "Y-m-d",
        });
        $('#reportSalesMonth').flatpickr({
            plugins: [
            new monthSelectPlugin({
                shorthand: true, //defaults to false
                dateFormat: "Y-m", //defaults to "F Y"
                altFormat: "Y-m", //defaults to "F Y"
                theme: "light" // defaults to "light"
            })
            ]
        });
        $('#reportSalesStartDate').flatpickr({
            dateFormat: "Y-m-d",
            onChange: function() {
            $('#reportSalesEndDate').val('');
            let start_date = new Date($('#reportSalesStartDate').val());
            let min_date = new Date().setFullYear(start_date.getFullYear(), start_date.getMonth(), start_date.getDate() + 1);
            $('#reportSalesEndDate').flatpickr({
                minDate: min_date,
                dateFormat: "Y-m-d"
            });
            }
        });
        $('#reportSalesEndDate').flatpickr({
            dateFormat: "Y-m-d"
        });

        $(".user_id").select2({
            placeholder: "Choose User",
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
                length: -1,
                department: "Sales"
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
        $("#filterType").select2({
            placeholder: "Choose Type"
        });
        $('#filterDate').flatpickr({
            dateFormat: "Y-m-d"
        });
        $('#saveExportSalesBtn').click(function(e) {
            // $('#exportReportModal').modal('hide');
        });
        $('#btnExportReport').on('click', function() {
            $("#reportSalesUserID").val('').trigger('change');
            $("#reportSalesType").val('').trigger('change');
            $("#reportSalesPeriod").val('').trigger('change');
            $("#reportSalesDate").val('');
            $("#reportSalesMonth").val('');
            reloadTable();
        })
        $('#exportReportForm').validate({
            rules: {
            user_id: {
                required: true,
            },
            type: {
                required: true,
            },
            period: {
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
        $('#btnApply').click(function() {
            request.user_id = $("#filterUserId").val();
            request.type = $("#filterType").val();
            request.date = $("#filterDate").val();
            reloadTable();
        });
        $('#btnReset').on('click', function() {
            request.user_id = "";
            request.type = "";
            request.date = "";
            $("#filterUserId").val('').trigger('change');
            $("#filterType").val('').trigger('change');
            $("#filterDate").val('')
            reloadTable();
        })
        });
    </script>
@endpush

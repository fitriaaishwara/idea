@extends('layouts.master')

@section('title') @lang('translation.Dashboard') @endsection

@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ URL::asset('/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- plugin css -->
<link href="{{ URL::asset('/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboard @endslot
        @slot('title') Dashboard @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100 card bg-dark border-dark text-light">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="mb-3 lh-1 d-block text-light">Client</span>
                            <h4 class="mb-3 text-light">
                                <span class="counter-value" data-target="{{ $client }}">0</span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100 card bg-dark border-dark text-light">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="mb-3 lh-1 d-block text-light">Client Win</span>
                            <h4 class="mb-3 text-light">
                                <span class="counter-value" data-target="{{ $clientWin }}">0</span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100 card bg-dark border-dark text-light">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="mb-3 lh-1 d-block text-light">Project Progress</span>
                            <h4 class="mb-3 text-light">
                                <span class="counter-value" data-target="{{ $projectProgress}}">0</span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-h-100 card bg-dark border-dark text-light">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <span class="mb-3 lh-1 d-block text-light">Project Finish</span>
                            <h4 class="mb-3 text-light">
                                <span class="counter-value" data-target="{{ $projectFinish }}">0</span>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row-->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="monitoringClientsTable" class="table table-striped table-bordered dt-responsive  nowrap w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Client Name</th>
                                <th>Project Name</th>
                                <th>Next Activity</th>
                                <th>Progress</th>
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
        <!-- apexcharts -->
        <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- Plugins js-->
        <script src="{{ URL::asset('/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>

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

        <!-- dashboard init -->
        <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            var user_id = "{{ Auth::user()->id }}";
            let request = {
                start: 0,
                length: 10
            };
            var monitoringClientsTable = $('#monitoringClientsTable').DataTable({
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
                "url": "{{ route('monitoring-project/getData') }}",
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
                    "data": "monitoring_client.name",
                    "width": '20%',
                    "defaultContent": "-",
                    render: function(data, type, row) {
                    return "<div class='text-wrap'>" + data + "</div>";
                    },
                },
                {
                    "data": "id",
                    "width": '20%',
                    "defaultContent": "-",
                    render: function(data, type, row) {
                    let name = (row.name) ? row.name : '-';
                    let project_status = '-';
                    if (row.project_status == '1') {
                        project_status = 'Internal';
                    } else if (row.project_status == '2') {
                        project_status = 'Eksternal';
                    }
                    let detail = '<b>Name</b><br>' + name + '<br><b>Status</b><br>' + project_status;
                    return "<div class='text-wrap'>" + detail + "</div>";
                    },
                },
                {
                    "data": "next_monitoring_project_detail",
                    "width": '20%',
                    "defaultContent": "-",
                    render: function(data, type, row) {
                    let activity = 'Project Finish';
                    if (data) {
                        activity = data.activity + '<br>' + moment(data.plan_date).format("DD MMMM YYYY")

                    }
                    activity += '<div class="avatar-group">';

                    $.each(data.monitoring_project_detail_pic, function(key, value) {
                        let avatar = (value.user.photo) ? '/storage/images/user/' + value.user.photo : '/assets/images/users/avatar.png';
                        activity += '<a href="#" data-toggle="tooltip" title="' + value.user.name + '">' +
                        '<img alt="Header Avatar" class="flex-shrink-0 me-3 rounded-circle" height="36" src="' + avatar + '">' +
                        '</a>';
                    });
                    activity += '</div>';
                    return "<div class='text-wrap'>" + activity + "</div>";
                    },
                },
                {
                    "data": "progress",
                    "width": '10%',
                    render: function(data, type, row) {
                    let progress = (data) ? data : 0;
                    let barProgress = '<div class="d-flex align-items-center">' +
                        '<span class="mr-2">' + progress + '%</span>' +
                        '<div>' +
                        '<div class="progress">' +
                        '<div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="' + progress + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + progress + '%;"></div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    return barProgress;
                    },
                },
                ]
            });
        });
    </script>
@endpush


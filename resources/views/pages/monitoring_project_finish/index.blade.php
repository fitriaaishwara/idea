@extends('layouts.master')

@section('title') @lang('Project Finish') @endsection

@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ URL::asset('/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Project @endslot
@slot('title') Project Finish @endslot
@endcomponent

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
                            <th>Meeting</th>
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
          "url": "{{ route('monitoring-project-finish/getData') }}",
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
            "data": "name",
            "width": '20%',
            "defaultContent": "-",
            render: function(data, type, row) {
              let name = (data) ? data : '-';
              return "<div class='text-wrap'>" + name + "</div>";
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
              return "<div class='text-wrap'>" + activity + "</div>";
            },
          },
          {
            "data": "progress",
            "width": '15%',
            render: function(data, type, row) {
              let progress = (data) ? data : 0;
              let barProgress = '<div class="d-flex align-items-center">' +
                '<span class="mr-2">' + progress + '%</span>' +
                '<div>' +
                '<div class="progress">' +
                '<div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="' + progress + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + progress + '%;"></div>' +
                '</div>' +
                '</div>' +
                '</div>';
              return barProgress;
            },
          },
          {
            "data": "meeting_count",
            "width": '10%',
            "defaultContent": "-",
            render: function(data, type, row) {
              let btnDetail = "";
              btnDetail += '<a href="/monitoring-project-finish/meeting/' + row.id + '" name="btnDetail" data-id="' + row.id + '" type="button" class="btn btn-dark btn-sm btnDetail" data-toggle="tooltip" data-placement="top" title="Total Meeting"><i class="fa fa-info-circle"></i> ' + data + ' Meeting</a>';
              return btnDetail;
            },
          },
          {
            "data": "id",
            "width": '10%',
            render: function(data, type, row) {

              let btnDetail = "";

              btnDetail += '<a href="/monitoring-project-finish/detail/' + data + '" name="btnDetail" type="button" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>';

              return btnDetail;
            },
          },
        ]
      });

      function reloadTable() {
        monitoringClientsTable.ajax.reload(null, false); //reload datatable ajax
      }
      $('.date').flatpickr({
        dateFormat: "Y-m-d"
      });

    });
  </script>
@endpush


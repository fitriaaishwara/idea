@extends('layouts.master')

@section('title') @lang('Meeting Project Finish') @endsection

@section('css')

<!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ URL::asset('/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Project Monitoring @endslot
@slot('title') Meeting Project Finish @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <input type="hidden" class="form-control monitoring_project_id" name="id" value="{{ $id }}">
            </div>
            <div class="card-body">
                <table id="monitoringProjectMeetingTable" class="table table-striped table-bordered dt-responsive  nowrap w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Agenda</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('monitoring-project-finish') }}" class="btn btn-dark waves-effect waves-light btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
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
      let monitoring_project_id = $('.monitoring_project_id').val();
      let request = {
        start: 0,
        length: -1,
        monitoring_project_id: monitoring_project_id
      };
      let monitoringProjectMeetingTable = $('#monitoringProjectMeetingTable').DataTable({
        "language": {
          "paginate": {
            "next": '<i class="fas fa-arrow-right"></i>',
            "previous": '<i class="fas fa-arrow-left"></i>'
          }
        },
        "aaSorting": [],
        "ordering": false,
        "searching": false,
        "lengthChange": false,
        "info": false,
        "paging": true,
        "responsive": true,
        "serverSide": true,
        "lengthMenu": [
          [5, 10, 15, 25, 50, -1],
          [5, 10, 15, 25, 50, "All"]
        ],
        "ajax": {
          "url": "{{ route('monitoring-project-meeting/getData') }}",
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
            "data": "agenda",
            "width": '35%',
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
              let date = moment(data).locale('id').format("DD MMMM YYYY");
              return date + '<br>' + row.start_time + '-' + row.end_time;
            }
          },
          {
            "data": "location",
            "width": '25%',
            "defaultContent": "-",
            render: function(data, type, row) {
              return "<div class='text-wrap'>" + data + "</div>";
            },
          },
          {
            "data": "id",
            "width": '20%',
            render: function(data, type, row) {
              let urlDetail = "{{ route('monitoring-project-meeting/detail', ['id' => ':id']) }}";
              urlDetail = urlDetail.replace(':id', row.id);
              let urlDownload = "{{ route('monitoring-project-meeting/download', ['id' => ':id']) }}";
              urlDownload = urlDownload.replace(':id', row.id);

              let btnDetail = '<a href="' + urlDetail + '" name="btnDetail" type="button" class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>';
              let btnDownload = '<a target="_blank" href="' + urlDownload + '" name="btnDownload" data-id="' + data + '" type="button" class="btn btn-success btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download"></i></a>';

              return btnDetail+btnDownload;
            },
          },
        ]
      });
    });
  </script>
@endpush


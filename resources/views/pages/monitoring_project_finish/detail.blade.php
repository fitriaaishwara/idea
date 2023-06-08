@extends('layouts.master')

@section('title') @lang('Detail Project Finish') @endsection

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
@slot('title') Detail Project Finish @endslot
@endcomponent

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
                            <input type="hidden" class="form-control monitoring_project_id" name="id" value="{{ $id }}">
                            <div class="row mb-4">
                                <label for="address" class="col-sm-3 col-form-label">Status<span style="color:red;">*</span></label>
                                <div class="col-sm-9 validate">
                                    <select id="project_status" type="text" class="form-control project_status" name="project_status" disabled>
                                        <option></option>
                                        <option value="1">Internal</option>
                                        <option value="2">Eksternal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="monitoring_client_id" class="col-sm-3 col-form-label">Client Name<span style="color:red;">*</span></label>
                                <div class="col-sm-9 validate">
                                    <select type="text" class="form-control" id="monitoring_client_id" name="monitoring_client_id" disabled>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="name" class="col-sm-3 col-form-label">Project Name<span style="color:red;">*</span></label>
                                <div class="col-sm-9 validate">
                                    <input type="text" class="form-control" id="name" name="name" disabled>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="description" class="col-sm-3 col-form-label">Project Description</label>
                                <div class="col-sm-9 validate">
                                    <textarea rows="5" id="description" name="description" class="form-control" disabled></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for="start_date" class="col-sm-3 col-form-label">Start Date<span style="color:red;">*</span></label>
                                <div class="col-sm-9 validate">
                                    <input id="start_date" type="text" class="form-control date" style="background-color: #fff" name="start_date" disabled>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for="end_date" class="col-sm-3 col-form-label">End Date<span style="color:red;">*</span></label>
                                <div class="col-sm-9 validate">
                                    <input id="end_date" type="text" class="form-control date" style="background-color: #fff" name="end_date" disabled>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="note" class="col-sm-3 col-form-label">Note</label>
                                <div class="col-sm-9 validate">
                                    <textarea rows="3" id="note" name="note" class="form-control" disabled></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group row ml-2 mr-2">
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover nowrap" id="monitoringProjectDetailTable" style="width: 100%;">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Activity</th>
                                    <th>Description</th>
                                    <th>Percentage</th>
                                    <th>Plan Date</th>
                                    <th>PIC</th>
                                    <th>Status</th>
                                    <th class="none">Actual Date</th>
                                    <th class="none">Comment</th>
                                    <th class="none">Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{route('monitoring-project-finish')}}" class="btn btn-dark waves-effect waves-light btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
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
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

@endsection
@push('js')
<script type="text/javascript">
  $(function(){
    var monitoring_project_id  = $('.monitoring_project_id').val();
    show(monitoring_project_id)
    var request = {
      start:0,
      length:-1,
      monitoring_project_id:monitoring_project_id,
    };
    var monitoringProjectDetailTable = $('#monitoringProjectDetailTable').DataTable( {
        "language": {
          "paginate": {
              "next":       '<i class="fas fa-arrow-right"></i>',
              "previous":   '<i class="fas fa-arrow-left"></i>'
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
            "url": "{{route('monitoring-project-detail/getData')}}",
            "type": "POST",
            "headers":
              {
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
        "columns": [
            {
              "data": null,
              "width" : '5%',
              render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            {
              "data": "activity",
              "width" : '15%',
              "defaultContent": "-",
              "render": function(data, type, row){
                let activity = (data)?data:'-'
                return "<div class='text-wrap'>" + activity + "</div>";
              }
            },
            {
              "data": "description",
              "width" : '25%',
              "defaultContent": "-",
              "render": function(data, type, row){
                let description = (data)?data:'-'
                return "<div class='text-wrap'>" + description + "</div>";
              }
            },
            {
              "data": "percentage",
              "width" : '10%',
              "defaultContent": "-",
              "render": function(data, type, row){
                return "<div class='text-wrap'>" + data + "%</div>";
              }
            },
            {
              "data": "plan_date",
              "width" : '15%',
              "defaultContent": "-",
              render: function (data, type, row) {
                return moment(data).format("DD MMMM YYYY")
              },
            },
            {
              "data": "monitoring_project_detail_pic",
              "width" : '15%',
              "defaultContent": "-",
              render: function(data, type, row) {
                let pic = "";
                $.each(data, function(key, value) {
                  let no = key+1;
                  pic += no+'. '+value.user.name+'<br>';
                });
                return "<div class='text-wrap'>" + pic + "</div>";
              }
            },
            {
              "data": "is_done",
              "width" : '12%',
              "defaultContent": "-",
              "render": function(data, type, row){
                let is_done = (data)?'Done':'On Progress'
                return "<div class='text-wrap'>" + is_done + "</div>";
              }
            },
            {
              "data": "actual_date",
              "width" : '15%',
              "defaultContent": "-",
              render: function (data, type, row) {
                let actual_date = (data)?moment(data).format("DD MMMM YYYY"):'-'
                return "<div class='text-wrap'>" + actual_date + "</div>";
              },
            },
            {
              "data": "comment",
              "width" : '10%',
              "defaultContent": "-",
              "render": function(data, type, row){
                let comment = (data)?data:'-';
                return "<div class='text-wrap'>" + comment + "</div>";
              }
            },
            {
              "data": "attachment_id",
              "width" : '10%',
              "defaultContent": "-",
              "render": function(data, type, row){
                let urlDownload = "{{route('monitoring-project-detail/download',['id'=>':id'])}}";
                urlDownload = urlDownload.replace(':id',row.id);
                let btnDownload = '<a target="_blank" href="'+urlDownload+'" name="btnDownload" data-id="' + data + '" type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download"></i></a>';
                btnDownload = (data)?btnDownload:'-';
                return "<div class='text-wrap'>" + btnDownload + "</div>";
              }
            },
        ]
    });
    function show(monitoring_project_id) {
      let url = "{{route('monitoring-project-finish/show',['id'=>':id'])}}";
      url = url.replace(':id', monitoring_project_id);
      $.ajax({
        type: 'GET',
        url: url,
        success: function(response) {
          $('#project_status').val(response.data.project_status).trigger('change')
          var monitoring_client_id = (response.data.monitoring_client)?new Option(response.data.monitoring_client.name, response.data.monitoring_client.id, true, true):null;
          $('#monitoring_client_id').append(monitoring_client_id).trigger('change');
          $('#name').val(response.data.name);
          $('#description').val(response.data.description);
          $('#start_date').val(response.data.start_date);
          $('#end_date').val(response.data.end_date);
          $('#note').val(response.data.note);
        },
        error: function(){
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

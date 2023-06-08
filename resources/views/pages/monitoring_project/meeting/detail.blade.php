@extends('layouts.master')

@section('title') @lang('Detail Meeting Project') @endsection

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
@slot('title') Detail Meeting Project @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <h4 class="card-title">Detail Follow Up</h4>
            </div> --}}
            <!-- sample modal content -->
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-10">
                        <div>
                            <form method="POST" action="{{ route('monitoring-project-meeting/update') }}" id="meetingForm" name="meetingForm">
                                @csrf
                                <input type="hidden" class="form-control monitoring_project_meeting_id" name="id" value="{{ $id }}">
                                <div class="row mb-4">
                                    <label for="agenda" class="col-sm-3 col-form-label">Agenda<span style="color:red;">*</span></label>
                                    <div class="col-sm-9 validate">
                                        <input id="agenda" type="text" class="form-control" name="agenda" disabled>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="date" class="col-sm-3 col-form-label">Date<span style="color:red;">*</span></label>
                                    <div class="col-sm-9 validate">
                                        <input id="date" style="background-color: #fff" type="text" class="form-control" name="date" disabled>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="name" class="col-sm-3 col-form-label">Time<span style="color:red;">*</span></label>
                                    <div class="col-md-2 validate">
                                        <input placeholder="Start Time" id="start_time" style="background-color: #fff" type="text" class="form-control time" name="start_time" disabled>
                                    </div>
                                    <div class="col-md-2 validate">
                                        <input placeholder="End Time" id="end_time" style="background-color: #fff" type="text" class="form-control time" name="end_time" disabled>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="location" class="col-sm-3 col-form-label">Location<span style="color:red;">*</span></label>
                                    <div class="col-sm-9 validate">
                                        <textarea rows="5" id="location" name="location" class="form-control" disabled></textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="attendee" class="col-sm-3 col-form-label">Participant<span style="color:red;">*</span></label>
                                    <div class="col-sm-9 validate">
                                        <div class="table-responsive mt-3">
                                            <table class="table table-sm table-bordered table-hover nowrap" id="meetingParticipantTable" style="width: 100%;">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Role</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="note" class="col-sm-3 col-form-label">Note</label>
                                    <div class="col-sm-9 validate">
                                        <textarea rows="3" id="note" name="note" class="form-control" disabled></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="card-footer">
                <a href="{{ url('monitoring-project/meeting/' . $monitoring_project_id) }}" class="btn btn-dark waves-effect waves-light btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
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
    $(function() {
      let monitoring_project_meeting_id = $('.monitoring_project_meeting_id').val();
      show(monitoring_project_meeting_id)

      function show(monitoring_project_meeting_id) {
        let url = "{{ route('monitoring-project-meeting/show', ['id' => ':id']) }}";
        url = url.replace(':id', monitoring_project_meeting_id);
        $.ajax({
          type: 'GET',
          url: url,
          success: function(response) {
            $('#agenda').val(response.data.agenda);
            $('#date').val(response.data.date);
            $('#start_time').val(response.data.start_time);
            $('#end_time').val(response.data.end_time);
            $('#location').val(response.data.location);
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
    });
    $(function() {
      let monitoring_project_meeting_id = $('.monitoring_project_meeting_id').val();

      let request = {
        start: 0,
        length: -1,
        monitoring_project_meeting_id: monitoring_project_meeting_id
      };

      let meetingParticipantTable = $('#meetingParticipantTable').DataTable({
        "language": {
          "paginate": {
            "next": "<b> > </b>",
            "previous": "<b> < </b>"
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
          "url": "{{ route('monitoring-project-meeting-participant/getData') }}",
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
            "width": '50%',
            "defaultContent": "-"
          },
          {
            "data": "role",
            "width": '35%',
            "defaultContent": "-"
          },
        ]
      });
    });
  </script>
@endpush

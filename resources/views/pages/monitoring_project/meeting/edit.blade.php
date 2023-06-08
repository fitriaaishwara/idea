@extends('layouts.master')

@section('title') @lang('Edit Meeting Project') @endsection

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
@slot('title') Edit Meeting Project @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <h4 class="card-title">Detail Follow Up</h4>
            </div> --}}
            <!-- sample modal content -->
            <div id="meetingParticipantModal" class="modal fade" tabindex="-1" aria-labelledby="meetingParticipantModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="meetingParticipantModalLabel">Form Participant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('monitoring-project-meeting-participant/store') }}" id="meetingParticipantForm" name="meetingParticipantForm">
                            <div class="modal-body">
                                @csrf
                                <input id="monitoring_project_meeting_participant_id" type="hidden" class="form-control" name="id">
                                <input type="hidden" class="form-control monitoring_project_meeting_id" name="monitoring_project_meeting_id" value="{{ $id }}">
                                <div class="row mb-4">
                                    <label for="name" class="col-sm-3 col-form-label">Name<span style="color:red;">*</span></label>
                                    <div class="col-sm-9 validate">
                                        <input id="name" type="text" class="form-control" name="name">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="role" class="col-sm-3 col-form-label">Role<span style="color:red;">*</span></label>
                                    <div class="col-sm-9 validate">
                                        <input id="role" type="text" class="form-control" name="role">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark waves-effect waves-light" id="saveMeetingParticipantBtn" name="saveMeetingParticipantBtn">Save changes</button>
                                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal" >Close</button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
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
                                        <input id="agenda" type="text" class="form-control" name="agenda">
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="date" class="col-sm-3 col-form-label">Date<span style="color:red;">*</span></label>
                                    <div class="col-sm-9 validate">
                                        <input id="date" type="text" class="form-control" name="date">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="time" class="col-sm-3 col-form-label">Time<span style="color:red;">*</span></label>
                                    <div class="col-md-2 validate">
                                        <input placeholder="Start Time" id="start_time" type="text" class="form-control time" name="start_time">
                                    </div>
                                    <div class="col-md-2 validate">
                                        <input placeholder="End Time" id="end_time" type="text" class="form-control time" name="end_time">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="location" class="col-sm-3 col-form-label">Location<span style="color:red;">*</span></label>
                                    <div class="col-sm-9 validate">
                                        <textarea rows="3" id="location" name="location" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="attendee" class="col-sm-3 col-form-label">Participant<span style="color:red;">*</span></label>
                                    <div class="col-sm-9 validate">
                                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light btn-sm" data-bs-toggle="modal" data-bs-target="#meetingParticipantModal" id="meetingParticipantBtn" name="meetingParticipantBtn">Add Participant</a>
                                        <div class="table-responsive mt-3">
                                            <table class="table table-sm table-bordered table-hover nowrap" id="meetingParticipantTable" style="width: 100%;">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Role</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label for="mom" class="col-sm-3 col-form-label">MoM</label>
                                    <div class="col-sm-9 validate">
                                        <input id="mom" type="file" class="form-control" name="mom">
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
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-dark waves-effect waves-light btn-sm" id="saveBtn" name="saveBtn">Save</button>
                <a href="{{ url('monitoring-project/meeting/' . $monitoring_project_id) }}" class="btn btn-secondary waves-effect btn-sm">Cancel</a>
            </div>
        </div>
    </div> <!-- end col -->

</div>
<!-- end row -->
@endsection

@push('js')
<script type="text/javascript">
    $(function() {
      let monitoring_project_meeting_id = $('.monitoring_project_meeting_id').val();
      show(monitoring_project_meeting_id)
      $('#date').flatpickr({
        dateFormat: "Y-m-d"
      });
      $('.time').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
      });
      $('#saveBtn').click(function(e) {
        e.preventDefault();
        var isValid = $("#meetingForm").valid();
        if (isValid) {
          $('#saveBtn').text('Save...');
          $('#saveBtn').attr('disabled', true);
          var formData = new FormData($('#meetingForm')[0]);
          $.ajax({
            url: "{{ route('monitoring-project-meeting/update') }}",
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
              $('#saveBtn').text('Save');
              $('#saveBtn').attr('disabled', false);
              (data.status) ? window.location.href = "{{ url('monitoring-project/meeting/' . $monitoring_project_id) }}": "";
            },
            error: function(data) {
              Swal.fire(
                'Error',
                'A system error has occurred. please try again later.',
                'error'
              )
              $('#saveBtn').text('Save');
              $('#saveBtn').attr('disabled', false);
            }
          });
        }
      });
      $('#meetingForm').validate({
        rules: {
          agenda: {
            required: true,
          },
          date: {
            required: true,
          },
          start_time: {
            required: true,
          },
          end_time: {
            required: true,
          },
          location: {
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
          {
            "data": "id",
            "width": '10%',
            render: function(data, type, row) {
              var btnEdit = "";
              var btnDelete = "";
              btnEdit += '<button name="btnEdit" data-id="' + data + '" type="button" class="btnEdit btn btn-warning btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
              btnDelete += '<button name="btnDelete" data-id="' + data + '" type="button" class="btnDelete btn btn-danger btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Delete Department"><i class="fa fa-trash"></i></button>';
              return btnEdit + btnDelete;
            },
          },
        ]
      });

      function reloadTableAttendee() {
        meetingParticipantTable.ajax.reload(null, false); //reload datatable ajax
      }

      $('#meetingParticipantTable').on("click", ".btnEdit", function() {
        $('#meetingParticipantModal').modal('show');
        isUpdate = true;
        var id = $(this).attr('data-id');
        var url = "{{ route('monitoring-project-meeting-participant/show', ['id' => ':id']) }}";
        url = url.replace(':id', id);
        $.ajax({
          type: 'GET',
          url: url,
          success: function(response) {
            $('#name').val(response.data.name);
            $('#role').val(response.data.role);
            $('#monitoring_project_meeting_participant_id').val(response.data.id);
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
      $('#meetingParticipantTable').on("click", ".btnDelete", function() {
        var id = $(this).attr('data-id');
        Swal.fire({
          title: 'Confirmation',
          text: "You will delete this attendee. Are you sure you want to continue?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: "Yes, I'm sure",
          cancelButtonText: 'No'
        }).then(function(result) {
          if (result.value) {
            var url = "{{ route('monitoring-project-meeting-participant/delete', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
              headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
              },
              url: url,
              type: "POST",
              success: function(data) {
                Swal.fire(
                  (data.status) ? 'Success' : 'Error',
                  data.message,
                  (data.status) ? 'success' : 'error'
                )
                reloadTableAttendee();
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
      $('#saveMeetingParticipantBtn').click(function(e) {
        e.preventDefault();
        var isValid = $("#meetingParticipantForm").valid();
        if (isValid) {
          if (!isUpdate) {
            var url = "{{ route('monitoring-project-meeting-participant/store') }}";
          } else {
            var url = "{{ route('monitoring-project-meeting-participant/update') }}";
          }
          $('#saveMeetingParticipantBtn').text('Save...');
          $('#saveMeetingParticipantBtn').attr('disabled', true);
          var formData = new FormData($('#meetingParticipantForm')[0]);
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
              $('#saveMeetingParticipantBtn').text('Save');
              $('#saveMeetingParticipantBtn').attr('disabled', false);
              reloadTableAttendee();
              $('#meetingParticipantModal').modal('hide');
            },
            error: function(data) {
              Swal.fire(
                'Error',
                'A system error has occurred. please try again later.',
                'error'
              )
              $('#saveMeetingDetailBtn').text('Save');
              $('#saveMeetingDetailBtn').attr('disabled', false);
            }
          });
        }
      });
      $('#meetingParticipantForm').validate({
        rules: {
          name: {
            required: true,
          },
          role: {
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
      $('#meetingParticipantBtn').on('click', function() {
        $('#name').val('');
        $('#role').val('');
        isUpdate = false;
      });
    });
  </script>
@endpush

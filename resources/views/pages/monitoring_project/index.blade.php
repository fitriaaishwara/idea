@extends('layouts.master')

@section('title') @lang('Project Progress') @endsection

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
@slot('title') Progress @endslot
@endcomponent

<!-- sample modal content -->
<div id="activityModal" class="modal fade" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activityModalLabel">Form Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="activityForm" name="activityForm">
                <div class="modal-body">
                    @csrf
                    <input id="id" type="hidden" class="form-control" name="id">
                    <input id="monitoring_project_id" type="hidden" class="form-control" name="monitoring_project_id">
                    <div class="row mb-4">
                        <label for="activity" class="col-sm-3 col-form-label">Activity</label>
                        <div class="col-sm-9 validate">
                            <input disabled id="activity" type="text" class="form-control" name="activity">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="description" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9 validate">
                            <textarea disabled id="description" name="description" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="plan_date" class="col-sm-3 col-form-label">Plan Date</label>
                        <div class="col-sm-9 validate">
                            <input disabled id="plan_date" type="text" class="form-control" name="plan_date">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="pic" class="col-sm-3 col-form-label">PIC</label>
                        <div class="col-sm-9 validate">
                            <input disabled id="pic" type="text" class="form-control" name="pic">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="comment" class="col-sm-3 col-form-label">Comment<span style="color:red;">*</span></label>
                        <div class="col-sm-9 validate">
                            <textarea id="comment" name="comment" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="attachment" class="col-sm-3 col-form-label">Attachment<span style="color:red;">*</span></label>
                        <div class="col-sm-9 validate">
                            <input id="attachment" type="file" class="form-control" name="attachment">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect waves-light" id="activityBtn" name="activityBtn">Save changes</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a  href="{{ route('monitoring-project/create') }}" class="btn btn-dark waves-effect waves-light btn-sm m-1" id="addNew" name="addNew"><i class="mdi mdi-plus-circle mr-1"></i> Create Project</a>
            </div>
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
                '<div class="progress-bar" role="progressbar" style="width: 25%;" style="width: 20%" aria-valuenow="' + progress + '" aria-valuemin="0" aria-valuemax="100" style="width: ' + progress + '%;"></div>' +
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
              btnDetail += '<a href="/monitoring-project/meeting/' + row.id + '" name="btnDetail" data-id="' + row.id + '" type="button" class="btn btn-dark btn-sm btnDetail" data-toggle="tooltip" data-placement="top" title="Total Meeting"><i class="fa fa-info-circle"></i> ' + data + ' Meeting</a>';
              return btnDetail;
            },
          },
          {
            "data": "id",
            "width": '15%',
            render: function(data, type, row) {
              let btnActivity = "";
              let btnDetail = "";
              let btnEdit = "";
              let btnDelete = "";
              if (row.next_monitoring_project_detail) {
                $.each(row.next_monitoring_project_detail.monitoring_project_detail_pic, function(key, value) {
                  if (value.user_id == user_id) {
                    btnActivity += '<button name="btnActivity" data-id="' + row.next_monitoring_project_detail.id + '" type="button" class="btn btn-success btn-sm btnActivity m-1" data-toggle="tooltip" data-placement="top" title="Finish Activity"><i class="fa fa-check-double"></i></button>';
                  }
                });
              }
              btnDetail += '<a href="/monitoring-project/detail/' + data + '" name="btnDetail" type="button" class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>';
                if (row.created_by == "{{ Auth::user()->id }}") {
                  btnEdit += '<a href="/monitoring-project/edit/' + data + '" name="btnEdit" type="button" class="btn btn-warning btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>';
                }
                if (row.created_by == "{{ Auth::user()->id }}") {
                  btnDelete += '<button name="btnDelete" data-id="' + data + '" type="button" class="btn btn-danger btn-sm btnDelete m-1" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>';
                }
              return btnActivity + btnDetail + btnEdit + btnDelete;
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
      $('#monitoringClientsTable').on("click", ".btnActivity", function() {
        var id = $(this).attr('data-id');
        $('#activityModal').modal('show');
        var url = "{{ route('monitoring-project-detail/show', ['id' => ':id']) }}";
        url = url.replace(':id', id);
        $.ajax({
          type: 'GET',
          url: url,
          success: function(response) {
            $('#monitoring_project_id').val(response.data.monitoring_project_id);
            $('#id').val(response.data.id);
            $('#activity').val(response.data.activity);
            $('#description').val(response.data.description);
            $('#plan_date').val(moment(response.data.plan_date).format("DD MMMM YYYY"));
            let pic = ''
            var len = response.data.monitoring_project_detail_pic.length;
            $.each(response.data.monitoring_project_detail_pic, function(key, value) {
              if (key == (len - 1)) {
                pic += value.user.name;
              } else {
                pic += value.user.name + ', ';
              }
            });
            $('#pic').val(pic);
            $('#actual_date').val('');
            $('#comment').val('');
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
      $('#monitoringClientsTable').on("click", ".btnDelete", function() {
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
            var url = "{{ route('monitoring-project/delete', ['id' => ':id']) }}";
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
      $('#activityBtn').click(function(e) {
        e.preventDefault();
        var isValid = $("#activityForm").valid();
        if (isValid) {
          let url = "{{ route('monitoring-project/activity') }}";
          $('#activityBtn').text('Save...');
          $('#activityBtn').attr('disabled', true);
          var formData = new FormData($('#activityForm')[0]);
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
              $('#activityBtn').text('Save');
              $('#activityBtn').attr('disabled', false);
              reloadTable();
              $('#activityModal').modal('hide');
            },
            error: function(data) {
              Swal.fire(
                'Error',
                'A system error has occurred. please try again later.',
                'error'
              )
              $('#activityBtn').text('Save');
              $('#activityBtn').attr('disabled', false);
            }
          });
        }
      });
      $('#activityForm').validate({
        rules: {
          comment: {
            required: true,
          },
          attachment: {
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
      $("#filterStatus").select2({
        placeholder: "Choose Status"
      });
      $("#filterType").select2({
        placeholder: "Choose Type"
      });
      $("#filterProgress").select2({
        placeholder: "Choose Progress"
      });
      $('#btnApply').click(function() {
        request.project_status = $("#filterStatus").val();
        request.progress = $("#filterProgress").val();
        reloadTable();
      });
      $('#btnReset').on('click', function() {
        request.project_status = "";
        $("#filterStatus").val('').trigger('change');
        $("#filterType").val('').trigger('change');
        request.progress = "";
        $("#filterProgress").val('').trigger('change');
        reloadTable();
      });
    });
  </script>
@endpush


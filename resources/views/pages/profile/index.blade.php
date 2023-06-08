@extends('layouts.master')

@section('title') @lang('translation.Profile') @endsection

@section('content')

@component('components.breadcrumb')
@slot('title') Profile @endslot
@slot('li_1') @endslot
@endcomponent

<!-- sample modal content -->
<div id="profileModal" class="modal fade" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Form Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('profile/update') }}" id="profileForm" name="profileForm">
                @csrf
                <div class="modal-body">
                    <input id="id" type="hidden" class="form-control id" name="id">
                    <div class="row mb-4">
                        <label for="username" class="col-md-4 form-control-label text-md-left">Username<span style="color:red;">*</span></label>
                        <div class="col-md-8 validate">
                            <input id="username" type="text" class="form-control" name="username">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="name" class="col-md-4 form-control-label text-md-left">Name<span style="color:red;">*</span></label>
                        <div class="col-md-8 validate">
                            <input id="name" type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="email" class="col-md-4 form-control-label text-md-left">Email<span style="color:red;">*</span></label>
                        <div class="col-md-8 validate">
                            <input id="email" type="email" class="form-control" name="email">
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark waves-effect waves-light" id="saveBtn" name="saveBtn">Save changes</button>
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

 <!-- sample modal content -->
 <div id="changePasswordModal" class="modal fade" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Default Modal Heading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST"  action="{{ route('profile/password') }}" id="changePasswordForm" name="changePasswordForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" class="form-control id" name="id">
                    <div class="row mb-4">
                        <label for="password" class="col-md-6 form-control-label text-md-left">New Password<span style="color:red;">*</span></label>
                        <div class="col-md-12 validate">
                            <input id="password" type="password" class="form-control" name="password"/>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label for="password_confirm" class="col-md-6 form-control-label text-md-left">Confirm Password<span style="color:red;">*</span></label>
                        <div class="col-md-12 validate">
                            <input id="password_confirm" type="password" class="form-control" name="password_confirm"/>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark waves-effect waves-light" id="passwordBtn" name="passwordBtn">Save changes</button>
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card bg-dark border-dark text-light">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm order-2 order-sm-1">
                        <div class="d-flex align-items-start mt-3 mt-sm-0">
                            <div class="flex-shrink-0">
                                <div class="avatar-xl me-3">
                                    <img src="{{ auth()->user()->photo != '' ? asset('storage/images/user/' . auth()->user()->photo) : asset('assets/images/users/avatar.png') }}" alt="" class="img-fluid rounded-circle d-block">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div>
                                    <br>
                                    <h5 class="font-size-20 mb-1 text-light">{{ Auth::user()->name }}</h5>
                                    {{-- <p class="text-muted font-size-14">Role</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-auto order-1 order-sm-2">
                        <div class="d-flex align-items-start justify-content-end gap-2">
                            <div>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#changePasswordModal" id="btnChangePassword" name="btnChangePassword"><i class="me-1"></i> Change Password</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#profileModal"  id="btnUpdateProfile" name="btnUpdateProfile"><i class="me-1"></i> Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->

        <div class="tab-content">
            <div class="tab-pane active" id="overview" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-dark border-dark text-light">
                        <h5 class="card-title mb-0 text-light">User Information</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <div>
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div>
                                            <h5 class="font-size-15">Name :</h5>
                                        </div>
                                    </div>
                                    <div class="col-xl">
                                        <div class="font-size-15">
                                            <p class="mb-2">{{ Auth::user()->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div>
                                            <h5 class="font-size-15">Username :</h5>
                                        </div>
                                    </div>
                                    <div class="col-xl">
                                        <div class="font-size-15">
                                            <p>{{ Auth::user()->username }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div>
                                            <h5 class="font-size-15">Email :</h5>
                                        </div>
                                    </div>
                                    <div class="col-xl">
                                        <div class="font-size-15">
                                            <p>{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end tab pane -->
        </div>
        <!-- end tab content -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection
@push('js')
<script type="text/javascript">
$(function(){
  let id = '{{ Auth::user()->id }}';
  $('.id').val(id);

  $('#btnUpdateProfile').click(function(e) {
      e.preventDefault();
      $('#profileModal').modal('show');
      var url = "{{route('profile/show',['id'=>':id'])}}";
      url = url.replace(':id', id);
      $.ajax({
        type: 'GET',
        url: url,
        success: function(response) {
            $('#name').val(response.data.name);
            $('#username').val(response.data.username);
            $('#email').val(response.data.email);
            $('#id').val(response.data.id);
        },
        error: function(){
          Swal.fire(
            'Error',
            'A system error has occurred. please try again later.',
            'error'
          )
        },
      });
  });
  $('#saveBtn').click(function(e) {
    e.preventDefault();
    var isValid = $("#profileForm").valid();
    if(isValid){
      $('#saveBtn').text('Save...');
      $('#saveBtn').attr('disabled',true);
      var formData = new FormData($('#profileForm')[0]);
      $.ajax({
        url : "{{route('profile/update')}}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
          Swal.fire(
                (data.status) ? 'Success' : 'Error',
                data.message,
                (data.status) ? 'success' : 'error'
            )
          $('#saveBtn').text('Save');
          $('#saveBtn').attr('disabled',false);
          $('#profileModal').modal('hide');
          location.reload();
        },
        error: function (data)
        {
          Swal.fire(
            'Error',
            'A system error has occurred. please try again later.',
            'error'
          )
          $('#saveBtn').text('Save');
          $('#saveBtn').attr('disabled',false);
        }
    });
    }
  });
  $('#passwordBtn').click(function(e) {
    e.preventDefault();
    var isValid = $("#changePasswordForm").valid();
    if(isValid){
      $('#passwordBtn').text('Save...');
      $('#passwordBtn').attr('disabled',true);
      var formData = new FormData($('#changePasswordForm')[0]);
      $.ajax({
        url : "{{route('profile/password')}}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function(data)
        {
          Swal.fire(
                (data.status) ? 'Success' : 'Error',
                data.message,
                (data.status) ? 'success' : 'error'
            )
          $('#passwordBtn').text('Save');
          $('#passwordBtn').attr('disabled',false);
          $('#changePasswordModal').modal('hide');
        },
        error: function (data)
        {
          Swal.fire(
            'Error',
            'A system error has occurred. please try again later.',
            'error'
          )
          $('#passwordBtn').text('Save');
          $('#passwordBtn').attr('disabled',false);
        }
    });
    }
  });

  $('#profileForm').validate({
    rules: {
      username: {
        required: true,
      },
      name: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
    },
    errorElement: 'em',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.validate').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });

  $('#changePasswordForm').validate({
    rules: {
      password: {
        required: true,
        minlength: 8
      },
      password_confirm: {
        required: true,
        minlength: 8,
        equalTo: "#password"
      },
    },
    errorElement: 'em',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.validate').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });

  $('#btnChangePassword').on('click', function(){
    $('#password').val("");
    $('#password_confirm').val("");
  });
});
</script>
@endpush

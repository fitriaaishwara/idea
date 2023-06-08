@extends('layouts.master')

@section('title')
    @lang('Create Role')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Management User
        @endslot
        @slot('title')
            Create Role
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Role</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('role/create') }}" method="POST" id="roleForm" name="roleForm">
                        @csrf
                        <div class="row mb-4">
                            <label for="name" class="col-md-2 form-control-label text-md-left">Role Name <span
                                    style="color:red;">*</span></label>
                            <div class="col-md-6 validate">
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="description" class="col-md-2 form-control-label text-md-left">Description</label>
                            <div class="col-md-6 validate">
                                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label" for="permission">Permission<span
                                    style="color: red">*</span></label>
                            <div class="row mt-2 validate">
                                @foreach ($groupPermission as $groupName => $data)
                                    <div class="col-md-4 mb-3">
                                        <div style="border: 1px solid #dee2e6; border-radius: 0.25rem; padding: 10px;">
                                            <h4>{{ strtoupper($groupName) }}</h4>
                                            @foreach ($data as $value)
                                                <div class="form-check col-md-12">
                                                    <input type="checkbox" name="permission[]" class="form-check-input"
                                                        id="{{ $value->id }}" value="{{ $value->id }}">
                                                    <label for="{{ $value->id }}"
                                                        class="form-check-label">{{ $value->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-dark" id="saveBtn" name="saveBtn">Save</button>
                    <a href="{{ route('role') }}" class="btn btn-sm btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#roleForm").valid();
                if (isValid) {
                    var url = "{{ route('role/create') }}";
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    var formData = new FormData($('#roleForm')[0]);
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
                            ).then(function(result) {
                                $('#saveBtn').text('Save');
                                $('#saveBtn').attr('disabled', false);
                                (data.status) ? window.location.href =
                                    "{{ route('role') }}": '';
                            });

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
            $('#roleForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    'permission[]': {
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
        });
    </script>
@endpush

@extends('layouts.master')

@section('title')
    @lang('Create Client')
@endsection

@section('css')
    <!-- choices css -->
    <link href="{{ URL::asset('/assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- color picker css -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/@simonwep/pickr/themes/classic.min.css') }}" />
    <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/@simonwep/pickr/themes/monolith.min.css') }}" />
    <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/@simonwep/pickr/themes/nano.min.css') }}" />
    <!-- 'nano' theme -->

    <!-- datepicker css -->
    <link rel="stylesheet" href="{{ URL::asset('/assets/libs/flatpickr/flatpickr.min.css') }}">
@endsection


@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Client
        @endslot
        @slot('title')
            Create Client
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Create Client</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('client/create') }}" id="clientForm" name="clientForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3 validate">
                                        <label for="name" class="form-label">Client Name<span
                                                style="color:red;">*</span></label>
                                        <input id="name" type="text" class="form-control" name="name"
                                            style="text-transform: uppercase;">
                                    </div>
                                    <div class="mb-3 validate">
                                        <label for="province_id" class="form-label">Province<span
                                                style="color:red;">*</span></label>
                                        <select id="province_id" type="text" class="form-control" id="province_id"
                                            name="province_id">
                                        </select>
                                    </div>
                                    <div class="mb-3 validate">
                                        <label for="regency_id" class="form-label">Regency<span
                                                style="color:red;">*</span></label>
                                        <select id="regency_id" type="text" class="form-control" id="regency_id"
                                            name="regency_id">
                                        </select>
                                    </div>
                                    <div class="mb-3 validate">
                                        <label for="address" class="form-label">Address<span
                                                style="color:red;">*</span></label>
                                        <textarea rows="5" id="address" name="address" class="form-control"></textarea>
                                    </div>
                                    <div class="validate">
                                        <label for="scope_1" class="form-label">Scope<span
                                                style="color:red;">*</span></label>
                                        <select id="scope_1" type="text" class="form-control scope_id" name="scope_1">
                                        </select>
                                    </div>
                                    <div class="validate">
                                        <label for="scope_2" class="form-label"></label>
                                        <select id="scope_2" type="text" class="form-control scope_id" name="scope_2">
                                        </select>
                                    </div>
                                    <div class="validate">
                                        <label for="scope_3" class="form-label"></label>
                                        <select id="scope_3" type="text" class="form-control scope_id" name="scope_3">
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">
                                    <div class="mb-3 validate">
                                        <label for="service" class="form-label">Service<span
                                                style="color:red;">*</span></label>
                                        <textarea rows="3" id="service" name="service" class="form-control"></textarea>
                                    </div>
                                    <div class="mb-3 validate">
                                        <label for="pic" class="form-label">PIC</label>
                                        <input id="pic" type="text" class="form-control" name="pic">
                                    </div>
                                    <div class="mb-3 validate">
                                        <label for="pic_position" class="form-label">PIC Position</label>
                                        <input id="pic_position" type="text" class="form-control"
                                            name="pic_position">
                                    </div>
                                    <div class="mb-3 validate">
                                        <label for="mobile_phone" class="form-label">Mobile Phone<span
                                                style="color:red;">*</span></label>
                                        <input id="mobile_phone" type="text" class="form-control"
                                            name="mobile_phone">
                                    </div>
                                    <div class="mb-3 validate">
                                        <label for="email" class="form-label">Email<span
                                                style="color:red;">*</span></label>
                                        <input id="email" type="email" class="form-control" name="email">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-dark waves-effect waves-light btn-sm" id="saveBtn"
                        name="saveBtn">Save</button>
                    <a href="{{ route('client') }}" class="btn btn-secondary waves-effect btn-sm"
                        data-bs-dismiss="modal">Cancel</a>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@section('script')
    <!-- choices js -->
    <script src="{{ URL::asset('/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

    <!-- color picker js -->
    <script src="{{ URL::asset('/assets/libs/@simonwep/pickr/pickr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- datepicker js -->
    <script src="{{ URL::asset('/assets/libs/flatpickr/flatpickr.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            $("#province_id").select2({
                theme: 'bootstrap-5',
                placeholder: "Choose Province",
                ajax: {
                    url: "{{ route('ajax/getDataProvince') }}",
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
                            length: 50
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
            }).change(function() {
                $("#regency_id").val("").trigger("change");
            });
            $("#regency_id").select2({
                theme: 'bootstrap-5',
                placeholder: "Choose Regency",
                ajax: {
                    url: "{{ route('ajax/getDataRegency') }}",
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
                            province_id: $('#province_id').val(),
                            searchkey: params.term || '',
                            start: 0,
                            length: -1
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
            $(".scope_id").select2({
                theme: 'bootstrap-5',
                placeholder: "Choose Scope",
                allowClear: true,
                ajax: {
                    url: "{{ route('scope/getData') }}",
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
                            length: -1
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
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#clientForm").valid();
                if (isValid) {
                    var url = "{{ route('client/create') }}";
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    var formData = new FormData($('#clientForm')[0]);
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
                            $('#saveBtn').text('Save');
                            $('#saveBtn').attr('disabled', false);
                            (data.status) ? window.location.href = "{{ route('client') }}": "";
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
            $('#clientForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    province_id: {
                        required: true,
                    },
                    regency_id: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    scope_1: {
                        required: true,
                    },
                    service: {
                        required: true,
                    },
                    mobile_phone: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
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

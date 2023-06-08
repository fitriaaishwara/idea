@extends('layouts.master')

@section('title')
    @lang('Create Schedule Email')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Schedule Email
        @endslot
        @slot('title')
            Create Schedule Email
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Schedule Email</h4>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST" id="scheduleMailForm" name="scheduleMailForm">
                        @csrf
                        <div class="row mb-4">
                            <label for="date" class="col-md-2 form-control-label text-md-left">Date<span
                                    style="color:red;">*</span></label>
                            <div class="col-md-6 validate">
                                <input id="date" type="text" class="form-control date" name="date"
                                    style="background-color: #fff;">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="scope" class="col-md-2 form-control-label text-md-left">Scope<span
                                    style="color:red;">*</span></label>
                            <div class="col-md-10 validate row ml-0" id="scope">

                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="totalClient" class="col-md-2 form-control-label text-md-left">Total Client</label>
                            <div class="col-md-6 validate">
                                <input readonly id="totalClient" type="text" class="form-control" name="total_client"
                                    value="0">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="note" class="col-md-2 form-control-label text-md-left">Note</label>
                            <div class="col-md-10 validate">
                                <textarea id="note" name="note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Email</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <label for="subject" class="col-md-2 form-control-label text-md-left">Subject<span
                                            style="color:red;">*</span></label>
                                    <div class="col-md-12 validate">
                                        <input id="subject" type="text" class="form-control" name="subject"
                                            style="background-color: #fff;">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="is_html" class="col-md-2 form-control-label text-md-left">HTML<span
                                            style="color:red;">*</span></label>
                                    <div class="col-md-12 validate">
                                        <select id="is_html" type="text" class="form-control is_html" name="is_html">
                                            <option></option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="body" class="col-md-2 form-control-label text-md-left">Body<span
                                            style="color:red;">*</span></label>
                                    <div class="col-md-12 validate">
                                        <textarea id="body" name="body" class="form-control" style="display: none;"></textarea>
                                        <textarea id="body_html" name="body_html" rows="20" class="form-control" style="display: none;"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="attachment"
                                        class="col-md-2 form-control-label text-md-left">Attachment</label>
                                    <div class="col-md-12 validate">
                                        <input id="attachment" type="file" class="form-control" name="attachment">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-dark" id="saveBtn" name="saveBtn">Save</button>
                    <a href="{{ route('schedule-mail') }}" class="btn btn-sm btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        $(function() {
            let user_id = "{{ Auth::user()->id }}";

            scope();
            $("#is_html").select2({
                theme: 'bootstrap-5',
                placeholder: "Choose Answer"
            }).on("change", function(e) {
                if ($(this).val() != null) {
                    if ($(this).val() == 1) {
                        tinymce.remove('#body');
                        $('#body_html').show();
                        $("#body_html").rules("add", {
                            required: true,
                        });
                        $("#body").rules('remove', 'required')
                        $('#body').hide();
                        $('#body').val('');
                    } else {
                        $('#body').show();
                        $("#body").rules("add", {
                            required: true,
                        });
                        tinymce.init({
                            selector: 'textarea#body',
                            plugins: 'lists',
                            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
                            toolbar: 'undo redo | formatselect| bold italic underline| fontselect |  fontsizeselect | alignleft aligncenter alignright alignjustify| bullist numlist | indent outdent',
                            height: "480"
                        });

                        $("#body_html").rules('remove', 'required')
                        $('#body_html').hide();
                        $('#body_html').val('');
                    }
                }
            });
            $('.date').flatpickr({
                minDate: "today",
                dateFormat: "Y-m-d"
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                let isValid = $("#scheduleMailForm").valid();
                if (isValid) {
                    let is_html = $('#is_html').val();
                    if (is_html == 1) {
                        let url = "{{ route('schedule-mail/store') }}";
                        $('#saveBtn').text('Save...');
                        $('#saveBtn').attr('disabled', true);
                        let formData = new FormData($('#scheduleMailForm')[0]);
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
                                (data.status) ? window.location.href =
                                    "{{ route('schedule-mail') }}": "";
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
                    } else {
                        let ed = tinyMCE.get('body');
                        let data = ed.getContent();
                        $('#body').val(data);
                        console.log(data)
                        if (!data) {
                            Swal.fire(
                                'Error',
                                'Body email is required',
                                'error'
                            )
                        } else {
                            let url = "{{ route('schedule-mail/store') }}";
                            $('#saveBtn').text('Save...');
                            $('#saveBtn').attr('disabled', true);
                            let formData = new FormData($('#scheduleMailForm')[0]);
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
                                    (data.status) ? window.location.href =
                                        "{{ route('schedule-mail') }}": "";
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
                    }


                }
            });
            $('#scheduleMailForm').validate({
                rules: {
                    date: {
                        required: true,
                    },
                    "scope_id[]": {
                        required: true,
                    },
                    body: {
                        required: true,
                    },
                    subject: {
                        required: true,
                    },
                    is_html: {
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

            function scope() {
                let req = {
                    "searchkey": '',
                    "start": 0,
                    "length": -1,
                };
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: "POST",
                    url: "{{ route('scope/getData') }}",
                    data: req,
                    success: function(response) {
                        $.each(response.data, function(key, value) {
                            let scope =
                                '<div class="form-check col-md-6">' +
                                '<input type="checkbox" name="scope_id[]" class="form-check-input scope_id" id="scope' +
                                value.id + '" value="' + value.id + '">' +
                                '<label for="scope' + value.id +
                                '" class="form-check-label">' + value.name + '</label>' +
                                '</div>';

                            $('#scope').append(scope);
                        });
                        let arrScope = [0];
                        $('.scope_id').click(function() {
                            let scope_id = $(this).attr('value');
                            if (this.checked) {
                                arrScope.push(scope_id);
                            } else {
                                arrScope = arrScope.filter(item => item !== scope_id)
                            }
                            $.ajax({
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                        'content'),
                                },
                                url: "{{ route('schedule-mail/total/client') }}",
                                type: "POST",
                                data: {
                                    user_id: user_id,
                                    scope: arrScope
                                },
                                success: function(response) {
                                    $('#totalClient').val(response.data);
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
                    },
                    error: function(data) {
                        Swal.fire(
                            'Error',
                            'A system error has occurred. please try again later.',
                            'error'
                        )
                    }
                });
            }
        });
    </script>
@endpush

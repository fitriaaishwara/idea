@extends('layouts.master')

@section('title')
    @lang('Detail Schedule Email')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Schedule Email
        @endslot
        @slot('title')
            Detail Schedule Email
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Schedule Email</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" id="scheduleMailForm" name="scheduleMailForm">
                        @csrf
                        <input type="hidden" class="form-control schedule_mail_id" name="id"
                            value="{{ $id }}">
                        <div class="row mb-4">
                            <label for="date" class="col-md-2 form-control-label text-md-left">Date<span
                                    style="color:red;">*</span></label>
                            <div class="col-md-6 validate">
                                <input disabled id="date" type="text" class="form-control date" name="date">
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
                                <textarea disabled id="note" name="note" class="form-control" rows="3"></textarea>
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
                                        <input disabled id="subject" type="text" class="form-control" name="subject">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="is_html" class="col-md-2 form-control-label text-md-left">HTML<span
                                            style="color:red;">*</span></label>
                                    <div class="col-md-12 validate">
                                        <select disabled id="is_html" type="text" class="form-control is_html"
                                            name="is_html">
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
                                        <textarea disabled id="body" name="body" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="attachment"
                                        class="col-md-2 form-control-label text-md-left">Attachment</label>
                                    <div id="doc_attachment" class="col-md-12 validate">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="{{ route('schedule-mail') }}" class="btn btn-sm btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        $(function() {
            var schedule_mail_id = $('.schedule_mail_id').val();
            scope();

            show(schedule_mail_id)

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
                                '<input disabled type="checkbox" name="scope_id[]" class="form-check-input scope_id" id="scope' +
                                value.id + '" value="' + value.id + '">' +
                                '<label for="scope' + value.id +
                                '" class="form-check-label">' + value.name + '</label>' +
                                '</div>';
                            $('#scope').append(scope);
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

            function show(schedule_mail_id) {
                let url = "{{ route('schedule-mail/show', ['id' => ':id']) }}";
                url = url.replace(':id', schedule_mail_id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(response) {
                        tinymce.init({
                            selector: 'textarea#body',
                            readonly: 1,
                            plugins: 'lists',
                            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
                            toolbar: 'undo redo | formatselect| bold italic underline| fontselect |  fontsizeselect | alignleft aligncenter alignright alignjustify| bullist numlist | indent outdent',
                            height: "480"
                        });
                        $('#date').val(response.data.date);
                        $.each(response.data.schedule_email_scopes, function(key, value) {
                            $('#scope' + value.scope_id).prop('checked', true);
                        });
                        $('#totalClient').val(response.data.total_client);
                        $('#note').val(response.data.note);
                        $('#subject').val(response.data.subject);
                        $('#is_html').val(response.data.is_html).trigger('change');
                        $('#body').val(response.data.body);
                        if (response.data.attachment_id != null) {
                            var doc_attachment =
                                '<a target="_blank" href="{{ route('schedule-mail/download/attachment', ['id' => ':id']) }}">Attachment ' +
                                response.data.subject + '.pdf</a>';
                            doc_attachment = doc_attachment.replace(':id', response.data.id);
                        } else {
                            var doc_attachment = "";
                        }
                        $('#doc_attachment').append(doc_attachment);

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
    </script>
@endpush

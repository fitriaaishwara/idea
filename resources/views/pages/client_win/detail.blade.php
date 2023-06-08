@extends('layouts.master')

@section('title') @lang('Detail Client') @endsection

@section('css')

<!-- choices css -->
<link href="{{ URL::asset('/assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" />

<!-- color picker css -->
<link rel="stylesheet" href="{{ URL::asset('/assets/libs/@simonwep/pickr/themes/classic.min.css') }}" /> <!-- 'classic' theme -->
<link rel="stylesheet" href="{{ URL::asset('/assets/libs/@simonwep/pickr/themes/monolith.min.css') }}" /> <!-- 'monolith' theme -->
<link rel="stylesheet" href="{{ URL::asset('/assets/libs/@simonwep/pickr/themes/nano.min.css') }}" /> <!-- 'nano' theme -->

<!-- datepicker css -->
<link rel="stylesheet" href="{{ URL::asset('/assets/libs/flatpickr/flatpickr.min.css') }}">

@endsection


@section('content')

@component('components.breadcrumb')
@slot('li_1') Client @endslot
@slot('title') Detail Client @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Detail Client</h4>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <input id="id" type="hidden" class="form-control" name="id" value="{{$id}}">
                            <div class="mb-3 validate">
                                <label for="name" class="form-label">Client Name<span style="color:red;">*</span></label>
                                <input id="name" type="text" class="form-control" name="name" disabled>
                            </div>
                            <div class="mb-3 validate">
                                <label for="province_id" class="form-label">Province<span style="color:red;">*</span></label>
                                <select id="province_id" type="text" class="form-control" id="province_id" name="province_id" disabled>
                                </select>
                            </div>
                            <div class="mb-3 validate">
                                <label for="regency_id" class="form-label">Regency<span style="color:red;">*</span></label>
                                <select id="regency_id" type="text" class="form-control" id="regency_id" name="regency_id" disabled>
                                </select>
                            </div>
                            <div class="mb-3 validate">
                                <label for="address" class="form-label">Address<span style="color:red;">*</span></label>
                                <textarea rows="5" id="address" name="address" class="form-control" disabled></textarea>
                            </div>
                            <div class="validate">
                                <label for="scope_1" class="form-label">Scope<span style="color:red;">*</span></label>
                                <select id="scope_1" type="text" class="form-control scope_id" name="scope_1" disabled>
                                </select>
                            </div>
                            <div class="validate">
                                <label for="scope_2" class="form-label"></label>
                                <select id="scope_2" type="text" class="form-control scope_id" name="scope_2" disabled>
                                </select>
                            </div>
                            <div class="validate">
                                <label for="scope_3" class="form-label"></label>
                                <select id="scope_3" type="text" class="form-control scope_id" name="scope_3" disabled>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mt-3 mt-lg-0">
                            <div class="mb-3 validate">
                                <label for="service" class="form-label">Service<span style="color:red;">*</span></label>
                                <textarea rows="3" id="service" name="service" class="form-control" disabled></textarea>
                            </div>
                            <div class="mb-3 validate">
                                <label for="pic" class="form-label">PIC</label>
                                <input id="pic" type="text" class="form-control" name="pic" disabled>
                            </div>
                            <div class="mb-3 validate">
                                <label for="pic_position" class="form-label">PIC Position</label>
                                <input id="pic_position" type="text" class="form-control" name="pic_position" disabled>
                            </div>
                            <div class="mb-3 validate">
                                <label for="mobile_phone" class="form-label">Mobile Phone<span style="color:red;" >*</span></label>
                                <input id="mobile_phone" type="text" class="form-control" name="mobile_phone" disabled>
                            </div>
                            <div class="mb-3 validate">
                                <label for="email" class="form-label">Email<span style="color:red;">*</span></label>
                                <input id="email" type="email" class="form-control" name="email" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="card-footer">
                {{-- <button type="button" class="btn btn-primary waves-effect waves-light" id="saveBtn" name="saveBtn">Save</button> --}}
                <a href="{{route('client-win')}}" class="btn btn-dark waves-effect btn-sm" data-bs-dismiss="modal"><i class="mdi mdi-arrow-left"></i> Back</a>
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
    $(function(){
        var id = $('#id').val();
        show(id);
        function show(id) {
        let url = "{{route('client/show',['id'=>':id'])}}";
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
            $('#name').val(response.data.name);
            var province_id = (response.data.regency)?new Option(response.data.regency.province.name, response.data.regency.province.id, true, true):null;
            $('#province_id').append(province_id).trigger('change');
            var regency_id = (response.data.regency)?new Option(response.data.regency.name, response.data.regency.id, true, true):null;
            $('#regency_id').append(regency_id).trigger('change');
            $('#address').val(response.data.address);
            var scope_1 = (response.data.scope_1)?new Option(response.data.scope_1.name, response.data.scope_1.id, true, true):null;
            $('#scope_1').append(scope_1).trigger('change');
            var scope_2 = (response.data.scope_2)?new Option(response.data.scope_2.name, response.data.scope_2.id, true, true):null;
            $('#scope_2').append(scope_2).trigger('change');
            var scope_3 = (response.data.scope_3)?new Option(response.data.scope_3.name, response.data.scope_3.id, true, true):null;
            $('#scope_3').append(scope_3).trigger('change');
            $('#service').val(response.data.service);
            $('#pic').val(response.data.pic);
            $('#pic_position').val(response.data.pic_position);
            $('#mobile_phone').val(response.data.mobile_phone);
            $('#email').val(response.data.email);

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

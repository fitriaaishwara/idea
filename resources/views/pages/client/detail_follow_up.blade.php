@extends('layouts.master')

@section('title') @lang('Detail Follow Up') @endsection

@section('css')

<!-- choices css -->
<link href="{{ URL::asset('/assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet" type="text/css" />

<!-- DataTables -->
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ URL::asset('/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection


@section('content')

@component('components.breadcrumb')
@slot('li_1') Client @endslot
@slot('title') Detail Follow Up @endslot
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
                            <input id="id" type="hidden" class="form-control" name="id" value="{{$id}}">
                            <div class="row mb-4">
                                <label for="name" class="col-sm-3 col-form-label">Client Name</label>
                                <div class="col-sm-9">
                                    <input disabled type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="address" class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-9">
                                    <textarea disabled rows="5" id="address" name="address" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <label for="scope_id" class="col-sm-3 col-form-label">Scope</label>
                                <div class="col-sm-9">
                                    <select disabled type="text" class="form-control" id="scope_id" name="scope_id">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="form-group row ml-2 mr-2">
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover nowrap" id="followUpTable" style="width: 100%;">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Note</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{route('client')}}" class="btn btn-dark waves-effect btn-sm"><i class="mdi mdi-arrow-left"></i> Back</a>
            </div>
        </div>
    </div> <!-- end col -->

</div>
<!-- end row -->
@endsection

@section('script')

<!-- choices js -->
<script src="{{ URL::asset('/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>

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
        var id = $('#id').val();
        show(id);
        var request = {
        start:0,
        length:10,
        client_id:id,
        };
        var followUpTable = $('#followUpTable').DataTable( {
            "language": {
            "paginate": {
                "next":       '<i class="fas fa-arrow-right"></i>',
                "previous":   '<i class="fas fa-arrow-left"></i>'
            }
            },
            "aaSorting": [],
            "searching": false,
            "ordering": false,
            "responsive": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 15, 25, 50, -1],
                [10, 15, 25, 50, "All"]
            ],
            "ajax": {
                "url": "{{route('client/follow-up/getData')}}",
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
                "data": "date",
                "width" : '20%',
                "defaultContent": "-",
                render: function (data, type, row) {
                    let date = moment(data).format("DD MMMM YYYY");
                    return "<div class='text-wrap'>" + date + "</div>";
                },
                },
                {
                "data": "type",
                "width" : '10%',
                "defaultContent": "-",
                "render": function(data, type, row){
                    let typeFollowUp = ''
                    if (data == '1') {
                    typeFollowUp = 'Call';
                    }else if(data == '2'){
                    typeFollowUp = 'Meeting';
                    }else if(data == '3'){
                    typeFollowUp = 'Proposal';
                    }else if(data == '4'){
                    typeFollowUp = 'Email';
                    }
                    return "<div class='text-wrap'>" + typeFollowUp + "</div>";
                }
                },
                {
                "data": "note",
                "width" : '50%',
                "defaultContent": "-",
                "render": function(data, type, row){
                    let note = (data)?data:'-';
                    return "<div class='text-wrap'>" + note + "</div>";
                }
                },
                {
                "data": "attachment_id",
                "width" : '15%',
                "defaultContent": "-",
                "render": function(data, type, row){
                    let urlDownload = "{{route('client/follow-up/download',['id'=>':id'])}}";
                    urlDownload = urlDownload.replace(':id',row.id);
                    let btnDownload = '<a target="_blank" href="'+urlDownload+'" name="btnDownload" data-id="' + data + '" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download"></i></a>';
                    btnDownload = (data)?btnDownload:'-';
                    return "<div class='text-wrap'>" + btnDownload + "</div>";
                }
                },
            ]
        });
        function show(id) {
        let url = "{{route('client/show',['id'=>':id'])}}";
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            success: function(response) {
            $('#name').val(response.data.name);
            $('#address').val(response.data.address);
            var scope_id = (response.data.scope)?new Option(response.data.scope.name, response.data.scope.id, true, true):null;
            $('#scope_id').append(scope_id).trigger('change');

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

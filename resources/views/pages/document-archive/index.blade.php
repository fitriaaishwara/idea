@extends('layouts.master')

@section('title')
    @lang('Document Archive')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Management Document
        @endslot
        @slot('title')
            Document Archive
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="archivesTable" class="table table-striped table-bordered dt-responsive nowrap w-100"
                        width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Document Number</th>
                                <th>Effective Date</th>
                                <th>Revisi</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {
            let request = {
                start: 0,
                length: 10
            };
            var isUpdate = false;

            var archivesTable = $('#archivesTable').DataTable({
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
                    "url": "{{ route('document-archive/getData') }}",
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
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "data": "name",
                        "defaultContent": "-"
                    },
                    {
                        "data": "no_document",
                        "defaultContent": "-"
                    },
                    {
                        "data": "date",
                        "defaultContent": "-",
                        render: function(data, type, row) {
                            return moment(data).locale('id').format("DD MMMM YYYY")
                        }
                    },
                    {
                        "data": "revisi",
                        "defaultContent": "-"
                    },
                    {
                        "data": "description",
                        "defaultContent": "-"
                    },
                    {
                        "data": "id",
                        render: function(data, type, row) {
                            let urlDownload =
                                "{{ route('document-archive/download', ['id' => ':id']) }}";
                            let urlStream =
                                "{{ route('document-archive/stream', ['id' => ':id']) }}";
                            urlDownload = urlDownload.replace(':id', row.id);
                            urlStream = urlStream.replace(':id', row.id);
                            let extension = row.extension;
                            let btnView = '';
                            if (extension == 'png' || extension == 'jpg' || extension == 'jpeg') {
                                let fileLocation = row.attachment.path + row.attachment.name + '.' +
                                    row.attachment.extension;
                                $("#showImage").attr("src", "/storage/" + fileLocation);
                                btnView =
                                    '<a href="javascript:void(0)" class="btn btn-info btn-sm"  data-toggle="modal" data-target="#openDocumentModal"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                            } else {
                                btnView = '<a target="_blank" href="' + urlStream +
                                    '" type="button" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Open"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                            }

                            var btnDownload = "";
                            btnDownload += '<a target="_blank" href="' + urlDownload +
                                '" id="btnDownload" name="btnDownload" data-id="' + data +
                                '" type="button" class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-download"></i></a>';
                            return btnView + " " + btnDownload;
                        },
                    },
                ]
            });

            function reloadTable() {
                archivesTable.ajax.reload(null, false); //reload datatable ajax
            }
        });
    </script>
@endpush

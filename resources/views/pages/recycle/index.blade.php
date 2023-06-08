@extends('layouts.master')

@section('title')
    @lang('Recycle Bin')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            Recycle Bin
        @endslot
    @endcomponent
    <style>
        .dropbtn {
            background-color: #3498DB;
            color: white;
            padding: 40px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover,
        .dropbtn:focus {
            background-color: #2980B9;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 150px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 5px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }
    </style>
    <div id="propertiesModal" class="modal fade" tabindex="-1" aria-labelledby="propertiesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="propertiesModalLabel">Description Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Folder
                                                    Name</strong></td>
                                            <td>:</td>
                                            <td align="left" id="nameFolder">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Size</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="sizeFolder">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Contents</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="containsFolder">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Description</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="descriptionfolder">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Creator</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="userFolder">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Created</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="dateFolder">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div id="propertiesDocumentModal" class="modal fade" tabindex="-1" aria-labelledby="propertiesDocumentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="propertiesDocumentModalLabel">Description Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Document
                                                    Name</strong></td>
                                            <td>:</td>
                                            <td align="left" id="showNameDocument">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Ektensi</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="extension">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Size</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="sizeDocument">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Download</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="downloadDocument">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Description</strong>
                                            </td>
                                            <td>:</td>
                                            <td align="left" id="showDescriptionDocument">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Deleted
                                                    by</strong></td>
                                            <td>:</td>
                                            <td align="left" id="userDocument">&nbsp;</td>
                                        </tr>

                                        <tr>
                                            <td style="width: 150px;" align="left"><i
                                                    class="ace-icon fa fa-caret-right blue"></i><strong>&nbsp;Deleted
                                                    at</strong></td>
                                            <td>:</td>
                                            <td align="left" id="dateDocument">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-5 ml-md-4">
                                <input type="text" placeholder="Search" name="nameFilter" id="nameFilter"
                                    class="form-control form-control-sm">
                                <div class="input-group-prepend">
                                    <button id="btnFilter" class="btn btn-info waves-effect waves-light btn-sm"><span
                                            class="btn-label"><i class="fa fa-search"></i></span>&nbsp;Search</button>
                                    <button id="btnReset" class="btn btn-danger btn-sm waves-effect waves-light"><span
                                            class="btn-label"><i class="fa fa-sync"></i></span>&nbsp;Refresh</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row" id="listFolder">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(function() {

            var request = {
                "name": ""
            };
            var countFolder = 0;
            var countDocument = 0;
            $.when(getFolder()).then(getDocument());

            function getFolder() {
                var url = "{{ route('folder/getDataRecycle') }}";
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: 'POST',
                    url: url,
                    data: request,
                    success: function(response) {
                        let data = response.data;
                        if (data.length > 0) {
                            countFolder = data.length;
                            $('#listFolder').append(folder(data));
                        }

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

            function getDocument() {
                var url = "{{ route('document/getDataRecycle') }}";
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                    },
                    type: 'POST',
                    url: url,
                    data: request,
                    success: function(response) {
                        let data = response.data;
                        if (data.length > 0) {
                            countDocument = data.length;
                            $('#listFolder').append(document(data));
                        }
                        cek();
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

            function folder(data) {
                let html = ''
                $.each(data, function(key, value) {
                    let recyclefolder = '';
                    recycleFolder = '<a href="javascript:void(0)" onclick="restore(' + value.id +
                        ')"><i class="fa fa-trash-restore-alt" aria-hidden="true"></i>&nbsp;&nbsp;Restore</a>';
                    html += '<div class="col-md-2 countFolder" align="center" id="tr_' + value.id + '">' +
                        '<div class="dropdown" align="left">' +
                        '<div id="popUpMenu' + value.id + '" class="dropdown-content">' +
                        recycleFolder +
                        '<a href="javascript:void(0)" onclick="properties(' + value.id +
                        ')"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;Properties</a>' +
                        '</div>' +
                        '</div>' +
                        '<img class="card-img-top img-responsive bounce-over" oncontextmenu="right_click(' +
                        value.id + ')" style="cursor: pointer;" alt="' + value.name +
                        '" src="{{ URL::asset('assets/images/file_manager/folder.png') }}">' +
                        '<div class="el-card-content">' +
                        '<p>' +
                        '<a data-type="text">' + value.name + '</a>' +
                        '</p>' +
                        '</div>' +
                        '</div>';
                });
                return html;
            }

            function document(data) {
                let html = ''
                $.each(data, function(key, value) {
                    let id = value.id;
                    let urlDownload = "{{ route('document/download', ['id' => ':id']) }}";
                    urlDownload = urlDownload.replace(':id', id);
                    let recycleDocument = '';
                    recycleDocument = '<a href="javascript:void(0)" onclick="restoreDocument(' + value.id +
                        ')"><i class="fa fa-trash-restore-alt" aria-hidden="true"></i>&nbsp;&nbsp;Restore</a>';
                    html += '<div class="col-md-2 countDocument" align="center" id="tr_document' + value
                        .id + '">' +
                        '<div class="dropdown" align="left">' +
                        '<div id="popUpMenuDocument' + value.id + '" class="dropdown-content">' +
                        recycleDocument +
                        '<a href="javascript:void(0)" onclick="propertiesDocument(' + value.id +
                        ')"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;Properties</a>' +
                        '</div>' +
                        '</div>' +
                        '<img class="card-img-top img-responsive bounce-over" oncontextmenu="right_click_document(' +
                        value.id + ')" style="cursor: pointer;" alt="' + value.name +
                        '" src="/assets/images/extensions/' + value.extension + '.png"">' +
                        '<div class="el-card-content">' +
                        '<p>' +
                        '<a data-type="text">' + value.name + '</a>' +
                        '</p>' +
                        '</div>' +
                        '</div>';
                });
                return html;
            }

            function cek() {
                if (countFolder == 0 && countDocument == 0) {
                    let html =
                        '<div class="alert alert-danger col-md-12" style="text-align: center;">Document is Empty</div>';
                    $('#listFolder').append(html);
                }
            }

            $('#btnFilter').click(function() {
                request.name = $("#nameFilter").val();
                $("#listFolder").children().remove();
                $.when(getFolder()).then(getDocument());
            });
            $('#btnReset').click(function() {
                request.name = "";
                $('#nameFilter').val("");
                $("#listFolder").children().remove();
                $.when(getFolder()).then(getDocument());
            });
        });

        function right_click(id) {
            document.getElementById("popUpMenu" + id).classList.toggle("show");
        }

        function right_click_document(id) {
            document.getElementById("popUpMenuDocument" + id).classList.toggle("show");
        }

        function restore(id) {
            Swal.fire({
                title: 'Confirmation',
                text: "You will restore this folder. Are you sure you want to continue?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes, I'm sure",
                cancelButtonText: 'No'
            }).then(function(result) {
                if (result.value) {
                    var url = "{{ route('folder/restore', ['id' => ':id']) }}";
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
                            $("#tr_" + id).remove();

                            const countFolder = document.querySelectorAll(".countFolder");
                            const countDocument = document.querySelectorAll(".countDocument");
                            if (countFolder.length == 0 && countDocument.length == 0) {
                                let html =
                                    '<div class="alert alert-danger col-md-12" style="text-align: center;">Document is Empty</div>';
                                $('#listFolder').append(html);
                            }
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
        }

        function restoreDocument(id) {
            Swal.fire({
                title: 'Confirmation',
                text: "You will restore this document. Are you sure you want to continue?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes, I'm sure",
                cancelButtonText: 'No'
            }).then(function(result) {
                if (result.value) {
                    var url = "{{ route('document/restore', ['id' => ':id']) }}";
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
                            $("#tr_document" + id).remove();
                            const countFolder = document.querySelectorAll(".countFolder");
                            const countDocument = document.querySelectorAll(".countDocument");
                            if (countFolder.length == 0 && countDocument.length == 0) {
                                let html =
                                    '<div class="alert alert-danger col-md-12" style="text-align: center;">Document is Empty</div>';
                                $('#listFolder').append(html);
                            }
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
        }

        function properties(id) {
            $('#propertiesModal').modal('show');
            isUpdate = true;
            var url = "{{ route('folder/show', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#nameFolder').text(response.data.name);
                    $('#sizeFolder').text(bytesToSize((response.data.size_sum) ? response.data.size_sum : 0));
                    $('#containsFolder').text(response.data.total_child + " Folder & " + response.data
                        .total_document + " Dokumen");
                    $('#descriptionfolder').text((response.data.description) ? response.data.description : "-");
                    $('#userFolder').text(response.data.deleted_by.name);
                    $('#dateFolder').text(moment(response.data.deleted_at).locale('id').format("DD MMMM YYYY"));
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

        function propertiesDocument(id) {
            $('#propertiesDocumentModal').modal('show');
            isUpdate = true;
            var url = "{{ route('document/show', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#showNameDocument').text(response.data.name);
                    $('#extension').text(response.data.extension);
                    $('#sizeDocument').text(bytesToSize(response.data.size));
                    $('#downloadDocument').text(response.data.download);
                    $('#showDescriptionDocument').text((response.data.description) ? response.data.description :
                        "-");
                    $('#userDocument').text(response.data.deleted_by.name);
                    $('#dateDocument').text(moment(response.data.deleted_at).locale('id').format(
                        "DD MMMM YYYY"));
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

        function bytesToSize(bytes) {
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes == 0) return '0 Byte';
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1000)));
            return Math.round(bytes / Math.pow(1000, i), 2) + ' ' + sizes[i];
        }
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
        window.onload = function() {
            document.addEventListener("contextmenu", function(e) {
                e.preventDefault();
            }, false);
            document.addEventListener("keydown", function(e) {
                //document.onkeydown = function(e) {
                // "I" key
                if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                    disabledEvent(e);
                }
                // "J" key
                if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                    disabledEvent(e);
                }
                // "S" key + macOS
                if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
                    disabledEvent(e);
                }
                // "U" key
                if (e.ctrlKey && e.keyCode == 85) {
                    disabledEvent(e);
                }
                // "F12" key
                if (event.keyCode == 123) {
                    disabledEvent(e);
                }
            }, false);

            function disabledEvent(e) {
                if (e.stopPropagation) {
                    e.stopPropagation();
                } else if (window.event) {
                    window.event.cancelBubble = true;
                }
                e.preventDefault();
                return false;
            }
        };
    </script>
@endpush

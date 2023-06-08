@extends('layouts.master')

@section('title')
    @lang('Document')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            File Manager
        @endslot
        @slot('title')
            Document
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
    <div id="folderModal" class="modal fade" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="folderModalLabel">Form Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('folder/store') }}" id="folderForm" name="folderForm">
                        @csrf
                        <input id="id" type="hidden" class="form-control" name="id">
                        <div class="row mb-4">
                            <label for="name" class="col-sm-3 col-form-label">Folder Name<span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9 validate">
                                <input id="name" type="text" class="form-control" name="name">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9 validate">
                                <textarea class="form-control" rows="3" id="description" name="description"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark waves-effect waves-light btn-sm" id="saveBtn"
                        name="saveBtn">Save</button>
                    <button type="button" class="btn btn-secondary waves-effect btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @if (auth()->user()->can('Create Folder'))
                        <a href="javascript:void(0)" class="btn btn-dark waves-effect waves-light btn-sm"
                            data-bs-toggle="modal" data-bs-target="#folderModal" id="addNew" name="addNew"><i
                                class="mdi mdi-plus-circle mr-1"></i>
                            Add Folder</a>
                    @endif
                </div>
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
                "name": "",
            };
            getFolder();

            function getFolder() {
                var url = "{{ route('folder/getData') }}";
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
                            $('#listFolder').append(folder(data));
                        } else {
                            let html =
                                '<div class="alert alert-danger col-md-12" style="text-align: center;">Document is Empty</div>';
                            $('#listFolder').append(html);
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

            function folder(data) {
                let html = ''
                $.each(data, function(key, value) {
                    let editFolder = '';
                    let deleteFolder = '';
                    let exportFolder = '';
                    if ("{{ Auth::user()->can('Edit Folder') }}") {
                        editFolder = '<a href="javascript:void(0)" onclick="edit(' + value.id +
                            ')"><i class="fa fa-edit" aria-hidden="true"></i>&nbsp;&nbsp;Edit</a>';
                    }
                    if ("{{ Auth::user()->can('Delete Folder') }}") {
                        deleteFolder = '<a href="javascript:void(0)" onclick="remove(' + value.id +
                            ')"><i class="fa fa-trash-alt" aria-hidden="true"></i>&nbsp;&nbsp;Delete</a>';
                    }

                    html += '<div class="col-md-2 countFolder" align="center" id="tr_' + value.id + '">' +
                        '<div class="dropdown" align="left">' +
                        '<div id="popUpMenu' + value.id + '" class="dropdown-content">' +
                        '<a href="/document/child/' + value.id +
                        '"><i class="fa fa-external-link-alt" aria-hidden="true"></i>&nbsp;&nbsp;Open</a>' +
                        editFolder +
                        deleteFolder +
                        '<a href="javascript:void(0)" onclick="properties(' + value.id +
                        ')"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;&nbsp;Properties</a>' +
                        '</div>' +
                        '</div>' +
                        '<img class="card-img-top img-responsive bounce-over" onclick="double_click(' +
                        value.id + ')" oncontextmenu="right_click(' + value.id +
                        ')" style="cursor: pointer;" alt="' + value.name +
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
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                var isValid = $("#folderForm").valid();
                if (isValid) {
                    if (!isUpdate) {
                        var url = "{{ route('folder/store') }}";
                    } else {
                        var url = "{{ route('folder/update') }}";
                    }
                    $('#saveBtn').text('Save...');
                    $('#saveBtn').attr('disabled', true);
                    var formData = new FormData($('#folderForm')[0]);
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
                            $("#listFolder").children().remove();
                            getFolder();
                            $('#folderModal').modal('hide');
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
            $('#folderForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                },
                errorElement: 'em',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.col-md-8').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('#addNew').on('click', function() {
                $('#name').val("");
                $('#description').val("");
                isUpdate = false;
            });
            $('#btnFilter').click(function() {
                request.name = $("#nameFilter").val();
                $("#listFolder").children().remove();
                getFolder();
            });
            $('#btnReset').click(function() {
                request.name = "";
                $('#nameFilter').val("");
                $("#listFolder").children().remove();
                getFolder();
            });
        });

        function double_click(id) {
            window.location.href = "/document/child/" + id;
        }

        function right_click(id) {
            document.getElementById("popUpMenu" + id).classList.toggle("show");
        }

        function edit(id) {
            $('#folderModal').modal('show');
            isUpdate = true;
            var url = "{{ route('folder/show', ['id' => ':id']) }}";
            url = url.replace(':id', id);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(response) {
                    $('#name').val(response.data.name);
                    $('#description').val(response.data.description);
                    $('#id').val(response.data.id);
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

        function remove(id) {
            Swal.fire({
                title: 'Confirmation',
                text: "You will delete this folder. Are you sure you want to continue?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes, I'm sure",
                cancelButtonText: 'No'
            }).then(function(result) {
                if (result.value) {
                    var url = "{{ route('folder/delete', ['id' => ':id']) }}";
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
                            if (countFolder.length == 0) {
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
                        .total_document + " Document");
                    $('#descriptionfolder').text((response.data.description) ? response.data.description : "-");
                    $('#userFolder').text(response.data.created_by.name);
                    $('#dateFolder').text(moment(response.data.created_at).locale('id').format("DD MMMM YYYY"));
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

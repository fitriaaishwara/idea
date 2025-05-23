<?php

namespace App\Http\Controllers\Web;

use App\Events\ExportClient;
use App\Exports\ExportReportClient;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Client;
use App\Models\ClientWin;
use App\Models\FollowUp;
use App\Imports\ClientImport;
use App\Imports\DeleteClientImport;
use App\Imports\UpdateClientImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ClientController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Data Client|Create Client|Edit Client|Delete Client', ['only' => ['index', 'show', 'detail']]);
        $this->middleware('permission:Create Client', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit Client', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Client', ['only' => ['destroy']]);
        $this->middleware('permission:Follow Up Client', ['only' => ['followUp', 'detailFollowUp', 'downloadAttachmentFollowUp', 'getDataFollowUp']]);
    }
    public function index()
    {
        return view('pages.client.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];
        $created_by = $request['user_id'];
        $scope_id = $request['scope_id'];
        if (Auth::user()->can('All Data Client')) {
            $user_id = null;
        } else {
            $user_id = Auth::user()->id;
        }

        $allClient = Client::select()
            ->when($user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            })
            ->where('status', true)
            ->count();

        $client = Client::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? $allClient : $request['length'])
            ->with(['user', 'regency', 'scope_1', 'scope_2', 'scope_3', 'last_follow_up_client'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            })
            ->when($created_by, function ($query, $created_by) {
                return $query->where('user_id', $created_by);
            })
            ->when($scope_id, function ($query, $scope_id) {
                return $query->where(function ($query) use ($scope_id) {
                    $query->where('scope_1', $scope_id)->orWhere('scope_2', $scope_id)->orWhere('scope_3', $scope_id);
                });
            })
            ->where('status', true)
            ->oldest('updated_at')
            ->get();

        $clientCounter = Client::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            })
            ->when($created_by, function ($query, $created_by) {
                return $query->where('user_id', $created_by);
            })
            ->when($scope_id, function ($query, $scope_id) {
                return $query->where(function ($query) use ($scope_id) {
                    $query->where('scope_1', $scope_id)->orWhere('scope_2', $scope_id)->orWhere('scope_3', $scope_id);
                });
            })
            ->where('status', true)
            ->count();

        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => $allClient,
            'recordsFiltered' => $clientCounter,
            'data'            => $client,
        ];
        return $response;
    }
    public function create()
    {
        return view('pages.client.create');
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to create'];
            $create = Client::create([
                'user_id'      => Auth::user()->id,
                'regency_id'   => $request['regency_id'],
                'name'         => strtoupper($request['name']),
                'address'      => $request['address'],
                'scope_1'      => $request['scope_1'],
                'scope_2'      => $request['scope_2'],
                'scope_3'      => $request['scope_3'],
                'service'      => $request['service'],
                'pic'          => $request['pic'],
                'pic_position' => $request['pic_position'],
                'mobile_phone' => $request['mobile_phone'],
                'email'        => $request['email'],
                'created_by'   => Auth::user()->id,
            ]);
            if ($create) {
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully created'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'Data failed to be found'];
            $client = Client::with(['regency.province', 'scope_1', 'scope_2', 'scope_3'])->where('id', $id)->firstOrFail();
            if ($client) {
                $data = ['status' => true, 'message' => 'Data was successfully found', 'data' => $client];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function edit($id)
    {
        $client = Client::find($id);
        if ($client) {
            return view('pages.client.edit', compact('id'));
        } else {
            abort(404);
        }
    }
    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];
            $update = Client::where('id', $request['id'])->update([
                'name'         => strtoupper($request['name']),
                'regency_id'   => $request['regency_id'],
                'address'      => $request['address'],
                'scope_1'      => $request['scope_1'],
                'scope_2'      => $request['scope_2'],
                'scope_3'      => $request['scope_3'],
                'service'      => $request['service'],
                'pic'          => $request['pic'],
                'pic_position' => $request['pic_position'],
                'mobile_phone' => $request['mobile_phone'],
                'email'        => $request['email'],
                'updated_by'   => Auth::user()->id,
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function detail($id)
    {
        $client = Client::find($id);
        if ($client) {
            return view('pages.client.detail', compact('id'));
        } else {
            abort(404);
        }
    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to delete'];

            $delete = Client::where('id', $id)->update([
                'status'     => 0,
            ]);
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function followUp(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to create'];
            $today = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
            if ($request['attachment']) {
                $fileName = Str::random(20);
                $path     = 'follow_up_client/' . $request['client_id'];

                $validator = Validator::make($request->all(), [
                    'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,png,jpg,jpeg,rar,zip|max:10240',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, CSV, PNG, JPG, JPEG, RAR, ZIP.']);
                }
                $extension = $request->file('attachment')->extension();
                Storage::disk('public')->putFileAs($path, $request->file('attachment'), $fileName . "." . $extension);

                $createAttachment = Attachment::create([
                    'path'      => $path,
                    'name'      => $fileName,
                    'extension' => $extension
                ]);
            }

            $create = FollowUp::create([
                'client_id'     => $request['client_id'],
                'attachment_id' => ($request['attachment']) ? $createAttachment->id : null,
                'date'          => $today,
                'type'          => $request['type'],
                'amount'          => ($request['amount'] ? str_replace('.', '', $request['amount']) : null),
                'note'          => $request['note'],
                'created_by'    => Auth::user()->id,
            ]);
            if ($create) {
                $update = Client::where('id', $request['client_id'])->update([
                    'last_followup_at'   => $today,
                ]);
                if ($update) {
                    DB::commit();
                    $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully created'];
                }
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function getDataFollowUp(Request $request)
    {
        $client_id = $request['client_id'];

        $followUpClientCounter = FollowUp::select()
            ->when($client_id, function ($query, $client_id) {
                return $query->where('client_id', $client_id);
            })
            ->where('status', true)
            ->count();

        $followUpClient = FollowUp::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? $followUpClientCounter : $request['length'])
            ->when($client_id, function ($query, $client_id) {
                return $query->where('client_id', $client_id);
            })
            ->where('status', true)
            ->latest('date')
            ->get();

        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => $followUpClientCounter,
            'recordsFiltered' => $followUpClientCounter,
            'data'            => $followUpClient,
        ];
        return $response;
    }
    public function detailFollowUp($id)
    {
        $client = Client::find($id);
        if ($client) {
            return view('pages.client.detail_follow_up', compact('id'));
        } else {
            abort(404);
        }
    }
    public function downloadAttachmentFollowUp($id)
    {

        $attachment  = FollowUp::with(['attachment'])->where('id', $id)->first();

        $path      = public_path('storage/' . $attachment->attachment->path);
        $name      = $attachment->attachment->name;
        $extension = $attachment->attachment->extension;
        $fileName  = $name . '.' . $extension;

        return response()->download($path . '/' . $name . '.' . $extension, $fileName);
    }
    public function win(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];
            $today = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
            if ($request['attachment']) {
                $fileName = Str::random(20);
                $path     = 'client_win/' . $request['client_id'];

                $validator = Validator::make($request->all(), [
                    'attachment' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,png,jpg,jpeg,rar,zip|max:10240',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, CSV, PNG, JPG, JPEG, RAR, ZIP.']);
                }
                $extension = $request->file('attachment')->extension();
                Storage::disk('public')->putFileAs($path, $request->file('attachment'), $fileName . "." . $extension);

                $createAttachment = Attachment::create([
                    'path'      => $path,
                    'name'      => $fileName,
                    'extension' => $extension
                ]);
            }

            $create = ClientWin::create([
                'client_id'     => $request['client_id'],
                'attachment_id' => ($request['attachment']) ? $createAttachment->id : null,
                'date'          => $today,
                'amount'          => ($request['amount'] ? str_replace('.', '', $request['amount']) : null),
                'note'          => $request['note'],
                'created_by'    => Auth::user()->id,
            ]);
            if ($create) {
                $update = Client::where('id', $request['client_id'])->update([
                    'is_win'   => true,
                ]);
                if ($update) {
                    DB::commit();
                    $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully updated'];
                }
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'mimes:xls,xlsx|max:10240',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format XLS, XLSX']);
        } else {
            $import = new ClientImport();
            Excel::import($import, $request->file('file'));
            return $import->getResponse();
        }
    }
    public function importBouncing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'mimes:xls,xlsx|max:10240',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format XLS, XLSX']);
        } else {
            $import = new DeleteClientImport();
            Excel::import($import, $request->file('file'));
            return $import->getResponse();
        }
    }
    public function importUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'mimes:xls,xlsx|max:10240',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format XLS, XLSX']);
        } else {
            $import = new UpdateClientImport();
            Excel::import($import, $request->file('file'));
            return $import->getResponse();
        }
    }
    public function export(Request $request)
    {

        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to export'];

            $user_id = $request['user_id'];

            $user = User::Where('id', $user_id)->first();
            $report_name = 'Data Client ' . $user->name . '.xlsx';
            $url = asset('storage/client/' . $report_name);
            $export = ExportClient::dispatch($user);
            if ($export) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data exported successfully', 'url' => $url];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}

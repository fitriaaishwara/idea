<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Client;
use App\Models\FollowUp;
use App\Models\ScheduleEmail;
use App\Models\ScheduleEmailScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ScheduleEmailController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Data Schedule Email|Create Schedule Email|Edit Schedule Email|Delete Schedule Email', ['only' => ['index', 'show', 'detail', 'totalDetail']]);
        $this->middleware('permission:Create Schedule Email', ['only' => ['create', 'store']]);
        $this->middleware('permission:Edit Schedule Email', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Delete Schedule Email', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('pages.schedule_email.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];
        if (Auth::user()->can('All Data Schedule Email')) {
            $user_id = null;
        } else {
            $user_id = Auth::user()->id;
        }

        $allData = ScheduleEmail::select()
            ->when($user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            })
            ->where('status', true)
            ->count();

        $data = ScheduleEmail::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? $allData : $request['length'])
            ->with(['user', 'schedule_email_scopes.scope'])
            ->when($keyword, function ($query, $keyword) {
                return $query->whereHas('user', function ($q) use ($keyword) {
                    return $q->where('name', 'like', '%' . $keyword . '%');
                })->orWhere('subject', 'like', '%' . $keyword . '%');
            })
            ->when($user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            })
            ->where('status', true)
            ->latest('date')
            ->get();

        $dataCounter = ScheduleEmail::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->whereHas('user', function ($q) use ($keyword) {
                    return $q->where('name', 'like', '%' . $keyword . '%');
                })->orWhere('subject', 'like', '%' . $keyword . '%');
            })
            ->when($user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            })
            ->where('status', true)
            ->count();

        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => $allData,
            'recordsFiltered' => $dataCounter,
            'data'            => $data,
        ];
        return $response;
    }
    public function create()
    {
        return view('pages.schedule_email.create');
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to create'];
            $user_id = Auth::user()->id;
            $scope = $request['scope_id'];
            $countSchedule = ScheduleEmail::where('user_id', $user_id)->whereDate('date', $request['date'])->where('status', true)->count();
            if ($countSchedule >= 5) {
                return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum 5 email subjects per day']);
            }
            $countClient = Client::select()
                ->where('email', 'like', '%@%')
                ->where('user_id', $user_id)
                ->where('status', true)
                ->where(function ($query) use ($scope) {
                    $query->whereIn('scope_1', $scope)->orWhereIn('scope_2', $scope)->orWhereIn('scope_3', $scope);
                })
                ->count();

            $countFollowUpClient = FollowUp::select()
                ->whereHas('client', function ($q) use ($user_id, $scope) {
                    return $q->where('user_id', $user_id)
                        ->where('status', true)
                        ->where('email', 'like', '%@%')
                        ->where(function ($query) use ($scope) {
                            $query->whereIn('scope_1', $scope)->orWhereIn('scope_2', $scope)->orWhereIn('scope_3', $scope);
                        });
                })
                ->where('note', $request['note'])
                ->count();

            $countClientNonEmail = $countClient - $countFollowUpClient;

            $countSchedule = ScheduleEmail::select()
                ->where('subject', $request['subject'])
                ->where('user_id', $request['user_id'])
                ->where('schedule_status', 1)
                ->where('status', true)
                ->count();

            $countSchedule = $countSchedule * 100;

            if ($countClientNonEmail <= $countSchedule) {
                return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'Client with that scope has been sent an email']);
            }

            if ($request->file('attachment')) {
                $fileName = time();
                $path     = 'schedule_email';

                $validator = Validator::make($request->all(), [
                    'attachment' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,png,jpg,jpeg,rar,zip|max:10240',
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

            $create = ScheduleEmail::create([
                'user_id'           => Auth::user()->id,
                'attachment_id'     => ($request['attachment']) ? $createAttachment : null,
                'date'              => $request['date'],
                'note'              => $request['note'],
                'total_client'      => $request['total_client'],
                'is_html'           => $request['is_html'],
                'subject'           => $request['subject'],
                'body'              => ($request['is_html']) ? $request['body_html'] : $request['body'],
                'created_by'        => Auth::user()->id,
            ]);

            if ($create) {
                foreach ($request['scope_id'] as $key => $value) {
                    $createScheduleEmailScope = ScheduleEmailScope::create([
                        'schedule_email_id'     => $create->id,
                        'scope_id'              => $value
                    ]);
                }
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
            $schedule = ScheduleEmail::with(['schedule_email_scopes.scope'])->where('id', $id)->firstOrFail();
            if ($schedule) {
                $data = ['status' => true, 'message' => 'Data was successfully found', 'data' => $schedule];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function detail($id)
    {
        $schedule = ScheduleEmail::find($id);
        if ($schedule) {
            return view('pages.schedule_email.detail', compact('id'));
        } else {
            abort(404);
        }
    }
    public function edit($id)
    {
        $schedule = ScheduleEmail::find($id);
        if ($schedule) {
            return view('pages.schedule_email.edit', compact('id'));
        } else {
            abort(404);
        }
    }
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];
            if ($request->file('attachment')) {
                $fileName = time();
                $path     = 'schedule_email';

                $validator = Validator::make($request->all(), [
                    'attachment' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,png,jpg,jpeg,rar,zip|max:10240',
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
            } else {
                $schedule = ScheduleEmail::where('id', $request['id'])->first();
                $attachment_id = $schedule['attachment_id'];
            }
            $update = ScheduleEmail::where('id', $request['id'])->update([
                'attachment_id' => ($request['attachment']) ? $createAttachment->id : $attachment_id,
                'date'          => $request['date'],
                'total_client'  => $request['total_client'],
                'note'          => $request['note'],
                'is_html'       => $request['is_html'],
                'subject'       => $request['subject'],
                'body'          => ($request['is_html']) ? $request['body_html'] : $request['body'],
                'updated_by'    => Auth::user()->id
            ]);
            if ($update) {
                $delete = ScheduleEmailScope::where('schedule_email_id', $request['id'])->delete();
                if ($delete) {
                    foreach ($request['scope_id'] as $key => $value) {
                        $createScheduleEmailScope = ScheduleEmailScope::create([
                            'schedule_email_id' => $request['id'],
                            'scope_id'          => $value
                        ]);
                    }
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
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to delete'];

            $delete = ScheduleEmail::where('id', $id)->update([
                'status' => false,
            ]);
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function downloadAttachment($id)
    {
        $attachment  = ScheduleEmail::with(['attachment'])->where('id', $id)->first();

        $path      = public_path('storage/' . $attachment->attachment->path);
        $name      = $attachment->attachment->name;
        $extension = $attachment->attachment->extension;
        $fileName  = $name . '.' . $extension;

        return response()->download($path . '/' . $name . '.' . $extension, $fileName);
    }
    public function totalClient(Request $request)
    {
        $user_id = $request['user_id'];
        $scope = $request['scope'];

        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];
            $total = Client::where('user_id', $user_id)->where('status', true)->whereIn('scope_1', $scope)->orWhereIn('scope_2', $scope)->orWhereIn('scope_3', $scope)->count();
            $data = ['status' => true, 'message' => 'Data was successfully found', 'data' => $total];
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}

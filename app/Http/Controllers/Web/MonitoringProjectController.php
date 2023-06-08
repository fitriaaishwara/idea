<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\MonitoringProject;
use App\Models\MonitoringProjectDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MonitoringProjectController extends Controller
{
    public function index()
    {
        return view('pages.monitoring_project.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];
        $progress = $request['progress'];
        $project_status = $request['project_status'];
        if (Auth::user()->can('All Data Monitoring Project')){
            $user_id = null;
        }else{
            $user_id = Auth::user()->id;
        }
        $allProject = MonitoringProject::where('status', true)
            ->whereHas('monitoring_client', function ($q) {
                return $q->where('status', true);
            })
            ->when($user_id, function ($query) use ($user_id) {
                return $query->where(function ($query) use ($user_id) {
                    return $query->whereHas('monitoring_project_details', function ($query) use($user_id) {
                        return $query->whereHas('monitoring_project_detail_pic', function ($q) use($user_id) {
                            return $q->where('user_id', $user_id);
                        });
                    })->orWhere('created_by', $user_id);
                });
            })
            ->whereHas('next_monitoring_project_detail')
            ->count();
        $monitoringProject = MonitoringProject::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? $allProject : $request['length'])
            ->withCount([
                'monitoring_project_details AS progress' => function ($query) {
                    $query->select(DB::raw("SUM(percentage) as percentage"))->where('is_done', true);
                }
            ])
            ->withCount([
                'monitoring_project_meetings as meeting_count' => function ($query) {
                    $query->where('status', true);
            }])
            ->with(['monitoring_client', 'next_monitoring_project_detail.monitoring_project_detail_pic.user'])
            ->when($progress, function ($query, $progress) {
                return $query->orderBy('progress', $progress);
            })
            ->whereHas('monitoring_client', function ($q) {
                return $q->where('status', true);
            })
            ->when($user_id, function ($query) use ($user_id) {
                return $query->where(function ($query) use ($user_id) {
                    return $query->whereHas('monitoring_project_details', function ($query) use($user_id) {
                        return $query->whereHas('monitoring_project_detail_pic', function ($q) use($user_id) {
                            return $q->where('user_id', $user_id);
                        });
                    })->orWhere('created_by', $user_id);
                });
            })
            ->whereHas('next_monitoring_project_detail')
            ->where('status', true)
            ->when($project_status, function ($query, $project_status) {
                return $query->where('project_status', $project_status);
            })
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->whereHas('monitoring_client', function ($q) use ($keyword) {
                        return $q->where('name', 'like', '%' . $keyword . '%');
                    })->orWhere('name', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->get();

        $monitoringProjectCounter = MonitoringProject::select()
            ->whereHas('monitoring_client', function ($q) {
                return $q->where('status', true);
            })
            ->when($user_id, function ($query) use ($user_id) {
                return $query->where(function ($query) use ($user_id) {
                    return $query->whereHas('monitoring_project_details', function ($query) use($user_id) {
                        return $query->whereHas('monitoring_project_detail_pic', function ($q) use($user_id) {
                            return $q->where('user_id', $user_id);
                        });
                    })->orWhere('created_by', $user_id);
                });
            })
            ->whereHas('next_monitoring_project_detail')
            ->where('status', true)
            ->when($project_status, function ($query, $project_status) {
                return $query->where('project_status', $project_status);
            })
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->whereHas('monitoring_client', function ($q) use ($keyword) {
                        return $q->where('name', 'like', '%' . $keyword . '%');
                    })->orWhere('name', 'like', '%' . $keyword . '%');
                });
            })
            ->count();


        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => $allProject,
            'recordsFiltered' => $monitoringProjectCounter,
            'data'            => $monitoringProject,
        ];
        return $response;
    }
    public function detail($id)
    {
        $project = MonitoringProject::find($id);
        if ($project) {
            return view('pages.monitoring_project.detail', compact('id'));
        } else {
            abort(404);
        }
    }
    public function create()
    {
        return view('pages.monitoring_project.create');
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to create'];
            $total = MonitoringProjectDetail::where('temporary_id', $request['temporary_id'])->sum('percentage');
            if ($total != 100) {
                if ($total < 100) {
                    $data = ['status' => false, 'code' => 'EC001', 'message' => 'Total activity less than 100%'];
                    return $data;
                } else {
                    $data = ['status' => false, 'code' => 'EC001', 'message' => 'Total activity more than 100%'];
                    return $data;
                }
            }
            $create = MonitoringProject::create([
                'monitoring_client_id' => $request['monitoring_client_id'],
                'project_status'       => $request['project_status'],
                'name'                 => $request['name'],
                'description'          => $request['description'],
                'start_date'           => $request['start_date'],
                'end_date'             => $request['end_date'],
                'note'                 => $request['note'],
                'created_by'           => Auth::user()->id
            ]);

            if ($create) {
                $updateMonitoringProjectDetail = MonitoringProjectDetail::where('temporary_id', $request['temporary_id'])->update([
                    'monitoring_project_id' => ($request['monitoring_project_id']) ? $request['monitoring_project_id'] : $create->id
                ]);
                if ($updateMonitoringProjectDetail) {
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
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'Data failed to be found'];
            $monitoringProject = MonitoringProject::with(['monitoring_client'])->where('id', $id)->firstOrFail();
            if ($monitoringProject) {
                $data = ['status' => true, 'message' => 'Data was successfully found', 'data' => $monitoringProject];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function edit($id)
    {
        $project = MonitoringProject::find($id);
        if ($project) {
            return view('pages.monitoring_project.edit', compact('id'));
        } else {
            abort(404);
        }
    }
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];
            $total = MonitoringProjectDetail::where('monitoring_project_id', $request['id'])->sum('percentage');
            if ($total != 100) {
                if ($total < 100) {
                    $data = ['status' => false, 'code' => 'EC001', 'message' => 'Total activity less than 100%'];
                    return $data;
                } else {
                    $data = ['status' => false, 'code' => 'EC001', 'message' => 'Total activity more than 100%'];
                    return $data;
                }
            }
            $update = MonitoringProject::where('id', $request['id'])->update([
                'monitoring_client_id' => $request['monitoring_client_id'],
                'project_status'       => $request['project_status'],
                'name'                 => $request['name'],
                'description'          => $request['description'],
                'start_date'           => $request['start_date'],
                'end_date'             => $request['end_date'],
                'note'                 => $request['note'],
                'updated_by'           => Auth::user()->id
            ]);

            if ($update) {
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully updated'];
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

            $delete = MonitoringProject::where('id', $id)->update([
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
    public function activity(Request $request)
    {
        $today = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];
            $fileName = Str::random(20);
            $path     = 'monitoring_project/' . $request['monitoring_project_id'];

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

            $create = MonitoringProjectDetail::where('id', $request['id'])->update([
                'attachment_id' => $createAttachment->id,
                'actual_date'   => $today,
                'comment'       => $request['comment'],
                'is_done'       => true,
                'updated_by'    => Auth::user()->id,
            ]);
            if ($create) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function totalActivity($id)
    {

        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];
            $activity = MonitoringProjectDetail::where('monitoring_project_id', $id)->orWhere('temporary_id', $id)->sum('percentage');
            $data = ['status' => true, 'message' => 'Data was successfully found', 'data' => $activity];
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function meeting($id)
    {
        $project = MonitoringProject::find($id);
        if ($project) {
            return view('pages.monitoring_project.meeting.index', compact('id'));
        } else {
            abort(404);
        }
    }
}

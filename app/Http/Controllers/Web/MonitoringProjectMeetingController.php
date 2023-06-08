<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MonitoringProject;
use App\Models\MonitoringProjectMeeting;
use App\Models\MonitoringProjectMeetingParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MonitoringProjectMeetingController extends Controller
{
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];
        $monitoring_project_id = $request['monitoring_project_id'];

        $allData = MonitoringProjectMeeting::select()
            ->with(['monitoring_project', 'monitoring_project_detail_pic.user'])
            ->when($monitoring_project_id, function ($query, $monitoring_project_id) {
                return $query->where('monitoring_project_id', $monitoring_project_id);
            })
            ->where('status', true)
            ->count();

        $data = MonitoringProjectMeeting::select()
            ->with(['monitoring_project', 'monitoring_project_meeting_participants'])
            ->when($monitoring_project_id, function ($query, $monitoring_project_id) {
                return $query->where('monitoring_project_id', $monitoring_project_id);
            })
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('agenda', 'like', '%' . $keyword . '%')->orWhere('location', 'like', '%' . $keyword . '%');
                });
            })
            ->where('status', true)
            ->latest()
            ->get();

        $dataCounter = MonitoringProjectMeeting::select()
            ->with(['monitoring_project', 'monitoring_project_meeting_participants'])
            ->when($monitoring_project_id, function ($query, $monitoring_project_id) {
                return $query->where('monitoring_project_id', $monitoring_project_id);
            })
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('agenda', 'like', '%' . $keyword . '%')->orWhere('location', 'like', '%' . $keyword . '%');
                });
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
    public function create($id)
    {
        $project = MonitoringProject::find($id);
        if ($project) {
            return view('pages.monitoring_project.meeting.create', compact('id'));
        } else {
            abort(404);
        }
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to create'];
            $fileName = Str::random(20);
            $path     = 'monitoring_project/' . $request['monitoring_project_id'];

            $validator = Validator::make($request->all(), [
                'mom' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,png,jpg,jpeg,rar,zip|max:10240',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, CSV, PNG, JPG, JPEG, RAR, ZIP.']);
            }
            $extension = $request->file('mom')->extension();
            Storage::disk('public')->putFileAs($path, $request->file('mom'), $fileName . "." . $extension);

            $create = MonitoringProjectMeeting::create([
                'monitoring_project_id' => $request['monitoring_project_id'],
                'agenda'                => $request['agenda'],
                'date'                  => $request['date'],
                'start_time'            => $request['start_time'],
                'end_time'              => $request['end_time'],
                'location'              => $request['location'],
                'mom'                   => $fileName . "." . $extension,
                'note'                  => $request['note'],
                'created_by'            => Auth::user()->id
            ]);

            if ($create) {
                $updateMonitoringProjectMeetingParticipant = MonitoringProjectMeetingParticipant::where('temporary_id', $request['temporary_id'])->update([
                    'monitoring_project_meeting_id' => ($request['monitoring_project_meeting_id']) ? $request['monitoring_project_meeting_id'] : $create->id
                ]);
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
            $data = MonitoringProjectMeeting::where('id', $id)->firstOrFail();
            if ($data) {
                $data = ['status' => true, 'message' => 'Data was successfully found', 'data' => $data];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function detail($id)
    {
        $data = MonitoringProjectMeeting::find($id);
        if ($data) {
            $monitoring_project_id = $data->monitoring_project_id;
            return view('pages.monitoring_project.meeting.detail', compact('id','monitoring_project_id'));
        } else {
            abort(404);
        }
    }
    public function edit($id)
    {
        $data = MonitoringProjectMeeting::find($id);
        if ($data) {
            $monitoring_project_id = $data->monitoring_project_id;
            return view('pages.monitoring_project.meeting.edit', compact('id','monitoring_project_id'));
        } else {
            abort(404);
        }
    }
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];
            if ($request->file('mom')) {
                $fileName = Str::random(20);
                $path     = 'monitoring_project/' . $request['monitoring_project_id'];

                $validator = Validator::make($request->all(), [
                    'mom' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,png,jpg,jpeg,rar,zip|max:10240',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, CSV, PNG, JPG, JPEG, RAR, ZIP.']);
                }
                $extension = $request->file('mom')->extension();
                Storage::disk('public')->putFileAs($path, $request->file('mom'), $fileName . "." . $extension);
                $mom = $fileName . "." . $extension;
            } else {
                $data = MonitoringProjectMeeting::where('id', $request['id'])->first();
                $mom = $data->mom;
            }

            $update = MonitoringProjectMeeting::where('id', $request['id'])->update([
                'agenda'        => $request['agenda'],
                'date'          => $request['date'],
                'start_time'    => $request['start_time'],
                'end_time'      => $request['end_time'],
                'location'      => $request['location'],
                'mom'           => $mom,
                'note'          => $request['note'],
                'updated_by'    => Auth::user()->id
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

            $delete = MonitoringProjectMeeting::where('id', $id)->update([
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
    public function download($id)
    {
        $data  = MonitoringProjectMeeting::where('id', $id)->first();

        $path      = public_path('storage/monitoring_project/' . $data->monitoring_project_id);
        $fileName  = $data->mom;

        return response()->download($path . '/' . $fileName, $fileName);
    }
}

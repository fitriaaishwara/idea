<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MonitoringProjectMeetingParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonitoringProjectMeetingParticipantController extends Controller
{
    public function getData(Request $request)
    {
        $temporary_id          = $request['temporary_id'];
        $monitoring_project_meeting_id = $request['monitoring_project_meeting_id'];

        $data = MonitoringProjectMeetingParticipant::select()
            ->when($temporary_id, function ($query, $temporary_id) {
                return $query->where('temporary_id', $temporary_id);
            })
            ->when($monitoring_project_meeting_id, function ($query, $monitoring_project_meeting_id) {
                return $query->where('monitoring_project_meeting_id', $monitoring_project_meeting_id);
            })
            ->latest()
            ->get();

        $response = [
            'status' => true,
            'data'   => $data,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to create'];
            $create = MonitoringProjectMeetingParticipant::create([
                'monitoring_project_meeting_id' => ($request['monitoring_project_meeting_id']) ? $request['monitoring_project_meeting_id'] : null,
                'temporary_id'                  => ($request['temporary_id']) ? $request['temporary_id'] : null,
                'name'                          => $request['name'],
                'role'                          => $request['role'],
                'created_by'                    => Auth::user()->id
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
            $data = MonitoringProjectMeetingParticipant::where('id', $id)->firstOrFail();
            if ($data) {
                $data = ['status' => true, 'message' => 'Data was successfully found', 'data' => $data];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];
            $update = MonitoringProjectMeetingParticipant::where('id', $request['id'])->update([
                'name'          => $request['name'],
                'role'          => $request['role'],
                'updated_by'    => Auth::user()->id,
            ]);
            if ($update) {
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to delete'];

            $delete = MonitoringProjectMeetingParticipant::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}

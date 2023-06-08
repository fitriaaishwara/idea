<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MonitoringProjectDetail;
use App\Models\MonitoringProjectDetailDate;
use App\Models\MonitoringProjectDetailPIC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class MonitoringProjectDetailController extends Controller
{
    public function getData(Request $request)
    {
        $temporary_id          = $request['temporary_id'];
        $monitoring_project_id = $request['monitoring_project_id'];

        $monitoringProjectDetails = MonitoringProjectDetail::select()
            ->with(['monitoring_project', 'monitoring_project_detail_pic.user', 'monitoring_project_detail_dates'])
            ->when($temporary_id, function ($query, $temporary_id) {
                return $query->where('temporary_id', $temporary_id);
            })
            ->when($monitoring_project_id, function ($query, $monitoring_project_id) {
                return $query->where('monitoring_project_id', $monitoring_project_id);
            })
            ->oldest('order')
            ->get();

        $response = [
            'status' => true,
            'data'   => $monitoringProjectDetails,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to create'];
            $cekData = MonitoringProjectDetail::where('monitoring_project_id', $request['monitoring_project_id'])->orWhere('temporary_id', $request['temporary_id'])->latest('order')->first();
            if ($cekData) {
                $order = $cekData->order + 1;
            } else {
                $order = 1;
            }
            $create = MonitoringProjectDetail::create([
                'monitoring_project_id' => ($request['monitoring_project_id']) ? $request['monitoring_project_id'] : null,
                'temporary_id'          => ($request['temporary_id']) ? $request['temporary_id'] : null,
                'order'                 => $order,
                'activity'              => $request['activity'],
                'description'           => $request['description'],
                'percentage'            => $request['percentage'],
                'plan_date'             => $request['plan_date'],
                'created_by'            => Auth::user()->id
            ]);
            if ($create) {
                foreach ($request['user_id'] as $key => $value) {
                    MonitoringProjectDetailPIC::create([
                        'monitoring_projects_detail_id' => $create->id,
                        'user_id'                      => $value,
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
            $monitoringProjectDetail = MonitoringProjectDetail::with(['monitoring_project_detail_pic.user', 'monitoring_project_detail_dates'])->where('id', $id)->firstOrFail();
            if ($monitoringProjectDetail) {
                $data = ['status' => true, 'message' => 'Data was successfully found', 'data' => $monitoringProjectDetail];
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
            $update = MonitoringProjectDetail::where('id', $request['id'])->update([
                'monitoring_project_id' => ($request['monitoring_project_id']) ? $request['monitoring_project_id'] : null,
                'temporary_id'          => ($request['temporary_id']) ? $request['temporary_id'] : null,
                'activity'              => $request['activity'],
                'description'           => $request['description'],
                'percentage'            => $request['percentage'],
                'plan_date'             => $request['plan_date'],
                'updated_by'            => Auth::user()->id,
            ]);
            if ($update) {
                MonitoringProjectDetailPIC::where('monitoring_projects_detail_id', $request['id'])->delete();
                foreach ($request['user_id'] as $key => $value) {
                    MonitoringProjectDetailPIC::create([
                        'monitoring_projects_detail_id' => $request['id'],
                        'user_id'                      => $value,
                    ]);
                }
                if ($request['monitoring_project_id'] != null && $request['revise_date'] != null) {
                    MonitoringProjectDetailDate::create([
                        'monitoring_projects_detail_id' => $request['id'],
                        'user_id'                      => Auth::user()->id,
                        'revise_date'                  => $request['revise_date'],
                        'revise_comment'               => $request['revise_comment'],
                    ]);
                }
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

            $delete = MonitoringProjectDetail::where('id', $id)->delete();
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

        $attachment  = MonitoringProjectDetail::with(['attachment'])->where('id', $id)->first();

        $path      = public_path('storage/' . $attachment->attachment->path);
        $name      = $attachment->attachment->name;
        $extension = $attachment->attachment->extension;
        $fileName  = $name . '.' . $extension;

        return response()->download($path . '/' . $name . '.' . $extension, $fileName);
    }
    public function move(Request $request)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $data           = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to move'];
            $type = $request['type'];
            $id = $request['id'];
            $order = $request['order'];
            $monitoring_project_id = $request['monitoring_project_id'];
            $temporary_id = $request['temporary_id'];
            if ($type == 'Up') {
                $oldData = MonitoringProjectDetail::select()
                    ->where('order', '<', $order)
                    ->when($temporary_id, function ($query, $temporary_id) {
                        return $query->where('temporary_id', $temporary_id);
                    })
                    ->when($monitoring_project_id, function ($query, $monitoring_project_id) {
                        return $query->where('monitoring_project_id', $monitoring_project_id);
                    })
                    ->orderBy('order', 'desc')
                    ->first();
            } else {
                $oldData = MonitoringProjectDetail::select()
                    ->where('order', '>', $order)
                    ->when($temporary_id, function ($query, $temporary_id) {
                        return $query->where('temporary_id', $temporary_id);
                    })
                    ->when($monitoring_project_id, function ($query, $monitoring_project_id) {
                        return $query->where('monitoring_project_id', $monitoring_project_id);
                    })
                    ->orderBy('order', 'asc')
                    ->first();
            }
            $newOrder = $oldData->order;
            $updateOld = MonitoringProjectDetail::where('id', $oldData->id)->update([
                'order' => $order,
                'updated_by' => Auth::user()->id,
            ]);
            if ($updateOld) {
                $update = MonitoringProjectDetail::where('id', $id)->update([
                    'order' => $newOrder,
                    'updated_by' => Auth::user()->id
                ]);

                if ($update) {
                    DB::commit();
                    $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully moved'];
                }
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}

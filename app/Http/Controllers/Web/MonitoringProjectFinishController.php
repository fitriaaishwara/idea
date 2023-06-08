<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MonitoringProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringProjectFinishController extends Controller
{
    public function index()
    {
        return view('pages.monitoring_project_finish.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $allProject = MonitoringProject::where('status', true)
            ->whereHas('monitoring_client', function($q){
                return $q->where('status', true);
            })
            ->whereDoesntHave('next_monitoring_project_detail')
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
            ->with(['monitoring_client','next_monitoring_project_detail.monitoring_project_detail_pic'])
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('monitoring_client', function($q) use($keyword){
                    return $q->where('name', 'like', '%'. $keyword . '%');
                })->orWhere('name', 'like', '%'. $keyword . '%');
            })
            ->whereHas('monitoring_client', function($q){
                return $q->where('status', true);
            })
            ->whereDoesntHave('next_monitoring_project_detail')
            ->where('status', true)
            ->latest()
            ->get();

        $monitoringProjectCounter = MonitoringProject::select()
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('monitoring_client', function($q) use($keyword){
                    return $q->where('name', 'like', '%'. $keyword . '%');
                })->orWhere('name', 'like', '%'. $keyword . '%');
            })
            ->whereHas('monitoring_client', function($q){
                return $q->where('status', true);
            })
            ->whereDoesntHave('next_monitoring_project_detail')
            ->where('status', true)
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
            return view('pages.monitoring_project_finish.detail', compact('id'));
        }else{
            abort(404);
        }
    }

    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'Data failed to be found'];
            $monitoringProject = MonitoringProject::with(['monitoring_client'])->where('id', $id)->firstOrFail();
            if ($monitoringProject) {
                $data = ['status'=> true, 'message'=> 'Data was successfully found','data'=> $monitoringProject];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. '.$ex];
        }
        return $data;
    }
    public function meeting($id)
    {
        $project = MonitoringProject::find($id);
        if ($project) {
            return view('pages.monitoring_project_finish.meeting.index', compact('id'));
        } else {
            abort(404);
        }
    }

}

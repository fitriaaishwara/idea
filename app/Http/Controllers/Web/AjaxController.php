<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\Schedule;
use App\Models\ScheduleAccreditation;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getDataProvince(Request $request){
        $keyword = $request['searchkey'];

        $provinces = Province::select()
        ->offset($request['start'])
        ->limit(($request['length'] == -1) ? Province::count() : $request['length'])
        ->when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%'. $keyword . '%');
        })
        ->get();

        $provincesCounter = Province::select()
        ->when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%'. $keyword . '%');
            })
        ->count();
        $response = [
            'status'          => true,
            'code'            => '',
            'message'         => '',
            'draw'            => $request['draw'],
            'recordsTotal'    => Province::count(),
            'recordsFiltered' => $provincesCounter,
            'data'            => $provinces,
        ];
        return $response;
    }
    public function getDataRegency(Request $request){
        $keyword = $request['searchkey'];

        $regencies = Regency::select()
        ->offset($request['start'])
        ->limit(($request['length'] == -1) ? Regency::count() : $request['length'])
        ->when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%'. $keyword . '%');
        })
        ->when($request['province_id'], function ($query, $keyword) {
            return $query->where('province_id', $keyword);
        })
        ->get();

        $regenciesCounter = Regency::select()
        ->when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%'. $keyword . '%');
            })
        ->when($request['province_id'], function ($query, $keyword) {
            return $query->where('province_id', $keyword);
        })
        ->count();
        $response = [
            'status'          => true,
            'code'            => '',
            'message'         => '',
            'draw'            => $request['draw'],
            'recordsTotal'    => Regency::count(),
            'recordsFiltered' => $regenciesCounter,
            'data'            => $regencies,
        ];
        return $response;
    }
    public function getDataDistrict(Request $request){
        $keyword = $request['searchkey'];

        $districts = District::select()
        ->offset($request['start'])
        ->limit(($request['length'] == -1) ? District::count() : $request['length'])
        ->when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%'. $keyword . '%');
        })
        ->when($request['regency_id'], function ($query, $keyword) {
            return $query->where('regency_id', $keyword);
        })
        ->get();

        $districtsCounter = District::select()
        ->when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%'. $keyword . '%');
            })
        ->when($request['regency_id'], function ($query, $keyword) {
            return $query->where('regency_id', $keyword);
        })
        ->count();
        $response = [
            'status'          => true,
            'code'            => '',
            'message'         => '',
            'draw'            => $request['draw'],
            'recordsTotal'    => Regency::count(),
            'recordsFiltered' => $districtsCounter,
            'data'            => $districts,
        ];
        return $response;
    }
    public function getDataVillage(Request $request){
        $keyword = $request['searchkey'];

        $villages = Village::select()
        ->offset($request['start'])
        ->limit(($request['length'] == -1) ? Village::count() : $request['length'])
        ->when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%'. $keyword . '%');
        })
        ->when($request['district_id'], function ($query, $keyword) {
            return $query->where('district_id', $keyword);
        })
        ->get();

        $villagesCounter = Village::select()
        ->when($keyword, function ($query, $keyword) {
            return $query->where('name', 'like', '%'. $keyword . '%');
            })
        ->when($request['district_id'], function ($query, $keyword) {
            return $query->where('district_id', $keyword);
        })
        ->count();
        $response = [
            'status'          => true,
            'code'            => '',
            'message'         => '',
            'draw'            => $request['draw'],
            'recordsTotal'    => Regency::count(),
            'recordsFiltered' => $villagesCounter,
            'data'            => $villages,
        ];
        return $response;
    }
    public function getDataSchedule(Request $request)
    {

        $schedules = Schedule::select()
            ->with(['standardSchedule','purposeSchedule', 'schedule_users.user'])
            ->where('status', true)
            ->get();

        $response = [
            'status'          => true,
            'data'            => $schedules,
        ];
        return $response;
    }
    public function getDataScheduleAccreditation(Request $request)
    {

        $schedules = ScheduleAccreditation::select()
            ->with(['standardSchedule','purposeSchedule', 'scheduleAccreditationUsers.user'])
            ->where('status', true)
            ->get();

        $response = [
            'status'          => true,
            'data'            => $schedules,
        ];
        return $response;
    }
}

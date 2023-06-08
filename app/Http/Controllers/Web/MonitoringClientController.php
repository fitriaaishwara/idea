<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class MonitoringClientController extends Controller
{
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $monitoringClient = Client::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? Client::where('status', true)->count() : $request['length'])
            ->with(['regency'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%'. $keyword . '%');
            })
            ->where('status', true)
            ->latest()
            ->get();

        $monitoringClientCounter = Client::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%'. $keyword . '%');
            })
            ->where('status', true)
            ->count();

        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => Client::where('status', true)->count(),
            'recordsFiltered' => $monitoringClientCounter,
            'data'            => $monitoringClient,
        ];
        return $response;
    }
}

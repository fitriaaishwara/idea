<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FollowUp;
use App\Models\ClientWin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\ExportReportFollowUpClient;
use App\Imports\ClientImport;
use App\Models\Attachment;
use Dotenv\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class FollowUpClientController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Follow Up Client', ['only' => ['index']]);
    }
    public function index()
    {
        return view('pages.followup.index');
    }

    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];
        $created_by = $request['user_id'];
        $type = $request['type'];
        $date = $request['date'];
        if (Auth::user()->can('All Data Client')) {
            $user_id = null;
        } else {
            $user_id = Auth::user()->id;
        }

        $allData = FollowUp::select()
            ->when($user_id, function ($query, $user_id) {
                $query->whereHas('client', function ($query) use ($user_id) {
                    return $query->where('user_id', $user_id);
                });
            })
            ->where('status', true)
            ->count();

        $data = FollowUp::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? $allData : $request['length'])
            ->with(['client.regency', 'createdBy'])
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('client', function ($q) use ($keyword) {
                    return $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->when($user_id, function ($query, $user_id) {
                $query->whereHas('client', function ($query) use ($user_id) {
                    return $query->where('user_id', $user_id);
                });
            })
            ->when($created_by, function ($query, $created_by) {
                return $query->where('created_by', $created_by);
            })
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($date, function ($query, $date) {
                return $query->whereDate('date', $date);
            })
            ->where('status', true)
            ->latest('created_at')
            ->get();

        $dataCounter = FollowUp::select()
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('client', function ($q) use ($keyword) {
                    return $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->when($user_id, function ($query, $user_id) {
                $query->whereHas('client', function ($query) use ($user_id) {
                    return $query->where('user_id', $user_id);
                });
            })
            ->when($created_by, function ($query, $created_by) {
                return $query->where('created_by', $created_by);
            })
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($date, function ($query, $date) {
                return $query->whereDate('date', $date);
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
    public function import(Request $request)
    {
        $fileName = time();
        $path     = 'follow_up_client/' . $request['client_id'];

        $validator = Validator::make($request->all(), [
            'file' => 'mimes:xls,xlsx|max:10240',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format XLS, XLSX']);
        }
        $extension = $request->file('file')->extension();
        Storage::disk('public')->putFileAs($path, $request->file('file'), $fileName . "." . $extension);

        $createAttachment = Attachment::create([
            'path'      => $path,
            'name'      => $fileName,
            'extension' => $extension
        ]);
        if ($createAttachment) {
            $type          = $request['type'];
            $attachment_id = $createAttachment->id;
            $import = new ClientImport($type, $attachment_id);
            Excel::import($import, $request->file('file'));
            return $import->getResponse();
        } else {
            return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'A system error has occurred. please try again later.']);
        }
    }
    public function exportReport(Request $request)
    {
        $user_id = $request['user_id'];
        $type = $request['type'];
        $period = $request['period'];
        $date = $request['date'];
        if ($request['month']) {
            $dataMonth    = explode("-", $request['month']);
            $year = $dataMonth[0];
            $month = $dataMonth[1];
        }
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];

        $user = User::Where('id', $user_id)->first();
        if ($type == '1') {
            if ($period == '1') {
                $data = FollowUp::select()
                    ->with(['client'])
                    ->where('created_by', $user_id)
                    ->whereDate('date', $date)
                    ->where('status', true)
                    ->orderBy('date')
                    ->get();

                $date = date('d F Y', strtotime($date));
                $report_name = 'Laporan Harian Telesale ' . $user->name . ' ' . $date;
            } elseif ($period == '2') {
                $data = FollowUp::select(
                    'date',
                    DB::raw('SUM(case when type = "1" THEN 1 ELSE 0 END) as Total_Call,
                        SUM(case when type = "2" THEN 1 ELSE 0 END) as Total_Meeting,
                        SUM(case when type = "3" THEN 1 ELSE 0 END) as Total_Proposal,
                        SUM(case when type = "4" THEN 1 ELSE 0 END) as Total_Email')
                )
                    ->where('created_by', $user_id)
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->where('status', true)
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();

                $monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "July", "Augustus", "September", "Oktober", "November", "Desember"];
                $report_name = 'Laporan Bulanan Telesale ' . $user->name . ' ' . $monthNames[(int)($month - 1)] . ' ' . $year;
            } elseif ($period == '3') {
                $data = FollowUp::select(
                    'date',
                    DB::raw('SUM(case when type = "1" THEN 1 ELSE 0 END) as Total_Call,
                        SUM(case when type = "2" THEN 1 ELSE 0 END) as Total_Meeting,
                        SUM(case when type = "3" THEN 1 ELSE 0 END) as Total_Proposal,
                        SUM(case when type = "4" THEN 1 ELSE 0 END) as Total_Email')
                )
                    ->where('created_by', $user_id)
                    ->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)
                    ->where('status', true)
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();

                $start_date = date('d F Y', strtotime($start_date));
                $end_date = date('d F Y', strtotime($end_date));
                $report_name = 'Laporan Telesale ' . $user->name . ' ' . $start_date . ' - ' . $end_date;
            }
        } elseif ($type == '2') {
            if ($period == '1') {
                $data = FollowUp::select()
                    ->with(['client'])
                    ->where('created_by', $user_id)
                    ->where('type', '3')
                    ->whereDate('date', $date)
                    ->where('status', true)
                    ->orderBy('date')
                    ->get();

                $date = date('d F Y', strtotime($date));
                $report_name = 'Laporan Harian Prospek ' . $user->name . ' ' . $date;
            } elseif ($period == '2') {
                $data = FollowUp::select()
                    ->with(['client'])
                    ->where('created_by', $user_id)
                    ->where('type', '3')
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->where('status', true)
                    ->orderBy('date')
                    ->get();

                $monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "July", "Agustus", "September", "Oktober", "November", "Desember"];
                $report_name = 'Laporan Bulanan Prospek ' . $user->name . ' ' . $monthNames[(int)($month - 1)] . ' ' . $year;
            } elseif ($period == '3') {
                $data = FollowUp::select()
                    ->with(['client'])
                    ->where('created_by', $user_id)
                    ->where('type', '3')
                    ->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)
                    ->where('status', true)
                    ->orderBy('date')
                    ->get();

                $start_date = date('d F Y', strtotime($start_date));
                $end_date = date('d F Y', strtotime($end_date));
                $report_name = 'Laporan Prospek ' . $user->name . ' ' . $start_date . ' - ' . $end_date;
            }
        } elseif ($type == '3') {
            if ($period == '1') {
                $data = ClientWin::select()
                    ->with(['client'])
                    ->where('created_by', $user_id)
                    ->whereDate('date', $date)
                    ->where('status', true)
                    ->orderBy('date')
                    ->get();

                $date = date('d F Y', strtotime($date));
                $report_name = 'Laporan Harian Achievement ' . $user->name . ' ' . $date;
            } elseif ($period == '2') {
                $data = ClientWin::select()
                    ->with(['client'])
                    ->where('created_by', $user_id)
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->where('status', true)
                    ->orderBy('date')
                    ->get();

                $monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "July", "Agustus", "September", "Oktober", "November", "Desember"];
                $report_name = 'Laporan Bulanan Achievement ' . $user->name . ' ' . $monthNames[(int)($month - 1)] . ' ' . $year;
            } elseif ($period == '3') {
                $data = ClientWin::select()
                    ->with(['client'])
                    ->where('created_by', $user_id)
                    ->whereDate('date', '>=', $start_date)
                    ->whereDate('date', '<=', $end_date)
                    ->where('status', true)
                    ->orderBy('date')
                    ->get();

                $start_date = date('d F Y', strtotime($start_date));
                $end_date = date('d F Y', strtotime($end_date));
                $report_name = 'Laporan Achievement ' . $user->name . ' ' . $start_date . ' - ' . $end_date;
            }
        }


        return Excel::download(new ExportReportFollowUpClient($type, $period, $data, $report_name), $report_name . '.xlsx');
    }
}

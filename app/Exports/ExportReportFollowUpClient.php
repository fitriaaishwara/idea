<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportReportFollowUpClient implements FromView
{
    private $type, $period, $data, $report_name;

    public function __construct($type, $period, $data, $report_name)
    {
        $this->type = $type;
        $this->period = $period;
        $this->data = $data;
        $this->report_name = $report_name;
    }

    use Exportable;

    public function view(): View 
    {
        if ($this->type == '1') {
            if ($this->period == '1') {
                return view('export.telesales.daily', [
                    'data' => $this->data,
                    'report_name' => $this->report_name
                ]);
            } else if ($this->period == '2') {
                return view('export.telesales.monthly', [
                    'data' => $this->data,
                    'report_name' => $this->report_name
                ]);
            } else if ($this->period == '3') {
                return view('export.telesales.range', [
                    'data' => $this->data,
                    'report_name' => $this->report_name
                ]);
            }
        }if ($this->type == '2') {
            if ($this->period == '1') {
                return view('export.prospect.daily', [
                    'data' => $this->data,
                    'report_name' => $this->report_name
                ]);
            } else if ($this->period == '2') {
                return view('export.prospect.monthly', [
                    'data' => $this->data,
                    'report_name' => $this->report_name
                ]);
            } else if ($this->period == '3') {
                return view('export.prospect.range', [
                    'data' => $this->data,
                    'report_name' => $this->report_name
                ]);
            }
        }if ($this->type == '3') {
            if ($this->period == '1') {
                return view('export.achievement.daily', [
                    'data' => $this->data,
                    'report_name' => $this->report_name
                ]);
            } else if ($this->period == '2') {
                return view('export.achievement.monthly', [
                    'data' => $this->data,
                    'report_name' => $this->report_name
                ]);
            } else if ($this->period == '3') {
                return view('export.achievement.range', [
                    'data' => $this->data,
                    'report_name' => $this->report_name
                ]);
            }
        }
    }
}

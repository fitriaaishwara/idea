<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportObjectiveUser implements FromView, ShouldAutoSize
{
    private $period, $data, $report_name;

    public function __construct($period, $data, $report_name)
    {
        $this->period = $period;
        $this->data = $data;
        $this->report_name = $report_name;
    }

    use Exportable;

    public function view(): View
    {
        if ($this->period == '1') {
            return view('export.objective.yearly', [
                'data' => $this->data,
                'report_name' => $this->report_name
            ]);
        } else if ($this->period == '2') {
            return view('export.objective.monthly', [
                'data' => $this->data,
                'report_name' => $this->report_name
            ]);
        }
    }
}

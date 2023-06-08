<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportReportPettyCash implements FromView
{
    private $data, $saldo, $periode, $report_name;

    public function __construct($data, $saldo, $periode, $report_name)
    {
        $this->data = $data;
        $this->saldo = $saldo;
        $this->periode = $periode;
        $this->report_name = $report_name;
    }

    use Exportable;
    public function view(): View 
    {
        return view('export.petty_cash.monthly', [
            'data' => $this->data,
            'saldo' => $this->saldo,
            'periode' => $this->periode,
            'report_name' => $this->report_name
        ]);
    }
}

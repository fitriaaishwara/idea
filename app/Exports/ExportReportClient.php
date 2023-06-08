<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportReportClient implements FromView, ShouldAutoSize, WithEvents
{
    private $data, $report_name;

    public function __construct($data, $report_name)
    {
        $this->data = $data;
        $this->report_name = $report_name;
    }

    use Exportable;
    public function registerEvents(): array
    {
        return array(
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setAutoFilter('E2:G2');

            }
        );
    }   
    public function view(): View 
    {
        return view('export.client.all', [
            'data' => $this->data,
            'report_name' => $this->report_name
        ]);
    }
}

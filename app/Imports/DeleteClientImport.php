<?php

namespace App\Imports;

use App\Models\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;

class DeleteClientImport implements ToCollection, WithHeadingRow
{
    private $response;
    public function __construct()
    {

    }
    public function collection(Collection $collections)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to delete'];
            foreach ($collections as $key => $value) {
                if ($value['email']) {
                    Client::where('user_id', Auth::user()->id)->where('email', $value['email'])->update([
                        'status'        => false,
                        'updated_by'   => Auth::user()->id,
                    ]);
                }
            }
            DB::commit();
            $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data deleted successfully'];
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'Ups, Terjadi kesalahan sistem'.$ex];
        }
        
        $this->response = $data;

    }
    public function getResponse()
    {
        return $this->response;
    }

    public function headingRow(): int
    {
        return 4;
    }
}

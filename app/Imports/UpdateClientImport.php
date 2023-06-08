<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\FollowUpClient;
use App\Models\Scope;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;

class UpdateClientImport implements ToCollection, WithHeadingRow
{
    private $response;
    public function __construct()
    {
    }


    public function collection(Collection $collections)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];
            $today       = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
            $user_id = Auth::user()->id;
            foreach ($collections as $key => $value) {
                if ($value['company']) {
                    $scope_1 = null;
                    $scope_2 = null;
                    $scope_3 = null;

                    if($value['scope_1']){
                        $scope_1 = Scope::where('name', $value['scope_1'])->first();
                    }
                    if($value['scope_2']){
                        $scope_2 = Scope::where('name', $value['scope_2'])->first();
                    }
                    if ($value['scope_3']) {
                        $scope_3 = Scope::where('name', $value['scope_3'])->first();
                    }

                    $update = Client::where('name', 'like', '%' . $value['company'] . '%')->where('user_id', $user_id)->update([
                        'name'         => strtoupper($value['company']),
                        'address'      => $value['address'],
                        'scope_1'      => ($scope_1) ? $scope_1['id'] : null,
                        'scope_2'      => ($scope_2) ? $scope_2['id'] : null,
                        'scope_3'      => ($scope_3) ? $scope_3['id'] : null,
                        'service'      => $value['service'],
                        'pic'          => $value['pic'],
                        'pic_position' => $value['pic_position'],
                        'mobile_phone' => $value['phone'],
                        'email'        => trim($value['email']),
                        'updated_by'   => $user_id,
                        'updated_at'   => $today,
                    ]);
                }
            }
            DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully update'];
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'Ups, Terjadi kesalahan sistem'];
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

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

class ClientImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    private $response;
    public function __construct()
    {

    }
    public function sheets(): array
	{
		return [
			0 => $this,
		];
	}



    public function collection(Collection $collections)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Scope failed to import'];
            $today       = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
            $user_id = Auth::user()->id;
            $arrayClient = [];
            foreach ($collections as $key => $value) {
                if ($value['company']) {
                    $scope_1 = Scope::where('name', $value['scope_1'])->first();
                    $scope_2 = Scope::where('name', $value['scope_2'])->first();
                    $scope_3 = Scope::where('name', $value['scope_3'])->first();
                    $client = Client::where('name', 'like', '%'. $value['company'] . '%')->where('user_id', $user_id)->where('status', true)->first();
                    if (!$client) {
                        $updateClient = [
                            'user_id'      => Auth::user()->id,
                            'name'         => strtoupper($value['company']),
                            'address'      => $value['address'],
                            'scope_1'      => ($scope_1)?$scope_1['id']:null,
                            'scope_2'      => ($scope_2)?$scope_2['id']:null,
                            'scope_3'      => ($scope_3)?$scope_3['id']:null,
                            'service'      => $value['service'],
                            'pic'          => $value['pic'],
                            'mobile_phone' => $value['phone'],
                            'email'        => trim($value['email']),
                            'created_at'   => $today,
                        ];
                        array_push($arrayClient,$updateClient);
                    }
                }
            }
            foreach (array_chunk($arrayClient,1000) as $value){
                $createClient = Client::insert($value);
            }
            
            if($createClient){
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully import'];
            }
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

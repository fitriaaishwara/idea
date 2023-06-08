<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\FollowUpClient;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;

class ClientImport implements ToCollection, WithHeadingRow
{
    private $response;
    public function __construct($type, $attachment_id)
    {
        $this->type          = $type;
        $this->attachment_id = $attachment_id;
    }


    public function collection(Collection $collections)
    {
        $today               = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $arrayClient         = [];
        $arrayFollowUpClient = [];
        foreach ($collections as $key => $value) {
            if ($value['company']) {
                $client = Client::where('name', 'like', '%'. $value['company'] . '%')->first();
                if (!$client) {
                    $updateClient = [
                        'user_id'      => Auth::user()->id,
                        'name'         => strtoupper($value['company']),
                        'address'      => $value['address'],
                        'scope'        => $value['scope'],
                        'service'      => $value['service'],
                        'pic'          => $value['pic'],
                        'mobile_phone' => $value['phone'],
                        'email'        => $value['email'],
                        'created_at'   => $today,
                    ];
                    array_push($arrayClient,$updateClient);
                }
            }
        }
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data gagal ditambah'];
            $createClient = Client::insert($arrayClient);
            if($createClient){
                foreach ($collections as $key => $value) {
                    if ($value['company']) {
                        $unix_date = ($value['date'] - 25569) * 86400;
                        $date = gmdate("Y-m-d", $unix_date);
                        $client = Client::where('name', 'like', '%'. $value['company'] . '%')->first();
                        if ($client) {
                            $followUpClient = [
                                'client_id'     => $client['id'],
                                'attachment_id' => $this->attachment_id,
                                'date'          => $date,
                                'type'          => $this->type,
                                'created_by'    => Auth::user()->id,
                                'note'          => $value['note'],
                                'created_at'    => $today,
                            ];
                            array_push($arrayFollowUpClient,$followUpClient);
                        }
                    }
                }
                $createFollowUp = FollowUpClient::insert($arrayFollowUpClient);
                if ($createFollowUp) {
                    DB::commit();
                    $data = ['status' => true, 'code' => 'SC001', 'message' => 'Tambah data berhasil'];    
                }
                
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

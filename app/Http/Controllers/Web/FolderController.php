<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class FolderController extends Controller
{
    public function getData(Request $request)
    {
        $keyword = $request['name'];

        $folders = Folder::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->where('parent_id', null)
            ->where('status', 1)
            ->get();
        $response = [
            'status' => true,
            'data'   => $folders,
        ];
        return $response;
    }
    public function getDataChild(Request $request)
    {
        $keyword = $request['name'];

        $folders = Folder::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->where('parent_id', $request['parent_id'])
            ->where('status', 1)
            ->get();
        $response = [
            'status' => true,
            'data'   => $folders,
        ];
        return $response;
    }
    public function getDataRecycle(Request $request)
    {
        $keyword = $request['name'];

        $folders = Folder::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->where('status', 0)
            ->get();
        $response = [
            'status'          => true,
            'data'            => $folders,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Folder failed to create'];
            $create = Folder::create([
                'name'        => $request['name'],
                'parent_id'   => $request['parent_id'],
                'description' => $request['description'],
                'created_by'  => Auth::user()->id,
            ]);
            if ($create) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Folder created successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Folder gagal didapatkan'];
            $folder = Folder::with(['documents', 'child', 'createdBy', 'deletedBy'])
                ->withCount([
                    'documents AS size_sum' => function ($query) {
                        $query->select(DB::raw("SUM(size) as size_sum"))->where('status', 1);
                    }
                ])
                ->withCount([
                    'documents AS total_document' => function ($query) {
                        $query->where('status', 1);
                    }
                ])
                ->withCount([
                    'child AS total_child' => function ($query) {
                        $query->where('status', 1);
                    }
                ])
                ->where('id', $id)->first();
            if ($folder) {
                $data = ['status' => true, 'code' => '', 'message' => 'Folder berhasil didapatkan', 'data' => $folder];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Folder failed to update'];

            $update = Folder::where('id', $request['id'])->update([
                'name'        => $request['name'],
                'description' => $request['description'],
                'updated_by' => Auth::user()->id,
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Folder updated successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        $today = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Folder failed to delete'];

            $delete = Folder::where('id', $id)->update([
                'status'     => 0,
                'deleted_by' => Auth::user()->id,
                'deleted_at' => $today,
            ]);
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Folder deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function restore($id)
    {
        $today = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Folder failed to restore'];

            $restore = Folder::where('id', $id)->update([
                'status'     => 1,
            ]);
            if ($restore) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Folder restored successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function export()
    {
        $folder = Folder::with(['documents'])->where('parent_id', null)->get();
        $pdf = PDF::loadView('pdf.folder', compact('folder'))->setPaper('A4', 'potrait');

        return $pdf->stream('Daftar Induk Dokumen.pdf');
    }
}

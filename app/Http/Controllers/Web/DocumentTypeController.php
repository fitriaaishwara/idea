<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Data Document Type|Create Document Type|Edit Document Type|Delete Document Type', ['only' => ['index']]);
        $this->middleware('permission:Create Document Type', ['only' => ['store']]);
        $this->middleware('permission:Edit Document Type', ['only' => ['update']]);
        $this->middleware('permission:Delete Document Type', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('pages.document_type.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $documentType = DocumentType::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? DocumentType::count() : $request['length'])
            ->with(['fileExtension'])
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('fileExtension', function ($q) use ($keyword) {
                    return $q->where('extension', 'like', '%' . $keyword . '%')->orWhere('description', 'like', '%' . $keyword . '%');
                });
            })
            ->get();

        $documentTypeCounter = DocumentType::select()
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('fileExtension', function ($q) use ($keyword) {
                    return $q->where('extension', 'like', '%' . $keyword . '%')->orWhere('description', 'like', '%' . $keyword . '%');
                });
            })
            ->count();
        $response = [
            'status'          => true,
            'code'            => '',
            'message'         => '',
            'draw'            => $request['draw'],
            'recordsTotal'    => DocumentType::count(),
            'recordsFiltered' => $documentTypeCounter,
            'data'            => $documentType,
        ];
        return $response;
    }
    public function getDataActive()
    {
        $documentType = DocumentType::select()
            ->with(['fileExtension'])
            ->where('status', 1)
            ->get();
        $response = [
            'status'          => true,
            'data'            => $documentType,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Document type failed to create'];
            $create = DocumentType::updateOrCreate(
                ['file_extension_id' => $request['file_extension_id']],
                ['status' => 1]
            );
            if ($create) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Document type successfully created'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Document type failed to update'];
            $status = ($request['status'] == "true") ? 1 : 0;

            $update = DocumentType::where('id', $request['id'])->update([
                'status'        => $status,
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Document type successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Document type failed to delete'];

            $delete = DocumentType::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Document type deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}

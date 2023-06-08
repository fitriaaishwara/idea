<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Document;
use App\Models\DocumentArchive;
use App\Models\DocumentType;
use App\Models\Folder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use illuminate\support\Str;
use PDF;

class DocumentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Data Document|Create Document|Edit Document|Delete Document', ['only' => ['index', 'show', 'child', 'stream']]);
        $this->middleware('permission:Create Document', ['only' => ['store']]);
        $this->middleware('permission:Edit Document', ['only' => ['update', 'archive']]);
        $this->middleware('permission:Delete Document', ['only' => ['destroy']]);
        $this->middleware('permission:Restore Document', ['only' => ['restore']]);
        $this->middleware('permission:Export Document', ['only' => ['export']]);
        $this->middleware('permission:Download Document', ['only' => ['download']]);
    }
    public function index()
    {
        return view('pages.document.index');
    }
    public function child($id)
    {
        $data['id'] = $id;
        return view('pages.document.child')->with($data);
    }
    public function getData(Request $request)
    {
        $keyword = $request['name'];

        $documents = Document::select()
            ->with(['attachment'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->where('folder_id', $request['parent_id'])
            ->where('status', 1)
            ->get();
        $response = [
            'status'          => true,
            'data'            => $documents,
        ];
        return $response;
    }
    public function getDataRecycle(Request $request)
    {
        $keyword = $request['name'];

        $documents = Document::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->where('status', 0)
            ->get();
        $response = [
            'status'          => true,
            'data'            => $documents,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        $documentType = DocumentType::with(['fileExtension'])->where('status', 1)->get();
        $len = count($documentType);
        $type = '';
        foreach ($documentType as $key => $value) {
            if ($key == $len - 1) {
                $type .= $value->fileExtension->extension;
            } else {
                $type .= $value->fileExtension->extension . ',';
            }
        }
        $folder = Folder::where('id', $request['folder_id'])->first();
        $fileName = Str::random(20);
        $path = 'documents/' . $folder->name . '/';
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Document failed to upload'];
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:' . $type . '|max:10240',
            ], [
                'file' => 'File tidak boleh lebih dari 10 MB, dengan format ' . $type . '',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format ' . $type . '']);
            }
            if (!File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            $extension = $request->file('file')->extension();
            $photoName = $fileName . '.' . $extension;
            Storage::disk('public')->putFileAs($path, $request->file('file'), $fileName . "." . $extension);

            $createAttachment = Attachment::create([
                'path'      => $path,
                'name'      => $fileName,
                'extension' => $extension
            ]);
            if ($createAttachment) {
                $createDocument = Document::create([
                    'folder_id'     => $request['folder_id'],
                    'attachment_id' => $createAttachment->id,
                    'name'          => $request['nameDocument'],
                    'no_document'   => $request['no_document'],
                    'date'          => $request['date'],
                    'revisi'        => $request['revisi'],
                    'description'   => $request['descriptionDocument'],
                    'extension'     => $extension,
                    'size'          => $request->file('file')->getSize(),
                    'created_by'    => Auth::user()->id
                ]);
            }
            if ($createDocument) {
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Document uploaded successfully'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        $documentType = DocumentType::with(['fileExtension'])->where('status', 1)->get();
        $len = count($documentType);
        $type = '';
        foreach ($documentType as $key => $value) {
            if ($key == $len - 1) {
                $type .= $value->fileExtension->extension;
            } else {
                $type .= $value->fileExtension->extension . ',';
            }
        }
        $folder = Folder::where('id', $request['folder_id'])->first();
        $document = Document::where('id', $request['id'])->first();
        $fileName = Str::random(20);
        $path = 'documents/' . $folder->name . '/';
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Document failed to update'];
            $validator = Validator::make($request->all(), [
                'file' => 'mimes:' . $type . '|max:10240',
            ], [
                'file' => 'File tidak boleh lebih dari 10 MB, dengan format ' . $type . '',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format ' . $type . '']);
            }
            if ($request['file']) {
                $extension = $request->file('file')->extension();
                $photoName = $fileName . '.' . $extension;
                Storage::disk('public')->putFileAs($path, $request->file('file'), $fileName . "." . $extension);

                $createAttachment = Attachment::create([
                    'path'      => $path,
                    'name'      => $fileName,
                    'extension' => $extension
                ]);
            }

            if ($document['revisi'] != $request['revisi']) {
                $createDocumentArchive = DocumentArchive::create([
                    'folder_id'     => $document['folder_id'],
                    'attachment_id' => $document['attachment_id'],
                    'name'          => $document['name'],
                    'no_document'   => $document['no_document'],
                    'date'          => $document['date'],
                    'revisi'        => $document['revisi'],
                    'description'   => $document['description'],
                    'extension'     => $document['extension'],
                    'size'          => $document['size'],
                    'created_by'    => Auth::user()->id
                ]);
            }

            $updateDocument = Document::where('id', $request['id'])->update([
                'folder_id'     => $request['folder_id'],
                'attachment_id' => ($request['file']) ? ($createAttachment->id) : $document->attachment_id,
                'name'          => $request['name'],
                'no_document'   => $request['no_document'],
                'date'          => $request['date'],
                'revisi'        => $request['revisi'],
                'description'   => $request['description'],
                'extension'     => ($request['file']) ? $extension : $document->extension,
                'size'          => ($request['file']) ? $request->file('file')->getSize() : $document->size,
                'updated_by'     => Auth::user()->id
            ]);
            if ($updateDocument) {
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Document updated successfully'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function archive(Request $request)
    {
        $documentType = DocumentType::with(['fileExtension'])->where('status', 1)->get();
        $len = count($documentType);
        $type = '';
        foreach ($documentType as $key => $value) {
            if ($key == $len - 1) {
                $type .= $value->fileExtension->extension;
            } else {
                $type .= $value->fileExtension->extension . ',';
            }
        }
        $folder = Folder::where('id', $request['folder_id'])->first();
        $fileName = Str::random(20);
        $path = 'documents/' . $folder->name . '/';
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Document failed to update'];
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:' . $type . '|max:10240',
            ], [
                'file' => 'File tidak boleh lebih dari 10 MB, dengan format ' . $type . '',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format ' . $type . '']);
            }
            $extension = $request->file('file')->extension();
            $photoName = $fileName . '.' . $extension;
            Storage::disk('public')->putFileAs($path, $request->file('file'), $fileName . "." . $extension);

            $createAttachment = Attachment::create([
                'path'      => $path,
                'name'      => $fileName,
                'extension' => $extension
            ]);

            $document = Document::where('id', $request['id'])->first();
            $createDocumentArchive = DocumentArchive::create([
                'folder_id'     => $document['folder_id'],
                'attachment_id' => $document['attachment_id'],
                'name'          => $document['name'],
                'no_document'   => $document['no_document'],
                'date'          => $document['date'],
                'revisi'        => $document['revisi'],
                'description'   => $document['description'],
                'extension'     => $document['extension'],
                'size'          => $document['size'],
                'created_by'    => Auth::user()->id
            ]);
            if ($createDocumentArchive) {
                $updateDocument = Document::where('id', $request['id'])->update([
                    'folder_id'     => $request['folder_id'],
                    'attachment_id' => $createAttachment->id,
                    'name'          => $request['name'],
                    'no_document'   => $request['no_document'],
                    'date'          => $request['date'],
                    'revisi'        => $request['revisi'],
                    'description'   => $request['description'],
                    'extension'     => $extension,
                    'size'          => $request->file('file')->getSize(),
                    'updated_by'    => Auth::user()->id
                ]);
                if ($updateDocument) {
                    DB::commit();
                    $data = ['status' => true, 'code' => 'SC001', 'message' => 'Document updated successfully'];
                }
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Document failed to be found'];
            $document = Document::with(['folder', 'attachment', 'createdBy', 'deletedBy'])->where('id', $id)->first();
            if ($document) {
                $data = ['status' => true, 'code' => '', 'message' => 'Document was successfully found', 'data' => $document];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function stream($id)
    {
        $document  = Document::with(['folder', 'attachment'])->where('id', $id)->first();

        $pathDocument = $document->attachment->path;
        $name      = $document->attachment->name;
        $extension = $document->attachment->extension;
        $data['documentName'] = $pathDocument . '' . $name . '.' . $extension;

        return view('pages.document.view')->with($data);
    }
    public function download($id)
    {

        $document  = Document::with(['folder', 'attachment'])->where('id', $id)->first();
        $download = Document::where('id', $id)->update([
            'download'     => $document->download + 1,
        ]);
        $fileName  = $document->name . '.' . $document->extension;
        $path      = public_path('storage/' . $document->attachment->path);
        $name      = $document->attachment->name;
        $extension = $document->attachment->extension;
        return response()->download($path . '/' . $name . '.' . $extension, $fileName);
        // return response()->file($path.'/'.$name.'.'.$extension, ['Content-Type' => 'application/pdf']);
    }
    public function destroy($id)
    {
        $today = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Document failed to delete'];

            $delete = Document::where('id', $id)->update([
                'status'     => 0,
                'deleted_by' => Auth::user()->id,
                'deleted_at' => $today,
            ]);
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Document deleted successfully'];
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
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Document failed to restore'];

            $restore = Document::where('id', $id)->update([
                'status'     => 1,
            ]);
            if ($restore) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Document restored successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function export($id)
    {
        $folder = Folder::findOrFail($id);
        $document = Document::where('folder_id', $id)->get();
        $pdf = PDF::loadView('pdf.document', compact('document', 'folder'))->setPaper('A4', 'potrait');

        return $pdf->stream('Daftar Induk Dokumen.pdf');
    }
}

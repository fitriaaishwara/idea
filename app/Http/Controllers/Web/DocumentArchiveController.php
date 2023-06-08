<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DocumentArchive;
use Illuminate\Http\Request;

class DocumentArchiveController extends Controller
{
    public function index()
    {
        return view('pages.document-archive.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $archives = DocumentArchive::select()
            ->with(['attachment'])
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? DocumentArchive::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%')->orWhere('no_Archive', 'like', '%' . $keyword . '%');
            })
            ->latest()
            ->get();

        $archivesCounter = DocumentArchive::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%')->orWhere('no_document', 'like', '%' . $keyword . '%');
            })
            ->count();
        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => DocumentArchive::count(),
            'recordsFiltered' => $archivesCounter,
            'data'            => $archives,
        ];
        return $response;
    }
    public function stream($id)
    {
        $archive  = DocumentArchive::with(['folder', 'attachment'])->where('id', $id)->first();

        $pathDocument = $archive->attachment->path;
        $name      = $archive->attachment->name;
        $extension = $archive->attachment->extension;
        $data['documentName'] = $pathDocument . '' . $name . '.' . $extension;

        return view('pages.document-archive.view')->with($data);
    }
    public function download($id)
    {

        $archive  = DocumentArchive::with(['folder', 'attachment'])->where('id', $id)->first();

        $download = DocumentArchive::where('id', $id)->update([
            'download'     => $archive->download + 1,
        ]);
        $fileName  = $archive->name . '.' . $archive->extension;
        $path      = public_path('storage/' . $archive->attachment->path);
        $name      = $archive->attachment->name;
        $extension = $archive->attachment->extension;

        return response()->download($path . '/' . $name . '.' . $extension, $fileName);
    }
}

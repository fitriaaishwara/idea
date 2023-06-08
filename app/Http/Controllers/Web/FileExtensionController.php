<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FileExtension;
use Illuminate\Http\Request;

class FileExtensionController extends Controller
{
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $fileExtensions = FileExtension::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? FileExtension::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('extension', 'like', '%' . $keyword . '%')->orWhere('description', 'like', '%' . $keyword . '%');
            })
            ->oldest('description')
            ->get();

        $fileExtensionsCounter = FileExtension::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('extension', 'like', '%' . $keyword . '%')->orWhere('description', 'like', '%' . $keyword . '%');
            })
            ->count();
        $response = [
            'status'          => true,
            'code'            => '',
            'message'         => '',
            'draw'            => $request['draw'],
            'recordsTotal'    => FileExtension::count(),
            'recordsFiltered' => $fileExtensionsCounter,
            'data'            => $fileExtensions,
        ];
        return $response;
    }
}

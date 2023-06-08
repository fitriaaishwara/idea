<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Scope;
use Illuminate\Http\Request;

class ScopeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Data Scope|Create Scope|Edit Scope|Delete Scope', ['only' => ['index']]);
        $this->middleware('permission:Create Scope', ['only' => ['store']]);
        $this->middleware('permission:Edit Scope', ['only' => ['update']]);
        $this->middleware('permission:Delete Scope', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('pages.scope.index');
    }

    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $data = Scope::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? Scope::where('status', true)->count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->where('status', true)
            ->get();

        $dataCounter = Scope::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->where('status', true)
            ->count();
        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => Scope::where('status', true)->count(),
            'recordsFiltered' => $dataCounter,
            'data'            => $data,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Scope failed to create'];
            $create = Scope::create([
                'name'        => $request['name'],
                'description' => $request['description']
            ]);
            if ($create) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Scope successfully created'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'Scope failed to be found'];
            $data = Scope::findOrFail($id);
            if ($data) {
                $data = ['status' => true, 'message' => 'Scope was successfully found', 'data' => $data];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Scope failed to update'];

            $update = Scope::where('id', $request['id'])->update([
                'name'        => $request['name'],
                'description' => $request['description']
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Scope successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Scope failed to delete'];
            $delete = Scope::where('id', $id)->update([
                'status' => false
            ]);
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Scope deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}

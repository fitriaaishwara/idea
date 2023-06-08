<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecycleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Data Recycle Bin', ['only' => ['index']]);
    }
    public function index()
    {
        return view('pages.recycle.index');
    }
}

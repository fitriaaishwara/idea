<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.profile.index');
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'User failed to be found'];
            $user = User::findOrFail($id);
            if ($user) {
                $data = ['status'=> true, 'code'=> 'EEC001', 'message'=> 'User was successfully found','data'=> $user];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. '.$ex];
        }
        return $data;
    }
    public function changePassword(Request $request)
    {
       try {
            $data = ['status' => false, 'message' => 'Password failed to update'];

            $update = User::where('id', $request['id'])->update([
                'password' => Hash::make($request['password']),
            ]);
            if($update){
                $data = ['status' => true, 'message' => 'Password successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. '.$ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        $user = User::find($request->id);
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'message' => 'User failed to update'];
            if ( $user->username != $request['username']) {
                if(User::where('username', $request['username'])->exists()){
                    return $data = ['status' => false, 'message' => 'Username already exists'];
                }
            }

            $user->username      = $request['username'];
            $user->name          = $request['name'];
            $user->email         = $request['email'];
            $user->save();
            if($user){
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'User updated successfully'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. '.$ex];
        }
        return $data;
    }
}

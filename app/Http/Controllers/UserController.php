<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $users= User::all();
        return response()->json($users, 200);
    }

    public function findUserById (int $id) : JsonResponse{
        $user = User::where('id', $id)
            ->first();
        return response()->json($user);
    }

    public function saveUser (Request $request) : JsonResponse{
        $request = $this->parseRequest($request);
        DB::beginTransaction();
        try {
            $user = User::create($request->all());
            DB::commit();
            return response()->json($user, 201);
        }
        catch (\Exception $e){
            DB::rollBack();
            return response()->json('saving user failed'.$e->getMessage(), 420);
        }
    }

}

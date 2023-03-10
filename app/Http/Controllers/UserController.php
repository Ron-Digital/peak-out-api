<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index() {
        $allusers = User::all();
        return response()->json([
            'users' => UserResource::collection($allusers)
        ], 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'Message' => 'Invalid user id'
            ], 400);
        }
             return response()->json([
                 'User' => new UserResource($user)
             ], 200);
    }

    public function update(Request $request, $id)
    {
        $users = User::find($id);

        if (!$users){
            return response()->json(['Invalid user id!'], 400);
        }else{

            $rules = [
                'email' => 'email:strict|unique:users',
                'birth_date' => 'date_format:Y-m-d|before:now',
                'bio' => 'max:1024',
                'avatar' => 'exists:medias,id',
                'password' => [Password::min(6)
                                                    ->letters()
                                                    ->mixedCase()
                                                    ->numbers()
                                                    ->symbols()],
            ];
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json(['validation_errors' => $validator->errors()], 400);
            }
            
            Gate::authorize('is-my-profile', $users);
        
                if ($request->has('name')) {
                    $users->name = $request->name;
                }
                if ($request->has('password')) {
                    $users->password = bcrypt($request->password);
                }
                if ($request->has('email')) {
                    $users->email = $request->email;
                }
                if ($request->has('birth_date')) {
                    $users->birth_date = $request->birth_date;
                }
                if ($request->has('bio')) {
                    $users->bio = $request->bio;
                }
                if ($request->has('gender')) {
                    $users->gender = $request->gender;
                }
                if ($request->has('avatar')) {
                    $users->avatar = $request->avatar;
                }
                

                $users -> save();

                return response()->json([
                    'Message' => 'User Updated!'
                ], 200);
        }
    }

    public function destroy($id)
    {
        $deleted = User::find($id);

        Gate::authorize('is-my-profile', $deleted);

        if (!$deleted){
            return response()->json([
                'Message' => 'Invalid User id'
            ], 400);
        }else{
            $deleted->delete();

                return response()->json([
                    'Message' => 'User Deleted!'
                ], 200);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserProfileResource;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $alluserprofiles = UserProfile::all();
        return response()->json([
            'users' => UserProfileResource::collection($alluserprofiles)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user_profile = UserProfile::find($id);

        if (!$user_profile) {
            return response()->json([
                'Message' => 'Invalid user profile id'
            ], 400);
        }
             return response()->json([
                 'User' => new UserProfileResource($user_profile)
             ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    
     public function update(Request $request, $id)
    {
        $user_profile = UserProfile::find($id);
        $user = User::find($id);

        if (!$user_profile){
            return response()->json(['Invalid user id!'], 400);
        }else{

            $rules = [
                'user_name' => 'max:256',
                'biograpth' => 'max:1024',
                'phone_number' => 'required|size:11',
                'category_id' => 'array'
            ];
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json(['validation_errors' => $validator->errors()], 400);
            }
            
            Gate::authorize('is-my-profile', $user);
        
    
                if ($request->has('user_name')) {
                    $user_profile->user_name = $request->user_name;
                }
                if ($request->has('biography')) {
                    $user_profile->biography = $request->biography;
                }
                if ($request->has('phone_number')) {
                    $user_profile->phone_number = $request->phone_number;
                }
                if ($request->has('gender')) {
                    $user_profile->gender = $request->gender;
                }
                $user_profile->user_categories()->sync($request->category_id);
                
                $user_profile->save();

                return response()->json([
                    'Message' => 'User Updated!'
                ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }
}

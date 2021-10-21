<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }


    public function list(){
        return User::orderBy('name', 'ASC')->get();
    }


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success'=> true,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
    function destroy ($id){
        $result= User::where('id',$id)->delete();
        if($result){
            return ["result"=> "Admin has been deleted"];
        } else{
            return ["result"=> "Operation failed"];
        }
    }
   public function getadmin($id){
        return User::find($id);
    }


    public function update(Request $request, $id)
    {
        $admin = User::find($id);
        //what is the best way to validate the update request
        if ($admin) {
            $admin->update($request->all()); //because we used fillable
            if ($admin->save()) { //returns a boolean
                return response()->json([
                    'data' => $admin
                ], 200);
            } else {
                return response()->json([
                    'admin' => 'admin could not be updated'
                ], 500);
            }
        }
        return response()->json([
            'admin' => 'admin could not be found'
        ], 500);
    }
}

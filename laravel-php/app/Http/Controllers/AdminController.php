<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $admins = Admin::orderBy('username', 'ASC')->get();
            if ($admins) {
                return response()->json([
                    'data' => $admins
                ], 200);
            }
            return response()->json([
                'admin' => "empty"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'admin' => 'internal error'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddAdminRequest $request)
    {
        $admin = new Admin();
        $admin->fill($request->all()); //because we used fillable
        $admin->fill([
            'password' => Hash::make($request->newPassword)
        ]);
        if ($admin->save()) { //returns a boolean
            return response()->json([
                'data' => $admin
            ], 200);
        } else {
            return response()->json([
                'admin' => 'category could not be added'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::find($id);
        if ($admin) {
            return response()->json([
                'data' => $admin
            ], 200);
        }
        return response()->json([
            'admin' => 'admin could not be found'
        ], 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $admin = Admin::find($id);
        if($admin->delete()){ //returns a boolean
            return response()->json([
                'admin'=> "good for you"
            ],200);
        }
        else
        {
            return response()->json([
                'admin'=>'admin could not be deleted'
            ],500);
        }
    }
}

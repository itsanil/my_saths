<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Pdf;
use Illuminate\Http\Request;
use DB;
// use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User = User::with('roles')->get();
        $Role = Role::all();
        // echo "<pre>"; print_r($Role); echo "</pre>"; die('end of code');
        return view('user.index',compact('User','Role'));
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pdfData = Pdf::where('user_id',$id)->get();
        return view('onlinepdf.index',compact('pdfData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function edit(User $User)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request)
    {
            $user_id = $request['id'];
            $role = $request['role'];

            DB::table('role_user')
            ->where('user_id', $user_id)
            ->update(['role_id' => $role]);
            return redirect('role')->with(['success'=> 'User role update successfully.']);
            // return Response::json(array('success' => 1,'message'=>'User role update successfully.','data' => []));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $User)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
class profileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "profile";
    public $page = "Profile";
    public function index()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "Update Profile";    
        $data['dataUser'] = User::where('users.id',Auth::user()->id)
                            ->leftJoin('satker','users.kd_satker','=','satker.id')
                            ->first();        
        return view($this->mainPage.".index",$data);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate is user herself
        
        if(Auth::user()->id==$id)
            echo "sama";
        else
            return redirect('error');           
        //validate data
         $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        $data = $request->all();
        $user = User::find($id);
         if(!Hash::check($data['old_password'], $user->password)){
             return back()
                            ->with(['message'=>'The specified password does not match the database password','status'=>'danger']);
            }else{
               $datas['password'] = Hash::make($data['new_password']);
               $query = User::where('id',$id)->update($datas);
               return redirect('profile')
                            ->with(['message'=>'success update password','status'=>'success']);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

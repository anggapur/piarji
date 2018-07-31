<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\satker ;
use App\User;
class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "settingUser";
    public $page = "Setting User";
    public function index()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "Buat User";    
        $data['dataUser'] = User::where('level','<>','admin')
                            ->leftJoin('satker','users.kd_satker','=','satker.id')
                            ->select('users.*','satker.kd_satker','satker.nm_satker')
                            ->get();
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
        $data['page'] = $this->page;
        $data['subpage'] = "Buat User";        
        $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();
        return view($this->mainPage.".create",$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'conf_password' => 'required|same:password',
            'kd_satker' => 'required'
        ]);
        $data =  $request->all();
        $data['level'] = 'operator';
        $data['password'] = bcrypt($data['password']);
        $query = User::create($data);
        //IS data success created
        if($query)
        {
            return redirect($this->mainPage)->with(['status' => 'success' ,'message' => "Berhasil Membuat User Baru"]);
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
        $data['page'] = $this->page;
        $data['subpage'] = "Edit User";        
        $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();
        $data['dataUser'] = User::find($id);        
        return view($this->mainPage.".edit",$data);
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
        //
        //validasi data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,id,'.$id,
            'password' => 'required|min:6',
            'conf_password' => 'required|same:password',
            'kd_satker' => 'required'
        ]);
        $data =  $request->except('_method','_token','conf_password');        
        $data['password'] = bcrypt($data['password']);
        $query = User::where('id',$id)->update($data);
        //IS data success created
        if($query)
        {
            return redirect($this->mainPage)->with(['status' => 'success' ,'message' => "Berhasil Update User <b>".$data['name']."</b>"]);
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
        $query = User::where('id',$id)->delete();
        if($query)
        {
            return redirect($this->mainPage)->with(['status' => 'success' ,'message' => "Berhasil Menghapus User"]);
        }
    }
}

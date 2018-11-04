<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\aturan_tunkin;
use App\aturan_tunkin_detail;
use App\absensi;
use Validator;
class aturanTunkinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "aturanTunkin";
    public $page = "Aturan Tunkin";
    public function index()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "";    
        $data['dataTunkin'] = aturan_tunkin::all();
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
        $data['subpage'] = "";            
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
        $rules = [
            'kd_aturan' => 'required|unique:aturan_tunkin',
            'nama_aturan' => 'required',
            'state' => 'required',
        ];

        $messages = [
            'required'    => 'Inputan :attribute harus diisi',            
            'unique' => 'Inputan :attribute sudah digunakan'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        // Setting data aturan tunkin
        $dataHeader['kd_aturan'] = $request->kd_aturan;
        $dataHeader['nama_aturan'] = $request->nama_aturan;
        $dataHeader['state'] = $request->state;
        // change aktif
        if($request->state == "1")
            $change = aturan_tunkin::where('state','1')->update(['state'=>'0']);

        $insert = aturan_tunkin::create($dataHeader);
        $id = $insert->id;

        $i = 0;
        foreach ($request->kelas_jabatan as $key => $value) {
            $dataDetail[$i]['kelas_jabatan'] = $value;
            $dataDetail[$i]['tunjangan'] = str_replace('.','',$request->tunjangan[$key]);
            $dataDetail[$i++]['id_aturan_tunkin'] = $id;
        }

        $insert2 = aturan_tunkin_detail::insert($dataDetail);

        if($insert && $insert2)
            return redirect($this->mainPage)->with(['status' => 'success' , 'message' => 'Sukses membuat aturan tunkin baru']);




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
        $data['page'] = $this->page;
        $data['subpage'] = "Edit Aturan Tunkin";        
        $data['dataTunkin'] = aturan_tunkin::where('id',$id)->with(['detailAturanTunkinDetail' => function($q){
            $q->orderBy('kelas_jabatan','ASC');
        }])->first();        
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
        $rules = [
            'kd_aturan' => 'required|unique:aturan_tunkin',
            'nama_aturan' => 'required',
            'state' => 'required',
        ];

        $messages = [
            'required'    => 'Inputan :attribute harus diisi',            
            'unique' => 'Inputan :attribute sudah digunakan'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        // Setting data aturan tunkin
        $dataHeader['kd_aturan'] = $request->kd_aturan;
        $dataHeader['nama_aturan'] = $request->nama_aturan;
        $dataHeader['state'] = $request->state;
        // change aktif
        if($request->state == "1")
            $change = aturan_tunkin::where('state','1')->update(['state'=>'0']);

        $insert = aturan_tunkin::where('id',$id)->update($dataHeader);
        $id = $id;

        //delete all dulu 
        $delete = aturan_tunkin_detail::where('id_aturan_tunkin',$id)->delete();
        $i = 0;
        foreach ($request->kelas_jabatan as $key => $value) {
            $dataDetail[$i]['kelas_jabatan'] = $value;
            $dataDetail[$i]['tunjangan'] = str_replace('.','',$request->tunjangan[$key]);
            $dataDetail[$i++]['id_aturan_tunkin'] = $id;
        }

        $insert2 = aturan_tunkin_detail::insert($dataDetail);

        // return $dataDetail;
        if($insert && $insert2)
            return redirect($this->mainPage)->with(['status' => 'success' , 'message' => 'Sukses Update aturan tunkin <b>'.$request->nama_aturan.'</b>']);



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
        $find = aturan_tunkin::where('id',$id)->first();
        if($find->state == "1" || $find->state == "2")
            return redirect()->back()->with(['status' => 'danger' , 'message' => 'Tidak Bisa Menghapus Aturan Dengan Status Aktif']);
        //apakah digunakan
        $find2 = absensi::where('kd_aturan',$id)->get();
        if(count($find2) > 0)
        {               
              return redirect()->back()->with(['status' => 'danger' , 'message' => 'Aturan <b>'.$find->kd_aturan.' - '.$find->nama_aturan.'</b> Tidak Dapat Dihapus Karena Telah Digunakan Oleh Data Lain']);
        }
        $delete1 = aturan_tunkin::where('id',$id)->delete();
        $delete2 = aturan_tunkin_detail::where('id_aturan_tunkin',$id)->delete();

        if($delete1 && $delete2)
            return redirect($this->mainPage)->with(['status' => 'success' , 'message' => 'Berhasil Menghapus Aturan <b>'.$find->kd_aturan.' - '.$find->nama_aturan.'</b>']);

    }
    public function aktifkan($id)
    {
        $update = aturan_tunkin::where('state','1')->update(['state' => '0']);
        $update2 = aturan_tunkin::where('id',$id)->update(['state' => '1']);
        $data = aturan_tunkin::where('id',$id)->first();

        if($update && $update2)
            return redirect($this->mainPage)->with(['status' => 'success' , 'message' => 'Sukses Mengaktifkan Aturan Untuk Induk <b>'.$data->kd_aturan.' - '.$data->nama_aturan.'</b>']);
    }
    public function aktifkanKekurangan($id)
    {
        $update = aturan_tunkin::where('state','2')->update(['state' => '0']);
        $update2 = aturan_tunkin::where('id',$id)->update(['state' => '2']);
        $data = aturan_tunkin::where('id',$id)->first();

        if($update && $update2)
            return redirect($this->mainPage)->with(['status' => 'success' , 'message' => 'Sukses Mengaktifkan Aturan Untuk Kekurangan <b>'.$data->kd_aturan.' - '.$data->nama_aturan.'</b>']);
    }
    public function detail($id)
    {
        $data['datas'] = aturan_tunkin::where('id',$id)->with('detailAturanTunkinDetail')->first();
        $data['page'] = $this->page;
        $data['subpage'] = "";            
        return view($this->mainPage.".detail",$data); 
    }
}

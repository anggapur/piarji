<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\pegawai;
use CH;
use Auth;
use Excel;
use App\pangkat;
use App\jabatan;
use App\satker;
use App\aturan_tunkin;
use Validator;
use App\anak_satker;
class pegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "dataPegawai";
    public $page = "Data Personil";
    public function index()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "List Pegawai";    
        return view($this->mainPage.".index",$data);
    }

    public function rekapPegawai()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "Rekap Data Personil";  
        $data['dataRekap'] = satker::withCount(['getPegawai' => function($q){
            $q->where('status_aktif','1');
        }])->get();
        // return $data['dataRekap'];
        return view($this->mainPage.".rekapPegawai",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();
        $data['page'] = $this->page;
        $data['aturanTunkin'] = aturan_tunkin::where('state','1')->with('detailAturanTunkinDetail')->first();
        $data['subpage'] = "Input Data Personil";         
        $data['pangkat'] = pangkat::all();
        $data['jabatan'] = jabatan::all();
        if(Auth::user()->level == "admin")
            $data['dataAnakSatker'] = anak_satker::all();
        else
            $data['dataAnakSatker'] = anak_satker::where('kd_satker',CH::getKdSatker(Auth::user()->kd_satker))->get();
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
        //
        $dataInput = $request->except('_method','_token');
        $dataInput['gapok'] = str_replace('.','',$dataInput['gapok']);
        $dataInput['tunj_strukfung'] = str_replace('.','',$dataInput['tunj_strukfung']);
        $dataInput['tunj_lain'] = str_replace('.','',$dataInput['tunj_lain']);

        //satker
        if(Auth::user()->level != "admin")
            $dataInput['kd_satker'] = CH::getKdSatker(Auth::user()->kd_satker);
        //cari pangkat
        $cariPangkat = pangkat::where('nm_pangkat2',$dataInput['kd_pangkat']);
        if($cariPangkat->get()->count() == 0)
        {   
            $cariPangkat = pangkat::orderBy('id','DESC')->first();
            $idPangkat = ($cariPangkat->kd_pangkat+1);
            $dataInsert = ['kd_pangkat' => $idPangkat,'nm_pangkat1' => $dataInput['kd_pangkat'] ,'nm_pangkat2' => $dataInput['kd_pangkat'],'kd_kelgapok' => '0'];
            $insert = pangkat::create($dataInsert);
            $dataInput['kd_pangkat'] = $idPangkat;
        }
        else
        {
            $dataInput['kd_pangkat'] = $cariPangkat->first()->kd_pangkat;
        }

        //cari jabatan
        $cariJabatan = jabatan::where('nm_jabatan',$dataInput['kd_jab']);
        if($cariJabatan->get()->count() == 0)
        {   
            $cariJabatan = jabatan::orderBy('id','DESC')->first();
            $idJabatan = ($cariJabatan->kd_jabatan+1);
            $dataInsert = ['kd_jabatan' => $idJabatan,'nm_jabatan' => $dataInput['kd_jab']];
            $insert = jabatan::create($dataInsert);
            $dataInput['kd_jab'] = $idJabatan;
        }
        else
        {
            $dataInput['kd_jab'] = $cariJabatan->first()->kd_jabatan;
        }
        $dataInput['kd_gapok'] = "";
        $dataInput['no_rekening'] = $request->no_rekening;
        $dataInput['status_aktif'] = $request->status_aktif;
        $dataInput['status_tipikor'] = $request->status_tipikor;
        // return $dataInput;   
        $insertPegawai = pegawai::create($dataInput);

        if($insertPegawai)
            return redirect("settingRekening")->with(['status' => 'success' ,'message' => 'Berhasil Buat Data Pegawai <b>'.$request->nip.' '.$request->nama.'</b>']);
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
        

        $data['dataPegawai'] = pegawai::where('pegawai.id',$id)
                                ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                                ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                                ->select('pegawai.*','pangkat.nm_pangkat2','jabatan.nm_jabatan')
                                ->first();  
        if(Auth::user()->level != "admin")   
        {
            if($data['dataPegawai']->kd_satker != CH::getKdSatker(Auth::user()->kd_satker))
                return redirect('error');
        }
        $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();
        //anak satker
        if(Auth::user()->level == "admin")
        {
            $data['dataAnakSatker'] = anak_satker::all();
        }
        else
        {
            $data['dataAnakSatker'] = anak_satker::where('kd_satker',CH::getKdSatker(Auth::user()->kd_satker))->get();
        }
        $data['page'] = $this->page;
        $data['aturanTunkin'] = aturan_tunkin::where('state','1')->with('detailAturanTunkinDetail')->first();
        $data['subpage'] = "Edit Data Pegawai";         
        $data['pangkat'] = pangkat::all();
        $data['jabatan'] = jabatan::all();
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
        $data['dataPegawai'] = pegawai::where('pegawai.id',$id)
                                ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                                ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                                ->select('pegawai.*','pangkat.nm_pangkat2','jabatan.nm_jabatan')
                                ->first();     
         if(Auth::user()->level != "admin")   
        {
            if($data['dataPegawai']->kd_satker != CH::getKdSatker(Auth::user()->kd_satker))
                return redirect('error');
        }

        $dataInput = $request->except('_method','_token');
        $dataInput['gapok'] = str_replace('.','',$dataInput['gapok']);
        $dataInput['tunj_strukfung'] = str_replace('.','',$dataInput['tunj_strukfung']);
        $dataInput['tunj_lain'] = str_replace('.','',$dataInput['tunj_lain']);

        //satker
        if(Auth::user()->level != "admin")
            $dataInput['kd_satker'] = CH::getKdSatker(Auth::user()->kd_satker);
            
        //cari pangkat
        $cariPangkat = pangkat::where('nm_pangkat2',$dataInput['kd_pangkat']);
        if($cariPangkat->get()->count() == 0)
        {   
            $cariPangkat = pangkat::orderBy('id','DESC')->first();
            $idPangkat = ($cariPangkat->kd_pangkat+1);
            $dataInsert = ['kd_pangkat' => $idPangkat,'nm_pangkat1' => $dataInput['kd_pangkat'] ,'nm_pangkat2' => $dataInput['kd_pangkat'],'kd_kelgapok' => '0'];
            $insert = pangkat::create($dataInsert);
            $dataInput['kd_pangkat'] = $idPangkat;
        }
        else
        {
            $dataInput['kd_pangkat'] = $cariPangkat->first()->kd_pangkat;
        }

        //cari jabatan
        $cariJabatan = jabatan::where('nm_jabatan',$dataInput['kd_jab']);
        if($cariJabatan->get()->count() == 0)
        {   
            $cariJabatan = jabatan::orderBy('id','DESC')->first();
            $idJabatan = ($cariJabatan->kd_jabatan+1);
            $dataInsert = ['kd_jabatan' => $idJabatan,'nm_jabatan' => $dataInput['kd_jab']];
            $insert = jabatan::create($dataInsert);
            $dataInput['kd_jab'] = $idJabatan;
        }
        else
        {
            $dataInput['kd_jab'] = $cariJabatan->first()->kd_jabatan;
        }
        $updatePegawai = pegawai::where('id',$id)->update($dataInput);

        if($updatePegawai)
            return redirect("settingRekening")->with(['status' => 'success' ,'message' => 'Berhasil Update Data Pegawai <b>'.$request->nip.' '.$request->nama.'</b>']);
        //return $dataInput;
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
        $pegawai = pegawai::where('pegawai.id',$id)
                                ->first();   
        $delete = pegawai::where('id',$id)->delete();
        if($delete)
            return redirect("settingRekening")->with(['status' => 'success' ,'message' => 'Berhasil Hapus Data Pegawai <b>'.$pegawai->nip.' '.$pegawai->nama.'</b>']);

    }
    public function anyData()
    {
        if(Auth::user()->level == "admin")
        {
            $q = pegawai::leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
            ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')            
            ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')     
            // ->where('pegawai.status_aktif','1')       
            ->orderBy('kelas_jab','DESC')
            ->select('pegawai.*','satker.nm_satker','nm_pangkat1','nm_pangkat2','nm_jabatan');
        }
        else
        {
            $q = pegawai::leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
            ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')            
            ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')   
            ->where('pegawai.kd_satker',CH::getKdSatker(Auth::user()->kd_satker)) 
            // ->where('pegawai.status_aktif','1')        
            ->orderBy('kelas_jab','DESC')
            ->select('pegawai.*','satker.nm_satker','nm_pangkat1','nm_pangkat2','nm_jabatan');
        }
        return Datatables::of($q)
            ->addColumn('nm_pangkat', function ($user) {
                return $user->nm_pangkat2;
                // return $user->nm_pangkat1." - ".$user->nm_pangkat2;
                
            })
            ->addColumn('status_aktif', function ($user) {
                if($user->status_aktif == "0")
                    return "<span class='label label-danger'>Non-aktif</span>";
                else if($user->status_aktif == "1")
                    return "<span class='label label-success'>Aktif</span>";
                
            })
            ->addColumn('action', function ($user) {
                return '<a href="dataPegawai/'.$user->id.'/edit" class="btn btn-warning btn-xs">Edit</a>
                        <form action="'.url('dataPegawai/'.$user->id).'" method="POST">
                          '.csrf_field().'
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class=" btn btn-danger btn-xs"> Hapus</button>
                        </form>';
                // return $user->nm_pangkat1." - ".$user->nm_pangkat2;
                
            })
            ->rawColumns(['status_aktif','action'])
            ->make(true);
    }
    public function formImport()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "Form Import Data Personil";    
        return view($this->mainPage.".formImport",$data);
    }
    public function importDataPegawai(Request $request)
    {
        $berhasil = "";
        $gagal = "";
        $updateCount = 0;
        $insertCount = 0;
        if($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader){})->get();
            if(!empty($data) && $data->count()){
                $dataInsert = [];
                //return $data;
                $insert = true;
                $update = true;

                foreach($data as $key=>$val){   
                    if($val->no == null || $val->nipnrp == null)
                        continue;         

                    
                    //cari satker                    
                    if(Auth::user()->level == "admin")
                    {
                        $cariSatker = satker::where('kd_satker',$val->kode_satker)->get();
                        if($cariSatker->count() == 0)     
                            return redirect('pegawaiSetting/importPegawai')->with(['status' => 'danger' ,'message' => 'Gagal Import Data Pegawai, Kode Satker :'.$val->kode_satker.' tidak terdaftar']);
                        $cariAnakSatker = anak_satker::where(['kd_satker' => $val->kode_satker , 'kd_anak_satker' => $val->anak_satker])->get();
                        if($cariAnakSatker->count() == 0)
                            return redirect('pegawaiSetting/importPegawai')->with(['status' => 'danger' ,'message' => 'Gagal Import Data Pegawai, Kode Satker :'.$val->kode_satker.' Anak Satker : '.$val->anak_satker.' tidak terdaftar']);                        

                    }
                    

                    $cariPegawai = pegawai::where('nip',$val->nipnrp)->get();
                    if($cariPegawai->count() == 0)
                    {
                        if(Auth::user()->level == "admin")     
                            $dataInsert[$key]['kd_satker'] = $val->kode_satker;
                        else
                            $dataInsert[$key]['kd_satker'] = CH::getKdSatker(Auth::user()->kd_satker);

                        $dataInsert[$key]['kd_anak_satker'] = $val->anak_satker;
                        //pangkat golongan
                        $where = pangkat::where('nm_pangkat2',$val->pangkatgolongan);
                        if($where->get()->count() == 0)
                        {
                            $cari = pangkat::orderBy('id','DESC')->first();
                            $dataCreate = ['kd_pangkat' => ($cari->kd_pangkat+1),'nm_pangkat1' => $val->pangkatgolongan,'nm_pangkat2' => $val->pangkatgolongan,'kd_kelgapok' => '0'];
                            $create = pangkat::create($dataCreate);
                            $dataInsert[$key]['kd_pangkat'] = ($cari->kd_pangkat+1);
                        }
                        else
                        {
                            $cari = $where->first();
                            $dataInsert[$key]['kd_pangkat'] = ($cari->kd_pangkat);
                        }

                        //jabatan
                        $where = jabatan::where('nm_jabatan',$val->jabatan);
                        if($where->get()->count() == 0)
                        {
                            $cari = jabatan::orderBy('id','DESC')->first();
                            $dataCreate = ['kd_jabatan' => ($cari->kd_jabatan+1),'nm_jabatan' => $val->jabatan];
                            $create = jabatan::create($dataCreate);
                            $dataInsert[$key]['kd_jab'] = ($cari->kd_jabatan+1);
                        }
                        else
                        {
                            $cari = $where->first();
                            $dataInsert[$key]['kd_jab'] = ($cari->kd_jabatan);
                        }

                        $dataInsert[$key]['nama'] = $val->nama;
                        $dataInsert[$key]['nip'] = $val->nipnrp;                                                            
                        $dataInsert[$key]['kelas_jab'] = $val->kls_jab;
                        $dataInsert[$key]['kd_gapok'] = "";
                        $dataInsert[$key]['kawin'] = $val->kawin;
                        $dataInsert[$key]['tanggungan'] = $val->tanggungan;
                        $dataInsert[$key]['jenis_kelamin'] = $val->jenis_kelamin;
                        $dataInsert[$key]['gapok'] = $val->gaji_pokokpensiun;
                        $dataInsert[$key]['tunj_strukfung'] = $val->tunjangan_strukturalfungsional;
                        $dataInsert[$key]['tunj_lain'] = $val->tunjangan_lain_lain;
                        $dataInsert[$key]['no_rekening'] = $val->no_rekening;
                        $dataInsert[$key]['status_aktif'] = 1;
                        $dataInsert[$key]['kd_gapok'] = 0;
                        //Validation data
                        $messages = [
                            'required' => 'Gagal Import Data, Pastikan Kolom <b> :attribute </b> Diisi / Tidak Kosong',
                        ];
                        $validation = Validator::make($dataInsert[$key],[
                            'nama' => 'required',
                            'nip' => 'required',
                            'status_aktif' => 'required',
                            'kd_satker' => 'required',
                            'kd_pangkat' => 'required',
                            'kd_jab' => 'required',
                            'no_rekening' => 'required',
                            'kd_gapok' => 'required',
                            'kelas_jab' => 'required',
                            'kawin' => 'required',
                            'tanggungan' => 'required',
                            'jenis_kelamin' => 'required',
                            'gapok' => 'required',
                            'tunj_strukfung' => 'required',
                            'tunj_lain' => 'required',
                        ],$messages)->validate();

                        $insert = pegawai::insert($dataInsert);
                        $dataInsert = null;
                        $insertCount++;
                    }
                    else
                    {
                        //cari pegawainya     
                        if(Auth::user()->level == "operator")               
                        {
                            $cariPegawai = pegawai::where('nip',$val->nipnrp)->first()->kd_satker;
                            if($cariPegawai !== CH::getKdSatker(Auth::user()->kd_satker))
                                return redirect()->back()->with(['status' => 'danger' , 'message' => 'Gagal Import Data Pegawai, anda mencoba mengupdate pegawai dengan NIP '.$val->nipnrp.' yang bukan pegawai dalam satker anda']);
                        }
                        
                        if(Auth::user()->level == "admin")     
                            $dataUpdate['kd_satker'] = $val->kode_satker;
                        else
                            $dataUpdate['kd_satker'] = CH::getKdSatker(Auth::user()->kd_satker);

                        //pangkat golongan
                        $where = pangkat::where('nm_pangkat2',$val->pangkatgolongan);
                        if($where->get()->count() == 0)
                        {
                            $cari = pangkat::orderBy('id','DESC')->first();
                            $dataCreate = ['kd_pangkat' => ($cari->kd_pangkat+1),'nm_pangkat1' => $val->pangkatgolongan,'nm_pangkat2' => $val->pangkatgolongan,'kd_kelgapok' => '0'];
                            $create = pangkat::create($dataCreate);
                            $dataUpdate['kd_pangkat'] = ($cari->kd_pangkat+1);
                        }
                        else
                        {
                            $cari = $where->first();
                            $dataUpdate['kd_pangkat'] = ($cari->kd_pangkat);
                        }

                        //jabatan
                        $where = jabatan::where('nm_jabatan',$val->jabatan);
                        if($where->get()->count() == 0)
                        {
                            $cari = jabatan::orderBy('id','DESC')->first();
                            $dataCreate = ['kd_jabatan' => ($cari->kd_jabatan+1),'nm_jabatan' => $val->jabatan];
                            $create = jabatan::create($dataCreate);
                            $dataUpdate['kd_jab'] = ($cari->kd_jabatan+1);
                        }
                        else
                        {
                            $cari = $where->first();
                            $dataUpdate['kd_jab'] = ($cari->kd_jabatan);
                        }

                        $dataUpdate['kd_anak_satker'] = $val->anak_satker;
                        $dataUpdate['nama'] = $val->nama;
                        $dataUpdate['nip'] = $val->nipnrp;                                                            
                        $dataUpdate['kelas_jab'] = $val->kls_jab;
                        $dataUpdate['kd_gapok'] = "";
                        $dataUpdate['no_rekening'] =  $val->no_rekening;
                        $dataUpdate['kawin'] = $val->kawin;
                        $dataUpdate['tanggungan'] = $val->tanggungan;
                        $dataUpdate['jenis_kelamin'] = $val->jenis_kelamin;
                        $dataUpdate['gapok'] = $val->gaji_pokokpensiun;
                        $dataUpdate['tunj_strukfung'] = $val->tunjangan_strukturalfungsional;
                        $dataUpdate['tunj_lain'] = $val->tunjangan_lain_lain;

                        $update = pegawai::where('nip',$val->nipnrp)->update($dataUpdate);
                        $updateCount++;
                    }
                }
                // $insert = pegawai::insert($dataInsert);
                if($insert || $update)
                    return redirect('pegawaiSetting/importPegawai')->with(['status' => 'success' ,'message' => 'Berhasil Import Data Pegawai. Insert Data Baru '.$insertCount.' , Update Data '.$updateCount]);
            }
            else
            {
                return redirect($this->mainPage)->with(['status' => 'success' ,'message' => "Data Kosong"]);   
            }
        }
    }

    public function exporting()
    {
         // Execute the query used to retrieve the data. In this example
    // we're joining hypothetical users and payments tables, retrieving
    // the payments table's primary key, the user's first and last name, 
    // the user's e-mail address, the amount paid, and the payment
    // timestamp.

    if(Auth::user()->level == "admin")
        {
            $payments = pegawai::leftJoin('satker','satker.kd_satker','=','pegawai.kd_satker')
                ->leftJoin('pangkat','pangkat.kd_pangkat','=','pegawai.kd_pangkat')
                ->leftJoin('jabatan','jabatan.kd_jabatan','=','pegawai.kd_jab')
                ->select('nip','nama','nm_satker','nm_pangkat2','nm_jabatan','kelas_jab','no_rekening','kawin','tanggungan','jenis_kelamin')
                ->get();
        }
        else
        {
            $payments = pegawai::leftJoin('satker','satker.kd_satker','=','pegawai.kd_satker')
                ->leftJoin('pangkat','pangkat.kd_pangkat','=','pegawai.kd_pangkat')
                ->leftJoin('jabatan','jabatan.kd_jabatan','=','pegawai.kd_jab')
                ->select('nip','nama','nm_satker','nm_pangkat2','nm_jabatan','kelas_jab','no_rekening','kawin','tanggungan','jenis_kelamin')
                ->where('pegawai.kd_satker',CH::getKdSatker(Auth::user()->kd_satker))
                ->get();
        }
    // return $payments;

    // Initialize the array which will be passed into the Excel
    // generator.
    $paymentsArray = []; 

    // Define the Excel spreadsheet headers
    $paymentsArray[] = ['NI/NRP', 'NAMA','SATKER','PANGKAT','JABATAN','KELAS JABATAN','NO REKENING','KAWIN','TANGGUNGAN','JENIS KELAMIN'];
    // Convert each member of the returned collection into an array,
    // and append it to the payments array.
    foreach ($payments as $payment) {
        $paymentsArray[] = $payment->toArray();
    }

    // Generate and return the spreadsheet
    $data = "a";
    Excel::create('Data Pegawai', function($excel) use ($paymentsArray) {

        // Set the spreadsheet title, creator, and description
        $excel->setTitle('Data Pegawai');
        $excel->setCreator('PRG BALI')->setCompany('Angga Purnajiwa');
        $excel->setDescription('List Pegawai');

        // Build the spreadsheet, passing in the payments array
        $excel->sheet('sheet1', function($sheet) use ($paymentsArray) {
            $sheet->fromArray($paymentsArray, null, 'A1', false, false);
        });

    })->download('xlsx');
    }
}

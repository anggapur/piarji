<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//last update
Route::get('cobaPrint','HomeController@cobaPrint');
Route::get('download/{filename}', function($filename)
{
    // Check if file exists in app/storage/file folder
    $file_path = public_path()."/".$filename;
    if (file_exists($file_path))
    {
        // Send Download
        return Response::download($file_path, $filename, [
            'Content-Length: '. filesize($file_path)
        ]);
    }
    else
    {
        // Error
        //return $file_path;
        exit('Requested file does not exist on our server!');
    }
})
->where('filename', '[A-Za-z0-9\-\_\.]+');
Route::get('downloadBackup/{filename}', function($filename)
{
    // Check if file exists in app/storage/file folder
    $file_path = public_path()."/backupMysql/".$filename;
    if (file_exists($file_path))
    {
        // Send Download
        return Response::download($file_path, $filename, [
            'Content-Length: '. filesize($file_path)
        ]);
    }
    else
    {
        // Error
        //return $file_path;
        exit('Requested file does not exist on our server!');
    }
})
->where('filename', '[A-Za-z0-9\-\_\.]+');

Route::get('/', function () {
    return redirect('login');
});

Route::get('cobaImport','HomeController@cobaImport');
Route::get('formula','HomeController@mathFormula');
Route::get('test',function(){
	return CH::segment(1,"test");
});
Route::get('formulaPPH/{id}','HomeController@formulaPPH');
Route::get('autoCekMutasiAktif','mutasiController@autoCekMutasiAktif');

Auth::routes();

Route::group(['middleware' => 'auth'],function(){
	Route::get('exportDataPegawai','pegawaiController@exporting');

	//Api
	Route::get('getDeptApi','apiController@getDeptApi');
	Route::get('getLokasiApi','apiController@getLokasiApi');
	Route::get('getUnitApi','apiController@getUnitApi');
	Route::get('getPangkatApi','apiController@getPangkatApi');
	Route::get('getGapokApi','apiController@getGapokApi');
	Route::get('getPegawaiApi','apiController@getPegawaiApi');
	Route::get('getSatkerApi','apiController@getSatkerApi');
	//sinkronisasi
	Route::get('sinkronisasiData','apiController@index');
	Route::post('sinkronisasiData','apiController@getDataPost');
	// Home
	Route::get('/home', 'HomeController@index')->name('home');
	//update profile
	Route::resource('profile','profileController');

	// Data Satker
	Route::get('dataSatker/editOwnSatker','satkerController@editOwnSatker');
	Route::post('dataSatker/importDataSatker','satkerController@importDataSatker');
	Route::get('dataSatker/importSatker','satkerController@formImport');
	Route::resource('dataSatker','satkerController');		
	Route::get('getDataSatker','satkerController@anyData')->name('getDataSatker');
	//Data Unit
	Route::resource('dataUnit','unitController');
	Route::get('getDataUnit','unitController@anyData')->name('getDataUnit');
	// Dataa Dept
	Route::resource('dataDept','deptController');
	Route::get('getDataDept','deptController@anyData')->name('getDataDept');
	// Dataa Jabatan
	Route::resource('dataJabatan','jabatanController');
	Route::get('getDataJabatan','jabatanController@anyData')->name('getDataJabatan');
	// Dataa Lokasi
	Route::resource('dataLokasi','lokasiController');
	Route::get('getDataLokasi','lokasiController@anyData')->name('getDataLokasi');
	// Dataa Pangkat
	Route::resource('dataPangkat','pangkatController');
	Route::get('getDataPangkat','pangkatController@anyData')->name('getDataPangkat');
	// Data Pegawai
	Route::get('pegawaiSetting/rekapPegawai','pegawaiController@rekapPegawai');
	Route::get('pegawaiSetting/importPegawai','pegawaiController@formImport');
	Route::post('pegawaiSetting/importDataPegawai','pegawaiController@importDataPegawai');
	Route::resource('dataPegawai','pegawaiController');
	Route::get('getDataPegawai','pegawaiController@anyData')->name('getDataPegawai');
	Route::post('getDataPegawaiTry','pegawaiController@anyDataTry')->name('getDataPegawaiTry');

	Route::get('settingRekening/importForm','settingRekening@importForm');
	Route::post('settingRekening/importrekening','settingRekening@importrekening');
	Route::resource('settingRekening','settingRekening');
	Route::get('getDataRekening','settingRekening@anyData')->name('getDataRekening');

	//,utasi cek
	
	//Only Admin can access	
	Route::group(['middleware' => 'level:admin'],function(){
		//mutasi
		Route::get('mutasiSetting/mutasiViewAdmin','mutasiController@mutasiViewAdmin');
		//User setting
		Route::resource('settingUser','userController');
		//Setting Kebijakan Abensi
		Route::resource('kebijakanAbsensi','kebijakanAbsensiController');	
		// Aturan Tunkin
		Route::get('aturanTunkin/aktifkan/{id}','aturanTunkinController@aktifkan');
		Route::get('aturanTunkin/aktifkanKekurangan/{id}','aturanTunkinController@aktifkanKekurangan');
		Route::get('aturanTunkin/detail/{id}','aturanTunkinController@detail');
		Route::resource('aturanTunkin','aturanTunkinController');	
		//backup restore
		Route::get('backupRestore/restore','backupController@restoreView');
		Route::get('backupRestore/backup','backupController@backupView');
		Route::resource('backupRestore','backupController');
		//minta amprahan
		Route::get('laporanAmprahan/mintaTunkin','amprahanController@mintaTunkin');
		Route::post('apiMintaTunkin','amprahanController@apiMintaTunkin')->name('apiMintaTunkin');		
		
		Route::get('laporanAmprahan/lbrKerja','amprahanController@lbrKerja');
		Route::post('apiLbrKerja','amprahanController@apiLbrKerja')->name('apiLbrKerja');		

		Route::get('laporanAmprahan/perKelasJabatan','amprahanController@perKelasJabatan');
		Route::post('apiPerKelasJabatan','amprahanController@apiPerKelasJabatan')->name('apiPerKelasJabatan');
	});

	//Only Operator can access
	Route::group(['middleware' => 'level:operator'],function(){
		//amprahan
		Route::resource('amprahan','amprahanController');
		Route::post('pilihBulanTahunPegawaiAmprahan','amprahanController@pilihBulanTahunPegawai')->name('pilihBulanTahunPegawaiAmprahan');
		Route::get('laporanAmprahan/laporan1','amprahanLaporan@laporan1');
		Route::post('pilihBulanTahunLaporanPermintaanTunkin','amprahanLaporan@pilihBulanTahun')->name('pilihBulanTahunLaporanPermintaanTunkin');
		//kekurangan
		Route::resource('absensiKekurangan','absensiKekuranganController');
		Route::post('pilihBulanTahunPegawaiKekurangan','absensiKekuranganController@pilihBulanTahunPegawai')->name('pilihBulanTahunPegawaiKekurangan');
		//absensi
		Route::post('absensiSusulan/cekBulanTahun','absensiSusulan@cekBulanTahun')->name('cekBulanTahun');
		Route::resource('absensi','absensiController');
		Route::resource('absensiSusulan','absensiSusulan');

		Route::get('getDataAbsensi','absensiController@anyData')->name('getDataAbsensi');	
		Route::post('pilihBulanTahun','absensiController@pilihBulanTahun')->name('pilihBulanTahun');		
		Route::post('pilihBulanTahunPegawai','absensiController@pilihBulanTahunPegawai')->name('pilihBulanTahunPegawai');		
		//Mutasi
		Route::get('mutasiSetting/kirimMutasi','mutasiController@kirimMutasi');
		Route::get('mutasiSetting/terimaMutasi','mutasiController@terimaMutasi');
		Route::post('mutasiSetting/terima','mutasiController@terima');
		Route::resource('mutasiSetting','mutasiController');
	});

	Route::get('apiLihatAmprah','laporanAbsensi@apiLihatAmprah')->name('apiLihatAmprah');
	//cetak 1
	Route::get('rekapAbsensi/laporanPerSatker','laporanAbsensi@laporanPerSatker');
	Route::get('laporanAbsensi/laporan1','laporanAbsensi@laporan1');
	Route::post('pilihBulanTahunLaporan','laporanAbsensi@pilihBulanTahun')->name('pilihBulanTahunLaporan');

	Route::get('laporanAbsensi/laporanB','laporanAbsensi@laporanB');
	Route::post('pilihBulanTahunLaporanB','laporanAbsensi@pilihBulanTahunB')->name('pilihBulanTahunLaporanB');
	Route::get('laporanAbsensi/cekLap','laporanAbsensi@cekLap');

	Route::get('laporanAbsensi/laporanSPP','laporanAbsensi@laporanSPP');
	Route::get('laporanAbsensi/laporanSPTJM','laporanAbsensi@laporanSPTJM');
	Route::post('pilihBulanTahunLaporanSPP','laporanAbsensi@pilihBulanTahunSPP')->name('pilihBulanTahunLaporanSPP');

	Route::get('laporanAbsensi/laporanKU','laporanAbsensi@laporanKU');
	Route::post('pilihBulanTahunLaporanKU','laporanAbsensi@pilihBulanTahunKU')->name('pilihBulanTahunLaporanKU');

	//cetak 2
	Route::get('rekapAbsensiSusulan/laporanPerSatkerSusulan','laporanAbsensiSusulan@laporanPerSatkerSusulan');
	Route::get('laporanAbsensiSusulan/laporan1','laporanAbsensiSusulan@laporan1');
	Route::post('pilihBulanTahunLaporanSusulan','laporanAbsensiSusulan@pilihBulanTahun')->name('pilihBulanTahunLaporanSusulan');

	Route::get('laporanAbsensiSusulan/laporanB','laporanAbsensiSusulan@laporanB');
	Route::post('pilihBulanTahunLaporanBSusulan','laporanAbsensiSusulan@pilihBulanTahunB')->name('pilihBulanTahunLaporanBSusulan');
	Route::get('laporanAbsensiSusulan/cekLap','laporanAbsensiSusulan@cekLap');

	Route::get('laporanAbsensiSusulan/laporanSPP','laporanAbsensiSusulan@laporanSPP');
	Route::get('laporanAbsensiSusulan/laporanSPTJM','laporanAbsensiSusulan@laporanSPTJM');
	Route::post('pilihBulanTahunLaporanSPPSusulan','laporanAbsensiSusulan@pilihBulanTahunSPP')->name('pilihBulanTahunLaporanSPPSusulan');

	Route::get('laporanAbsensiSusulan/laporanKU','laporanAbsensiSusulan@laporanKU');
	Route::post('pilihBulanTahunLaporanKUSusulan','laporanAbsensiSusulan@pilihBulanTahunKU')->name('pilihBulanTahunLaporanKUSusulan');

	//cetak 3
	Route::get('rekapAbsensiKekurangan/laporanPerSatkerKekurangan','laporanAbsensiKekurangan@laporanPerSatkerKekurangan');
	Route::get('laporanAbsensiKekurangan/laporan1','laporanAbsensiKekurangan@laporan1');
	Route::post('pilihBulanTahunLaporanKekurangan','laporanAbsensiKekurangan@pilihBulanTahun')->name('pilihBulanTahunLaporanKekurangan');

	Route::get('laporanAbsensiKekurangan/laporanB','laporanAbsensiKekurangan@laporanB');
	Route::post('pilihBulanTahunLaporanBKekurangan','laporanAbsensiKekurangan@pilihBulanTahunB')->name('pilihBulanTahunLaporanBKekurangan');
	Route::get('laporanAbsensiKekurangan/cekLap','laporanAbsensiKekurangan@cekLap');

	Route::get('laporanAbsensiKekurangan/laporanSPP','laporanAbsensiKekurangan@laporanSPP');
	Route::get('laporanAbsensiKekurangan/laporanSPTJM','laporanAbsensiKekurangan@laporanSPTJM');
	Route::post('pilihBulanTahunLaporanSPPKekurangan','laporanAbsensiKekurangan@pilihBulanTahunSPP')->name('pilihBulanTahunLaporanSPPKekurangan');

	Route::get('laporanAbsensiKekurangan/laporanKU','laporanAbsensiKekurangan@laporanKU');
	Route::post('pilihBulanTahunLaporanKUKekurangan','laporanAbsensiKekurangan@pilihBulanTahunKU')->name('pilihBulanTahunLaporanKUKekurangan');
	//
	
	Route::get('tandaTanganSetting/laporan1','TTDController@laporan1');
	Route::get('tandaTanganSetting/laporanB','TTDController@laporanB');
	Route::get('tandaTanganSetting/laporanSPP','TTDController@laporanSPP');
	Route::get('tandaTanganSetting/laporanSPTJM','TTDController@laporanSPTJM');
	Route::get('tandaTanganSetting/laporanKU','TTDController@laporanKU');
	Route::post('tandaTanganSetting/saveData','TTDController@saveData');
	Route::post('tandaTanganSetting/deleteImageTTD','TTDController@deleteImageTTD')->name('deleteImageTTD');
});

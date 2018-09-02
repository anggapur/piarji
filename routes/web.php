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

Route::get('/', function () {
    return redirect('login');
});

Route::get('cobaImport','HomeController@cobaImport');
Route::get('formula','HomeController@mathFormula');
Route::get('test',function(){
	return CH::segment(1,"test");
});
Route::get('formulaPPH','HomeController@formulaPPH');

Auth::routes();

Route::group(['middleware' => 'auth'],function(){
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
	Route::resource('dataPegawai','pegawaiController');
	Route::get('getDataPegawai','pegawaiController@anyData')->name('getDataPegawai');

	Route::get('settingRekening/importForm','settingRekening@importForm');
	Route::post('settingRekening/importrekening','settingRekening@importrekening');
	Route::resource('settingRekening','settingRekening');
	Route::get('getDataRekening','settingRekening@anyData')->name('getDataRekening');


	//Only Admin can access	
	Route::group(['middleware' => 'level:admin'],function(){
		//User setting
		Route::resource('settingUser','userController');
		//Setting Kebijakan Abensi
		Route::resource('kebijakanAbsensi','KebijakanAbsensiController');	
		// Aturan Tunkin
		Route::get('aturanTunkin/aktifkan/{id}','aturanTunkinController@aktifkan');
		Route::get('aturanTunkin/detail/{id}','aturanTunkinController@detail');
		Route::resource('aturanTunkin','aturanTunkinController');	
		//backup restore
		Route::get('backupRestore/restore','backupController@restoreView');
		Route::get('backupRestore/backup','backupController@backupView');
		Route::resource('backupRestore','backupController');
	});

	//Only Operator can access
	Route::group(['middleware' => 'level:operator'],function(){
		Route::resource('absensi','absensiController');
		Route::get('getDataAbsensi','absensiController@anyData')->name('getDataAbsensi');	
		Route::post('pilihBulanTahun','absensiController@pilihBulanTahun')->name('pilihBulanTahun');		
	});

	Route::get('laporanAbsensi/laporan1','laporanAbsensi@laporan1');
	Route::post('pilihBulanTahunLaporan','laporanAbsensi@pilihBulanTahun')->name('pilihBulanTahunLaporan');

	Route::get('laporanAbsensi/laporanB','laporanAbsensi@laporanB');
	Route::post('pilihBulanTahunLaporanB','laporanAbsensi@pilihBulanTahunB')->name('pilihBulanTahunLaporanB');
	Route::get('laporanAbsensi/cekLap','laporanAbsensi@cekLap');

	Route::get('laporanAbsensi/laporanSPP','laporanAbsensi@laporanSPP');
	Route::post('pilihBulanTahunLaporanSPP','laporanAbsensi@pilihBulanTahunSPP')->name('pilihBulanTahunLaporanSPP');

	Route::get('laporanAbsensi/laporanKU','laporanAbsensi@laporanKU');
	Route::post('pilihBulanTahunLaporanKU','laporanAbsensi@pilihBulanTahunKU')->name('pilihBulanTahunLaporanKU');
	

});

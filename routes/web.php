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

Route::get('test',function(){
	return CH::segment(1,"test");
});

Auth::routes();

Route::group(['middleware' => 'auth'],function(){
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

	//Only Admin can access	
	Route::group(['middleware' => 'level:admin'],function(){
		//User setting
		Route::resource('settingUser','userController');
		//Setting Kebijakan Abensi
		Route::resource('kebijakanAbsensi','KebijakanAbsensiController');		
	});

	//Only Operator can access
	Route::group(['middleware' => 'level:operator'],function(){
		Route::resource('absensi','absensiController');
		Route::get('getDataAbsensi','absensiController@anyData')->name('getDataAbsensi');
	});

});

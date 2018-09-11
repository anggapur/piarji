<?php
namespace App\Helpers;
 
use Request;
use Auth;
use App\satker;
use App\mutasi;
class customHelper {
    /**
     * @param int $user_id User-id
     * 
     * @return string
     */
    public static function getNotifTerimaMutasi()
    {
        $q = satker::where('id',Auth::user()->kd_satker);

        if($q->get()->count() != 0)
            $data = mutasi::where('ke_satker',$q->first()->kd_satker)
                ->leftJoin('pegawai','mutasi.nip','=','pegawai.nip')
                ->leftJoin('satker','mutasi.dari_satker','=','satker.kd_satker')
                ->select('mutasi.*','pegawai.nama','satker.nm_satker')
                ->where('status_terima','0')
                ->get();
        else
            $data = "";
        return $data;
    }
    public static function segment($i,$word) {
            
      if (in_array(Request::segment($i),$word))
      	return "active";
      else
      	return "boom";
    }
    public static function getSatker()
    {
      $kd_satker = Auth::user()->kd_satker;
      if(Auth::user()->level == 'admin')
      {
        return "Administrator";
      }
      else
      {
        $query = satker::where('id',$kd_satker)->first();        
        return $query['kd_satker']." - ".$query['nm_satker'];
      }
    }
    public static function adminOnly()
    {
       if(Auth::user()->level == 'admin')
      {
        
      }
      else
      {
        return redirect('error');
      }
    }
    public static function showTo($level)
    {
      if(!in_array(Auth::user()->level, $level))
        return "hide";
    }
    public static function getKdSatker($id)
    {
      $q = satker::where('id',$id)->first();
      return $q->kd_satker;
    }

    public static function currencyIndo($val)
    {
      return number_format($val,0,',','.');
    }
    public static function formulaPPH($kawin,$tanggungan,$jenis_kelamin,$gapok,$tunj_strukfung,$tunkin,$tunj_lain)
    {
        $tanggunganArray = ['18','38','48','0','0','0','0','0','0','0','0','0'];
        if($nilaiTanggungan > 2)
            $nilaiTanggungan = 48;
        else
            $nilaiTanggungan = $tanggunganArray[$tanggungan];
        //$query = pegawai::where('nip','81051411')->first();

        $gapok = $gapok;
        $tunjangan_istri = (10/100)*$gapok;
        $tunjangan_anak = $tanggungan*0.02*$gapok;
        $jumlah_gaji_tunjangan_keluarga = $gapok+$tunjangan_istri+$tunjangan_anak;
        $tunjangan_strukfung = $tunj_strukfung;

        $tunjangan_beras = (7242*$nilaiTanggungan);
        $tunkin = $tunkin;///special
        $tunjangan_lain = $tunj_lain;
        $jumlah_penghasilan_bruto = $jumlah_gaji_tunjangan_keluarga+$tunjangan_strukfung+$tunjangan_beras+$tunkin+$tunjangan_lain;

        $biaya_jabatan = ($jumlah_penghasilan_bruto*(5/100) > 500000) ? 500000 : ($jumlah_penghasilan_bruto*(5/100));
        $iuran_pensiun = $jumlah_gaji_tunjangan_keluarga*(10/100);
        $jumlah_pengurang = $biaya_jabatan+$iuran_pensiun;
        $jumlah_penghasilan_netto = $jumlah_penghasilan_bruto-$jumlah_pengurang;
        $jumlah_ph_netto = $jumlah_penghasilan_netto*12;
        //ptkp
        if($jenis_kelamin == "P" AND $kawin == "K")
            $ptkp = 54000000;
        else if($kawin == 0 AND $tanggungan == 0)
            $ptkp = 1;
        else if($kawin == "K" AND $tanggungan == 0)
            $ptkp = 58500000;
        else if($kawin == "K" AND $tanggungan == 1)
            $ptkp = 63000000;
        else if($kawin == "K" AND $tanggungan == 2)
            $ptkp = 67500000;
        else if($kawin == "K" AND $tanggungan == 3)
            $ptkp = 72000000;
        else if($kawin == "TK" AND $tanggungan == 0)
            $ptkp = 54000000;
        else if($kawin == "TK" AND $tanggungan == 1)
            $ptkp = 58500000;
        else if($kawin == "TK" AND $tanggungan == 2)
            $ptkp = 63000000;
        else if($kawin == "TK" AND $tanggungan == 3)
            $ptkp = 67500000;

        $pkp_setahun = ($jumlah_ph_netto<$ptkp) ? 0:$jumlah_ph_netto-$ptkp;

        if($pkp_setahun > 500000000)
            $pph_21_terutang = 95000000+300*(($pkp_setahun-500000000)/1000);
        else if($pkp_setahun > 250000000)
            $pph_21_terutang = 32500000+250*(($pkp_setahun-250000000)/1000);
        else if($pkp_setahun > 50000000)
            $pph_21_terutang = 2500000+150*(($pkp_setahun-50000000)/1000);
        else
            $pph_21_terutang = 50*($pkp_setahun/1000);

        $pph_21_yang_telah_dipotong = $pph_21_terutang;
        $jumlah_pph_pasal_21 =  $pph_21_terutang-$pph_21_yang_telah_dipotong;
        $pph_21_per_bulan = $pph_21_terutang/12;

        $gaji_kotor_bulanan = $jumlah_gaji_tunjangan_keluarga+$tunjangan_strukfung+$tunjangan_beras+$tunjangan_lain;

        $biaya_jabatan   = ($gaji_kotor_bulanan*(5/100) > 500000) ? 500000:($gaji_kotor_bulanan*(5/100));
        $iuran_pensiun = $iuran_pensiun;
        $jumlah_pengurang_hijau = $biaya_jabatan+$iuran_pensiun;
        $penghasilan_netto_hijau = $gaji_kotor_bulanan-$jumlah_pengurang_hijau;
        $peng_netto_setahun = $penghasilan_netto_hijau*12;
        $ptkp = $ptkp;
        $pkp = ($peng_netto_setahun < $ptkp) ? 0:($peng_netto_setahun-$ptkp) ;

        if($pkp > 500000000)
            $pph_pasal_21_setahun  = 95000000+300*(($pkp-500000000)/1000);
        else if($pkp > 250000000)
            $pph_pasal_21_setahun = 32500000+250*(($pkp-250000000)/1000);
        else if($pkp > 50000000)
            $pph_pasal_21_setahun = 2500000+150*(($pkp-50000000)/1000);
        else
            $pph_pasal_21_setahun = 50*($pkp/1000);
        
        $pph_pasal_21_sebulan = $pph_pasal_21_setahun/12;
        $pph_final = $pph_21_per_bulan  - $pph_pasal_21_sebulan;

        /*
        echo $tanggung."<br>";
        echo "Gaji Pokok : ".$gapok."<br>";
        echo "tunjangan_istri : ".$tunjangan_istri."<br>";
        echo "tunjangan_anak : ".$tunjangan_anak."<br>";
        echo "jumlah_gaji_tunjangan_keluarga : ".$jumlah_gaji_tunjangan_keluarga."<br>";
        echo "tunjangan_strukfung : ".$tunjangan_strukfung."<br>";
        echo "tunjangan_beras : ".$tunjangan_beras."<br>";
        echo "tunkin : ".$tunkin."<br>";
        echo "tunj_lain : ".$tunjangan_lain."<br>";
        echo "jumlah penghasilan bruto : ".$jumlah_penghasilan_bruto."<br>";
        echo "<hr>";
        echo "biaya_jabatan".ceil($biaya_jabatan)."<br>";
        echo "iuran_pensiun".ceil($iuran_pensiun)."<br>";
        echo "jumlah_pengurang".ceil($jumlah_pengurang)."<br>";
        echo "jumlah_penghasilan_netto".ceil($jumlah_penghasilan_netto)."<br>";
        echo "jumlah_ph netto".ceil($jumlah_ph_netto)."<br>";
        echo "ptkp".ceil($ptkp)."<br>";
        echo "pkp etahun".ceil($pkp_setahun)."<br>";
        echo "pph 21 terutang".ceil($pph_21_terutang)."<br>";
        echo "pph 21 yang telah dipoting ".ceil($pph_21_yang_telah_dipotong)."<br>";
        echo "jumlah pph 21 ".ceil($jumlah_pph_pasal_21)."<br>";
        echo "pph 21 per bulan ".floor($pph_21_per_bulan)."<br>";
        echo "<hr>";
        echo "Gaji Kotor Bulanan ".$gaji_kotor_bulanan."<br>";
        echo "Gaji Kotor Bulanan ".$biaya_jabatan."<br>";
        echo "Gaji Kotor Bulanan ".$iuran_pensiun."<br>";
        echo "Gaji Kotor Bulanan ".$jumlah_pengurang_hijau."<br>";
        echo "Gaji Kotor Bulanan ".$penghasilan_netto_hijau."<br>";
        echo "Gaji Kotor Bulanan ".$peng_netto_setahun."<br>";
        echo "Gaji Kotor Bulanan ".$ptkp."<br>";
        echo "Gaji Kotor Bulanan ".$pkp."<br>";
        echo "Gaji Kotor Bulanan ".$pph_pasal_21_setahun."<br>";
        echo "Gaji Kotor Bulanan ".$pph_pasal_21_sebulan."<br>";
        echo "Gaji Kotor Bulanan ".$pph_final."<br>";
        */
        return $pph_final;
    }
}
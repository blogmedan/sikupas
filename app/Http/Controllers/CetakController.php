<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use File;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use PDF;
 
 
class CetakController extends Controller
{
	public function absensi($id1)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='admin' or Session::get('level')=='sekolah' or Session::get('level')=='guru')){
			if(Session::get('level')=='admin'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan',$id1)->get();
				$pertemuankelas = DB::table('pertemuankelas')->where('id_pertemuan',$id1)->orderby('n_siswa','ASC')->get();
				return view('cetakabsensi',['pertemuan' => $pertemuan,'pertemuankelas'=>$pertemuankelas]);
			}elseif(Session::get('level')=='sekolah'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan',$id1)->where('id_sekolah',Session::get('id_sekolah'))->get();
				$pertemuankelas = DB::table('pertemuankelas')->where('id_pertemuan',$id1)->orderby('n_siswa','ASC')->get();
				return view('cetakabsensi',['pertemuan' => $pertemuan,'pertemuankelas'=>$pertemuankelas]);
			}elseif(Session::get('level')=='guru'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan',$id1)->where('id_sekolah',Session::get('id_sekolah'))->get();
				$pertemuankelas = DB::table('pertemuankelas')->where('id_pertemuan',$id1)->orderby('n_siswa','ASC')->get();
				return view('cetakabsensi',['pertemuan' => $pertemuan,'pertemuankelas'=>$pertemuankelas]);
			}else{
				return redirect(Session::get('level'));
			}
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function cetak($id1)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='admin' or Session::get('level')=='sekolah' or Session::get('level')=='guru')){
			if(Session::get('level')=='admin'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan',$id1)->get();
				$pertemuankelas = DB::table('pertemuankelas')->where('id_pertemuan',$id1)->orderby('n_siswa','ASC')->get();
				$pdf = PDF::loadview('cetakabsensipdf',['pertemuan' => $pertemuan,'pertemuankelas'=>$pertemuankelas]);
    			return $pdf->download('laporan-absensi-pertemuan.pdf');
			}elseif(Session::get('level')=='sekolah'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan',$id1)->where('id_sekolah',Session::get('id_sekolah'))->get();
				$pertemuankelas = DB::table('pertemuankelas')->where('id_pertemuan',$id1)->orderby('n_siswa','ASC')->get();
				$pdf = PDF::loadview('cetakabsensipdf',['pertemuan' => $pertemuan,'pertemuankelas'=>$pertemuankelas]);
    			return $pdf->download('laporan-absensi-pertemuan.pdf');
			}elseif(Session::get('level')=='guru'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan',$id1)->where('id_sekolah',Session::get('id_sekolah'))->get();
				$pertemuankelas = DB::table('pertemuankelas')->where('id_pertemuan',$id1)->orderby('n_siswa','ASC')->get();
				$pdf = PDF::loadview('cetakabsensipdf',['pertemuan' => $pertemuan,'pertemuankelas'=>$pertemuankelas]);
    			return $pdf->download('laporan-absensi-pertemuan.pdf');
			}else{
				return redirect(Session::get('level'));
			}
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function nilai($id1,$id2)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='admin' or Session::get('level')=='sekolah' or Session::get('level')=='guru')){
			if(Session::get('level')=='admin'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->get();
				$tugaspertemuan= DB::table('tugaspertemuan')->where('id_pertemuan','=',$id1)->where('id_tugaspertemuan','=',$id2)->get();
				$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby('n_siswa','ASC')->get();
				return view('cetaknilai',['pertemuan' => $pertemuan,'pertemuankelas'=>$pertemuankelas,'tugaspertemuan'=>$tugaspertemuan]);
			}elseif(Session::get('level')=='sekolah'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->where('id_sekolah','=',Session::get('id_sekolah'))->get();
				$tugaspertemuan= DB::table('tugaspertemuan')->where('id_pertemuan','=',$id1)->where('id_tugaspertemuan','=',$id2)->get();
				$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby('n_siswa','ASC')->get();
				return view('cetaknilai',['pertemuan' => $pertemuan,'pertemuankelas'=>$pertemuankelas,'tugaspertemuan'=>$tugaspertemuan]);
			}elseif(Session::get('level')=='guru'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->where('id_sekolah','=',Session::get('id_sekolah'))->get();
				$tugaspertemuan= DB::table('tugaspertemuan')->where('id_pertemuan','=',$id1)->where('id_tugaspertemuan','=',$id2)->get();
				$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby('n_siswa','ASC')->get();
				return view('cetaknilai',['pertemuan' => $pertemuan,'pertemuankelas'=>$pertemuankelas,'tugaspertemuan'=>$tugaspertemuan]);
			}else{
				return redirect(Session::get('level'));
			}
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function cetaknilai($id1,$id2)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='guru')){
			if(Session::get('level')=='sekolah'){
				return redirect(Session::get('level'));
			}elseif(Session::get('level')=='guru'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->get();
				$tugaspertemuan= DB::table('tugaspertemuan')->where('id_pertemuan','=',$id1)->where('id_tugaspertemuan','=',$id2)->get();
				$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby('n_siswa','ASC')->get();
				$pdf = PDF::loadview('cetaknilaipdf',['pertemuan' => $pertemuan,'pertemuankelas'=>$pertemuankelas,'tugaspertemuan'=>$tugaspertemuan]);
    			return $pdf->download('laporan-nilai-tugas.pdf');
			}else{
				return redirect(Session::get('level'));
			}
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
    }
}
?>
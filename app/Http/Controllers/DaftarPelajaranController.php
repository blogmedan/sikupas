<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pelajaran;
use Session;
//use App\Exports\SekolahExport;
use App\Imports\PelajaranImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
 
 
class DaftarPelajaranController extends Controller
{
    public function lihat()
    {
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$matapelajaran = DB::table('matapelajaran')->where('a_sekolah',Session::get('name'))->where('id_sekolah',Session::get('id_sekolah'))->get();
    		return view('matapelajaran',['matapelajaran' => $matapelajaran]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
    }
	public function prosesreg(Request $request)
	{
		if($request->tambah){
            $c_d_pelajaran=DB::table('matapelajaran')->where('id_sekolah','=',Session::get('id_sekolah'))->where('n_pelajaran','=',$request->n_pelajaran)->count();
			if($c_d_pelajaran == 0){
                if(!empty(Session::get('name')) and Session::get('level')=='admin'){
                    /*DB::table('kelas')->insert([
                    'n_kelas' => $request->n_kelas,
                    'n_w_kelas' => $request->n_w_kelas,
                    'a_sekolah' => $request->a_sekolah,
                    'created_at' => date("Y-m-d"),
                    'updted_at' => date("Y-m-d")*/
                    return redirect(Session::get('level'));
                }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
                    $a_sekolah=Session::get('name');
                    DB::table('matapelajaran')->insert([
                    'id_sekolah' => Session::get('id_sekolah'),
                    'a_sekolah' => Session::get('name'),
                    'kode' => $request->kode,
                    'n_pelajaran' => $request->n_pelajaran,
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                    ]);
                    Session::flash('sukses','Data Mata Pelajaran Berhasil Ditambah!');
                }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
                    return redirect(Session::get('level'));
                }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
                    return redirect(Session::get('level'));
                }elseif(empty(Session::get('level'))){
                    return redirect('siswa');
                }
            }else{
                Session::flash('gagal','Mata Pelajaran Sudah Ada Di Sekolah Ini!');
            }
			return redirect('/daftarpelajaran');
		}
	}
	public function delete($id)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='admin')){
			DB::table('matapelajaran')->where('id_matapelajaran',$id)->delete();
			Session::flash('sukses','Data Mata Pelajaran Berhasil Dihapus!');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
		}elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
		return redirect('/daftarpelajaran');
	}
    public function import(Request $request) 
    {
        if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
            if($request->import){
                $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
                ]);
                if($request->import){
                $file = $request->file('file');
                Excel::import(new PelajaranImport, $file);
                Session::flash('sukses','Data Pelajaran Berhasil Diupload!');
                return redirect('daftarpelajaran');
                }
            }
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
            return redirect('siswa');
        }
    }
}
?>
<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Sekolah;
use Session;
use Crypt;
use Excel;
use App\Exports\SekolahExport;
use App\Imports\SekolahImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;


class DaftarSekolahController extends Controller
{
	
    public function lihat()
    {
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            $sekolah = DB::table('sekolah')->get();
			return view('daftarsekolah',['sekolah' => $sekolah]);
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
    }
	public function registrasi()
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return view('tambahsekolah');
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
            return redirect(Session::get('level'));
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
			$c_d_user=DB::table('sekolah')->where('username','=',$request->username)->count();
			if($c_d_user == 0){
				if(!empty(Session::get('name')) and Session::get('level')=='admin'){	
					//foreach($c_d_user as $c_u) {
						DB::table('sekolah')->insert([
							'npsn' => $request->npsn,
							'status' => $request->status,
							'n_sekolah' => $request->n_sekolah,
							'n_k_sekolah' => $request->n_k_sekolah,
							'username' => $request->username,
							'password' => Crypt::encrypt($request->password),
							'a_sekolah' => $request->a_sekolah,
							'created_at' => date("Y-m-d H:s:i"),
							'updated_at' => date("Y-m-d H:s:i"),
							'login_at' => date("Y-m-d H:s:i")
						]);
						Session::flash('sukses','Data Sekolah Berhasil Ditambah!');
					return redirect('/daftarsekolah');
				}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
					return redirect(Session::get('level'));
				}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
					return redirect(Session::get('level'));
				}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
					return redirect(Session::get('level'));
				}elseif(empty(Session::get('level'))){
					return redirect('siswa');
				}
			}else{
				Session::flash('gagal','Username Yang dimasukkan Sudah Terdaftar!');
			}
        }
	}
	public function tampil($id)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='admin' or Session::get('level')=='sekolah')){
			if(Session::get('level')=='admin'){
				$sekolah= DB::table('sekolah')->where('id_sekolah',$id)->get();
				return view('tampilsekolah',['sekolah' => $sekolah]);
			}elseif(Session::get('level')=='sekolah'){
				$sekolah= DB::table('sekolah')->where('id_sekolah',Session::get('id_sekolah'))->get();
				return view('tampilsekolah',['sekolah' => $sekolah]);
			}elseif(Session::get('level')=='guru'){
				return redirect(Session::get('level'));
			}else{
				return redirect(Session::get('level'));
			}
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
		
	}
	public function edit($id)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='admin' or Session::get('level')=='sekolah')){
			if(Session::get('level')=='admin'){
				$sekolah= DB::table('sekolah')->where('id_sekolah',$id)->get();
				return view('editsekolah',['sekolah' => $sekolah]);
			}elseif(Session::get('level')=='sekolah'){
				$sekolah= DB::table('sekolah')->where('id_sekolah',Session::get('id_sekolah'))->get();
				return view('editsekolah',['sekolah' => $sekolah]);
			}else{
				return redirect(Session::get('level'));
			}
		}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
		}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
			return redirect(Session::get('level'));
		}elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function prosesedit(Request $request)
	{
		if($request->update){
			if(!empty(Session::get('name')) and (Session::get('level')=='admin' or Session::get('level')=='sekolah')){
				//$c_d_user=DB::table('sekolah')->where('username','=',$request->username)->count();
				//if($c_d_user == 0){
					if(Session::get('level')=='admin'){
						DB::table('sekolah')->where('id_sekolah',$request->id_sekolah)->update([
							'npsn' => $request->npsn,
							'status' => $request->status,
							'n_sekolah' => $request->n_sekolah,
							'n_k_sekolah' => $request->n_k_sekolah,
							'email' => $request->email,
							'username' => $request->username,
							'password' => Crypt::encrypt($request->password),
							'a_sekolah' => $request->a_sekolah
						]);
						DB::table('guru')->where('id_sekolah',$request->id_sekolah)->update([
							'a_sekolah' => $request->n_sekolah
						]);
						DB::table('siswa')->where('id_sekolah',$request->id_sekolah)->update([
							'a_sekolah' => $request->n_sekolah
						]);
						DB::table('kelas')->where('id_sekolah',$request->id_sekolah)->update([
							'a_sekolah' => $request->n_sekolah
						]);
						DB::table('matapelajaran')->where('id_sekolah',$request->id_sekolah)->update([
							'a_sekolah' => $request->n_sekolah
						]);
					}elseif(Session::get('level')=='sekolah'){
						DB::table('sekolah')->where('id_sekolah',Session::get('id_sekolah'))->update([
							//'npsn' => $request->npsn,
							//'status' => $request->status,
							//'n_sekolah' => $request->n_sekolah,
							'n_k_sekolah' => $request->n_k_sekolah,
							'email' => $request->email,
							'username' => $request->username,
							'password' => Crypt::encrypt($request->password),
							'a_sekolah' => $request->a_sekolah
						]);
						DB::table('guru')->where('id_sekolah',Session::get('id_sekolah'))->update([
							'a_sekolah' => Session::get('name')
						]);
						DB::table('siswa')->where('id_sekolah',Session::get('id_sekolah'))->update([
							'a_sekolah' => Session::get('name')
						]);
						DB::table('kelas')->where('id_sekolah',Session::get('id_sekolah'))->update([
							'a_sekolah' => Session::get('name')
						]);
						DB::table('matapelajaran')->where('id_sekolah',Session::get('id_sekolah'))->update([
							'a_sekolah' => Session::get('name')
						]);
					}else{
						return redirect(Session::get('level'));
					}
				Session::flash('sukses','Data Sekolah Berhasil Diubah!');
				return redirect('/daftarsekolah/edit/'.$request->id_sekolah);
				//}else{				
				//	Session::flash('gagal','Username Yang dimasukkan Sudah Terdaftar!');
				//	return redirect('/daftarsekolah/edit/'.$request->id_sekolah);
				//}
			}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
				return redirect(Session::get('level'));
			}elseif(empty(Session::get('level'))){
				return redirect('siswa');
			}
		}
	}
	public function delete($id)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
			DB::table('sekolah')->where('id_sekolah',$id)->delete();
			Session::flash('sukses','Data Sekolah Berhasil Dihapus!');
			return redirect('/daftarsekolah');
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function import(Request $request) 
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
			if($request->import){
				$this->validate($request, [
					'file' => 'required|mimes:csv,xls,xlsx'
				]);
				if($request->import){
				$file = $request->file('file');
				Excel::import(new SekolahImport, $file);
				Session::flash('sukses','Data Sekolah Berhasil Diupload!');
				return redirect('daftarsekolah');
				}
			}
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
            return redirect(Session::get('level'));
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
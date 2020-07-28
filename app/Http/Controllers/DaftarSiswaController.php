<?php 

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Siswa;
use Session;
//use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Crypt;


class DaftarSiswaController extends Controller
{
    public function lihat()
    {
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            $siswa = DB::table('siswa')->where('id_sekolah',Session::get('id_sekolah'))->get();
			return view('daftarsiswa',['siswa' => $siswa]);
			$sekolah = DB::table('sekolah')->get();
			return view('daftarguru',['sekolah' => $sekolah]);
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$siswa = DB::table('siswa')->where('id_sekolah',Session::get('id_sekolah'))->get();
    		return view('daftarsiswa',['siswa' => $siswa]);
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
            return view('tambahsiswa');
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			return view('tambahsiswa');
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
			$c_d_user=DB::table('siswa')->where('username','=',$request->username)->count();
				if($c_d_user == 0){
					if(!empty(Session::get('name')) and Session::get('level')=='admin'){
						/*DB::table('siswa')->insert([
						'nama' => $request->nama,
						'agama' => $request->agama,
						'j_kelamin' => $request->j_kelamin,
						'kelas' => $request->kelas,
						'username' => $request->username,
						'password' => Crypt::encrypt($request->password),
						'a_sekolah' => $request->a_sekolah,
						'created_at' => date("Y-m-d"),
						'updated_at' => date("Y-m-d")
					]);
					Session::flash('sukses','Data Siswa Berhasil Ditambah!');
					*/
						return redirect(Session::get('level'));
					}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
						$a_sekolah=Session::get('name');
						DB::table('siswa')->insert([
							'id_sekolah' => Session::get('id_sekolah'),
							'id_kelas'=>0,
							'nisn' => 'Kosong',
							'nama' => $request->nama,
							'agama' => $request->agama,
							'j_kelamin' => $request->j_kelamin,
							'tgl_lahir' => 'Kosong',
							't_lahir' => 'Kosong',
							'kelas' => $request->kelas,
							'username' => $request->username,
							'password' => Crypt::encrypt($request->password),
							'a_sekolah' => $a_sekolah,
							'created_at' => date("Y-m-d"),
							'updated_at' => date("Y-m-d")
						]);
						Session::flash('sukses','Data Siswa Berhasil Ditambah!');
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
		return redirect('/daftarsiswa');
	}
	public function tampil($id)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='guru' or Session::get('level')=='admin')){
			if(Session::get('level')=='sekolah' or Session::get('level')=='admin'){
				$siswa= DB::table('siswa')->where('id_siswa',$id)->get();
				return view('tampilsiswa',['siswa' => $siswa]);
			}elseif(Session::get('level')=='guru'){
				$siswa= DB::table('siswa')->where('id_siswa',$id)->get();
				return view('tampilsiswa',['siswa' => $siswa]);
			}else{
				return redirect(Session::get('level'));
			}
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            $siswa= DB::table('siswa')->where('id_siswa',Session::get('id'))->get();
			return view('tampilsiswa',['siswa' => $siswa]);
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function edit($id)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='siswa')){
			if(Session::get('level')=='sekolah'){
				$siswa= DB::table('siswa')->where('id_siswa',$id)->get();
				return view('editsiswa',['siswa' => $siswa]);
			}elseif(Session::get('level')=='siswa'){
				$siswa= DB::table('siswa')->where('id_siswa',Session::get('id'))->get();
				return view('editsiswa',['siswa' => $siswa]);
			}else{
				return redirect(Session::get('level'));
			}
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function prosesedit(Request $request)
	{
		if($request->simpan){
			//$c_d_user=DB::table('siswa')->where('username','=',$request->username)->count();
				//if($c_d_user == 0){
					if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='siswa')){
						if(Session::get('level')=='sekolah'){
							DB::table('siswa')->where('id_siswa',$request->id_siswa)->update([
								'nisn' => $request->nisn,
								'nama' => $request->nama,
								'agama' => $request->agama,
								'j_kelamin' => $request->j_kelamin,
								//'kelas' => $request->kelas,
								't_lahir' => $request->t_lahir,
								'tgl_lahir' => $request->tgl_lahir,
								'email' => $request->email,
								//'username' => $request->username,
								'password' => Crypt::encrypt($request->password),
								//'a_sekolah' => $request->a_sekolah,
								'updated_at' => date("Y-m-d")
							]);
							DB::table('siswakelas')->where('id_siswa',$request->id_siswa)->update([
								'nama' => $request->nama,
								'agama' => $request->agama,
								'j_kelamin' => $request->j_kelamin,
								'updated_at' => date("Y-m-d")
							]);
							DB::table('pertemuankelas')->where('id_siswa',$request->id_siswa)->update([
								'n_siswa' => $request->nama,
								'agama' => $request->agama,
								'j_kelamin' => $request->j_kelamin
							]);
						}elseif(Session::get('level')=='siswa'){
							DB::table('siswa')->where('id_siswa',$request->id_siswa)->update([
								//'nisn' => $request->nisn,
								//'nama' => $request->nama,
								'agama' => $request->agama,
								'j_kelamin' => $request->j_kelamin,
								//'kelas' => $request->kelas,
								't_lahir' => $request->t_lahir,
								'tgl_lahir' => $request->tgl_lahir,
								'email' => $request->email,
								//'username' => $request->username,
								'password' => Crypt::encrypt($request->password),
								//'a_sekolah' => $a_sekolah,
								'updated_at' => date("Y-m-d")
							]);
							DB::table('siswakelas')->where('id_siswa',$request->id_siswa)->update([
								'nama' => Session::get('name'),
								'agama' => $request->agama,
								'j_kelamin' => $request->j_kelamin,
								'updated_at' => date("Y-m-d")
							]);
							DB::table('pertemuankelas')->where('id_siswa',$request->id_siswa)->update([
								'n_siswa' => Session::get('name'),
								'agama' => $request->agama,
								'j_kelamin' => $request->j_kelamin
							]);
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
				Session::flash('sukses','Data Siswa Berhasil Diubah!');
				return redirect('/daftarsiswa/edit/'.$request->id_siswa);
			//}else{				
			//Session::flash('gagal','Username Yang dimasukkan Sudah Terdaftar!');
			//return redirect('/daftarsiswa/edit/'.$request->id_siswa);
			//}
		}
		return redirect('/daftarsiswa');
	}
	public function delete($id)
	{		
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			DB::table('siswa')->where('id_siswa',$id)->delete();
			DB::table('siswakelas')->where('id_siswa',$id)->delete();
			Session::flash('sukses','Data Siswa Berhasil Dihapus!');
			return redirect('/daftarsiswa');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }
	}
	public function deletcek(Request $request)
	{
		if(isset($request->hapuscek)){
			if(!empty($request->id_siswa)){
					$jumlah_id = count($request->id_siswa);
					for($i=0;$i<$jumlah_id;$i++){
						if(!empty(Session::get('name')) and (Session::get('level')=='admin')){
							return redirect(Session::get('level'));
						}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
							DB::table('siswa')->where('id_siswa',$request->id_siswa[$i])->delete();
							DB::table('siswakelas')->where('id_siswa',$request->id_siswa[$i])->delete();
							Session::flash('sukses','Data Siswa Berhasil Dihapus!');
						}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
							return redirect(Session::get('level'));
						}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
							return redirect(Session::get('level'));
						}elseif(empty(Session::get('level'))){
							return redirect('siswa');
						}
					}
			}else{
				Session::flash('gagal','Maaf Tidak Ada Data Siswa Yang dipilih!');
			}
		}
		return redirect('/daftarsiswa');
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
				Excel::import(new SiswaImport, $file);
				Session::flash('sukses','Data Siswa Berhasil Diupload!');
				return redirect('daftarsiswa');
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
<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Guru;
use Session;
//use App\Exports\SekolahExport;
use App\Imports\GuruImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Crypt;
 
 
class DaftarGuruController extends Controller
{
    public function lihat()
    {
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            $guru = DB::table('guru')->where('id_sekolah',Session::get('id_sekolah'))->get();
			return view('daftarguru',['guru' => $guru]);
			$sekolah = DB::table('sekolah')->get();
			return view('daftarguru',['sekolah' => $sekolah]);
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$guru = DB::table('guru')->where('id_sekolah',Session::get('id_sekolah'))->get();
    		return view('daftarguru',['guru' => $guru]);
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
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			return view('tambahguru');
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
		$c_d_user=DB::table('guru')->where('username','=',$request->username)->count();
			if($c_d_user == 0){
				if(!empty(Session::get('name')) and Session::get('level')=='admin'){
					/*DB::table('guru')->insert([
						'n_guru' => $request->nama,
						'a_sekolah' => $request->a_sekolah,
						'username' => $request->username,
						'password' => Hash::make($request->password),
						'created_at' => date("Y-m-d"),
						'updated_at' => date("Y-m-d")
					]);
					Session::flash('sukses','Data Guru Berhasil Ditambah!');
					*/
					return redirect(Session::get('level'));
				}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
					$a_sekolah=Session::get('name');
					DB::table('guru')->insert([
					'id_sekolah' => Session::get('id_sekolah'),
					'n_guru' => $request->nama,
					'a_sekolah' => $a_sekolah,
					'username' => $request->username,
					'password' => Crypt::encrypt($request->password),
					'created_at' => date("Y-m-d"),
					'updated_at' => date("Y-m-d")
					]);
					Session::flash('sukses','Data Guru Berhasil Ditambah!');
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
		return redirect('/daftarguru');
		}
	}
	public function tampil($id)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='guru' or Session::get('level')=='admin')){
			if(Session::get('level')=='sekolah' or Session::get('level')=='admin'){
				$guru= DB::table('guru')->where('id_guru',$id)->get();
				return view('tampilguru',['guru' => $guru]);
			}elseif(Session::get('level')=='guru'){
				$guru= DB::table('guru')->where('id_guru',Session::get('id'))->get();
				return view('tampilguru',['guru' => $guru]);
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
		if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='guru')){
			if(Session::get('level')=='sekolah'){
				$guru= DB::table('guru')->where('id_guru',$id)->get();
				return view('editguru',['guru' => $guru]);
			}elseif(Session::get('level')=='guru'){
				$guru= DB::table('guru')->where('id_guru',Session::get('id'))->get();
				return view('editguru',['guru' => $guru]);
			}else{
				return redirect(Session::get('level'));
			}
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function prosesedit(Request $request)
	{
		if($request->simpan){
		//$c_d_user=DB::table('guru')->where('username','=',$request->username)->count();
			//if($c_d_user == 0){
				if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='guru')){
					if(Session::get('level')=='sekolah'){
						$a_sekolah=Session::get('name');
						DB::table('guru')->where('id_guru',$request->id_guru)->update([
						'nip' => $request->nip,
						'nuptk' => $request->nuptk,
						'n_guru' => $request->n_guru,
						'pangkat' => $request->pangkat,
						'jabatan' => $request->jabatan,
						//'a_sekolah' => $request->a_sekolah,
						'username' => $request->username,
						'password' => Crypt::encrypt($request->password),
						'email' => $request->email,
						'created_at' => date("Y-m-d h:i:s")
						]);
						DB::table('pertemuan')->where('id_guru',$request->id_guru)->update([
						'n_guru' => $request->n_guru
						]);
						DB::table('pertemuan')->where('id_guru',$request->id_guru)->update([
						'n_guru' => $request->nama,
						'updated_at' => date("Y-m-d")
						]);
					}elseif(Session::get('level')=='guru'){
						DB::table('guru')->where('id_guru',$request->id_guru)->update([
							//'nip' => $request->nip,
							'nuptk' => $request->nuptk,
							'n_guru' => $request->n_guru,
							//'pangkat' => $request->pangkat,
							//'jabatan' => $request->jabatan,
							//'a_sekolah' => $request->a_sekolah,
							'username' => $request->username,
							'password' => Crypt::encrypt($request->password),
							'email' => $request->email,
							'created_at' => date("Y-m-d h:i:s")
						]);
						DB::table('pertemuan')->where('id_guru',$request->id_guru)->update([
							'n_guru' => $request->n_guru,
							'updated_at' => date("Y-m-d")
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
			Session::flash('sukses','Data Guru Berhasil Diubah!');
			return redirect('/daftarguru/edit/'.$request->id_guru);
			//}else{				
			//Session::flash('gagal','Username Yang dimasukkan Sudah Terdaftar!');
			//return redirect('/daftarguru/edit/'.$request->id_guru);
			//}
		}
	return redirect('/daftarguru/edit/'.$request->id_guru);
	}
	public function delete($id)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			DB::table('guru')->where('id_guru',$id)->delete();
			Session::flash('sukses','Data Guru Berhasil dihapus!');
			return redirect('/daftarguru');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function deletcek(Request $request)
	{
		if(isset($request->hapuscek)){
			if(!empty($request->id_guru)){
					$jumlah_id = count($request->id_guru);
					for($i=0;$i<$jumlah_id;$i++){
						if(!empty(Session::get('name')) and (Session::get('level')=='admin')){
							return redirect(Session::get('level'));
						}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
							DB::table('guru')->where('id_guru',$request->id_guru[$i])->delete();
							Session::flash('sukses','Data Guru Berhasil Dihapus!');
						}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
							return redirect(Session::get('level'));
						}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
							return redirect(Session::get('level'));
						}elseif(empty(Session::get('level'))){
							return redirect('siswa');
						}
					}
			}else{
				Session::flash('gagal','Maaf Tidak Ada Data Guru Yang dipilih!');
			}
		}
		return redirect('/daftarguru');
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
				Excel::import(new GuruImport, $file);
				Session::flash('sukses','Data Guru Berhasil Diupload!');
				return redirect('daftarguru');
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
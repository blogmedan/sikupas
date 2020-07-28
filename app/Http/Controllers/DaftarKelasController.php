<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Kelas;
use Session;
//use App\Exports\SekolahExport;
use App\Imports\KelasImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
 
 
class DaftarKelasController extends Controller
{
    public function lihat()
    {
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$kelas = DB::table('kelas')->where('id_sekolah',Session::get('id_sekolah'))->get();
			$guru = DB::table('guru')->where('id_sekolah',Session::get('id_sekolah'))->get();
    		return view('daftarkelas',['kelas' => $kelas,'guru' => $guru]);
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
				DB::table('kelas')->insert([
				'id_sekolah' => Session::get('id_sekolah'),
				'n_kelas' => $request->n_kelas,
				'n_w_kelas' => $request->n_w_kelas,
				'a_sekolah' => $a_sekolah,
				'created_at' => date("Y-m-d"),
				'updated_at' => date("Y-m-d")
				]);
				Session::flash('sukses','Data Kelas Berhasil Ditambah!');
			}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
				return redirect(Session::get('level'));
			}elseif(empty(Session::get('level'))){
				return redirect('siswa');
			}
			return redirect('/daftarkelas');
		}
	}
	public function tampil($id)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='guru' or Session::get('level')=='admin')){
			if(Session::get('level')=='sekolah' or Session::get('level')=='admin'){
				$kelas= DB::table('kelas')->where('id_kelas',$id)->get();
				$siswakelas= DB::table('siswakelas')->where('id_kelas',$id)->get();
				return view('tampilkelas',['kelas' => $kelas], ['siswakelas' => $siswakelas]);
			}elseif(Session::get('level')=='guru'){
				$kelas= DB::table('kelas')->where('id_kelas',$id)->get();
				$siswakelas= DB::table('siswakelas')->where('id_kelas',$id)->get();
				return view('tampilkelas',['kelas' => $kelas], ['siswakelas' => $siswakelas]);
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
	public function tampiltambah($id)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			if(Session::get('level')=='sekolah'){
				$kelas= DB::table('kelas')->where('id_kelas',$id)->get();
				$siswa= DB::table('siswa')->where('id_sekolah',Session::get('id_sekolah'))->get();
				return view('addsiswakelas',['kelas' => $kelas], ['siswa' => $siswa]);
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
	public function tambahproses(Request $request)
	{
		if($request->tambah){
			if(!empty($request->id_siswa)){
					$jumlah_id = count($request->id_siswa);
					$i=0;
					for($i=0;$i<$jumlah_id;$i++){
						if(!empty(Session::get('name')) and (Session::get('level')=='admin')){
							return redirect(Session::get('level'));
						}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
						$c_d_user=DB::table('siswakelas')->where('id_siswa','=',$request->id_siswa[$i])->count();
							if($c_d_user == 0){
								$dsiswa=DB::table('siswa')->where('id_siswa',$request->id_siswa[$i])->get();
								foreach($dsiswa as $d_siswa){
								DB::table('siswakelas')->insert([
								'id_kelas' => $request->id_kelas,
								'id_siswa' => $d_siswa->id_siswa,
								'nama' => $d_siswa->nama,
								'j_kelamin' => $d_siswa->j_kelamin,
								'agama' => $d_siswa->agama,
								'created_at' => date("Y-m-d"),
								'updated_at' => date("Y-m-d")
								]);
									$kelas=DB::table('kelas')->where('id_kelas','=',$request->id_kelas)->get();
									foreach($kelas as $k){
									DB::table('siswa')->where('id_siswa',$d_siswa->id_siswa)->update([
										'id_kelas' => $request->id_kelas,
										'kelas' => $k->n_kelas
									]);
									}
								}
								Session::flash('sukses','Data Siswa Berhasil Ditambah!');
							}else{
								Session::flash('gagal','Maaf Data Siswa Sudah ada didalam Kelas!');
							}
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
		return redirect('/daftarkelas/tampil/'.$request->id_kelas);
	}
	public function deletesis($id1,$id)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='admin')){
			DB::table('siswakelas')->where('id_siswa',$id)->where('id_siswa',$id)->where('id_kelas',$id1)->delete();
			DB::table('siswa')->where('id_siswa',$id)->update([
				'id_kelas' => '0',
				'kelas' => 'Kosong'
			]);
			Session::flash('sukses','Data Siswa Berhasil Dihapus!');
			return redirect('/daftarkelas/tampil/'.$id1);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
		}
	}
	public function edit($id)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='sekolah'){
			$kelas = DB::table('kelas')->where('id_sekolah',Session::get('id_sekolah'))->where('id_kelas',$id)->get();
			$guru = DB::table('guru')->where('id_sekolah',Session::get('id_sekolah'))->get();
			return view('editkelas',['kelas' => $kelas,'guru' => $guru]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
		}
	}
	public function prosesedit(Request $request)
	{
		if(Session::get('name')){
			$dsiswa=DB::table('siswa')->where('id_kelas',$request->id_kelas)->get();
			foreach($dsiswa as $d_siswa){
			DB::table('siswa')->where('id_kelas',$request->id_kelas)->update([
			'kelas' => $request->n_kelas,
			'updated_at' => date("Y-m-d")
			]);
			}
			$a_sekolah=Session::get('name');
			DB::table('kelas')->where('id_kelas',$request->id_kelas)->update([
			'n_kelas' => $request->n_kelas,
			'n_w_kelas' => $request->n_w_kelas,
			'a_sekolah' => $a_sekolah,
			'created_at' => date("Y-m-d"),
			'updated_at' => date("Y-m-d")
			]);
			DB::table('pertemuan')->where('id_kelas',$request->id_kelas)->update([
			'n_kelas' => $request->n_kelas,
			'n_w_kelas' => $request->n_w_kelas,
			'created_at' => date("Y-m-d"),
			'updated_at' => date("Y-m-d")
			]);
		}else{
			$dsiswa=DB::table('siswa')->where('id_kelas',$request->id_kelas)->get();
			foreach($dsiswa as $d_siswa){
			DB::table('siswa')->where('id_kelas',$request->id_kelas)->update([
			'kelas' => $request->n_kelas,
			'updated_at' => date("Y-m-d")
			]);
			}
			DB::table('kelas')->where('id_kelas',$request->id_kelas)->update([
			'n_kelas' => $request->n_kelas,
			'n_w_kelas' => $request->n_w_kelas,
			'a_sekolah' => $request->a_sekolah,
			'created_at' => date("Y-m-d"),
			'updated_at' => date("Y-m-d")
			]);
			DB::table('pertemuan')->where('id_kelas',$request->id_kelas)->update([
			'n_kelas' => $request->n_kelas,
			'n_w_kelas' => $request->n_w_kelas,
			'created_at' => date("Y-m-d"),
			'updated_at' => date("Y-m-d")
			]);
		}
		Session::flash('sukses','Data Kelas Berhasil Diubah!');
		return redirect('/daftarkelas');
	}
	public function delete($id)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='admin')){
			DB::table('kelas')->where('id_kelas',$id)->delete();
			DB::table('siswakelas')->where('id_kelas',$id)->delete();
			Session::flash('sukses','Data Kelas Berhasil Dihapus!');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
		}elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
		return redirect('/daftarkelas');
	}
	/*public function import(Request $request) 
	{
		
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$this->validate($request, [
				'file' => 'required|mimes:csv,xls,xlsx'
			]);
			 // menangkap file excel
			$file = $request->file('file');
			 // membuat nama file unik
			$nama_file = rand().$file->getClientOriginalName();
			 // upload ke folder file_siswa di dalam folder public
			$file->move('file_guru',$nama_file);
			 // import data
			Excel::import(new GuruImport, public_path('/file_guru/'.$nama_file));
			 // notifikasi dengan session
			Session::flash('sukses','Data Guru Berhasil Diimport!');
			return redirect('/daftarguru');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}*/
}
?>
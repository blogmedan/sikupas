<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Pertemuan;
use Session;
use File;
//use App\Exports\SekolahExport;
use App\Imports\PertemuanImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use PDF;
 
 
class DaftarPertemuanController extends Controller
{
	public function sekolah(){
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            $sekolah = DB::table('sekolah')->orderby('n_sekolah','ASC')->get();
			return view('sekolahpertemuan',['sekolah' => $sekolah]);
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}else{
			return redirect('daftarpertemuan/'.Session::get('id_sekolah'));
		}
	}
	public function kelas($id1){
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
			$kelas = DB::table('kelas')->where('id_sekolah',$id1)->orderby('n_kelas','ASC')->get();
			return view('kelaspertemuan',['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='sekolah'){
			$kelas = DB::table('kelas')->where('id_sekolah',Session::get('id_sekolah'))->orderby('n_kelas','ASC')->get();
			return view('kelaspertemuan',['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			$kelas = DB::table('kelas')->where('id_sekolah',Session::get('id_sekolah'))->orderby('n_kelas','ASC')->get();
			$pelajaran = DB::table('matapelajaran')->where('id_sekolah',Session::get('id_sekolah'))->get();
			return view('kelaspertemuan',['kelas' => $kelas],['pelajaran' => $pelajaran]);
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}else{
			return redirect('daftarpertemuan/'.Session::get('id_sekolah').'/kelas/'.Session::get('id_kelas'));
		}
	}
	public function mapel($id1,$id2){
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
			$matapelajaran = DB::table('matapelajaran')->where('id_sekolah',$id1)->orderby('n_pelajaran','ASC')->get();
			$kelas = DB::table('kelas')->where('id_sekolah',$id1)->where('id_kelas',$id2)->get();
			return view('pelajaranpertemuan',['matapelajaran' => $matapelajaran],['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='sekolah'){
			$matapelajaran = DB::table('matapelajaran')->where('id_sekolah',Session::get('id_sekolah'))->orderby('n_pelajaran','ASC')->get();
			$kelas = DB::table('kelas')->where('id_kelas',$id2)->get();
			return view('pelajaranpertemuan',['matapelajaran' => $matapelajaran],['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			$matapelajaran = DB::table('matapelajaran')->where('id_sekolah',Session::get('id_sekolah'))->orderby('n_pelajaran','ASC')->get();
			$kelas = DB::table('kelas')->where('id_sekolah',Session::get('id_sekolah'))->where('id_kelas',$id2)->get();
			return view('pelajaranpertemuan',['matapelajaran' => $matapelajaran],['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
			$matapelajaran = DB::table('matapelajaran')->where('id_sekolah',Session::get('id_sekolah'))->orderby('n_pelajaran','ASC')->get();
			$kelas = DB::table('kelas')->where('id_sekolah',Session::get('id_sekolah'))->where('id_kelas',$id2)->get();
			return view('pelajaranpertemuan',['matapelajaran' => $matapelajaran],['kelas' => $kelas]);
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
    public function lihat($id1,$id2,$id3)
    {
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            $kelas = DB::table('kelas')->where('id_sekolah',$id1)->get();
			$pertemuan = DB::table('pertemuan')
			->where('id_sekolah',$id1)
			->where('id_kelas',$id2)
			->where('id_matapelajaran',$id3)
			->orderby("tgl_pertemuan","DESC")->get();
			return view('daftarpertemuan',['pertemuan' => $pertemuan],['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$kelas = DB::table('kelas')->where('id_sekolah',Session::get('id_sekolah'))->get();
			$pertemuan = DB::table('pertemuan')
			->where('id_sekolah',Session::get('id_sekolah'))
			->where('id_kelas',$id2)
			->where('id_matapelajaran',$id3)
			->orderby("id_pertemuan","DESC")->get();
			return view('daftarpertemuan',['pertemuan' => $pertemuan],['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			$kelas = DB::table('kelas')->where('id_sekolah',Session::get('id_sekolah'))->get();
			$pertemuan = DB::table('pertemuan')
			->where('id_sekolah',Session::get('id_sekolah'))
			->where('id_kelas',$id2)
			->where('id_matapelajaran',$id3)
			->where('id_guru',Session::get('id'))
			->orderby("id_pertemuan","DESC")->get();
			$pelajaran = DB::table('matapelajaran')->where('id_sekolah',Session::get('id_sekolah'))->get();
			return view('daftarpertemuan',['pertemuan' => $pertemuan,'pelajaran' => $pelajaran,'kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            $kelas = DB::table('kelas')->where('id_sekolah',Session::get('id_sekolah'))->get();
			$pertemuan = DB::table('pertemuan')
			->where('id_sekolah',Session::get('id_sekolah'))
			->where('id_matapelajaran',$id3)
			->where('id_kelas',Session::get('id_kelas'))
			->orderby("id_pertemuan","DESC")->get();
			$pelajaran = DB::table('matapelajaran')->where('id_sekolah',Session::get('id_sekolah'))->get();
			return view('daftarpertemuan',['pertemuan' => $pertemuan,'kelas' => $kelas,'pelajaran' => $pelajaran]);
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
    }
	public function prosesreg(Request $request)
	{   
		if(isset($request->tambah)){
			if(!empty(Session::get('name')) and Session::get('level')=='admin'){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
				$kelas = DB::table('kelas')->get();
				return view('daftarkelas',['kelas' => $kelas]);
			}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
				$d_kelas = DB::table('kelas')->where('id_kelas',$request->id_kelas)->get();
				foreach($d_kelas as $row) {
					DB::table('pertemuan')->insert([
					'id_sekolah' => Session::get('id_sekolah'),
					'id_kelas' => $request->id_kelas,
					'id_guru' => Session::get('id'),
					'id_matapelajaran' => $request->id_matapelajaran,
					'n_guru' => Session::get('name'),
					'n_pertemuan' => $request->n_pertemuan,
					'n_kelas' => $row->n_kelas,
					'n_w_kelas' => $row->n_w_kelas,
					'l_v_pembelajaran' => $request->l_v_pembelajaran,
					'a_guru' => 'Belum Absen',
					'tgl_absen_guru' => date("Y-m-d"),
					'tgl_pertemuan' => $request->tgl_pertemuan,
					'created_at' => date("Y-m-d"),
					'updated_at' => date("Y-m-d")
					]);
				}
				$d_pertemuan = DB::table('pertemuan')->where('id_kelas',$request->id_kelas)->get();
				foreach($d_pertemuan as $p){
				}
				$d_siswa = DB::table('siswakelas')->where('id_kelas',$request->id_kelas)->get();
				foreach($d_siswa as $d_s){
					DB::table('pertemuankelas')->insert([
					'id_pertemuan' => $p->id_pertemuan,
					'id_siswa' => $d_s->id_siswa,
					'n_siswa' => $d_s->nama,
					'j_kelamin' => $d_s->j_kelamin,
					'agama' => $d_s->agama,
					'a_siswa' => "Belum",
					'tgl_absen' => date("Y-m-d")
					]);
					DB::table('siswa')->where('id_siswa',$d_s->id_siswa)->update([
					'id_kelas' => $request->id_kelas
					]);
				}
			}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
				return redirect(Session::get('level'));
			}elseif(empty(Session::get('level'))){
				return redirect('siswa');
			}
			Session::flash('sukses','Data Pertemuan Berhasil Ditambah!');
		}
        return redirect('/daftarpertemuan');
	}
	public function tampil(Request $request,$id1)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            $pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->get();
			$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby("id_pertemuankelas", "DESC")->get();
			$daftarhadir= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby("n_siswa", "ASC")->get();
			$modulpertemuan= DB::table('modulpertemuan')->where('id_pertemuan','=',$id1)->orderby("id_modul", "DESC")->get();
			$tugaspertemuan= DB::table('tugaspertemuan')->where('id_pertemuan','=',$id1)->orderby("id_tugaspertemuan", "DESC")->get();
			$chat= DB::table('chat')->where('id_pertemuan','=',$id1)->orderby("id_chat", "DESC")->get();
			$livestream= DB::table('livestreampertemuan')->where('id_pertemuan','=',$id1)->get();
			if(!empty($request->isi)){
			DB::table('chat')->insert([
				'id_pertemuan' => $id1,
				'n_pengirim' => Session::get('name'),
				'isi' => $request->isi,
				'tgl' => date('Y-m-d H:s:i')
			]);
			return redirect('/daftarpertemuan/tampil/'.$id1);
			}
			return view('tampilpertemuan',['pertemuan' => $pertemuan,'pertemuankelas' => $pertemuankelas,'daftarhadir' => $daftarhadir,'modulpertemuan' => $modulpertemuan,'tugaspertemuan' => $tugaspertemuan,'chat'=>$chat,'livestream'=>$livestream]);
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
        	$pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->get();
			$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby("id_pertemuankelas", "DESC")->get();
			$daftarhadir= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby("n_siswa", "ASC")->get();
			$modulpertemuan= DB::table('modulpertemuan')->where('id_pertemuan','=',$id1)->orderby("id_modul", "DESC")->get();
			$tugaspertemuan= DB::table('tugaspertemuan')->where('id_pertemuan','=',$id1)->orderby("id_tugaspertemuan", "DESC")->get();
			$chat= DB::table('chat')->where('id_pertemuan','=',$id1)->orderby("id_chat", "DESC")->get();
			$livestream= DB::table('livestreampertemuan')->where('id_pertemuan','=',$id1)->get();
			if(!empty($request->isi)){
			DB::table('chat')->insert([
				'id_pertemuan' => $id1,
				'n_pengirim' => Session::get('name'),
				'isi' => $request->isi,
				'tgl' => date('Y-m-d H:s:i')
			]);
			return redirect('/daftarpertemuan/tampil/'.$id1);
			}
			return view('tampilpertemuan',['pertemuan' => $pertemuan,'pertemuankelas' => $pertemuankelas,'daftarhadir' => $daftarhadir,'modulpertemuan' => $modulpertemuan,'tugaspertemuan' => $tugaspertemuan,'chat'=>$chat,'livestream'=>$livestream]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			$pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->where('id_guru','=',Session::get('id'))->get();
			$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby("id_pertemuankelas", "DESC")->get();
			$daftarhadir= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby("n_siswa", "ASC")->get();
			$modulpertemuan= DB::table('modulpertemuan')->where('id_pertemuan','=',$id1)->orderby("id_modul", "DESC")->get();
			$tugaspertemuan= DB::table('tugaspertemuan')->where('id_pertemuan','=',$id1)->orderby("id_tugaspertemuan", "DESC")->get();
			$chat= DB::table('chat')->where('id_pertemuan','=',$id1)->orderby("id_chat", "DESC")->get();
			$livestream= DB::table('livestreampertemuan')->where('id_pertemuan','=',$id1)->get();
			if(!empty($request->isi)){
			DB::table('chat')->insert([
				'id_pertemuan' => $id1,
				'n_pengirim' => Session::get('name'),
				'isi' => $request->isi,
				'tgl' => date('Y-m-d H:s:i')
			]);
			return redirect('/daftarpertemuan/tampil/'.$id1);
			}
			return view('tampilpertemuan',['pertemuan' => $pertemuan,'pertemuankelas' => $pertemuankelas,'daftarhadir' => $daftarhadir,'modulpertemuan' => $modulpertemuan,'tugaspertemuan' => $tugaspertemuan,'chat'=>$chat,'livestream'=>$livestream]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            $pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->get();
			$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->where('id_siswa','=',Session::get('id'))->orderby("id_pertemuankelas", "DESC")->get();
			$daftarhadir= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby("n_siswa", "ASC")->get();
			$modulpertemuan= DB::table('modulpertemuan')->where('id_pertemuan','=',$id1)->get();
			$tugaspertemuan= DB::table('tugaspertemuan')->where('id_pertemuan','=',$id1)->get();
			$chat= DB::table('chat')->where('id_pertemuan','=',$id1)->orderby("id_chat", "DESC")->get();
			$livestream= DB::table('livestreampertemuan')->where('id_pertemuan','=',$id1)->get();
			if(!empty($request->isi)){
			DB::table('chat')->insert([
				'id_pertemuan' => $id1,
				'n_pengirim' => Session::get('name'),
				'isi' => $request->isi,
				'tgl' => date('Y-m-d H:s:i')
			]);
			return redirect('/daftarpertemuan/tampil/'.$id1);
			}
			return view('tampilpertemuan',['pertemuan' => $pertemuan,'pertemuankelas' => $pertemuankelas,'daftarhadir' => $daftarhadir,'modulpertemuan' => $modulpertemuan,'tugaspertemuan' => $tugaspertemuan,'chat'=>$chat,'livestream'=>$livestream]);
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function edit($id1)
	{
		if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='guru')){
			if(Session::get('level')=='sekolah'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan',$id1)->get();
				$pelajaran = DB::table('matapelajaran')->where('id_sekolah',Session::get('id_sekolah'))->get();
				return view('editpertemuan',['pertemuan' => $pertemuan,'pelajaran'=>$pelajaran]);
			}elseif(Session::get('level')=='guru'){
				$pertemuan= DB::table('pertemuan')->where('id_pertemuan',$id1)->get();
				$pelajaran = DB::table('matapelajaran')->where('id_sekolah',Session::get('id_sekolah'))->get();
				$kelas = DB::table('kelas')->where('id_sekolah',Session::get('id_sekolah'))->get();
				return view('editpertemuan',['pertemuan' => $pertemuan,'pelajaran'=>$pelajaran,'kelas'=>$kelas]);
			}else{
				return redirect(Session::get('level'));
			}
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function tambahlivestream(Request $request)
	{
		if($request->tambah){
			if(!empty(Session::get('name')) and Session::get('level')=='admin'){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
				DB::table('livestreampertemuan')->insert([
				'id_pertemuan' => $request->id_pertemuan,
				'id_sekolah' => Session::get('id_sekolah'),
				'id_guru' => Session::get('id'),
				'embed' => $request->fb_livestream
				]); 
			}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
				return redirect(Session::get('level'));
			}elseif(empty(Session::get('level'))){
				return redirect('siswa');
			} 
			Session::flash('sukses','Data LiveStream Facebook Berhasil Ditambah!');  
		}
        return redirect('/daftarpertemuan/tampil/'.$request->id_pertemuan);
	}
	public function delstream($id1,$id2)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$kelas = DB::table('kelas')->get();
    		return view('daftarkelas',['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			DB::table('livestreampertemuan')->where('id_livestreampertemuan',$id2)->delete();
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
		Session::flash('sukses','Data Facebook Live Stream Berhasil Dihapus!');
		return redirect('/daftarpertemuan/tampil/'.$id1);
	}
	public function prosesedit(Request $request)
	{
		if($request->simpan){
		//$c_d_user=DB::table('guru')->where('username','=',$request->username)->count();
			//if($c_d_user == 0){
				if(!empty(Session::get('name')) and (Session::get('level')=='sekolah' or Session::get('level')=='guru')){
					if(Session::get('level')=='sekolah'){
						return redirect(Session::get('level'));
					}elseif(Session::get('level')=='guru'){
							DB::table('pertemuan')->where('id_pertemuan',$request->id_pertemuan)->update([
							'id_matapelajaran' => $request->id_matapelajaran,
							//'id_kelas' => $request->id_kelas,
							'n_pertemuan' => $request->n_pertemuan,
							//'n_kelas' => $row->n_kelas,
							//'n_w_kelas' => $row->n_w_kelas,
							'l_v_pembelajaran' => $request->l_v_pembelajaran,
							//'tgl_pertemuan' => $request->tgl_pertemuan,
							'updated_at' => date("Y-m-d")
						]);
					}else{
						return redirect(Session::get('level'));
					}
				}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
					return redirect(Session::get('level'));
				}elseif(empty(Session::get('level'))){
					return redirect('siswa');
				}
			Session::flash('sukses','Data Pertemuan Berhasil Diubah!');
			return redirect('/daftarpertemuan/edit/'.$request->id_pertemuan);
		}
	}
	public function tambahmodul(Request $request)
	{
		if($request->tambah){
			if(!empty(Session::get('name')) and Session::get('level')=='admin'){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
				$kelas = DB::table('kelas')->get();
				return view('daftarkelas',['kelas' => $kelas]);
			}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
				DB::table('modulpertemuan')->insert([
				'id_pertemuan' => $request->id_pertemuan,
				'id_sekolah' => Session::get('id_sekolah'),
				'id_guru' => Session::get('id'),
				'n_modul' => $request->n_modul,
				'file' => $request->file
				]); 
			}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
				return redirect(Session::get('level'));
			}elseif(empty(Session::get('level'))){
				return redirect('siswa');
			} 
			Session::flash('sukses','Data Materi Berhasil Ditambah!');  
		}
        return redirect('/daftarpertemuan/tampil/'.$request->id_pertemuan);
	}
	public function delmodul($id1,$id2)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$kelas = DB::table('kelas')->get();
    		return view('daftarkelas',['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			DB::table('modulpertemuan')->where('id_modul',$id1)->delete();
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
		Session::flash('sukses','Data Materi Berhasil Dihapus!');
		return redirect('/daftarpertemuan/tampil/'.$id2);
	}
	public function tambahtugas(Request $request)
	{
		if($request->tambah){
			if(!empty(Session::get('name')) and Session::get('level')=='admin'){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
				$kelas = DB::table('kelas')->get();
				return view('daftarkelas',['kelas' => $kelas]);
			}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
				if(!empty($request->n_tugas) and !empty($request->deskripsi) and !empty($request->linktugas) and !empty($request->file) and !empty($request->tgl) and !empty($request->jam)){
					$file = $request->file('file');
					$nama_file = time()."_".$file->getClientOriginalName();
					$tujuan_upload = 'soal/';
					$file->move($tujuan_upload,$nama_file);
					DB::table('tugaspertemuan')->insert([
					'id_pertemuan' => $request->id_pertemuan,
					'n_tugas' => $request->n_tugas,
					'deskripsi' => $request->deskripsi,
					'linktugas' => $request->linktugas,
					'f_tugas' => $nama_file,
					'tgl_kumpul' => $request->tgl.' '.$request->jam.':59'
					]);
				}elseif(empty($request->file) and empty($request->linktugas)){
					DB::table('tugaspertemuan')->insert([
						'id_pertemuan' => $request->id_pertemuan,
						'n_tugas' => $request->n_tugas,
						'deskripsi' => $request->deskripsi,
						'tgl_kumpul' => $request->tgl.' '.$request->jam.':59'
					]);
				}elseif(empty($request->file)){
					DB::table('tugaspertemuan')->insert([
						'id_pertemuan' => $request->id_pertemuan,
						'n_tugas' => $request->n_tugas,
						'deskripsi' => $request->deskripsi,
						'linktugas' => $request->linktugas,
						'tgl_kumpul' => $request->tgl.' '.$request->jam.':59'
					]);
				}elseif(empty($request->linktugas)){
					$file = $request->file('file');
					$nama_file = time()."_".$file->getClientOriginalName();
					$tujuan_upload = 'soal/';
					$file->move($tujuan_upload,$nama_file);
					DB::table('tugaspertemuan')->insert([
						'id_pertemuan' => $request->id_pertemuan,
						'n_tugas' => $request->n_tugas,
						'deskripsi' => $request->deskripsi,
						'f_tugas' => $nama_file,
						'tgl_kumpul' => $request->tgl.' '.$request->jam.':59'
					]);
				}
				$nilaipertemuan= DB::table('pertemuankelas')->where('id_pertemuan','=',$request->id_pertemuan)->get();
				foreach($nilaipertemuan as $m_n){
					$tugaspertemuan= DB::table('tugaspertemuan')->where('id_pertemuan','=',$request->id_pertemuan)->get();
					foreach($tugaspertemuan as $t_p){
						DB::table('nilaipertemuan')->insert([
						'id_tugaspertemuan' => $t_p->id_tugaspertemuan,
						'id_pertemuan' => $m_n->id_pertemuan,
						'id_siswa' => $m_n->id_siswa
						]);
					}
				}
			}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
				return redirect(Session::get('level'));
			}elseif(empty(Session::get('level'))){
				return redirect('siswa');
			}
		}
		Session::flash('sukses','Data Tugas Berhasil Ditambah!');
		return redirect('/daftarpertemuan/tampil/'.$request->id_pertemuan);
	}
	public function tambahsoal(Request $request)
	{
		if($request->tambah=="Tambah"){
			$d_tugaspertemuan=DB::table('tugaspertemuan')->where('id_tugaspertemuan',$request->id_tugaspertemuan)->get();
			if(!empty(Session::get('name')) and Session::get('level')=='admin'){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
				foreach($d_tugaspertemuan as $t){
					DB::table('soalnilaipertemuan')->insert([
					'id_tugaspertemuan' => $t->id_tugaspertemuan,
					'id_pertemuan' => $t->id_pertemuan,
					'soal' => $request->soal,
					'created_at' => date("Y-m-d"),
					'updated_at' => date("Y-m-d")
					]);
					$d_jawab=DB::table('nilaipertemuan')->where(
					'id_tugaspertemuan',$t->id_tugaspertemuan
					)->where(
					'id_pertemuan',$t->id_pertemuan
					)->get();
					foreach($d_jawab as $s){
						$d_soalnilaipertemuan=DB::table('soalnilaipertemuan')
						->where('id_tugaspertemuan',$request->id_tugaspertemuan)
						->where('id_pertemuan',$t->id_pertemuan)->get();
						foreach($d_soalnilaipertemuan as $d_s){
							DB::table('jawabannilaipertemuan')->insert([
							'id_soalnilaipertemuan' => $d_s->id_soalnilaipertemuan,
							'id_nilaipertemuan' => $s->id_nilaipertemuan,
							'id_tugaspertemuan' => $s->id_tugaspertemuan,
							'id_pertemuan' => $s->id_pertemuan,
							'id_siswa' => $s->id_siswa,
							'jawaban' => 'Kosong',
							'created_at' => date("Y-m-d"),
							'updated_at' => date("Y-m-d")
							]);
						}
					}
				}
			}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
				return redirect(Session::get('level'));
			}elseif(empty(Session::get('level'))){
				return redirect('siswa');
			}
		}elseif($request->upload){
			echo "hallo";
		}
		Session::flash('sukses','Data Soal Berhasil Ditambah!');
		foreach($d_tugaspertemuan as $t_p){
			return redirect('/daftarpertemuan/tampil/'.$t_p->id_pertemuan.'/nilai/'.$request->id_tugaspertemuan);
		}
	}
	public function deltugas($id1,$id2)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$kelas = DB::table('kelas')->get();
    		return view('daftarkelas',['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			$gambar=DB::table('tugaspertemuan')->where('id_tugaspertemuan',$id1)->get();
			foreach($gambar as $g){
			File::delete('soal/'.$g->f_tugas);
			}
			DB::table('tugaspertemuan')->where('id_tugaspertemuan',$id1)->delete();
			DB::table('nilaipertemuan')->where('id_pertemuan',$id2)->delete();
			DB::table('soalnilaipertemuan')->where('id_pertemuan',$id2)->delete();
			DB::table('jawabannilaipertemuan')->where('id_pertemuan',$id2)->delete();
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
		Session::flash('sukses','Data Tugas Berhasil Dihapus!');
		return redirect('/daftarpertemuan/tampil/'.$id2);
	}
	public function nilai($id1,$id2)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$kelas = DB::table('kelas')->get();
    		return view('daftarkelas',['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			$pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->get();
			$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby('n_siswa','ASC')->get();
			$modulpertemuan= DB::table('modulpertemuan')->where('id_pertemuan','=',$id1)->get();
			$tugaspertemuan= DB::table('tugaspertemuan')->where('id_tugaspertemuan','=',$id2)->get();
			$nilaipertemuan= DB::table('nilaipertemuan')->where('id_tugaspertemuan','=',$id2)->get();
			$soalnilaipertemuan= DB::table('soalnilaipertemuan')->where('id_pertemuan','=',$id1)->where('id_tugaspertemuan','=',$id2)->orderby("id_tugaspertemuan", "DESC")->get();
		}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            $pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->get();
			$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->orderby('n_siswa','ASC')->get();
			$modulpertemuan= DB::table('modulpertemuan')->where('id_pertemuan','=',$id1)->get();
			$tugaspertemuan= DB::table('tugaspertemuan')->where('id_tugaspertemuan','=',$id2)->get();
			$nilaipertemuan= DB::table('nilaipertemuan')->where('id_tugaspertemuan','=',$id2)->where('id_siswa','=',Session::get('id'))->get();
			$soalnilaipertemuan= DB::table('soalnilaipertemuan')->where('id_pertemuan','=',$id1)->where('id_tugaspertemuan','=',$id2)->orderby("id_tugaspertemuan", "DESC")->get();
		}elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
		return view('tampilnilai',['pertemuan' => $pertemuan,'pertemuankelas' => $pertemuankelas,'modulpertemuan' => $modulpertemuan,'tugaspertemuan' => $tugaspertemuan,'nilaipertemuan' => $nilaipertemuan,'soalnilaipertemuan'=>$soalnilaipertemuan]);
	}

	public function upjawaban(Request $request)
	{
		if($request->jawab){
			if(!empty(Session::get('name')) and Session::get('level')=='admin'){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
				$kelas = DB::table('kelas')->get();
				return view('daftarkelas',['kelas' => $kelas]);
			}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
				if(!empty($request->file) or !empty($request->jawaban) or !empty($request->linkjawaban) and !empty($request->esai)){
					if(!empty($request->file)){
						$file = $request->file('file');
						$nama_file = time()."_".$file->getClientOriginalName();
						$tujuan_upload = 'tugas/';
						$file->move($tujuan_upload,$nama_file);
						DB::table('nilaipertemuan')->where(
						//'id_siswa',$request->id_siswa)->where(
						'id_nilaipertemuan',$request->id_nilaipertemuan//)->where(
						//'id_tugaspertemuan',$request->id_tugaspertemuan)->where(
						//'id_pertemuan',$request->id_pertemuan
						)->update([
						'file' => $nama_file,
						'tgl_jawab'=>date('Y-m-d H:i:s'),
						's_jawaban'=>'Sudah'
						]);
					}
					if(!empty($request->jawaban)){
						DB::table('nilaipertemuan')->where(
						'id_siswa',Session::get('id'))->where(
						'id_nilaipertemuan',$request->id_nilaipertemuan//)->where(
						//'id_tugaspertemuan',$request->id_tugaspertemuan)//->where(
						//'id_pertemuan',$request->id_pertemuan
						)->update([
						'jawaban' => $request->jawaban,
						'tgl_jawab'=>date('Y-m-d H:i:s'),
						's_jawaban'=>'Sudah'
						]);
					}
					if(!empty($request->linkjawaban)){					
						DB::table('nilaipertemuan')->where(
						'id_siswa',Session::get('id'))->where(
						'id_nilaipertemuan',$request->id_nilaipertemuan//)->where(
						//'id_tugaspertemuan',$request->id_tugaspertemuan)->where(
						//'id_pertemuan',$request->id_pertemuan
						)->update([
						'linkjawaban' => $request->linkjawaban,
						'tgl_jawab'=>date('Y-m-d H:i:s'),
						's_jawaban'=>'Sudah'
						]);
					}
					if(!empty($request->id_soalnilaipertemuan)){
						$jumlah_id = count($request->id_soalnilaipertemuan);
						$jumlah_esai = count($request->esai);
						for($i=0;$i<$jumlah_id;$i++){
							for($k=0;$k<$jumlah_esai;$k++){
								if($i==$k){
									DB::table('jawabannilaipertemuan')->where('id_soalnilaipertemuan',$request->id_soalnilaipertemuan[$i])->where('id_siswa',Session::get('id'))->update([
									'jawaban' => $request->esai[$i],
									'updated_at' => date("Y-m-d")
									]);
								}
							}
						}
						Session::flash('sukses','Jawaban Anda Terkirim!');
					}else{
						Session::flash('gagal','Maaf Anda Tidak Menjawab Essai!');
					}
				Session::flash('sukses','Anda Berhasil Menjawab!');
				return redirect('daftarpertemuan/tampil/'.$request->id_pertemuan.'/nilai/'.$request->id_tugaspertemuan);
				}else{
					Session::flash('gagal','Maaf Anda Tidak Menjawab Essai!');
				}
			}elseif(empty(Session::get('level'))){
				return redirect('siswa');
			}
		}
		
	}
	public function hadirguru($id)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			DB::table('pertemuan')->where(
				'id_pertemuan',$id
				)->update([
				'a_guru' => 'Hadir',
				'tgl_absen_guru' => date('Y-m-d H:i:s')
			]);
			Session::flash('sukses','Anda Hadir!');
			return redirect('daftarpertemuan/tampil/'.$id);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	public function hadirsiswa($id1,$id2)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
			DB::table('pertemuankelas')->where('id_pertemuan',$id1)->where('id_siswa',$id2
				)->update([
				'a_siswa' => 'Hadir',
				'tgl_absen' => date('Y-m-d H:i:s')
			]);
			Session::flash('sukses','Anda Hadir!');
			return redirect('daftarpertemuan/tampil/'.$id1);
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	
	public function berinilai($id1,$id2,$id3,$id4)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$kelas = DB::table('kelas')->get();
    		return view('daftarkelas',['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			$pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->get();
			$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->where('id_siswa','=',$id4)->get();
			$tugaspertemuan= DB::table('tugaspertemuan')->where('id_tugaspertemuan','=',$id3)->get();
			$nilaipertemuan= DB::table('nilaipertemuan')->where('id_tugaspertemuan','=',$id3)->where('id_siswa','=',$id4)->get();
			$soalnilaipertemuan= DB::table('soalnilaipertemuan')->where('id_pertemuan','=',$id1)->where('id_tugaspertemuan','=',$id3)->orderby("id_tugaspertemuan", "DESC")->get();
			return view('berinilai',[
				'pertemuan' => $pertemuan,
				'pertemuankelas' => $pertemuankelas,
				'tugaspertemuan' => $tugaspertemuan,
				'nilaipertemuan' => $nilaipertemuan,
				'soalnilaipertemuan' => $soalnilaipertemuan
			]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            $pertemuan= DB::table('pertemuan')->where('id_pertemuan','=',$id1)->get();
			$pertemuankelas= DB::table('pertemuankelas')->where('id_pertemuan','=',$id1)->where('id_siswa','=',$id4)->get();
			$tugaspertemuan= DB::table('tugaspertemuan')->where('id_tugaspertemuan','=',$id3)->get();
			$nilaipertemuan= DB::table('nilaipertemuan')->where('id_tugaspertemuan','=',$id3)->where('id_siswa','=',$id4)->get();
			$soalnilaipertemuan= DB::table('soalnilaipertemuan')->where('id_pertemuan','=',$id1)->where('id_tugaspertemuan','=',$id3)->orderby("id_tugaspertemuan", "DESC")->get();
			return view('berinilai',[
				'pertemuan' => $pertemuan,
				'pertemuankelas' => $pertemuankelas,
				'tugaspertemuan' => $tugaspertemuan,
				'nilaipertemuan' => $nilaipertemuan,
				'soalnilaipertemuan' => $soalnilaipertemuan
			]);
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
	}
	
	public function upnilai(Request $request)
	{
		if($request->beri){
			if(!empty(Session::get('name')) and Session::get('level')=='admin'){
				return redirect(Session::get('level'));
			}elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
				$kelas = DB::table('kelas')->get();
				return view('daftarkelas',['kelas' => $kelas]);
			}elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
				DB::table('nilaipertemuan')->where(
					'id_siswa',$request->id_siswa)->where(
					'id_nilaipertemuan',$request->id_nilaipertemuan)->where(
					'id_tugaspertemuan',$request->id_tugaspertemuan)->where(
					'id_pertemuan',$request->id_pertemuan
					)->update([
					'nilai' => $request->nilai
				]);
				Session::flash('sukses','Anda Berhasil Menambahkan Nilai!');
			}elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
				return redirect(Session::get('level'));
			}elseif(empty(Session::get('level'))){
				return redirect('siswa');
			}
		}
		return redirect('daftarpertemuan/tampil/'.$request->id_pertemuan.'/nilai/'.$request->id_tugaspertemuan);
	}

	public function delete($id)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$kelas = DB::table('kelas')->get();
    		return view('daftarkelas',['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			DB::table('pertemuan')->where('id_pertemuan',$id)->delete();
			DB::table('pertemuankelas')->where('id_pertemuan',$id)->delete();
			DB::table('tugaspertemuan')->where('id_pertemuan',$id)->delete();
			DB::table('nilaipertemuan')->where('id_pertemuan',$id)->delete();
			DB::table('modulpertemuan')->where('id_pertemuan',$id)->delete();
			DB::table('soalnilaipertemuan')->where('id_pertemuan',$id)->delete();
			DB::table('jawabannilaipertemuan')->where('id_pertemuan',$id)->delete();
			Session::flash('sukses','Data Pertemuan Berhasil Dihapus!');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
		return redirect('/daftarpertemuan');
	}
	public function delsoal($id1,$id2,$id3)
	{
		if(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect(Session::get('level'));
        }elseif(!empty(Session::get('name')) and (Session::get('level')=='sekolah')){
			$kelas = DB::table('kelas')->get();
    		return view('daftarkelas',['kelas' => $kelas]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
			DB::table('soalnilaipertemuan')->where('id_soalnilaipertemuan',$id3)->delete();
			DB::table('jawabannilaipertemuan')->where('id_soalnilaipertemuan',$id3)->delete();
			Session::flash('sukses','Data Soal Berhasil Dihapus!');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect(Session::get('level'));
        }elseif(empty(Session::get('level'))){
			return redirect('siswa');
		}
		return redirect('daftarpertemuan/tampil/'.$id1.'/nilai/'.$id2);
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
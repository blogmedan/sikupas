<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Siswa;
use Session;
use Crypt;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
 
 
class DashboardController extends Controller
{
    public function admin(){
        if(!empty(Session::get('name')) and (Session::get('level')=='admin') or Session::get('level')=='superadmin'){
            $sekolah = DB::table('sekolah')->count();
            $pertemuan = DB::table('pertemuan')->count();
    		return view('admin',['sekolah' => $sekolah,'pertemuan' => $pertemuan]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='sekolah'){
            return redirect('sekolah');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
            return redirect('guru');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect('siswa');
        }else{
            return view('loginadmin');
        }
    }
    public function sekolah(){
        if(!empty(Session::get('name')) and Session::get('level')=='sekolah'){
            /*$jlhkelas = DB::table('kelas')->where('id_sekolah','=',Session::get('id_sekolah'))->count();
            $kelas = DB::table('kelas')->where('id_sekolah','=',Session::get('id_sekolah'))->get();
            if($jlhkelas < 1){
                $pertemuan=0;
                return view('sekolah',['pertemuan' => $pertemuan]);
            }else{
            */
                //foreach($kelas as $k){
                    $pertemuan = DB::table('pertemuan')->where('id_sekolah','=',Session::get('id_sekolah'))->count();
                    return view('sekolah',['pertemuan' => $pertemuan]);
                //}
            //}
        }elseif(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect('admin');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='guru'){
            return redirect('guru');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            return redirect('siswa');
        }else{
            return view('loginsekolah');
        }
    }
    public function guru(){
        if(!empty(Session::get('name')) and Session::get('level')=='guru'){
            $pertemuan = DB::table('pertemuan')->where('id_guru',Session::get('id'))->count();
    		return view('guru',['pertemuan' => $pertemuan]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect('admin');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='sekolah'){
            return redirect('sekolah');
        }elseif(!empty(Session::get('sekolah')) and Session::get('level')=='siswa'){
            return redirect('siswa');
        }else{
            return view('loginguru');
        }
    }
    public function siswa(){
        if(!empty(Session::get('name')) and Session::get('level')=='siswa'){
            $pertemuan = DB::table('pertemuan')->where('id_kelas',Session::get('id_kelas'))->count();
    		return view('siswa',['pertemuan' => $pertemuan]);
        }elseif(!empty(Session::get('name')) and Session::get('level')=='admin'){
            return redirect('admin');
        }elseif(!empty(Session::get('name')) and Session::get('level')=='sekolah'){
            return redirect('sekolah');
        }elseif(!empty(Session::get('sekolah')) and Session::get('level')=='guru'){
            return redirect('guru');
        }else{
            return view('loginsiswa');
        }
    }
}
?>
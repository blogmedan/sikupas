<?php

namespace App\Http\Controllers;

use App\ModelUser;
use App\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Crypt;

class LoginController extends Controller
{
    public function loginadmin(Request $request){

        $username = $request->username;
        $password = $request->password;

        $data = DB::table('dinas')->where('username',$request->username)->first();
        //$customKey = "blogmedan123456"; 
        //return Crypt::encrypt( $customKey );
        if($data){
            if(Crypt::decrypt($data->password) == $request->password){
                Session::put('id',$data->id_dinas);
                Session::put('created_at',$data->created_at);
                Session::put('name',$data->n_pegawai);
                Session::put('username',$data->username);
                Session::put('login',TRUE);
                Session::put('level',$data->level);
                DB::table('dinas')->where('id_dinas',$data->id_dinas)->update([
                    's_login' => 'Login',
                    'login_at' => date("Y-m-d h:i:s")
                ]);
                DB::table('log')->insert([
                    'nama' => $data->n_pegawai,
                    'username' => $data->username,
                    'level' => $data->level,
                    'status' => 'Online',
                    'login_at' => date("Y-m-d h:i:s")
                ]);
                return redirect('admin')->with('alert-success','Anda Berhasil Login !');
            }
            else{
                return redirect('admin')->with('alert','Password atau Email, Salah !');
            }
        }else{
            return redirect('admin')->with('alert','Password atau Email, Salah!');
        }
    }


    public function loginsekolah(Request $request){

        $username = $request->username;
        $password = $request->password;

        $data = DB::table('sekolah')->where('username',$request->username)->first();
        if($data){
            if(Crypt::decrypt($data->password) == $request->password){
                Session::put('id_sekolah',$data->id_sekolah);
                Session::put('created_at',$data->created_at);
                Session::put('name',$data->n_sekolah);
                Session::put('username',$data->username);
                Session::put('login',TRUE);
                Session::put('level',$data->level);
                DB::table('sekolah')->where('id_sekolah',$data->id_sekolah)->update([
                    's_login' => 'Login',
                    'login_at' => date("Y-m-d h:i:s")
                ]);
                DB::table('log')->insert([
                'nama' => $data->n_sekolah,
                'username' => $data->username,
                'level' => $data->level,
                'status' => 'Online',
                'login_at' => date("Y-m-d h:i:s")
                ]);
                return redirect('sekolah')->with('alert-success','Anda Berhasil Login !');
            }else{
                return redirect('sekolah')->with('alert','Password atau Email, Salah !');
            }
        }else{
            return redirect('sekolah')->with('alert','Password atau Email, Salah!');
        }
    }


    public function loginguru(Request $request){

        $username = $request->username;
        $password = $request->password;

        $data = DB::table('guru')->where('username',$request->username)->first();
        if($data){
            if(Crypt::decrypt($data->password) == $request->password){
                Session::put('id',$data->id_guru);
                Session::put('id_sekolah',$data->id_sekolah);
                Session::put('created_at',$data->created_at);
                Session::put('name',$data->n_guru);
                Session::put('name1',$data->a_sekolah);
                Session::put('username',$data->username);
                Session::put('login',TRUE);
                Session::put('level',$data->level);
                DB::table('guru')->where('id_guru',$data->id_guru)->update([
                    's_login' => 'Login',
                    'login_at' => date("Y-m-d H:i:s")
                ]);
                DB::table('log')->insert([
                    'nama' => $data->n_guru,
                    'username' => $data->username,
                    'level' => $data->level,
                    'status' => 'Login',
                    'login_at' => date("Y-m-d H:i:s")
                ]);
                return redirect('guru')->with('alert-success','Anda Berhasil Login !');
            }
            else{
                //return redirect('guru')->with('alert','Maaf Bapak Ibu Aplikasi Untuk Guru Sedang Diupgrade !');
                return redirect('guru')->with('alert','Password atau Email, Salah !');
            }
        }else{
            return redirect('guru')->with('alert','Password atau Email, Salah!');
        }
    }


    public function loginsiswa(Request $request){

        $username = $request->username;
        $password = $request->password;

        $data = DB::table('siswa')->where('username',$request->username)->first();
        if($data){
            if(Crypt::decrypt($data->password) == $request->password){
                Session::put('id',$data->id_siswa);
                Session::put('id_sekolah',$data->id_sekolah);
                Session::put('id_kelas',$data->id_kelas);
                Session::put('created_at',$data->created_at);
                Session::put('name',$data->nama);
                Session::put('username',$data->username);
                Session::put('login',TRUE);
                Session::put('level',$data->level);
                DB::table('siswa')->where('id_siswa',$data->id_siswa)->update([
                    's_login' => 'Login',
                    'login_at' => date("Y-m-d H:i:s")
                ]);
                DB::table('log')->insert([
                    'nama' => $data->nama,
                    'username' => $data->username,
                    'level' => $data->level,
                    'status' => 'Login',
                    'login_at' => date("Y-m-d H:i:s")
                ]);
                return redirect('siswa')->with('alert-success','Anda Berhasil Login !');
            }
            else{
                return redirect('siswa')->with('alert','Password atau Email, Salah !');
            }
        }else{
            return redirect('siswa')->with('alert','Password atau Email, Salah!');
        }
    }

    
    public function logout(){
        if(!empty(Session::get('level'))){
            DB::table('log')->insert([
                'nama' => Session::get('name'),
                'username' => Session::get('username'),
                'level' => Session::get('level'),
                'status' => 'Logout',
                'login_at' => date("Y-m-d h:i:s")
            ]);
            if(Session::get('level')=="admin" or Session::get('level')=="superadmin"){
                DB::table('dinas')->where('id_dinas',Session::get('id'))->update([
                    's_login' => 'Logout'
                ]);
                Session::flush();
                return redirect('admin')->with('alert','Silahkan Login Kembali!!');
            }elseif(Session::get('level')=="sekolah"){
                DB::table('sekolah')->where('id_sekolah',Session::get('id_sekolah'))->update([
                    's_login' => 'Logout'
                ]);
                Session::flush();
                return redirect('sekolah')->with('alert','Silahkan Login Kembali!!');
            }elseif(Session::get('level')=="guru"){
                DB::table('guru')->where('id_guru',Session::get('id'))->update([
                    's_login' => 'Logout'
                ]);
                Session::flush();
                return redirect('guru')->with('alert','Silahkan Login Kembali!!');
            }elseif(Session::get('level')=="siswa"){
                DB::table('siswa')->where('id_siswa',Session::get('id'))->update([
                    's_login' => 'Logout'
                ]);
                Session::flush();
                return redirect('siswa')->with('alert','Silahkan Login Kembali!!');
            }else{
                return redirect('siswa')->with('alert','Kamu Sudah Keluar!!');
            }
        }else{
             return redirect('siswa')->with('alert','Kamu Sudah Keluar!!');
        }
    }

    /*public function register(Request $request){
        return view('register');
    }

    /*public function registerPost(Request $request){
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|min:4|email|unique:users',
            'password' => 'required',
            'confirmation' => 'required|same:password',
        ]);

        $data =  new ModelUser();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->save();
        return redirect('login')->with('alert-success','Kamu berhasil Register');
    }*/
}
?>
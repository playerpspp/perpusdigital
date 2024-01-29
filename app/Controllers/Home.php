<?php

namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\M_model;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/*
//
*/

class Home extends BaseController
{

    protected function checkAuth()
    {
        $id_user = session()->get('id_user');
        if ($id_user != null) {
            return true;
        } else {
            return false;
        }
    }

//<------------------------------------------------------Tampilan Awal dan Settings---------------------------------------------------->

public function index()// login
{
    if ($this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        echo view('login');
    
}

public function register()// register
{
    if ($this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        echo view('register');
    
}

public function aksi_register()   //Proses register
{
        $n=$this->request->getPost('username'); //mengambil username dan password dari halaman register
        $p=$this->request->getPost('password');
        $name= $this->request->getPost('name');
        $notelp= $this->request->getPost('notelp');
        $model= new M_model();
        $user=array(
            'user.username'=>$n, 
            'user.password'=>md5($p),
            'user.level'=>3

        );

        $model=new M_model();
        $iduser=$model->simpanID('user', $user);


        //Yang ditambah ke member
        $member=array(
            'nama'=>$name,
            'no_telp'=>$notelp,
            'user_id'=>$iduser
        );
        $model->simpan('member', $member);


        $data=array(
            'user.username'=>$n, //memasukan username dan password ke satu STRING($) 
            'user.password'=>md5($p),
        );
        $on="member.user_id=user.id_user";
        $cek=$model->fusionArray('member','user',$on, $data);
        if ($cek>0) {

            session()->set('id_user', $cek['id_user']);
            session()->set('username', $cek['nama_member']);
            session()->set('foto', $cek['foto']);
            session()->set('level', $cek['level']);
            return redirect()->to('home/dashboard');
        }else {
            $error = "Wrong Username or Password";
            return redirect()->back()->with('error', $error);
        }
    }




public function aksi_login()   //Proses Login
{
        $n=$this->request->getPost('name'); //mengambil username dan password dari halaman Login
        $p=$this->request->getPost('password');
        $model= new M_model();
        $data=array(
            'user.username'=>$n, //memasukan username dan password ke satu STRING($) 
            'user.password'=>md5($p)

        );
        $on="member.user_id=user.id_user";
        $on2="karyawan.user_id=user.id_user";
        $cek=$model->fusionArray('member','user',$on, $data);
        $cek2=$model->fusionArray('karyawan','user',$on2, $data);
        if ($cek>0) {

            session()->set('id_user', $cek['id_user']);
            session()->set('username', $cek['nama_member']);
            session()->set('foto', $cek['foto']);
            session()->set('level', $cek['level']);
            return redirect()->to('home/dashboard');

        }elseif ($cek2>0) {

            session()->set('id_user', $cek2['id_user']);
            session()->set('username', $cek2['nama_karyawan']);
            session()->set('foto', $cek2['foto']);
            session()->set('level', $cek2['level']);
            return redirect()->to('home/dashboard');

        }else {
            $error = "Wrong Username or Password";
            return redirect()->back()->with('error', $error);
        }
    }

   

    public function profile()  
    {

        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }

            $id=session()->get('id_user');
            $where2=array('user.id_user'=>$id);
            $model=new M_model();
            if(session()->get('level')== 3){
            $on="member.user_id=user.id_user";
            $data['data']=$model->fusionRow('member','user',$on, $where2);
            }else{
            $on2="karyawan.user_id=user.id_user";
            $data['data']=$model->fusionRow('karyawan','user',$on2, $where2);
            }

           


          
            echo view('profile',$data);

    
    }

    public function ganti_pass()  
    {
        if (!$this->checkAuth()) {
            return redirect()->to(base_url('/home'));
        }

      
            echo view('ganti_pass');
            
       
    }

    public function aksi_ganti_password()   
    {
        $p=$this->request->getPost('pswd');
        $id=session()->get('id_user');
        $model= new M_model();

        $data=array( 
            'password'=>md5($p)
        );
        
        $where=array('id_user'=>$id);
        $model->edit('user', $data, $where);
        return redirect()->to('/home');
    }

    public function aksi_ganti_profil()
    {
        $model= new M_model();
        $id=session()->get('id_user');
        $where=array('id_user'=>$id);
        $photo=$this->request->getFile('foto');
        
        if($_FILES['foto']['error'] !=4 && file_exists(PUBLIC_PATH."/images/avatar/".session()->get('foto')) ) 
        {
            unlink(PUBLIC_PATH."/images/avatar/".session()->get('foto'));
            session()->remove('foto');
        }elseif($photo == '')
        {
            $username= $this->request->getPost('username');
        

            $user=array(
                'username'=>$username,
            );
            $model->edit('user', $user,$where);

         
            return redirect()->to('/home/profile');
        }

        $username= $this->request->getPost('username');
     

        $img = $photo->getRandomName();
        $photo->move(PUBLIC_PATH.'/images/avatar/',$img);
        $user=array(
            'username'=>$username,
            'foto'=>$img
        );
        $model=new M_model();
        $model->edit('user', $user,$where);

        session()->set('foto', $img);

        return redirect()->to('/home/profile');
    }
    
    
    public function log_out()
    {
       

           session()->destroy();
           return redirect()->to('/');

     

}




public function dashboard()
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home'));
    }

        $model=new M_model();
        $id=session()->get('id');
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere('peminjaman',$where2);

        echo view('dashboard',$kui);

    // print_r(session()->get());

   
}




}

















/*

*/
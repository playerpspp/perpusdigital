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

//<------------------------------------------------------Tampilan Awal dan Settings---------------------------------------------------->

public function index()// login
{
    if(session()->get('id')>0 ) {
        return redirect()->to('home/dashboard');

    }else{

        echo view('login');
    }
}

public function aksi_login()   //Proses Login
{
        $n=$this->request->getPost('username'); //mengambil username dan password dari halaman Login
        $p=$this->request->getPost('pswd');
        $model= new M_model();
        $data=array(
            'username'=>$n, //memasukan username dan password ke satu STRING($) 
            'password'=>md5($p)

        );
        $cek=$model->getarray('user', $data);
        if ($cek>0) {

            session()->set('id', $cek['id_user']);
            session()->set('username', $cek['username']);
            session()->set('foto', $cek['foto']);
            session()->set('level', $cek['level']);
            return redirect()->to('home/dashboard');

        }else {
            return redirect()->to('/');
        }
    }

    public function reset_p($id)
    {
        $model=new M_model();
        $where=array('id_user'=>$id);
        $data=array(
            'password'=>md5('12345')
        );
        $model->edit('user',$data,$where);
        return redirect()->to('Home/t_user');
    }

    public function ganti_profil()  
    {
        if(session()->get('id')>0 ) {

            $id=session()->get('id');
            $where2=array('id_user'=>$id);
            $model=new M_model();
            $pakif['karkar']=$model->getRow('karyawan',$where2);
            $pakif['use']=$model->getRow('user',$where2);

            $id=session()->get('id');
            $where1=array('id_user'=>$id);
            $kui['foto']=$model->getRow('user',$where1);
            $kui['buku']=$model->tampil('buku');
            $kui['user']=$model->tampil('user');
            $kui['karyawan']=$model->tampil('karyawan');
            $where=array('status'=>'0');
            $tgl=date('y-m-d');
            $where2=array('status'=>'1');
            $kui['pinjam']=$model->getWhere('peminjaman',$where);
            $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);


            echo view('header',$kui);
            echo view('menu',$kui);
            echo view('ganti_profil',$pakif);
            echo view('footer');

        }else{

            echo view('login');
        }
    }

    public function ganti_pass()  
    {
        if(session()->get('id')>0 ) {

            $id=session()->get('id');
            $where2=array('id_user'=>$id);
            $model=new M_model();
            $pakif['karkar']=$model->getRow('karyawan',$where2);
            $pakif['use']=$model->getRow('user',$where2);

            $id=session()->get('id');
            $where1=array('id_user'=>$id);
            $kui['foto']=$model->getRow('user',$where1);
            $kui['buku']=$model->tampil('buku');
            $kui['user']=$model->tampil('user');
            $kui['karyawan']=$model->tampil('karyawan');
            $where=array('status'=>'0');
            $tgl=date('y-m-d');
            $where2=array('status'=>'1');
            $kui['pinjam']=$model->getWhere('peminjaman',$where);
            $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);


            echo view('header',$kui);
            echo view('menu',$kui);
            echo view('ganti_pass',$pakif);
            echo view('footer');
            
        }else{

            echo view('login');
        }
    }

    public function aksi_ganti_password()   
    {
        $p=$this->request->getPost('pswd');
        $id=session()->get('id');
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
        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $photo=$this->request->getFile('foto');
        $kui=$model->getRow('user',$where);
        if($_FILES['foto']['error'] !=4 && file_exists(PUBLIC_PATH."/images/avatar/".$kui->foto) ) 
        {
            unlink(PUBLIC_PATH."/images/avatar/".$kui->foto);
        }elseif($photo == '')
        {
            $username= $this->request->getPost('username');
            $name= $this->request->getPost('name');
            $nik= $this->request->getPost('nik');
            $jk= $this->request->getPost('jk');

            $user=array(
                'username'=>$username,
            );
            $model->edit('user', $user,$where);

            $karyawan=array(
                'nama'=>$name,
                'NIK'=>$nik,
                'JK'=>$jk,
            );
            $model->edit('karyawan', $karyawan, $where);
            return redirect()->to('/home/ganti_profil');
        }

        $username= $this->request->getPost('username');
        $name= $this->request->getPost('name');
        $nik= $this->request->getPost('nik');
        $jk= $this->request->getPost('jk');

        $img = $photo->getRandomName();
        $photo->move(PUBLIC_PATH.'/images/avatar/',$img);
        $user=array(
            'username'=>$username,
            'foto'=>$img
        );
        $model=new M_model();
        $model->edit('user', $user,$where);

        $karyawan=array(
            'nama'=>$name,
            'NIK'=>$nik,
            'JK'=>$jk,
        );
        $where=array('id_user'=>$id);
        $model->edit('karyawan', $karyawan, $where);

        return redirect()->to('/home/ganti_profil');
    }
    
    
    public function log_out()
    {
        if(session()->get('id')>0) {

           session()->destroy();
           return redirect()->to('/');

       }else{
        return redirect()->to('/');
    }

}



//<------------------------------------------------------Tampilan Dashboard------------------------------------------------------------>

public function dashboard()
{
    if(session()->get('id')>0) {

        $model=new M_model();
        $id=session()->get('id');
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);
        echo view('header',$kui);
        echo view('menu',$kui);
        // echo view('dashboard',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home');
    }
}




//
//<--------------------------------------------------------Tabel Perpus---------------------------------------------------------------->

public function t_buku()
{
    if(session()->get('level')== 2) {
        return redirect()->to('/home');
    }elseif(session()->get('level')>0 ){

        $model=new M_model();
        $on='buku.id_user=karyawan.id_user';
        $kui['duar']=$model->fusion('buku', 'karyawan', $on);

        $id=session()->get('id');
        $where1=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where1);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);


        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('t_buku',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function t_peminjaman()
{
    if(session()->get('level')>0) {

        $model=new M_model();
        $on='peminjaman.id_buku=buku.id_buku';
        $on2='peminjaman.id_user=karyawan.id_user';
        $where=array('status'=>'0');
        $kui['duar']=$model->super_w('peminjaman','buku','karyawan',$on,$on2,$where);

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);

        
        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('t_peminjaman',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function t_pengembalian()
{
    if(session()->get('level')>0) {

        $model=new M_model();
        $on='peminjaman.id_buku=buku.id_buku';
        $on2='peminjaman.id_user_kembali=karyawan.id_user';
        $where=array('status'=>'1');
        $kui['duar']=$model->super_w('peminjaman','buku','karyawan',$on,$on2,$where);

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);

        
        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('t_pengembalian',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function t_karyawan()
{
    if(session()->get('level')== 1) {

        $model=new M_model();
        $on=('karyawan.id_user=user.id_user');
        $kui['duar']=$model->fusion('karyawan','user',$on);

        echo view('header');
        echo view('menu');
        echo view('karyawan',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function t_user()
{
    if(session()->get('level')== 1) {

        $model=new M_model();
        $kui['duar']=$model->tampil('user');

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);

        
        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('user',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

/*

*/


//<---------------------------------------------------------Tambah Tabel--------------------------------------------------------------->

public function tambah_b()
{
    if(session()->get('level')== 2) {
        return redirect()->to('/home');
    }elseif(session()->get('level')>0 ){

        $model=new M_model();
        $kui['duar']=$model->tampil('buku');

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);

        
        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('tambah_b',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function tambah_pj()
{
    if(session()->get('level')== 3) {
        return redirect()->to('/home');
    }elseif(session()->get('level')>0 ){

        $model=new M_model();
        $kui['duar']=$model->tampil('buku');

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);

        
        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('tambah_pj',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function tambah_k()
{
    if(session()->get('level')== 1) {

        $model=new M_model();
        $kui['duar']=$model->tampil('karyawan');

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);

        
        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('tambah_karyawan',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}


//
//<---------------------------------------------------------Aksi Tambah Tabel--------------------------------------------------------->

public function aksi_tambah_b()
{
    $model=new M_model();
    $nama=$this->request->getPost('name');
    $kode=$this->request->getPost('kode');
    $harga=$this->request->getPost('harga');
    $id=session()->get('id');
    $data=array(
        'nama_buku'=>$nama,
        'kode_buku'=>$kode,
        'harga'=>$harga,
        'id_user'=>$id,
    );
    $model->simpan('buku',$data);
    return redirect()->to('/Home/t_buku');
}

public function aksi_tambah_pj()
{
    $model=new M_model();
    $nama=$this->request->getPost('name');
    $harga=$this->request->getPost('harga');
    $peminjam=$this->request->getPost('peminjam');
    $id=session()->get('id');
    $data=array(
        'id_buku'=>$nama,
        'harga'=>$harga,
        'nama_peminjam'=>$peminjam,
        'tgl_pinjam'=>date('y-m-d'),
        'status'=>'0',
        'id_user'=>$id,
    );
    $model->simpan('peminjaman',$data);
    return redirect()->to('Home/t_peminjaman');
}


public function aksi_pengembalian($id)
{
    $model=new M_model();
    $where=array('id_pinjam'=>$id);
    $id=session()->get('id');
    $data=array(
        'status'=>'1',
        'tgl_kembali'=>date('y-m-d'),
        'id_user_kembali'=>$id,
    );
    $model->edit('peminjaman',$data,$where);
    return redirect()->to('Home/t_pengembalian');
}

public function aksi_tambah_karyawan()
{
    $username= $this->request->getPost('username');
    $pass= $this->request->getPost('pass');
    $name= $this->request->getPost('name');
    $nik= $this->request->getPost('nik');
    $jk= $this->request->getPost('jk');
    $lv= $this->request->getPost('lv');

    //Yang ditambah ke user
    $user=array(
        'username'=>$username,
        'password'=>$pass,
        'level'=>$lv,
    );
    $model=new M_model();
    $model->simpan('user', $user);
    $where=array('username'=>$username);
    $id=$model->getarray('user', $where);
    $iduser = $id['id_user'];

    //Yang ditambah ke karyawan
    $karyawan=array(
        'nama'=>$name,
        'NIK'=>$nik,
        'JK'=>$jk,
        'id_user'=>$iduser
    );
    $model->simpan('karyawan', $karyawan);
    return redirect()->to('home/t_karyawan');
}


//

//<-------------------------------------------------------Edit Tabel------------------------------------------------------------------->

public function edit_b($id)
{
    if(session()->get('level')== 1) {

        $model=new M_model();
        $where=array('id_buku'=>$id);
        $kui['gas']=$model->getRow('buku', $where);

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);

        
        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('edit_b',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function edit_k($id)
{
    if(session()->get('level')== 1) {

        $model=new M_model();
        $where2=array('id_user'=>$id);
        $pakif['karkar']=$model->getRow('karyawan',$where2);
        $pakif['use']=$model->getRow('user',$where2);

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);

        
        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('edit_karyawan',$pakif);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

/*

*/
//<----------------------------------------------------Aksi Edit Tabel----------------------------------------------------------------->

public function aksi_edit_b()
{
    $model=new M_model();
    $id=$this->request->getPost('id');
    $nama=$this->request->getPost('name');
    $kode=$this->request->getPost('kode');
    $harga=$this->request->getPost('harga');
    $data=array(
        'nama_buku'=>$nama,
        'kode_buku'=>$kode,
        'harga'=>$harga,
    );
    $where=array('id_buku'=>$id);
    $model->edit('buku',$data,$where);
    return redirect()->to('/Home/t_buku');
}

public function aksi_edit_karyawan()
{
    $id= $this->request->getPost('id');
    $id2= $this->request->getPost('id2');
    $username= $this->request->getPost('username');
    $pass= $this->request->getPost('pass');
    $name= $this->request->getPost('name');
    $nik= $this->request->getPost('nik');
    $jk= $this->request->getPost('jk');

    //Yang ditambah ke user
    $where=array('id_user'=>$id);
    $user=array(
        'username'=>$username,
        'password'=>$pass,
    );
    $model=new M_model();
    $model->edit('user', $user,$where);

    //Yang ditambah ke karyawan
    $where2=array('id_kw'=>$id2);
    $karyawan=array(
        'nama'=>$name,
        'NIK'=>$nik,
        'JK'=>$jk,
    );
    $model->edit('karyawan', $karyawan, $where2);
    return redirect()->to('home/t_karyawan');
}


//

//<----------------------------------------------------Hapus Tabel--------------------------------------------------------------------->

public function hapus_b($id)
{
    if(session()->get('level')== 1 ) {
        $model=new M_model();
        $where=array('id_buku'=>$id);
        $model->hapus('buku',$where);
        return redirect()->to('Home/t_buku');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function hapus_peminjaman($id)
{
    if(session()->get('level')== 3) {
        return redirect()->to('/home');
    }elseif(session()->get('level')>0 ){

        $model=new M_model();
        $where=array('id_pinjam'=>$id);
        $model->hapus('peminjaman',$where);
        return redirect()->to('Home/t_peminjaman');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function hapus_k($id)
{
    if(session()->get('level')== 2) {

        $model=new M_model();
        $where=array('id_user'=>$id);
        $model->hapus('karyawan',$where);
        $model->hapus('user',$where);
        return redirect()->to('Home/t_karyawan');

    }else{
        return redirect()->to('/home/dashboard');
    }
}



//<---------------------------------------------------------Laporan Tabel----------------------------------------------------------->

public function l_buku()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $kui['kunci']='view_b';

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);

        
        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('filter',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function l_peminjaman()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $kui['kunci']='view_pj';

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);

        
        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('filter',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

public function l_pengembalian()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $kui['kunci']='view_pg';

        $id=session()->get('id');
        $where=array('id_user'=>$id);
        $kui['foto']=$model->getRow('user',$where);
        $kui['buku']=$model->tampil('buku');
        $kui['user']=$model->tampil('user');
        $kui['karyawan']=$model->tampil('karyawan');
        $where=array('status'=>'0');
        $tgl=date('y-m-d');
        $where2=array('status'=>'1');
        $kui['pinjam']=$model->getWhere('peminjaman',$where);
        $kui['kembali']=$model->getWhere2('peminjaman',$where2,$tgl);

        
        echo view('header',$kui);
        echo view('menu',$kui);
        echo view('filter',$kui);
        echo view('footer');

    }else{
        return redirect()->to('/home/dashboard');
    }
}

//

//<-----------------------------------------------------------Laporan Print------------------------------------------------------------>

public function cari_b()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter2('buku',$awal,$akhir);

        $img = file_get_contents(
            'C:\xampp\htdocs\perpus\public\images\KOP_PH.jpg');

        $kui['foto'] = base64_encode($img);

        echo view('c_b',$kui);

    }else{
        return redirect()->to('/home/dashboard');
    }
}
//

public function cari_pj()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter_pj('peminjaman',$awal,$akhir);

        $img = file_get_contents(
            'C:\xampp\htdocs\perpus\public\images\KOP_PH.jpg');

        $kui['foto'] = base64_encode($img);

        echo view('c_pj', $kui);

    }else{
        return redirect()->to('/home/dashboard');
    }
}//


public function cari_pg()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter_pg('peminjaman',$awal,$akhir);

        $img = file_get_contents(
            'C:\xampp\htdocs\perpus\public\images\KOP_PH.jpg');

        $kui['foto'] = base64_encode($img);

        echo view('c_pg', $kui);

    }else{
        return redirect()->to('/home/dashboard');
    }
}
//


//<-----------------------------------------------------------Laporan Excel------------------------------------------------------------>


public function excel_b()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $data_buku= $model->filter2('buku',$awal,$akhir);
        // echo view('excel_print_buku',$data);

        $spreadsheet=new Spreadsheet();
        // tulis header/nama kolom
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Nama Buku')
        ->setCellValue('B1', 'Kode Buku')
        ->setCellValue('C1', 'Harga')
        ->setCellValue('D1', 'Tanggal')
        ->setCellValue('E1', 'Nama Karyawan');

        $column=2;
        //tulis data
        foreach($data_buku as $data){
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'. $column, $data->nama_buku)
            ->setCellValue('B'. $column, $data->kode_buku)
            ->setCellValue('C'. $column, $data->harga)
            ->setCellValue('D'. $column, $data->tanggal)
            ->setCellValue('E'. $column, $data->nama);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new XLsx($spreadsheet);
        $fileName = 'Data Buku';

        // Redirect hasil xlsx ke web client
        header('Content-type:vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition:attachment;filename='.$fileName.'.xls');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }else {
        return redirect()->to('home/dashboard');
    }
}
//

public function excel_pj()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $data_buku=$model->filter_pj('peminjaman',$awal,$akhir);
        // echo view('excel_print_pj', $data);

        $spreadsheet=new Spreadsheet();
        // tulis header/nama kolom
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Nama Buku')
        ->setCellValue('B1', 'Harga')
        ->setCellValue('C1', 'Nama Peminjam')
        ->setCellValue('D1', 'Tanggal Peminjaman')
        ->setCellValue('D1', 'Nama Karyawan');

        $column=2;
        //tulis data
        foreach($data_buku as $data){
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'. $column, $data->nama_buku)
            ->setCellValue('B'. $column, $data->harga)
            ->setCellValue('C'. $column, $data->nama_peminjam)
            ->setCellValue('D'. $column, $data->tgl_pinjam)
            ->setCellValue('E'. $column, $data->nama);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new XLsx($spreadsheet);
        $fileName = 'Data Pinjaman Buku';

        // Redirect hasil xlsx ke web client
        header('Content-type:vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition:attachment;filename='.$fileName.'.xls');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }else{
        return redirect()->to('/home/dashboard');
    }
}
//

public function excel_pg()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $data_buku=$model->filter_pg('peminjaman',$awal,$akhir);
        // echo view('excel_print_pg', $data);

        $spreadsheet=new Spreadsheet();
        // tulis header/nama kolom
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Nama Buku')
        ->setCellValue('B1', 'Harga')
        ->setCellValue('C1', 'Nama Peminjam')
        ->setCellValue('D1', 'Tanggal Peminjaman')
        ->setCellValue('E1', 'Tanggal Kembali')
        ->setCellValue('F1', 'Nama Karyawan');

        $column=2;
        //tulis data
        foreach($data_buku as $data){
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'. $column, $data->nama_buku)
            ->setCellValue('B'. $column, $data->harga)
            ->setCellValue('C'. $column, $data->nama_peminjam)
            ->setCellValue('D'. $column, $data->tgl_pinjam)
            ->setCellValue('E'. $column, $data->tgl_kembali)
            ->setCellValue('F'. $column, $data->nama);
            $column++;
        }
        // tulis dalam format .xlsx
        $writer = new XLsx($spreadsheet);
        $fileName = 'Data Pengembalian Buku';

        // Redirect hasil xlsx ke web client
        header('Content-type:vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition:attachment;filename='.$fileName.'.xls');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }else{
        return redirect()->to('/home/dashboard');
    }
}


//

//<-----------------------------------------------------------Laporan PDF-------------------------------------------------------------->

public function pdf_b()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter2('buku',$awal,$akhir);
        $img = file_get_contents(
            'C:\xampp\htdocs\perpus\public\images\KOP_PH.jpg');

        $kui['foto'] = base64_encode($img);

        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', TRUE);

        $dompdf->loadHtml(view('c_b',$kui));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('Daftar Buku.pdf',array('Attachment'=>0));
        
    }else{
        return redirect()->to('/Home/dashboard');
    }
}

public function pdf_pj()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter_pj('peminjaman',$awal,$akhir);
        $img = file_get_contents(
            'C:\xampp\htdocs\perpus\public\images\KOP_PH.jpg');

        $kui['foto'] = base64_encode($img);

        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', TRUE);

        $dompdf->loadHtml(view('c_pj',$kui));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('Daftar Pinjaman.pdf',array('Attachment'=>0));

    }else{
        return redirect()->to('/Home/dashboard');
    }
}

public function pdf_pg()
{
    if(session()->get('level')== 1 ||session()->get('level')== 3 ) {

        $model=new M_model();
        $awal= $this->request->getPost('awal');
        $akhir= $this->request->getPost('akhir');
        $kui['duar']=$model->filter_pg('peminjaman',$awal,$akhir);
        $img = file_get_contents(
            'C:\xampp\htdocs\perpus\public\images\KOP_PH.jpg');

        $kui['foto'] = base64_encode($img);

        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', TRUE);

        $dompdf->loadHtml(view('c_pg',$kui));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('Daftar Pengembalian.pdf',array('Attachment'=>0));

    }else{
        return redirect()->to('/Home/dashboard');
    }
}

public function coba(){
    echo view('coba');
    echo PUBLIC_PATH;
    echo session()->get('foto');
}

public function coba2(){
    $id=session()->get('id');
    $foto=$this->request->getFile('foto');
    if(file_exists(PUBLIC_PATH."/images/avatar/".$id.".jpg")) {unlink(PUBLIC_PATH."/images/avatar/".$id.".jpg");}else{}

//Place it into your "uploads" folder mow using the move_uploaded_file() function
    $foto->move(PUBLIC_PATH.'/images/avatar/',$id.'.jpg');

    $im =$this->request->getFile('foto');
    $img = $im->getName();

    $model= new M_model();
    $data=array( 
        'foto'=>$img
    );

    $where=array('id_user'=>$id);
    $model->edit('user', $data, $where);
    print_r($foto);
    session()->set('foto', $img);
    $kui['duar']=$model->getwhere('user',$where);
    echo view ('coba2',$kui);

}
//
//<-----------------------------------------------------------Penutup------------------------------------------------------------------->



}

















/*

*/
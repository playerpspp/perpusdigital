<?php

namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\M_model;


class Karyawan extends BaseController
{

    protected function checkAuth()
    {
        $id_user = session()->get('id_user');
        $level = session()->get('level');
        if ($id_user != null && $level == 1) {
            return true;
        } else {
            return false;
        }
    }

public function index()
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $on="karyawan.user_id=user.id_user";
        $on2="user.level=level.id";
        $data['data']=$model->super('karyawan','user','level',$on,$on2);

        echo view('karyawan/karyawan',$data);

   
}

public function reset_p($id)
{
    $model=new M_model();
    $where=array('id_user'=>$id);
    $data=array(
        'password'=>md5('12345')
    );
    $model->edit('user',$data,$where);
    return redirect()->to('/karyawan');
}

//<---------------------------------------------------------Tambah Tabel--------------------------------------------------------------->


public function tambah()
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }
    $model=new M_model();
    $data['levels']=$model->tampil('level');
        echo view('karyawan/tambah',$data);

   
}


//
//<---------------------------------------------------------Aksi Tambah Tabel--------------------------------------------------------->


public function aksi_tambah()
{
    $username= $this->request->getPost('username');
    $pass= 12345;
    $name= $this->request->getPost('name');
    $NIK= $this->request->getPost('NIK');
    $JK= $this->request->getPost('JK');
    $lv= $this->request->getPost('level');

    //Yang ditambah ke user
    $user=array(
        'username'=>$username,
        'password'=>md5($pass),
        'level'=>$lv,
    );
    $model=new M_model();
    $iduser=$model->simpanID('user', $user);

    //Yang ditambah ke karyawan
    $karyawan=array(
        'nama_karyawan'=>$name,
        'NIK'=>$NIK,
        'JK'=>$JK,
        'user_id'=>$iduser
    );
    $model->simpan('karyawan', $karyawan);
    return redirect()->to('/karyawan');
}


//

//<-------------------------------------------------------Edit Tabel------------------------------------------------------------------->


public function edit($id)
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $where2=array('user.id_user'=>$id);
        $on= "karyawan.user_id=user.id_user";
        $data['data']=$model->fusionRow('karyawan','user',$on,$where2);
        $data['levels']=$model->tampil('level');

      
        echo view('karyawan/edit',$data);

   
}

/*

*/
//<----------------------------------------------------Aksi Edit Tabel----------------------------------------------------------------->

public function aksi_edit()
{
    $id= $this->request->getPost('id');
    $username= $this->request->getPost('username');
    $name= $this->request->getPost('name');
    $NIK= $this->request->getPost('NIK');
    $JK= $this->request->getPost('JK');
    $lv= $this->request->getPost('level');

    //Yang ditambah ke user
    $where=array('id_user'=>$id);
    $user=array(
        'username'=>$username,
        'level'=>$lv,
    );
    $model=new M_model();
    $model->edit('user', $user,$where);

    //Yang ditambah ke karyawan
    $where2=array('user_id'=>$id);
    $karyawan=array(
        'nama_karyawan'=>$name,
        'NIK'=>$NIK,
        'JK'=>$JK,
    );
    $model->edit('karyawan', $karyawan, $where2);
    return redirect()->to('/karyawan');
}

public function hapus($id)
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $where=array('id_user'=>$id);
        $where2=array('user_id'=>$id);
        $model->hapus('karyawan',$where2);
        $model->hapus('user',$where);
        return redirect()->to('/karyawan');

   
}

}

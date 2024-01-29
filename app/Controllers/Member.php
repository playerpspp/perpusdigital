<?php

namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\M_model;


class Member extends BaseController
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
        $on="member.user_id=user.id_user";
        $on2="user.level=level.id";
        $data['data']=$model->super('member','user','level',$on,$on2);

        echo view('member/member',$data);

   
}

public function reset_p($id)
{
    $model=new M_model();
    $where=array('id_user'=>$id);
    $data=array(
        'password'=>md5('12345')
    );
    $model->edit('user',$data,$where);
    return redirect()->to('/member');
}

//<---------------------------------------------------------Tambah Tabel--------------------------------------------------------------->


public function tambah()
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }
        
        echo view('member/tambah');

   
}


//
//<---------------------------------------------------------Aksi Tambah Tabel--------------------------------------------------------->


public function aksi_tambah()
{
    $username= $this->request->getPost('username');
    $pass= 12345;
    $name= $this->request->getPost('name');
    $notelp= $this->request->getPost('notelp');
    $lv= 3;

    //Yang ditambah ke user
    $user=array(
        'username'=>$username,
        'password'=>md5($pass),
        'level'=>$lv,
    );
    $model=new M_model();
    $iduser=$model->simpanID('user', $user);


    //Yang ditambah ke member
    $member=array(
        'nama_member'=>$name,
        'no_telp'=>$notelp,
        'user_id'=>$iduser
    );
    $model->simpan('member', $member);
    return redirect()->to('/member');
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
        $on= "member.user_id=user.id_user";
        $data['data']=$model->fusionRow('member','user',$on,$where2);

      
        echo view('member/edit',$data);

   
}

/*

*/
//<----------------------------------------------------Aksi Edit Tabel----------------------------------------------------------------->

public function aksi_edit()
{
    $id= $this->request->getPost('id');
    $username= $this->request->getPost('username');
    $name= $this->request->getPost('name');
    $notelp= $this->request->getPost('notelp');

    //Yang ditambah ke user
    $where=array('id_user'=>$id);
    $user=array(
        'username'=>$username,
    );
    $model=new M_model();
    $model->edit('user', $user,$where);

    //Yang ditambah ke karyawan
    $where2=array('user_id'=>$id);
    $member=array(
        'nama_member'=>$name,
        'no_telp'=>$notelp,
    );
    $model->edit('member', $member, $where2);
    return redirect()->to('/member');
}

public function hapus($id)
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $where=array('id_user'=>$id);
        $where2=array('user_id'=>$id);
        $model->hapus('member',$where2);
        $model->hapus('user',$where);
        return redirect()->to('/member');

   
}

}

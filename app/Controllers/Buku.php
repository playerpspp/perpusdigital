<?php

namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\M_model;


class Buku extends BaseController
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


public function index()
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $on='buku.id_user=karyawan.user_id';
        $data['data']=$model->fusion('buku', 'karyawan', $on);

        $where=array('status' => 0);
        $data['pinjam']=$model->getWhereKey('peminjaman', $where, 'id_buku');
        

        if(session()->get('level')== 3){
            $where2 = array('favorit.user_id' => session()->get('id_user'));
            $data['favorit']=$model->getWhereKey('favorit',$where2,'buku_id');
            // print_r($data['favorit']);

        }

        
        echo view('buku/buku',$data);

    
}

public function ulasan($id)
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $on='ulasan.buku_id=buku.id_buku';
        $on2='ulasan.user_id=member.user_id';
        $data['data']=$model->super_w('ulasan', 'buku','member', $on,$on2, array('ulasan.buku_id' => $id));

        $data['buku']=$model->getRow('buku',array('buku.id_buku' => $id));


        
        echo view('buku/ulasan',$data);

    
}

public function tambah_ulasan($idbuku)
{
    $model=new M_model();
    $chat=$this->request->getPost('chat-message');
    $id=session()->get('id_user');
    $data=array(
        'ulasan'=>$chat,
        'user_id'=>$id,
        'buku_id'=>$idbuku,
    );
    $model->simpan('ulasan',$data);
    return redirect()->to('buku/ulasan/'.$idbuku);
}

public function favorit()
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $on='buku.id_user=karyawan.user_id';
        $data['data']=$model->fusion('buku', 'karyawan', $on);

        $where=array('status' => 0);
        $data['pinjam']=$model->getWhereKey('peminjaman', $where, 'id_buku');
        

        if(session()->get('level')== 3){
            $where2 = array('favorit.user_id' => session()->get('id_user'));
            $data['favorit']=$model->getWhereKey('favorit',$where2,'buku_id');
            // print_r($data['favorit']);

        }


        
        echo view('buku/favorit',$data);
}

public function tambah_favorit($idbuku)
{
    $model=new M_model();
    $id=session()->get('id_user');
    $data=array(
        'user_id'=>$id,
        'buku_id'=>$idbuku,
    );
    $model->simpan('favorit',$data);
    return redirect()->to('buku/favorit/');
}

public function hapus_favorit($idbuku)
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $where=array('buku_id'=>$idbuku, 'user_id'=>session()->get('id_user'));
        $model->hapus('favorit',$where);
        return redirect()->to('/buku/favorit');
}

//<---------------------------------------------------------Tambah Tabel--------------------------------------------------------------->

public function tambah()
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }


        
       
        echo view('buku/tambah');

    
}



//
//<---------------------------------------------------------Aksi Tambah Tabel--------------------------------------------------------->

public function aksi_tambah()
{
    $model=new M_model();
    $nama=$this->request->getPost('name');
    $kode=$this->request->getPost('kode');
    $lokasi=$this->request->getPost('lokasi');
    $stok=$this->request->getPost('stok');
    $kategori=$this->request->getPost('kategori');
    $id=session()->get('id');
    $data=array(
        'nama_buku'=>$nama,
        'kode_buku'=>$kode,
        'lokasi'=>$lokasi,
        
        'kategori'=>$kategori,
        'id_user'=>$id,
    );
    $model->simpan('buku',$data);
    return redirect()->to('/buku');
}

//<-------------------------------------------------------Edit Tabel------------------------------------------------------------------->

public function edit($id)
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $where=array('id_buku'=>$id);
        $kui['data']=$model->getRow('buku', $where);
        
        echo view('buku/edit',$kui);

    
}

//<----------------------------------------------------Aksi Edit Tabel----------------------------------------------------------------->

public function aksi_edit()
{
    $model=new M_model();
    $id=$this->request->getPost('id');
    $nama=$this->request->getPost('name');
    $kode=$this->request->getPost('kode');
    $lokasi=$this->request->getPost('lokasi');
    $stok=$this->request->getPost('stok');
    $kategori=$this->request->getPost('kategori');
    $id=session()->get('id');
    $data=array(
        'nama_buku'=>$nama,
        'kode_buku'=>$kode,
        'lokasi'=>$lokasi,
        
        'kategori'=>$kategori,
        'id_user'=>$id,
    );
    $where=array('id_buku'=>$id);
    $model->edit('buku',$data,$where);
    return redirect()->to('/buku');
}

//<----------------------------------------------------Hapus Tabel--------------------------------------------------------------------->

public function hapus_b($id)
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $where=array('id_buku'=>$id);
        $model->hapus('buku',$where);
        return redirect()->to('/buku');


}

}

















/*

*/
<?php

namespace App\Controllers;
use CodeIgniter\Controllers;
use App\Models\M_model;

class Peminjaman extends BaseController
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
        $on='peminjaman.id_buku=buku.id_buku';
        $on2='peminjaman.id_user=karyawan.user_id';
        $on3='peminjaman.peminjam_id=member.IDmember';
        if(session()->get('level') !=3 ){
        $data['data']=$model->ultra('peminjaman','buku','karyawan','member',$on,$on2,$on3);
        }else{
            $where= array('member.user_id'=>session()->get('id_user'));
            $data['data']=$model->ultra_w('peminjaman','buku','karyawan','member',$on,$on2,$on3,$where);
        }

        
       
        echo view('peminjaman/peminjaman',$data);

    
}

public function tambah()
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $kui['duar']=$model->tampil('buku');

      

        
       
        echo view('peminjaman/tambah',$kui);

    
}
public function aksi_tambah()
{
    $model=new M_model();
    $kode=$this->request->getPost('kode');
    $harga=$this->request->getPost('harga');
    $peminjam=$this->request->getPost('peminjam');
    $id=session()->get('id_user');


    $where=array('no_telp'=>$peminjam);
    $datapeminjam=$model->getRow('member',$where);

    $where2=array('kode_buku'=>$kode);
    $databuku=$model->getRow('buku',$where2);

    $where3=array('status' => 0, 'id_buku'=>$databuku->id_buku);
        $datapinjam=$model->getRow('peminjaman', $where3);

        if(!empty( $datapinjam)){
            $error['error'] = 'Buku Telah dipinjam';
            echo view('peminjaman/tambah',$error);
        }else{

    $data=array(
        'id_buku'=>$databuku->id_buku,
        'peminjam_id'=>$datapeminjam->IDmember,
        'tgl_pinjam'=>date('y-m-d'),
        'status'=>'0',
        'id_user'=>$id,
    );
    // print_r($data);
    $model->simpan('peminjaman',$data);
    return redirect()->to('/peminjaman');
        }
}


public function pengembalian($id)
{
    $model=new M_model();
    $where=array('id_pinjam'=>$id);
    $data=array(
        'status'=>'1',
        'tgl_kembali'=>date('y-m-d'),
    );
    $model->edit('peminjaman',$data,$where);
    return redirect()->to('/peminjaman');
}


public function hapus_peminjaman($id)
{
    if (!$this->checkAuth()) {
        return redirect()->to(base_url('/home/dashboard'));
    }

        $model=new M_model();
        $where=array('id_pinjam'=>$id);
        $model->hapus('peminjaman',$where);
        return redirect()->to('/peminjaman');

    
}

}

















/*

*/
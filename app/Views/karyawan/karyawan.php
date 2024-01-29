<?= view("layout/head") ?>

<?= view('layout/nav') ?>



<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="card-title">
                    <h3 style="margin-left: 3px;">karyawans</h3>
                </div>
                <a style="margin-left: 5px;" href="/karyawan/tambah"><button class="btn btn-success" title="Add new"><i class="ti-plus"></i></button></a>            
                <div class="card-body">
                    <br>
                    <div class="bootstrap-data-table-panel ">
                    <div class="table-responsive">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="10px">no</th>
                                    <th width="1000px">Name</th>
                                    <th width="1000px">Username</th>
                                    <th width="1000px">NIK</th>
                                    <th width="1000px">Jenis Kelamin</th>
                                    <th width="1000px">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                $no++;
                                ?>

                                <?php foreach ($data as $karyawan) { ?>
                                <tr>
                                    <td width="10px"><?=$no?></td>
                                    <td><?= $karyawan->nama_karyawan ?></td>
                                    <td><?= $karyawan->username ?></td>
                                    <td><?= $karyawan->NIK ?></td>
                                    <td><?= $karyawan->JK ?></td>
                                    
                                    <td>
                                       <a href="<?= base_url("/karyawan/edit/".$karyawan->user_id) ?>"><button class="btn btn-warning" title="Detail"><i class="ti-pencil-alt"></i></button></a>

                                       <a href="<?= base_url("/karyawan/hapus/".$karyawan->user_id) ?>"><button class="btn btn-danger" title="Delete"><i class="ti-trash"></i></button></a>

                                   </td>
                               </tr>
                               <?php
                               $no++;
                                }
                               ?>
                           </tbody>
                       </table>
                   </div>
                    </div>
               </div>
           </div>
       </div>
   </div>
</div>


<?= view('layout/foot') ?>
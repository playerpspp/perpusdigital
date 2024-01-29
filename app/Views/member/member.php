<?= view("layout/head") ?>

<?= view('layout/nav') ?>



<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="card-title">
                    <h3 style="margin-left: 3px;">Members</h3>
                </div>
                <a style="margin-left: 5px;" href="/member/tambah"><button class="btn btn-success" title="Add new"><i class="ti-plus"></i></button></a>            
                <div class="card-body">
                    <br>
                    <div class="bootstrap-data-table-panel ">
                    <div class="table-responsive">
                        <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="10px">no</th>
                                    <th width="1000px">Name</th>
                                    <th width="1000px">Username</th>
                                    <th width="1000px">Nomor Telepon</th>
                                    <th width="1000px">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                $no++;
                                ?>

                                <?php foreach ($data as $member) { ?>
                                <tr>
                                    <td width="10px"><?=$no?></td>
                                    <td><?= $member->nama_member ?></td>
                                    <td><?= $member->username ?></td>
                                    <td><?= $member->no_telp ?></td>
                                    
                                    <td>
                                       <a href="<?= base_url("/member/edit/".$member->user_id) ?>"><button class="btn btn-warning" title="Detail"><i class="ti-pencil-alt"></i></button></a>

                                       <a href="<?= base_url("/member/hapus/".$member->user_id) ?>"><button class="btn btn-danger" title="Delete"><i class="ti-trash"></i></button></a>

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
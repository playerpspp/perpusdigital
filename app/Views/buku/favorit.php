<?= view("layout/head") ?>

<?= view('layout/nav') ?>

<head>
    <title> : Buku</title>
</head>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="card-title">
                    <h3 style="margin-left: 3px;">Buku Favorit</h3>
                </div>
               
                <div class="card-body">
                    <br>
                    <div class="bootstrap-data-table-panel ">
                    <div class="table-responsive">
                  
                                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th width="1000px">Judul</th>
                                    <th width="1000px">Kode</th>
                                    <th width="1000px">Lokasi</th>
                                    <th width="1000px">Kategori</th>
                                    <th width="1000px">status</th>
                                    <th width="1000px">Tanggal Dimasukan</th>
                                    <th width="1000px">Pendata</th>
                                    <th width="1000px">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                $no++;
                                ?>

                                <?php foreach ($data as $key => $buku) { 
                                    if(!empty($favorit[$buku->id_buku])) { ?>
                                    
                                <tr>
                                    <td width="10px"><?=$no?></td>
                                    <td><?= $buku->nama_buku ?></td>
                                    <td><?= $buku->kode_buku ?></td>
                                    <td><?= $buku->lokasi ?></td>
                                    <td><?= $buku->kategori ?></td>
                                    <?php if (!empty($pinjam[$buku->id_buku])) { ?>
                                        <td style="background-color: red; color: white;">Dipinjam</td>
                                    <?php } else { ?>
                                        <td style="background-color: green; color: white;">Masih Ada</td>
                                    <?php } ?>

                                    <td><?= $buku->tanggal_buku ?></td>
                                    <td><?= $buku->nama_karyawan ?></td>
                                    
                                    <td>

                                      
    <a href="<?= base_url("/buku/hapus_favorit/".$favorit[$buku->id_buku]->idfavorit) ?>"><button class="btn btn-danger" title="Unfavorite"><i class="ti-close"></i></button></a>

    <a href="<?= base_url("/buku/ulasan/".$buku->id_buku) ?>"><button class="btn btn-gray" title="Ulasan"><i class="ti-comments"></i></button></a>

                                     
                                   </td>
                               </tr>
                               <?php
                               $no++;
                                } }
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
<!-- //Copyrighted by @playerpspp (Octarianto Lika NG) -->
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Karyawan</h2>
      <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Settings 1</a>
            </li>
            <li><a href="#">Settings 2</a>
            </li>
          </ul>
        </li>
        <li><a class="close-link"><i class="fa fa-close"></i></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div><!-- //Copyrighted by @playerpspp (Octarianto Lika NG) -->
    <div class="x_content">
      <!-- //Copyrighted by @playerpspp (Octarianto Lika NG) -->
      <form enctype="multipart/form-data" method="post" action="<?= base_url('/home/tambah_k/')?>">
        <input type="text" name="jumlah" value="1">

        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
      </form>
      <table id="datatable-buttons" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Jenis Kelamin</th>
            <th>NIK</th>
            <th>Username</th>
            <th>action</th>
          </tr>
        </thead>
        <!-- //Copyrighted by @playerpspp (Octarianto Lika NG) -->
        <tbody>
          <?php
          $no=1;
          foreach ($duar as $gas){
            ?>
            <tr>
              <th><?php echo $no++ ?></th>
              <td><?php echo $gas->nama?></td>
              <td><?php echo $gas->JK?></td>
              <td><?php echo $gas->NIK?></td>
              <td><?php echo $gas->username?></td>
              <td>
                <a href="<?= base_url('/home/edit_k/'.$gas->id_user)?>"><button class="btn btn-warning"><i class="fa fa-edit"></i></button></a>
                <a href="<?= base_url('/home/hapus_k/'.$gas->id_user)?>"><button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
              </td>
            </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= view("layout/head") ?>

<?= view('layout/nav') ?>

<div class="row">
  <div class="col-lg-3">
      <div class="card">
          <div class="stat-widget-one">
              <div class="stat-icon dib"><i class="ti-book color-pruimary border-pruimary"></i>
              </div>
              <div class="stat-content dib">
                  <div class="stat-text">Total Buku</div>
                  <div class="stat-digit"><?php  echo count($buku) ?></div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-lg-3">
      <div class="card">
          <div class="stat-widget-one">
              <div class="stat-icon dib"><i class="ti-export color-danger border-danger"></i>
              </div>
              <div class="stat-content dib">
                  <div class="stat-text">Total Pinjam</div>
                  <div class="stat-digit"><?php  echo count($pinjam) ?></div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-lg-3">
      <div class="card">
          <div class="stat-widget-one">
              <div class="stat-icon dib"><i class="ti-import color-success border-success"></i>
              </div>
              <div class="stat-content dib">
                  <div class="stat-text">Total Pengembalian</div>
                  <div class="stat-digit"><?php  echo count($kembali) ?></div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-lg-3">
      <div class="card">
          <div class="stat-widget-one">
              <div class="stat-icon dib"><i class="ti-user color-warning border-warning"></i></div>
              <div class="stat-content dib">
                  <div class="stat-text">Total Users</div>
                  <div class="stat-digit"><?php  echo count($user) ?></div>
              </div>
          </div>
      </div>
  </div>
</div>


  <?= view('layout/foot') ?>
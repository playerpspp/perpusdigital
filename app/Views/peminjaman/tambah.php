<?= view("layout/head") ?>

<?= view('layout/nav') ?>

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <button class="btn btn-primary" title="Back" onclick="history.back()"><i class="ti-arrow-left"></i></button>
                    <div class="card">
                        <div class="card-title">
                            <h3>Form Tambah Peminjaman</h3>
                        </div>
                        <br>
                        <div class="card-body">


                        <?php if(!empty($error)) { ?>
                        <div style="color: red;"><?= $error?></div> 
                        <?php } ?>

                            
                            <div class="basic-form">
                                <form action="/peminjaman/aksi_tambah" id="form_input" method="POST">
                                    
                                    <div class="form-group">
                                        <label for="kode">Kode buku:</label><br>
                                        <input class="form-control" type="text" id="kode" name="kode" placeholder="Kode Buku" value="<?=old('kode')?>" required>
                                    </div><br>

                                    <div class="form-group">
                                        <label for="peminjam">Nomor Telepon Member:</label><br>
                                        <input class="form-control" type="text" id="peminjam" name="peminjam" placeholder="Nomor Telepon" value="<?=old('peminjam')?>" required>
                                    </div><br>

                                    <button title="Submit" class="btn btn-success" type="submit" id="submitBtn"><i class="ti-save-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
               
<script type="text/javascript">
    document.getElementById("submitBtn").addEventListener("click", function(event){
        event.preventDefault();
        this.disabled = true;
        document.getElementById("form_input").submit();})
    </script>
    <?= view('layout/foot') ?>
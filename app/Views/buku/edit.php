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
                            <h3>Form Edit Buku : <?=$data->nama_buku?></h3>
                        </div>
                        <br>
                        <div class="card-body">


                        <?php if(!empty($error)) { 
                        implode('', $errors->all('<div style="color: red;">:message</div>')); 
                        } ?>

                            
                            <div class="basic-form">
                                <form action="/buku/aksi_edit" id="form_input" method="POST">

                                <input type="hidden"  name="id" value="<?=$data->id_buku?>" required>
                                    
                                <div class="form-group">
                                        <label for="name">Nama Buku:</label><br>
                                        <input class="form-control" type="text" id="name" name="name" placeholder="Name" value="<?= $data->nama_buku?>" required>
                                    </div><br>

                                    <div class="form-group">
                                        <label for="username">Kode Buku:</label><br>
                                        <input class="form-control" type="text" id="username" name="username" placeholder="Username" value="<?= $data->kode_buku?>" required>
                                    </div><br>

                                    <div class="form-group">
                                        <label for="lokasi">Lokasi Buku:</label><br>
                                        <input class="form-control" type="text" id="lokasi" name="lokasi" placeholder="Nomor telepon" value="<?= $data->lokasi?>"  required >
                                    </div><br>

                                    <div class="form-group">
                                        <label for="kategori">Kategori Buku:</label><br>
                                        <input class="form-control" type="text" id="kategori" name="kategori" placeholder="Kategori" value="<?= $data->kategori?>"  required >
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
        document.getElementById("form_input").submit(); })
    </script>
    <?= view('layout/foot') ?>
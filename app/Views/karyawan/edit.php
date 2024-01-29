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
                            <h3>Form Edit Karyawan : <?=$data->nama?></h3>
                        </div>
                        <br>
                        <div class="card-body">


                        <?php if(!empty($error)) { 
                        implode('', $errors->all('<div style="color: red;">:message</div>')); 
                        } ?>

                            
                            <div class="basic-form">
                                <form action="/karyawan/aksi_edit" id="form_input" method="POST">

                                <input type="hidden"  name="id" value="<?=$data->user_id?>" required>
                                    
                                    <div class="form-group">
                                        <label for="name">Nama Member:</label><br>
                                        <input class="form-control" type="text" id="name" name="name" placeholder="Name" value="<?=$data->nama?>" required>
                                    </div><br>

                                    <div class="form-group">
                                        <label for="username">Username Member:</label><br>
                                        <input class="form-control" type="text" id="username" name="username" placeholder="Username" value="<?=$data->username?>" required>
                                    </div><br>

                                    <div class="form-group">
                                        <label for="NIK">NIK karyawan:</label><br>
                                        <input class="form-control" type="text" id="NIK" name="NIK" placeholder="NIK" value="<?=$data->NIK?>"  required >
                                    </div><br>

                                    <div class="form-group">
                                        <label for="JK">Jenis Kelamin karyawan:</label><br>
                                        <select class="form-control" id="JK" name="JK"  required >
                                            <option value="Laki-laki" <?php echo ($data->JK == 'Laki-laki') ? 'selected' : ''; ?> >Laki-laki</option>
                                            <option value="Perempuan" <?php echo ($data->JK == 'Perempuan') ? 'selected' : ''; ?> >Perempuan</option>
                                        </select>
                                    </div><br>

                                    <div class="form-group">
                                        <label>Level</label>
                                        <select required id="level" name="level" class="form-control">
                                            <option value="">-</option>
                                            <?php foreach($levels as $level) { if($level->id != 3){ ?>
                                            <option value="<?= $level->id?>" <?php echo ($data->level == $level->id) ? 'selected' : ''; ?> ><?= $level->level?></option>
                                            <?php } }?>
                                        </select>
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
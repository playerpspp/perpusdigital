<?= view("layout/head") ?>

<?= view('layout/nav') ?>


<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-title">
                            <h3>Ubah password</h3>

                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form  id="form_input" action="/home/aksi_ganti_password" method="POST">                        
                                
                              <div class="form-group">
                                <label>New Password</label>
                                <input type="password" id="pswd" name="pswd" class="form-control" placeholder="Password">
                            </div>
                            

                            <button title="Submit" class="btn btn-success" type="submit" id="submitBtn"><i class="ti-save-alt"></i></button>
                        </form><br>
                        <h5><a href="/home/profile">Mau ganti Profile?</a></h5>
                    </div>
                </div>
            </div>
        </div>
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
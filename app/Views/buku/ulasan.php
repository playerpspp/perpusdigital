<?= view("layout/head") ?>

<?= view('layout/nav') ?>

<head>
    <style type="text/css">
        /*.chat-box {
            width: 98%;
          height: 200px;
          border: 1px solid #000;
          overflow: auto;
          overflow-y: scroll;
          padding: 10px;
          background-color: white;
      }*/

      
  </style>
</head>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-title">
                <h2>Ulasan</h2>
            </div>
            <div class="card-body">
                <div class="chat-box">
                  <div class="chat-messages" id="chat-messages">
                    <?php if (count($data) == 0) { ?>
                    <p>Belum ada Ulasan</p>
                    <?php }else{?>
                    <div class="recent-comment m-t-15">
                        <?php foreach ($data as $ulasan) { ?>
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading color-primary"><?= $ulasan->nama_member ?></h4>
                                <?php if(!empty($ulasan->foto) && file_exists(PUBLIC_PATH."/images/avatar/".$ulasan->foto)){ ?>
                                    <img width="400px" height="400px" src="<?= base_url(PUBLIC_PATH."/images/avatar/".$ulasan->foto)?>" alt="Avatar">
                        <?php }else{ ?>

                         <img class="m-r-10 avatar-img"src="/images/avatar/default.jpg" alt="" />
                         <?php }?>
                                
                                <p><?= $ulasan->ulasan ?></p>
                                <p class="comment-date"><?= $ulasan->tanggal ?></p>
                                <br>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <?php }?>
                </div><br>
            </div>
            <?php  if(session()->get('level')== 3){ ?>
                <h3>Send a message</h3>
                <form id="chat-form" method="POST" action="<?= base_url("/buku/tambah_ulasan/".$buku->id_buku) ?>">
                    <div class="form-group">
                        <textarea required style="height: 80px;" class="form-control" placeholder="Berikan Ulasan" type="text"  class="chat-message" id="chat-message" name="chat-message"></textarea>
                    </div>
                    <button type="submit" id="button-input" class="btn btn-success" title="Send Message">Kirim Ulasan</i></button>
                </form>
                <?php  }else{}?>
                <br>


            </div>
        </div>
    </div>
</div>










<?= view('layout/foot') ?>
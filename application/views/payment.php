
    <section class="row volunteer-content page-content">
        <div class="container">
            <div class="row">
            <div class="col-md-8 center pay">
               <div class="row sectionTitle text-center">
			   
                <?php if($notif=='capture' or $notif=='settlement'){ ?>
                <h3>Terima Kasih atas bantuan anda</h3>
                 <p>Status donasi anda telah <b>Berhasil</b>.</p>
                <?php }elseif ($notif=='pending') { ?>
                 <h3>Terima Kasih atas bantuan anda</h3>
                  <p>Status donasi anda adalah <b>Menunggu</b></p>
                <?php }elseif ($notif=='deny') { ?>
                 <h3>Maaf Donasi anda tidak berhasil</h3>
                  <p>Status donasi anda adalah <b>Gagal</b></p>
                <?php } ?>
                <br/>

                <p>Menggunakan <b><?php echo $type ?></b></p>
                <p>No Invoice anda adalah <b><?php echo $order_id ?></b></p>
                </div>
            </div>
            </div>
        </div>
    </section>

    
<section class="hero-wrap hero-wrap-2" style="background-image: url('<?= BASE_URL . 'dist/assets/img/hero.png' ?>');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate mb-5 text-center">
                <p class="breadcrumbs mb-0"><span class="mr-2"><a>Home <i class="fa fa-chevron-right"></i></a></span><span>Detail Paket <i class="fa fa-chevron-right"></i></span></p>
                <h2 class="mb-0 bread">Detail Paket</h2>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 ftco-animate">
                <a href="<?= BASE_URL . 'dist/assets/img/paket.jpg' ?>" class="image-popup"><img src="<?= BASE_URL . 'dist/assets/img/paket.jpg' ?>" class="img-fluid" alt=""></a>
            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">

                <h3><?= $data['paketData']['judul'] ?> | <?= $data['paketData']['kategori'] ?></h3>
                <p class="price"><span>Rp. <?php echo number_format($data["paketData"]['harga']); ?> / <?= ucfirst($data['paketData']['tipe']) ?></span></p>
                <br>
                <form method="post" action="<?= BASE_URL . 'order' ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id_paket" value="<?= $data['paketData']['id'] ?>">
                    <div class="form-group">
                        <label for="id_metode_pembayaran">Pilih Metode Pembayaran</label>
                        <select name="id_metode_pembayaran" id="id_metode_pembayaran" class="form-control text-left" required>
                            <option value=""></option>
                            <?php foreach ($data['metodePembayaran'] as $key): ?>
                                <option value="<?= $key['id'] ?>"><?= $key['tipe'] ?> | <?= $key['nama'] ?> | <?= $key['nomor_atau_norek'] ?> | <?= $key['atas_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bukti_pembayaran">Bukti Transfer</label>
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" capture="user" class="form-control" required>
                    </div>
                    <?php
                    // Display success flash message
                    $successMessage = $action->getFlashMessage('success');
                    if ($successMessage) {
                        echo '<div class="alert alert-success">' . htmlspecialchars($successMessage) . '</div>';
                    }

                    // Display failed flash message
                    $failedMessage = $action->getFlashMessage('failed');
                    if ($failedMessage) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($failedMessage) . '</div>';
                    }
                    ?>
                    <div class="form-group">
                        <button class="btn btn-success float-right" name="beli"><i class="fa fa-shopping-cart"></i> Beli</button>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>
</section>
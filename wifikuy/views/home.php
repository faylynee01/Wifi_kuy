<div class="hero-wrap" style="background-image: url('<?= BASE_URL . 'dist/assets/img/hero.png' ?>');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-8 ftco-animate d-flex align-items-end">
                <div class="text w-100 text-center">
                    <?php $action->getFlashMessage('failed');
                    $action->getFlashMessage('success'); ?>
                    <h1 class="mb-4">Selamat<span> Datang</span> Di <span><?= $pengaturan['nama_web'] ?></span>.</h1>
                    <p><a href="#paket" class="btn btn-primary py-2 px-4">Lihat Paket Wifi</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="ftco-intro" style="background: #FFC300;">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-md-4 d-flex">
                <div class="intro d-lg-flex w-100 ftco-animate" style="background: #FFC300;">
                    <div class="icon">
                        <span class="flaticon-cashback" style="color: black !important;"></span>
                    </div>
                    <div class="text" style="color: black !important;">
                        <h2 style="color: black !important;">Harga Worth It</h2>
                        <p>Kami menyewa wifi dengan kecepatan yang stabil tentunya!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="intro d-lg-flex w-100 ftco-animate" style="background: #FFC300;">
                    <div class="icon">
                        <span class="flaticon-shopping-bag" style="color: black !important;"></span>
                    </div>
                    <div class="text" style="color: black !important;">
                        <h2 style="color: black !important;">Harga Terjangkau</h2>
                        <p>Paket yang sesuai dengan kebutuhan dari budget Anda</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex">
                <div class="intro d-lg-flex w-100 ftco-animate" style="background: #FFC300;">
                    <div class="icon">
                        <span class="flaticon-support" style="color: black !important;"></span>
                    </div>
                    <div class="text" style="color: black !important;">
                        <h2 style="color: black !important;">Layanan 24 Jam</h2>
                        <p>Melayani Dengan Integritas Dan Pelayanan Yang Terpadu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pb">
    <div class="container">
        <div class="row">
            <div class="col-md-6 img img-3 d-flex justify-content-center align-items-center">
                <img src="<?= BASE_URL . 'dist/assets/img/side.jpg' ?>" width="100%" style="border-radius: 10px">
            </div>
            <div class="col-md-6 wrap-about pl-md-5 ftco-animate py-5">
                <div class="heading-section">
                    <h3 class="mt-4"><b>Sewa WiFi untuk Konektivitas di Satu Tempat Jadi Mudah</h3>
                    <p>Ingin sewa WiFi untuk konektivitas di area tertentu? Kini, hanya dengan satu sentuhan, Anda bisa sewa WiFi online yang siap digunakan di satu kompleks atau lokasi yang Anda inginkan.</p>
                    <p> Cek harga sewa WiFi online di sini, dan pastikan cakupan jaringan sesuai dengan kebutuhan Anda di area tersebut.</p>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="ftco-section" id="paket" style="background-color: #f0f0f0;">
    <div class="container">
        <div class="row justify-content-center pb-5">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <span class="subheading">Paket</span>
                <h2>Pilihan Paket Wifi Kami</h2>
            </div>
        </div>
        <div class="row">

            <!-- LOOP -->
            <?php
            $currentCategory = ''; // Initialize currentCategory to track category changes
            ?>

            <?php foreach ($data['pakets'] as $paket): ?>
                <!-- Check if the category has changed, if so, display the <hr> -->
                <?php if ($paket['kategori'] !== $currentCategory): ?>
                    <?php if ($currentCategory !== ''): ?>
                        <!-- Horizontal line for separation between categories -->
                        <hr style="width: 100%; border-top: 1px solid #000;">
                    <?php endif; ?>
                    <!-- New Category Title -->
                    <div class="col-12">
                        <h3 class="category-title text-center"><?php echo $paket['kategori']; ?></h3>
                    </div>
                    <?php $currentCategory = $paket['kategori']; ?>
                <?php endif; ?>

                <!-- Display the package details (Product Card) -->
                <div class="col-md-4 d-flex">
                    <div class="product ftco-animate">
                        <div class="img d-flex align-items-center justify-content-center" style="background-image: url('<?= BASE_URL . 'dist/assets/img/paket.jpg' ?>');">
                            <div class="desc">
                                <p class="meta-prod d-flex">
                                    <a href="detail/<?php echo $paket['id']; ?>" class="d-flex align-items-center justify-content-center"><span class="flaticon-visibility"></span></a>
                                </p>
                            </div>
                        </div>
                        <div class="text text-center">
                            <h2><?php echo $paket["judul"] ?></h2>
                            <p class="mb-0"><span class="price price-sale"></span> <span class="price">Rp <?php echo number_format($paket['harga']) ?> / <?= $paket['tipe'] ?></span></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </div>
</section>
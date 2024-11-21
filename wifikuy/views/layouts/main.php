<?php
function tanggal($tgl)
{
    $tanggal = substr($tgl, 8, 2);
    $bulan = getBulan(substr($tgl, 5, 2));
    $tahun = substr($tgl, 0, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
}
function getBulan($bln)
{
    switch ($bln) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $pengaturan['nama_web'] ?? 'Web' ?> | <?= $data['title'] ?? 'Judul' ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Spectral:ital,wght@0,200;0,300;0,400;0,500;0,700;0,800;1,200;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= BASE_URL . 'dist/' ?>home/css/animate.css">
    <link rel="stylesheet" href="<?= BASE_URL . 'dist/' ?>home/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= BASE_URL . 'dist/' ?>home/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= BASE_URL . 'dist/' ?>home/css/magnific-popup.css">
    <link rel="stylesheet" href="<?= BASE_URL . 'dist/' ?>home/css/flaticon.css">
    <link rel="stylesheet" href="<?= BASE_URL . 'dist/' ?>home/css/style.css">
    <link rel="icon" type="image/x-icon" href="foto/TNGR.png">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        body {
            font-size: 15pt !important;
            color: #000;
        }

        label {
            font-size: 15pt !important;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <center>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.php" style="font-size: 20px !important;"> &nbsp;<?= $pengaturan['nama_web'] ?? 'Web' ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-list"></i>
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="<?= BASE_URL ?>" class="nav-link">Home</a></li>
                    <li class="nav-item active"><a href="#paket" class="nav-link">Paket</a></li>

                    <?php if (!isset($_SESSION['user'])): ?>
                        <li class="nav-item active"><a href="<?= BASE_URL . 'register' ?>" class="nav-link">Daftar</a></li>
                        <li class="nav-item active"><a href="<?= BASE_URL . 'login' ?>" class="nav-link">Login</a></li>
                    <?php else: ?>
                        <li class="nav-item active"><a href="#" class="nav-link"><?= $_SESSION['user']['nama'] ?></a></li>
                        <li class="nav-item active"><a href="<?= BASE_URL . 'logout' ?>" class="nav-link">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>



    <?php require_once(__DIR__ . '/../' . $data['views']); ?>




    <footer class="ftco-footer">
        <div class="container">
            <div class="row mb-5">
                <div class="col-sm-12 col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2 logo"><a href="#"><?= $pengaturan['nama_web'] ?? 'Web' ?></a></h2>

                    </div>
                </div>
                <div class="col-sm-12 col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Kontak</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon fa fa-inbox marker"></span><span class="text"><?= $pengaturan['email'] ?? 'Email Kontak' ?></span></li>
                                <li><span class="icon fa fa-whatsapp marker"></span><span class="text"><?= $pengaturan['no_telp'] ?? 'No Telp Kontak' ?></span></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8 col-md">
                    <div class="ftco-footer-widget mb-4">
                        <iframe src="<?= $pengaturan['link_embed_maps'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d65368094.47364528!2d37.21362699410102!3d-0.33070676671030774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4c07d7496404b7%3A0xe37b4de71badf485!2sIndonesia!5e0!3m2!1sen!2sid!4v1731074674108!5m2!1sen!2sid' ?>" width="400" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid px-0 py-5 bg-black">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/jquery.min.js"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/jquery-migrate-3.0.1.min.js"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/popper.min.js"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/jquery.easing.1.3.js"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/jquery.waypoints.min.js"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/jquery.stellar.min.js"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/owl.carousel.min.js"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/jquery.magnific-popup.min.js"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/jquery.animateNumber.min.js"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/scrollax.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/google-map.js"></script>
    <script src="<?= BASE_URL . 'dist/' ?>home/js/main.js"></script>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener("click", function(e) {
                e.preventDefault();

                // Get the target element from the anchor link
                const target = document.querySelector(this.getAttribute("href"));

                // Scroll to the target element smoothly
                window.scrollTo({
                    top: target.offsetTop,
                    behavior: "smooth"
                });
            });
        });
    </script>

</body>

</html>
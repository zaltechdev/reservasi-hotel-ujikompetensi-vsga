<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <link rel="stylesheet" href="bootstrap.css">
        <title>Selamat datang di Tidar VSGA Hotel</title>
        <style>
            main{
                height:calc(100dvh - 70px);
            }

            #bgimg{
                background-position: cover;
                background-repeat: no-repeat;
                background-size: cover;
                transform: scaleX(-1);
            }

            #bgimg > div{
                transform: scaleX(-1);
                background: rgba(0, 0, 0, 0.6);
                backdrop-filter: blur(2px);
            }

            img{
                height:15rem !important;
                object-fit: cover;
                object-position: center;
            }
        </style>
    </head>
    <body class="d-flex flex-column vh-100">
        <nav class="w-100 sticky-top bg-primary d-flex flex-row align-items-center justify-content-between">
            <p class="fs-4 fw-bold text-light m-0 p-3">VSGA Hotel</p>
            <div class="sticky-top bg-primary d-flex flex-row align-items-center justify-content-end gap-3 px-4">
                <a class="btn <?=(!isset($_GET['page'])) ? "btn-light" : "text-light"?>" href="index.php">Beranda</a>
                <a class="btn <?=(isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] === "paket") ? "btn-light" : "text-light"?>" href="?page=paket">Kamar</a>
                <a class="btn <?=(isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] === "tentang") ? "btn-light" : "text-light"?>" href="?page=tentang">Tentang</a>
                <a class="btn btn-outline-light" href="pemesanan.php">Pesan sekarang</a>
            </div>
        </nav>
        <main class="w-100 d-flex align-items-center justify-content-center">
            <?php if(!isset($_GET['page'])) {?>
            <div class="w-100 h-100 d-flex flex-column justify-content-center" id="bgimg" style="background:url(./res/hall.jpg);">
                <div class="w-100 h-100 text-light d-flex flex-column align-items-center">
                    <div class="container d-flex flex-column justify-content-center h-100">
                        <p class="fs-1 fw-bold m-0 mb-2">Selamat datang di Tidar VSGA Hotel</p>
                        <p class="fs-4 fw-medium">Pengalaman menginap yang mewah dan nyaman menanti Anda</p>
                        <div class="d-flex flex-row align-items-center gap-3">
                            <a href="pemesanan.php" class="btn btn-primary" style="width:max-content;">Pesan sekarang!</a>
                            <a href="?page=paket" class="btn btn-outline-light" style="width:max-content;">Lihat paket</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if(isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] === "paket") {?>
                <div class="w-100 h-100 text-light d-flex flex-row align-items-center justify-content-evenly">
                    <div class="card" style="width: 18rem;">
                        <img src="https://asset.kompas.com/crops/33vZ6Rt128kzOfcC_aU3fy7oo0I=/0x36:640x463/750x500/data/photo/2020/07/10/5f081b41cc76c.jpeg" class="card-img-top" alt="kamar standar: 1 kasur">
                        <div class="card-body text-dark">
                            <h5 class="card-title">Kelas Standar</h5>
                            <p class="card-text">1 Kasur, AC, kamar mandi/WC dalam, Meja 1</p>
                            <a href="#" class="btn btn-primary">Rp 200.000,- /hari</a>
                        </div>
                    </div>    
                    <div class="card" style="width: 18rem;">
                        <img src="https://images.tokopedia.net/blog-tokopedia-com/uploads/2020/02/4.-Family-room-sumber-gambar-newsaphirhotel.jpg" class="card-img-top" alt="kamar family: 2-3 kasur, 2 Meja">
                        <div class="card-body text-dark">
                            <h5 class="card-title">Kelas Family</h5>
                            <p class="card-text">2-3 Kasur, AC, kamar mandi/WC dalam, 1 Meja, 1 Sofa </p>
                            <a href="#" class="btn btn-primary">Rp 300.000,- /hari</a>
                        </div>
                    </div>
                    <div class="card" style="width: 18rem;">
                        <img src="https://backend.parador-hotels.com/wp-content/uploads/2023/04/Deluxe-Room-Artinya-Apa.jpg" class="card-img-top" alt="kamar Deluxe: 1 kasur, Sofa dan Meja">
                        <div class="card-body text-dark">
                            <h5 class="card-title">Kelas Deluxe</h5>
                            <p class="card-text">1 Kasur, AC, kamar mandi/WC dalam, Meja, Sofa</p>
                            <a href="#" class="btn btn-primary">Rp 400.000,- /hari</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if(isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] === "tentang") {?>
                <div class="w-100 h-100 text-light d-flex flex-row align-items-center justify-content-evenly">

                </div>
            <?php } ?>
        </main>
    </body>
</html>
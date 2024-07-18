<?php

require_once __DIR__ . "/config/configs.php";

if(isset($_GET['pesanan']) && !empty($_GET['pesanan'])){

    $nama = base64_decode($_GET['pesanan']);
    $res = sql("SELECT * FROM `pemesanan` WHERE nama = :nama",[":nama" => $nama]);

    if($res['row'] === 0){
        echo "<script>alert('Pesanan tidak ditemukan!');</script>"; return;
    }
    
    foreach($res['data'] as $pesan){
        $nama = $pesan['nama'];
        $jk = $pesan['jeniskelamin'];
        $ktp = $pesan['nomorktp'];
        $tipe = $pesan['tipekamar'];
        $durasi = $pesan['durasi'];
        $diskon = $pesan['diskon'];
        $final = $pesan['final'];
    }

}
else{
    echo "<script>alert('Buat pesanan terlebih dahulu!'); window.location.href='pemesanan.php';</script>";
}

function image(string $tipe){
    switch(strtolower($tipe)){
        case "standar" : return "./res/img/kamar-standar.png";
        case "family" : return "./res/img/kamar-family.png";
        case "deluxe" : return "./res/img/kamar-deluxe.png";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./res/css/bootstrap.css">
        <title>Struk Pesanan</title>
        <style>
            #img{
                width: 100%;
                height:200px;
                object-fit: cover;
                object-position: center
            }
        </style>
    </head>
    <body>
    <body class="d-flex flex-column vh-100 w-100 align-items-center">
        <?php if(isset($_GET['pesanan']) && !empty($_GET['pesanan'])) { ?>
        <table class="table" style="width:400px;">
            <tr>
                <th class="fs-4 text-center" colspan="2">HOTEL TIDAR VSGA</th>
            </tr>
            <tr>
                <th colspan="2" class="text-center fs-6">Struk Pesanan Kamar</th>
            </tr>
            <tr>
                <th colspan="2">
                    <img src="<?=image($tipe); ?>" id="img">
                </th>
            </tr>
            <tr>
                <td>Nama pemesan</td>
                <td><?=$nama?></td>
            </tr>            
            <tr>
                <td>Nomor Identitas</td>
                <td><?=$ktp?></td>
            </tr> 
            <tr>
                <td>Jenis kelamin</td>
                <td><?=$jk?></td>
            </tr>
            <tr>
                <td>Tipe kamar</td>
                <td><?=$tipe?></td>
            </tr>
            <tr>
                <td>Durasi penginapan</td>
                <td><?=$durasi?> Hari</td>
            </tr>
            <tr>
                <td>Diskon</td>
                <td><?=$diskon * 100?> %</td>
            </tr>
            <tr>
                <td>Total Bayar</td>
                <td>Rp <?=$final?></td>
            </tr>
            <tr>
                <td colspan="2"><a href="pemesanan.php" class="btn btn-primary">Pesan lagi</a></td>
            </tr>
        </table>            
        <?php } ?>
    </body>
</html>
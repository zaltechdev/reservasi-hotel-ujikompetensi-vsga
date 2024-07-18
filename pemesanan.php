<?php

require_once __DIR__ . "/config/configs.php";

if(isset($_POST['pesan']) && $_SERVER['REQUEST_METHOD'] === "POST"){
    define("discount",0.1);
    define("lamahari_dsc",3);
    define("typekamar",[
        "200000" => "Standar",
        "300000" => "Family",
        "400000" => "Deluxe"
    ]);

    if(
        isset($_POST['pemesan']) && 
        isset($_POST['jeniskelamin']) && 
        isset($_POST['nomorktp']) && 
        isset($_POST['tipekamar']) && 
        isset($_POST['tanggalpesan']) && 
        isset($_POST['durasiinap'])
    ){
        $nama = htmlspecialchars($_POST['pemesan']);
        $jk = htmlspecialchars($_POST['jeniskelamin']);
        $ktp = htmlspecialchars($_POST['nomorktp']);
        $kamar = intval(htmlspecialchars($_POST['tipekamar']));
        $tglpesan = htmlspecialchars($_POST['tanggalpesan']) . date(" G:i:s");
        $durasi = intval(htmlspecialchars($_POST['durasiinap']));

        $sarapan = 0; $presdis = 0;
        if(isset($_POST['breakfast'])){
            $sarapan = htmlspecialchars($_POST['breakfast']);
        }

        $hitung = ($durasi * $kamar);
        if($durasi > lamahari_dsc){
            $presdis = discount;
            $hargadis = $hitung * discount;
            $final = ($hitung - $hargadis) + $sarapan;
        }
        else{
            $final = $hitung + $sarapan;
        }

        if(array_key_exists($kamar,typekamar)){
            $tipe = typekamar[$kamar];
        }

        sql("INSERT INTO `pemesanan` (nama,jeniskelamin,nomorktp,tipekamar,hargakamarperhari,tglpesan,durasi,sarapan,diskon,final) VALUES (
            :nama,:jeniskelamin,:nomorktp,:tipekamar,:hargakamarperhari,:tglpesan,:durasi,:sarapan,:diskon,:final
        )", [
            ":nama" => $nama,
            ":jeniskelamin" => $jk,
            ":nomorktp" => $ktp,
            ":tipekamar" => $tipe,
            ":hargakamarperhari" => $kamar,
            ":tglpesan" => $tglpesan,
            ":durasi" => $durasi,
            ":sarapan" => $sarapan,
            ":diskon" => $presdis,
            ":final" => $final
        ]);

        header("location:strukpemesanan.php?pesanan=".base64_encode($nama));
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap.css">
        <script src="jquery.js"></script>
        <title>Pemesanan Hotel</title>
    </head>
    <body class="d-flex flex-column vh-100 w-100 align-items-center">
        <form class="d-flex flex-column mt-2 pb-5" style="width:400px" action="pemesanan.php" method="POST">
            <a href="index.php" class="btn btn-secondary fixed-top mt-4 mx-4" style="width:max-content;">Kembali ke Beranda</a>
            <p class="fs-3 fw-bold">Pesan Kamar</p>
            <div class="mb-3">
                <label for="namapemesan" class="form-label">Nama lengkap</label>
                <input type="text" class="form-control" id="namapemesan" name="pemesan" required>
            </div>
            <div class="d-flex flex-row align-items-center gap-3">
                <label for="jeniskelamin1" class="mb-2">Jenis kelamin</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jeniskelamin" id="jeniskelamin1" value="laki-laki" checked>
                    <label class="form-check-label" for="jeniskelamin1">Laki-laki</label>
                </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jeniskelamin" id="jeniskelamin2" value="perempuan">
                    <label class="form-check-label" for="jeniskelamin2">Perempuan</label>
                </div>
            </div>
            <div class="mt-1 mb-3">
                <label for="nomorktp" class="form-label">Nomor identitas</label>
                <input type="text" class="form-control" id="nomorktp" name="nomorktp" required maxlength="16" minlength="16">
            </div>
            <label for="tipekamar" class="mb-2">Tipe kamar</label>
            <select class="form-select" id="tipekamar" name="tipekamar" required>
                <option selected value="0">Pilih Tipe kamar</option>
                <option value="200000">Standar (Rp 200.000,-)</option>
                <option value="300000">Family (Rp 300.000,-)</option>
                <option value="400000">Deluxe (Rp 400.000,-)</option>
            </select>
            <div class="mt-3">
                <label for="tanggalpesan" class="form-label">Tanggal pesan</label>
                <input type="date" class="form-control" id="tanggalpesan" name="tanggalpesan" required>
            </div>    
            <div class="mt-3">
                <label for="durasiinap" class="form-label">Durasi menginap (Lebih 3 hari diskon 10%)</label>
                <input type="number" class="form-control" id="durasiinap" name="durasiinap" required>
            </div>    
            <div class="d-flex flex-row align-items-center gap-3 mt-3">
                <input class="form-check-input" type="checkbox" id="breakfast" value="80000" name="breakfast">
                <label for="breakfast">Termasuk Breakfast (Rp 80.000,-)</label>
            </div>
            <div class="input-group mt-3">
                <input type="number" readonly class="form-control" placeholder="Harga total" id="final" required>
            </div>
            <button type="submit" name="pesan" class="btn btn-primary mt-4" id="submit">Buat pesanan</button>
        </form>
    </body>
    <script>

        function calc(){
            
            const presdis = 0.1;
            const kamar = parseFloat($("#tipekamar").val());
            const durasi = parseFloat($("#durasiinap").val()); 
            var sarapan = 0;

            if(kamar === "" || kamar === 0 || durasi === ""){
                return false;
            }

            if($("#breakfast").is(":checked")){
                sarapan = parseFloat($("#breakfast").val()); 
            }

            var harga = 0;
            if(durasi > 3){
                var hargadis = kamar * durasi * presdis;
                harga = ((kamar * durasi) - hargadis) + sarapan;
            }
            else{
                harga = (kamar * durasi) + sarapan;
            }

            $("#final").val(harga);
            return true;
        }
        
        $("#breakfast").click(() => {
            if(!calc()){
                $("#submit").attr("type","button");
            }
            else{
                $("#submit").attr("type","submit");
            }
        });

        $("#final,#durasiinap,#tipekamar").on("input",() => {
            if(!calc()){
                $("#submit").attr("type","button");
            }
            else{
                $("#submit").attr("type","submit");
            }
        });
    </script>
</html>

<?php

require_once __DIR__ . "/config/configs.php";

if(isset($_POST['pesan']) && $_SERVER['REQUEST_METHOD'] === "POST"){

    define("discount",0.1);
    define("lamahari_dsc",3);
    define("typekamar",[
        "100000" => "Standar",
        "200000" => "Family",
        "300000" => "Deluxe"
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

        if(strlen($ktp) === 16){

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
        else{
            $ktp_invalid = true;
        }

    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./res/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <script src="./res/js/jquery.js"></script>
        <title>Pemesanan Hotel</title>
    </head>
    <body class="d-flex flex-column vh-100 w-100 align-items-center">
        <form class="d-flex flex-column mt-2 pb-5" style="width:400px" action="pemesanan.php" method="POST">
            <div class="d-flex flex-row align-items-center gap-3 mb-3">
                <a href="index.php" class="fas fa-house fs-6 text-primary"></a>|
                <p class="fs-3 fw-bold m-0">Pesan Kamar</p>
            </div>
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
                <input type="number" class="form-control" id="nomorktp" name="nomorktp" required>
                <?php if(isset($ktp_invalid)) : ?><label for="nomorktp" class="form-text text-danger" style="font-size:.9rem">Nomor Identitas atau KTP salah, harus 16 digit!</label><?php endif;?>
            </div>
            <label for="tipekamar" class="mb-2">Tipe kamar</label>
            <select class="form-select" id="tipekamar" name="tipekamar" required>
                <option selected value="0">- Pilih Tipe kamar -</option>
                <option value="100000">Standar (Rp 100.000,-)</option>
                <option value="200000">Family (Rp 200.000,-)</option>
                <option value="300000">Deluxe (Rp 300.000,-)</option>
            </select>
            <label for="tipekamar" class="form-text text-danger d-none" id="tipekamar-notice" style="font-size:.9rem">Pilih tipe kamar anda!</label>
            <div class="mt-3">
                <label for="tanggalpesan" class="form-label">Tanggal pesan</label>
                <input type="date" class="form-control" id="tanggalpesan" name="tanggalpesan" required>
            </div>    
            <div class="mt-3">
                <label for="durasiinap" class="form-label">Durasi menginap (hari) (Lebih 3 hari diskon 10%)</label>
                <input type="number" class="form-control" id="durasiinap" name="durasiinap" required>
                <label for="durasiinap" class="form-text text-danger d-none" id="durasi-notice" style="font-size:.9rem">Masukkan durasi penginapan anda!</label>
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

        const calc = () => {
            
            const presdis = 0.1;
            const kamar = parseFloat($("#tipekamar").val());
            const durasi = parseFloat($("#durasiinap").val()); 
            var sarapan = 0;

            if(durasi === "" || durasi <= 0){
                $("#durasi-notice").removeClass("d-none");
                $("#durasi-notice").addClass("d-flex");
                return false;
            }
            else{
                $("#durasi-notice").removeClass("d-flex");                
                $("#durasi-notice").addClass("d-none");
            }

            if(kamar === "" || kamar <= 0){
                $("#tipekamar-notice").removeClass("d-none");
                $("#tipekamar-notice").addClass("d-flex");
                return false;
            }
            else{
                $("#tipekamar-notice").removeClass("d-flex");                
                $("#tipekamar-notice").addClass("d-none");
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

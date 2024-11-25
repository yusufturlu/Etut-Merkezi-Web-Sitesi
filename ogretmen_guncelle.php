<?php
// Veritabanı bağlantısı
include("baglanti.php");
session_start();

// Öğretmen numarasını alma
$ogretmen_numara = $_GET['ogretmenNumara'];

// Öğretmen bilgilerini almak için sorgu
$sql_get_teacher_info = "SELECT * FROM ogretmenler WHERE ogretmenNumara = $ogretmen_numara";
$result_get_teacher_info = $baglanti->query($sql_get_teacher_info);

// Eğer öğretmen bulunamazsa
if ($result_get_teacher_info->num_rows == 0) {
    echo "Öğretmen bulunamadı.";
    exit();
}

// Öğretmen bilgilerini dizi olarak al
$ogretmen_info = $result_get_teacher_info->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_update'])) {
    // Formdan gelen güncel bilgileri al
    $isim = $_POST['isim'];
    $soyisim = $_POST['soyisim'];
    $email = $_POST['email'];
    $adres = $_POST['adres'];
    $unvan = $_POST['unvan'];
    $ders = $_POST['ders']; // Yeni eklenen ders alanını da burada ekliyoruz

    // Veritabanında güncelleme işlemi
    $sql_update_teacher = "UPDATE ogretmenler SET ogretmenIsim='$isim', ogretmenSoyisim='$soyisim', ogretmenEmail='$email', ogretmenAdres='$adres', unvanID='$unvan', dersID='$ders' WHERE ogretmenNumara=$ogretmen_numara";

    if ($baglanti->query($sql_update_teacher) === TRUE) {
        echo "Öğretmen bilgileri güncellendi.";
        // Güncelleme işlemi başarılıysa, "ogretmenislemleri.php" sayfasına yönlendirme
        header("Location: ogretmenislemleri.php");
        exit(); // Kodun devam etmemesi için çıkış yap
    } else {
        echo "Güncelleme hatası: " . $baglanti->error;
    }
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pırıltı Bire Bir Etüt Merkezi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <style>
    .card.text-bg-success {
    margin: 0 auto; /* Centers the card */
}
   </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="yetkiliAnasayfa.php" style="font-family: 'Arial Black', sans-serif; font-size: 24px; font-weight: bold;">
                <img src="image/pirilti.png" alt="Pırıltı Logo" style="height: 150px;">
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="yetkiliAnasayfa.php">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ogrenciislemleri.php">Öğrenci İşlemleri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ogretmenislemleri.php">Öğretmen İşlemleri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Çıkış Yap</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

   


<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Öğretmen Bilgilerini Güncelle</h5>
            <div class="card mb-3">
                <div class="card-body">
                        <form method="post">
    
        <h2 class="mt-4">Öğretmen Bilgilerini Güncelle</h2>
        <form method="post">
            <div class="form-group">
                <label for='isim'>İsim:</label>
                <input type='text' class="form-control" id='isim' name='isim' value='<?php echo isset($ogretmen_info["ogretmenIsim"]) ? $ogretmen_info["ogretmenIsim"] : ""; ?>'>
            </div>
            <div class="form-group">
                <label for='soyisim'>Soyisim:</label>
                <input type='text' class="form-control" id='soyisim' name='soyisim' value='<?php echo isset($ogretmen_info["ogretmenSoyisim"]) ? $ogretmen_info["ogretmenSoyisim"] : ""; ?>'>
            </div>
            <div class="form-group">
                <label for='email'>Email:</label>
                <input type='email' class="form-control" id='email' name='email' value='<?php echo isset($ogretmen_info["ogretmenEmail"]) ? $ogretmen_info["ogretmenEmail"] : ""; ?>'>
            </div>
            <div class="form-group">
                <label for='adres'>Adres:</label>
                <input type='text' class="form-control" id='adres' name='adres' value='<?php echo isset($ogretmen_info["ogretmenAdres"]) ? $ogretmen_info["ogretmenAdres"] : ""; ?>'>
            </div>
            <div class="form-group">
                <label for="unvan">Unvan:</label>
                <select class="form-control" name="unvan" id="unvan">
                    <?php
                    // Veritabanından unvanları çek ve seçenekleri oluştur
                    $sql_unvan = "SELECT unvanID, unvanAdi FROM unvan";
                    $result_unvan = $baglanti->query($sql_unvan);
                    if ($result_unvan->num_rows > 0) {
                        while ($row_unvan = $result_unvan->fetch_assoc()) {
                            $selected = ($row_unvan['unvanID'] == $ogretmen_info['unvanID']) ? 'selected' : '';
                            echo "<option value='" . $row_unvan['unvanID'] . "' $selected>" . $row_unvan['unvanAdi'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="ders">Ders:</label>
                <select class="form-control" name="ders" id="ders">
                    <?php
                    // Veritabanından dersleri çek ve seçenekleri oluştur
                    $sql_dersler = "SELECT dersID, dersAdi FROM dersler";
                    $result_dersler = $baglanti->query($sql_dersler);
                    if ($result_dersler->num_rows > 0) {
                        while ($row_ders = $result_dersler->fetch_assoc()) {
                            $selected = ($row_ders['dersID'] == $ogretmen_info['dersID']) ? 'selected' : '';
                            echo "<option value='" . $row_ders['dersID'] . "' $selected>" . $row_ders['dersAdi'] . "</option>";
                        }
                    }
                    ?>
                </select>
                <br>
            </div>
            <button type="submit" class="btn btn-primary" name="submit_update">Güncelle</button>
        </form>
    
    </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <br><br><br>
    
<!-- Footer -->
<footer class="text-center text-lg-start bg-light text-muted">
    <div class="container p-4">
        <div class="row">
            <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                <h5 class="text-uppercase">Pırıltı Bire Bir Etüt Merkezi</h5>
                <p>
                Her Öğrenciye Parıldayan Bir Gelecek!
                </p>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">Hizmetler</h5>
                <ul class="list-unstyled mb-0">
                    <li>
                        <a href="hizmetler.php" class="text-muted">9.Sınıf</a>
                    </li>
                    <li>
                        <a href="hizmetler.php" class="text-muted">10.Sınıf</a>
                    </li>
                    <li>
                        <a href="hizmetler.php" class="text-muted">11.Sınıf</a>
                    </li>
                    <li>
                        <a href="hizmetler.php" class="text-muted">12.Sınıf</a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0 " style="list-style-type:none">
                <h5 class="text-uppercase">İletişim</h5>
                <?php
                // Veritabanından iletişim bilgilerini çekme
                $query = "SELECT yetkiliNumara, yetkiliEmail FROM yetkili";
                $result = mysqli_query($baglanti, $query);

                // Verileri alırken hata kontrolü yapın
                if ($result) {
                    // Veri varsa, HTML içine yerleştirme
                    $row = mysqli_fetch_assoc($result);
                    $telefon = $row['yetkiliNumara'];
                    $email = $row['yetkiliEmail'];
                ?>
                <!-- İletişim Bilgilerini Gösterme -->
                <li>
                    <i class="fas fa-envelope me-2"></i> <?php echo $email; ?>
                </li>
                <li>
                    <i class="fas fa-phone me-2"></i> <?php echo $telefon; ?>
                </li>
                <?php
                } else {
                    // Veri yoksa veya hata oluştuysa bir hata mesajı gösterme
                    echo "İletişim bilgileri alınamadı.";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2024 Pırıltı Bire Bir Etüt Merkezi Tüm Hakları Saklıdır.
    </div>
</footer>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



<?php
// Veritabanı bağlantısını kapat
mysqli_close($baglanti);
?>
</body>
</html>


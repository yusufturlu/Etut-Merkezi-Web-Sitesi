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

<?php
include("../../db/baglanti.php");
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}
// Boş gün ayarlama
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ogretmenID'])) {
    $ogretmenID = mysqli_real_escape_string($baglanti, $_POST['ogretmenID']);

    // Sadece 'bosGunler' ve 'ogretmenID' varsa işlem yap
    if (isset($_POST['bosGunler'])) {
        $bosGunler = implode(',', $_POST['bosGunler']);

        // Boş günleri veritabanına kaydet
        $sorgu = "UPDATE ogretmenler SET bosGunler = '$bosGunler' WHERE ogretmenID = $ogretmenID";
        if (mysqli_query($baglanti, $sorgu)) {
            echo '<script>alert("Boş günler başarıyla kaydedildi.");</script>';
            echo '<script>window.location.href = "ogretmenislemleri.php";</script>';
        } else {
            echo '<script>alert("Boş günleri kaydederken bir hata oluştu.");</script>';
            echo '<script>window.history.back();</script>';
        }
    } else {
        echo '<script>alert("Boş günler seçilmedi.");</script>';
        echo '<script>window.history.back();</script>';
    }
}



// Tüm öğretmenleri listeleyen sorgu
$sql_all_teachers = "SELECT * FROM ogretmenler";
$result_all_teachers = $baglanti->query($sql_all_teachers);

// Öğretmen arama işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_search'])) {
    // Formdan gelen arama terimini al
    $search_term = mysqli_real_escape_string($baglanti, $_POST['search']);

    // Veritabanında öğretmenleri ara ve sonuçları göster
    $sql_search = "SELECT * FROM ogretmenler WHERE ogretmenIsim LIKE '%$search_term%' OR ogretmenSoyisim LIKE '%$search_term%'";
    $result_search = $baglanti->query($sql_search);
}

// Öğretmen silme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_delete'])) {
    // Formdan gelen öğretmen numarasını al
    $ogretmen_numara = $_POST['ogretmen_numara'];

    // Veritabanında öğretmeni sil
    $sql_delete_teacher = "DELETE FROM ogretmenler WHERE ogretmenNumara = $ogretmen_numara";
    if ($baglanti->query($sql_delete_teacher) === TRUE) {
        echo "Öğretmen başarıyla silindi.";
    } else {
        echo "Silme hatası: " . $baglanti->error;
    }
}




?>

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
            <h5 class="card-title text-center">Öğretmen İşlemleri</h5>
            <br>
            <div class="card mb-3">
                <div class="card-body">
                    
<!-- Öğretmen arama formu -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="mb-3">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Öğretmen Adı veya Soyadı" name="search" aria-label="Öğretmen Adı veya Soyadı">
        <button class="btn btn-primary" type="submit" name="submit_search">Ara</button>
    </div>
</form>

<?php if (isset($result_search) && $result_search->num_rows > 0): ?>
    <h2>Arama Sonuçları</h2>
    <ul class="list-group">
        <?php while ($row_teacher = $result_search->fetch_assoc()): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <?php echo $row_teacher['ogretmenIsim'] . " " . $row_teacher['ogretmenSoyisim']; ?>
                </div>
                <div>
                    <form method='post'>
                        <input type='hidden' name='ogretmen_numara' value='<?php echo $row_teacher['ogretmenNumara']; ?>'>
                        <button type='submit' class='btn btn-danger btn-sm me-1' name='submit_delete'>Sil</button>
                        <script>
                            function redirectToUpdatePage(ogretmenNumara) {
                                window.location.href = 'ogretmen_guncelle.php?ogretmenNumara=' + ogretmenNumara;
                            }
                        </script>
                        <button type='button' class='btn btn-warning btn-sm' onclick="redirectToUpdatePage('<?php echo $row_teacher['ogretmenNumara']; ?>')">Güncelle</button>
                    </form>
                </div>
            </li>
        <?php endwhile; ?>
    </ul>
<?php elseif(isset($result_search) && $result_search->num_rows == 0): ?>
    <p>Arama sonucu bulunamadı.</p>
<?php endif; ?>
                </div>
            </div>
       
   


<br><br>
    <!-- Tatil ayarlama işlemleri -->
    <div style="text-align: center;  display: flex;
    justify-content: center;
    align-items: center;">
    <div class="card mb-3" style="max-width: 26rem; margin-inline-end: 50px;">
        <div class="card-header" style="background-color:#0f4a8a; color:#ebf7ff;">
            <h5 class="card-title">Tatil Ayarlama İşlemleri</h5>
        </div>
        <div class="card-body">
            <!-- Tatil ayarlama işlemleri formu -->
            <form method="post" action="">
                <div class="mb-3">
                    <label for="ogretmenID" class="form-label">Öğretmen Seçin:</label>
                    <select name="ogretmenID" id="ogretmenID" class="form-select">
                        <!-- Öğretmenleri veri tabanından al ve listele -->
                        <?php
                        $sorgu = "SELECT ogretmenID, ogretmenIsim, ogretmenSoyisim FROM ogretmenler";
                        $sonuc = mysqli_query($baglanti, $sorgu);
                        while ($row = mysqli_fetch_assoc($sonuc)) {
                            echo "<option value='" . $row['ogretmenID'] . "'>" . $row['ogretmenIsim'] . " " . $row['ogretmenSoyisim'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="bos_gunler" class="form-label">Boş Günleri Seçin:</label><br>
                    <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="bosGunler[]" value="Pazartesi" id="bosGunler1">
                            <label class="form-check-label" for="bosGunler1">Pazartesi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="bosGunler[]" value="Salı" id="bosGunler2">
                            <label class="form-check-label" for="bosGunler2">Salı</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="bosGunler[]" value="Çarşamba" id="bosGunler3">
                            <label class="form-check-label" for="bosGunler3">Çarşamba</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="bosGunler[]" value="Perşembe" id="bosGunler4">
                            <label class="form-check-label" for="bosGunler4">Perşembe</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="bosGunler[]" value="Cuma" id="bosGunler5">
                            <label class="form-check-label" for="bosGunler5">Cuma</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="bosGunler[]" value="Cumartesi" id="bosGunler6">
                            <label class="form-check-label" for="bosGunler6">Cumartesi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="bosGunler[]" value="Pazar" id="bosGunler7">
                            <label class="form-check-label" for="bosGunler7">Pazar</label>
                        </div>

                </div>
                <button type="submit" class="btn " style="background-color:#0f4a8a; color:#ebf7ff;" >Boş Günleri Kaydet</button>
            </form>
            
        </div>
    </div>
</div>
<br>

</div>
</div> </div>

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

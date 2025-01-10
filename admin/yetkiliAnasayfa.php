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
    margin: 0 auto; 
}
   </style>
</head>

<?php
include("../db/baglanti.php");

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}


echo "Hoşgeldiniz ".$_SESSION['admin'];



//Boş gün ayarlama 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ogretmenID'])) {
  $ogretmenID = mysqli_real_escape_string($baglanti, $_POST['ogretmenID']);
  
  // Sadece 'bosGunler' ve 'ogretmenID' varsa işlem yap
  if (isset($_POST['bosGunler'])) {
      $bosGunler = implode(',', $_POST['bosGunler']);

      // Boş günleri veritabanına kaydet
      $sorgu = "UPDATE ogretmenler SET bosGunler = '$bosGunler' WHERE ogretmenID = $ogretmenID";
      if (mysqli_query($baglanti, $sorgu)) {
          echo "Boş günler başarıyla kaydedildi.";
          header("refresh:2;url=yetkiliAnasayfa.php");
      } else {
          echo "Boş günleri kaydederken bir hata oluştu.";
      }
  } else {
      echo "Boş günler seçilmedi.";
  }
}

// Dersler tablosundan verileri çek
$sql_dersler = "SELECT * FROM dersler";
$result_dersler = mysqli_query($baglanti, $sql_dersler);

// Unvanlar tablosundan verileri çek
$sql_unvan = "SELECT * FROM unvan";
$result_unvan = mysqli_query($baglanti, $sql_unvan);

// Öğretmen
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ogretmenIsim"])) {
    // POST verilerini al
    $ogretmenIsim = isset($_POST["ogretmenIsim"]) ? $_POST["ogretmenIsim"] : '';
    $ogretmenSoyisim = isset($_POST["ogretmenSoyisim"]) ? $_POST["ogretmenSoyisim"] : '';
    $ogretmenNumara = isset($_POST["ogretmenNumara"]) ? $_POST["ogretmenNumara"] : '';
    $ogretmenEmail = isset($_POST["ogretmenEmail"]) ? $_POST["ogretmenEmail"] : '';
    $ogretmenSifre = isset($_POST["ogretmenSifre"]) ? $_POST["ogretmenSifre"] : '';
    $ogretmenSube = isset($_POST["ogretmenSube"]) ? $_POST["ogretmenSube"] : '';
    $ogretmenAdres = isset($_POST["ogretmenAdres"]) ? $_POST["ogretmenAdres"] : '';
    $ogretmenDers = isset($_POST["ogretmenDers"]) ? $_POST["ogretmenDers"] : '';
    $ogretmenUnvan = isset($_POST["ogretmenUnvan"]) ? $_POST["ogretmenUnvan"] : '';

    // SQL sorgusunu oluştur ve çalıştır
    $sql = "INSERT INTO ogretmenler (ogretmenIsim, ogretmenSoyisim, ogretmenNumara, ogretmenEmail, ogretmenSifre, ogretmenSube, ogretmenAdres, dersID, unvanID) VALUES ('$ogretmenIsim', '$ogretmenSoyisim', '$ogretmenNumara', '$ogretmenEmail', '$ogretmenSifre', '$ogretmenSube', '$ogretmenAdres', '$ogretmenDers', '$ogretmenUnvan')";

    if (mysqli_query($baglanti, $sql)) {
        echo "Öğretmen başarıyla eklendi.";
    } else {
        echo "Hata: " . $sql . "<br>" . mysqli_error($baglanti);
    }
}

// Öğrenci
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ogrenciIsim"])) {
    // POST verilerini al
    $ogrenciIsim = isset($_POST["ogrenciIsim"]) ? $_POST["ogrenciIsim"] : '';
    $ogrenciSoyisim = isset($_POST["ogrenciSoyisim"]) ? $_POST["ogrenciSoyisim"] : '';
    $ogrenciNumara = isset($_POST["ogrenciNumara"]) ? $_POST["ogrenciNumara"] : '';
    $ogrenciEmail = isset($_POST["ogrenciEmail"]) ? $_POST["ogrenciEmail"] : '';
    $ogrenciSifre = isset($_POST["ogrenciSifre"]) ? $_POST["ogrenciSifre"] : '';
    $ogrenciSinif = isset($_POST["ogrenciSinif"]) ? $_POST["ogrenciSinif"] : '';
    $ogrenciAdres = isset($_POST["ogrenciAdres"]) ? $_POST["ogrenciAdres"] : '';
    $ogrenciSube = isset($_POST["ogrenciSube"]) ? $_POST["ogrenciSube"] : '';

    // SQL sorgusunu oluştur ve çalıştır
    $sql = "INSERT INTO ogrenciler (ogrenciIsim, ogrenciSoyisim, ogrenciNumara, ogrenciEmail, ogrenciSifre, ogrenciSinif, ogrenciAdres, ogrenciSube) VALUES ('$ogrenciIsim', '$ogrenciSoyisim', '$ogrenciNumara', '$ogrenciEmail', '$ogrenciSifre', '$ogrenciSinif', '$ogrenciAdres', '$ogrenciSube')";

    if (mysqli_query($baglanti, $sql)) {
        echo "Öğrenci başarıyla eklendi.";
    } else {
        echo "Hata: " . $sql . "<br>" . mysqli_error($baglanti);
    }
}



  ?>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="yetkiliAnasayfa.php" style="font-family: 'Arial Black', sans-serif; font-size: 24px; font-weight: bold;">
                <img src="../image/pirilti.png" alt="Pırıltı Logo" style="height: 150px;">
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="yetkiliAnasayfa.php">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="student/ogrenciislemleri.php">Öğrenci İşlemleri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="teacher/ogretmenislemleri.php">Öğretmen İşlemleri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="data.php">Öğretmenlerimiz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cikis.php">Çıkış Yap</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="card mb-3" style="margin: 50px; text-align: center;">
    <div class="card-body">
        <h5 class="card-title">Yetkili İşlemleri</h5><br>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-header bg-primary text-white">
                            Öğrenci Ekle
                        </div>
                        <div class="card-body">
                            <p class="card-text">Yeni bir öğrenci eklemek için buraya tıklayın.</p>
                            <button type="button" class="btn btn-primary" onclick="openOgrenciEkleModal()">
                                Öğrenci Ekle
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-header bg-success text-white">
                            Öğretmen Ekle
                        </div>
                        <div class="card-body">
                            <p class="card-text">Yeni bir öğretmen eklemek için buraya tıklayın.</p>
                            <button type="button" class="btn btn-primary" onclick="openOgretmenEkleModal()">
                                Öğretmen Ekle
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Duyurular -->
        <div class="container">
            <h3 class="text-center mt-5 mb-4">Duyurular</h3>
            <div class="accordion" id="accordionExample">
                <?php
                include '../db/baglanti.php';

                $query = "SELECT * FROM duyurular";
                $result = mysqli_query($baglanti, $query);

                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading'.$i.'">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$i.'" aria-expanded="true" aria-controls="collapse'.$i.'">
                                '.$row["duyuruBasligi"].'
                            </button>
                        </h2>
                        <div id="collapse'.$i.'" class="accordion-collapse collapse" aria-labelledby="heading'.$i.'" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                '.$row["duyuruAciklama"].'
                            </div>
                        </div>
                    </div>';
                    $i++;
                }
                ?>
            </div>
        </div>
    </div>
</div>
    </div>
    
</div>


        


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


<script>
    function openOgrenciEkleModal() {
        // Öğrenci ekle modalını açar
        $('#ogrenciEkleModal').modal('show');
    }
</script>


<!-- Öğrenci Ekle Modal -->
<div class="modal fade" id="ogrenciEkleModal" tabindex="-1" aria-labelledby="ogrenciEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ogrenciEkleModalLabel">Öğrenci Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="ogrenciIsim" class="form-label">İsim</label>
                        <input type="text" class="form-control" id="ogrenciIsim" name="ogrenciIsim" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogrenciSoyisim" class="form-label">Soyisim</label>
                        <input type="text" class="form-control" id="ogrenciSoyisim" name="ogrenciSoyisim" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogrenciNumara" class="form-label">Numara</label>
                        <input type="text" class="form-control" id="ogrenciNumara" name="ogrenciNumara" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogrenciEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="ogrenciEmail" name="ogrenciEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogrenciSifre" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="ogrenciSifre" name="ogrenciSifre" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogrenciResim" class="form-label">Resim</label>
                        <input type="file" class="form-control" id="ogrenciResim" name="ogrenciResim" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogrenciAdres" class="form-label">Adres</label>
                        <textarea class="form-control" id="ogrenciAdres" name="ogrenciAdres" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ogrenciSinif" class="form-label">Sınıf:</label>
                        <select id="ogrenciSinif" name="ogrenciSinif" class="form-select" required>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ogrenciSube" class="form-label">Şube:</label>
                        <select id="ogrenciSube" name="ogrenciSube" class="form-select" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Öğrenci Ekle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openOgretmenEkleModal() {
        // Öğretmen ekle modalını açar
        $('#ogretmenEkleModal').modal('show');
    }
</script>


        <!-- Öğretmen Ekle Modal -->
        <div class="modal fade" id="ogretmenEkleModal" tabindex="-1" aria-labelledby="ogretmenEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ogretmenEkleModalLabel">Öğretmen Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="ogretmenIsim" class="form-label">İsim</label>
                        <input type="text" class="form-control" id="ogretmenIsim" name="ogretmenIsim" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogretmenSoyisim" class="form-label">Soyisim</label>
                        <input type="text" class="form-control" id="ogretmenSoyisim" name="ogretmenSoyisim" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogretmenNumara" class="form-label">Numara</label>
                        <input type="text" class="form-control" id="ogretmenNumara" name="ogretmenNumara" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogretmenEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="ogretmenEmail" name="ogretmenEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogretmenSifre" class="form-label">Şifre</label>
                        <input type="password" class="form-control" id="ogretmenSifre" name="ogretmenSifre" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogretmenResim" class="form-label">Resim</label>
                        <input type="file" class="form-control" id="ogretmenResim" name="ogretmenResim" required>
                    </div>
                    <div class="mb-3">
                        <label for="ogretmenAdres" class="form-label">Adres</label>
                        <textarea class="form-control" id="ogretmenAdres" name="ogretmenAdres" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ogretmenSube" class="form-label">Şube:</label>
                        <select id="ogretmenSube" name="ogretmenSube" class="form-select" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ogretmenDers" class="form-label">Ders:</label>
                        <select id="ogretmenDers" name="ogretmenDers" class="form-select" required>
                            <?php while ($row = mysqli_fetch_assoc($result_dersler)) { ?>
                                <option value="<?php echo $row['dersID']; ?>"><?php echo $row['dersAdi']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ogretmenUnvan" class="form-label">Unvan:</label>
                        <select id="ogretmenUnvan" name="ogretmenUnvan" class="form-select" required>
                            <?php while ($row = mysqli_fetch_assoc($result_unvan)) { ?>
                                <option value="<?php echo $row['unvanID']; ?>"><?php echo $row['unvanAdi']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Öğretmen Ekle</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
// Veritabanı bağlantısını kapat
mysqli_close($baglanti);
?>
</body>
</html>

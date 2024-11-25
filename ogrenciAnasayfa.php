<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pırıltı Bire Bir Etüt Merkezi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
/* Düğme stilleri */
.accordion-button {
    background-color: #f8f9fa;
    color: #495057;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    padding: .75rem 1rem;
    margin-bottom: 1rem;
}

/* Açılır alan biçimi */
.accordion-body {
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.125);
    border-top: 0;
    padding: 1rem;
}
</style>
</head>


<?php
include("baglanti.php");
session_start();
//Bize Ulaşın formu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form gönderildiğinde bu blok çalışacak
    if (isset($_POST['ulasanEmail']) && isset($_POST['ulasanMesaj'])) {
        $email = mysqli_real_escape_string($baglanti, $_POST['ulasanEmail']);
        $mesaj = mysqli_real_escape_string($baglanti, $_POST['ulasanMesaj']);

        // Veritabanına ekleme sorgusu
        $ekleme_sorgusu = "INSERT INTO bize_ulaşın (ulasanEmail, ulasanMesaj) VALUES ('$email', '$mesaj')";

        // Sorguyu çalıştır
        if (mysqli_query($baglanti, $ekleme_sorgusu)) {
            // Başarılı ekleme durumunda JavaScript kodunu kullanarak bir alert göster
            echo '<script>alert("Mesajınız başarıyla gönderildi.");</script>';
        } else {
            // Hata durumunda JavaScript kodunu kullanarak bir alert göster
            echo '<script>alert("Hata: ' . mysqli_error($baglanti) . '");</script>';
        }
    } 
}


?>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="ogrenciAnasayfa.php" style="font-family: 'Arial Black', sans-serif; font-size: 24px; font-weight: bold;">
                <img src="image/pirilti.png" alt="Pırıltı Logo" style="height: 150px;">
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="ogrenciAnasayfa.php">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="randevual.php">Randevu Al</a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="openrandevuModal()">Randevular</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#" onclick="openMailModal()">Mail Adresleri</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#" onclick="openiletisimModal()">Bize Ulaşın</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" alert="çıkış yapıldı">Çıkış Yap</a>
                    </li>
                   
                </ul>
            </div>
        </div>
    </nav>


    <div class="card mb-3" style="margin: 50px; text-align: center;">
    <div class="card-body">
        <h5 class="card-title">Öğrenci İşlemleri</h5><br>

        <!-- Öğrenci Bilgileri Kartı ve Randevu Kartı -->
        <div style="display: flex; flex-direction: row; justify-content:left; gap: 50px;">
            <!-- Öğrenci Bilgileri Kartı -->
            <div class="card text-bg-light mb-3" style="max-width: 26rem; border: 1px solid #ccc;">
                <div class="card-header" style="text-align: center; padding: 0; background-color: #0f4a8a;">
                    <br>
                    <?php
// Öğrenci resmini göster
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $ogrenciNumara = $_SESSION['ogrenciNumara'];
    $sql = "SELECT ogrenciResim FROM ogrenciler WHERE ogrenciNumara = $ogrenciNumara";
    $result = $baglanti->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $resimData = $row["ogrenciResim"];
        if ($resimData !== null) {
            // Resim base64 olarak veritabanına kaydedilmiş
            echo "<img src='data:image/jpeg;base64," . $resimData . "' alt='Öğrenci Resmi' width='200' height='200' style='border-top-left-radius: 15px; border-top-right-radius: 15px;'>";
        } else {
            // Resim veritabanında yoksa veya hatalıysa, varsayılan resmi göster
            echo "<img src='placeholder.jpg' alt='Öğrenci Resmi' width='200' height='200' style='border-top-left-radius: 15px; border-top-right-radius: 15px;'>";
        }
    } else {
        // Öğrenci kaydı bulunamadıysa, varsayılan resmi göster
        echo "<img src='placeholder.jpg' alt='Öğrenci Resmi' width='200' height='200' style='border-top-left-radius: 15px; border-top-right-radius: 15px;'>";
    }
}
?>

                </div>
                <div class="card-body" style="background-color: #ebf7ff;">
                    <h5 class="card-title" style="color: #0f4a8a;">Kişisel Bilgiler</h5>
                    <div class="card-text" style="color: #0f4a8a;">
                        <?php
                        // Öğrenci bilgilerini göster
                        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                            $ogrenciNumara = $_SESSION['ogrenciNumara'];
                            $sql = "SELECT * FROM ogrenciler WHERE ogrenciNumara = $ogrenciNumara";
                            $result = $baglanti->query($sql);

                            if($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo "<p><b>Ad:</b> " . $row["ogrenciIsim"] . "</p>";
                                echo "<p><b>Soyad:</b> " . $row["ogrenciSoyisim"] . "</p>";
                                echo "<p><b>Email:</b> " . $row["ogrenciEmail"] . "</p>";
                                echo "<p><b>Numara:</b> " . $row["ogrenciNumara"] . "</p>";
                                echo "<p><b>Sınıf:</b> " . $row["ogrenciSinif"] . "</p>";
                                echo "<p><b>Adres:</b> " . $row["ogrenciAdres"] . "</p>";
                                echo "<p><b>Şube:</b> " . $row["ogrenciSube"] . "</p>";
                            } else {
                                echo "Öğrenci bilgileri bulunamadı.";
                            }
                        }
                        ?>
                    </div>
                    <!-- "Kişisel Bilgilerimi Güncelle" butonu -->
                    <button type="button" class="btn" style="background-color:#0f4a8a; color: white; padding: 10px 20px; border-radius: 5px;" data-bs-toggle="modal" data-bs-target="#ogrenciGuncelleModal">Kişisel Bilgilerimi Güncelle</button>
                </div>
            </div>
                        
            <!-- Öğrenci Bilgileri Güncelle Modalı -->
           <div class="modal fade" id="ogrenciGuncelleModal" tabindex="-1" aria-labelledby="ogrenciGuncelleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ogrenciGuncelleModalLabel">Kişisel Bilgilerimi Güncelle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <!-- Öğrenci bilgileri güncelleme formu -->
                <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='post' enctype='multipart/form-data'>
                    <label for='isim'>İsim:</label>
                    <input type='text' id='isim' name='isim' value='<?php echo isset($row["ogrenciIsim"]) ? $row["ogrenciIsim"] : ""; ?>' class="form-control"><br>
                    <label for='soyisim'>Soyisim:</label>
                    <input type='text' id='soyisim' name='soyisim' value='<?php echo isset($row["ogrenciSoyisim"]) ? $row["ogrenciSoyisim"] : ""; ?>' class="form-control"><br>
                    <label for='email'>Email:</label>
                    <input type='email' id='email' name='email' value='<?php echo isset($row["ogrenciEmail"]) ? $row["ogrenciEmail"] : ""; ?>' class="form-control"><br>
                    <label for='adres'>Adres:</label>
                    <input type='text' id='adres' name='adres' value='<?php echo isset($row["ogrenciAdres"]) ? $row["ogrenciAdres"] : ""; ?>' class="form-control"><br>
                    <label for='resim'>Fotoğraf Yükle:</label>
                    <input type='file' id='resim' name='resim' class="form-control"><br>
                    <button type="submit" name="submit_guncelle" class="btn btn-primary">Bilgileri Güncelle</button>
                </form>
                <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_guncelle'])) {
                $isim = $_POST['isim'];
                $soyisim = $_POST['soyisim'];
                $email = $_POST['email'];
                $adres = $_POST['adres'];
                $ogrenciNumara = $_SESSION['ogrenciNumara'];
            
                // Resmi base64'e çevirme işlemi
                $resimBase64 = null;
                if(isset($_FILES['resim']) && $_FILES['resim']['error'] == 0) {
                    $resimDosya = $_FILES['resim']['tmp_name'];
                    $resimIcerik = file_get_contents($resimDosya);
                    $resimBase64 = base64_encode($resimIcerik);
                }
            
                // Veritabanında güncelleme sorgusu
                if ($resimBase64 !== null) {
                    $sql = "UPDATE ogrenciler SET ogrenciIsim='$isim', ogrenciSoyisim='$soyisim', ogrenciEmail='$email', ogrenciAdres='$adres', ogrenciResim='$resimBase64' WHERE ogrenciNumara=$ogrenciNumara";
                } else {
                    $sql = "UPDATE ogrenciler SET ogrenciIsim='$isim', ogrenciSoyisim='$soyisim', ogrenciEmail='$email', ogrenciAdres='$adres' WHERE ogrenciNumara=$ogrenciNumara";
                }
            
                if ($baglanti->query($sql) === TRUE) {
                    echo "Bilgiler başarıyla güncellendi.";
                } else {
                    echo "Hata: " . $sql . "<br>" . $baglanti->error;
                }
            }
            
                ?>
                
            </div>
        </div>
    </div>
</div>

        
             <!-- Duyurular -->
   <div class="container" style="max-width: 46rem; ">
            <h3 class="text-center  mb-4">Duyurular</h3>
            <div class="accordion" id="accordionExample" >
                <?php

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
    function openiletisimModal() {
        $('#iletisimModal').modal('show');
    }
</script>
  
<div class="modal fade" id="iletisimModal" tabindex="-1" aria-labelledby="iletisimModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iletisimModalLabel">Bize Ulaşın</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Bize Ulaşın formu -->
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="ulasanEmail" class="form-label">E-posta Adresiniz</label>
                        <input type="email" class="form-control" id="ulasanEmail" name="ulasanEmail" placeholder="E-posta adresinizi girin">
                    </div>
                    <div class="mb-3">
                        <label for="ulasanMesaj" class="form-label">Mesajınız</label>
                        <textarea class="form-control" id="ulasanMesaj" name="ulasanMesaj" rows="4" placeholder="Mesajınızı buraya yazın"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit">Gönder</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Mail Adresleri Modal -->
<div class="modal fade" id="mailModal" tabindex="-1" aria-labelledby="mailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mailModalLabel">Mail Adresleri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Pozisyon ara..." id="searchPositionInput" oninput="searchPositions()">
                </div>
                <form action="index.php" method="POST">
                    <!-- Mail Adresleri tablosu -->
                    <?php
                    if (!$baglanti) {
                        die("Bağlantı başarısız: " . mysqli_connect_error());
                    }

                    mysqli_set_charset($baglanti, "UTF8");

                    $sorgu = "SELECT unvan.unvanAdi,  ogretmenler.ogretmenEmail
                              FROM unvan
                              INNER JOIN ogretmenler ON unvan.unvanID = ogretmenler.unvanID
                              UNION
                              SELECT unvan.unvanAdi, yetkili.yetkiliEmail
                              FROM yetkili
                              INNER JOIN unvan ON yetkili.unvanID = unvan.unvanID";

                    // Sorguyu çalıştır
                    $sonuc = mysqli_query($baglanti, $sorgu);

                    // Sonucu kontrol et
                    if (mysqli_num_rows($sonuc) > 0) {
                        // Verileri döngü ile al ve tabloya ekle
                        echo "<table class='table' id='emailTable'>
                                <thead>
                                    <tr>
                                        <th scope='col'>Pozisyon</th>
                                        <th scope='col'>Email</th>
                                    </tr>
                                </thead>
                                <tbody>";

                        while ($row = mysqli_fetch_assoc($sonuc)) {
                            echo "<tr>
                                    <td>" . $row["unvanAdi"] . "</td> 
                                    <td><a href='mailto:" . $row["ogretmenEmail"] . "'>" . $row["ogretmenEmail"] . "</a></td>
                                  </tr>";
                        }

                        echo "</tbody></table>";
                    } else {
                        echo "Veri bulunamadı.";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Mail Adresleri Modal Açma ve Kapatma Fonksiyonları -->
<script>
    function openMailModal() {
        $('#mailModal').modal('show');
    }

    function searchPositions() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchPositionInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("emailTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>


<script>
    // Form gönderildikten sonra, bir alert göster
    window.onload = function() {
        var formSubmitted = localStorage.getItem('formSubmitted');
        if(formSubmitted) {
            alert(formSubmitted);
            localStorage.removeItem('formSubmitted'); // Alert gösterildikten sonra localStorage'ı temizle
        }
    }
</script>

<!-- Randevular Modal -->
<div class="modal fade" id="randevuModal" tabindex="-1" aria-labelledby="randevuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="randevuModalLabel">Randevu Bilgileri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php
// Kontrol bölümü
if (isset($_SESSION['ogrenciID'])) {
    $ogrenciID = $_SESSION['ogrenciID'];

    // Öğrencinin randevularını sorgula
    $sorgu = "SELECT r.ogretmenID, r.randevuSaati, r.randevuTarihi, o.ogretmenIsim, o.ogretmenSoyisim
              FROM randevular r
              INNER JOIN ogretmenler o ON r.ogretmenID = o.ogretmenID
              WHERE r.ogrenciID = '$ogrenciID'";
    $sonuc = mysqli_query($baglanti, $sorgu);

    // Eğer sorgu başarılıysa
    if ($sonuc) {
        // Randevu bilgilerini göster
        echo "<table class='table'> 
            <thead>
                <tr>
                    <th scope='col'>Öğretmen İsim</th>
                    <th scope='col'>Öğretmen Soyisim</th>
                    <th scope='col'>Randevu Tarihi</th>
                    <th scope='col'>Randevu Saati</th>
                </tr>
            </thead>
            <tbody>";
        while ($row = mysqli_fetch_assoc($sonuc)) {
            echo "<tr>";
            echo "<td>" . $row['ogretmenIsim'] . "</td>";
            echo "<td>" . $row['ogretmenSoyisim'] . "</td>";
            echo "<td>" . $row['randevuTarihi'] . "</td>";
            echo "<td>" . $row['randevuSaati'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "Randevular getirilirken bir hata oluştu.";
    }
} else {
    echo "Oturum açılmamış.";
}
?>

        </div>
    </div>
</div>
<script>
    function openrandevuModal() {
        $('#randevuModal').modal('show');
    }
</script>



</body>
</html>

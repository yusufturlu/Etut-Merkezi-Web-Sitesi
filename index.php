<?php include ("db/baglanti.php"); ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pırıltı Bire Bir Etüt Merkezi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .carousel-item img {
            max-height: 400px;
            width: auto;
            margin: 0 auto;
        }
    .carousel-caption {
        font-size: 28px; /* Yazı boyutunu ayarla */
        text-align: center; /* Metni ortala */
        position: absolute;
        top: 50%; /* Yüksekliği yukarıdan aşağıya ortalama */
        left: 50%; /* Genişliği soldan sağa ortalama */
        transform: translate(-50%, -50%); /* Metni yatay ve dikey olarak ortala */
        color: white; /* Yazı rengini beyaz yap */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 1); /* Hafif bir gölge ekle */
    }
</style>

</head>


<?php
session_start();

// Yetkili Giriş İşlemleri
if (isset($_POST['yetkiliID'], $_POST['yetkiliSifre'])) {
    $yetkiliID = $_POST['yetkiliID'];
    $yetkiliSifre = $_POST['yetkiliSifre'];

    $stmt = $baglanti->prepare("SELECT * FROM yetkili WHERE yetkiliID = ? AND yetkiliSifre = ?");
    $stmt->bind_param("ss", $yetkiliID, $yetkiliSifre);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['yetkiliID'] = $yetkiliID;
        header("Location: yetkiliAnasayfa.php");
        exit;
    } else {
        $error_message = 'Geçersiz yetkili ID veya şifre.';
    }
}
// Öğrenci Giriş İşlemleri
if (isset($_POST['ogrenciNumara'], $_POST['ogrenciSifre'])) {
    $ogrenciNumara = $_POST['ogrenciNumara'];
    $ogrenciSifre = $_POST['ogrenciSifre'];

    $stmt = $baglanti->prepare("SELECT * FROM ogrenciler WHERE ogrenciNumara = ? AND ogrenciSifre = ?");
    $stmt->bind_param("ss", $ogrenciNumara, $ogrenciSifre);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['ogrenciID'] = $row['ogrenciID'];
        $_SESSION['ogrenciNumara'] = $ogrenciNumara;
        header("Location: ogrenciAnasayfa.php");
        exit;
    } else {
        $error_message = 'Geçersiz öğrenci numarası veya şifre.';
    }
}
// Öğretmen Giriş İşlemleri
if (isset($_POST['ogretmenNumara'], $_POST['ogretmenSifre'])) {
    $ogretmenNumara = $_POST['ogretmenNumara'];
    $ogretmenSifre = $_POST['ogretmenSifre'];

    $stmt = $baglanti->prepare("SELECT * FROM ogretmenler WHERE ogretmenNumara = ? AND ogretmenSifre = ?");
    $stmt->bind_param("ss", $ogretmenNumara, $ogretmenSifre);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['ogretmenID'] = $row['ogretmenID'];
        $_SESSION['ogretmenNumara'] = $ogretmenNumara;
        header("Location: ogretmenAnasayfa.php");
        exit;
    } else {
        $error_message = 'Geçersiz öğretmen numarası veya şifre.';
    }
}
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
    } else {
        // Eksik veya hatalı veri girişi durumunda JavaScript kodunu kullanarak bir alert göster
        echo '<script>alert("Eksik veya hatalı veri girişi.");</script>';
    }
}

?>

<body>
    <!-- Navbar -->
<?php 

include 'includes/navbar.php';

?>

<!-- Slider -->
<?php 

include 'includes/slider.php';

?>
<?php

// Veritabanından verileri çekme sorgusu
$sorgu = "SELECT * FROM anasayfa_card"; // ananasayfa_Card tablosundaki tüm verileri çekiyoruz

// Sorguyu çalıştırma
$sonuc = mysqli_query($baglanti, $sorgu);

// Verileri kullanarak HTML çıktısını oluşturma
echo '<div class="temel-card" style=" display:flex; flex-direction:row; margin:50px 150px; ">';
while ($satir = mysqli_fetch_assoc($sonuc)) {
    // Her bir kart için içeriği dolduruyoruz
    echo '<div class="card" style="width: 18rem; margin:50px; ">';
    echo '<img src="data:image/jpeg;base64,' . base64_encode($satir['sinif_foto']) . '" class="card-img-top" alt="...">'; // Sinif fotoğrafını belirtiyoruz
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $satir['sinif_baslik'] . '</h5>'; // Sinif basligini çekiyoruz
    echo '<p class="card-text">' . $satir['sinif_aciklama'] . '</p>'; // Sinif aciklamasini çekiyoruz
    echo '</div>';
    echo '</div>';

    // Kadromuz karti
    echo '<div class="card" style="width: 18rem; margin:50px; ">';
    echo '<img src="data:image/jpeg;base64,' . base64_encode($satir['kadromuz_foto']) . '" class="card-img-top" alt="...">'; // Kadromuz fotoğrafını belirtiyoruz
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $satir['kadromuz_baslik'] . '</h5>'; // Kadromuz basligini çekiyoruz
    echo '<p class="card-text">' . $satir['kadromuz_aciklama'] . '</p>'; // Kadromuz aciklamasini çekiyoruz
    echo '</div>';
    echo '</div>';

    // Dersler karti
    echo '<div class="card" style="width: 18rem; margin:50px; ">';
    echo '<img src="data:image/jpeg;base64,' . base64_encode($satir['ders_foto']) . '" class="card-img-top" alt="...">'; // Ders fotoğrafını belirtiyoruz
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $satir['ders_baslik'] . '</h5>'; // Ders basligini çekiyoruz
    echo '<p class="card-text">' . $satir['ders_aciklama'] . '</p>'; // Ders aciklamasini çekiyoruz
    echo '</div>';
    echo '</div>';
}
echo '</div>';

?>
    <!-- Footer -->
   <?php 
   
   include 'includes/footer.php';
   
   ?>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- Yetkili Giriş Modal -->
     <?php 
     
    include 'includes/admin-modal.php' ;
     
     ?>

    <!-- Öğrenci Giriş Modal -->
        <?php 

        include 'includes/student-modal.php' ;

        ?>
    <!-- Öğretmen Giriş Modalını Açmak İçin JavaScript -->
 <?php 
 
 include 'includes/teacher-modal.php' ;
 
 ?>
    <!-- İletişim Modalını Açmak İçin JavaScript -->
<?php 

 include 'includes/contact-modal.php' ;

?>

<!-- Öğretmen Şifremi Unuttum Modalı -->
<div class="modal fade" id="ogretmenSifremiUnuttumModal" tabindex="-1" aria-labelledby="ogretmenSifremiUnuttumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f8f9fa;">
                <h5 class="modal-title" id="ogretmenSifremiUnuttumModalLabel" style="font-size: 1.5rem;">Şifremi Unuttum Formu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
                
                        <?php
                        if(isset($_GET['error']) && $_GET['error'] == 'not_found') {
                            echo '<p class="text-danger text-center">Bu e-posta adresi veritabanında bulunamadı.</p>';
                        }
                        ?>
                        <form action="ogretmenmailgonder.php" method="POST">
                            <div class="mb-3">
                                <input type="email" name="eposta" class="form-control" placeholder="Eposta giriniz" style="border-radius: 5px; border: 1px solid #ced4da; box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.1);" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 1rem; border-radius: 5px; transition: all 0.3s ease;">GÖNDER</button>
                            </div>
                        </form>
                   
            </div>
        </div>
    </div>
</div>

<!-- Öğretmen Şifremi Unuttum Modalını Açmak İçin JavaScript -->
<script>
    function openOgretmenSifremiUnuttumModal() {
        $('#ogretmenSifremiUnuttumModal').modal('show');
    }
</script>
<!-- Yetkili Şifremi Unuttum Modalı -->
<div class="modal fade" id="yetkiliSifremiUnuttumModal" tabindex="-1" aria-labelledby="yetkiliSifremiUnuttumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f8f9fa;">
                <h5 class="modal-title" id="yetkiliSifremiUnuttumModalLabel" style="font-size: 1.5rem;">Şifremi Unuttum Formu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
               
                        <?php
                        if(isset($_GET['error']) && $_GET['error'] == 'not_found') {
                            echo '<p class="text-danger text-center">Bu e-posta adresi veritabanında bulunamadı.</p>';
                        }
                        ?>
                        <form action="yetkilimailgonder.php" method="POST">
                            <div class="mb-3">
                                <input type="email" name="eposta" class="form-control" placeholder="Eposta giriniz" style="border-radius: 5px; border: 1px solid #ced4da; box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.1);" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 1rem; border-radius: 5px; transition: all 0.3s ease;">GÖNDER</button>
                            </div>
                        </form>
                   
            </div>
        </div>
    </div>
</div>

<!-- Yetkili Şifremi Unuttum Modalını Açmak İçin JavaScript -->
<script>
    function openYetkiliSifremiUnuttumModal() {
        $('#yetkiliSifremiUnuttumModal').modal('show');
    }
</script>

<!-- Öğrenci Şifremi Unuttum Modalı -->
<div class="modal fade" id="ogrenciSifremiUnuttumModal" tabindex="-1" aria-labelledby="ogrenciSifremiUnuttumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f8f9fa;">
                <h5 class="modal-title" id="ogrenciSifremiUnuttumModalLabel" style="font-size: 1.5rem;">Şifremi Unuttum Formu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f8f9fa;">
            <?php
                        if(isset($_GET['error']) && $_GET['error'] == 'not_found') {
                            echo '<p class="text-danger text-center">Bu e-posta adresi veritabanında bulunamadı.</p>';
                        }
                        ?>
                        <form action="php/ogrencimailgonder.php" method="POST">
                            <div class="mb-3">
                                <input type="email" name="eposta" class="form-control" placeholder="Eposta giriniz" style="border-radius: 5px; border: 1px solid #ced4da; box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.1);" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 1rem; border-radius: 5px; transition: all 0.3s ease;">GÖNDER</button>
                            </div>
                        </form>
            </div>
        </div>
    </div>
</div>
<!-- Öğrenci Şifremi Unuttum Modalını Açmak İçin JavaScript -->
<script>
    function openOgrenciSifremiUnuttumModal() {
        $('#ogrenciSifremiUnuttumModal').modal('show');
    }
</script>
    <?php
// Veritabanı bağlantısını kapat
mysqli_close($baglanti);
?>
</body>
</html>
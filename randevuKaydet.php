<?php
include("baglanti.php");

session_start(); // Oturumu başlat

if (isset($_SESSION['ogrenciID'])) {
    $ogrenciID = $_SESSION['ogrenciID']; // Giriş yapan öğrencinin ID'sini al
} else {
    echo "Öğrenci kimliği bulunamadı. Lütfen giriş yapın.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $randevuTarihi = $_POST['randevuTarihi'];
    $randevuSaati = $_POST['randevuSaati'];
    $ogretmenIsim = $_POST['ogretmenIsim']; // Öğretmen adı

    // Öğretmen ID'sini almak için sorgu
    $query = "SELECT ogretmenID FROM ogretmenler WHERE CONCAT(ogretmenIsim, ' ', ogretmenSoyisim) = '$ogretmenIsim'";
    $result = mysqli_query($baglanti, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $ogretmenID = $row['ogretmenID'];

        // Randevu alınan tarihi ve saati kontrol et
        $checkQuery = "SELECT * FROM randevular WHERE randevuTarihi = '$randevuTarihi' AND randevuSaati = '$randevuSaati' AND ogretmenID = '$ogretmenID'";
        $checkResult = mysqli_query($baglanti, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "Seçilen tarih ve saatte öğretmenin randevusu dolu!";
        } else {
            // Randevu kaydetmek için sorgu
            $insertQuery = "INSERT INTO randevular (randevuTarihi, randevuSaati, ogretmenID, ogrenciID) VALUES ('$randevuTarihi', '$randevuSaati', '$ogretmenID', '$ogrenciID')";
            if (mysqli_query($baglanti, $insertQuery)) {
                echo "Randevu başarıyla kaydedildi!";
            } else {
                echo "Randevu kaydedilirken bir hata oluştu: " . mysqli_error($baglanti);
            }
        }
    } else {
        echo "Öğretmen bulunamadı: " . mysqli_error($baglanti);
    }
} else {
    echo "Geçersiz istek.";
}
?>

<?php
// Bağlantı dosyasını içe aktar
include("baglanti.php");

// GET parametrelerini al
$clickedDate = $_GET['clickedDate'];
$clickedDayName = $_GET['clickedDayName'];

// SQL sorgusu: Veritabanından uygun öğretmenleri seç
$query = "
    SELECT ogretmenler.ogretmenIsim, ogretmenler.ogretmenSoyisim, dersler.dersAdi 
    FROM ogretmenler 
    INNER JOIN dersler ON ogretmenler.dersID = dersler.dersID 
    WHERE FIND_IN_SET('$clickedDayName', ogretmenler.bosGunler) = 0";

$result = $baglanti->query($query);

// Seçeneklerin oluşturulması
$options = "";
while ($row = $result->fetch_assoc()) {
  $options .= '<option value="' . $row['dersAdi'] . ' - ' . $row['ogretmenIsim'] . ' ' . $row['ogretmenSoyisim'] . '">' . $row['dersAdi'] . ' - ' . $row['ogretmenIsim'] . ' ' . $row['ogretmenSoyisim'] . '</option>';
}

// Sonuçları geri döndür
echo $options;

// Bağlantıyı kapat
$baglanti->close();
?>

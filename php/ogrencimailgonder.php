<?php
use PHPMailer\PHPMailer\PHPMailer;

$gemail = $_POST['eposta'];

include("../db/baglanti.php");

// Veritabanında e-posta adresini ara
$query = "SELECT * FROM ogrenciler WHERE ogrenciemail='$gemail'";
$result = mysqli_query($baglanti, $query) or die(mysqli_error($baglanti));
$num_row = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

// Eğer e-posta adresi bulunduysa
if ($num_row >= 1) {
    $gideceksifre = $row['ogrenciSifre'];
    
    // PHPMailer sınıfını dahil et
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    
    // Mail gönderme işlemleri
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "ustanisa2@gmail.com"; // Gönderen e-posta adresi
    $mail->Password = "jxjp viie hyzw xjja"; // Gönderen e-posta şifresi
    $mail->addAddress($gemail);
    $mail->Subject = "Hatirlatma Maili";
    $mail->Body = "Şifreniz: " . $gideceksifre;
    
    if ($mail->Send())
        echo "Gönderildi";
 
    else
        echo "Gönderilemedi";
} else {
    echo "Bu e-posta adresi veritabanında bulunamadı.";
}
?>

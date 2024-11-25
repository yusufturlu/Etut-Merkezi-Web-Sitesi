<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// E-posta adresini al
$gemail = $_POST['eposta'];

include("baglanti.php");
// Veritabanında e-posta adresini ara
$query = "SELECT * FROM yetkili WHERE yetkiliemail='$gemail'";
$result = mysqli_query($baglanti, $query) or die(mysqli_error($baglanti));

// Eğer e-posta adresi bulunduysa
if (mysqli_num_rows($result) >= 1) {
    $row = mysqli_fetch_array($result);
    $gideceksifre = $row['yetkiliSifre'];
    
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
    $mail->Subject = "Hatırlatma Maili";
    $mail->Body = "Şifreniz: " . $gideceksifre;
    
    if ($mail->Send())
        echo "Gönderildi";
    else
        echo "Gönderilemedi";
} else {
    echo "Bu e-posta adresi veritabanında bulunamadı.";
}

?>

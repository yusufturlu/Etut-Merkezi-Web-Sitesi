<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yetkili Giriş Sayfası</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        input[type="text"], input[type="password"] {
            width: 93%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 0;
            background-color: #333;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <h2>Admin Girişi</h2>
            <input type="text" name="name" placeholder="Yetkili Adı">
            <input type="text" name="keyword" placeholder="Yetkili Şifresi">
            <input type="submit" value="Giriş Yap" name="submit">
    </form>
</body>
</html>
<?php 

include '../db/baglanti.php';


if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $keyword = $_POST['keyword'];

    $query = ("SELECT yetkiliAd,yetkiliSifre FROM yetkili WHERE yetkiliAd =? AND yetkiliSifre =?");
    $stmt = $baglanti->prepare($query);
    $stmt->bind_param("ss", $name, $keyword);
    $stmt->execute();

    $result = $stmt->get_result();
    if($result->num_rows > 0) {
        session_start();
        $_SESSION['admin'] = $_POST['name'];
        header("Location: yetkiliAnasayfa.php");
    }else {
        echo "<script>alert('Giriş Başarısız !')</script>";
    }
}

?>
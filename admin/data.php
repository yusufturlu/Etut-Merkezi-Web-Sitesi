<?php
// Bağlantı dosyasını içe aktar
include("../db/baglanti.php");

session_start() ;

if (!isset($_SESSION['admin'])) {
    header('Location: admin-login.php');
    exit;
}


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
  $options .= '<tr>';
  $options .= '<td>' . $row['dersAdi'] . '</td>';
  $options .= '<td>' . $row['ogretmenIsim'] . '</td>';
  $options .= '<td>' . $row['ogretmenSoyisim'] . '</td>';
  $options .= '</tr>';
}

// Bağlantıyı kapat
$baglanti->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğretmen Listesi</title>
    
    <!-- CSS kodları -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
            color: #333;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Öğretmen ve Ders Listesi</h1>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Ders Adı</th>
                        <th>Öğretmen Adı</th>
                        <th>Öğretmen Soyadı</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $options; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

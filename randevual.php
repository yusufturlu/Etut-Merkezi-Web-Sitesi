<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pırıltı Bire Bir Etüt Merkezi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
 #calendar {
            max-height: 600px;
            overflow-y: auto;
            margin-bottom: 20px;
            border: 3px solid #888;
            padding: 30px;
            border-radius: 5px;
        }

        .modal-content {
            background-color: #fefefe;
            border: 1px solid #888;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            font-size: 28px;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header,
        .modal-footer {
            border: none;
        }  

        .btn-primary {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
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
    <div id="calendar"></div>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" >
                <h5 class="modal-title" id="exampleModalLabel">Ders ve Öğretmen Seçimi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                <p>Tıklanan Tarih: <span id="modal-date"></span></p>
                <p>Gün: <span id="week-day"></span></p>
                <p>Öğretmen Seç: <span id="selected-teacher"></span></p>
                <input type="text" id="searchInput" onkeyup="searchFunction()" class="form-control mb-3"
                       placeholder="Öğretmen Ara.."/>
                <select name="lessonTeacher" id="lessonTeacher" class="form-select" size="10"></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#timeModal">Saat
                    Seç
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="timeModal" tabindex="-1" aria-labelledby="timeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timeModalLabel">Saat Seçme</h5>
                
            </div>
            <div class="modal-body" >
                <p>Seçilen Öğretmen: <span id="selected-teacher-time-modal"></span></p>
                <hr/>
                <p>Saatleri seçin:</p>
                <div class="row">
                    <?php for ($hour = 9; $hour <= 17; $hour += 2) {
                        $start = sprintf('%02d:00', $hour);
                        $end = sprintf('%02d:00', $hour + 2);
                        ?>
                        <div class="col-md-2">
                            <p><?php echo $start . ' - ' . $end; ?></p>
                            <button type="button" class="btn btn-primary">Randevu Al</button>
                        </div>
                    <?php } ?>
                </div>
            </div>
           
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/tr.global.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var calendarEl = document.getElementById("calendar");
        var modal = new bootstrap.Modal(document.getElementById("myModal"), {keyboard: false});

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            locale: "tr",
            validRange: {
                start: new Date().toISOString().split("T")[0],
            },
            dateClick: function (info) {
                modal.show();
                var clickedDate = new Date(info.dateStr);
                document.getElementById("modal-date").innerText = info.dateStr;
                document.getElementById("week-day").innerText = getDayName(clickedDate);
                updateTeacherList(info.dateStr); // Yeni fonksiyon çağrısı
            },
        });
        calendar.render();

        function getDayName(date) {
            var days = ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'];
            return days[date.getDay()];
        }

        function updateTeacherList(clickedDate) {
            var clickedDayName = getDayName(new Date(clickedDate));
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?clickedDate=' + clickedDate + '&clickedDayName=' + clickedDayName, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("lessonTeacher").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        document.querySelector(".modal-footer .btn-primary").addEventListener("click", function () {
            var selectedTeacher = document.getElementById("lessonTeacher").value;
            document.getElementById("selected-teacher-time-modal").innerText = selectedTeacher;
            new bootstrap.Modal(document.getElementById("timeModal")).show();
        });

        document.querySelectorAll("#timeModal .btn-primary").forEach(function (button) {
            button.addEventListener("click", function () {
                var selectedDate = document.getElementById("modal-date").innerText;
                var selectedTeacher = document.getElementById("lessonTeacher").value.split(" - ")[1];
                var selectedTime = this.parentElement.querySelector("p").innerText;

                var timeParts = selectedTime.split(" - ")[0].split(":");
                var selectedTimeFormatted = timeParts[0] + ":" + timeParts[1] + ":00";

                var confirmationMessage = "Randevuyu onaylıyor musunuz?";
                if (confirm(confirmationMessage)) {
                    var formData = new FormData();
                    formData.append("randevuTarihi", selectedDate);
                    formData.append("randevuSaati", selectedTimeFormatted);
                    formData.append("ogretmenIsim", selectedTeacher);

                    fetch("randevuKaydet.php", {
                        method: "POST",
                        body: formData,
                    })
                        .then((response) => response.text())
                        .then((data) => {
                            alert(data);
                            new bootstrap.Modal(document.getElementById("timeModal")).hide();
                        })
                        .catch((error) => console.error("Error:", error));
                }
            });
        });
    });
</script>
</body>
</html>

<?php
if (isset($_GET['clickedDate']) && isset($_GET['clickedDayName'])) {
    include("baglanti.php");

    $clickedDate = $_GET['clickedDate'];
    $clickedDayName = $_GET['clickedDayName'];

    $query = "
        SELECT ogretmenler.ogretmenIsim, ogretmenler.ogretmenSoyisim, dersler.dersAdi 
        FROM ogretmenler 
        INNER JOIN dersler ON ogretmenler.dersID = dersler.dersID 
        WHERE FIND_IN_SET('$clickedDayName', ogretmenler.bosGunler) = 0";

    $result = $baglanti->query($query);

    $options = "";
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['dersAdi'] . ' - ' . $row['ogretmenIsim'] . ' ' . $row['ogretmenSoyisim'] . '">' . $row['dersAdi'] . ' - ' . $row['ogretmenIsim'] . ' ' . $row['ogretmenSoyisim'] . '</option>';
    }

    echo $options;

    $baglanti->close();
}
?>
</div></div>



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

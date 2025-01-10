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
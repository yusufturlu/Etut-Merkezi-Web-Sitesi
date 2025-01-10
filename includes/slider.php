<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php
        $sql = "SELECT * FROM anasayfa_foto";
        $result = mysqli_query($baglanti, $sql);
        $indicator_count = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $active_class = ($indicator_count == 0) ? 'active' : '';
            ?>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?= $indicator_count ?>" class="<?= $active_class ?>" aria-current="<?= $active_class ?>"></button>
            <?php
            $indicator_count++;
        }
        ?>
    </div>
    <div class="carousel-inner">
        <?php
        $item_count = 0; // item_count değişkenini tanımladık
        mysqli_data_seek($result, 0); // Sonraki döngü için imleci başa alıyoruz
        while ($row = mysqli_fetch_assoc($result)) {
            $active_class = ($item_count == 0) ? 'active' : '';
            ?>
            <div class="carousel-item <?= $active_class ?>">
                <img src="data:image/jpeg;base64,<?= base64_encode($row["fotolar"]) ?>" class="d-block w-100" >
                <div class="carousel-caption d-none d-md-block">
                    <h4><?= $row['altyazı'] ?></h4>
                </div>
            </div>
            <?php
            $item_count++;
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Önceki</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Sonraki</span>
    </button>
</div>
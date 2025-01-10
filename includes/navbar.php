<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php"
                style="font-family: 'Arial Black', sans-serif; font-size: 24px; font-weight: bold;">
                <img src="image/pirilti.png" alt="Pırıltı Logo" style="height: 150px;">
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main/hakkimizda.php">Hakkımızda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main/hizmetler.php">Hizmetler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="openiletisimModal()">İletişim</a>
                    </li>
                    <!-- Giriş Kısmı -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Giriş Yap
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#" onclick="openOgrenciGirisModal()">Öğrenci Giriş</a>
                            </li>
                            <li><a class="dropdown-item" href="#" onclick="openOgretmenGirisModal()">Öğretmen Giriş</a>
                            </li>
                            <li><a class="dropdown-item" href="#" onclick="openYetkiliGirisModal()">Yetkili Giriş</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<script>
        // Yetkili Giriş Modalını Açmak İçin Fonksiyon
        function openYetkiliGirisModal() {
            $('#yetkiliGirisModal').modal('show'); // Modalı aç
        }
    </script>
    <!-- Yetkili Giriş Modalı -->
    <div class="modal fade" id="yetkiliGirisModal" tabindex="-1" aria-labelledby="yetkiliGirisModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="yetkiliGirisModalLabel">Yetkili Giriş</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="image/girislogo.png" alt="Giriş Logo" style="max-width: 100%; height: auto;">
                        </div>
                        <div class="col-md-6">
                            <!-- Yetkili giriş formu -->
                            <form action="index.php" method="POST">
                                 <div class="mb-3">
                                    <label for="yetkiliID" class="form-label">Kullanıcı Numarası</label>
                                    <input type="text" class="form-control" id="yetkiliID" name="yetkiliID" required>
                                 </div>
                                <div class="mb-3">
                                    <label for="yetkiliSifre" class="form-label">Şifre</label>
                                    <input type="password" class="form-control" id="yetkiliSifre" name="yetkiliSifre" required>
                                </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Giriş Yap</button>
                                </form>
                                <div class="mt-3">
                                    <a href="index.php" class="btn btn-danger btn-sm btn-block" style="box-shadow: 0px 0px 5px 0px rgba(255, 0, 0, 0.75);">İptal Et</a>
                                    <a href="#" onclick="openYetkiliSifremiUnuttumModal()" class="btn btn-link btn-sm btn-block" style="box-shadow: 0px 0px 5px 0px rgba(0, 0, 255, 0.75);">Şifremi Unuttum</a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            <input type="email" class="form-control" id="ulasanEmail" name="ulasanEmail"
                                placeholder="E-posta adresinizi girin">
                        </div>
                        <div class="mb-3">
                            <label for="ulasanMesaj" class="form-label">Mesajınız</label>
                            <textarea class="form-control" id="ulasanMesaj" name="ulasanMesaj" rows="4"
                                placeholder="Mesajınızı buraya yazın"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit">Gönder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

<!-- Modal Upload Bukti Bayar PNBP -->
<div class="modal fade" id="modalUploadPNBP" tabindex="-1" role="dialog" aria-labelledby="modalUploadPNBPLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content border-0 shadow-lg">
            <form id="formUploadPNBP" method="post" enctype="multipart/form-data" action="<?= base_url('cuti/upload_pnbp'); ?>">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalUploadPNBPLabel">
                        <i class="fa fa-upload"></i> Upload Bukti Bayar PNBP Notaris Pengganti
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Hidden field -->
                    <input type="hidden" name="id_cuti" id="pnbp_id_cuti">

                    <!-- Upload Field Bukti Bayar-->
                    <div class="form-group">
                        <label for="pnbp_file" class="font-weight-bold">
                            Pilih File Bukti Bayar (PDF / Word / Gambar)<br>
                            <small style="color: red!important;">Dokumen Pendukung : Voucher Pemesanan, Bukti Bayar PNBP Notaris Pengganti</small>
                        </label>
                        <input type="file"
                               name="pnbp_file"
                               id="pnbp_file"
                               class="form-control"
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               required>
                        <small class="text-muted">
                            Maksimal 5 MB &nbsp;|&nbsp; Format diperbolehkan:
                            <b>PDF, DOC, DOCX, JPG, PNG</b>
                        </small>
                    </div>

                    <!-- Tempat tampilkan file yang sudah ada -->
                    <div id="pnbp_existing_file" class="mt-3"></div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Tutup
                    </button>
                    <button type="submit" name="btn_upload_pnbp" id="btn_upload_pnbp" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan Bukti
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script validasi tambahan -->
<script>
    $(document).ready(function () {

        // 🔹 Validasi file sebelum upload
        $('#pnbp_file').on('change', function () {
            const file = this.files[0];
            if (!file) return;

            // MIME types yang diizinkan
            const allowedTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'image/jpeg',
                'image/png'
            ];

            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Format tidak didukung',
                    text: 'Gunakan file PDF, Word (DOC/DOCX), JPG, atau PNG.',
                    confirmButtonColor: '#3085d6'
                });
                $(this).val('');
                return;
            }

            // Batas ukuran file: 5MB
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ukuran File Terlalu Besar',
                    text: 'Maksimal 5 MB diperbolehkan.',
                    confirmButtonColor: '#3085d6'
                });
                $(this).val('');
            }
        });

        // 🔹 Saat tombol submit ditekan
        $('#formUploadPNBP').on('submit', function (e) {
            const fileInput = $('#pnbp_file').val();

            if (!fileInput) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'File belum dipilih',
                    text: 'Silakan pilih file terlebih dahulu sebelum menyimpan.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Tampilkan loading SweetAlert
            Swal.fire({
                title: 'Mengupload Bukti...',
                html: 'Mohon tunggu sebentar, sistem sedang memproses file Anda.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Setelah submit, biarkan form berjalan normal
            // Namun jika ingin via AJAX, nanti bisa diubah di sini
        });

        // 🔹 Deteksi flash message sukses/gagal dari PHP (opsional)
        <?php if ($this->session->flashdata('msg')): ?>
        const msgHtml = `<?= trim(preg_replace('/\s+/', ' ', $this->session->flashdata('msg'))); ?>`;
        if (msgHtml.includes('Sukses')) {
            // Swal.fire({
            //     icon: 'success',
            //     title: 'Berhasil!',
            //     html: 'Bukti bayar PNBP berhasil diupload.',
            //     confirmButtonColor: '#3085d6'
            // });
        } else if (msgHtml.includes('Gagal')) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Upload!',
                html: 'Terjadi kesalahan saat mengupload file.<br>Silakan coba lagi.',
                confirmButtonColor: '#d33'
            });
        }
        <?php endif; ?>
    });
</script>


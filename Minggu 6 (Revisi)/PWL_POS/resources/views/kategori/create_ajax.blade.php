<form action="{{ route('kategori.store_ajax') }}" method="POST" id="form-tambah-kategori">
    @csrf
    <div id="modal-master" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Kategori</label>
                        <input type="text" name="kategori_kode" id="kategori_kode" class="form-control" required>
                        <small id="error-kategori_kode" class="error-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="kategori_nama" id="kategori_nama" class="form-control" required>
                        <small id="error-kategori_nama" class="error-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan-kategori">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-tambah-kategori").on("submit", function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let formData = new FormData(this);

            $(".error-text").text('');
            $("#btn-simpan-kategori").prop("disabled", true).text("Menyimpan...");

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });

                        $("#modal-master").modal("hide");
                        form[0].reset();
                        if (typeof dataKategori !== 'undefined') {
                            dataKategori.ajax.reload();
                        }
                    } else {
                        if (response.msgField) {
                            $.each(response.msgField, function(key, value) {
                                $("#error-" + key).text(value[0]);
                            });
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message || 'Harap periksa kembali input Anda.'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Terjadi kesalahan saat menghubungi server!'
                    });
                },
                complete: function() {
                    $("#btn-simpan-kategori").prop("disabled", false).text("Simpan");
                }
            });
        });
    });
</script>

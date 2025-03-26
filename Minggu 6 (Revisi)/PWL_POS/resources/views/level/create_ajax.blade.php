<form action="{{ route('level.store_ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Level</label>
                    <input type="text" name="level_kode" id="level_kode" class="form-control" required>
                    <small id="error-level_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Level</label>
                    <input type="text" name="level_name" id="level_name" class="form-control" required>
                    <small id="error-level_name" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-tambah").on("submit", function(e) {
            e.preventDefault();

            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();

            $(".error-text").text('');

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, // Tambahan untuk CSRF
                beforeSend: function() {
                    $("#btn-simpan").prop("disabled", true).text("Menyimpan...");
                },
                success: function(response) {
                    if(response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        $("#modal-master").modal("hide");
                        $("#form-tambah")[0].reset();
                        dataLevel.ajax.reload();
                    } else {
                        $.each(response.msgField, function(key, value) {
                            $("#error-" + key).text(value[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
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
                    $("#btn-simpan").prop("disabled", false).text("Simpan");
                }
            });
        });
    });
</script>

@empty($barang)
<div id="modal-edit-barang" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data barang tidak ditemukan
            </div>
            <a href="{{ url('/barang') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/barang/' . $barang->barang_id . '/update_ajax') }}" method="POST" id="form-edit-barang">
    @csrf
    @method('PUT')

    <div id="modal-edit-barang" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control" name="kategori_id" id="kategori_id" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->kategori_id }}" {{ $barang->kategori_id == $item->kategori_id ? 'selected' : '' }}>
                                {{ $item->kategori_nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kode Barang</label>
                    <input value="{{ $barang->barang_kode }}" type="text" name="barang_kode" id="barang_kode" class="form-control" required>
                    <small id="error-barang_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <input value="{{ $barang->barang_nama }}" type="text" name="barang_nama" id="barang_nama" class="form-control" required>
                    <small id="error-barang_nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Harga Beli</label>
                    <input value="{{ $barang->harga_beli }}" type="number" name="harga_beli" id="harga_beli" class="form-control" required>
                    <small id="error-harga_beli" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Harga Jual</label>
                    <input value="{{ $barang->harga_jual }}" type="number" name="harga_jual" id="harga_jual" class="form-control" required>
                    <small id="error-harga_jual" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $("#form-edit-barang").validate({
        rules: {
            barang_kode: { required: true, minlength: 3, maxlength: 20 },
            barang_nama: { required: true, minlength: 3, maxlength: 100 },
            kategori_id: { required: true },
            harga_beli: { required: true, number: true, min: 1 },
            harga_jual: { required: true, number: true, min: 1 },
        },
        submitHandler: function(form) {
            let formData = $(form).serialize();
            
            console.log("Data yang dikirim:", formData);

            $.ajax({
                url: form.action,
                type: "POST", // Harus POST karena ada _method=PUT
                data: formData,
                success: function(response) {
                    if(response.status) {
                        $('#modal-edit-barang').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        $('#table_barang').DataTable().ajax.reload(); // Refresh data table
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    console.log("Error:", xhr.responseText);
                }
            });

            return false;
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
@endempty

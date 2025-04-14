<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrasi Pengguna</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    
    <style>
        body {
            background: linear-gradient(135deg, #5dacbd 0%, #2c7873 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 450px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border: none;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            padding: 2rem 1rem 1rem;
        }

        .card-header a {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: #2c7873 !important;
            text-decoration: none;
        }

        .card-body {
            padding: 2rem;
        }

        .login-box-msg {
            font-size: 1.2rem;
            color: #444;
            margin-bottom: 2rem;
            text-align: center;
        }

        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-control {
            border-radius: 8px;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #5dacbd;
            box-shadow: none;
        }

        .input-group-text {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            background: transparent;
            border: none;
            z-index: 4;
            padding: 0 1rem;
        }

        .input-group-text span {
            color: #5dacbd;
        }

        .btn-primary {
            background: #2c7873;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #245d59;
            transform: translateY(-2px);
        }

        .text-center a {
            color: #2c7873 !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .text-center a:hover {
            color: #245d59 !important;
            text-decoration: underline;
        }

        .error-text {
            display: block;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1"><b>POS</b> System</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Daftar Pengguna Baru</p>
                <form action="{{ url('register') }}" method="POST" id="form-register">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <small id="error-username" class="error-text text-danger"></small>
                    </div>

                    <div class="input-group">
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-id-card"></span>
                            </div>
                        </div>
                        <small id="error-nama" class="error-text text-danger"></small>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <small id="error-password" class="error-text text-danger"></small>
                    </div>

                    <div class="input-group">
                        <select name="level_id" id="level_id" class="form-control">
                            <option value="">- Pilih Level -</option>
                            @foreach($level as $l)
                                <option value="{{ $l->level_id }}">{{ $l->level_name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-tag"></span>
                            </div>
                        </div>
                        <small id="error-level_id" class="error-text text-danger"></small>
                    </div>

                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-user-plus mr-2"></i> Daftar
                            </button>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <p class="mb-0" style="color: #666;">Sudah punya akun? 
                            <a href="{{ url('login') }}" class="font-weight-bold">Login di sini</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $("#form-register").validate({
                rules: {
                    username: { required: true, minlength: 4, maxlength: 20 },
                    nama: { required: true, maxlength: 100 },
                    password: { required: true, minlength: 5, maxlength: 20 },
                    level_id: { required: true }
                },
                submitHandler: function (form) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Registrasi Berhasil',
                                    text: response.message,
                                }).then(() => {
                                    if (response.redirect) {
                                        window.location = response.redirect;
                                    }
                                });
                            } else {
                                $('.error-text').text('');
                                $.each(response.errors, function (key, val) {
                                    $('#error-' + key).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>
</html>

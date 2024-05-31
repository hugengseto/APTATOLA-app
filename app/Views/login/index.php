<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="/index2.html">Aplikasi <b><?= $aplikasi; ?></b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="text-center font-weight-bold"><?= $toko; ?></p>
                <p class="login-box-msg">Sign in to start your session</p>

                <div class="swal" data-swalTitle="<?= session()->getFlashdata('titleMessage'); ?>" data-swalMessage="<?= session()->getFlashdata('message'); ?>"></div>

                <form action="/auth" method="post">
                    <?= csrf_field(); ?>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control <?= session('errors') && isset(session('errors')['username']) ? 'is-invalid' : ''; ?>" placeholder="Username" name="username" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <?php if (session('errors') && isset(session('errors')['username'])) : ?>
                            <div class="invalid-feedback">
                                <?= esc(session('errors')['username']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control <?= session('errors') && isset(session('errors')['password']) ? 'is-invalid' : ''; ?>" placeholder="Password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <?php if (session('errors') && isset(session('errors')['password'])) : ?>
                            <div class="invalid-feedback">
                                <?= esc(session('errors')['password']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Log In <i class="fas fa-angle-right"></i></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
            <?php if (session()->getFlashdata('messageFailed')) {
                echo '<div class="alert alert-danger text-sm mx-2">' . session()->getFlashdata('messageFailed') . '</div>';
            } ?>
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="/js/sweetalert2.all.min.js"></script>
    <script>
        //SweetAlert2
        // Ambil semua elemen dengan kelas swal
        const swalElements = document.querySelectorAll(".swal");

        // Loop melalui setiap elemen
        swalElements.forEach((element) => {
            // Ambil nilai atribut data untuk setiap elemen
            const swalMessage = element.dataset.swalmessage;
            const swalTitle = element.dataset.swaltitle;

            // Periksa apakah ada pesan yang ditetapkan
            if (swalMessage) {
                // Tampilkan SweetAlert untuk setiap elemen
                Swal.fire({
                    title: swalTitle ? swalTitle : "Successfully",
                    text: swalMessage,
                    icon: "success",
                });
            }
        });

        // Menggunakan event listener untuk mengonfirmasi logout
        document.querySelectorAll(".login-btn").forEach((btn) => {
            btn.addEventListener("click", function(event) {

                Swal.fire({
                    title: "Good job!",
                    text: "You clicked the button!",
                    icon: "success"
                });
            });
        });
    </script>
</body>

</html>
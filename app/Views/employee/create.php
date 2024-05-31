<?= $this->extend('layouts/template_admin'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add new employee data</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/employee">Employee</a></li>
                        <li class="breadcrumb-item active">New Employee</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <small>Please fill out this form to add a new employee</small>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Form
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="/employee/save" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control <?= session('errors') && isset(session('errors')['name']) ? 'is-invalid' : ''; ?>" id="name" name="name" autofocus value="<?= old('name'); ?>">
                                        <?php if (session('errors') && isset(session('errors')['name'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['name']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="wa" class="col-sm-2 col-form-label">Whatsapp</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control <?= session('errors') && isset(session('errors')['wa']) ? 'is-invalid' : ''; ?>" id="wa" name="wa" value="<?= old('wa'); ?>">
                                        <?php if (session('errors') && isset(session('errors')['wa'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['wa']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control <?= session('errors') && isset(session('errors')['address']) ? 'is-invalid' : ''; ?>" id="address" name="address" value="<?= old('address'); ?>">
                                        <?php if (session('errors') && isset(session('errors')['address'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['address']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="photo" class="col-sm-2 col-form-label">Photo</label>
                                    <div class="col-sm-2">
                                        <img src="/photo/default-photo.jpg" class="img-thumbnail img-preview">
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input <?= session('errors') && isset(session('errors')['photo']) ? 'is-invalid' : ''; ?>" id="photo" name="photo" onchange="previewImg()">
                                            <label class="custom-file-label" for="photo">Choose file</label>
                                            <?php if (session('errors') && isset(session('errors')['photo'])) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors')['photo'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?= $this->endSection(); ?>
<?= $this->extend('layouts/template_admin'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create A Package Laundry</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/package">Package</a></li>
                        <li class="breadcrumb-item active">New Package</li>
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
                    <small>Please fill out this form to add a new package</small>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Form
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="/package/save" method="post">
                                <?= csrf_field(); ?>

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Package Name</label>
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
                                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea id="description" name="description" class="form-control <?= session('errors') && isset(session('errors')['description']) ? 'is-invalid' : ''; ?>">
                                        <?= old('description'); ?>
                                        </textarea>
                                        <?php if (session('errors') && isset(session('errors')['description'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['description']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="price" class="col-sm-2 col-form-label">Price (/Kg)</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control <?= session('errors') && isset(session('errors')['price']) ? 'is-invalid' : ''; ?>" id="price" name="price" value="<?= old('price'); ?>">
                                        <?php if (session('errors') && isset(session('errors')['price'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['price']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="duration" class="col-sm-2 col-form-label">Duration (Day)</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control <?= session('errors') && isset(session('errors')['duration']) ? 'is-invalid' : ''; ?>" id="duration" name="duration" value="<?= old('duration'); ?>">
                                        <?php if (session('errors') && isset(session('errors')['duration'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['duration']) ?>
                                            </div>
                                        <?php endif; ?>
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
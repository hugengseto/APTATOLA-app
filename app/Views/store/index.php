<?= $this->extend('layouts/template_admin'); ?>

<?= $this->section('content'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Store</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Store</li>
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

                    <div class="swal" data-swalIcon="<?= session()->getFlashdata('icon'); ?>" data-swalTitle="<?= session()->getFlashdata('titleMessage'); ?>" data-swalMessage="<?= session()->getFlashdata('message'); ?>"></div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Store Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">Name</td>
                                    <td>:</td>
                                    <td><?= $store['store_name']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Address</td>
                                    <td>:</td>
                                    <td><?= $store['store_address']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Phone</td>
                                    <td>:</td>
                                    <td><?= $store['store_telp']; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Email</td>
                                    <td>:</td>
                                    <td><?= $store['store_email']; ?></td>
                                </tr>
                            </table>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning btn-sm my-3" data-toggle="modal" data-target="#profileModal">
                                Change Information <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<form action="/store/update" method="post">
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Store Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- form -->
                    <div class="form-group row">
                        <label for="store_name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="store_name" name="store_name" value="<?= $store['store_name'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="store_address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="store_address" name="store_address" value="<?= $store['store_address'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="store_telp" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="store_telp" name="store_telp" value="<?= $store['store_telp'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="store_email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="store_email" name="store_email" value="<?= $store['store_email'] ?>">
                        </div>
                    </div>
                    <!-- end form -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning btn-sm">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>



<?= $this->endSection(); ?>
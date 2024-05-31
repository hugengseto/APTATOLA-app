<?= $this->extend('layouts/template_admin'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Package Laundry</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Package</li>
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

                    <div class="swal" data-swalTitle="<?= session()->getFlashdata('titleMessage'); ?>" data-swalMessage="<?= session()->getFlashdata('message'); ?>"></div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Laundry package list
                            </h3>
                        </div>
                        <div class="card-body">
                            <a href="/package/create" class="btn btn-primary my-2"><i class="fas fa-plus-square"></i> New Package</a>
                            <table id="package" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Duration (Day)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($packages as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['package_name']; ?></td>
                                            <td><?= $row['description']; ?></td>
                                            <td><?= number_format($row['price'], 0, ',', '.'); ?></td>
                                            <td><?= $row['duration']; ?></td>
                                            <td>
                                                <a href="/package/edit/<?= $row['id']; ?>" class="btn btn-warning btn-sm my-1">
                                                    <i class="fas fa-edit"></i> Edit</a>
                                                <form id="deleteForm<?= $row['id']; ?>" action="/package/<?= $row['id']; ?>" method="post" class="d-inline">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="<?= $row['id']; ?>"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?= $this->endSection(); ?>
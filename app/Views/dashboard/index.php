<?= $this->extend('layouts/template_admin'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="swal" data-swalTitle="<?= session()->getFlashdata('titleMessage'); ?>" data-swalMessage="<?= session()->getFlashdata('message'); ?>"></div>

            <!-- Small boxes (Stat box) -->
            <div class="card">
                <h5 class="m-3">Welcome, <b><?= session()->get('fullname'); ?></h5>
                <p class="m-3 font-weight-normal">Have a great day 😊, so far your recorded income has reached <b>Rp. <?= number_format($pendapatan, 2, ',', '.'); ?></b><br>from the first transaction on <b><?= $firstTransaction; ?></b></p>
            </div>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $allTransactions; ?></h3>

                            <p>Transaction</p>
                            <table>
                                <tr>
                                    <td>Completed</td>
                                    <td>:</td>
                                    <td><?= $completedTransactions; ?></td>
                                </tr>
                                <tr>
                                    <td>In Progress</td>
                                    <td>:</td>
                                    <td><?= $progressTransactions; ?></td>
                                </tr>
                                <tr>
                                    <td>In Queque</td>
                                    <td>:</td>
                                    <td><?= $queueTransactions; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-cart"></i>
                        </div>
                        <a href="/transaction" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $allEmployee; ?></h3>

                            <p>Employee</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="/employee" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $allPackage; ?></h3>

                            <p>Package</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-magic"></i>
                        </div>
                        <a href="/package" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $notYetPaid; ?></h3>

                            <p>Not Yet Paid</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <a href="/transaction/payment" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?= $this->endSection(); ?>
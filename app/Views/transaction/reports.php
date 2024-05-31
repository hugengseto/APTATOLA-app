<?php

use CodeIgniter\I18n\Time;
use App\Helpers\DateHelper;

?>
<?= $this->extend('layouts/template_admin'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reports</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/transaction">Transaction</a></li>
                        <li class="breadcrumb-item active">Transaction Reports</li>
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


                    <form action="/pdf/reportPdf" method="post" class="my-2" id="cetak">
                        <p class="font-weight-bold">Enter transaction date range</p>
                        <div class="row">
                            <div class="col-5">
                                <input type="date" class="form-control" placeholder="Start date" id="startDate" name="startDate">
                            </div>
                            <div class="col-2 text-center">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            <div class="col-5">
                                <input type="date" class="form-control" placeholder="End date" id="endDate" name="endDate">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-danger btn-sm my-2">PDF <i class="fas fa-file"></i></button>
                            </div>
                        </div>
                    </form>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Customer transaction list report
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="transaction-list-reports" class="table table-bordered table-hover table-responsive" style="zoom: 80%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Transaction Code</th>
                                            <th>Name</th>
                                            <th>Whatsapp</th>
                                            <th>Package</th>
                                            <th>Wight (Kg)</th>
                                            <th>Total Payment (Rupiah)</th>
                                            <th>Waktu Masuk</th>
                                            <th>Pengambilan</th>
                                            <th>Status</th>
                                            <th>Kasir</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">Date Range</td>
                                    <td>:</td>
                                    <td id="dateRange">All transactions</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Total of all completed payments</td>
                                    <td>:</td>
                                    <td id="totalPayment">xxx</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?= $this->endSection(); ?>
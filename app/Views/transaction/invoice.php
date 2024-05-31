<?php

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
                    <h1 class="m-0">Invoice</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/transaction">Transaction</a></li>
                        <li class="breadcrumb-item active">Invoice</li>
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
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <img class="border rounded-circle" src="/assets/dist/img/aptatola.png" alt="AdminLTELogo" height="80" width="80"> <?= $toko; ?>
                                    <small class="float-right">Transaksi: <?= DateHelper::formatDate($customer['created_at']); ?></small>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-3 invoice-col">
                                Detail Toko
                                <address>
                                    <strong><?= $toko; ?></strong><br>
                                    <?= $store['store_address']; ?><br>
                                    No HP: <?= $store['store_telp']; ?><br>
                                    Email: <?= $store['store_email']; ?>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 invoice-col">
                                Detail Pelanggan
                                <address>
                                    <strong><?= $customer['customer_name']; ?></strong><br>
                                    No HP: <?= $customer['customer_whatsapp']; ?><br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-5 invoice-col">
                                <b>Invoice</b><br>
                                <br>
                                <b>Kode Transaksi:</b> <?= $customer['transaction_code']; ?><br>
                                <b>Estimasi Pengambilan:</b> <?= DateHelper::formatDate($pengambilan); ?><br>
                                <b>Waktu Pembayaran & Pengambilan:</b> <?= DateHelper::formatDate($customer['pay_time']); ?><br>
                                <b>Status:</b> <?= $customer['payment_status']; ?><br>
                                <b>Kasir:</b> <?= $customer['employee_name']; ?><br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Jumlah (kg)</th>
                                            <th>Paket</th>
                                            <th>Hari</th>
                                            <th>Harga(/kg)</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= $customer['weight']; ?></td>
                                            <td><?= $customer['package_name']; ?></td>
                                            <td><?= $customer['duration']; ?></td>
                                            <td><?= number_format($customer['price'], 0, ',', '.'); ?></td>
                                            <td><?= number_format($customer['total_payment'], 0, ',', '.'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-sm-6 mb-3">
                                <p class="lead">Metode Pembayaran:</p>
                                <?php
                                if ($customer['payment_method'] == 'Tunai') { ?>
                                    <img src="/tunai.png" alt="Tunai" width="180">
                                <?php } else { ?>
                                    <img src="/qris.png" alt="Qris" width="180">
                                <?php } ?>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Total:</th>
                                            <td><?= number_format($customer['total_payment'], 0, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Bayar:</th>
                                            <td><?= number_format($customer['money_paid'], 0, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kembali:</th>
                                            <td><?= number_format($customer['refund'], 0, ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="/transaction/invoicePrint/<?= $customer['transaction_code']; ?>" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                <form action="/transaction/sendInvoice/<?= $customer['transaction_code']; ?>" method="post">
                                    <button type="submit" class="btn btn-success float-right"><i class="far fa-address-book"></i> Send Whatsapp
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


<?= $this->endSection(); ?>
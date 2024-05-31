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
                    <h1 class="m-0">Detail</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/transaction">Transaction</a></li>
                        <li class="breadcrumb-item active">Detail</li>
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
                                    <small class="float-right"><b><?= $customer['transaction_code']; ?></b></small>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                Detail Kasir
                                <address>
                                    <strong>
                                        <?php
                                        if (isset($customer['employee_name']) && $customer['employee_name'] !== 0) {
                                            echo $customer['employee_name'];
                                        } else {
                                            echo "xxx";
                                        }
                                        ?>
                                    </strong><br>
                                    No HP:
                                    <?php if (isset($customer['employee_whatsapp']) && $customer['employee_whatsapp'] !== 0) {
                                        echo $customer['employee_whatsapp'];
                                    } else {
                                        echo "xxx";
                                    }
                                    ?><br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                Detail Pelanggan
                                <address>
                                    <strong><?= $customer['customer_name']; ?></strong><br>
                                    No HP: <?= $customer['customer_whatsapp']; ?><br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                Detail Pembayaran
                                <table>
                                    <tr>
                                        <td>Waktu Pembayaran</td>
                                        <td>:
                                            <?php if (isset($customer['pay_time']) && $customer['pay_time'] !== 0) {
                                                $payTime = DateHelper::formatDate($customer['pay_time']);
                                                echo $payTime;
                                            } else {
                                                echo "xxx";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Metode Pembayaran</td>
                                        <td>:
                                            <?php if (isset($customer['payment_method']) && $customer['payment_method'] !== 0) {
                                                if ($customer['payment_method'] == 'Tunai') { ?>
                                                    <img src="/tunai.png" alt="Tunai" width="55">
                                                <?php } else { ?>
                                                    <img src="/qris.png" alt="Qris" width="55">
                                                <?php } ?>
                                            <?php } else {
                                                echo "xxx";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status Pembayaran</td>
                                        <td>:
                                            <span class="font-weight-bold">
                                                <?php if (isset($customer['payment_status']) && $customer['payment_status'] !== 0) {
                                                    echo $customer['payment_status'];
                                                } else {
                                                    echo "xxx";
                                                }
                                                ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <h6>Detail Transaksi</h6>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Waktu Masuk</th>
                                            <th>Waktu Pengambilan</th>
                                            <th>Jumlah (kg)</th>
                                            <th>Paket</th>
                                            <th>Hari</th>
                                            <th>Harga(/kg)</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= DateHelper::formatDate($customer['created_at']); ?></td>
                                            <td>
                                                <?php if (isset($pengambilan) && $pengambilan !== 0) {
                                                    $ambil = DateHelper::formatDate($pengambilan);
                                                    echo $ambil;
                                                } else {
                                                    echo "xxx";
                                                }
                                                ?>
                                            </td>
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
                                            <td>
                                                <?php
                                                if (isset($customer['money_paid']) && $customer['money_paid'] !== 0) {
                                                    $bayar = number_format($customer['money_paid'], 0, ',', '.');
                                                    echo $bayar;
                                                } else {
                                                    echo "xxx";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Kembali:</th>
                                            <td>
                                                <?php
                                                // Periksa apakah kunci 'refund' ada dalam array $customer dan nilainya tidak kosong
                                                if (isset($customer['refund']) && $customer['refund'] !== 0) {
                                                    // Jika 'refund' ada dan nilainya bukan 0, format dan tampilkan nilai refund
                                                    $kembali = number_format($customer['refund'], 0, ',', '.');
                                                    echo $kembali;
                                                } else {
                                                    // Jika 'refund' tidak ada atau nilainya 0, tampilkan pesan 'xxx'
                                                    echo "xxx";
                                                }
                                                ?>
                                            </td>
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
                                <form action="/transaction/sendInvoiceFirst/<?= $customer['transaction_code']; ?>" method="post">
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
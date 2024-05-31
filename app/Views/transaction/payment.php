<?= $this->extend('layouts/template_admin'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Payment</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Payment</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="/transaction/paymentAction" method="post" id="paymentForm">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-4">
                        <p>Looking for customers who will make payments</p>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <select class="form-control searchCustomer select2bs4 <?= session('errors') && isset(session('errors')['transaction_code']) ? 'is-invalid' : ''; ?>" name="transaction_code" id="transaction_code">
                                    <option value="">Search code transaction/customer name/whatsapp</option>
                                    <?php foreach ($customers as $row) : ?>
                                        <option value="<?= $row['transaction_code']; ?>" <?= old('transaction_code') == $row['transaction_code'] ? 'selected' : ''; ?>>
                                            <?= $row['transaction_code']; ?> #<?= $row['customer_name']; ?> - <?= $row['customer_whatsapp']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session('errors') && isset(session('errors')['transaction_code'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors')['transaction_code']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-8">
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <img class="border rounded-circle" src="/assets/dist/img/aptatola.png" alt="AdminLTELogo" height="80" width="80"> <?= $toko; ?>
                                        <small class="float-right">Transaksi: <span id="dibuat">xxx</span></small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    Detail Toko
                                    <address>
                                        <strong><?= $toko; ?></strong><br>
                                        <?= $store['store_address']; ?><br>
                                        No HP: <?= $store['store_telp']; ?><br>
                                        Email: <?= $store['store_email']; ?>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    Detail Pelanggan
                                    <address>
                                        <strong id="customer_name" data-refund="<?= old('kembalian'); ?>">xxx</strong><br>
                                        No HP: <span id="customer_whatsapp">xxx</span><br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice</b><br>
                                    <br>
                                    <b>Kode Transaksi:</b> <span id="kode_transaksi">xxx</span><br>
                                    <b>Pengambilan:</b> <span id="pengambilan">xxx</span><br>
                                    <b>Status:</b> <span id="status">xxx</span><br>
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
                                                <td id="jumlah">xxx</td>
                                                <td id="paket">xxx</td>
                                                <td id="hari">xxx</td>
                                                <td id="harga">xxx</td>
                                                <td class="total">xxx</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->


                            <div class="row">
                                <!-- accepted payments column -->

                                <div class="col-sm-6">
                                    <p class="lead">Metode Pembayaran:</p>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="radioPrimary1" name="metodePembayaran" value="Tunai" <?= old('metodePembayaran') == 'Tunai' ? 'checked' : ''; ?> class="pembayaran">
                                            <label for="radioPrimary1">
                                                <img src="/tunai.png" alt="Tunai" width="120">
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="radioPrimary2" name="metodePembayaran" value="Qris" <?= old('metodePembayaran') == 'Qris' ? 'checked' : ''; ?> class="pembayaran">
                                            <label for="radioPrimary2">
                                                <img src="/qris.png" alt="Qris" width="120">
                                            </label>
                                        </div>
                                    </div>
                                    <div id="radioError">Silakan pilih metode pembayaran</div>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th>Total:</th>
                                                <td>
                                                    <input type="text" class="form-control" id="totalBayar" name="totalBayar" value="<?= old('totalBayar'); ?>" data-total="<?= old('totalBayar'); ?>" readonly>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Bayar:</th>
                                                <td>
                                                    <input type="text" class="form-control <?= session('errors') && isset(session('errors')['bayar']) ? 'is-invalid' : ''; ?>" id="bayar" name="bayar" value="<?= old('bayar'); ?>">
                                                    <?php if (session('errors') && isset(session('errors')['bayar'])) : ?>
                                                        <div class="invalid-feedback">
                                                            <?= esc(session('errors')['bayar']); ?>
                                                        </div>
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Kembali:</th>
                                                <td>
                                                    <input type="text" class="form-control" id="kembalian" name="kembalian" value="<?= old('kembalian'); ?>" data-refund="<?= old('kembalian'); ?>" readonly>
                                                    <div class="invalid-feedback">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Kasir</th>
                                                <td>
                                                    <select class="form-control <?= session('errors') && isset(session('errors')['employee']) ? 'is-invalid' : ''; ?>" name="employee">
                                                        <option value=""> -- Select --
                                                        </option>
                                                        <?php foreach ($employees as $row) : ?>
                                                            <option value="<?= $row['id']; ?>" <?= old('employee') == $row['id'] ? 'selected' : ''; ?>>
                                                                <?= $row['name']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <?php if (session('errors') && isset(session('errors')['employee'])) : ?>
                                                        <div class="invalid-feedback">
                                                            <?= esc(session('errors')['employee']); ?>
                                                        </div>
                                                    <?php endif ?>
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
                                    <button type="submit" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                                        Payment
                                    </button>
                                </div>
                            </div>
            </form>

        </div>
        <!-- /.invoice -->
        <div class="form-group row">
            </form>
        </div>
</div>
</section>
</div>


<?= $this->endSection(); ?>
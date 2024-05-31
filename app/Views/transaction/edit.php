<?= $this->extend('layouts/template_admin'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Transaction</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/transaction">Transaction</a></li>
                        <li class="breadcrumb-item active">Edit Transaction</li>
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
                <div class="col-sm-12">
                    <small>Please fill out this form to modify atransaction</small>
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                Form
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="/transaction/update/<?= $customer['id']; ?>" method="post">
                                <?= csrf_field(); ?>

                                <input type="text" value="<?= $customer['created_at'] ?>" name="created_at" hidden>
                                <input type="text" value="<?= $customer['updated_at'] ?>" name="updated_at" hidden>

                                <div class="form-group row">
                                    <label for="transaction_code" class="col-sm-2 col-form-label">Transaction Code</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control <?= session('errors') && isset(session('errors')['transaction_code']) ? 'is-invalid' : ''; ?>" id="transaction_code" name="transaction_code" value="<?= $customer['transaction_code']; ?>" readonly>
                                        <?php if (session('errors') && isset(session('errors')['transaction_code'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['transaction_code']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="customer_name" class="col-sm-2 col-form-label">Customer Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control <?= session('errors') && isset(session('errors')['customer_name']) ? 'is-invalid' : ''; ?>" id="customer_name" name="customer_name" autofocus value="<?= old('customer_name', $customer['customer_name']); ?>">
                                        <?php if (session('errors') && isset(session('errors')['customer_name'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['customer_name']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="customer_whatsapp" class="col-sm-2 col-form-label">Customer Whatsapp</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control <?= session('errors') && isset(session('errors')['customer_whatsapp']) ? 'is-invalid' : ''; ?>" id="customer_whatsapp" name="customer_whatsapp" value="<?= old('customer_whatsapp', $customer['customer_whatsapp']); ?>">
                                        <?php if (session('errors') && isset(session('errors')['customer_whatsapp'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['customer_whatsapp']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="package" class="col-sm-2 col-form-label">Laundry Package</label>
                                    <div class="col-sm-10">
                                        <select class="form-control laundry-package select2bs4 <?= session('errors') && isset(session('errors')['package']) ? 'is-invalid' : ''; ?>" name="package">
                                            <?php foreach ($optionPackage as $row) : ?>
                                                <option value="<?= $row['id']; ?>" data-price="<?= $row['price']; ?>" <?= old('package', $customer['package']) == $row['id'] ? 'selected' : ''; ?>>
                                                    <?= $row['package_name']; ?> - (Rp. <?= number_format($row['price'], 0, ',', '.'); ?> /kg)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" id="price" value="">

                                        <?php if (session('errors') && isset(session('errors')['package'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['package']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="weight" class="col-sm-2 col-form-label">Weight (Kg)</label>
                                    <div class="col-sm-10">
                                        <input type="number" step='0.01' class="form-control <?= session('errors') && isset(session('errors')['weight']) ? 'is-invalid' : ''; ?>" id="weight" name="weight" value="<?= old('weight', $customer['weight']); ?>">
                                        <?php if (session('errors') && isset(session('errors')['weight'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['weight']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="total_payment" class="col-sm-2 col-form-label">Total Payment</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control <?= session('errors') && isset(session('errors')['total_payment']) ? 'is-invalid' : ''; ?>" id="total_payment" name="total_payment" value="<?= old('total_payment', $customer['total_payment']); ?>" readonly>
                                        <?php if (session('errors') && isset(session('errors')['total_payment'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['total_payment']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Change</button>
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
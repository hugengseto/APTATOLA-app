<?= $this->extend('layouts/template_admin'); ?>

<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">New Transaction</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/transaction">Transaction</a></li>
                        <li class="breadcrumb-item active">New Transaction</li>
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
                <div class="col-sm-4">
                    <p>Not the customer's first transaction</p>
                    <form action="/transaction/repeatTransaction" method="post">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <select class="form-control searchCustomer select2bs4 <?= session('errors') && isset(session('errors')['repeat_costumer_name']) ? 'is-invalid' : ''; ?>" name="repeat_costumer_name">
                                    <option value="">Search customer name/whatsapp</option>
                                    <?php foreach ($customers as $row) : ?>
                                        <option value="<?= $row['customer_name']; ?>" <?= old('customer_name') == $row['customer_name'] ? 'selected' : ''; ?>>
                                            <?= $row['customer_name']; ?> - <?= $row['customer_whatsapp']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session('errors') && isset(session('errors')['repeat_costumer_name'])) : ?>
                                    <div class="invalid-feedback">
                                        <?= esc(session('errors')['repeat_costumer_name']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-12 my-2">
                                <button type="submit" class="btn btn-success">Transaction Again</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-8">
                    <small>Please fill out this form to add a new transaction</small>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Form
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="/transaction/save" method="post">
                                <?= csrf_field(); ?>

                                <div class="form-group row">
                                    <label for="transaction_code" class="col-sm-2 col-form-label">Transaction Code</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control <?= session('errors') && isset(session('errors')['transaction_code']) ? 'is-invalid' : ''; ?>" id="transaction_code" name="transaction_code" value="<?= $transaction_code; ?>" readonly>
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
                                        <input type="text" class="form-control <?= session('errors') && isset(session('errors')['customer_name']) ? 'is-invalid' : ''; ?>" id="customer_name" name="customer_name" autofocus value="<?= old('customer_name'); ?>">
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
                                        <input type="number" class="form-control <?= session('errors') && isset(session('errors')['customer_whatsapp']) ? 'is-invalid' : ''; ?>" id="customer_whatsapp" name="customer_whatsapp" autofocus value="<?= old('customer_whatsapp'); ?>">
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
                                                <option value="<?= $row['id']; ?>" data-price="<?= $row['price']; ?>" <?= old('package') == $row['id'] ? 'selected' : ''; ?>>
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
                                        <input type="number" step='0.01' class="form-control <?= session('errors') && isset(session('errors')['weight']) ? 'is-invalid' : ''; ?>" id="weight" name="weight" value="<?= old('weight'); ?>">
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
                                        <input type="number" class="form-control <?= session('errors') && isset(session('errors')['total_payment']) ? 'is-invalid' : ''; ?>" id="total_payment" name="total_payment" value="<?= old('total_payment'); ?>" readonly>
                                        <?php if (session('errors') && isset(session('errors')['total_payment'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= esc(session('errors')['total_payment']) ?>
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
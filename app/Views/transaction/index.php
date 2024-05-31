<?php

use CodeIgniter\I18n\Time;

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
                    <h1 class="m-0">Transaction List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Transaction</a></li>
                        <li class="breadcrumb-item active">Transaction List</li>
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
                                Customer transaction list
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="transaction-list" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Transaction Code</th>
                                        <th>Name</th>
                                        <th>Whatsapp</th>
                                        <th>Package</th>
                                        <th>Wight (Kg)</th>
                                        <th>Total Payment (Rupiah)</th>
                                        <th>Pengambilan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($transactions as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['transaction_code']; ?></td>
                                            <td><?= $row['customer_name']; ?></td>
                                            <td><?= $row['customer_whatsapp']; ?></td>
                                            <td><?= $row['package_name']; ?></td>
                                            <td><?= $row['weight']; ?></td>
                                            <td><?= number_format($row['total_payment'], 0, ',', '.'); ?></td>
                                            <?php
                                            //tanggal transaksi dibuat
                                            $dibuat = Time::createFromFormat('Y-m-d H:i:s', $row['created_at']);
                                            //dari tanggal transaksi dibuat, maka jadwal pengambilan laundry sesuai package yang dipilih oleh customer
                                            $pengambilan = $dibuat->addDays($row['duration']);

                                            //ambil waktu sekarang dan perbedaan waktunya
                                            $sekarang = Time::now();
                                            $perbedaan = $pengambilan->getTimestamp() - $sekarang->getTimestamp();
                                            ?>
                                            <td>
                                                <?php
                                                if ($perbedaan >= 86400) {  // Lebih dari atau sama dengan satu hari (1 hari = 86400 detik)
                                                    echo $pengambilan->format('d-m-Y H:i:s');
                                                } elseif ($perbedaan < 86400 && $perbedaan > 0) { // Kurang dari satu hari tapi lebih dari 0 detik
                                                    echo '<span class="text-warning">' . $pengambilan->format('d-m-Y H:i:s') . '</span>';
                                                } else {
                                                    echo '<span class="text-danger">' . $pengambilan->format('d-m-Y H:i:s') . '</span>';
                                                }
                                                ?>
                                            <td>
                                                <?php if ($row['status'] == 'Completed') { ?>
                                                    <span class="badge badge-success status-complete"><?= $row['status']; ?></span>
                                                    <a href="/transaction/invoice/<?= $row['transaction_code']; ?>" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-file"></i> Invoice
                                                    </a>
                                                <?php } else if ($row['status'] == 'In Progress') { ?>
                                                    <span class="badge badge-warning status" data-toggle="modal" data-target="#statusModal<?= $row['id']; ?>"><?= $row['status']; ?></span>
                                                <?php } else { ?>
                                                    <span class="badge badge-secondary status" data-toggle="modal" data-target="#statusModal<?= $row['id']; ?>"><?= $row['status']; ?></span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="/transaction/detail/<?= $row['transaction_code']; ?>" class="btn btn-info btn-sm ">
                                                    <i class="fas fa-edit"></i> Detail</a>
                                                <a href="/transaction/edit/<?= $row['id']; ?>" class="btn btn-warning btn-sm my-1">
                                                    <i class="fas fa-edit"></i> Edit</a>
                                                <form id="deleteForm<?= $row['id']; ?>" action="/transaction/<?= $row['id']; ?>" method="post" class="d-inline">
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

<!-- Modal -->
<?php foreach ($transactions as $row) : ?>
    <div class="modal fade" id="statusModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Change Transaction Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <small>Transaction Code : <?= $row['transaction_code']; ?></small>
                    <h6 class="text-center"><i class="fas fa-user"></i></br><?= $row['customer_name']; ?></h6>
                    <h6 class="text-center"><i class="fas fa-phone-square"></i></br><?= $row['customer_whatsapp']; ?></h6>
                    <form action="/transaction/updateStatus/<?= $row['id']; ?>" method="post">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="In Progress" <?= ($row['status'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                                <option value="In Queue" <?= ($row['status'] == 'In Queue') ? 'selected' : ''; ?>>In Queue</option>
                            </select>
                        </div>
                        <small class="text-danger">The “completed” status can only be set when the payment has been completed. <a href="/transaction/payment">Payment</a></small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>

            </div>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->endSection(); ?>
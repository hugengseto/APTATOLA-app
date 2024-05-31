<?php

use CodeIgniter\I18n\Time;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        table,
        td,
        th {
            border: 1px solid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <section class="content">
        <div class="container-fluid">
            <div class="card mt-5">
                <div class="card-header">
                    <h3 class="card-title">
                        Customer transaction list report
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table>
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
                                <?php
                                $no = 1;
                                foreach ($transactions as $row) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['transaction_code'] ?></td>
                                        <td><?= $row['customer_name'] ?></td>
                                        <td><?= $row['customer_whatsapp'] ?></td>
                                        <td><?= $row['package_name'] ?></td>
                                        <td><?= $row['weight'] ?></td>
                                        <td><?= $row['total_payment'] ?></td>
                                        <td><?= $row['created_at'] ?></td>
                                        <td><?= $row['pengambilan'] ?></td>
                                        <td><?= $row['status'] ?></td>
                                        <td>
                                            <?php
                                            if (is_null($row['employee_name'])) {
                                                echo " ---";
                                            } else {
                                                echo $row['employee_name'];
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <p>Date Range :
                        <?php if (empty($startDate) || empty($endDate)) {
                            echo "All transactions";
                        } else {
                            echo $startDate . " to " . $endDate;
                        } ?>
                    </p>
                    <p>Total of all complated payments : Rp. <?= number_format($total_payment_compeletd, 0, ',', '.'); ?></p>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'transaction_code',
        'customer_name',
        'customer_whatsapp',
        'package',
        'weight',
        'total_payment',
        'status',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllTransaction()
    {
        $builder = $this->db->table('transaction')
            ->select('transaction.*, package.package_name, package.price, package.duration, package.id as id_package')
            ->join('package', 'package.id = transaction.package')
            ->orderBy('transaction.created_at', 'DESC')
            ->get();

        return $builder->getResultArray();
    }


    //menampilkan semua data transaksi beserta kasir yang bertanggung jawab pada transaction yang berstatus payment
    public function getAllTransactionWithEmployee()
    {
        $builder = $this->db->table('transaction')
            ->select('transaction.*, package.package_name, package.price, package.duration, package.id as id_package, payment.employee_id, employee.name as employee_name')
            ->join('package', 'package.id = transaction.package')
            ->join('payment', 'payment.transaction_code = transaction.transaction_code', 'left')
            ->join('employee', 'employee.id = payment.employee_id', 'left')
            ->orderBy('transaction.created_at', 'DESC')
            ->get();

        return $builder->getResultArray();
    }

    //mengambil data transaksi dengan range tanggal
    public function getAllTransactionWithEmployeeByDate($startDate, $endDate)
    {
        $builder = $this->db->table('transaction')
            ->select('transaction.*, package.package_name, package.price, package.duration, package.id as id_package, payment.employee_id, employee.name as employee_name')
            ->join('package', 'package.id = transaction.package')
            ->join('payment', 'payment.transaction_code = transaction.transaction_code', 'left')
            ->join('employee', 'employee.id = payment.employee_id', 'left')
            ->where('transaction.created_at >=', $startDate)
            ->where('transaction.created_at <=', $endDate)
            ->orderBy('transaction.created_at', 'DESC')
            ->get();

        return $builder->getResultArray();
    }

    public function getTransactionById(int $id)
    {
        $builder = $this->db->table('transaction')
            ->select('transaction.*, package.package_name, package.price, package.duration, package.id as id_package')
            ->join('package', 'package.id = transaction.package')
            ->where('transaction.id', $id)
            ->get();

        return $builder->getRowArray();
    }

    public function getTransactionByTransactionCode(string $transactionCode)
    {
        $builder = $this->db->table('transaction')
            ->select('transaction.*, package.package_name, package.price, package.duration, package.id as id_package, payment.employee_id, employee.name as employee_name, payment.payment_status, payment.payment_method, payment.money_paid, payment.refund, payment.updated_at as pay_time')
            ->join('package', 'package.id = transaction.package')
            ->join('payment', 'payment.transaction_code = transaction.transaction_code', 'left')
            ->join('employee', 'employee.id = payment.employee_id', 'left')
            ->where('transaction.transaction_code', $transactionCode)
            ->get();

        return $builder->getRowArray();
    }

    //  query untuk mendaptkan data pembayaran yang belum pernah dilakukan, ambil semuad data yang mana kolom transaction_code pada tabel transaction harus tidak ada di tabel payment
    public function getAllCustomerNotSameTransactionCode()
    {
        $builder = $this->db->table('transaction')
            ->select('transaction.transaction_code, transaction.customer_name, transaction.customer_whatsapp, transaction.status')
            ->where('transaction.transaction_code NOT IN (SELECT transaction_code FROM payment)');

        return $builder->get()->getResultArray();
    }
}

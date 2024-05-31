<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payment';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'transaction_code',
        'employee_id',
        'payment_status',
        'payment_method',
        'money_paid',
        'refund',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getPaymentById(string $transaction_code)
    {
        $builder = $this->db->table('payment')
            ->select('payment.id as id_payment, payment.payment_status, payment.payment_method, payment.money_paid, payment.refund, payment.updated_at as pay_time,transaction.id as id_transaction, transaction.transaction_code, transaction.customer_name, transaction.customer_whatsapp,transaction.total_payment, transaction.weight, transaction.created_at, package.id as id_package, package.package_name, package.duration, package.price, employee.id as id_employee, employee.name as employee_name, employee.whatsapp as employee_whatsapp')
            ->join('employee', 'employee.id = payment.employee_id')
            ->join('transaction', 'transaction.transaction_code = payment.transaction_code')
            ->join('package', 'package.id = transaction.package')
            ->where('payment.transaction_code', $transaction_code)
            ->get();

        return $builder->getRowArray();
    }
}

<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\PackageModel;
use App\Models\StoreModel;
use App\Models\TransactionModel;
use CodeIgniter\I18n\Time;

class Dashboard extends BaseController
{
    protected string $toko;

    public function __construct()
    {
        $storeModel = new StoreModel();
        $toko = $storeModel->first();
        $this->toko = $toko['store_name'];
    }

    public function index()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $transactionModel = new TransactionModel();
        $employeeModel = new EmployeeModel();
        $packageModel = new PackageModel();

        $pendapatan = $transactionModel->where(['status' => 'Completed'])->findAll();
        $total_payment = 0;
        foreach ($pendapatan as $row) {
            $total_payment += $row['total_payment'];
        }

        $data = [
            'title' => 'Dashboard | Aptatola',
            'toko'  => $this->toko,
            'allTransactions' => $transactionModel->countAllResults(),
            'completedTransactions' => $transactionModel->where(['status' => 'Completed'])->countAllResults(),
            'progressTransactions' => $transactionModel->where(['status' => 'In Progress'])->countAllResults(),
            'queueTransactions' => $transactionModel->where(['status' => 'In Queue'])->countAllResults(),
            'allEmployee' => $employeeModel->countAllResults(),
            'allPackage' => $packageModel->countAllResults(),
            'notYetPaid' => $transactionModel->where('transaction.transaction_code NOT IN (SELECT transaction_code FROM payment)')->countAllResults(),
            'pendapatan' => $total_payment,
        ];

        $transaksiPertama = $transactionModel->first();
        // Inisialisasi variabel tanggal transaksi pertama
        $ambilTanggalTransaksiPertama = null;

        // Jika ada transaksi pertama
        if ($transaksiPertama) {
            // Ambil tanggal transaksi pertama
            $ambilTanggalTransaksiPertama = Time::createFromFormat('Y-m-d H:i:s', $transaksiPertama['created_at']);
            $ambilTanggalTransaksiPertama->format('d-m-Y H:i:s');
        } else {
            // Jika tidak ada transaksi, lakukan sesuatu, misalnya set tanggal ke tanggal default
            $ambilTanggalTransaksiPertama = 'belum ada teransaksi'; // atau atur ke tanggal lain yang sesuai dengan kebutuhan Anda
        }
        $data['firstTransaction'] = $ambilTanggalTransaksiPertama;


        return view('dashboard/index', $data);
    }
}

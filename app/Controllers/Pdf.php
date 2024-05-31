<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;

class Pdf extends BaseController
{
    protected string $toko = 'Zahra Laundry';
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $startDate   = $this->request->getPost('startDate');
        $endDate    = $this->request->getPost('endDate');

        if ($endDate) {
            $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
        }

        // Ambil semua data jika tanggal tidak disediakan
        $start = null;
        $end = null;
        if (empty($startDate) || empty($endDate)) {
            $results = $this->transactionModel->getAllTransactionWithEmployee();
        } else {
            $results = $this->transactionModel->getAllTransactionWithEmployeeByDate($startDate, $endDate);

            $start = Time::createFromFormat('Y-m-d', $startDate);
            $end = Time::createFromFormat('Y-m-d', $endDate);

            $endDate = $end->addDays(-1);

            $start->format('d-m-Y');
            $endDate->format('d-m-Y');
        }

        // Lakukan loop melalui setiap transaksi
        $total_payment = 0;
        foreach ($results as &$result) {
            //tanggal transaksi dibuat
            $dibuat = Time::createFromFormat('Y-m-d H:i:s', $result['created_at']);
            //dari tanggal transaksi dibuat, maka jadwal pengambilan laundry sesuai package yang dipilih oleh customer
            $pengambilan = $dibuat->addDays($result['duration']);
            //format ulang tanggal
            $result['pengambilan'] = $pengambilan->format('Y-m-d H:i:s');
            if ($result['status'] == 'Completed') {
                $total_payment += $result['total_payment'];
            }
        }

        $data = [
            'title' => 'Transaction Reports | Aptatola',
            'transactions' => $results,
            'total_payment_compeletd' => $total_payment,
            'startDate' => $start,
            'endDate'   => $endDate
        ];

        $fileName = date('d-m-Y-H-i-s') . ' Laporan Transaksi Toko' . '[' . $data['startDate'] . '_' . $data['endDate'] . ']';

        // instantiate and use the dompdf class

        $dompdf = new Dompdf();

        // load html content
        $dompdf->loadHtml(view('pdf/reportPdf', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // render html as PDF
        $dompdf->render();

        // output the generate pdf
        $dompdf->stream($fileName);
    }
}

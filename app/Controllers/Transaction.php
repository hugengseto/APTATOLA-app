<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\PackageModel;
use App\Models\PaymentModel;
use App\Models\StoreModel;
use App\Models\TransactionModel;
use CodeIgniter\I18n\Time;
use Config\Services;

class Transaction extends BaseController
{
    protected string $toko;
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $storeModel = new StoreModel();
        $toko = $storeModel->first();
        $this->toko = $toko['store_name'];
    }

    public function index()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $data = [
            'title' => 'Transaction List | Aptatola',
            'toko'  => $this->toko,
            'transactions' => $this->transactionModel->getAllTransaction()
        ];

        return view('transaction/index', $data);
    }

    private function _generateTransactionCode($length = 8)
    {
        // Karakter yang digunakan untuk kode transaksi
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        // Panjang kode transaksi
        $codeLength = strlen($characters);

        // Inisialisasi variabel untuk menyimpan kode transaksi
        $code = '';

        // Generate kode transaksi secara acak
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, $codeLength - 1)];
        }

        return $code;
    }

    public function create()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $generate_code = $this->_generateTransactionCode(10); // Menghasilkan kode baru

        // Periksa apakah kode sudah ada di database
        while ($this->transactionModel->where('transaction_code', $generate_code)->countAllResults() > 0) {
            // Jika kode sudah ada, generate kode baru lagi
            $generate_code = $this->_generateTransactionCode(10);
        }

        //untuk mengirimkan option paket laundry
        $modelPackage = new PackageModel();
        $optionPackage = $modelPackage->findAll();

        $data = [
            'title' => 'New Transaction | Aptatola',
            'toko'  => $this->toko,
            'transaction_code' => $generate_code,
            'optionPackage' => $optionPackage,
            'customers' => $this->transactionModel->select(['customer_name', 'customer_whatsapp'])->distinct()->findAll()
        ];


        return view('transaction/create', $data);
    }

    private function _rules()
    {
        return [
            'transaction_code' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} has not been generated, try reloading the page'
                ]
            ],
            'customer_name' => [
                'rules' => 'required|max_length[50]',
                'errors' => [
                    'required'  => '{field} is required, cannot be empty',
                    'max_length'    => 'The {field} cannot contain more than 50 characters'
                ]
            ],
            'customer_whatsapp' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => '{field} is required, cannot be empty'
                ]
            ],
            'package' => [
                'rules' => 'required',
                'errors'    => [
                    'required' => 'Please choose a laundry package first'
                ]
            ],
            'weight' => [
                'rules' => 'required|numeric',
                'errors'    => [
                    'required'  => '{field} is required, cannot be empty'
                ]
            ],
            'total_payment' => [
                'rules' => 'required',
                'errors'    => [
                    'required'  => '{field} is required, fill in the weight first, so it fills automatically'
                ]
            ]
        ];
    }

    public function save()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $validation  = Services::validation();
        $validation->setRules($this->_rules());

        // lakukan validasi form, jika terdapat validasi gagal maka redirect
        if (!$validation->run($this->request->getPost())) {
            return redirect()->to(base_url() . 'transaction/create')->withInput()->with('errors', $validation->getErrors());
        }

        $this->transactionModel->save([
            'transaction_code'  => $this->request->getPost('transaction_code'),
            'customer_name'     => $this->request->getPost('customer_name'),
            'customer_whatsapp' => $this->request->getPost('customer_whatsapp'),
            'package'           => $this->request->getPost('package'),
            'weight'            => $this->request->getPost('weight'),
            'total_payment'     => $this->request->getPost('total_payment'),
            'status'            => 'In Queue'
        ]);

        session()->setFlashdata('titleMessage', 'Saved!');
        session()->setFlashdata('message', 'New transaction added successfully');

        return redirect()->to(base_url() . 'transaction');
    }

    //untuk melakukan penambahan transaksi yang diulang (pelanggan sudah pernah bertransaksi)
    public function repeatTransaction()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $validation = Services::validation();
        $validation->setRules([
            'repeat_costumer_name' => [
                'rules' => 'required',
                'errors' => [
                    'required'  => "Please select the customer's name first",
                ]
            ]
        ]);

        if (!$validation->run($this->request->getPost())) {
            return redirect()->to(base_url() . 'transaction/create')->withInput()->with('errors', $validation->getErrors());
        }

        $generate_code = $this->_generateTransactionCode(10); // Menghasilkan kode baru

        // Periksa apakah kode sudah ada di database
        while ($this->transactionModel->where('transaction_code', $generate_code)->countAllResults() > 0) {
            // Jika kode sudah ada, generate kode baru lagi
            $generate_code = $this->_generateTransactionCode(10);
        }

        //untuk mengirimkan option paket laundry
        $modelPackage = new PackageModel();
        $optionPackage = $modelPackage->findAll();

        $data = [
            'title' => 'New Transaction | Aptatola',
            'toko'  => $this->toko,
            'transaction_code' => $generate_code,
            'optionPackage' => $optionPackage,
            'customer' => $this->transactionModel->select(['customer_name', 'customer_whatsapp'])->where('customer_name', $this->request->getPost('repeat_costumer_name'))->find()
        ];

        return view('transaction/repeatTransaction', $data);
    }

    //menghapus data transaction
    public function remove(int $id)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $this->transactionModel->delete($id);

        session()->setFlashdata('titleMessage', 'Deleted!');
        session()->setFlashdata('message', 'Transaction data has been deleted');

        return redirect()->to(base_url() . 'transaction');
    }

    public function edit(int $id)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        //untuk mengirimkan option paket laundry
        $modelPackage = new PackageModel();
        $optionPackage = $modelPackage->findAll();

        $data = [
            'title' => 'New Transaction | Aptatola',
            'toko'  => $this->toko,
            'optionPackage' => $optionPackage,
            'customer' => $this->transactionModel->find($id)
        ];


        return view('transaction/edit', $data);
    }

    public function update(int $id)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $validation  = Services::validation();
        $validation->setRules($this->_rules());

        // lakukan validasi form, jika terdapat validasi gagal maka redirect
        if (!$validation->run($this->request->getPost())) {
            return redirect()->to(base_url() . 'transaction/edit/' . $id)->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'id'                => $id,
            'transaction_code'  => $this->request->getPost('transaction_code'),
            'customer_name'     => $this->request->getPost('customer_name'),
            'customer_whatsapp' => $this->request->getPost('customer_whatsapp'),
            'package'           => $this->request->getPost('package'),
            'weight'            => $this->request->getPost('weight'),
            'total_payment'     => $this->request->getPost('total_payment'),
            'status'            => 'Completed',
            'created_at'        => $this->request->getPost('created_at'),
            'updated_at'        => $this->request->getPost('updated_at'),
        ];

        // ambil data transaksi
        $getTransaction = $this->transactionModel->where(['transaction_code' => $this->request->getPost('transaction_code')])->first();
        // mengembalikan array karena kosong karena kedua array sama
        $cekData = array_diff_assoc($data, $getTransaction);
        if (empty($cekData)) {
            // tidak melakukan update data (jika array kedua array sama)
            session()->setFlashdata('titleMessage', 'Not Changed!');
            session()->setFlashdata('message', "You don't make changes!.");
        } else {
            // jika ada perubahan maka lakukan update dan hapus data pembayaran, agar nanti dapat melakukan pembayaran ulang
            $this->transactionModel->update($id, [
                'transaction_code'  => $this->request->getPost('transaction_code'),
                'customer_name'     => $this->request->getPost('customer_name'),
                'customer_whatsapp' => $this->request->getPost('customer_whatsapp'),
                'package'           => $this->request->getPost('package'),
                'weight'            => $this->request->getPost('weight'),
                'total_payment'     => $this->request->getPost('total_payment'),
                'status'            => 'In Queue'
            ]);

            $modelPayment = new PaymentModel();
            // ambil data pembayaran
            $getPayment = $modelPayment->where(['transaction_code' => $this->request->getPost('transaction_code')])->first();

            // cek apakah ada data pembayaran (tidak sama dengan kosong)
            if (!empty($getPayment)) {
                // hapus data pembayaran
                $modelPayment->delete(['id' => $getPayment['id']]);
            }

            session()->setFlashdata('titleMessage', 'Changed!');
            session()->setFlashdata('message', 'Transaction successfully edited, transaction status is set to In Queue');
        }

        return redirect()->to(base_url() . 'transaction');
    }

    //aksi ketika pelanggan melakukan perubahan status transaksi
    public function updateStatus(int $id)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $this->transactionModel->update($id, [
            'status'    => $this->request->getPost('status')
        ]);

        session()->setFlashdata('titleMessage', 'Changed!');
        session()->setFlashdata('message', 'Transaction status changed successfully');

        return redirect()->to(base_url() . 'transaction');
    }

    //menampilkan halaman invoice
    public function invoice(string $transaction_code)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $modelPayment = new PaymentModel();
        $modelStore = new StoreModel();

        $data = [
            'title' => 'Invoice | Aptatola',
            'toko'  => $this->toko,
            'store' => $modelStore->first(),
            'customer' => $modelPayment->getPaymentById($transaction_code)
        ];

        //tanggal transaksi dibuat
        $dibuat = Time::createFromFormat('Y-m-d H:i:s', $data['customer']['created_at']);
        //dari tanggal transaksi dibuat, maka jadwal pengambilan laundry sesuai package yang dipilih oleh customer
        $pengambilan = $dibuat->addDays($data['customer']['duration']);
        //format ulang tanggal
        $data['pengambilan'] = $pengambilan->format('Y-m-d H:i:s');

        return view('transaction/invoice', $data);
    }

    public function payment()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $modelPackage = new PackageModel();
        $modelEmployee = new EmployeeModel();
        $modelStore = new StoreModel();

        $data = [
            'title' => 'Payment | Aptatola',
            'toko'  => $this->toko,
            'store' => $modelStore->first(),
            'customers' => $this->transactionModel->getAllCustomerNotSameTransactionCode(),
            'optionPackage' => $modelPackage->findAll(),
            'employees' => $modelEmployee->findAll(),
        ];

        return view('transaction/payment', $data);
    }

    public function getCustomerData($transactionCode)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $customerData = $this->transactionModel->getTransactionByTransactionCode($transactionCode);

        //tanggal transaksi dibuat
        $dibuat = Time::createFromFormat('Y-m-d H:i:s', $customerData['created_at']);
        //dari tanggal transaksi dibuat, maka jadwal pengambilan laundry sesuai package yang dipilih oleh customer
        $pengambilan = $dibuat->addDays($customerData['duration']);

        // ambil data pembayaran jika ada
        $modalPayment = new PaymentModel();
        $pembayaran = $modalPayment->where(['transaction_code' => $transactionCode])->find();

        if (empty($pembayaran)) {
            $tagihan = "Belum Lunas";
        } else {
            $tagihan = $pembayaran[0]['payment_status'];
        }

        // membuat response dalam format json
        $response = [
            'transaction_code' => $customerData['transaction_code'],
            'customer_name' => $customerData['customer_name'],
            'customer_whatsapp' => $customerData['customer_whatsapp'],
            'weight' => $customerData['weight'],
            'total_payment' => $customerData['total_payment'],
            'created_at'    => $dibuat->format('d-m-Y H:i'),
            'package_name' => $customerData['package_name'],
            'price' => $customerData['price'],
            'duration' => $customerData['duration'],
            'pengambilan' => $pengambilan->format('d-m-Y H:i'),
            'tagihan'   => $tagihan
        ];

        // kembalikan data response dalam format JSON
        return $this->response->setJSON($response);
    }

    public function paymentAction()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $validation = Services::validation();
        $validation->setRules([
            'transaction_code' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih lebih dahulu!'
                ]
            ],
            'bayar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Masukkan jumlah yang dibayarkan!'
                ]
            ],
            'employee' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih kasir lebih dahulu!'
                ]
            ],
            'totalBayar' => [
                'rules' => 'required'
            ],
            'metodePembayaran' => [
                'rules' => 'required'
            ],
            'kembalian' => [
                'rules' => 'required'
            ]
        ]);

        if (!$validation->run($this->request->getPost())) {
            return redirect()->to(base_url() . 'transaction/payment')->withInput()->with('errors', $validation->getErrors());
        }


        $modelPayment = new PaymentModel();
        //ambil data pembayaran
        $checkPayment = $modelPayment->where(['transaction_code' => $this->request->getPost('transaction_code')])->countAllResults();
        //ambil id dengan kode transaction dari yang disubmit
        $getIdPembayaran =  $modelPayment->where(['transaction_code' => $this->request->getPost('transaction_code')])->find();

        //cek bila datanya sudah ada maka cukup update saja
        if ($checkPayment > 0) {
            $modelPayment->update($getIdPembayaran[0]['id'], [
                'transaction_code'  => $this->request->getPost('transaction_code'),
                'employee_id'       => $this->request->getPost('employee'),
                'payment_status'    => 'Lunas',
                'payment_method'    => $this->request->getPost('metodePembayaran'),
                'money_paid'        => $this->request->getPost('bayar'),
                'refund'            => $this->request->getPost('kembalian')
            ]);
        } else {
            // bila belum ada maka tambahkan pembayaran
            $modelPayment->save([
                'transaction_code'  => $this->request->getPost('transaction_code'),
                'employee_id'       => $this->request->getPost('employee'),
                'payment_status'    => 'Lunas',
                'payment_method'    => $this->request->getPost('metodePembayaran'),
                'money_paid'            => $this->request->getPost('bayar'),
                'refund'            => $this->request->getPost('kembalian')
            ]);
        }

        //ambil id transaksi untuk digunakan update status laundry
        $findIdTransaksiId = $this->transactionModel->where('transaction_code', $this->request->getPost('transaction_code'))->find();

        $this->transactionModel->update($findIdTransaksiId[0]['id'], [
            'status'    => 'Completed'
        ]);

        session()->setFlashdata('titleMessage', 'Success!');
        session()->setFlashdata('message', 'Payment is saved. The laundry status is changed to complete.');

        return redirect()->to(base_url() . 'transaction');
    }

    //untuk menampilkan halaman print invoice
    public function invoicePrint(string $transaction_code)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $modelPayment = new PaymentModel();
        $modelStore   = new StoreModel();

        $data = [
            'title' => 'Invoice#' . $transaction_code . '-' . $this->toko . '[Aptatola]',
            'toko'  => $this->toko,
            'store' => $modelStore->first(),
            'customer' => $modelPayment->getPaymentById($transaction_code)
        ];

        //tanggal transaksi dibuat
        $dibuat = Time::createFromFormat('Y-m-d H:i:s', $data['customer']['created_at']);
        //dari tanggal transaksi dibuat, maka jadwal pengambilan laundry sesuai package yang dipilih oleh customer
        $pengambilan = $dibuat->addDays($data['customer']['duration']);
        //format ulang tanggal
        $data['pengambilan'] = $pengambilan->format('Y-m-d H:i:s');

        return view('transaction/invoice-print.html', $data);
    }

    public function detail(string $transaction_code)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $modelPayment = new PaymentModel();

        $data = [
            'title' => 'Transaction Reports | Aptatola',
            'toko'  => $this->toko,
            'customer' => $modelPayment->getPaymentById($transaction_code)
        ];

        // jika belum pernah melakukan pembayaran maka ambil data transaksi saja
        if (empty($data['customer'])) {
            $data['customer'] = $this->transactionModel->getTransactionByTransactionCode($transaction_code);
        }

        //tanggal transaksi dibuat
        $dibuat = Time::createFromFormat('Y-m-d H:i:s', $data['customer']['created_at']);
        //dari tanggal transaksi dibuat, maka jadwal pengambilan laundry sesuai package yang dipilih oleh customer
        $pengambilan = $dibuat->addDays($data['customer']['duration']);
        //format ulang tanggal
        $data['pengambilan'] = $pengambilan->format('Y-m-d H:i:s');

        return view('transaction/detail', $data);
    }

    public function reports()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $data = [
            'title' => 'Transaction Reports | Aptatola',
            'toko'  => $this->toko,
            'transactions' => $this->transactionModel->getAllTransactionWithEmployee()
        ];

        return view('transaction/reports', $data);
    }

    public function getTransactionWithEmployeeData()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');

        if ($endDate) {
            $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
        }

        // Ambil semua data jika tanggal tidak disediakan
        if (empty($startDate) || empty($endDate)) {
            $results = $this->transactionModel->getAllTransactionWithEmployee();
        } else {
            $results = $this->transactionModel->getAllTransactionWithEmployeeByDate($startDate, $endDate);
        }

        // Lakukan loop melalui setiap transaksi
        foreach ($results as &$result) {
            //tanggal transaksi dibuat
            $dibuat = Time::createFromFormat('Y-m-d H:i:s', $result['created_at']);
            //dari tanggal transaksi dibuat, maka jadwal pengambilan laundry sesuai package yang dipilih oleh customer
            $pengambilan = $dibuat->addDays($result['duration']);
            //format ulang tanggal
            $result['pengambilan'] = $pengambilan->format('Y-m-d H:i:s');
        }

        return $this->response->setJSON(['data' => $results]);
    }

    // untuk menangani kirim invoice pertama transaksi pada bagian detail
    public function sendInvoiceFirst(string $transaction_code)
    {
        $modelStore = new StoreModel();
        $getStore = $modelStore->first();
        $getCustomer = $this->transactionModel->getTransactionByTransactionCode($transaction_code);

        $phoneNumber = $getCustomer['customer_whatsapp'];

        // Cek apakah nomor telepon dimulai dengan '0', jika iya, hapus '0' pertama
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        // Tambahkan kode negara '+62' di depan nomor telepon
        $phoneNumber = '+62' . $phoneNumber;

        // echo $phoneNumber; // Output: +6282200440055

        $formatTanggalMasuk = Time::createFromFormat('Y-m-d H:i:s', $getCustomer['created_at']);
        $masukLaundry = $formatTanggalMasuk->format('d-m-Y H:i:s');

        //tanggal transaksi dibuat
        $dibuat = Time::createFromFormat('Y-m-d H:i:s', $getCustomer['created_at']);
        //dari tanggal transaksi dibuat, maka jadwal pengambilan laundry sesuai package yang dipilih oleh customer
        $pengambilan = $dibuat->addDays($getCustomer['duration']);
        //format ulang tanggal
        $pengambilanLaundry = $pengambilan->format('d-m-Y H:i:s');

        $params = array(
            'token' => '5opmxaxgd16ovzgq',
            'to' => $phoneNumber,
            'body' => "
*===BUKTI TRANSAKSI===*
_*ini untuk pengambilan_
-------------------------------------
#" . $getStore['store_name'] . "
-------------------------------------

Nomer Invoice          : " . $getCustomer['transaction_code'] . "
Nama                        : " . $getCustomer['customer_name'] . "
Masuk Laundry         : " . $masukLaundry . "
Estimasi Selesai         : " . $pengambilanLaundry . "
Paket Laundry            : " . $getCustomer['package_name'] . "
Berat(Kg)                    : " . $getCustomer['weight'] . "
Harga(/Kg)                 : Rp. " . number_format($getCustomer['price'], 0, ',', '.') . "

-------------------------------------
Total Pembayaran  : Rp. " . number_format($getCustomer['total_payment'], 0, ',', '.') . "

*Harap tunjukkan pesan ini untuk mengambil laundrynya!*
Terima Kasih telah mempercaya jasa laundry kami."
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance86907/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function sendInvoice(string $transaction_code)
    {
        $modelStore = new StoreModel();
        $getStore = $modelStore->first();
        $getCustomer = $this->transactionModel->getTransactionByTransactionCode($transaction_code);

        $phoneNumber = $getCustomer['customer_whatsapp'];

        // Cek apakah nomor telepon dimulai dengan '0', jika iya, hapus '0' pertama
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        // Tambahkan kode negara '+62' di depan nomor telepon
        $phoneNumber = '+62' . $phoneNumber;

        // echo $phoneNumber; // Output: +6282200440055

        // dd($getCustomer, $getStore['store_name'], $transaction_code, $getCustomer['customer_name'], $getCustomer['package_name'], $getCustomer['employee_name'], $getCustomer['total_payment'], $getCustomer['package_name'], $getCustomer['pay_time'], $getCustomer['money_paid'], $getCustomer['money_paid'], $getCustomer['refund'], $getCustomer['payment_method'], $getCustomer['employee_name']);
        $formatTanggalBayar = Time::createFromFormat('Y-m-d H:i:s', $getCustomer['pay_time']);
        $payTime = $formatTanggalBayar->format('d-m-Y H:i:s');

        $params = array(
            'token' => '5opmxaxgd16ovzgq',
            'to' => $phoneNumber,
            'body' => "
*===BUKTI TRANSAKSI===*
-------------------------------------
#" . $getStore['store_name'] . "
-------------------------------------
            
Nomer Invoice          : " . $getCustomer['transaction_code'] . "
Status                        : Lunas
Nama                        : " . $getCustomer['customer_name'] . "
Waktu Pembayaran   : " . $payTime . "
Metode Pembayaran : " . $getCustomer['payment_method'] . "
Paket Laundry            : " . $getCustomer['package_name'] . "
Berat(Kg)                    : " . $getCustomer['weight'] . "
Harga(/Kg)                 : Rp. " . number_format($getCustomer['price'], 0, ',', '.') . "
Kasir                           : " . $getCustomer['employee_name'] . "

Total Pembayaran  : Rp. " . number_format($getCustomer['total_payment'], 0, ',', '.') . "
Dibayarkan            : Rp. " . number_format($getCustomer['money_paid'], 0, ',', '.') . "
-------------------------------------
Kembalian             : Rp. " . number_format($getCustomer['refund'], 0, ',', '.') . "
            
*Pesan ini sebagai bukti transaksi yang valid*
Terima Kasih telah mempercaya jasa laundry kami."
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance86907/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}

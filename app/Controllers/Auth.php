<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\StoreModel;
use Config\Services;

class Auth extends BaseController
{
    protected $authModel;
    protected string $toko;

    public function __construct()
    {
        $this->authModel = new AuthModel();
        $storeModel = new StoreModel();
        $toko = $storeModel->first();
        $this->toko = $toko['store_name'];
    }

    public function index()
    {
        if (session()->get('username') !== null) {
            return redirect()->to(base_url('/dashboard'));
        }

        $data = [
            'toko'  => $this->toko,
            'aplikasi' => 'Pengelolaan Transaksi Toko Laundry'
        ];

        return view('login/index', $data);
    }

    private function _rules(): array
    {
        return [
            'username' => [
                'rules'     => "required|min_length[5]",
                'errors'    => [
                    'required' => "Username cannot be empty",
                    'min_length' => "Ups!, username must be more than 5 characters"
                ]
            ],
            'password' => [
                'rules'     => "required|min_length[5]",
                'errors'    => [
                    'required' => "Password cannot be empty",
                    'min_length' => "Ups!, passsword must be more than 5 characters"
                ]
            ],
        ];
    }

    public function login()
    {
        $username   = $this->request->getPost('username');
        $password   = $this->request->getVar('password');

        $validation = Services::validation();

        $validation->setRules($this->_rules());

        if (!$validation->run($this->request->getPost())) {
            return redirect()->to(base_url())->with('errors', $validation->getErrors());
        }

        //ambil data berdasarkan username
        $cekUser = $this->authModel->get_data($username);

        // periksa apakah pengguna ditemukan
        if ($cekUser) {
            //jika ditemukan, selanjutnya periksa  apakah password yang dimasukkan cocok dengan hash yang disimpan dan apakah user statusnya active
            if ((password_verify($password, $cekUser['password'])) && ($cekUser['status'] == 'active')) {
                // password cocok,
                session()->set('username', $cekUser['username']);
                session()->set('email', $cekUser['email']);
                session()->set('fullname', $cekUser['fullname']);
                session()->set('role_id', $cekUser['user_role']);
                session()->set('photo', $cekUser['photo']);

                session()->setFlashdata('titleMessage', 'Good job!');
                session()->setFlashdata('message', 'Your session has started!');

                return redirect()->to(base_url('/dashboard'));
            } else {
                //password tidak cocok
                return redirect()->to(base_url())->with('messageFailed', 'Username or Password is wrong');
            }
        } else {
            // pengguna tidak ditemukan
            return redirect()->to(base_url())->with('messageFailed', 'Username or Password is wrong');
        }
    }

    public function logout()
    {
        session()->remove('username');
        session()->remove('email');
        session()->remove('fullname');
        session()->remove('role_id');
        session()->remove('photo');

        session()->setFlashdata('titleMessage', 'Log Out!');
        session()->setFlashdata('message', 'Your session has ended!');

        return redirect()->to(base_url());
    }
}

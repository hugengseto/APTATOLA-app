<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StoreModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Store extends BaseController
{
    protected string $toko;
    protected $storeModel;

    public function __construct()
    {
        $this->storeModel = new StoreModel();
        $nama_toko = $this->storeModel->first();
        $this->toko = $nama_toko['store_name'];
    }


    public function index()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $data = [
            'title'     => 'Store | Aptatola',
            'toko'      => $this->toko,
            'store'     => $this->storeModel->first()
        ];

        return view('store/index', $data);
    }

    private function _rules()
    {
        return [
            'store_name' => [
                'rules' => 'required'
            ],
            'store_address' => [
                'rules' => 'required'
            ],
            'store_telp' => [
                'rules' => 'required'
            ],
            'store_email' => [
                'rules' => 'required'
            ],
        ];
    }

    public function update()
    {
        $validation = Services::validation();
        $validation->setRules($this->_rules());

        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('titleMessage', 'Oops...');
            return redirect()->to(base_url() . 'store')->withInput()->with('message', 'Please fill in the form according to the applicable provisions. make sure there is no empty input.');
        }

        $data = [
            'store_name' => $this->request->getPost('store_name'),
            'store_address' => $this->request->getPost('store_address'),
            'store_telp' => $this->request->getPost('store_telp'),
            'store_email' => $this->request->getPost('store_email'),
        ];

        $getData = $this->storeModel->first();
        $id = $getData['store_id'];

        $this->storeModel->update($id, $data);

        session()->setFlashdata('titleMessage', 'Changed!');
        session()->setFlashdata('message', 'Store information updated.');

        return redirect()->to(base_url() . 'store');
    }
}

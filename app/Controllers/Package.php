<?php

namespace App\Controllers;

use App\Models\PackageModel;
use App\Models\StoreModel;
use Config\Services;

class Package extends BaseController
{
    protected string $toko;

    protected $modelPackage;

    public function __construct()
    {
        $this->modelPackage = new PackageModel();
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
            'title'     => 'Laundry Package | Aptatola',
            'toko'      => $this->toko,
            'packages'  => $this->modelPackage->findAll()
        ];

        return view('package/index', $data);
    }

    //menampilkan halaman tambah paket laundry baru
    public function create()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $data = [
            'title' => 'Add New Package | Aptatola',
            'toko'  => $this->toko,
        ];

        return view('package/create', $data);
    }

    private function _rules(?int $id = null): array
    {
        return [
            'name' => [
                'rules'  => "required|max_length[50]|is_unique[package.package_name, id, {$id}]",
                'errors' => [
                    'required' => 'You must enter the {field} of the laundry package',
                    'is_unique' => 'The package {field} already exists.'
                ],
            ],
            'description' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'You must enter a {field} of the laundry package'
                ],
            ],
            'price' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'You must enter the {field} of the laundry package'
                ],
            ],
            'duration' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required' => 'You must enter the {field} of the laundry package'
                ],
            ],
        ];
    }

    //untuk melakukan validasi sekaligus penyimpanan ke dalam database
    public function save()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $validation = Services::validation();
        $validation->setRules($this->_rules());


        //lakukan proses validasi form, jika gagal
        if (!$validation->run($this->request->getPost())) {
            return redirect()->to(base_url() . 'package/create')->withInput()->with('errors', $validation->getErrors());
        }


        //validasi sukses
        $this->modelPackage->save([
            'package_name'  => $this->request->getPost('name'),
            'description'   => $this->request->getPost('description'),
            'price'         => $this->request->getPost('price'),
            'duration'      => $this->request->getPost('duration')

        ]);

        session()->setFlashdata('titleMessage', 'Saved!');
        session()->setFlashdata('message', 'New data added successfully');

        return redirect()->to(base_url() . 'package');
    }

    //menghapus data packgae
    public function remove(int $id)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $this->modelPackage->delete($id);

        session()->setFlashdata('titleMessage', 'Deleted!');
        session()->setFlashdata('message', 'Package data has been deleted');

        return redirect()->to(base_url() . 'package');
    }

    //untuk melakukan edit data 
    public function edit(int $id)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $data = [
            'title'     => 'Edit Package | Aptatola',
            'toko'      => $this->toko,
            'package'   => $this->modelPackage->find($id)
        ];

        return view('package/edit', $data);
    }

    //untuk melakukan modifikasi atau edit data paket laundry
    public function update(int $id)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $validation = Services::validation();
        $validation->setRules($this->_rules($id));


        //lakukan proses validasi form, jika gagal
        if (!$validation->run($this->request->getPost())) {
            return redirect()->to(base_url() . 'package/edit/' . $id)->withInput()->with('errors', $validation->getErrors());
        }


        //validasi sukses
        $this->modelPackage->update($id, [
            'package_name'  => $this->request->getPost('name'),
            'description'   => $this->request->getPost('description'),
            'price'         => $this->request->getPost('price'),
            'duration'      => $this->request->getPost('duration')

        ]);

        session()->setFlashdata('titleMessage', 'Changed!');
        session()->setFlashdata('message', 'Data changed successfully');

        return redirect()->to(base_url() . 'package');
    }
}

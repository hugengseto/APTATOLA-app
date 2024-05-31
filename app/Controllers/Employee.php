<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\StoreModel;
use Config\Services;

class Employee extends BaseController
{
    protected string $toko;

    protected $modelEmployee;

    public function __construct()
    {
        $this->modelEmployee = new EmployeeModel();
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
            'title' => 'Employee | Aptatola',
            'toko'  => $this->toko,
            'employees' => $this->modelEmployee->findAll()
        ];

        return view('employee/index', $data);
    }

    public function create()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $data = [
            'title' => 'Added Employee | Aptatola',
            'toko'  => $this->toko,
        ];

        return view('employee/create', $data);
    }

    private function _rules(): array
    {
        return [
            'name' => [
                'rules'  => "required|max_length[50]",
                'errors' => [
                    'required' => 'You must enter the {field} of the laundry package'
                ],
            ],
            'wa' => [
                'rules'  => 'required|min_length[10]',
                'errors' => [
                    'required' => 'You must enter a {field} of the laundry package'
                ],
            ],
            'address' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'You must enter the {field} of the laundry package'
                ],
            ],
            'photo' => [
                'rules' => 'max_size[photo,1024]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size'  => 'file {field} size is too large',
                    'is_image'  => 'not the image you chose',
                    'mime_in'  => 'not the image you chose',
                ]
            ],
        ];
    }

    public function save()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }


        $validation = Services::validation();

        $validation->setRules($this->_rules());

        if (!$validation->run($this->request->getPost())) {
            return redirect()->to(base_url() . 'employee/create')->withInput()->with('errors', $validation->getErrors());
        }

        // get photo
        $photoFile = $this->request->getFile('photo');
        // cek the photo
        if ($photoFile->getError() == 4) {
            $photoName = 'default-photo.jpg';
        } else {
            // generate a random name file
            $photoName = $photoFile->getRandomName();

            $photoFile->move('photo', $photoName);
        }

        $this->modelEmployee->save([
            'name'      => $this->request->getPost('name'),
            'whatsapp'  => $this->request->getPost('wa'),
            'address'   => $this->request->getPost('address'),
            'photo'     => $photoName,
        ]);

        session()->setFlashdata('titleMessage', 'Saved!');
        session()->setFlashdata('message', 'New data added successfully');

        return redirect()->to(base_url() . 'employee');
    }

    //remove employee data
    public function remove(int $id)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        // get information photo
        $photo = $this->modelEmployee->find($id);
        // check photo
        if ($photo['photo'] != 'default-photo.jpg') {
            unlink('photo/' . $photo['photo']);
        }

        $this->modelEmployee->delete($id);

        session()->setFlashdata('titleMessage', 'Deleted!');
        session()->setFlashdata('message', 'Employee data has been deleted');

        return redirect()->to(base_url() . 'employee');
    }

    public function edit(int $id)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $data = [
            'title'     => 'Edit Employee | Aptatola',
            'toko'      => $this->toko,
            'employee'  => $this->modelEmployee->find($id)
        ];

        return view('/employee/edit', $data);
    }

    // action edit when user click save
    public function update(int $id)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $validation = Services::validation();
        $validation->setRules($this->_rules());

        if (!$validation->run($this->request->getPost())) {
            return redirect()->to(base_url() . 'employee/edit/' . $id)->withInput()->with('errors', $validation->getErrors());
        }

        // get photo
        $photoFile = $this->request->getFile('photo');
        $oldPhotoFile = $this->request->getPost('oldPhoto');
        // cek the photo
        if ($photoFile->getError() == 4) {
            $photoName = $oldPhotoFile;
        } else {
            // generate a random name file
            $photoName = $photoFile->getRandomName();

            $photoFile->move('photo', $photoName);

            // check default photo ?
            if ($oldPhotoFile != 'default-photo.jpg') {
                // cek apakah ada data foto lama
                $filePath = 'photo/' . $oldPhotoFile;
                if (file_exists($filePath)) {
                    //  ada filenya, maka hapus
                    unlink('photo/' . $oldPhotoFile);
                }
            }
        }

        $this->modelEmployee->update($id, [
            'name'      => $this->request->getPost('name'),
            'whatsapp'  => $this->request->getPost('wa'),
            'address'   => $this->request->getPost('address'),
            'photo'     => $photoName,
        ]);

        session()->setFlashdata('titleMessage', 'Updated!');
        session()->setFlashdata('message', 'Updated data employee successfully');

        return redirect()->to(base_url() . 'employee');
    }
}

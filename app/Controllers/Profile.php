<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuthModel;
use App\Models\StoreModel;
use Config\Services;

class Profile extends BaseController
{
    protected string $toko;
    protected $storeModel;
    protected $profileModel;

    public function __construct()
    {
        $this->storeModel = new StoreModel();
        $nama_toko = $this->storeModel->first();
        $this->toko = $nama_toko['store_name'];
        $this->profileModel = new AuthModel();
    }


    public function index()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $data = [
            'title'     => 'Store | Aptatola',
            'toko'      => $this->toko,
            'user'      => $this->profileModel->first(),
        ];

        return view('profile/index', $data);
    }

    private function _rules(): array
    {
        return [
            'username' => [
                'rules' => 'required'
            ],
            'fullname'  => [
                'rules' => 'required'
            ],
            'phone' => [
                'rules' => 'required'
            ],
            'email' => [
                'rules' => 'required'
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

    public function update()
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $validation = Services::validation();
        $validation->setRules($this->_rules());

        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('titleMessage', 'Oops...');
            // dd($validation->getErrors());
            return redirect()->to(base_url() . 'profile/information')->withInput()->with('message', 'Please fill in the form according to the applicable provisions. make sure there is no empty input.');
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

            $photoFile->move('profile', $photoName);

            // check default photo ?
            if ($oldPhotoFile != 'user2-160x160.jpg') {
                // cek apakah ada data foto lama
                $filePath = 'profile/' . $oldPhotoFile;
                if (file_exists($filePath)) {
                    //  ada filenya, maka hapus
                    unlink('profile/' . $oldPhotoFile);
                }
            }
        }

        $data = [
            'username'  => $this->request->getPost('username'),
            'fullname'  => $this->request->getPost('fullname'),
            'whatsapp'  => $this->request->getPost('phone'),
            'email'     => $this->request->getPost('email'),
            'photo'     => $photoName
        ];

        // ambil data pengguna
        $getData = $this->profileModel->first();
        $id = $getData['username'];

        $this->profileModel->update($id, $data);

        // ulangi ambil data terbaru pengguna dan melaukan set session
        $getData = $this->profileModel->where(['username' => $data['username']])->first();

        session()->set('username', $getData['username']);
        session()->set('email', $getData['email']);
        session()->set('fullname', $getData['fullname']);
        session()->set('role_id', $getData['user_role']);
        session()->set('photo', $getData['photo']);

        session()->setFlashdata('titleMessage', 'Changed!');
        session()->setFlashdata('message', 'Profile information updated.');

        return redirect()->to(base_url() . 'profile/information');
    }

    public function updatePassword(string $username)
    {
        if (session()->get('username') === null) {
            return redirect()->to(base_url())->with('messageFailed', 'You are not logged');
        }

        $validation = Services::validation();
        $validation->setRule('currentPassword', ' Current Password', 'required|min_length[5]');
        $validation->setRule('newPassword', 'New Password', 'required|min_length[5]');
        $validation->setRule('confirmPassword', 'Confirm New Password', 'required|min_length[5]');

        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata('icon', 'error');
            session()->setFlashdata('titleMessage', 'Oops...');
            return redirect()->to(base_url() . 'profile/information')->withInput()->with('message', 'Please fill in the form in accordance with the applicable provisions. make sure there are no empty fields & a minimum length of 5 characters.');
        }

        // ambil data pengguna
        $getData = $this->profileModel->where(['username' => $username])->first();

        $currentPassword = $this->request->getVar('currentPassword');
        $newPassword = $this->request->getVar('newPassword');
        $confirmPassword = $this->request->getVar('confirmPassword');

        if (password_verify($currentPassword, $getData['password'])) {
            // periksa password baru apakah sesuai dengan confirmasi password baru
            if ($newPassword != $confirmPassword) {
                session()->setFlashdata('icon', 'warning');
                session()->setFlashdata('titleMessage', 'Oops...');
                return redirect()->to(base_url() . 'profile/information')->withInput()->with('message', 'New password and confirmation of new password do not match.');
            } else {
                // sesuai dan proses pergantian passwordnya
                $this->profileModel->update($username, [
                    'password' => password_hash($newPassword, PASSWORD_DEFAULT)
                ]);

                session()->setFlashdata('titleMessage', 'Success!');
                return redirect()->to(base_url() . 'profile/information')->withInput()->with('message', 'Your password was successfully updated.');
            }
        } else {
            // jika tidak sesuai password saat ini yang dimasukkannya
            session()->setFlashdata('icon', 'warning');
            session()->setFlashdata('titleMessage', 'Oops...');
            return redirect()->to(base_url() . 'profile/information')->withInput()->with('message', 'The current password you entered is incorrect.');
        }
    }
}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    protected $user;

    function __construct() {
        $this->user = new \App\Models\UserModel();
    }

    function login() {
        if(self::isLoggedIn()) return redirect()->to('/dashboard')->with('error', 'Anda Sudah Login!');
        $title = getenv('PROJECT_NAME') . ' | Login';
        return view('auth/login', compact('title'));
    }

    function register() {
        if(self::isLoggedIn()) return redirect()->to('/dashboard')->with('error', 'Anda Sudah Login!');
        $title = getenv('PROJECT_NAME') . ' | Register';
        return view('auth/register', compact('title'));
    }

    function postRegister() {
        if(self::isLoggedIn()) return redirect()->to('/dashboard')->with('error', 'Anda Sudah Login!');
        $rules = [
            // 'nama' => 'required|max_length[50]|min_length[5]',
            // 'username' => 'required|max_length[25]|min_length[8]',
            // 'password' => 'required|max_length[25]|min_length[8]|matches[password_konfirmasi]',
            'role' => 'required',
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required|matches[password_konfirmasi]',
            'password_konfirmasi' => 'required'
        ];

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('errors', $validation);
            return redirect()->to('/register');
        }
        
        $validData = $this->validator->getValidated();

        unset($validData['password_konfirmasi']);

        if(!$this->user->register($validData)) {
            session()->setFlashdata('error', 'Username sudah terdaftar!');
            return redirect()->to('/register');
        }

        session()->setFlashdata('success', 'Berhasil Register, Silahkan Login.');
        return redirect()->to('/');
    }

    function postLogin() {
        if(self::isLoggedIn()) return redirect()->to('/dashboard')->with('error', 'Anda Sudah Login!');
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $data = $this->request->getPost(array_keys($rules));
        $validation = \Config\Services::validation();
        
        if(!$this->validateData($data, $rules)) {
            session()->setFlashdata('errors', $validation);
            return redirect()->to('/');
        }
        
        $validData = $this->validator->getValidated();

        $userdata = $this->user->login($validData);

        if(!$userdata) {
            session()->setFlashdata('error', 'Username / Password Tidak Ditemukan!');
            return redirect()->to('/');
        }

        session()->set('userdata', $userdata);

        return redirect()->to('/dashboard');
    }

    function logout() {
        if(!self::isLoggedIn()) return redirect()->to('/')->with('error', 'Anda Belum Login!');
        session()->destroy();
        return redirect()->to('/');
    }

    function isLoggedIn() {
        return session()->has('userdata');
    }
}

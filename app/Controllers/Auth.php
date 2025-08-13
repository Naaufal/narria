<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class Auth extends BaseController
{
    private function redirectRole()
    {
        $role = session()->get('role');
        
        if ($role == 'admin') {
            return redirect()->to('/admin/dashboard');
        } elseif ($role == 'author') {
            return redirect()->to('/author/dashboard');
        } else {
            return redirect()->to('/');
        }
    }

    public function login()
    {
        if (session()->get('isLoggedIn')){
            return $this->redirectRole();
        }
        return view('auth/login');
    }

    public function authLogin()
    {
        $session = session();
        $userModel = new userModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $userModel->where('email', $email)->first();

        if ($user) {
            log_message('debug', 'user found: ' . json_encode($user));
            if (password_verify($password, $user->password)){
                $displayName = !empty($user->display_name) ? $user->display_name : $user->username;
                
                $userData = [
                    'user_id' => $user->id,
                    'user_name' => $user->username,
                    'user_display_name' => $displayName,
                    'user_email' => $user->email,
                    'profile' => $user->profile,
                    'role' => $user->role,
                    'isLoggedIn' => TRUE
                ];

                $session->set($userData);

                return $this->redirectRole($user->role);
            } else {
                $session->setFlashdata('msg', 'Password Salah');    
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email tidak ada');
            return redirect()->to('/login');
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function authRegister()
    {
        $userModel = new userModel();

        // Validasi Input
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|alpha_numeric_punct|is_unique[users.username]|regex_match[/^[a-z0-9_.]+$/]',
            'display_name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]'
        ];

        $messages = [
            'username' => [
                'required' => 'Username wajib diisi.',
                'min_length' => 'Username minimal 3 karakter.',
                'max_length' => 'Username maksimal 50 karakter.',
                'alpha_numeric_punct' => 'Username hanya boleh mengandung huruf, angka, underscore, dan titik.',
                'is_unique' => 'Username sudah digunakan.',
                'regex_match' => 'Username hanya boleh mengandung huruf kecil, angka, underscore, dan titik.'
            ],
            'display_name' => [
                'required' => 'Nama tampilan wajib diisi.',
                'min_length' => 'Nama tampilan minimal 3 karakter.',
                'max_length' => 'Nama tampilan maksimal 100 karakter.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => strtolower($this->request->getVar('username')), // Convert to lowercase
            'display_name' => $this->request->getVar('display_name'),
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'), // password akan di-hash otomatis oleh model
            'role' => 'reader'
        ];

        $userModel->insert($data);

        return redirect()->to('/login')->with('success', 'Sekarang kamu bisa Login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}

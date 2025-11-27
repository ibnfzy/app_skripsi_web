<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        helper(['form', 'url']);

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'role' => 'required',
                'username' => 'required',
                'password' => 'required',
            ];

            if (! $this->validate($rules)) {
                return redirect()->back()->withInput()->with('error', 'Pastikan semua data terisi.');
            }

            $role = $this->request->getPost('role');
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel
                ->where('username', $username)
                ->where('role', $role)
                ->first();

            if (! $user || ! password_verify($password, $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'Kombinasi username, role, atau password salah.');
            }

            session()->set([
                'isLoggedIn' => true,
                'user'       => $user,
                'role'       => $user['role'],
                'username'   => $user['username'],
            ]);

            $redirectMap = [
                'Sekjur'            => '/Sekjur',
                'Kaprodi'           => '/Kaprodi',
                'Dosen Pembimbing'  => '/DosenPembimbing',
                'Mahasiswa'         => '/Mahasiswa',
            ];

            return redirect()->to($redirectMap[$role] ?? '/')->with('message', 'Login berhasil.');
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('message', 'Anda telah keluar dari sistem.');
    }
}

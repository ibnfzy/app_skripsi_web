<?php

namespace App\Controllers;

use App\Models\UserModel;

class AccountController extends BaseController
{
    public function update()
    {
        helper(['form', 'url']);

        $session = session();
        $currentUser = $session->get('user');

        if (! $session->get('isLoggedIn') || ! $currentUser) {
            return redirect()->to('/login')->with('error', 'Silakan masuk untuk mengubah pengaturan akun.');
        }

        $rules = [
            'username' => 'required|min_length[3]',
            'nama'     => 'required|min_length[3]',
            'password' => 'permit_empty|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Periksa kembali data yang diisi.')
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userId = $currentUser['id'];
        $username = $this->request->getPost('username');

        $existingUser = $userModel
            ->where('username', $username)
            ->where('id !=', $userId)
            ->first();

        if ($existingUser) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username sudah digunakan pengguna lain.');
        }

        $updateData = [
            'username' => $username,
            'nama'     => $this->request->getPost('nama'),
        ];

        $password = $this->request->getPost('password');
        if (! empty($password)) {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($userId, $updateData);

        $updatedUser = $userModel->find($userId);
        $session->set('user', $updatedUser);
        $session->set('username', $updatedUser['username']);
        $session->set('role', $updatedUser['role']);

        return redirect()->back()->with('message', 'Pengaturan akun berhasil diperbarui.');
    }
}

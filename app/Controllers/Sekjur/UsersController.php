<?php

namespace App\Controllers\Sekjur;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UsersController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = $this->userModel->findAll();
        return $this->response->setStatusCode(200)->setJSON($data);
    }

    public function show($id = null)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Data tidak ditemukan']);
        }
        return $this->response->setStatusCode(200)->setJSON($user);
    }

    public function create()
    {
        $payload = $this->request->getJSON(true) ?? $this->request->getPost();
        if (! isset($payload['username'], $payload['password'], $payload['nama'], $payload['role'])) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Field wajib: username, password, nama, role']);
        }

        $payload['password'] = password_hash($payload['password'], PASSWORD_DEFAULT);
        $payload['created_at'] = date('Y-m-d H:i:s');

        $id = $this->userModel->insert($payload, true);
        $created = $this->userModel->find($id);
        return $this->response->setStatusCode(201)->setJSON($created);
    }

    public function update($id = null)
    {
        $payload = $this->request->getJSON(true) ?? $this->request->getRawInput();
        if (isset($payload['password']) && $payload['password'] !== '') {
            $payload['password'] = password_hash($payload['password'], PASSWORD_DEFAULT);
        } else {
            unset($payload['password']);
        }
        $updated = $this->userModel->update($id, $payload);
        if (! $updated) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Gagal memperbarui data']);
        }
        return $this->response->setStatusCode(200)->setJSON($this->userModel->find($id));
    }

    public function delete($id = null)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Data tidak ditemukan']);
        }
        $this->userModel->delete($id);
        return $this->response->setStatusCode(200)->setJSON(['deleted' => true, 'id' => $id]);
    }
}
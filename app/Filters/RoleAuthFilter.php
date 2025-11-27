<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (! $session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login untuk melanjutkan.');
        }

        $role = $session->get('role');
        $segment = ucfirst($request->uri->getSegment(1));

        $roleMap = [
            'Sekjur'           => ['Sekjur'],
            'Kaprodi'          => ['Kaprodi'],
            'Dosenpembimbing'  => ['Dosen Pembimbing'],
            'Mahasiswa'        => ['Mahasiswa'],
        ];

        if (isset($roleMap[$segment]) && ! in_array($role, $roleMap[$segment], true)) {
            return redirect()->to('/login')->with('error', 'Anda tidak memiliki akses ke panel ini.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}

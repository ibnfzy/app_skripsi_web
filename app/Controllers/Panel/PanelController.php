<?php

namespace App\Controllers\Panel;

use App\Controllers\BaseController;

abstract class PanelController extends BaseController
{
    abstract protected function role(): string;

    abstract protected function menuItems(): array;

    abstract protected function accountSettingsPath(): string;

    protected function renderAccountSettings(): string
    {
        $data = [
            'role' => $this->role(),
            'menu' => $this->menuItems(),
            'activeMenu' => 'Pengaturan Akun',
            'user' => session()->get('user'),
            'formAction' => $this->accountSettingsPath(),
        ];

        return view('panel/account_settings', $data);
    }
}

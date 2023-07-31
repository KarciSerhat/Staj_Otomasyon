<?php

namespace App\Helpers\Permission;

class Permission {
    protected $permissions = [
        'formlar'=>'Form Ayarları',
        'roller' => 'Rol Ayarları',

    ];



    public function get_permissions() {
        return $this->permissions;
    }




}

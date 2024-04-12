<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Notario']);
        $role3 = Role::create(['name' => 'Gestor']);
        $role4 = Role::create(['name' => 'Dependencia']);
        $role5 = Role::create(['name' => 'AMPI']);
        $role6 = Role::create(['name' => 'Abogado']);


        Permission::create(['name' => 'Lista de roles', 'area' => 'Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear rol', 'area' => 'Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar rol', 'area' => 'Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar rol', 'area' => 'Roles'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de permisos', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear permiso', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar permiso', 'area' => 'Permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar permiso', 'area' => 'Permisos'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de usuarios', 'area' => 'Usuarios'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Crear usuario', 'area' => 'Usuarios'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Editar usuario', 'area' => 'Usuarios'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Borrar usuario', 'area' => 'Usuarios'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de entidades', 'area' => 'Entidades'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Crear entidad', 'area' => 'Entidades'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Editar entidad', 'area' => 'Entidades'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Borrar entidad', 'area' => 'Entidades'])->syncRoles([$role1]);

        Permission::create(['name' => 'Auditoria', 'area' => 'Auditoria'])->syncRoles([$role1]);

        Permission::create(['name' => 'Logs', 'area' => 'Logs'])->syncRoles([$role1]);

        Permission::create(['name' => 'Área de usuarios', 'area' => 'Usuarios'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Nuevo aviso', 'area' => 'Usuarios'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Avisos', 'area' => 'Usuarios'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Trámites', 'area' => 'Usuarios'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Trámite nuevo', 'area' => 'Usuarios'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Certificados', 'area' => 'Usuarios'])->syncRoles([$role1, $role2, $role3, $role4]);

    }
}

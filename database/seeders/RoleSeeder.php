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
        $role3 = Role::create(['name' => 'Notario adscrito']);
        $role4 = Role::create(['name' => 'Gestor']);
        $role5 = Role::create(['name' => 'Dependencia']);
        $role6 = Role::create(['name' => 'AMPI']);
        $role7 = Role::create(['name' => 'Abogado']);
        $role8 = Role::create(['name' => 'Sistemas']);
        $role9 = Role::create(['name' => 'Oficina central']);

        Permission::create(['name' => 'Área de administración', 'area' => 'Administración'])->syncRoles([$role1]);

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
        Permission::create(['name' => 'Reestablecer contraseña', 'area' => 'Usuarios'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de entidades', 'area' => 'Entidades'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Crear entidad', 'area' => 'Entidades'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Editar entidad', 'area' => 'Entidades'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'Borrar entidad', 'area' => 'Entidades'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de avisos', 'area' => 'Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'Ver aviso', 'area' => 'Roles'])->syncRoles([$role1]);

        Permission::create(['name' => 'Auditoria', 'area' => 'Auditoria'])->syncRoles([$role1]);

        Permission::create(['name' => 'Logs', 'area' => 'Logs'])->syncRoles([$role1]);

        Permission::create(['name' => 'Área de catastro', 'area' => 'Catastro'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Mis avisos', 'area' => 'Catastro'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Nuevo aviso', 'area' => 'Catastro'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Avisos', 'area' => 'Catastro'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Mis revisiones', 'area' => 'Catastro'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Nueva revisión', 'area' => 'Catastro'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Trámites catastro', 'area' => 'Catastro'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Trámite nuevo catastro', 'area' => 'Catastro'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Certificados catastro', 'area' => 'Catastro'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Observaciones', 'area' => 'Catastro'])->syncRoles([$role1, $role2, $role3, $role4]);

        Permission::create(['name' => 'Área de rpp', 'area' => 'RPP'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Trámites rpp', 'area' => 'RPP'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Trámite nuevo rpp', 'area' => 'RPP'])->syncRoles([$role1, $role2, $role3, $role4]);
        Permission::create(['name' => 'Certificados rpp', 'area' => 'RPP'])->syncRoles([$role1, $role2, $role3, $role4]);

        Permission::create(['name' => 'Usuarios notaria', 'area' => 'RPP'])->syncRoles([$role1, $role2,$role4]);

    }
}
